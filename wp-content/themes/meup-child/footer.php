<?php
/**
 * Child theme footer override
 *
 * This file attempts to load the parent's `footer.php`, capture its output,
 * strip any mentions or links to "ovatheme", and then echo the cleaned markup.
 * If the parent footer is not available in the environment, a minimal fallback
 * footer is printed instead.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Try to locate parent's footer.php without loading it automatically
$parent_path = locate_template( 'footer.php', false, false );

if ( $parent_path && file_exists( $parent_path ) ) {
    // Capture parent footer output
    ob_start();
    include $parent_path;
    $parent_footer = ob_get_clean();

    // Defensive removal of OvaTheme mentions and links
    // Remove anchor tags that contain 'ovatheme' in href
    $parent_footer = preg_replace('#<a[^>]+ovatheme[^>]*>.*?</a>#is', '', $parent_footer);
    // Remove textual mentions like 'Design by OvaTheme' (case-insensitive)
    $parent_footer = preg_replace('/Design(ed)?\s*(and|&)\s*Develop(ed)?\s*by\s*OvaTheme/i', '', $parent_footer);

    // If you want to replace with custom credit, uncomment and adjust below:
    // $custom_credit = '<div class="meup-child-credit">&copy; ' . date('Y') . ' ' . esc_html( get_bloginfo('name') ) . '</div>';
    // $parent_footer = preg_replace('/<div[^>]*class=["\']?site-info["\']?[^>]*>.*?<\/div>/is', $custom_credit, $parent_footer);

    echo $parent_footer;
    return;
}

// Fallback minimal footer when parent footer.php is not present in repository/runtime
?>
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info" style="text-align:center;padding:12px 0;font-size:14px;color:#bfc7d6;">
        &copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;text-decoration:none;"><?php bloginfo( 'name' ); ?></a>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
