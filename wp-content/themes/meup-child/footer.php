<?php
/**
 * Child theme footer override
 *
 * Membuat footer bersih tanpa teks placeholder "COMING SOON" dan kredit lama
 * dari parent theme. Footer ini menggunakan data dinamis (tahun berjalan,
 * nama situs) dan menambahkan tautan penting untuk meningkatkan rasa percaya
 * pengunjung.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Data dinamis
$year      = date( 'Y' );
$site_name = get_bloginfo( 'name' );
$site_url  = esc_url( home_url( '/' ) );

?>
<footer id="colophon" class="site-footer" role="contentinfo" style="background:#0f172a;color:#cbd5e1;padding:32px 0;">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 16px;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;align-items:flex-start;">
        <div>
            <h2 style="margin:0 0 12px;font-size:18px;color:#e2e8f0;">Majelis.info</h2>
            <p style="margin:0 0 8px;line-height:1.6;">Platform acara kajian &amp; maulid – jadwal terpercaya dari panitia resmi.</p>
            <p style="margin:0;line-height:1.6;">Jl. Guru Mughni No.27F, Jakarta Selatan<br>Telepon/WA: <a href="tel:+628999150143" style="color:#fbbf24;text-decoration:none;">+62 899-9150-143</a><br>Email: <a href="mailto:halo@majelis.info" style="color:#fbbf24;text-decoration:none;">halo@majelis.info</a></p>
        </div>

        <div>
            <h3 style="margin:0 0 12px;font-size:16px;color:#e2e8f0;">Keamanan &amp; Transparansi</h3>
            <ul style="list-style:none;margin:0;padding:0;line-height:1.8;">
                <li><a href="<?php echo esc_url( home_url( '/transparansi-donasi/' ) ); ?>" style="color:#fbbf24;text-decoration:none;">Transparansi Donasi &amp; Tiket</a></li>
                <li><a href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>" style="color:#fbbf24;text-decoration:none;">Kontak / Redaksi</a></li>
                <li><a href="<?php echo esc_url( home_url( '/kebijakan-privasi/' ) ); ?>" style="color:#fbbf24;text-decoration:none;">Kebijakan Privasi</a></li>
            </ul>
        </div>

        <div>
            <h3 style="margin:0 0 12px;font-size:16px;color:#e2e8f0;">Ikuti &amp; Bagikan</h3>
            <ul style="list-style:none;margin:0;padding:0;line-height:1.8;">
                <li><a href="https://t.me/JadwalMajelis" style="color:#fbbf24;text-decoration:none;">Telegram @JadwalMajelis</a></li>
                <li><a href="<?php echo esc_url( home_url( '/links/' ) ); ?>" style="color:#fbbf24;text-decoration:none;">Link Hub Sosial</a></li>
                <li><a href="<?php echo esc_url( home_url( '/event/' ) ); ?>" style="color:#fbbf24;text-decoration:none;">Jadwal Kajian Terbaru</a></li>
            </ul>
        </div>
    </div>

    <div class="site-info" style="text-align:center;padding:16px 0 0;font-size:14px;color:#94a3b8;">
        &copy; <?php echo esc_html( $year ); ?> <a href="<?php echo $site_url; ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html( $site_name ); ?></a>. Semua hak dilindungi.
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
