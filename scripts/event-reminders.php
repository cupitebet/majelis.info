#!/usr/bin/env php
<?php
/**
 * Send Event Reminders
 *
 * Find upcoming events and send reminder notifications
 * Run daily: 0 9 * * * php /path/to/scripts/event-reminders.php
 */

// Load WordPress
require_once dirname( __DIR__ ) . '/wp-load.php';

if ( ! defined( 'ABSPATH' ) ) {
    die( 'WordPress not loaded' );
}

echo "[" . date( 'Y-m-d H:i:s' ) . "] Checking for upcoming events...\n";

// Find events happening in the next 24 hours
$args = array(
    'post_type'      => 'mep_events',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'event_start_datetime',
            'value'   => array(
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s', strtotime( '+24 hours' ) ),
            ),
            'compare' => 'BETWEEN',
            'type'    => 'DATETIME',
        ),
    ),
);

$events = get_posts( $args );

if ( empty( $events ) ) {
    echo "No upcoming events found\n";
    exit( 0 );
}

echo "Found " . count( $events ) . " upcoming events\n";

foreach ( $events as $event ) {
    echo "\nProcessing: {$event->post_title}\n";

    // Get event date
    $event_date = get_post_meta( $event->ID, 'event_start_datetime', true );
    $hours_until = ( strtotime( $event_date ) - time() ) / 3600;

    echo "  Event starts in " . round( $hours_until, 1 ) . " hours\n";

    // Check if reminder already sent
    $reminder_sent = get_post_meta( $event->ID, '_reminder_sent_24h', true );

    if ( $reminder_sent ) {
        echo "  Reminder already sent, skipping\n";
        continue;
    }

    // Get attendees (this depends on your booking system)
    $attendees = get_event_attendees( $event->ID );

    echo "  Found " . count( $attendees ) . " attendees\n";

    // Send to n8n for processing
    $webhook_url = get_option( 'majelis_n8n_webhook_url' );

    if ( $webhook_url ) {
        $payload = array(
            'action'     => 'send_event_reminder',
            'event_id'   => $event->ID,
            'event_title' => $event->post_title,
            'event_date' => $event_date,
            'event_url'  => get_permalink( $event->ID ),
            'attendees'  => $attendees,
        );

        $response = wp_remote_post( $webhook_url, array(
            'method'  => 'POST',
            'timeout' => 10,
            'headers' => array( 'Content-Type' => 'application/json' ),
            'body'    => wp_json_encode( $payload ),
        ));

        if ( ! is_wp_error( $response ) ) {
            // Mark reminder as sent
            update_post_meta( $event->ID, '_reminder_sent_24h', current_time( 'mysql' ) );
            echo "  ✓ Reminder sent\n";
        } else {
            echo "  ✗ Failed: " . $response->get_error_message() . "\n";
        }
    }

    // Rate limiting
    sleep( 2 );
}

echo "\nDone!\n";

/**
 * Get event attendees
 * (Customize based on your booking system)
 */
function get_event_attendees( $event_id ) {
    // Example implementation
    // This should be customized based on your actual booking/ticketing system

    global $wpdb;

    // If using WooCommerce + Events plugin
    $attendees = array();

    // Example query (customize as needed)
    // $results = $wpdb->get_results( $wpdb->prepare(
    //     "SELECT DISTINCT meta_value as email
    //      FROM {$wpdb->prefix}postmeta
    //      WHERE post_id IN (
    //          SELECT post_id FROM {$wpdb->prefix}postmeta
    //          WHERE meta_key = '_event_id' AND meta_value = %d
    //      ) AND meta_key = '_billing_email'",
    //     $event_id
    // ) );

    // foreach ( $results as $row ) {
    //     $attendees[] = array(
    //         'email' => $row->email,
    //     );
    // }

    return $attendees;
}
