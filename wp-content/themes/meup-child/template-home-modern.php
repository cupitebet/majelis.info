<?php
/**
 * Template Name: Home Modern (Goers-inspired)
 *
 * Modern homepage template inspired by professional event platforms
 * Features: Explore Feed, Categories, Featured Events, Testimonials
 */

get_header();
?>

<div class="modern-home-page" style="background: #f8fafc;">

    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 20px 60px; text-align: center;">
        <div style="max-width: 900px; margin: 0 auto;">
            <h1 style="font-size: 3em; font-weight: 800; margin-bottom: 20px; line-height: 1.2;">
                Temukan Kajian & Majelis Ilmu Terbaik
            </h1>
            <p style="font-size: 1.3em; opacity: 0.95; margin-bottom: 35px; line-height: 1.6;">
                Platform terpercaya untuk jadwal kajian, majelis ilmu, dan acara keislaman di seluruh Indonesia
            </p>

            <!-- Search Bar -->
            <div style="max-width: 600px; margin: 0 auto;">
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; gap: 10px; background: white; padding: 8px; border-radius: 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                    <input type="search" name="s" placeholder="Cari event, ustadz, atau lokasi..."
                           style="flex: 1; border: none; padding: 15px 25px; font-size: 1.05em; border-radius: 50px; outline: none;">
                    <button type="submit"
                            style="background: #1E3A8A; color: white; border: none; padding: 15px 35px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: transform 0.2s;">
                        🔍 Cari
                    </button>
                </form>
            </div>

            <!-- Quick Stats -->
            <div style="display: flex; gap: 40px; justify-content: center; margin-top: 50px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="font-size: 2.5em; font-weight: 800; margin-bottom: 5px;">
                        <?php
                        $event_count = wp_count_posts( 'mep_events' );
                        echo number_format( $event_count->publish );
                        ?>+
                    </div>
                    <div style="opacity: 0.9; font-size: 1.05em;">Event Tersedia</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5em; font-weight: 800; margin-bottom: 5px;">100%</div>
                    <div style="opacity: 0.9; font-size: 1.05em;">Gratis untuk Jamaah</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5em; font-weight: 800; margin-bottom: 5px;">24/7</div>
                    <div style="opacity: 0.9; font-size: 1.05em;">Akses Tanpa Batas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Categories -->
    <section class="event-categories" style="padding: 50px 20px; max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2em; color: #1E3A8A; margin-bottom: 10px;">Jelajahi Berdasarkan Kategori</h2>
            <p style="color: #64748b; font-size: 1.05em;">Temukan event sesuai minat Anda</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px;">
            <?php
            $categories = array(
                array( 'name' => 'Kajian Rutin', 'icon' => '📚', 'color' => '#3b82f6', 'slug' => 'kajian-rutin' ),
                array( 'name' => 'Majelis Ilmu', 'icon' => '🕌', 'color' => '#8b5cf6', 'slug' => 'majelis-ilmu' ),
                array( 'name' => 'Maulid Nabi', 'icon' => '🌙', 'color' => '#ec4899', 'slug' => 'maulid' ),
                array( 'name' => 'Seminar', 'icon' => '🎤', 'color' => '#f59e0b', 'slug' => 'seminar' ),
                array( 'name' => 'Workshop', 'icon' => '📝', 'color' => '#10b981', 'slug' => 'workshop' ),
                array( 'name' => 'Kelas Tahfidz', 'icon' => '📖', 'color' => '#6366f1', 'slug' => 'tahfidz' ),
            );

            foreach ( $categories as $cat ) :
            ?>
            <a href="<?php echo home_url( '/?category=' . $cat['slug'] ); ?>"
               style="background: white; padding: 30px 20px; border-radius: 16px; text-decoration: none; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 2px solid transparent; transition: all 0.3s;">
                <div style="font-size: 3em; margin-bottom: 10px;"><?php echo $cat['icon']; ?></div>
                <div style="color: #334155; font-weight: 700; font-size: 1.05em;"><?php echo $cat['name']; ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Explore Feed: Hari Ini, Besok, Minggu Ini -->
    <section class="explore-feed" style="padding: 50px 20px; background: white;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2em; color: #1E3A8A; margin-bottom: 10px;">Event Mendatang</h2>
                <p style="color: #64748b; font-size: 1.05em;">Jangan sampai terlewat!</p>
            </div>

            <!-- Time Filter Tabs -->
            <div class="event-tabs" style="display: flex; gap: 15px; justify-content: center; margin-bottom: 40px; flex-wrap: wrap;">
                <button class="event-tab active" data-tab="today"
                        style="background: #1E3A8A; color: white; border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                    🌟 Hari Ini
                </button>
                <button class="event-tab" data-tab="tomorrow"
                        style="background: white; color: #334155; border: 2px solid #e2e8f0; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                    📅 Besok
                </button>
                <button class="event-tab" data-tab="week"
                        style="background: white; color: #334155; border: 2px solid #e2e8f0; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                    📆 Minggu Ini
                </button>
                <button class="event-tab" data-tab="all"
                        style="background: white; color: #334155; border: 2px solid #e2e8f0; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                    📋 Semua Event
                </button>
            </div>

            <!-- Events Grid -->
            <div id="events-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
                <?php
                // Today's events
                $today_args = array(
                    'post_type'      => 'mep_events',
                    'post_status'    => 'publish',
                    'posts_per_page' => 6,
                    'meta_query'     => array(
                        array(
                            'key'     => 'event_start_datetime',
                            'value'   => array( date( 'Y-m-d 00:00:00' ), date( 'Y-m-d 23:59:59' ) ),
                            'compare' => 'BETWEEN',
                            'type'    => 'DATETIME',
                        ),
                    ),
                    'orderby' => 'meta_value',
                    'order'   => 'ASC',
                );

                $events = new WP_Query( $today_args );

                if ( $events->have_posts() ) :
                    while ( $events->have_posts() ) : $events->the_post();
                        $event_id = get_the_ID();
                        $event_start = get_post_meta( $event_id, 'event_start_datetime', true );
                        $location = get_post_meta( $event_id, 'mep_location', true );
                        $ticket_price = get_post_meta( $event_id, 'mep_ticket_price', true );

                        // Get average rating (if exists)
                        $rating = get_post_meta( $event_id, '_event_rating_average', true );
                        $rating_count = get_post_meta( $event_id, '_event_rating_count', true );
                ?>
                <article class="event-card" style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s, box-shadow 0.2s;">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div style="position: relative; height: 200px; overflow: hidden;">
                        <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
                        <?php if ( $ticket_price ) : ?>
                        <div style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.95); padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85em; color: #16a34a;">
                            <?php echo esc_html( $ticket_price ); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div style="padding: 20px;">
                        <h3 style="font-size: 1.2em; color: #1E3A8A; margin-bottom: 12px; line-height: 1.3;">
                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <?php if ( $event_start ) : ?>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; color: #64748b; font-size: 0.9em;">
                            <span>⏰</span>
                            <span><?php echo date_i18n( 'l, j M Y - H:i', strtotime( $event_start ) ); ?> WIB</span>
                        </div>
                        <?php endif; ?>

                        <?php if ( $location ) : ?>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; color: #64748b; font-size: 0.9em;">
                            <span>📍</span>
                            <span><?php echo wp_trim_words( $location, 8 ); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if ( $rating && $rating_count ) : ?>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                            <div style="display: flex; gap: 2px;">
                                <?php
                                $full_stars = floor( $rating );
                                for ( $i = 0; $i < 5; $i++ ) {
                                    echo $i < $full_stars ? '⭐' : '☆';
                                }
                                ?>
                            </div>
                            <span style="color: #64748b; font-size: 0.9em;">
                                <?php echo number_format( $rating, 1 ); ?> (<?php echo $rating_count; ?> review)
                            </span>
                        </div>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>"
                           style="display: block; background: #1E3A8A; color: white; text-align: center; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 700; transition: background 0.2s;">
                            Lihat Detail →
                        </a>
                    </div>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #94a3b8;">
                    <div style="font-size: 3em; margin-bottom: 15px;">📅</div>
                    <p style="font-size: 1.1em;">Belum ada event untuk hari ini.</p>
                    <p style="margin-top: 10px;">Coba filter lain atau <a href="<?php echo home_url( '/events/' ); ?>" style="color: #1E3A8A; font-weight: 600;">lihat semua event</a></p>
                </div>
                <?php endif; ?>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo home_url( '/events/' ); ?>"
                   style="display: inline-block; background: white; color: #1E3A8A; border: 2px solid #1E3A8A; padding: 14px 35px; border-radius: 50px; text-decoration: none; font-weight: 700; transition: all 0.2s;">
                    Lihat Semua Event →
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (Goers-inspired) -->
    <section class="testimonials-section" style="padding: 60px 20px; background: #f8fafc;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2em; color: #1E3A8A; margin-bottom: 10px;">Dipercaya oleh Penyelenggara Terbaik</h2>
                <p style="color: #64748b; font-size: 1.05em;">Apa kata mereka tentang Majelis.info</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">

                <!-- Testimonial 1 -->
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                    <div style="display: flex; gap: 4px; margin-bottom: 15px; font-size: 1.2em;">
                        ⭐⭐⭐⭐⭐
                    </div>
                    <p style="color: #334155; font-size: 1.05em; line-height: 1.7; margin-bottom: 20px;">
                        "Platform yang sangat memudahkan kami mempublikasikan jadwal kajian. Tim support Majelis.info sangat responsif dan membantu!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2em;">
                            P
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1E3A8A;">Panitia Majelis Al-Hikam</div>
                            <div style="color: #64748b; font-size: 0.9em;">Jakarta Selatan</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                    <div style="display: flex; gap: 4px; margin-bottom: 15px; font-size: 1.2em;">
                        ⭐⭐⭐⭐⭐
                    </div>
                    <p style="color: #334155; font-size: 1.05em; line-height: 1.7; margin-bottom: 20px;">
                        "Sejak menggunakan Majelis.info, jangkauan jamaah kami meningkat signifikan. Sistem yang mudah dan gratis!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2em;">
                            Y
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1E3A8A;">Yayasan Nurul Fikri</div>
                            <div style="color: #64748b; font-size: 0.9em;">Depok</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                    <div style="display: flex; gap: 4px; margin-bottom: 15px; font-size: 1.2em;">
                        ⭐⭐⭐⭐⭐
                    </div>
                    <p style="color: #334155; font-size: 1.05em; line-height: 1.7; margin-bottom: 20px;">
                        "Fitur kalender dan share sangat membantu jamaah kami. Event kami lebih terstruktur dan profesional!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2em;">
                            M
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1E3A8A;">Masjid Agung At-Taqwa</div>
                            <div style="color: #64748b; font-size: 0.9em;">Bekasi</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" style="padding: 80px 20px; background: linear-gradient(135deg, #1E3A8A 0%, #3b82f6 100%); color: white; text-align: center;">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 2.5em; font-weight: 800; margin-bottom: 20px;">
                Siap Publikasikan Event Anda?
            </h2>
            <p style="font-size: 1.2em; opacity: 0.95; margin-bottom: 35px; line-height: 1.7;">
                Bergabunglah dengan ratusan penyelenggara yang telah mempercayai Majelis.info untuk mempublikasikan jadwal kajian dan majelis ilmu mereka
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="https://wa.me/628999150143?text=Halo,%20saya%20ingin%20submit%20event"
                   style="background: white; color: #1E3A8A; padding: 18px 40px; border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.1em; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 6px 25px rgba(0,0,0,0.2); transition: transform 0.2s;">
                    📱 Submit Event Gratis
                </a>
                <a href="<?php echo home_url( '/kontak/' ); ?>"
                   style="background: rgba(255,255,255,0.15); color: white; padding: 18px 40px; border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.1em; display: inline-flex; align-items: center; gap: 10px; border: 2px solid white; transition: transform 0.2s;">
                    💬 Hubungi Kami
                </a>
            </div>
        </div>
    </section>

</div>

<style>
/* Hover Effects */
.modern-home-page .event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.modern-home-page .event-categories a:hover {
    border-color: #1E3A8A;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(30, 58, 138, 0.1);
}

.modern-home-page button:hover {
    transform: translateY(-2px);
}

.modern-home-page .event-tab.active {
    background: #1E3A8A !important;
    color: white !important;
    border-color: #1E3A8A !important;
}

.modern-home-page .cta-section a:hover {
    transform: translateY(-3px);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .modern-home-page .hero-section h1 {
        font-size: 2em !important;
    }
    .modern-home-page .hero-section p {
        font-size: 1.1em !important;
    }
    .modern-home-page .hero-section form {
        flex-direction: column;
        border-radius: 16px !important;
    }
    .modern-home-page .hero-section button {
        border-radius: 12px !important;
    }
}
</style>

<script>
// Tab switching for event filters
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.event-tab');
    const container = document.getElementById('events-container');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => {
                t.classList.remove('active');
                t.style.background = 'white';
                t.style.color = '#334155';
                t.style.borderColor = '#e2e8f0';
            });

            // Add active class to clicked tab
            this.classList.add('active');
            this.style.background = '#1E3A8A';
            this.style.color = 'white';
            this.style.borderColor = '#1E3A8A';

            // Get filter type
            const filter = this.dataset.tab;

            // Show loading
            container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #94a3b8;"><div style="font-size: 2em;">⏳</div><p>Memuat event...</p></div>';

            // Fetch events via AJAX (implement this in functions.php)
            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_events_by_time&filter=' + filter)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.html) {
                        container.innerHTML = data.html;
                    } else {
                        container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #94a3b8;"><div style="font-size: 3em; margin-bottom: 15px;">📅</div><p style="font-size: 1.1em;">Belum ada event untuk filter ini.</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});
</script>

<?php get_footer(); ?>
