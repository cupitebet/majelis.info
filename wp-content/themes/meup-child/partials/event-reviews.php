<?php
/**
 * Event Reviews Component (Goers-inspired)
 *
 * Display reviews and rating form for event
 * Usage: include this file in single-mep_events.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$event_id = get_the_ID();
$average_rating = get_post_meta( $event_id, '_event_rating_average', true );
$rating_count = get_post_meta( $event_id, '_event_rating_count', true );

// Get published reviews
$reviews = get_posts( array(
    'post_type'      => 'event_review',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array(
            'key'   => '_event_id',
            'value' => $event_id,
        ),
    ),
));
?>

<section class="event-reviews-section" style="background: white; border-radius: 16px; padding: 35px; margin-bottom: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">

    <h2 style="color: #1E3A8A; font-size: 1.8em; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
        <span>⭐</span> Rating & Review
    </h2>

    <!-- Rating Summary -->
    <?php if ( $rating_count > 0 ) : ?>
    <div style="background: #f8fafc; padding: 30px; border-radius: 12px; margin-bottom: 30px; display: flex; gap: 40px; align-items: center; flex-wrap: wrap;">
        <div style="text-align: center;">
            <div style="font-size: 4em; font-weight: 800; color: #1E3A8A; margin-bottom: 10px;">
                <?php echo number_format( $average_rating, 1 ); ?>
            </div>
            <div style="display: flex; gap: 4px; justify-content: center; margin-bottom: 10px; font-size: 1.5em;">
                <?php
                $full_stars = floor( $average_rating );
                $half_star = ( $average_rating - $full_stars ) >= 0.5;
                for ( $i = 0; $i < 5; $i++ ) {
                    if ( $i < $full_stars ) {
                        echo '⭐';
                    } elseif ( $i == $full_stars && $half_star ) {
                        echo '⭐';
                    } else {
                        echo '☆';
                    }
                }
                ?>
            </div>
            <div style="color: #64748b; font-size: 0.95em;">
                Dari <?php echo $rating_count; ?> review
            </div>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <?php
            // Count ratings by star
            $star_counts = array( 5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0 );
            foreach ( $reviews as $review ) {
                $rating = intval( get_post_meta( $review->ID, '_rating', true ) );
                if ( isset( $star_counts[ $rating ] ) ) {
                    $star_counts[ $rating ]++;
                }
            }

            foreach ( array( 5, 4, 3, 2, 1 ) as $star ) :
                $count = $star_counts[ $star ];
                $percentage = $rating_count > 0 ? ( $count / $rating_count ) * 100 : 0;
            ?>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <div style="width: 60px; color: #64748b; font-size: 0.9em;">
                    <?php echo $star; ?> ⭐
                </div>
                <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                    <div style="background: #fbbf24; height: 100%; width: <?php echo $percentage; ?>%; transition: width 0.3s;"></div>
                </div>
                <div style="width: 40px; color: #64748b; font-size: 0.9em; text-align: right;">
                    <?php echo $count; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else : ?>
    <div style="background: #f8fafc; padding: 30px; border-radius: 12px; margin-bottom: 30px; text-align: center;">
        <div style="font-size: 3em; margin-bottom: 15px;">⭐</div>
        <p style="color: #64748b; font-size: 1.05em;">Belum ada review. Jadilah yang pertama memberikan review untuk event ini!</p>
    </div>
    <?php endif; ?>

    <!-- Review List -->
    <?php if ( ! empty( $reviews ) ) : ?>
    <div style="margin-bottom: 40px;">
        <h3 style="color: #334155; font-size: 1.3em; margin-bottom: 20px;">
            Apa Kata Mereka
        </h3>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ( $reviews as $review ) :
                $reviewer_name = get_post_meta( $review->ID, '_reviewer_name', true );
                $rating = intval( get_post_meta( $review->ID, '_rating', true ) );
                $review_date = get_the_date( 'j M Y', $review->ID );
            ?>
            <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border-left: 4px solid #3b82f6;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <div style="font-weight: 700; color: #1E3A8A; margin-bottom: 5px;">
                            <?php echo esc_html( $reviewer_name ); ?>
                        </div>
                        <div style="display: flex; gap: 2px; font-size: 1.1em;">
                            <?php
                            for ( $i = 0; $i < 5; $i++ ) {
                                echo $i < $rating ? '⭐' : '☆';
                            }
                            ?>
                        </div>
                    </div>
                    <div style="color: #94a3b8; font-size: 0.9em;">
                        <?php echo $review_date; ?>
                    </div>
                </div>
                <p style="color: #334155; line-height: 1.7; margin: 0;">
                    <?php echo wp_kses_post( $review->post_content ); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Review Form -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); padding: 30px; border-radius: 16px; border: 2px solid #e2e8f0;">
        <h3 style="color: #1E3A8A; font-size: 1.4em; margin-bottom: 20px;">
            ✍️ Tulis Review Anda
        </h3>

        <form id="review-form" style="display: flex; flex-direction: column; gap: 20px;">
            <input type="hidden" name="event_id" value="<?php echo esc_attr( $event_id ); ?>">

            <!-- Rating Stars -->
            <div>
                <label style="display: block; font-weight: 600; color: #334155; margin-bottom: 10px;">
                    Rating <span style="color: #ef4444;">*</span>
                </label>
                <div class="star-rating" style="display: flex; gap: 8px; font-size: 2.5em; cursor: pointer;">
                    <span class="star" data-rating="1">☆</span>
                    <span class="star" data-rating="2">☆</span>
                    <span class="star" data-rating="3">☆</span>
                    <span class="star" data-rating="4">☆</span>
                    <span class="star" data-rating="5">☆</span>
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
                <small style="color: #64748b; display: block; margin-top: 8px;">Klik bintang untuk memberikan rating</small>
            </div>

            <!-- Review Text -->
            <div>
                <label for="review-text" style="display: block; font-weight: 600; color: #334155; margin-bottom: 10px;">
                    Review Anda <span style="color: #ef4444;">*</span>
                </label>
                <textarea name="review_text" id="review-text" rows="6" required minlength="50" maxlength="8000"
                          placeholder="Ceritakan pengalaman Anda mengikuti event ini (minimal 50 karakter, maksimal 8000 karakter)..."
                          style="width: 100%; padding: 15px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1em; font-family: inherit; resize: vertical;"></textarea>
                <small style="color: #64748b; display: block; margin-top: 8px;">
                    <span id="char-count">0</span> / 8000 karakter (minimal 50)
                </small>
            </div>

            <!-- Name -->
            <div>
                <label for="reviewer-name" style="display: block; font-weight: 600; color: #334155; margin-bottom: 10px;">
                    Nama Anda <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="reviewer_name" id="reviewer-name" required
                       placeholder="Masukkan nama Anda"
                       style="width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1em;">
            </div>

            <!-- Email -->
            <div>
                <label for="reviewer-email" style="display: block; font-weight: 600; color: #334155; margin-bottom: 10px;">
                    Email Anda <span style="color: #ef4444;">*</span>
                </label>
                <input type="email" name="reviewer_email" id="reviewer-email" required
                       placeholder="email@example.com"
                       style="width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1em;">
                <small style="color: #64748b; display: block; margin-top: 8px;">
                    Email Anda tidak akan dipublikasikan
                </small>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 40px; border-radius: 50px; font-size: 1.1em; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                    📝 Kirim Review
                </button>
            </div>

            <!-- Message -->
            <div id="review-message" style="display: none; padding: 15px; border-radius: 12px;"></div>
        </form>
    </div>

</section>

<script>
jQuery(document).ready(function($) {
    // Star rating interaction
    let selectedRating = 0;

    $('.star').on('click', function() {
        selectedRating = $(this).data('rating');
        $('#rating-input').val(selectedRating);

        $('.star').each(function(index) {
            if (index < selectedRating) {
                $(this).text('⭐');
            } else {
                $(this).text('☆');
            }
        });
    });

    $('.star').on('mouseenter', function() {
        const hoverRating = $(this).data('rating');
        $('.star').each(function(index) {
            if (index < hoverRating) {
                $(this).text('⭐');
            } else {
                $(this).text('☆');
            }
        });
    });

    $('.star-rating').on('mouseleave', function() {
        $('.star').each(function(index) {
            if (index < selectedRating) {
                $(this).text('⭐');
            } else {
                $(this).text('☆');
            }
        });
    });

    // Character count
    $('#review-text').on('input', function() {
        const count = $(this).val().length;
        $('#char-count').text(count);

        if (count < 50) {
            $('#char-count').css('color', '#ef4444');
        } else {
            $('#char-count').css('color', '#10b981');
        }
    });

    // Form submission
    $('#review-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        const $message = $('#review-message');

        // Validate rating
        if (!selectedRating) {
            $message.show().css({
                'background': '#fee2e2',
                'color': '#991b1b',
                'border-left': '4px solid #ef4444'
            }).text('Silakan pilih rating terlebih dahulu!');
            return;
        }

        // Disable button
        $button.prop('disabled', true).text('⏳ Mengirim...');
        $message.hide();

        // Submit via AJAX
        $.ajax({
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            type: 'POST',
            data: {
                action: 'submit_review',
                nonce: '<?php echo wp_create_nonce( 'submit_review' ); ?>',
                event_id: $form.find('[name="event_id"]').val(),
                rating: selectedRating,
                review_text: $form.find('[name="review_text"]').val(),
                reviewer_name: $form.find('[name="reviewer_name"]').val(),
                reviewer_email: $form.find('[name="reviewer_email"]').val()
            },
            success: function(response) {
                if (response.success) {
                    $message.show().css({
                        'background': '#d1fae5',
                        'color': '#065f46',
                        'border-left': '4px solid #10b981'
                    }).html('✅ ' + response.data.message);

                    // Reset form
                    $form[0].reset();
                    selectedRating = 0;
                    $('.star').text('☆');
                    $('#char-count').text('0').css('color', '#64748b');

                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: $message.offset().top - 100
                    }, 500);
                } else {
                    $message.show().css({
                        'background': '#fee2e2',
                        'color': '#991b1b',
                        'border-left': '4px solid #ef4444'
                    }).html('❌ ' + response.data.message);
                }
            },
            error: function() {
                $message.show().css({
                    'background': '#fee2e2',
                    'color': '#991b1b',
                    'border-left': '4px solid #ef4444'
                }).text('❌ Terjadi kesalahan. Silakan coba lagi.');
            },
            complete: function() {
                $button.prop('disabled', false).text('📝 Kirim Review');
            }
        });
    });
});
</script>

<style>
.star {
    transition: transform 0.1s;
}

.star:hover {
    transform: scale(1.2);
}

#review-form button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

#review-form button[type="submit"]:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
