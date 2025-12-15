<?php
/**
 * Template Name: Transparansi Donasi & Tiket
 *
 * Template untuk menampilkan informasi transparansi donasi dan tiket event
 */

get_header(); ?>

<div class="transparansi-donasi-page" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">

    <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header" style="text-align: center; margin-bottom: 40px;">
            <h1 class="entry-title" style="font-size: 2.5em; color: #1E3A8A; margin-bottom: 10px;">
                <?php the_title(); ?>
            </h1>
            <p style="font-size: 1.1em; color: #64748b;">
                Komitmen Kami untuk Transparansi dan Kepercayaan
            </p>
        </header>

        <div class="entry-content" style="line-height: 1.8;">

            <?php the_content(); ?>

            <!-- Tentang Kami Section -->
            <section style="background: #f8fafc; padding: 30px; border-radius: 12px; margin: 30px 0;">
                <h2 style="color: #1E3A8A; margin-bottom: 20px;">
                    <span style="font-size: 1.5em;">ℹ️</span> Tentang Majelis.info
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <div>
                        <h3 style="color: #334155; font-size: 1.1em;">Pengelola Platform</h3>
                        <p style="color: #64748b;">
                            <strong>Majelis.info</strong> adalah platform agregator jadwal kajian dan majelis ilmu di Indonesia.
                            Kami menghubungkan jamaah dengan berbagai acara keislaman di seluruh nusantara.
                        </p>
                    </div>
                    <div>
                        <h3 style="color: #334155; font-size: 1.1em;">Kontak Resmi</h3>
                        <p style="color: #64748b; margin: 5px 0;">
                            📍 Alamat: Jl. Guru Mughni No.27F, Jakarta
                        </p>
                        <p style="color: #64748b; margin: 5px 0;">
                            📱 WhatsApp: <a href="https://wa.me/628999150143" style="color: #1E3A8A;">+62 899-9150-143</a>
                        </p>
                        <p style="color: #64748b; margin: 5px 0;">
                            ✉️ Email: <a href="mailto:info@majelis.info" style="color: #1E3A8A;">info@majelis.info</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sistem Donasi & Tiket -->
            <section style="margin: 40px 0;">
                <h2 style="color: #1E3A8A; margin-bottom: 20px;">
                    <span style="font-size: 1.5em;">💳</span> Sistem Donasi & Tiket
                </h2>

                <div style="background: white; border-left: 4px solid #3b82f6; padding: 20px; margin: 20px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="color: #334155; margin-top: 0;">Penting untuk Diketahui</h3>
                    <p style="color: #64748b;">
                        Majelis.info <strong>tidak mengelola dana donasi atau tiket secara langsung</strong>.
                        Setiap event yang ditampilkan di platform kami dikelola oleh penyelenggara masing-masing.
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-top: 30px;">

                    <div style="background: #fefce8; padding: 25px; border-radius: 10px; border: 2px solid #fde047;">
                        <h3 style="color: #854d0e; font-size: 1.2em; margin-bottom: 15px;">
                            📋 Alur Donasi/Tiket
                        </h3>
                        <ol style="color: #713f12; padding-left: 20px; line-height: 2;">
                            <li>Pilih event yang ingin Anda ikuti</li>
                            <li>Periksa detail rekening/metode pembayaran penyelenggara</li>
                            <li>Transfer langsung ke rekening penyelenggara</li>
                            <li>Simpan bukti transfer</li>
                            <li>Konfirmasi ke kontak penyelenggara yang tertera</li>
                        </ol>
                    </div>

                    <div style="background: #f0fdf4; padding: 25px; border-radius: 10px; border: 2px solid #86efac;">
                        <h3 style="color: #14532d; font-size: 1.2em; margin-bottom: 15px;">
                            ✅ Verifikasi Penyelenggara
                        </h3>
                        <p style="color: #166534; line-height: 1.8;">
                            Kami melakukan verifikasi dasar terhadap penyelenggara event melalui:
                        </p>
                        <ul style="color: #166534; padding-left: 20px; line-height: 2;">
                            <li>Validasi kontak dan lokasi</li>
                            <li>Pengecekan riwayat event sebelumnya</li>
                            <li>Konfirmasi identitas penyelenggara</li>
                            <li>Review feedback jamaah</li>
                        </ul>
                    </div>

                    <div style="background: #fef2f2; padding: 25px; border-radius: 10px; border: 2px solid #fca5a5;">
                        <h3 style="color: #7f1d1d; font-size: 1.2em; margin-bottom: 15px;">
                            ⚠️ Tips Aman Berdonasi
                        </h3>
                        <ul style="color: #991b1b; padding-left: 20px; line-height: 2;">
                            <li>Pastikan rekening atas nama penyelenggara/lembaga resmi</li>
                            <li>Simpan bukti transfer dengan baik</li>
                            <li>Konfirmasi ke nomor kontak resmi yang tertera</li>
                            <li>Hati-hati dengan penipuan yang mengatasnamakan event</li>
                            <li>Laporkan ke kami jika ada kecurigaan</li>
                        </ul>
                    </div>

                </div>
            </section>

            <!-- Pelaporan & Support -->
            <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; margin: 40px 0; text-align: center;">
                <h2 style="color: white; margin-bottom: 20px;">
                    📢 Butuh Bantuan atau Ingin Melaporkan Masalah?
                </h2>
                <p style="font-size: 1.1em; margin-bottom: 25px; opacity: 0.95;">
                    Kami berkomitmen untuk menjaga kepercayaan jamaah. Jika Anda menemukan hal yang mencurigakan atau butuh bantuan:
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://wa.me/628999150143"
                       style="background: white; color: #667eea; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.2s;">
                        📱 WhatsApp Support
                    </a>
                    <a href="mailto:info@majelis.info"
                       style="background: rgba(255,255,255,0.2); color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; border: 2px solid white; transition: transform 0.2s;">
                        ✉️ Email Kami
                    </a>
                </div>
            </section>

            <!-- FAQ -->
            <section style="margin: 40px 0;">
                <h2 style="color: #1E3A8A; margin-bottom: 25px; text-align: center;">
                    ❓ Pertanyaan yang Sering Diajukan
                </h2>

                <div style="max-width: 800px; margin: 0 auto;">

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 15px;">
                        <h3 style="color: #334155; font-size: 1.1em; margin-bottom: 10px;">
                            Apakah Majelis.info mengelola dana donasi?
                        </h3>
                        <p style="color: #64748b; margin: 0;">
                            Tidak. Kami hanya platform agregator. Semua transaksi donasi/tiket dilakukan langsung antara jamaah dan penyelenggara event.
                        </p>
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 15px;">
                        <h3 style="color: #334155; font-size: 1.1em; margin-bottom: 10px;">
                            Bagaimana jika saya merasa tertipu oleh penyelenggara?
                        </h3>
                        <p style="color: #64748b; margin: 0;">
                            Segera laporkan ke kami melalui WhatsApp atau email. Kami akan menindaklanjuti dengan penghapusan event dan blacklist penyelenggara yang terbukti menipu.
                        </p>
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 15px;">
                        <h3 style="color: #334155; font-size: 1.1em; margin-bottom: 10px;">
                            Apakah ada biaya untuk menggunakan platform Majelis.info?
                        </h3>
                        <p style="color: #64748b; margin: 0;">
                            Tidak. Platform kami 100% gratis untuk jamaah. Kami juga tidak mengambil komisi dari transaksi donasi atau tiket.
                        </p>
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 15px;">
                        <h3 style="color: #334155; font-size: 1.1em; margin-bottom: 10px;">
                            Bagaimana cara melaporkan event yang mencurigakan?
                        </h3>
                        <p style="color: #64748b; margin: 0;">
                            Hubungi kami melalui WhatsApp di <a href="https://wa.me/628999150143" style="color: #1E3A8A;">+62 899-9150-143</a> atau email ke <a href="mailto:info@majelis.info" style="color: #1E3A8A;">info@majelis.info</a> dengan menyertakan bukti atau informasi lengkap.
                        </p>
                    </div>

                </div>
            </section>

            <!-- Komitmen Kami -->
            <section style="background: #1E3A8A; color: white; padding: 40px; border-radius: 12px; margin: 40px 0;">
                <h2 style="color: white; text-align: center; margin-bottom: 30px;">
                    🤝 Komitmen Kami
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">

                    <div style="text-align: center;">
                        <div style="font-size: 3em; margin-bottom: 10px;">🔒</div>
                        <h3 style="font-size: 1.1em; margin-bottom: 10px;">Keamanan</h3>
                        <p style="opacity: 0.9; font-size: 0.95em;">
                            Verifikasi penyelenggara dan monitoring event secara berkala
                        </p>
                    </div>

                    <div style="text-align: center;">
                        <div style="font-size: 3em; margin-bottom: 10px;">👁️</div>
                        <h3 style="font-size: 1.1em; margin-bottom: 10px;">Transparansi</h3>
                        <p style="opacity: 0.9; font-size: 0.95em;">
                            Informasi jelas tentang siapa kami dan bagaimana sistem bekerja
                        </p>
                    </div>

                    <div style="text-align: center;">
                        <div style="font-size: 3em; margin-bottom: 10px;">⚡</div>
                        <h3 style="font-size: 1.1em; margin-bottom: 10px;">Responsif</h3>
                        <p style="opacity: 0.9; font-size: 0.95em;">
                            Tim support siap membantu dan menindaklanjuti laporan
                        </p>
                    </div>

                    <div style="text-align: center;">
                        <div style="font-size: 3em; margin-bottom: 10px;">💯</div>
                        <h3 style="font-size: 1.1em; margin-bottom: 10px;">Gratis</h3>
                        <p style="opacity: 0.9; font-size: 0.95em;">
                            Tanpa biaya tersembunyi, tanpa komisi dari transaksi
                        </p>
                    </div>

                </div>
            </section>

        </div>

    </article>

    <?php endwhile; ?>

</div>

<?php get_footer(); ?>
