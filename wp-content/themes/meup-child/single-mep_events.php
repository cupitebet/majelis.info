<?php
/**
 * Template for single event page (mep_events post type)
 *
 * Standardized event template with:
 * - Ringkasan event
 * - Lokasi + tombol peta
 * - Rundown/detail acara
 * - FAQ singkat
 * - CTA share & add to calendar
 */

get_header();

while ( have_posts() ) : the_post();
    $event_id = get_the_ID();

    // Get event meta data
    $event_start = get_post_meta( $event_id, 'event_start_datetime', true );
    $event_end   = get_post_meta( $event_id, 'event_end_datetime', true );
    $location    = get_post_meta( $event_id, 'mep_location', true );
    $location_name = get_post_meta( $event_id, 'mep_location_name', true );
    $event_lat   = get_post_meta( $event_id, 'mep_latitude', true );
    $event_lng   = get_post_meta( $event_id, 'mep_longitude', true );
    $organizer   = get_post_meta( $event_id, 'mep_organizer', true );
    $contact     = get_post_meta( $event_id, 'mep_contact', true );
    $ticket_price = get_post_meta( $event_id, 'mep_ticket_price', true );

    // Format dates
    $start_date = $event_start ? date_i18n( 'l, j F Y', strtotime( $event_start ) ) : '';
    $start_time = $event_start ? date_i18n( 'H:i', strtotime( $event_start ) ) : '';
    $end_time   = $event_end ? date_i18n( 'H:i', strtotime( $event_end ) ) : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-event-page' ); ?> style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <!-- Featured Image -->
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="event-featured-image" style="margin-bottom: 30px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
    </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">

        <!-- Main Content -->
        <div class="event-main-content">

            <!-- Title & Quick Info -->
            <header class="event-header" style="margin-bottom: 30px;">
                <h1 style="font-size: 2.5em; color: #1E3A8A; margin-bottom: 15px; line-height: 1.2;">
                    <?php the_title(); ?>
                </h1>

                <!-- Quick Info Pills -->
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                    <?php if ( $start_date ) : ?>
                    <span style="background: #dbeafe; color: #1e40af; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600;">
                        📅 <?php echo esc_html( $start_date ); ?>
                    </span>
                    <?php endif; ?>

                    <?php if ( $start_time ) : ?>
                    <span style="background: #fef3c7; color: #92400e; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600;">
                        ⏰ <?php echo esc_html( $start_time ); ?><?php echo $end_time ? ' - ' . esc_html( $end_time ) : ''; ?> WIB
                    </span>
                    <?php endif; ?>

                    <?php if ( $ticket_price ) : ?>
                    <span style="background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600;">
                        💵 <?php echo esc_html( $ticket_price ); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Ringkasan (Excerpt) -->
                <?php if ( has_excerpt() ) : ?>
                <div class="event-summary" style="background: #f8fafc; padding: 20px; border-left: 4px solid #3b82f6; border-radius: 8px; margin-bottom: 25px;">
                    <p style="font-size: 1.1em; color: #334155; line-height: 1.7; margin: 0;">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                </div>
                <?php endif; ?>
            </header>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 30px;">
                <a href="#" class="add-to-calendar-btn"
                   style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); transition: transform 0.2s;">
                    📅 Tambah ke Kalender
                </a>

                <a href="javascript:void(0)" onclick="navigator.share ? navigator.share({title: '<?php echo esc_js( get_the_title() ); ?>', url: '<?php echo esc_url( get_permalink() ); ?>'}) : alert('Share feature not supported')"
                   style="background: white; color: #334155; border: 2px solid #e2e8f0; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;">
                    🔗 Share Event
                </a>
            </div>

            <!-- Lokasi -->
            <?php if ( $location ) : ?>
            <section class="event-location" style="background: white; border: 2px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                <h2 style="color: #1E3A8A; font-size: 1.5em; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                    <span>📍</span> Lokasi Acara
                </h2>
                <p style="font-size: 1.1em; color: #334155; margin-bottom: 15px; line-height: 1.6;">
                    <strong><?php echo esc_html( $location_name ? $location_name : 'Lokasi Event' ); ?></strong><br>
                    <?php echo esc_html( $location ); ?>
                </p>
                <?php if ( $event_lat && $event_lng ) : ?>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode( $location ); ?>"
                       target="_blank" rel="noopener"
                       style="background: #1E3A8A; color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                        🗺️ Buka di Google Maps
                    </a>
                    <a href="https://www.waze.com/ul?ll=<?php echo esc_attr( $event_lat ); ?>,<?php echo esc_attr( $event_lng ); ?>&navigate=yes"
                       target="_blank" rel="noopener"
                       style="background: #00d8ff; color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                        🚗 Buka di Waze
                    </a>
                </div>
                <?php else : ?>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode( $location ); ?>"
                   target="_blank" rel="noopener"
                   style="background: #1E3A8A; color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    🗺️ Cari di Google Maps
                </a>
                <?php endif; ?>
            </section>
            <?php endif; ?>

            <!-- Detail Acara / Rundown -->
            <section class="event-content" style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h2 style="color: #1E3A8A; font-size: 1.5em; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>📋</span> Detail Acara
                </h2>
                <div class="entry-content" style="font-size: 1.05em; line-height: 1.8; color: #334155;">
                    <?php the_content(); ?>
                </div>
            </section>

            <!-- Penyelenggara & Kontak -->
            <?php if ( $organizer || $contact ) : ?>
            <section class="event-organizer" style="background: #f8fafc; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                <h2 style="color: #1E3A8A; font-size: 1.5em; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>👥</span> Penyelenggara & Kontak
                </h2>

                <?php if ( $organizer ) : ?>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #334155;">Penyelenggara:</strong>
                    <p style="color: #64748b; margin: 5px 0;"><?php echo esc_html( $organizer ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( $contact ) : ?>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #334155;">Kontak:</strong>
                    <p style="color: #64748b; margin: 5px 0;">
                        <?php
                        // Check if contact is WhatsApp number
                        $contact_clean = preg_replace( '/[^0-9]/', '', $contact );
                        if ( strlen( $contact_clean ) >= 10 ) :
                        ?>
                        <a href="https://wa.me/<?php echo esc_attr( $contact_clean ); ?>"
                           target="_blank" rel="noopener"
                           style="color: #25d366; font-weight: 600; text-decoration: none;">
                            💬 <?php echo esc_html( $contact ); ?> (WhatsApp)
                        </a>
                        <?php else : ?>
                        <?php echo esc_html( $contact ); ?>
                        <?php endif; ?>
                    </p>
                </div>
                <?php endif; ?>

                <!-- Transparansi Info -->
                <div style="background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-top: 20px;">
                    <p style="color: #92400e; font-size: 0.95em; margin: 0; line-height: 1.6;">
                        ⚠️ <strong>Info Penting:</strong> Majelis.info tidak mengelola donasi/tiket secara langsung.
                        Semua transaksi dilakukan dengan penyelenggara.
                        <a href="<?php echo home_url( '/transparansi-donasi/' ); ?>" style="color: #1E3A8A; font-weight: 600;">Pelajari lebih lanjut →</a>
                    </p>
                </div>
            </section>
            <?php endif; ?>

            <!-- FAQ Section -->
            <section class="event-faq" style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h2 style="color: #1E3A8A; font-size: 1.5em; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>❓</span> Pertanyaan Umum
                </h2>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px;">
                        <h3 style="color: #334155; font-size: 1.05em; margin-bottom: 8px;">Apakah acara ini gratis?</h3>
                        <p style="color: #64748b; margin: 0; line-height: 1.6;">
                            <?php echo $ticket_price ? 'Acara ini memiliki kontribusi: ' . esc_html( $ticket_price ) : 'Silakan hubungi penyelenggara untuk informasi lebih detail.'; ?>
                        </p>
                    </div>

                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px;">
                        <h3 style="color: #334155; font-size: 1.05em; margin-bottom: 8px;">Bagaimana cara mendaftar?</h3>
                        <p style="color: #64748b; margin: 0; line-height: 1.6;">
                            Hubungi penyelenggara melalui kontak yang tertera atau datang langsung ke lokasi acara.
                        </p>
                    </div>

                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px;">
                        <h3 style="color: #334155; font-size: 1.05em; margin-bottom: 8px;">Saya punya pertanyaan lain</h3>
                        <p style="color: #64748b; margin: 0; line-height: 1.6;">
                            Silakan hubungi penyelenggara atau tim Majelis.info di
                            <a href="https://wa.me/628999150143" style="color: #1E3A8A; font-weight: 600;">WhatsApp</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Share CTA -->
            <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 30px; border-radius: 16px; text-align: center; margin-bottom: 30px;">
                <h2 style="color: white; font-size: 1.8em; margin-bottom: 15px;">
                    📢 Sebarkan Kebaikan
                </h2>
                <p style="font-size: 1.1em; opacity: 0.95; margin-bottom: 25px;">
                    Bagikan event ini ke keluarga dan teman agar mereka juga bisa mendapatkan manfaat!
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>"
                       target="_blank"
                       style="background: #25d366; color: white; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                        💬 Share via WhatsApp
                    </a>
                    <a href="https://t.me/share/url?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>"
                       target="_blank"
                       style="background: #0088cc; color: white; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                        ✈️ Share via Telegram
                    </a>
                </div>
            </section>

        </div>

    </div>

</article>

<!-- Simple Add to Calendar Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCalBtn = document.querySelector('.add-to-calendar-btn');
    if (addToCalBtn) {
        addToCalBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Create iCal format
            const eventTitle = "<?php echo esc_js( get_the_title() ); ?>";
            const eventStart = "<?php echo $event_start ? date( 'Ymd\THis', strtotime( $event_start ) ) : ''; ?>";
            const eventEnd = "<?php echo $event_end ? date( 'Ymd\THis', strtotime( $event_end ) ) : ''; ?>";
            const eventLocation = "<?php echo esc_js( $location ); ?>";
            const eventUrl = "<?php echo esc_url( get_permalink() ); ?>";

            // For simplicity, redirect to Google Calendar
            const googleCalUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventStart}/${eventEnd}&details=${encodeURIComponent('Lihat detail: ' + eventUrl)}&location=${encodeURIComponent(eventLocation)}`;

            window.open(googleCalUrl, '_blank');
        });
    }
});
</script>

<style>
/* Responsive styles */
@media (max-width: 768px) {
    .single-event-page h1 {
        font-size: 1.8em !important;
    }
    .single-event-page .event-content,
    .single-event-page .event-location,
    .single-event-page .event-organizer {
        padding: 20px !important;
    }
}

/* Hover effects */
.single-event-page a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
</style>

<?php
endwhile;

get_footer();
?>
