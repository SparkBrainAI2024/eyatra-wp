<?php
/**
 * The sidebar containing the main widget area
 *
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<aside class="large-4 sidebar-second columns sidebar" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>