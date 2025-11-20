<?php
/**
 * meup-child/functions.php
 *
 * Contoh minimal child theme functions untuk menghapus footer credit OvaTheme
 * dan menambahkan credit kustom yang aman.
 *
 * Cara pakai:
 * - Letakkan file ini di `wp-content/themes/meup-child/functions.php`
 * - Aktifkan `meup-child` sebagai child theme (WP-CLI atau via Dashboard)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Pastikan fungsi tidak didefinisikan dua kali
if ( ! function_exists( 'meup_child_setup_footer_overrides' ) ) {
    function meup_child_setup_footer_overrides() {
        // Jika parent theme menambahkan action 'ova_footer_credits', hapus handler default
        if ( has_action( 'ova_footer_credits' ) ) {
            // Nama callback default bisa berbeda per versi theme; coba hapus yang umum
            // Jika tidak ada efek, child theme akan menimpa hook di bawah dengan prioritas tinggi
            remove_action( 'ova_footer_credits', 'ova_footer_credits_default' );
            remove_action( 'ova_footer_credits', 'ova_footer_credit_output' );
        }

        // Tambahkan credit kustom (prioritas tinggi sehingga override)
        add_action( 'ova_footer_credits', 'meup_child_output_custom_credit', 99 );

        // Fallback: jika theme tidak menggunakan hook 'ova_footer_credits', injeksi via wp_footer
        add_action( 'wp_footer', 'meup_child_footer_fallback_inject', 100 );
    }
    add_action( 'after_setup_theme', 'meup_child_setup_footer_overrides', 20 );
}

if ( ! function_exists( 'meup_child_output_custom_credit' ) ) {
    function meup_child_output_custom_credit() {
        $year = date( 'Y' );
        $site_name = get_bloginfo( 'name' );
        // Gunakan esc_html/esc_url untuk keamanan output
        $site_url = esc_url( home_url( '/' ) );

        echo '<div class="meup-child-credit" style="text-align:center;padding:12px 0;font-size:14px;color:#bfc7d6;">';
        echo '&copy; ' . esc_html( $year ) . ' <a href="' . $site_url . '" style="color:inherit;text-decoration:none;">' . esc_html( $site_name ) . '</a> - Platform Acara Kajian &amp; Majelis Ilmu';
        echo '</div>';
    }
}

if ( ! function_exists( 'meup_child_footer_fallback_inject' ) ) {
    function meup_child_footer_fallback_inject() {
        // Jangan duplikasi jika hook 'ova_footer_credits' sudah ada dan berjalan
        if ( has_action( 'ova_footer_credits' ) ) {
            return;
        }

        // Jika footer already contains .meup-child-credit, jangan tambahkan lagi
        // (Minimal check via DOM not available here, so check option flag)
        static $injected = false;
        if ( $injected ) {
            return;
        }

        // Output kustom credit yang sama seperti di atas
        $year = date( 'Y' );
        $site_name = get_bloginfo( 'name' );
        $site_url = esc_url( home_url( '/' ) );

        echo '<div class="meup-child-credit" style="text-align:center;padding:12px 0;font-size:14px;color:#bfc7d6;">';
        echo '&copy; ' . esc_html( $year ) . ' <a href="' . $site_url . '" style="color:inherit;text-decoration:none;">' . esc_html( $site_name ) . '</a> - Platform Acara Kajian &amp; Majelis Ilmu';
        echo '</div>';

        $injected = true;
    }
}

// Optional: helper filter to remove plain text mentions via content filters (defensive)
if ( ! function_exists( 'meup_child_strip_ovatheme_mentions' ) ) {
    function meup_child_strip_ovatheme_mentions( $text ) {
        // Hapus tautan atau teks yang mengandung 'ovatheme' (kasar, case-insensitive)
        $text = preg_replace( '#<a[^>]+ovatheme[^>]*>.*?</a>#i', '', $text );
        $text = preg_replace( '/ovatheme/i', '', $text );
        return $text;
    }
    add_filter( 'the_content', 'meup_child_strip_ovatheme_mentions', 9999 );
}
