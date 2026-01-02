<?php
/**
 * ICS generation and feed endpoints.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Majelis_Events_ICS {
	private static $instance;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'add_rewrite_rules' ) );
		add_filter( 'query_vars', array( $this, 'register_query_vars' ) );
		add_action( 'template_redirect', array( $this, 'handle_ics_requests' ) );
	}

	public function add_rewrite_rules() {
		add_rewrite_rule( '^events\.ics$', 'index.php?majelis_events_ics=1', 'top' );
		add_rewrite_rule( '^events/([^/]+)/download/ics/?$', 'index.php?event=$matches[1]&majelis_event_ics=1', 'top' );
	}

	public function register_query_vars( $vars ) {
		$vars[] = 'majelis_events_ics';
		$vars[] = 'majelis_event_ics';
		$vars[] = 'format';

		return $vars;
	}

	public function handle_ics_requests() {
		if ( get_query_var( 'majelis_events_ics' ) ) {
			$this->output_events_feed();
		}

		if ( is_singular( 'event' ) && ( get_query_var( 'majelis_event_ics' ) || 'ics' === get_query_var( 'format' ) ) ) {
			$this->output_single_event( get_the_ID() );
		}
	}

	private function output_events_feed() {
		$days = 30;
		$now  = current_time( 'mysql' );

		$query = new WP_Query(
			array(
				'post_type'      => 'event',
				'posts_per_page' => 200,
				'meta_key'       => 'start_datetime',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => 'start_datetime',
						'value'   => $now,
						'compare' => '>=',
						'type'    => 'DATETIME',
					),
					array(
						'key'     => 'start_datetime',
						'value'   => gmdate( 'Y-m-d H:i:s', strtotime( "+{$days} days" ) ),
						'compare' => '<=',
						'type'    => 'DATETIME',
					),
				),
			)
		);

		$events = $query->posts;

		$this->send_ics_headers( 'majelis-events.ics' );
		echo $this->build_ics_calendar( $events );
		exit;
	}

	private function output_single_event( $post_id ) {
		$event = get_post( $post_id );
		if ( ! $event || 'event' !== $event->post_type ) {
			wp_die( esc_html__( 'Event not found.', 'majelis-events' ), 404 );
		}

		$filename = sanitize_title( $event->post_title ) . '.ics';
		$this->send_ics_headers( $filename );
		echo $this->build_ics_calendar( array( $event ) );
		exit;
	}

	private function send_ics_headers( $filename ) {
		nocache_headers();
		header( 'Content-Type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
	}

	private function build_ics_calendar( $events ) {
		$lines   = array(
			'BEGIN:VCALENDAR',
			'VERSION:2.0',
			'PRODID:-//Majelis//Events//EN',
			'CALSCALE:GREGORIAN',
		);

		foreach ( $events as $event ) {
			$lines = array_merge( $lines, $this->build_ics_event( $event ) );
		}

		$lines[] = 'END:VCALENDAR';

		return implode( "\r\n", array_filter( $lines ) );
	}

	private function build_ics_event( $event ) {
		$start = get_post_meta( $event->ID, 'start_datetime', true );
		$end   = get_post_meta( $event->ID, 'end_datetime', true );
		$uid   = $event->ID . '@' . parse_url( home_url(), PHP_URL_HOST );

		$dtstart = $this->format_datetime( $start );
		$dtend   = $this->format_datetime( $end );

		return array_filter(
			array(
				'BEGIN:VEVENT',
				'UID:' . $uid,
				'DTSTAMP:' . gmdate( 'Ymd\THis\Z' ),
				$dtstart ? 'DTSTART:' . $dtstart : '',
				$dtend ? 'DTEND:' . $dtend : '',
				'SUMMARY:' . $this->escape_ics_text( get_the_title( $event ) ),
				'DESCRIPTION:' . $this->escape_ics_text( wp_strip_all_tags( $event->post_excerpt ? $event->post_excerpt : $event->post_content ) ),
				'URL;VALUE=URI:' . get_permalink( $event ),
				'LOCATION:' . $this->escape_ics_text( get_post_meta( $event->ID, 'address', true ) ),
				'END:VEVENT',
			)
		);
	}

	private function format_datetime( $value ) {
		if ( empty( $value ) ) {
			return '';
		}

		$timestamp = strtotime( $value );
		if ( ! $timestamp ) {
			return '';
		}

		return gmdate( 'Ymd\THis\Z', $timestamp );
	}

	private function escape_ics_text( $text ) {
		$text = wp_strip_all_tags( $text );
		$text = str_replace( array( '\\', ';', ',', "\n", "\r" ), array( '\\\\', '\;', '\,', '\n', '' ), $text );
		return $text;
	}
}
