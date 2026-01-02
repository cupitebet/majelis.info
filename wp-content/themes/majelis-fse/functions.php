<?php
/**
 * Majelis FSE functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	static function () {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
	}
);

add_action(
	'after_switch_theme',
	static function () {
		add_role(
			'organizer',
			__( 'Organizer', 'majelis-fse' ),
			array(
				'read'       => true,
				'edit_posts' => true,
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_enqueue_style( 'majelis-fse-style', get_stylesheet_uri(), array(), '0.1.0' );
	}
);

add_action(
	'admin_init',
	static function () {
		if ( current_user_can( 'administrator' ) || wp_doing_ajax() ) {
			return;
		}

		wp_safe_redirect( home_url( '/dashboard' ) );
		exit;
	}
);

add_filter(
	'query_vars',
	static function ( $vars ) {
		$vars[] = 'event_category';
		$vars[] = 'event_tag';
		$vars[] = 'city';
		$vars[] = 'from';
		$vars[] = 'to';
		return $vars;
	}
);

add_action(
	'pre_get_posts',
	static function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'event' ) ) {
			return;
		}

		$query->set( 'meta_key', 'start_datetime' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'ASC' );

		$meta_query = array();

		$from = get_query_var( 'from' );
		if ( $from ) {
			$meta_query[] = array(
				'key'     => 'start_datetime',
				'value'   => $from,
				'compare' => '>=',
				'type'    => 'DATETIME',
			);
		}

		$to = get_query_var( 'to' );
		if ( $to ) {
			$meta_query[] = array(
				'key'     => 'start_datetime',
				'value'   => $to,
				'compare' => '<=',
				'type'    => 'DATETIME',
			);
		}

		if ( ! empty( $meta_query ) ) {
			$query->set( 'meta_query', $meta_query );
		}

		$tax_query = array();

		$event_category = get_query_var( 'event_category' );
		if ( $event_category ) {
			$tax_query[] = array(
				'taxonomy' => 'event_category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $event_category ),
			);
		}

		$event_tag = get_query_var( 'event_tag' );
		if ( $event_tag ) {
			$tax_query[] = array(
				'taxonomy' => 'event_tag',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $event_tag ),
			);
		}

		$city = get_query_var( 'city' );
		if ( $city ) {
			$tax_query[] = array(
				'taxonomy' => 'city',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $city ),
			);
		}

		if ( ! empty( $tax_query ) ) {
			$query->set( 'tax_query', $tax_query );
		}
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! is_singular( 'event' ) ) {
			return;
		}

		$lat = get_post_meta( get_the_ID(), 'lat', true );
		$lng = get_post_meta( get_the_ID(), 'lng', true );

		if ( ! $lat || ! $lng ) {
			return;
		}

		wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		wp_enqueue_script(
			'majelis-leaflet',
			get_theme_file_uri( 'assets/js/leaflet-map.js' ),
			array( 'leaflet' ),
			'0.1.0',
			true
		);
	}
);

add_action(
	'init',
	static function () {
		add_shortcode( 'majelis_event_filters', 'majelis_event_filters_shortcode' );
		add_shortcode( 'majelis_event_details', 'majelis_event_details_shortcode' );
		add_shortcode( 'majelis_event_share', 'majelis_event_share_shortcode' );
		add_shortcode( 'majelis_event_map', 'majelis_event_map_shortcode' );
		add_shortcode( 'majelis_login_form', 'majelis_login_form_shortcode' );
		add_shortcode( 'majelis_register_form', 'majelis_register_form_shortcode' );
		add_shortcode( 'majelis_forgot_password', 'majelis_forgot_password_shortcode' );
		add_shortcode( 'majelis_account', 'majelis_account_shortcode' );
		add_shortcode( 'majelis_dashboard', 'majelis_dashboard_shortcode' );
	}
);

function majelis_event_filters_shortcode() {
	$archive_url = get_post_type_archive_link( 'event' );

	$categories = get_terms( array( 'taxonomy' => 'event_category', 'hide_empty' => false ) );
	$tags       = get_terms( array( 'taxonomy' => 'event_tag', 'hide_empty' => false ) );
	$cities     = get_terms( array( 'taxonomy' => 'city', 'hide_empty' => false ) );

	ob_start();
	?>
	<form class="majelis-event-filters" method="get" action="<?php echo esc_url( $archive_url ); ?>">
		<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search events', 'majelis-fse' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<select name="event_category">
			<option value=""><?php esc_html_e( 'All categories', 'majelis-fse' ); ?></option>
			<?php foreach ( $categories as $term ) : ?>
				<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( get_query_var( 'event_category' ), $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
		<select name="event_tag">
			<option value=""><?php esc_html_e( 'All tags', 'majelis-fse' ); ?></option>
			<?php foreach ( $tags as $term ) : ?>
				<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( get_query_var( 'event_tag' ), $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
		<select name="city">
			<option value=""><?php esc_html_e( 'All cities', 'majelis-fse' ); ?></option>
			<?php foreach ( $cities as $term ) : ?>
				<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( get_query_var( 'city' ), $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="date" name="from" value="<?php echo esc_attr( get_query_var( 'from' ) ); ?>" />
		<input type="date" name="to" value="<?php echo esc_attr( get_query_var( 'to' ) ); ?>" />
		<button type="submit"><?php esc_html_e( 'Filter', 'majelis-fse' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}

function majelis_event_details_shortcode() {
	if ( ! is_singular( 'event' ) ) {
		return '';
	}

	$post_id = get_the_ID();
	$data    = array(
		'start_datetime'  => get_post_meta( $post_id, 'start_datetime', true ),
		'end_datetime'    => get_post_meta( $post_id, 'end_datetime', true ),
		'attendance_mode' => get_post_meta( $post_id, 'attendance_mode', true ),
		'venue'           => get_post_meta( $post_id, 'venue', true ),
		'address'         => get_post_meta( $post_id, 'address', true ),
		'registration'    => get_post_meta( $post_id, 'registration_url', true ),
	);

	ob_start();
	?>
	<div class="majelis-event-details">
		<p><strong><?php esc_html_e( 'Start:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $data['start_datetime'] ); ?></p>
		<p><strong><?php esc_html_e( 'End:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $data['end_datetime'] ); ?></p>
		<p><strong><?php esc_html_e( 'Attendance:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $data['attendance_mode'] ); ?></p>
		<p><strong><?php esc_html_e( 'Venue:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $data['venue'] ); ?></p>
		<p><strong><?php esc_html_e( 'Address:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $data['address'] ); ?></p>
		<?php if ( $data['registration'] ) : ?>
			<p><a href="<?php echo esc_url( $data['registration'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Register', 'majelis-fse' ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

function majelis_event_share_shortcode() {
	if ( ! is_singular( 'event' ) ) {
		return '';
	}

	$post_id      = get_the_ID();
	$title        = rawurlencode( get_the_title( $post_id ) );
	$permalink    = rawurlencode( get_permalink( $post_id ) );
	$description  = rawurlencode( wp_strip_all_tags( get_the_excerpt( $post_id ) ) );
	$start        = get_post_meta( $post_id, 'start_datetime', true );
	$end          = get_post_meta( $post_id, 'end_datetime', true );
	$address      = get_post_meta( $post_id, 'address', true );
	$calendar_url = majelis_google_calendar_url( $post_id, $start, $end, $description, $address );
	$ics_url      = add_query_arg( 'format', 'ics', get_permalink( $post_id ) );

	ob_start();
	?>
	<div class="majelis-event-share">
		<a href="<?php echo esc_url( $calendar_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Add to Google Calendar', 'majelis-fse' ); ?></a>
		<a href="<?php echo esc_url( $ics_url ); ?>"><?php esc_html_e( 'Download ICS', 'majelis-fse' ); ?></a>
		<a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( $title ); ?>&url=<?php echo esc_attr( $permalink ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Share on X', 'majelis-fse' ); ?></a>
	</div>
	<?php
	return ob_get_clean();
}

function majelis_event_map_shortcode() {
	if ( ! is_singular( 'event' ) ) {
		return '';
	}

	$post_id = get_the_ID();
	$lat     = get_post_meta( $post_id, 'lat', true );
	$lng     = get_post_meta( $post_id, 'lng', true );
	$address = get_post_meta( $post_id, 'address', true );
	$map_url = get_post_meta( $post_id, 'google_maps_url', true );

	if ( ! $lat || ! $lng ) {
		return '';
	}

	if ( ! $map_url && $address ) {
		$map_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );
	}

	ob_start();
	?>
	<div class="majelis-event-map" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lng ); ?>"></div>
	<?php if ( $map_url ) : ?>
		<p><a href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open in Google Maps', 'majelis-fse' ); ?></a></p>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

function majelis_login_form_shortcode() {
	if ( is_user_logged_in() ) {
		return '<p>' . esc_html__( 'You are already logged in.', 'majelis-fse' ) . '</p>';
	}

	ob_start();
	wp_login_form(
		array(
			'redirect' => home_url( '/dashboard' ),
		)
	);
	return ob_get_clean();
}

function majelis_register_form_shortcode() {
	if ( is_user_logged_in() ) {
		return '<p>' . esc_html__( 'You are already registered.', 'majelis-fse' ) . '</p>';
	}

	$errors = array();

	if ( isset( $_POST['majelis_register_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['majelis_register_nonce'] ) ), 'majelis_register' ) ) {
		$username = sanitize_user( wp_unslash( $_POST['username'] ?? '' ) );
		$email    = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
		$password = wp_unslash( $_POST['password'] ?? '' );

		if ( ! $username || ! $email || ! $password ) {
			$errors[] = __( 'All fields are required.', 'majelis-fse' );
		} else {
			$user_id = wp_create_user( $username, $password, $email );
			if ( is_wp_error( $user_id ) ) {
				$errors[] = $user_id->get_error_message();
			} else {
				wp_update_user(
					array(
						'ID'   => $user_id,
						'role' => 'organizer',
					)
				);
				return '<p>' . esc_html__( 'Registration successful. Please log in.', 'majelis-fse' ) . '</p>';
			}
		}
	}

	ob_start();
	if ( $errors ) {
		echo '<ul class="majelis-errors">';
		foreach ( $errors as $error ) {
			echo '<li>' . esc_html( $error ) . '</li>';
		}
		echo '</ul>';
	}
	?>
	<form method="post" class="majelis-register-form">
		<label><?php esc_html_e( 'Username', 'majelis-fse' ); ?></label>
		<input type="text" name="username" required />
		<label><?php esc_html_e( 'Email', 'majelis-fse' ); ?></label>
		<input type="email" name="email" required />
		<label><?php esc_html_e( 'Password', 'majelis-fse' ); ?></label>
		<input type="password" name="password" required />
		<?php wp_nonce_field( 'majelis_register', 'majelis_register_nonce' ); ?>
		<button type="submit"><?php esc_html_e( 'Register', 'majelis-fse' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}

function majelis_forgot_password_shortcode() {
	if ( is_user_logged_in() ) {
		return '<p>' . esc_html__( 'You are logged in.', 'majelis-fse' ) . '</p>';
	}

	$message = '';
	$errors  = array();

	if ( isset( $_POST['majelis_forgot_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['majelis_forgot_nonce'] ) ), 'majelis_forgot' ) ) {
		$user_login = sanitize_text_field( wp_unslash( $_POST['user_login'] ?? '' ) );
		$result     = retrieve_password( $user_login );

		if ( is_wp_error( $result ) ) {
			$errors[] = $result->get_error_message();
		} else {
			$message = __( 'Password reset email sent.', 'majelis-fse' );
		}
	}

	ob_start();
	if ( $message ) {
		echo '<p>' . esc_html( $message ) . '</p>';
	}
	if ( $errors ) {
		echo '<ul class="majelis-errors">';
		foreach ( $errors as $error ) {
			echo '<li>' . esc_html( $error ) . '</li>';
		}
		echo '</ul>';
	}
	?>
	<form method="post" class="majelis-forgot-form">
		<label><?php esc_html_e( 'Username or Email', 'majelis-fse' ); ?></label>
		<input type="text" name="user_login" required />
		<?php wp_nonce_field( 'majelis_forgot', 'majelis_forgot_nonce' ); ?>
		<button type="submit"><?php esc_html_e( 'Send Reset Link', 'majelis-fse' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}

function majelis_account_shortcode() {
	if ( ! is_user_logged_in() ) {
		return '<p>' . esc_html__( 'Please log in to view your account.', 'majelis-fse' ) . '</p>';
	}

	$user = wp_get_current_user();

	ob_start();
	?>
	<div class="majelis-account">
		<p><strong><?php esc_html_e( 'Username:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $user->user_login ); ?></p>
		<p><strong><?php esc_html_e( 'Email:', 'majelis-fse' ); ?></strong> <?php echo esc_html( $user->user_email ); ?></p>
		<p><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'majelis-fse' ); ?></a></p>
	</div>
	<?php
	return ob_get_clean();
}

function majelis_dashboard_shortcode() {
	if ( ! is_user_logged_in() ) {
		return '<p>' . esc_html__( 'Please log in to access the dashboard.', 'majelis-fse' ) . '</p>';
	}

	$user = wp_get_current_user();
	if ( ! in_array( 'organizer', (array) $user->roles, true ) && ! current_user_can( 'administrator' ) ) {
		return '<p>' . esc_html__( 'You do not have access to submit events.', 'majelis-fse' ) . '</p>';
	}

	$errors  = array();
	$success = '';

	if ( isset( $_POST['majelis_event_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['majelis_event_nonce'] ) ), 'majelis_event_submit' ) ) {
		$title = sanitize_text_field( wp_unslash( $_POST['event_title'] ?? '' ) );
		$desc  = wp_kses_post( wp_unslash( $_POST['event_description'] ?? '' ) );

		if ( ! $title ) {
			$errors[] = __( 'Event title is required.', 'majelis-fse' );
		} else {
			$post_id = wp_insert_post(
				array(
					'post_title'   => $title,
					'post_content' => $desc,
					'post_type'    => 'event',
					'post_status'  => 'pending',
					'post_author'  => $user->ID,
				)
			);

			if ( is_wp_error( $post_id ) ) {
				$errors[] = $post_id->get_error_message();
			} else {
				majelis_update_event_meta_from_request( $post_id );
				$success = __( 'Event submitted for review.', 'majelis-fse' );
			}
		}
	}

	$events = get_posts(
		array(
			'post_type'      => 'event',
			'author'         => $user->ID,
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => 20,
		)
	);

	ob_start();
	if ( $success ) {
		echo '<p>' . esc_html( $success ) . '</p>';
	}
	if ( $errors ) {
		echo '<ul class="majelis-errors">';
		foreach ( $errors as $error ) {
			echo '<li>' . esc_html( $error ) . '</li>';
		}
		echo '</ul>';
	}
	?>
	<form method="post" class="majelis-event-form">
		<label><?php esc_html_e( 'Event Title', 'majelis-fse' ); ?></label>
		<input type="text" name="event_title" required />
		<label><?php esc_html_e( 'Description', 'majelis-fse' ); ?></label>
		<textarea name="event_description" rows="6"></textarea>
		<label><?php esc_html_e( 'Start Date/Time', 'majelis-fse' ); ?></label>
		<input type="datetime-local" name="start_datetime" />
		<label><?php esc_html_e( 'End Date/Time', 'majelis-fse' ); ?></label>
		<input type="datetime-local" name="end_datetime" />
		<label><?php esc_html_e( 'Venue', 'majelis-fse' ); ?></label>
		<input type="text" name="venue" />
		<label><?php esc_html_e( 'Address', 'majelis-fse' ); ?></label>
		<input type="text" name="address" />
		<label><?php esc_html_e( 'Latitude', 'majelis-fse' ); ?></label>
		<input type="text" name="lat" />
		<label><?php esc_html_e( 'Longitude', 'majelis-fse' ); ?></label>
		<input type="text" name="lng" />
		<label><?php esc_html_e( 'Google Maps URL', 'majelis-fse' ); ?></label>
		<input type="url" name="google_maps_url" />
		<label><?php esc_html_e( 'Organizer Contact', 'majelis-fse' ); ?></label>
		<input type="text" name="organizer_contact" />
		<label><?php esc_html_e( 'Registration URL', 'majelis-fse' ); ?></label>
		<input type="url" name="registration_url" />
		<label><?php esc_html_e( 'Status', 'majelis-fse' ); ?></label>
		<input type="text" name="status" />
		<?php wp_nonce_field( 'majelis_event_submit', 'majelis_event_nonce' ); ?>
		<button type="submit"><?php esc_html_e( 'Submit Event', 'majelis-fse' ); ?></button>
	</form>

	<h2><?php esc_html_e( 'My Events', 'majelis-fse' ); ?></h2>
	<ul class="majelis-my-events">
		<?php foreach ( $events as $event ) : ?>
			<li>
				<a href="<?php echo esc_url( get_permalink( $event ) ); ?>"><?php echo esc_html( get_the_title( $event ) ); ?></a>
				(<?php echo esc_html( ucfirst( $event->post_status ) ); ?>)
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
	return ob_get_clean();
}

function majelis_update_event_meta_from_request( $post_id ) {
	$fields = array(
		'start_datetime'    => sanitize_text_field( wp_unslash( $_POST['start_datetime'] ?? '' ) ),
		'end_datetime'      => sanitize_text_field( wp_unslash( $_POST['end_datetime'] ?? '' ) ),
		'attendance_mode'   => sanitize_text_field( wp_unslash( $_POST['attendance_mode'] ?? '' ) ),
		'venue'             => sanitize_text_field( wp_unslash( $_POST['venue'] ?? '' ) ),
		'address'           => sanitize_text_field( wp_unslash( $_POST['address'] ?? '' ) ),
		'lat'               => sanitize_text_field( wp_unslash( $_POST['lat'] ?? '' ) ),
		'lng'               => sanitize_text_field( wp_unslash( $_POST['lng'] ?? '' ) ),
		'google_maps_url'   => esc_url_raw( wp_unslash( $_POST['google_maps_url'] ?? '' ) ),
		'organizer_contact' => sanitize_text_field( wp_unslash( $_POST['organizer_contact'] ?? '' ) ),
		'registration_url'  => esc_url_raw( wp_unslash( $_POST['registration_url'] ?? '' ) ),
		'status'            => sanitize_text_field( wp_unslash( $_POST['status'] ?? '' ) ),
	);

	foreach ( $fields as $key => $value ) {
		if ( '' !== $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}
}

function majelis_google_calendar_url( $post_id, $start, $end, $description, $address ) {
	$title = rawurlencode( get_the_title( $post_id ) );

	$start_ts = $start ? strtotime( $start ) : null;
	$end_ts   = $end ? strtotime( $end ) : $start_ts;

	$start_out = $start_ts ? gmdate( 'Ymd\THis\Z', $start_ts ) : '';
	$end_out   = $end_ts ? gmdate( 'Ymd\THis\Z', $end_ts ) : $start_out;
	$dates     = rawurlencode( $start_out . '/' . $end_out );

	$desc = rawurlencode( $description );
	$loc  = rawurlencode( $address );

	return sprintf(
		'https://calendar.google.com/calendar/render?action=TEMPLATE&text=%s&dates=%s&details=%s&location=%s&trp=false',
		$title,
		$dates,
		$desc,
		$loc
	);
}
