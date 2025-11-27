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

/**
 * ========================================
 * PWA (Progressive Web App) Implementation
 * ========================================
 */

/**
 * Add PWA manifest and meta tags to header
 */
if ( ! function_exists( 'majelis_pwa_add_manifest' ) ) {
    function majelis_pwa_add_manifest() {
        $manifest_url = home_url( '/manifest.json' );
        $theme_color = '#1E3A8A';

        echo "\n<!-- PWA Meta Tags -->\n";
        echo '<link rel="manifest" href="' . esc_url( $manifest_url ) . '">' . "\n";
        echo '<meta name="theme-color" content="' . esc_attr( $theme_color ) . '">' . "\n";
        echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";

        // iOS app icons
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/assets/icons/icon-192x192.png">' . "\n";

        // MS Tile
        echo '<meta name="msapplication-TileColor" content="' . esc_attr( $theme_color ) . '">' . "\n";
        echo '<meta name="msapplication-TileImage" content="' . get_stylesheet_directory_uri() . '/assets/icons/icon-144x144.png">' . "\n";

        echo "<!-- End PWA Meta Tags -->\n\n";
    }
    add_action( 'wp_head', 'majelis_pwa_add_manifest', 1 );
}

/**
 * Register and enqueue service worker
 */
if ( ! function_exists( 'majelis_pwa_register_service_worker' ) ) {
    function majelis_pwa_register_service_worker() {
        $sw_url = home_url( '/sw.js' );
        ?>

<!-- PWA Service Worker Registration -->
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('<?php echo esc_url( $sw_url ); ?>', {
            scope: '/'
        }).then(function(registration) {
            console.log('[PWA] Service Worker registered successfully:', registration.scope);

            // Check for updates
            registration.addEventListener('updatefound', function() {
                const newWorker = registration.installing;
                console.log('[PWA] New Service Worker version found');

                newWorker.addEventListener('statechange', function() {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        // New version available, show update prompt
                        if (confirm('Versi baru tersedia! Reload untuk update?')) {
                            newWorker.postMessage({ type: 'SKIP_WAITING' });
                            window.location.reload();
                        }
                    }
                });
            });
        }).catch(function(error) {
            console.log('[PWA] Service Worker registration failed:', error);
        });

        // Reload page when new service worker takes control
        navigator.serviceWorker.addEventListener('controllerchange', function() {
            console.log('[PWA] New Service Worker activated, reloading page');
            window.location.reload();
        });
    });

    // Add to Home Screen prompt
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', function(e) {
        console.log('[PWA] Install prompt available');
        e.preventDefault();
        deferredPrompt = e;

        // Show custom install button (if exists)
        const installButton = document.getElementById('pwa-install-button');
        if (installButton) {
            installButton.style.display = 'block';
            installButton.addEventListener('click', function() {
                installButton.style.display = 'none';
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function(choiceResult) {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('[PWA] User accepted the install prompt');
                    }
                    deferredPrompt = null;
                });
            });
        }
    });

    // Track installation
    window.addEventListener('appinstalled', function(e) {
        console.log('[PWA] App installed successfully');
        if (typeof gtag !== 'undefined') {
            gtag('event', 'pwa_install', {
                event_category: 'engagement',
                event_label: 'PWA Installed'
            });
        }
    });
}

// Online/Offline status
window.addEventListener('online', function() {
    console.log('[PWA] Back online');
    document.body.classList.remove('offline');
    document.body.classList.add('online');
});

window.addEventListener('offline', function() {
    console.log('[PWA] Gone offline');
    document.body.classList.remove('online');
    document.body.classList.add('offline');
});
</script>
<!-- End PWA Service Worker -->

        <?php
    }
    add_action( 'wp_footer', 'majelis_pwa_register_service_worker', 999 );
}

/**
 * Add PWA install button styles
 */
if ( ! function_exists( 'majelis_pwa_install_button_styles' ) ) {
    function majelis_pwa_install_button_styles() {
        ?>
<style>
#pwa-install-button {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 25px;
    border-radius: 50px;
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    z-index: 9999;
    transition: transform 0.2s, box-shadow 0.2s;
    animation: slideInUp 0.5s ease-out;
}

#pwa-install-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

#pwa-install-button:active {
    transform: translateY(-1px);
}

@keyframes slideInUp {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Offline indicator */
body.offline::before {
    content: 'Offline Mode';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: #f59e0b;
    color: white;
    text-align: center;
    padding: 8px;
    font-size: 14px;
    font-weight: 600;
    z-index: 999999;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    #pwa-install-button {
        bottom: 15px;
        right: 15px;
        padding: 12px 20px;
        font-size: 14px;
    }
}
</style>
        <?php
    }
    add_action( 'wp_head', 'majelis_pwa_install_button_styles' );
}

/**
 * Add install button to footer
 */
if ( ! function_exists( 'majelis_pwa_install_button' ) ) {
    function majelis_pwa_install_button() {
        echo '<button id="pwa-install-button">📱 Install Aplikasi</button>';
    }
    add_action( 'wp_footer', 'majelis_pwa_install_button', 998 );
}

/**
 * ========================================
 * AUTOMATION & WEBHOOK ENDPOINTS
 * ========================================
 */

/**
 * Register custom REST API routes for automation
 */
if ( ! function_exists( 'majelis_register_automation_routes' ) ) {
    function majelis_register_automation_routes() {
        // Webhook endpoint for n8n
        register_rest_route( 'majelis/v1', '/webhooks/n8n', array(
            'methods'  => 'POST',
            'callback' => 'majelis_handle_n8n_webhook',
            'permission_callback' => 'majelis_verify_webhook_signature',
        ));

        // Event published webhook
        register_rest_route( 'majelis/v1', '/webhooks/event-published', array(
            'methods'  => 'POST',
            'callback' => 'majelis_handle_event_published',
            'permission_callback' => 'majelis_verify_webhook_signature',
        ));

        // Booking webhook
        register_rest_route( 'majelis/v1', '/webhooks/booking', array(
            'methods'  => 'POST',
            'callback' => 'majelis_handle_booking_webhook',
            'permission_callback' => 'majelis_verify_webhook_signature',
        ));

        // Social media post endpoint
        register_rest_route( 'majelis/v1', '/automation/social-post', array(
            'methods'  => 'POST',
            'callback' => 'majelis_trigger_social_post',
            'permission_callback' => 'majelis_verify_api_key',
        ));

        // Video generation endpoint
        register_rest_route( 'majelis/v1', '/automation/generate-video', array(
            'methods'  => 'POST',
            'callback' => 'majelis_trigger_video_generation',
            'permission_callback' => 'majelis_verify_api_key',
        ));

        // Get automation status
        register_rest_route( 'majelis/v1', '/automation/status', array(
            'methods'  => 'GET',
            'callback' => 'majelis_get_automation_status',
            'permission_callback' => 'majelis_verify_api_key',
        ));
    }
    add_action( 'rest_api_init', 'majelis_register_automation_routes' );
}

/**
 * Verify webhook signature
 */
if ( ! function_exists( 'majelis_verify_webhook_signature' ) ) {
    function majelis_verify_webhook_signature( $request ) {
        // Get signature from header
        $signature = $request->get_header( 'X-Majelis-Signature' );

        if ( ! $signature ) {
            // For development, allow if no signature (remove in production)
            return true; // TODO: Set to false in production
        }

        // Get webhook secret from wp-config.php or options
        $secret = defined( 'MAJELIS_WEBHOOK_SECRET' ) ? MAJELIS_WEBHOOK_SECRET : get_option( 'majelis_webhook_secret' );

        if ( ! $secret ) {
            return new WP_Error( 'no_secret', 'Webhook secret not configured', array( 'status' => 500 ) );
        }

        // Verify signature
        $body = $request->get_body();
        $expected_signature = hash_hmac( 'sha256', $body, $secret );

        if ( ! hash_equals( $expected_signature, $signature ) ) {
            return new WP_Error( 'invalid_signature', 'Invalid webhook signature', array( 'status' => 401 ) );
        }

        return true;
    }
}

/**
 * Verify API key
 */
if ( ! function_exists( 'majelis_verify_api_key' ) ) {
    function majelis_verify_api_key( $request ) {
        $api_key = $request->get_header( 'X-Majelis-API-Key' );

        if ( ! $api_key ) {
            // Try to get from query parameter
            $api_key = $request->get_param( 'api_key' );
        }

        if ( ! $api_key ) {
            return new WP_Error( 'no_api_key', 'API key required', array( 'status' => 401 ) );
        }

        // Get API key from wp-config.php or options
        $valid_key = defined( 'MAJELIS_API_KEY' ) ? MAJELIS_API_KEY : get_option( 'majelis_api_key' );

        if ( ! $valid_key ) {
            return new WP_Error( 'no_key_configured', 'API key not configured', array( 'status' => 500 ) );
        }

        if ( ! hash_equals( $valid_key, $api_key ) ) {
            return new WP_Error( 'invalid_api_key', 'Invalid API key', array( 'status' => 401 ) );
        }

        return true;
    }
}

/**
 * Handle n8n webhook
 */
if ( ! function_exists( 'majelis_handle_n8n_webhook' ) ) {
    function majelis_handle_n8n_webhook( $request ) {
        $params = $request->get_json_params();

        // Log webhook received
        error_log( '[Majelis Webhook] n8n webhook received: ' . print_r( $params, true ) );

        // Process webhook based on action type
        $action = isset( $params['action'] ) ? $params['action'] : '';

        switch ( $action ) {
            case 'event_published':
                return majelis_process_event_published( $params );

            case 'booking_created':
                return majelis_process_booking_created( $params );

            case 'social_post':
                return majelis_process_social_post( $params );

            default:
                return new WP_REST_Response( array(
                    'success' => true,
                    'message' => 'Webhook received',
                    'data'    => $params
                ), 200 );
        }
    }
}

/**
 * Handle event published webhook
 */
if ( ! function_exists( 'majelis_handle_event_published' ) ) {
    function majelis_handle_event_published( $request ) {
        $params = $request->get_json_params();
        return majelis_process_event_published( $params );
    }
}

/**
 * Process event published
 */
if ( ! function_exists( 'majelis_process_event_published' ) ) {
    function majelis_process_event_published( $data ) {
        $event_id = isset( $data['event_id'] ) ? intval( $data['event_id'] ) : 0;

        if ( ! $event_id ) {
            return new WP_Error( 'no_event_id', 'Event ID required', array( 'status' => 400 ) );
        }

        // Get event data
        $event = get_post( $event_id );

        if ( ! $event || $event->post_type !== 'mep_events' ) {
            return new WP_Error( 'invalid_event', 'Invalid event ID', array( 'status' => 404 ) );
        }

        // Prepare event data for external systems
        $event_data = array(
            'id'          => $event_id,
            'title'       => $event->post_title,
            'content'     => $event->post_content,
            'excerpt'     => $event->post_excerpt,
            'url'         => get_permalink( $event_id ),
            'date'        => get_post_meta( $event_id, 'event_start_datetime', true ),
            'location'    => get_post_meta( $event_id, 'mep_location', true ),
            'image'       => get_the_post_thumbnail_url( $event_id, 'large' ),
        );

        // Trigger actions for other systems
        do_action( 'majelis_event_published', $event_id, $event_data );

        // Store in queue for processing
        $queue = get_option( 'majelis_automation_queue', array() );
        $queue[] = array(
            'type'      => 'event_published',
            'event_id'  => $event_id,
            'data'      => $event_data,
            'timestamp' => current_time( 'mysql' ),
            'status'    => 'pending',
        );
        update_option( 'majelis_automation_queue', $queue );

        return new WP_REST_Response( array(
            'success'    => true,
            'message'    => 'Event published webhook processed',
            'event_data' => $event_data,
        ), 200 );
    }
}

/**
 * Handle booking webhook
 */
if ( ! function_exists( 'majelis_handle_booking_webhook' ) ) {
    function majelis_handle_booking_webhook( $request ) {
        $params = $request->get_json_params();
        return majelis_process_booking_created( $params );
    }
}

/**
 * Process booking created
 */
if ( ! function_exists( 'majelis_process_booking_created' ) ) {
    function majelis_process_booking_created( $data ) {
        $booking_id = isset( $data['booking_id'] ) ? intval( $data['booking_id'] ) : 0;

        if ( ! $booking_id ) {
            return new WP_Error( 'no_booking_id', 'Booking ID required', array( 'status' => 400 ) );
        }

        // Trigger actions for booking processing
        do_action( 'majelis_booking_created', $booking_id, $data );

        return new WP_REST_Response( array(
            'success' => true,
            'message' => 'Booking webhook processed',
        ), 200 );
    }
}

/**
 * Process social media post
 */
if ( ! function_exists( 'majelis_process_social_post' ) ) {
    function majelis_process_social_post( $data ) {
        // This will be called by n8n to trigger social media posting
        do_action( 'majelis_trigger_social_post', $data );

        return new WP_REST_Response( array(
            'success' => true,
            'message' => 'Social media post triggered',
        ), 200 );
    }
}

/**
 * Trigger social media post
 */
if ( ! function_exists( 'majelis_trigger_social_post' ) ) {
    function majelis_trigger_social_post( $request ) {
        $params = $request->get_json_params();

        $post_id = isset( $params['post_id'] ) ? intval( $params['post_id'] ) : 0;
        $platforms = isset( $params['platforms'] ) ? $params['platforms'] : array( 'twitter', 'facebook', 'instagram' );

        if ( ! $post_id ) {
            return new WP_Error( 'no_post_id', 'Post ID required', array( 'status' => 400 ) );
        }

        // Get post data
        $post = get_post( $post_id );

        if ( ! $post ) {
            return new WP_Error( 'invalid_post', 'Invalid post ID', array( 'status' => 404 ) );
        }

        // Prepare social media content
        $social_data = array(
            'title'     => $post->post_title,
            'excerpt'   => wp_trim_words( $post->post_excerpt ? $post->post_excerpt : $post->post_content, 30 ),
            'url'       => get_permalink( $post_id ),
            'image'     => get_the_post_thumbnail_url( $post_id, 'large' ),
            'platforms' => $platforms,
        );

        // Add to automation queue
        $queue = get_option( 'majelis_automation_queue', array() );
        $queue[] = array(
            'type'      => 'social_post',
            'post_id'   => $post_id,
            'data'      => $social_data,
            'timestamp' => current_time( 'mysql' ),
            'status'    => 'pending',
        );
        update_option( 'majelis_automation_queue', $queue );

        return new WP_REST_Response( array(
            'success'     => true,
            'message'     => 'Social media post queued',
            'social_data' => $social_data,
        ), 200 );
    }
}

/**
 * Trigger video generation
 */
if ( ! function_exists( 'majelis_trigger_video_generation' ) ) {
    function majelis_trigger_video_generation( $request ) {
        $params = $request->get_json_params();

        $post_id = isset( $params['post_id'] ) ? intval( $params['post_id'] ) : 0;

        if ( ! $post_id ) {
            return new WP_Error( 'no_post_id', 'Post ID required', array( 'status' => 400 ) );
        }

        // Get post data
        $post = get_post( $post_id );

        if ( ! $post ) {
            return new WP_Error( 'invalid_post', 'Invalid post ID', array( 'status' => 404 ) );
        }

        // Prepare video generation data
        $video_data = array(
            'post_id'  => $post_id,
            'title'    => $post->post_title,
            'content'  => wp_trim_words( strip_tags( $post->post_content ), 100 ),
            'image'    => get_the_post_thumbnail_url( $post_id, 'large' ),
        );

        // Add to automation queue
        $queue = get_option( 'majelis_automation_queue', array() );
        $queue[] = array(
            'type'      => 'video_generation',
            'post_id'   => $post_id,
            'data'      => $video_data,
            'timestamp' => current_time( 'mysql' ),
            'status'    => 'pending',
        );
        update_option( 'majelis_automation_queue', $queue );

        return new WP_REST_Response( array(
            'success'    => true,
            'message'    => 'Video generation queued',
            'video_data' => $video_data,
        ), 200 );
    }
}

/**
 * Get automation status
 */
if ( ! function_exists( 'majelis_get_automation_status' ) ) {
    function majelis_get_automation_status( $request ) {
        $queue = get_option( 'majelis_automation_queue', array() );

        $stats = array(
            'total'      => count( $queue ),
            'pending'    => 0,
            'processing' => 0,
            'completed'  => 0,
            'failed'     => 0,
        );

        foreach ( $queue as $item ) {
            $status = isset( $item['status'] ) ? $item['status'] : 'pending';
            if ( isset( $stats[ $status ] ) ) {
                $stats[ $status ]++;
            }
        }

        return new WP_REST_Response( array(
            'success' => true,
            'stats'   => $stats,
            'queue'   => array_slice( $queue, -10 ), // Last 10 items
        ), 200 );
    }
}

/**
 * WordPress action hooks for automation triggers
 */

// Trigger when event is published
add_action( 'publish_mep_events', 'majelis_auto_trigger_event_published', 10, 2 );
function majelis_auto_trigger_event_published( $post_id, $post ) {
    // Send webhook to n8n when event is published
    $webhook_url = get_option( 'majelis_n8n_webhook_url' );

    if ( ! $webhook_url ) {
        return; // No webhook configured
    }

    $event_data = array(
        'action'   => 'event_published',
        'event_id' => $post_id,
        'title'    => $post->post_title,
        'url'      => get_permalink( $post_id ),
        'date'     => get_post_meta( $post_id, 'event_start_datetime', true ),
    );

    // Send async webhook
    wp_remote_post( $webhook_url, array(
        'method'  => 'POST',
        'timeout' => 5,
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body'    => wp_json_encode( $event_data ),
    ));
}
