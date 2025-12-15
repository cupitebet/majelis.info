<?php
/**
 * Template Name: Link Hub
 *
 * Template untuk menampilkan semua link penting Majelis.info
 */

get_header(); ?>

<div class="links-hub-page" style="max-width: 800px; margin: 0 auto; padding: 40px 20px; min-height: 100vh;">

    <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- Header / Profile -->
        <header class="entry-header" style="text-align: center; margin-bottom: 50px;">
            <div style="margin-bottom: 20px;">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/icon-192x192.png"
                     alt="<?php bloginfo( 'name' ); ?>"
                     style="width: 120px; height: 120px; border-radius: 50%; box-shadow: 0 4px 20px rgba(0,0,0,0.15); border: 5px solid white;"
                     onerror="this.style.display='none'">
            </div>
            <h1 class="entry-title" style="font-size: 2.2em; color: #1E3A8A; margin-bottom: 10px; font-weight: 700;">
                <?php bloginfo( 'name' ); ?>
            </h1>
            <p style="font-size: 1.15em; color: #64748b; line-height: 1.6; max-width: 600px; margin: 0 auto;">
                Platform Jadwal Kajian & Majelis Ilmu Terpercaya di Indonesia 🕌
            </p>
        </header>

        <div class="entry-content" style="line-height: 1.8;">

            <?php the_content(); ?>

            <!-- Main Website Link -->
            <div style="margin-bottom: 20px;">
                <a href="<?php echo home_url( '/' ); ?>"
                   style="display: block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 30px; border-radius: 16px; text-decoration: none; text-align: center; font-weight: 700; font-size: 1.1em; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); transition: transform 0.2s, box-shadow 0.2s;">
                    <div style="font-size: 1.5em; margin-bottom: 8px;">🌐</div>
                    <div>Kunjungi Website Utama</div>
                    <div style="font-size: 0.85em; opacity: 0.9; margin-top: 5px;">majelis.info</div>
                </a>
            </div>

            <!-- Social Media & Contact -->
            <div style="background: #f8fafc; padding: 25px; border-radius: 12px; margin-bottom: 20px;">
                <h2 style="color: #1E3A8A; font-size: 1.3em; margin-bottom: 20px; text-align: center;">
                    📱 Hubungi Kami
                </h2>
                <div style="display: flex; flex-direction: column; gap: 12px;">

                    <a href="https://wa.me/628999150143"
                       style="display: flex; align-items: center; background: white; padding: 18px 22px; border-radius: 12px; text-decoration: none; color: #334155; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; border-left: 4px solid #25d366;">
                        <span style="font-size: 1.8em; margin-right: 15px;">💬</span>
                        <div style="flex: 1;">
                            <div style="font-size: 1.05em;">WhatsApp Support</div>
                            <div style="font-size: 0.85em; color: #64748b; margin-top: 3px;">+62 899-9150-143</div>
                        </div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                    <a href="https://t.me/JadwalMajelis"
                       style="display: flex; align-items: center; background: white; padding: 18px 22px; border-radius: 12px; text-decoration: none; color: #334155; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; border-left: 4px solid #0088cc;">
                        <span style="font-size: 1.8em; margin-right: 15px;">📱</span>
                        <div style="flex: 1;">
                            <div style="font-size: 1.05em;">Channel Telegram</div>
                            <div style="font-size: 0.85em; color: #64748b; margin-top: 3px;">@JadwalMajelis</div>
                        </div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                    <a href="mailto:info@majelis.info"
                       style="display: flex; align-items: center; background: white; padding: 18px 22px; border-radius: 12px; text-decoration: none; color: #334155; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; border-left: 4px solid #667eea;">
                        <span style="font-size: 1.8em; margin-right: 15px;">✉️</span>
                        <div style="flex: 1;">
                            <div style="font-size: 1.05em;">Email</div>
                            <div style="font-size: 0.85em; color: #64748b; margin-top: 3px;">info@majelis.info</div>
                        </div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                </div>
            </div>

            <!-- Quick Access -->
            <div style="background: white; border: 2px solid #e2e8f0; padding: 25px; border-radius: 12px; margin-bottom: 20px;">
                <h2 style="color: #1E3A8A; font-size: 1.3em; margin-bottom: 20px; text-align: center;">
                    🔗 Akses Cepat
                </h2>
                <div style="display: flex; flex-direction: column; gap: 12px;">

                    <a href="<?php echo home_url( '/events/' ); ?>"
                       style="display: flex; align-items: center; background: #f8fafc; padding: 16px 20px; border-radius: 10px; text-decoration: none; color: #334155; font-weight: 600; transition: background 0.2s;">
                        <span style="font-size: 1.5em; margin-right: 12px;">📅</span>
                        <div style="flex: 1;">Jadwal Event Terbaru</div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                    <a href="<?php echo home_url( '/transparansi-donasi/' ); ?>"
                       style="display: flex; align-items: center; background: #f8fafc; padding: 16px 20px; border-radius: 10px; text-decoration: none; color: #334155; font-weight: 600; transition: background 0.2s;">
                        <span style="font-size: 1.5em; margin-right: 12px;">🔒</span>
                        <div style="flex: 1;">Transparansi Donasi & Tiket</div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                    <a href="<?php echo home_url( '/kontak/' ); ?>"
                       style="display: flex; align-items: center; background: #f8fafc; padding: 16px 20px; border-radius: 10px; text-decoration: none; color: #334155; font-weight: 600; transition: background 0.2s;">
                        <span style="font-size: 1.5em; margin-right: 12px;">📞</span>
                        <div style="flex: 1;">Kontak & Redaksi</div>
                        <span style="color: #94a3b8;">→</span>
                    </a>

                </div>
            </div>

            <!-- Submit Event -->
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #1E3A8A 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center;">
                <h2 style="color: white; font-size: 1.3em; margin-bottom: 15px;">
                    📝 Punya Event?
                </h2>
                <p style="opacity: 0.95; margin-bottom: 20px; line-height: 1.6;">
                    Publikasikan jadwal kajian atau majelis ilmu Anda di platform kami!
                </p>
                <a href="https://wa.me/628999150143?text=Halo,%20saya%20ingin%20submit%20event"
                   style="display: inline-block; background: white; color: #1E3A8A; padding: 14px 30px; border-radius: 50px; text-decoration: none; font-weight: 700; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    Submit Event Sekarang
                </a>
            </div>

            <!-- Cari Berdasarkan Kota (Optional - can be customized) -->
            <div style="background: #f8fafc; padding: 25px; border-radius: 12px; margin-bottom: 20px;">
                <h2 style="color: #1E3A8A; font-size: 1.3em; margin-bottom: 20px; text-align: center;">
                    🗺️ Cari Berdasarkan Kota
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px;">
                    <?php
                    // Popular cities - customize as needed
                    $cities = array(
                        'Jakarta' => '/location/jakarta/',
                        'Bandung' => '/location/bandung/',
                        'Surabaya' => '/location/surabaya/',
                        'Yogyakarta' => '/location/yogyakarta/',
                        'Semarang' => '/location/semarang/',
                        'Medan' => '/location/medan/',
                    );
                    foreach ( $cities as $city => $url ) :
                    ?>
                    <a href="<?php echo home_url( $url ); ?>"
                       style="background: white; padding: 12px; border-radius: 8px; text-align: center; text-decoration: none; color: #334155; font-weight: 600; font-size: 0.9em; box-shadow: 0 1px 4px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid #e2e8f0;">
                        <?php echo esc_html( $city ); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Partnership -->
            <div style="background: white; border: 2px dashed #cbd5e1; padding: 25px; border-radius: 12px; text-align: center; margin-bottom: 20px;">
                <div style="font-size: 2em; margin-bottom: 10px;">🤝</div>
                <h2 style="color: #334155; font-size: 1.2em; margin-bottom: 12px;">
                    Kerjasama & Partnership
                </h2>
                <p style="color: #64748b; margin-bottom: 20px; line-height: 1.6;">
                    Tertarik bermitra dengan Majelis.info? Hubungi tim kami!
                </p>
                <a href="mailto:info@majelis.info?subject=Proposal%20Kerjasama"
                   style="display: inline-block; background: #1E3A8A; color: white; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.2s;">
                    Kirim Proposal
                </a>
            </div>

            <!-- Footer Info -->
            <div style="text-align: center; padding: 30px 20px; color: #94a3b8; font-size: 0.9em;">
                <p style="margin-bottom: 10px;">
                    📍 Jl. Guru Mughni No.27F, Jakarta
                </p>
                <p style="margin-bottom: 15px;">
                    Platform Jadwal Kajian & Majelis Ilmu Terpercaya
                </p>
                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 20px;">
                    <a href="<?php echo home_url( '/transparansi-donasi/' ); ?>" style="color: #64748b; text-decoration: none; font-size: 0.85em;">Transparansi</a>
                    <a href="<?php echo home_url( '/kontak/' ); ?>" style="color: #64748b; text-decoration: none; font-size: 0.85em;">Kontak</a>
                    <a href="<?php echo home_url( '/privacy-policy/' ); ?>" style="color: #64748b; text-decoration: none; font-size: 0.85em;">Kebijakan Privasi</a>
                </div>
            </div>

        </div>

    </article>

    <?php endwhile; ?>

</div>

<style>
/* Hover effects */
.links-hub-page a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

@media (max-width: 600px) {
    .links-hub-page {
        padding: 30px 15px;
    }
    .entry-title {
        font-size: 1.8em !important;
    }
}
</style>

<?php get_footer(); ?>
