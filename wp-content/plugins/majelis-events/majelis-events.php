<?php
/**
 * Plugin Name: Majelis Events
 * Description: Core data layer for events (CPT, taxonomies, meta, feeds, and APIs).
 * Version: 0.1.0
 * Author: Majelis
 * Text Domain: majelis-events
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MAJELIS_EVENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MAJELIS_EVENTS_URL', plugin_dir_url( __FILE__ ) );

require_once MAJELIS_EVENTS_PATH . 'includes/class-majelis-events.php';
require_once MAJELIS_EVENTS_PATH . 'includes/class-majelis-events-ics.php';
require_once MAJELIS_EVENTS_PATH . 'includes/class-majelis-events-schema.php';
require_once MAJELIS_EVENTS_PATH . 'includes/class-majelis-events-rest.php';

add_action(
	'plugins_loaded',
	static function () {
		Majelis_Events::instance();
		Majelis_Events_ICS::instance();
		Majelis_Events_Schema::instance();
		Majelis_Events_Rest::instance();
	}
);

register_activation_hook(
	__FILE__,
	static function () {
		Majelis_Events::instance()->register_post_type();
		Majelis_Events::instance()->register_taxonomies();
		Majelis_Events_ICS::instance()->add_rewrite_rules();
		flush_rewrite_rules();
	}
);

register_deactivation_hook(
	__FILE__,
	static function () {
		flush_rewrite_rules();
	}
);
