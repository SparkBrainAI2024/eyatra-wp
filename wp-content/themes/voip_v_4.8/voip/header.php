<!doctype html>
<!--[if IE 9]>
<html class="lt-ie10" lang="en"> <![endif]-->
<html class="no-js" <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php if (!function_exists('has_site_icon')) {
		if (voip_get_option('wd_favicon', '') != '') { ?>
			<link rel="shortcut icon" href="<?php echo esc_url(voip_get_option('wd_favicon')); ?>"/>
		<?php }
	} ?>
	<?php wp_head() ?>
</head>
<body <?php body_class(); ?>>

<!-- offcanvas start -->
<?php
$menu_style = isset($_GET['menustyle']) ? $_GET['menustyle'] : voip_get_option('wd_menu_style', 'creative');


if (voip_get_option('wd_box_wrapper') == 'on') { ?>
	<img src="<?php echo esc_url(voip_get_option('wd_home_page')) ?>" class="bg_image_body"
	     alt="<?php echo esc_attr__('body background', 'voip') ?>">
<?php }

$boxed_class = '';
if (voip_get_option('wd_box_wrapper') == 'on') {
	$boxed_class = 'wd_wrapper';
} ?>

<?php if (voip_get_option('wd_show_top_social_bare', '') == 'on') { ?>
	<div class="top_address_bar">
		<ul class="inline-list">
			<?php if (voip_get_option('phone')) { ?>
				<li><?php echo esc_html(voip_get_option('phone')); ?></li>
			<?php } ?>
			<?php if (voip_get_option('adress')) { ?>
				<li><?php echo esc_html(voip_get_option('adress')); ?></li>
			<?php } ?>
			<?php if (voip_get_option('time')) { ?>
				<li><?php echo esc_html(voip_get_option('time')); ?></li>
			<?php } ?>
		</ul>
		<ul class="social-icons accent inline-list right">
			<?php if (voip_get_option('flickr') != ""): ?>
				<li class="flickr">
					<a href="<?php echo esc_url(voip_get_option('flickr')); ?>"><i class="fa fa-flickr"></i></a>
				</li>
			<?php endif ?>
			<?php if (voip_get_option('facebook') != ""): ?>
				<li class="facebook">
					<a href="<?php echo esc_url(voip_get_option('facebook')); ?>"><i class="fa fa-facebook"></i></a>
				</li>
			<?php endif ?>
			<?php if (voip_get_option('twitter') != ""): ?>
				<li class="twitter">
					<a href="<?php echo esc_url(voip_get_option('twitter')); ?>"><i class="fa fa-twitter"></i></a>
				</li>
			<?php endif ?>
			<?php if (voip_get_option('vimeo') != ""): ?>
				<li class="vimeo">
					<a href="<?php echo esc_url(voip_get_option('vimeo')); ?>"><i class="fa fa-vimeo-square"></i></a>
				</li>
			<?php endif ?>
		</ul>
	</div>
<?php } ?>
<header class="l-header <?php echo esc_attr($menu_style); ?>-layout">

	<div class="
          <?php if (voip_get_option('wd_menu_in_grid') == 'on') echo "contain-to-grid"; ?>
          <?php if (voip_get_option('wd_menu_sticky') != 'off') echo "sticky"; ?> ">
		<nav class="top-bar" data-topbar>
			<div class="page-section home-page large-1 columns" id="page-content">
				<ul class="title-area <?php if (voip_get_option('wd_show_title', '') == 'on') echo "title-displayed"; ?>">

					<li class="name">
						<?php
						$voip_logo_path = get_template_directory_uri() . "/images/logogvoip.png";
						$voip_logo = voip_get_option('wd_logo', $voip_logo_path);

						if (voip_get_option('wd_show_logo', 'off') == 'on' && voip_get_option('wd_logo', $voip_logo_path) != ''): ?>
							<?php $image = voip_get_option('wd_logo', $voip_logo);
							?>
							<h1><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" title="<?php echo bloginfo('name') ?>"
							       class="active"><img src="<?php echo esc_url($image); ?>"
							                           alt="<?php esc_attr__('logo', 'voip') ?>"/></a></h1>
						<?php endif; ?>
						<?php if (voip_get_option('wd_show_title', 'on') == 'on'):  
							?>
							<a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><h2><?php echo bloginfo('name') ?></h2>
							</a>
						<?php endif ?>
					</li>
					<?php if ($menu_style != "offcanvas" && $menu_style != "modern") { ?>
						<li class="toggle-topbar menu-icon">
							<a href="#"><span><?php echo esc_html__('Menu', 'voip'); ?></span></a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<section class="<?php echo esc_attr($menu_style); ?> top-bar-section large-9 columns">
				<?php


				if ($menu_style == "corporate") {

					$defaults = array(
						'theme_location' => 'primary',
						'menu' => '',
						'container' => 'div',
						'container_class' => 'menu-menu-container',
						'container_id' => '',
						'menu_class' => 'menu',
						'menu_id' => 'menu-menu',
						'echo' => true,
						'fallback_cb' => 'voip_main_menu_fallback',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',

						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth' => 0,
						'walker' => new voip_top_bar_walker,

					);

					wp_nav_menu($defaults);

					?>

				<?php } elseif ($menu_style == "creative") { ?>
					<?php
					$defaults = array(
						'theme_location' => 'primary',
						'menu' => '',
						'container' => 'div',
						'container_class' => '',
						'container_id' => '',
						'menu_class' => 'menu right',
						'menu_id' => '',
						'echo' => true,
						'fallback_cb' => 'voip_main_menu_fallback',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth' => 0,
						'walker' => new voip_top_bar_walker,
					);

					wp_nav_menu($defaults);

					?>

				<?php } ?>


			</section>
			<?php if ($menu_style == "creative") { ?>
				<section class="<?php echo esc_attr($menu_style); ?> log_menu  top-bar-section large-1 columns">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'login-menu',
						'container' => 'div',
						'menu_class' => 'menu right',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker' => new voip_top_bar_walker,

					)); ?>


				</section>
			<?php } ?>
			<!--<section class="large-1 columns search-section hide-for-small-only">
				<?php get_template_part('headersearchform'); ?>
				<?php
				if (function_exists('WC')) {
					?>
					<div class="show-cart-btn hide-for-small-only">

						<div class="hidden-cart" style="display: none;">
							<?php the_widget('WC_Widget_Cart');

							?>
						</div>
					</div>
				<?php } ?>
			</section>-->
		</nav>
	</div>
	<!--/.top-Menu -->
</header>