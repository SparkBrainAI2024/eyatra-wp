<?php
/*
Template Name: right sidebar
*/
?>
<?php get_header();
if(get_post_meta(get_the_ID(), 'wd_page_show_title_area', true) == 'yes') {
?>
	<section class="titlebar ">
					<div class="row" style="min-height: 200px;padding-top: 40px;">
						<div class="" style="float:right;">
							<?php voip_breadcrumb(); ?>
						</div>
						<div>
							<h1 id="page-title" class="title"><?php the_title(); ?></h1>
						</div>
					</div>
				</section>
<?php } ?>
<!-- content  -->
			<main class="row l-main">
				<div class="large-9 main columns">

			<!-- loop ... -->				
					<?php if (have_posts()) : ?>
               <?php while (have_posts()) : the_post(); ?>    
     
					<article>
						<div class="body field">
							<?php the_content(); ?>
						</div>
					</article>
     <?php endwhile; 
endif;
     ?>

<?php if (comments_open()){
                  comments_template( '', true ); 
                } ?>
							
<!-- /loop.. ********-->

				</div>
<?php get_sidebar(); ?>
			</main>
			<!-- /content  -->
			<?php get_footer(); ?>