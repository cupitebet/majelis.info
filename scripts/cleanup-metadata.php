<?php
/**
 * Script untuk membersihkan metadata yang tidak diperlukan dari post/page
 * Metadata ini biasanya ditambahkan oleh workflow n8n atau plugin yang sudah tidak digunakan
 *
 * Cara menggunakan:
 * wp-cli: wp eval-file scripts/cleanup-metadata.php
 * atau upload ke WordPress dan akses via browser (harus login sebagai admin)
 */

// Jika dijalankan via browser, pastikan user adalah admin
if ( ! defined( 'WP_CLI' ) ) {
    // Load WordPress
    require_once( dirname(__FILE__) . '/../wp-load.php' );

    // Cek apakah user adalah admin
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Anda tidak memiliki izin untuk mengakses halaman ini.' );
    }
}

/**
 * Daftar metadata yang akan dibersihkan
 * Metadata ini aman untuk dihapus karena:
 * - boomdevs_metabox: dari plugin BoomDevs yang mungkin tidak digunakan lagi
 * - litespeed_vpi_list: cache image list, akan di-regenerate otomatis oleh LiteSpeed
 * - ova_met_*: pengaturan theme yang override default, menghapus akan gunakan setting default theme
 */
$metadata_to_clean = array(
    'boomdevs_metabox',
    'litespeed_vpi_list',
    'ova_met_footer_version',
    'ova_met_header_version',
    'ova_met_main_layout',
    'ova_met_page_heading',
    'ova_met_width_site',
);

// Mode: 'dry-run' untuk melihat apa yang akan dihapus tanpa benar-benar menghapus
// Ubah ke 'execute' untuk benar-benar menghapus
$mode = 'dry-run'; // Ganti dengan 'execute' untuk menjalankan penghapusan

echo "=================================================\n";
echo "Cleanup Metadata dari Post/Page\n";
echo "=================================================\n";
echo "Mode: " . strtoupper($mode) . "\n";
echo "Tanggal: " . date('Y-m-d H:i:s') . "\n";
echo "=================================================\n\n";

// Statistik
$stats = array(
    'total_posts_checked' => 0,
    'total_posts_cleaned' => 0,
    'total_metadata_removed' => 0,
    'metadata_counts' => array(),
);

// Inisialisasi counter untuk setiap metadata
foreach ($metadata_to_clean as $meta_key) {
    $stats['metadata_counts'][$meta_key] = 0;
}

// Query semua posts dan pages
$args = array(
    'post_type' => array('post', 'page', 'ova_events'), // Tambahkan post type lain jika perlu
    'post_status' => 'any',
    'posts_per_page' => -1,
    'fields' => 'ids',
);

$post_ids = get_posts($args);
$stats['total_posts_checked'] = count($post_ids);

echo "Total post/page yang akan diperiksa: " . $stats['total_posts_checked'] . "\n\n";

// Loop untuk setiap post
foreach ($post_ids as $post_id) {
    $cleaned_this_post = false;
    $post_title = get_the_title($post_id);
    $post_type = get_post_type($post_id);

    echo "Memeriksa: [{$post_type}] {$post_title} (ID: {$post_id})\n";

    // Periksa setiap metadata
    foreach ($metadata_to_clean as $meta_key) {
        $meta_value = get_post_meta($post_id, $meta_key, true);

        if ($meta_value !== '' && $meta_value !== false) {
            echo "  ✓ Ditemukan metadata: {$meta_key}\n";

            // Tampilkan nilai metadata
            if (is_array($meta_value)) {
                echo "    Nilai: " . json_encode($meta_value) . "\n";
            } else {
                echo "    Nilai: " . $meta_value . "\n";
            }

            // Hapus metadata jika mode = execute
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
    } else {
        echo "  - Tidak ada metadata yang perlu dibersihkan\n";
    }

    echo "\n";
}

// Tampilkan ringkasan
echo "=================================================\n";
echo "RINGKASAN PEMBERSIHAN\n";
echo "=================================================\n";
echo "Total post/page diperiksa: " . $stats['total_posts_checked'] . "\n";
echo "Total post/page dengan metadata: " . $stats['total_posts_cleaned'] . "\n";
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
    echo "di baris 34 dalam file ini.\n";
} else {
    echo "✅ PEMBERSIHAN SELESAI\n";
    echo "Metadata telah berhasil dihapus dari database.\n";
}

echo "=================================================\n";

// Jika dijalankan via browser, keluar setelah selesai
if ( ! defined( 'WP_CLI' ) ) {
    exit;
}
