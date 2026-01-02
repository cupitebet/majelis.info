<?php
/**
 * Schema.org and social meta tags.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Majelis_Events_Schema {
	private static $instance;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'wp_head', array( $this, 'output_meta' ), 20 );
	}

	public function output_meta() {
		if ( ! is_singular( 'event' ) ) {
			return;
		}

		$post_id = get_the_ID();
		$data    = $this->build_schema( $post_id );
		$title   = get_the_title( $post_id );
		$url     = get_permalink( $post_id );
		$summary = wp_strip_all_tags( get_the_excerpt( $post_id ) );
		$image   = get_the_post_thumbnail_url( $post_id, 'full' );

		if ( $image ) {
			printf( '<meta property="og:image" content="%s" />', esc_url( $image ) );
			printf( '<meta name="twitter:image" content="%s" />', esc_url( $image ) );
		}

		printf( '<meta property="og:type" content="event" />' );
		printf( '<meta property="og:title" content="%s" />', esc_attr( $title ) );
		printf( '<meta property="og:description" content="%s" />', esc_attr( $summary ) );
		printf( '<meta property="og:url" content="%s" />', esc_url( $url ) );

		printf( '<meta name="twitter:card" content="summary_large_image" />' );
		printf( '<meta name="twitter:title" content="%s" />', esc_attr( $title ) );
		printf( '<meta name="twitter:description" content="%s" />', esc_attr( $summary ) );

		echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>';
	}

	private function build_schema( $post_id ) {
		$start = get_post_meta( $post_id, 'start_datetime', true );
		$end   = get_post_meta( $post_id, 'end_datetime', true );

		$schema = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'Event',
			'name'       => get_the_title( $post_id ),
			'startDate'  => $start,
			'endDate'    => $end,
			'eventStatus' => get_post_meta( $post_id, 'status', true ),
			'eventAttendanceMode' => get_post_meta( $post_id, 'attendance_mode', true ),
			'location'   => array(
				'@type'   => 'Place',
				'name'    => get_post_meta( $post_id, 'venue', true ),
				'address' => get_post_meta( $post_id, 'address', true ),
			),
			'url'        => get_permalink( $post_id ),
			'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
		);

		$image = get_the_post_thumbnail_url( $post_id, 'full' );
		if ( $image ) {
			$schema['image'] = $image;
		}

		$registration = get_post_meta( $post_id, 'registration_url', true );
		if ( $registration ) {
			$schema['offers'] = array(
				'@type' => 'Offer',
				'url'   => $registration,
			);
		}

		return array_filter( $schema );
	}
}
