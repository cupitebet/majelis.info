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
 * Notification opt-in (user-initiated)
 * ========================================
 */

if ( ! function_exists( 'majelis_notification_prompt_styles' ) ) {
    function majelis_notification_prompt_styles() {
        ?>
        <style>
        #majelis-notification-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #0ea5e9;
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.25);
            display: none;
            z-index: 9999;
        }

        #majelis-notification-button[data-state="granted"] {
            display: none;
        }
        </style>
        <?php
    }
    add_action( 'wp_head', 'majelis_notification_prompt_styles' );
}

if ( ! function_exists( 'majelis_notification_prompt_button' ) ) {
    function majelis_notification_prompt_button() {
        ?>
        <button id="majelis-notification-button" type="button" aria-live="polite">
            🔔 Aktifkan notifikasi kajian
        </button>
        <script>
        (function() {
            if (!('Notification' in window)) {
                return;
            }

            const button = document.getElementById('majelis-notification-button');
            if (!button) {
                return;
            }

            const renderState = () => {
                const state = Notification.permission;
                if (state === 'default') {
                    button.style.display = 'block';
                    button.dataset.state = 'prompt';
                    button.textContent = '🔔 Aktifkan notifikasi kajian';
                } else if (state === 'granted') {
                    button.dataset.state = 'granted';
                    button.style.display = 'none';
                } else {
                    button.dataset.state = 'denied';
                    button.textContent = 'Notifikasi diblokir';
                    button.style.display = 'block';
                    button.disabled = true;
                    button.style.opacity = '0.6';
                }
            };

            button.addEventListener('click', async () => {
                try {
                    button.disabled = true;
                    const permission = await Notification.requestPermission();
                    if (permission === 'granted') {
                        console.log('[Majelis] Notification permission granted');
                    }
                } catch (err) {
                    console.warn('[Majelis] Notification permission failed', err);
                } finally {
                    button.disabled = false;
                    renderState();
                }
            });

            renderState();
        })();
        </script>
        <?php
    }
    add_action( 'wp_footer', 'majelis_notification_prompt_button', 997 );
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

/**
 * ========================================
 * SCHEMA.ORG STRUCTURED DATA
 * ========================================
 */

/**
 * Add Organization Schema to site
 */
if ( ! function_exists( 'majelis_add_organization_schema' ) ) {
    function majelis_add_organization_schema() {
        // Only add on homepage or specific pages
        if ( ! is_front_page() && ! is_page( array( 'kontak', 'transparansi-donasi', 'links' ) ) ) {
            return;
        }

        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => get_bloginfo( 'name' ),
            'legalName'   => 'Majelis.info',
            'url'         => home_url( '/' ),
            'logo'        => get_stylesheet_directory_uri() . '/assets/icons/icon-512x512.png',
            'description' => 'Platform agregator jadwal kajian dan majelis ilmu terpercaya di Indonesia. Menghubungkan jamaah dengan berbagai acara keislaman di seluruh nusantara.',
            'foundingDate' => '2021',
            'contactPoint' => array(
                '@type'       => 'ContactPoint',
                'telephone'   => '+62-899-9150-143',
                'contactType' => 'customer service',
                'email'       => 'info@majelis.info',
                'areaServed'  => 'ID',
                'availableLanguage' => array( 'Indonesian', 'id' ),
            ),
            'address' => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Jl. Guru Mughni No.27F',
                'addressLocality' => 'Jakarta',
                'addressCountry'  => 'ID',
            ),
            'sameAs' => array(
                'https://t.me/JadwalMajelis',
                home_url( '/links/' ),
            ),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => array(
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => home_url( '/?s={search_term_string}' ),
                ),
                'query-input' => 'required name=search_term_string',
            ),
        );

        echo "\n<!-- Organization Schema -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        echo "<!-- End Organization Schema -->\n\n";
    }
    add_action( 'wp_head', 'majelis_add_organization_schema', 5 );
}

/**
 * Add WebSite Schema
 */
if ( ! function_exists( 'majelis_add_website_schema' ) ) {
    function majelis_add_website_schema() {
        if ( ! is_front_page() ) {
            return;
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo( 'name' ),
            'url'      => home_url( '/' ),
            'description' => get_bloginfo( 'description' ),
            'publisher' => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'logo'  => array(
                    '@type'  => 'ImageObject',
                    'url'    => get_stylesheet_directory_uri() . '/assets/icons/icon-512x512.png',
                ),
            ),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => array(
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => home_url( '/?s={search_term_string}' ),
                ),
                'query-input' => 'required name=search_term_string',
            ),
        );

        echo "\n<!-- WebSite Schema -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        echo "<!-- End WebSite Schema -->\n\n";
    }
    add_action( 'wp_head', 'majelis_add_website_schema', 5 );
}

/**
 * Add Event Schema for event pages
 */
if ( ! function_exists( 'majelis_add_event_schema' ) ) {
    function majelis_add_event_schema() {
        if ( ! is_singular( 'mep_events' ) ) {
            return;
        }

        global $post;
        $event_id = get_the_ID();

        // Get event data
        $event_start = get_post_meta( $event_id, 'event_start_datetime', true );
        $event_end   = get_post_meta( $event_id, 'event_end_datetime', true );
        $location    = get_post_meta( $event_id, 'mep_location', true );
        $location_name = get_post_meta( $event_id, 'mep_location_name', true );
        $event_lat   = get_post_meta( $event_id, 'mep_latitude', true );
        $event_lng   = get_post_meta( $event_id, 'mep_longitude', true );

        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Event',
            'name'        => get_the_title(),
            'description' => wp_trim_words( get_the_excerpt() ? get_the_excerpt() : get_the_content(), 50 ),
            'url'         => get_permalink(),
            'image'       => get_the_post_thumbnail_url( $event_id, 'large' ),
            'startDate'   => $event_start ? date( 'c', strtotime( $event_start ) ) : '',
            'endDate'     => $event_end ? date( 'c', strtotime( $event_end ) ) : '',
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'organizer'   => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'url'   => home_url( '/' ),
            ),
        );

        // Add location if available
        if ( $location ) {
            $schema['location'] = array(
                '@type'   => 'Place',
                'name'    => $location_name ? $location_name : 'Event Location',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => $location,
                    'addressCountry' => 'ID',
                ),
            );

            if ( $event_lat && $event_lng ) {
                $schema['location']['geo'] = array(
                    '@type'     => 'GeoCoordinates',
                    'latitude'  => $event_lat,
                    'longitude' => $event_lng,
                );
            }
        }

        echo "\n<!-- Event Schema -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        echo "<!-- End Event Schema -->\n\n";
    }
    add_action( 'wp_head', 'majelis_add_event_schema', 5 );
}

/**
 * Add BreadcrumbList Schema
 */
if ( ! function_exists( 'majelis_add_breadcrumb_schema' ) ) {
    function majelis_add_breadcrumb_schema() {
        if ( is_front_page() ) {
            return;
        }

        $breadcrumbs = array(
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => array(),
        );

        $position = 1;

        // Home
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => 'Home',
            'item'     => home_url( '/' ),
        );

        // Add current page
        if ( is_singular() ) {
            $breadcrumbs['itemListElement'][] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            );
        }

        echo "\n<!-- BreadcrumbList Schema -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        echo "<!-- End BreadcrumbList Schema -->\n\n";
    }
    add_action( 'wp_head', 'majelis_add_breadcrumb_schema', 5 );
}

/**
 * ========================================
 * RATING & REVIEW SYSTEM (Goers-inspired)
 * ========================================
 */

/**
 * Add rating & review meta boxes
 */
if ( ! function_exists( 'majelis_add_review_metaboxes' ) ) {
    function majelis_add_review_metaboxes() {
        add_meta_box(
            'event_reviews',
            'Reviews & Ratings',
            'majelis_render_reviews_metabox',
            'mep_events',
            'normal',
            'default'
        );
    }
    add_action( 'add_meta_boxes', 'majelis_add_review_metaboxes' );
}

/**
 * Render reviews metabox (admin view only)
 */
function majelis_render_reviews_metabox( $post ) {
    $average_rating = get_post_meta( $post->ID, '_event_rating_average', true );
    $rating_count = get_post_meta( $post->ID, '_event_rating_count', true );

    echo '<p><strong>Average Rating:</strong> ' . ( $average_rating ? number_format( $average_rating, 1 ) : 'No ratings yet' ) . '</p>';
    echo '<p><strong>Total Reviews:</strong> ' . ( $rating_count ? $rating_count : '0' ) . '</p>';
    echo '<p style="color: #666;"><em>Reviews are submitted by users on the frontend and cannot be edited here.</em></p>';
}

/**
 * Register review custom post type
 */
if ( ! function_exists( 'majelis_register_review_post_type' ) ) {
    function majelis_register_review_post_type() {
        $args = array(
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => 'edit.php?post_type=mep_events',
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array( 'title', 'editor', 'author' ),
            'labels'              => array(
                'name'               => 'Event Reviews',
                'singular_name'      => 'Event Review',
                'add_new'            => 'Add New Review',
                'add_new_item'       => 'Add New Review',
                'edit_item'          => 'Edit Review',
                'view_item'          => 'View Review',
                'search_items'       => 'Search Reviews',
                'not_found'          => 'No reviews found',
                'not_found_in_trash' => 'No reviews found in trash',
            ),
        );

        register_post_type( 'event_review', $args );
    }
    add_action( 'init', 'majelis_register_review_post_type' );
}

/**
 * AJAX handler: Submit review
 */
if ( ! function_exists( 'majelis_submit_review_ajax' ) ) {
    function majelis_submit_review_ajax() {
        // Verify nonce
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'submit_review' ) ) {
            wp_send_json_error( array( 'message' => 'Security check failed' ) );
        }

        // Get data
        $event_id = intval( $_POST['event_id'] );
        $rating = intval( $_POST['rating'] );
        $review_text = sanitize_textarea_field( $_POST['review_text'] );
        $reviewer_name = sanitize_text_field( $_POST['reviewer_name'] );
        $reviewer_email = sanitize_email( $_POST['reviewer_email'] );

        // Validate
        if ( ! $event_id || $rating < 1 || $rating > 5 || empty( $review_text ) || strlen( $review_text ) < 50 ) {
            wp_send_json_error( array( 'message' => 'Please provide valid rating and review (minimum 50 characters)' ) );
        }

        // Check if user already reviewed this event (by email)
        $existing_reviews = get_posts( array(
            'post_type'  => 'event_review',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'   => '_event_id',
                    'value' => $event_id,
                ),
                array(
                    'key'   => '_reviewer_email',
                    'value' => $reviewer_email,
                ),
            ),
        ));

        if ( ! empty( $existing_reviews ) ) {
            wp_send_json_error( array( 'message' => 'You have already reviewed this event' ) );
        }

        // Create review post
        $review_id = wp_insert_post( array(
            'post_type'    => 'event_review',
            'post_title'   => 'Review by ' . $reviewer_name . ' for Event #' . $event_id,
            'post_content' => $review_text,
            'post_status'  => 'pending', // Require moderation
            'post_author'  => 0,
        ));

        if ( $review_id ) {
            // Save meta data
            update_post_meta( $review_id, '_event_id', $event_id );
            update_post_meta( $review_id, '_rating', $rating );
            update_post_meta( $review_id, '_reviewer_name', $reviewer_name );
            update_post_meta( $review_id, '_reviewer_email', $reviewer_email );

            // Update event rating
            majelis_update_event_rating( $event_id );

            wp_send_json_success( array( 'message' => 'Thank you! Your review is pending moderation.' ) );
        } else {
            wp_send_json_error( array( 'message' => 'Failed to submit review. Please try again.' ) );
        }
    }
    add_action( 'wp_ajax_submit_review', 'majelis_submit_review_ajax' );
    add_action( 'wp_ajax_nopriv_submit_review', 'majelis_submit_review_ajax' );
}

/**
 * Update event rating average
 */
function majelis_update_event_rating( $event_id ) {
    $reviews = get_posts( array(
        'post_type'      => 'event_review',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => '_event_id',
                'value' => $event_id,
            ),
        ),
    ));

    if ( empty( $reviews ) ) {
        delete_post_meta( $event_id, '_event_rating_average' );
        delete_post_meta( $event_id, '_event_rating_count' );
        return;
    }

    $total_rating = 0;
    foreach ( $reviews as $review ) {
        $rating = get_post_meta( $review->ID, '_rating', true );
        $total_rating += intval( $rating );
    }

    $average = $total_rating / count( $reviews );

    update_post_meta( $event_id, '_event_rating_average', $average );
    update_post_meta( $event_id, '_event_rating_count', count( $reviews ) );
}

/**
 * Auto-update rating when review status changes
 */
add_action( 'transition_post_status', function( $new_status, $old_status, $post ) {
    if ( $post->post_type === 'event_review' ) {
        $event_id = get_post_meta( $post->ID, '_event_id', true );
        if ( $event_id ) {
            majelis_update_event_rating( $event_id );
        }
    }
}, 10, 3 );

/**
 * ========================================
 * AJAX HANDLERS FOR EVENT FILTERS (Goers-inspired)
 * ========================================
 */

/**
 * AJAX handler: Get events by time filter
 */
if ( ! function_exists( 'majelis_get_events_by_time_ajax' ) ) {
    function majelis_get_events_by_time_ajax() {
        $filter = isset( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'today';

        // Set date range based on filter
        switch ( $filter ) {
            case 'today':
                $start_date = date( 'Y-m-d 00:00:00' );
                $end_date = date( 'Y-m-d 23:59:59' );
                break;

            case 'tomorrow':
                $start_date = date( 'Y-m-d 00:00:00', strtotime( '+1 day' ) );
                $end_date = date( 'Y-m-d 23:59:59', strtotime( '+1 day' ) );
                break;

            case 'week':
                $start_date = date( 'Y-m-d 00:00:00' );
                $end_date = date( 'Y-m-d 23:59:59', strtotime( '+7 days' ) );
                break;

            case 'all':
            default:
                $start_date = date( 'Y-m-d 00:00:00' );
                $end_date = date( 'Y-m-d 23:59:59', strtotime( '+30 days' ) );
                break;
        }

        // Query events
        $args = array(
            'post_type'      => 'mep_events',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'meta_key'       => 'event_start_datetime',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => 'event_start_datetime',
                    'value'   => array( $start_date, $end_date ),
                    'compare' => 'BETWEEN',
                    'type'    => 'DATETIME',
                ),
            ),
        );

        $events = new WP_Query( $args );

        ob_start();

        if ( $events->have_posts() ) :
            while ( $events->have_posts() ) : $events->the_post();
                $event_id = get_the_ID();
                $event_start = get_post_meta( $event_id, 'event_start_datetime', true );
                $location = get_post_meta( $event_id, 'mep_location', true );
                $ticket_price = get_post_meta( $event_id, 'mep_ticket_price', true );
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

            $html = ob_get_clean();
            wp_send_json_success( array( 'html' => $html ) );

        else :
            ob_get_clean();
            wp_send_json_error( array( 'message' => 'No events found' ) );
        endif;
    }
    add_action( 'wp_ajax_get_events_by_time', 'majelis_get_events_by_time_ajax' );
    add_action( 'wp_ajax_nopriv_get_events_by_time', 'majelis_get_events_by_time_ajax' );
}
