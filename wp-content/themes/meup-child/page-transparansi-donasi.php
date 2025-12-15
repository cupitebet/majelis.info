<?php
/**
 * Template Name: Transparansi Donasi & Tiket
 * Description: Halaman statis untuk menjelaskan alur donasi/tiket dan akuntabilitas.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();
?>

<main id="primary" class="site-main" style="max-width:900px;margin:0 auto;padding:48px 20px 64px;">
    <header style="margin-bottom:24px;">
        <p style="text-transform:uppercase;font-weight:700;letter-spacing:0.08em;color:#0ea5e9;margin:0 0 8px;">Transparansi</p>
        <h1 style="margin:0 0 12px;font-size:32px;line-height:1.2;">Transparansi Donasi &amp; Tiket</h1>
        <p style="margin:0;color:#475569;">Standar keamanan penyaluran donasi dan pemesanan tiket di Majelis.info.</p>
    </header>

    <section style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,0.04);margin-bottom:20px;">
        <h2 style="margin-top:0;font-size:20px;color:#0f172a;">1) Siapa Pengelola?</h2>
        <p style="margin:0 0 12px;line-height:1.7;">Majelis.info dikelola oleh tim kurasi internal yang bekerja sama langsung dengan panitia resmi setiap acara. Semua nomor rekening dan tiket yang tampil di halaman event telah diverifikasi dengan surat atau kontak panitia.</p>
        <ul style="margin:0;padding-left:18px;line-height:1.7;color:#475569;">
            <li>Nama organisasi: <strong>Majelis.info</strong></li>
            <li>Alamat kantor: Jl. Guru Mughni No.27F, Jakarta Selatan</li>
            <li>Kontak verifikasi: <a href="mailto:halo@majelis.info">halo@majelis.info</a> / <a href="https://wa.me/628999150143" target="_blank" rel="noopener">WA +62 899-9150-143</a></li>
        </ul>
    </section>

    <section style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,0.04);margin-bottom:20px;">
        <h2 style="margin-top:0;font-size:20px;color:#0f172a;">2) Alur Penyaluran Donasi</h2>
        <ol style="margin:0;padding-left:18px;line-height:1.7;color:#475569;">
            <li>Penggalangan diumumkan di halaman event resmi.</li>
            <li>Donatur transfer ke rekening/QRIS yang tercantum atas nama panitia.</li>
            <li>Panitia mengirim bukti penerimaan ke tim Majelis.info.</li>
            <li>Rekap donasi dan bukti penyerahan dipublikasikan di bagian &ldquo;Laporan&rdquo; di halaman event atau arsip PDF.</li>
        </ol>
        <p style="margin:12px 0 0;color:#0f172a;font-weight:600;">Pertanyaan atau komplain? Kirim ke <a href="mailto:lapor@majelis.info">lapor@majelis.info</a>.</p>
    </section>

    <section style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,0.04);margin-bottom:20px;">
        <h2 style="margin-top:0;font-size:20px;color:#0f172a;">3) Pemesanan Tiket</h2>
        <ul style="margin:0;padding-left:18px;line-height:1.7;color:#475569;">
            <li>Pemesanan online hanya dibuka melalui tombol <strong>Daftar</strong>/<strong>Booking</strong> di halaman event.</li>
            <li>Jika tertulis &ldquo;Online booking closed&rdquo;, panitia hanya melayani <strong>loket onsite</strong> sesuai jam yang tertera.</li>
            <li>Tidak ada biaya tambahan di luar yang diumumkan di halaman event.</li>
        </ul>
        <p style="margin:12px 0 0;color:#0f172a;font-weight:600;">Butuh bantuan? Hubungi <a href="mailto:tiket@majelis.info">tiket@majelis.info</a> atau WA support di footer.</p>
    </section>

    <section style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,0.04);margin-bottom:20px;">
        <h2 style="margin-top:0;font-size:20px;color:#0f172a;">4) Laporan &amp; Bukti Serah</h2>
        <p style="margin:0 0 12px;line-height:1.7;">Setiap event donasi akan memiliki tautan laporan setelah penyerahan. Format laporan:</p>
        <ul style="margin:0;padding-left:18px;line-height:1.7;color:#475569;">
            <li>Total donasi diterima &amp; pengeluaran.</li>
            <li>Bukti transfer/penyerahan ke panitia (foto/scan).</li>
            <li>Kontak penanggung jawab panitia.</li>
        </ul>
        <p style="margin:12px 0 0;color:#0f172a;font-weight:600;">Laporan dapat diakses melalui tombol &ldquo;Laporan Donasi&rdquo; di halaman event yang relevan.</p>
    </section>

    <section style="background:#ecfeff;border:1px solid #bae6fd;border-radius:16px;padding:20px;box-shadow:0 10px 30px rgba(14,165,233,0.12);">
        <h2 style="margin-top:0;font-size:20px;color:#075985;">FAQ Singkat</h2>
        <dl style="margin:0;color:#075985;">
            <dt style="font-weight:700;">Apakah Majelis.info menahan dana?</dt>
            <dd style="margin:0 0 12px 0;">Tidak. Dana langsung masuk ke rekening panitia yang diverifikasi.</dd>

            <dt style="font-weight:700;">Bagaimana melaporkan penipuan?</dt>
            <dd style="margin:0 0 12px 0;">Segera email <a href="mailto:lapor@majelis.info">lapor@majelis.info</a> dengan bukti transfer, kami akan menandai event dan menghubungi panitia.</dd>

            <dt style="font-weight:700;">Bisakah meminta refund tiket?</dt>
            <dd style="margin:0;">Ikuti kebijakan yang tercantum di halaman event. Jika tidak ada, hubungi kontak panitia yang tertera.</dd>
        </dl>
    </section>
</main>

<?php
get_footer();
