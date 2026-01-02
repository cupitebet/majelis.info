<?php
/**
 * Core registration for Majelis Events.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Majelis_Events {
	private static $instance;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_meta' ) );
	}

	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Events', 'majelis-events' ),
			'singular_name'      => __( 'Event', 'majelis-events' ),
			'add_new_item'       => __( 'Add New Event', 'majelis-events' ),
			'edit_item'          => __( 'Edit Event', 'majelis-events' ),
			'new_item'           => __( 'New Event', 'majelis-events' ),
			'view_item'          => __( 'View Event', 'majelis-events' ),
			'search_items'       => __( 'Search Events', 'majelis-events' ),
			'not_found'          => __( 'No events found.', 'majelis-events' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'majelis-events' ),
		);

		register_post_type(
			'event',
			array(
				'labels'       => $labels,
				'public'       => true,
				'has_archive'  => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-calendar-alt',
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
				'rewrite'      => array( 'slug' => 'events' ),
			)
		);
	}

	public function register_taxonomies() {
		$this->register_taxonomy( 'event_category', __( 'Event Categories', 'majelis-events' ) );
		$this->register_taxonomy( 'event_tag', __( 'Event Tags', 'majelis-events' ), array( 'hierarchical' => false ) );
		$this->register_taxonomy( 'city', __( 'Cities', 'majelis-events' ) );
		$this->register_taxonomy( 'event_organizer', __( 'Organizers', 'majelis-events' ), array( 'hierarchical' => false ) );
	}

	private function register_taxonomy( $taxonomy, $label, $args = array() ) {
		$defaults = array(
			'label'        => $label,
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
		);

		register_taxonomy( $taxonomy, array( 'event' ), array_merge( $defaults, $args ) );
	}

	public function register_meta() {
		$meta_fields = array(
			'start_datetime'    => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'end_datetime'      => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'all_day'           => array( 'type' => 'boolean', 'sanitize_callback' => array( $this, 'sanitize_boolean' ) ),
			'attendance_mode'   => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'venue'             => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'address'           => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'lat'               => array( 'type' => 'number', 'sanitize_callback' => array( $this, 'sanitize_float' ) ),
			'lng'               => array( 'type' => 'number', 'sanitize_callback' => array( $this, 'sanitize_float' ) ),
			'google_maps_url'   => array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ),
			'organizer_contact' => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'registration_url'  => array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ),
			'status'            => array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
		);

		foreach ( $meta_fields as $key => $args ) {
			register_post_meta(
				'event',
				$key,
				array(
					'type'              => $args['type'],
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => $args['sanitize_callback'],
					'auth_callback'     => array( $this, 'auth_callback' ),
				)
			);
		}
	}

	public function auth_callback( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', $post_id );
	}

	public function sanitize_boolean( $value ) {
		return (bool) $value;
	}

	public function sanitize_float( $value ) {
		return is_numeric( $value ) ? (float) $value : null;
	}
}
