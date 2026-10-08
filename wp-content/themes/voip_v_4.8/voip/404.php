<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js"  <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head() ?>
</head>
<?php if(voip_get_option('wd_box_wrapper')=='on') {$box='wd_wrapper';$body_bg='bg_body_color';}else{$box='';$body_bg='';} ?>

<body <?php body_class(); ?>>

  	<div class="corp">
		<div class="row">
			<section class="oops">
				<h2><?php echo esc_html__('Oops!!', 'voip'); ?></h2>
			</section>
			<section>
				<p class="message">
					<?php echo esc_html__('It looks like that page no longer exists. Would you like to go to ', 'voip'); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong><?php echo esc_html__('Home page', 'voip'); ?></strong></a>  <?php echo esc_html__('instead?', 'voip'); ?>
				</p>
			</section>
			<section class="large-6 columns">
				<?php get_search_form() ?>
			</section>
		</div>	
	</div>
	<div class="oops-footer">
		<ul class="social-icons accent inline-list">
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

	<?php wp_footer(); ?> 
</body>
</html>