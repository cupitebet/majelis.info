<?php
/**
 * Script cepat untuk memeriksa metadata apa saja yang ada di post/page
 * Tanpa melakukan perubahan apapun
 *
 * Cara menggunakan:
 * wp eval-file scripts/check-metadata.php
 */

// Load WordPress jika belum
if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
    require_once( dirname(__FILE__) . '/../wp-load.php' );
}

echo "=================================================\n";
echo "Pemeriksaan Metadata Custom di Post/Page\n";
echo "=================================================\n\n";

// Query semua posts dan pages
$args = array(
    'post_type' => array('post', 'page', 'ova_events'),
    'post_status' => 'any',
    'posts_per_page' => -1,
    'fields' => 'ids',
);

$post_ids = get_posts($args);
$all_meta_keys = array();

echo "Mengumpulkan metadata dari " . count($post_ids) . " post/page...\n\n";

// Kumpulkan semua meta keys
foreach ($post_ids as $post_id) {
    $meta = get_post_meta($post_id);
    foreach ($meta as $key => $value) {
        // Skip meta keys yang standard WordPress
        if (strpos($key, '_') !== 0) { // Skip yang diawali underscore (WordPress internal)
            if (!isset($all_meta_keys[$key])) {
                $all_meta_keys[$key] = 0;
            }
            $all_meta_keys[$key]++;
        }
    }
}

// Urutkan berdasarkan jumlah
arsort($all_meta_keys);

echo "Metadata Custom yang Ditemukan:\n";
echo "=================================================\n\n";

if (empty($all_meta_keys)) {
    echo "Tidak ada metadata custom ditemukan.\n";
} else {
    $no = 1;
    foreach ($all_meta_keys as $key => $count) {
        echo "{$no}. {$key}\n";
        echo "   Digunakan di: {$count} post/page\n";

        // Ambil contoh nilai
        foreach ($post_ids as $post_id) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                if (is_array($value)) {
                    echo "   Contoh nilai: " . json_encode($value) . "\n";
                } else {
                    echo "   Contoh nilai: " . substr($value, 0, 100) . (strlen($value) > 100 ? '...' : '') . "\n";
                }
                break;
            }
        }
        echo "\n";
        $no++;
    }
}

echo "=================================================\n";
echo "Total jenis metadata custom: " . count($all_meta_keys) . "\n";
echo "=================================================\n";
