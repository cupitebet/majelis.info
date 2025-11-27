#!/usr/bin/env php
<?php
/**
 * Process Automation Queue
 *
 * This script processes the automation queue and sends tasks to n8n
 * Run via cron: */5 * * * * php /path/to/scripts/process-automation-queue.php
 */

// Load WordPress
require_once dirname( __DIR__ ) . '/wp-load.php';

if ( ! defined( 'ABSPATH' ) ) {
    die( 'WordPress not loaded' );
}

echo "[" . date( 'Y-m-d H:i:s' ) . "] Processing automation queue...\n";

// Get automation queue
$queue = get_option( 'majelis_automation_queue', array() );

if ( empty( $queue ) ) {
    echo "Queue is empty\n";
    exit( 0 );
}

$processed = 0;
$failed = 0;
$new_queue = array();

foreach ( $queue as $index => $item ) {
    // Skip if already processing or completed
    if ( in_array( $item['status'], array( 'processing', 'completed' ), true ) ) {
        $new_queue[] = $item;
        continue;
    }

    // Process item
    echo "Processing item {$index}: {$item['type']}\n";

    $item['status'] = 'processing';
    $result = process_automation_item( $item );

    if ( $result['success'] ) {
        $item['status'] = 'completed';
        $item['completed_at'] = current_time( 'mysql' );
        $processed++;
        echo "  ✓ Completed\n";
    } else {
        $item['status'] = 'failed';
        $item['error'] = $result['error'];
        $item['failed_at'] = current_time( 'mysql' );
        $failed++;
        echo "  ✗ Failed: {$result['error']}\n";
    }

    $new_queue[] = $item;

    // Rate limiting: wait 1 second between items
    sleep( 1 );
}

// Update queue (keep only last 100 items)
$new_queue = array_slice( $new_queue, -100 );
update_option( 'majelis_automation_queue', $new_queue );

echo "\nProcessed: {$processed}, Failed: {$failed}\n";
echo "Queue size: " . count( $new_queue ) . "\n";

/**
 * Process automation item
 */
function process_automation_item( $item ) {
    $type = $item['type'];
    $data = $item['data'];

    // Get n8n webhook URL
    $webhook_url = get_option( 'majelis_n8n_webhook_url' );

    if ( ! $webhook_url ) {
        return array(
            'success' => false,
            'error'   => 'n8n webhook URL not configured',
        );
    }

    // Prepare payload
    $payload = array(
        'type'      => $type,
        'data'      => $data,
        'timestamp' => current_time( 'mysql' ),
    );

    // Send to n8n
    $response = wp_remote_post( $webhook_url, array(
        'method'  => 'POST',
        'timeout' => 30,
        'headers' => array(
            'Content-Type'         => 'application/json',
            'X-Majelis-Signature'  => generate_webhook_signature( wp_json_encode( $payload ) ),
        ),
        'body'    => wp_json_encode( $payload ),
    ));

    if ( is_wp_error( $response ) ) {
        return array(
            'success' => false,
            'error'   => $response->get_error_message(),
        );
    }

    $status_code = wp_remote_retrieve_response_code( $response );

    if ( $status_code !== 200 ) {
        $body = wp_remote_retrieve_body( $response );
        return array(
            'success' => false,
            'error'   => "HTTP {$status_code}: {$body}",
        );
    }

    return array(
        'success' => true,
        'response' => wp_remote_retrieve_body( $response ),
    );
}

/**
 * Generate webhook signature
 */
function generate_webhook_signature( $data ) {
    $secret = defined( 'MAJELIS_WEBHOOK_SECRET' ) ? MAJELIS_WEBHOOK_SECRET : get_option( 'majelis_webhook_secret' );

    if ( ! $secret ) {
        return '';
    }

    return hash_hmac( 'sha256', $data, $secret );
}
