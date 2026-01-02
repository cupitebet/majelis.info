<?php
/**
 * REST API endpoints for events.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Majelis_Events_Rest {
	private static $instance;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route(
			'majelis/v1',
			'/events',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_events' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'city'      => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'category'  => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'tag'       => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'search'    => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'from'      => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'to'        => array( 'sanitize_callback' => 'sanitize_text_field' ),
					'per_page'  => array( 'sanitize_callback' => 'absint' ),
				),
			)
		);

		register_rest_route(
			'majelis/v1',
			'/events/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_event' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	public function build_google_calendar_url( WP_Post $post ) {
		$start = get_post_meta( $post->ID, 'start_datetime', true );
		$end   = get_post_meta( $post->ID, 'end_datetime', true );

		$dates = rawurlencode( $this->format_google_dates( $start, $end ) );
		$title = rawurlencode( get_the_title( $post ) );
		$desc  = rawurlencode( wp_strip_all_tags( $post->post_excerpt ? $post->post_excerpt : $post->post_content ) );
		$loc   = rawurlencode( get_post_meta( $post->ID, 'address', true ) );

		return sprintf(
			'https://calendar.google.com/calendar/render?action=TEMPLATE&text=%s&dates=%s&details=%s&location=%s&trp=false',
			$title,
			$dates,
			$desc,
			$loc
		);
	}

	public function get_events( WP_REST_Request $request ) {
		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => $request->get_param( 'per_page' ) ? (int) $request->get_param( 'per_page' ) : 20,
			's'              => $request->get_param( 'search' ),
			'meta_key'       => 'start_datetime',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		);

		$tax_query = array();

		if ( $request->get_param( 'category' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'event_category',
				'field'    => 'slug',
				'terms'    => $request->get_param( 'category' ),
			);
		}

		if ( $request->get_param( 'tag' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'event_tag',
				'field'    => 'slug',
				'terms'    => $request->get_param( 'tag' ),
			);
		}

		if ( $request->get_param( 'city' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'city',
				'field'    => 'slug',
				'terms'    => $request->get_param( 'city' ),
			);
		}

		if ( ! empty( $tax_query ) ) {
			$args['tax_query'] = $tax_query;
		}

		$meta_query = array();
		if ( $request->get_param( 'from' ) ) {
			$meta_query[] = array(
				'key'     => 'start_datetime',
				'value'   => $request->get_param( 'from' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			);
		}

		if ( $request->get_param( 'to' ) ) {
			$meta_query[] = array(
				'key'     => 'start_datetime',
				'value'   => $request->get_param( 'to' ),
				'compare' => '<=',
				'type'    => 'DATETIME',
			);
		}

		if ( ! empty( $meta_query ) ) {
			$args['meta_query'] = $meta_query;
		}

		$query  = new WP_Query( $args );
		$events = array();

		foreach ( $query->posts as $post ) {
			$events[] = $this->format_event( $post );
		}

		return rest_ensure_response(
			array(
				'count'  => count( $events ),
				'events' => $events,
			)
		);
	}

	public function get_event( WP_REST_Request $request ) {
		$post = get_post( (int) $request['id'] );
		if ( ! $post || 'event' !== $post->post_type ) {
			return new WP_Error( 'not_found', __( 'Event not found.', 'majelis-events' ), array( 'status' => 404 ) );
		}

		return rest_ensure_response( $this->format_event( $post ) );
	}

	private function format_event( WP_Post $post ) {
		$google_calendar = $this->build_google_calendar_url( $post );

		return array(
			'id'              => $post->ID,
			'title'           => get_the_title( $post ),
			'link'            => get_permalink( $post ),
			'excerpt'         => get_the_excerpt( $post ),
			'start_datetime'  => get_post_meta( $post->ID, 'start_datetime', true ),
			'end_datetime'    => get_post_meta( $post->ID, 'end_datetime', true ),
			'all_day'         => (bool) get_post_meta( $post->ID, 'all_day', true ),
			'attendance_mode' => get_post_meta( $post->ID, 'attendance_mode', true ),
			'venue'           => get_post_meta( $post->ID, 'venue', true ),
			'address'         => get_post_meta( $post->ID, 'address', true ),
			'lat'             => get_post_meta( $post->ID, 'lat', true ),
			'lng'             => get_post_meta( $post->ID, 'lng', true ),
			'google_maps_url' => get_post_meta( $post->ID, 'google_maps_url', true ),
			'organizer_contact' => get_post_meta( $post->ID, 'organizer_contact', true ),
			'registration_url'  => get_post_meta( $post->ID, 'registration_url', true ),
			'status'            => get_post_meta( $post->ID, 'status', true ),
			'categories'        => wp_get_post_terms( $post->ID, 'event_category', array( 'fields' => 'names' ) ),
			'tags'              => wp_get_post_terms( $post->ID, 'event_tag', array( 'fields' => 'names' ) ),
			'cities'            => wp_get_post_terms( $post->ID, 'city', array( 'fields' => 'names' ) ),
			'google_calendar_url' => $google_calendar,
		);
	}

	private function format_google_dates( $start, $end ) {
		$start_ts = $start ? strtotime( $start ) : null;
		$end_ts   = $end ? strtotime( $end ) : null;

		$start_out = $start_ts ? gmdate( 'Ymd\THis\Z', $start_ts ) : '';
		$end_out   = $end_ts ? gmdate( 'Ymd\THis\Z', $end_ts ) : $start_out;

		return $start_out . '/' . $end_out;
	}
}
