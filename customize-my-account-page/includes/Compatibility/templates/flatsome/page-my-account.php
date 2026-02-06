<?php
/**
 * Template name: WooCommerce - My Account for Flatsome.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
$tgwc_flatsome_before_page = 'flatsome_before_page';
$tgwc_flatsome_after_page	   = 'flatsome_after_page';
?>

<?php do_action( $tgwc_flatsome_before_page ); ?>

<?php wc_get_template( 'myaccount/header.php' ); ?>

<div class="page-wrapper my-account mb">
	<div class="container" role="main">
		<?php
		while ( have_posts() ) {
			the_post();
			the_content();
		}
		?>
	</div>
</div>

<?php do_action( $tgwc_flatsome_after_page ); ?>

<?php get_footer(); ?>
