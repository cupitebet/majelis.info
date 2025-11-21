<?php
/**
 * Script untuk membersihkan metadata HANYA dari plugin yang tidak digunakan
 * Tidak menghapus metadata theme (ova_met_*)
 *
 * Cara menggunakan:
 * wp eval-file scripts/cleanup-metadata-plugins-only.php
 */

// Jika dijalankan via browser, pastikan user adalah admin
if ( ! defined( 'WP_CLI' ) ) {
    require_once( dirname(__FILE__) . '/../wp-load.php' );
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Anda tidak memiliki izin untuk mengakses halaman ini.' );
    }
}

/**
 * Daftar metadata HANYA dari plugin yang tidak digunakan
 * TIDAK termasuk ova_met_* agar custom theme settings tetap utuh
 */
$metadata_to_clean = array(
    'boomdevs_metabox',    // Plugin BoomDevs yang tidak digunakan
    'litespeed_vpi_list',  // Cache list LiteSpeed (auto-regenerate)
);

// Mode: 'dry-run' atau 'execute'
$mode = 'dry-run';

echo "=================================================\n";
echo "Cleanup Metadata Plugin (BoomDevs & LiteSpeed)\n";
echo "=================================================\n";
echo "Mode: " . strtoupper($mode) . "\n";
echo "Tanggal: " . date('Y-m-d H:i:s') . "\n";
echo "=================================================\n\n";

echo "ℹ️  Script ini HANYA menghapus metadata dari plugin.\n";
echo "   Metadata theme (ova_met_*) TIDAK akan dihapus.\n\n";

// Statistik
$stats = array(
    'total_posts_checked' => 0,
    'total_posts_cleaned' => 0,
    'total_metadata_removed' => 0,
    'metadata_counts' => array(),
);

foreach ($metadata_to_clean as $meta_key) {
    $stats['metadata_counts'][$meta_key] = 0;
}

// Query semua posts dan pages
$args = array(
    'post_type' => array('post', 'page', 'ova_events'),
    'post_status' => 'any',
    'posts_per_page' => -1,
    'fields' => 'ids',
);

$post_ids = get_posts($args);
$stats['total_posts_checked'] = count($post_ids);

echo "Total post/page yang akan diperiksa: " . $stats['total_posts_checked'] . "\n\n";

foreach ($post_ids as $post_id) {
    $cleaned_this_post = false;
    $post_title = get_the_title($post_id);
    $post_type = get_post_type($post_id);

    $found_metadata = false;
    foreach ($metadata_to_clean as $meta_key) {
        $meta_value = get_post_meta($post_id, $meta_key, true);
        if ($meta_value !== '' && $meta_value !== false) {
            $found_metadata = true;
            break;
        }
    }

    if (!$found_metadata) {
        continue;
    }

    echo "Memeriksa: [{$post_type}] {$post_title} (ID: {$post_id})\n";

    foreach ($metadata_to_clean as $meta_key) {
        $meta_value = get_post_meta($post_id, $meta_key, true);

        if ($meta_value !== '' && $meta_value !== false) {
            echo "  ✓ Ditemukan metadata: {$meta_key}\n";

            if (is_array($meta_value)) {
                echo "    Nilai: " . json_encode($meta_value) . "\n";
            } else {
                echo "    Nilai: " . substr($meta_value, 0, 100) . "\n";
            }

            if ($mode === 'execute') {
                $deleted = delete_post_meta($post_id, $meta_key);
                if ($deleted) {
                    echo "    [DIHAPUS]\n";
                    $stats['metadata_counts'][$meta_key]++;
                    $stats['total_metadata_removed']++;
                    $cleaned_this_post = true;
                } else {
                    echo "    [GAGAL DIHAPUS]\n";
                }
            } else {
                echo "    [AKAN DIHAPUS saat mode = execute]\n";
                $stats['metadata_counts'][$meta_key]++;
                $stats['total_metadata_removed']++;
                $cleaned_this_post = true;
            }
        }
    }

    if ($cleaned_this_post) {
        $stats['total_posts_cleaned']++;
    }

    echo "\n";
}

echo "=================================================\n";
echo "RINGKASAN PEMBERSIHAN\n";
echo "=================================================\n";
echo "Total post/page diperiksa: " . $stats['total_posts_checked'] . "\n";
echo "Total post/page dengan metadata plugin: " . $stats['total_posts_cleaned'] . "\n";
echo "Total metadata " . ($mode === 'execute' ? 'dihapus' : 'yang akan dihapus') . ": " . $stats['total_metadata_removed'] . "\n\n";

echo "Detail per metadata:\n";
foreach ($stats['metadata_counts'] as $meta_key => $count) {
    if ($count > 0) {
        echo "  - {$meta_key}: {$count} kali\n";
    }
}

echo "\n=================================================\n";

if ($mode === 'dry-run') {
    echo "⚠️  MODE DRY-RUN AKTIF\n";
    echo "Tidak ada metadata yang benar-benar dihapus.\n";
    echo "Untuk menjalankan penghapusan, ubah \$mode menjadi 'execute'\n";
} else {
    echo "✅ PEMBERSIHAN SELESAI\n";
    echo "Metadata plugin telah berhasil dihapus.\n";
    echo "Custom theme settings (ova_met_*) tetap utuh.\n";
}

echo "=================================================\n";

if ( ! defined( 'WP_CLI' ) ) {
    exit;
}
