<?php
/**
 * Template Name: Kontak & Redaksi
 *
 * Template untuk halaman kontak dan informasi redaksi
 */

get_header(); ?>

<div class="kontak-page" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">

    <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header" style="text-align: center; margin-bottom: 40px;">
            <h1 class="entry-title" style="font-size: 2.5em; color: #1E3A8A; margin-bottom: 10px;">
                <?php the_title(); ?>
            </h1>
            <p style="font-size: 1.1em; color: #64748b;">
                Hubungi Kami - Platform Jadwal Kajian & Majelis Ilmu Terpercaya
            </p>
        </header>

        <div class="entry-content" style="line-height: 1.8;">

            <?php the_content(); ?>

            <!-- Informasi Kontak Utama -->
            <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px 30px; border-radius: 16px; margin: 30px 0; text-align: center;">
                <div style="max-width: 800px; margin: 0 auto;">
                    <h2 style="color: white; font-size: 2em; margin-bottom: 30px;">
                        📞 Informasi Kontak
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 30px;">

                        <div>
                            <div style="font-size: 2.5em; margin-bottom: 15px;">📍</div>
                            <h3 style="color: white; font-size: 1.1em; margin-bottom: 10px;">Alamat</h3>
                            <p style="opacity: 0.95; font-size: 0.95em; line-height: 1.6;">
                                Jl. Guru Mughni No.27F<br>
                                Jakarta, Indonesia
                            </p>
                        </div>

                        <div>
                            <div style="font-size: 2.5em; margin-bottom: 15px;">📱</div>
                            <h3 style="color: white; font-size: 1.1em; margin-bottom: 10px;">WhatsApp</h3>
                            <p style="opacity: 0.95; font-size: 0.95em;">
                                <a href="https://wa.me/628999150143"
                                   style="color: white; text-decoration: none; font-weight: 600; font-size: 1.1em; display: inline-block; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 20px; margin-top: 5px;">
                                    +62 899-9150-143
                                </a>
                            </p>
                        </div>

                        <div>
                            <div style="font-size: 2.5em; margin-bottom: 15px;">✉️</div>
                            <h3 style="color: white; font-size: 1.1em; margin-bottom: 10px;">Email</h3>
                            <p style="opacity: 0.95; font-size: 0.95em;">
                                <a href="mailto:info@majelis.info"
                                   style="color: white; text-decoration: none; font-weight: 600; font-size: 1.1em; display: inline-block; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 20px; margin-top: 5px;">
                                    info@majelis.info
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <!-- Tentang Tim Redaksi -->
            <section style="margin: 50px 0;">
                <h2 style="color: #1E3A8A; text-align: center; margin-bottom: 20px; font-size: 2em;">
                    👥 Tentang Tim Redaksi
                </h2>
                <p style="text-align: center; color: #64748b; font-size: 1.1em; max-width: 700px; margin: 0 auto 40px;">
                    Tim kami berdedikasi untuk menyediakan informasi jadwal kajian dan majelis ilmu yang akurat dan terpercaya
                </p>

                <div style="background: #f8fafc; padding: 40px 30px; border-radius: 12px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">

                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 2.5em; margin-bottom: 15px;">📝</div>
                            <h3 style="color: #334155; font-size: 1.2em; margin-bottom: 12px;">Kurasi Konten</h3>
                            <p style="color: #64748b; line-height: 1.7;">
                                Kami melakukan verifikasi dan kurasi terhadap setiap event yang dipublikasikan untuk memastikan kualitas dan keakuratan informasi.
                            </p>
                        </div>

                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 2.5em; margin-bottom: 15px;">🔍</div>
                            <h3 style="color: #334155; font-size: 1.2em; margin-bottom: 12px;">Verifikasi</h3>
                            <p style="color: #64748b; line-height: 1.7;">
                                Setiap penyelenggara event diverifikasi identitasnya untuk memastikan kredibilitas dan mencegah penyalahgunaan platform.
                            </p>
                        </div>

                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 2.5em; margin-bottom: 15px;">💬</div>
                            <h3 style="color: #334155; font-size: 1.2em; margin-bottom: 12px;">Dukungan Jamaah</h3>
                            <p style="color: #64748b; line-height: 1.7;">
                                Tim support kami siap membantu pertanyaan, masukan, atau laporan terkait event yang ditampilkan di platform.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <!-- Hubungi Kami Untuk -->
            <section style="margin: 50px 0;">
                <h2 style="color: #1E3A8A; text-align: center; margin-bottom: 40px; font-size: 2em;">
                    💬 Hubungi Kami Untuk
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">

                    <div style="background: white; border-left: 4px solid #3b82f6; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #1E3A8A; font-size: 1.2em; margin-bottom: 15px;">
                            📅 Submit Event
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Ingin mempublikasikan jadwal kajian atau majelis ilmu Anda? Hubungi kami untuk proses verifikasi dan publikasi.
                        </p>
                        <a href="https://wa.me/628999150143?text=Halo,%20saya%20ingin%20submit%20event"
                           style="color: #3b82f6; font-weight: 600; text-decoration: none;">
                            Submit Event →
                        </a>
                    </div>

                    <div style="background: white; border-left: 4px solid #8b5cf6; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #7c3aed; font-size: 1.2em; margin-bottom: 15px;">
                            🤝 Kerjasama & Partnership
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Tertarik untuk bermitra dengan Majelis.info? Mari kita diskusikan peluang kolaborasi yang saling menguntungkan.
                        </p>
                        <a href="mailto:info@majelis.info?subject=Proposal%20Kerjasama"
                           style="color: #8b5cf6; font-weight: 600; text-decoration: none;">
                            Hubungi Partnership →
                        </a>
                    </div>

                    <div style="background: white; border-left: 4px solid #ec4899; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #db2777; font-size: 1.2em; margin-bottom: 15px;">
                            💡 Masukan & Saran
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Punya ide untuk meningkatkan platform kami? Kami sangat menghargai feedback dari Anda.
                        </p>
                        <a href="https://wa.me/628999150143?text=Halo,%20saya%20punya%20masukan"
                           style="color: #ec4899; font-weight: 600; text-decoration: none;">
                            Kirim Masukan →
                        </a>
                    </div>

                    <div style="background: white; border-left: 4px solid #f59e0b; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #d97706; font-size: 1.2em; margin-bottom: 15px;">
                            ⚠️ Laporan Masalah
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Menemukan event yang mencurigakan atau bermasalah? Laporkan segera kepada tim kami.
                        </p>
                        <a href="https://wa.me/628999150143?text=Halo,%20saya%20ingin%20melaporkan%20masalah"
                           style="color: #f59e0b; font-weight: 600; text-decoration: none;">
                            Laporkan Masalah →
                        </a>
                    </div>

                    <div style="background: white; border-left: 4px solid #10b981; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #059669; font-size: 1.2em; margin-bottom: 15px;">
                            🆘 Bantuan Teknis
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Mengalami kesulitan menggunakan platform? Tim support kami siap membantu Anda.
                        </p>
                        <a href="https://wa.me/628999150143?text=Halo,%20saya%20butuh%20bantuan"
                           style="color: #10b981; font-weight: 600; text-decoration: none;">
                            Minta Bantuan →
                        </a>
                    </div>

                    <div style="background: white; border-left: 4px solid #6366f1; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px;">
                        <h3 style="color: #4f46e5; font-size: 1.2em; margin-bottom: 15px;">
                            📰 Media & Pers
                        </h3>
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 15px;">
                            Pertanyaan media atau permintaan wawancara? Hubungi tim media relations kami.
                        </p>
                        <a href="mailto:info@majelis.info?subject=Media%20Inquiry"
                           style="color: #6366f1; font-weight: 600; text-decoration: none;">
                            Kontak Media →
                        </a>
                    </div>

                </div>
            </section>

            <!-- Jam Operasional -->
            <section style="background: #f8fafc; padding: 40px 30px; border-radius: 12px; margin: 40px 0;">
                <h2 style="color: #1E3A8A; text-align: center; margin-bottom: 30px; font-size: 1.8em;">
                    🕐 Jam Operasional Support
                </h2>
                <div style="max-width: 600px; margin: 0 auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="padding: 15px; text-align: center; background: #f1f5f9; border-radius: 8px;">
                            <div style="font-weight: 600; color: #334155; margin-bottom: 5px;">Senin - Jumat</div>
                            <div style="color: #1E3A8A; font-size: 1.2em; font-weight: 700;">09:00 - 17:00</div>
                        </div>
                        <div style="padding: 15px; text-align: center; background: #f1f5f9; border-radius: 8px;">
                            <div style="font-weight: 600; color: #334155; margin-bottom: 5px;">Sabtu - Minggu</div>
                            <div style="color: #64748b; font-size: 1.2em; font-weight: 700;">09:00 - 15:00</div>
                        </div>
                    </div>
                    <p style="text-align: center; color: #64748b; margin-top: 20px; font-size: 0.95em;">
                        ⚡ Untuk pelaporan urgent, kami akan merespons secepat mungkin di luar jam operasional
                    </p>
                </div>
            </section>

            <!-- Social Media & Connect -->
            <section style="margin: 50px 0;">
                <h2 style="color: #1E3A8A; text-align: center; margin-bottom: 30px; font-size: 2em;">
                    🌐 Terhubung Dengan Kami
                </h2>
                <p style="text-align: center; color: #64748b; margin-bottom: 30px;">
                    Ikuti kami di berbagai platform untuk update jadwal kajian terbaru
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://t.me/JadwalMajelis"
                       style="background: #0088cc; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;">
                        <span>📱</span> Telegram
                    </a>
                    <a href="https://wa.me/628999150143"
                       style="background: #25d366; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;">
                        <span>💬</span> WhatsApp
                    </a>
                    <a href="mailto:info@majelis.info"
                       style="background: #667eea; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;">
                        <span>✉️</span> Email
                    </a>
                </div>
            </section>

            <!-- CTA Box -->
            <section style="background: linear-gradient(135deg, #1E3A8A 0%, #3b82f6 100%); color: white; padding: 50px 30px; border-radius: 16px; text-align: center; margin: 40px 0;">
                <h2 style="color: white; font-size: 1.8em; margin-bottom: 20px;">
                    📮 Siap Menghubungi Kami?
                </h2>
                <p style="font-size: 1.1em; opacity: 0.95; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                    Tim kami siap membantu Anda. Pilih metode kontak yang paling nyaman untuk Anda.
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://wa.me/628999150143"
                       style="background: white; color: #1E3A8A; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 1.1em; display: inline-block; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        📱 Chat WhatsApp
                    </a>
                    <a href="mailto:info@majelis.info"
                       style="background: rgba(255,255,255,0.2); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 1.1em; display: inline-block; border: 2px solid white; transition: transform 0.2s;">
                        ✉️ Kirim Email
                    </a>
                </div>
            </section>

        </div>

    </article>

    <?php endwhile; ?>

</div>

<?php get_footer(); ?>
