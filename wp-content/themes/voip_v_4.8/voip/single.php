<?php get_header() ?>
	<section class="titlebar m-0">
		<div class="row">
			<div class="right">
				<?php voip_breadcrumb(); ?>
			</div>
			<div>
				<h1 id="page-title" class="title"><?php the_title(); ?></h1>
			</div>
		</div>
	</section>
<!-- content  -->
			<main class="row l-main">
				<div class="large-8 main columns">
					
					
					<!-- loop ... -->				
						<?php if (have_posts()) : ?>
               <?php while (have_posts()) : the_post(); ?>
									<div class="blog-posts">
									<article>
										<div class="field field-name-field-blog-image field-type-image field-label-hidden field-wrapper">
											<?php the_post_thumbnail('voip_blog-thumb'); ?>
										</div>
										<div class="body field">
											<?php the_content(); ?>
										</div>
										<div class="post-info"> 
				              <span class="post-date"><i class="fa-calendar fa"></i> <?php echo get_the_date(); ?></span>
				              <span class="post-author"><i class="fa-user fa"></i> <?php the_author() ?></span>

				              <?php if(has_tag()){ ?>
				                <span class="post-tags"><i class="fa-tag fa"></i> <?php the_tags() ?></span>
				              <?php } ?>

				              <?php if(has_category()){ ?>
				                <span class="post-categories"><i class="fa-folder fa"></i> <?php echo esc_html__( 'Categories:', 'voip' );  the_category(); ?></span>
				              <?php } ?>
				          </div>
				          <?php if (comments_open()){
                  comments_template( '', true ); 
                } ?>
									</article>
									</div>
						     <?php endwhile;
							endif;?>
							
						<!-- /loop.. ********-->
							<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'voip' ), 'after' => '</div>' ) ); ?>
						
					
				</div>
				<!--/.main region -->
				<!-- *************sidebar ***********-->
				<?php get_sidebar(); ?>
				<!-- *************/sidebar ***********-->
			</main>
			<!-- /content  -->
			<?php get_footer(); ?>