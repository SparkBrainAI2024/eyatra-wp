<?php get_header();

  if(!is_rtl()) : ?>
    <section class="titlebar ">
    	<div class="row">
    		<div class="large-8 columns">
    			<h1 id="page-title" class="title"><?php single_post_title(); ?></h1>
    		</div>
    		<div class="large-4 columns">
    			<?php voip_breadcrumb(); ?>
    		</div>
    	</div>
    </section>
    <!-- content  -->
    <main class="row l-main">
      <div class="large-8 main columns">
        <div class="blog-post">
          <!-- loop ... -->
          <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post();

              ?>
              <div <?php post_class(); ?>>
               
                  <div class="blog-posts">



                    <?php get_template_part('content', get_post_format()); ?>


                  </div>
                
              </div>
            <?php endwhile;
          endif;


          if (comments_open()) {
            comments_template('', true);
          }
          ?>
          <!-- /loop.. ********-->
        </div>
        <!-- Pagination -->
        <div class="wd-pagination">
          <?php echo paginate_links(); ?>
        </div>
        <!-- /Pagination -->
      </div>
      <?php get_sidebar(); ?>
    </main>
    <!-- /content  -->
  <?php else : ?>
    <section class="titlebar ">
					<div class="row">
						<div class="large-4 columns">
							<?php voip_breadcrumb(); ?>
						</div>
						
						<div class="large-8 columns">
							<h1 id="page-title" class="title"><?php the_title(); ?></h1>

						</div>
					</div>
				</section>
			<main class="row l-main">
				<div class="large-9 main columns">
					<div>						
      			<!-- loop ... -->				
            <?php if (have_posts()) : ?>
              <?php while (have_posts()) : the_post(); ?>    
                <div>
                	<div class="row">
                			<div class="blog-posts large-10 columns">
                				
                			<?php get_template_part('content', get_post_format()); ?>
                			
                		</div>
                		<div class="blog-info large-2 columns">
                			<div class="arrow"></div>
                			<br>
                			<br>
                			<div class="author">
                				<?php echo esc_html__('By', 'voip') ?>
                				<div>
                					<span rel="sioc:has_creator"><span  property="foaf:name"  class="username"><?php the_author(); ?></span></span>
                				</div>
                			</div>
                			<div class="date">
                			<?php echo get_the_date('d-m-y'); ?>
                			</div>
                			<div class="comment-count text-center">
                				<div>
                					<?php comments_number('0', '1', '% responses'); ?>
                				</div>
                				<?php echo esc_html__('comment', 'voip') ?>
                			</div>
                		</div>
                		
                	</div>
                </div>
              <?php endwhile;
					endif;
					
 			?>						
            <!-- /loop.. ********-->
            <?php
				if (comments_open()) {
					comments_template('', true);
				}
 				?>
					</div>
					<!-- Pagination -->
										<div class="wd-pagination">
											<?php echo paginate_links(); ?>
										</div>
										<!-- /Pagination -->
				</div>
        <?php get_sidebar(); ?>
      </main>
			<?php endif ?>
			<!-- /content  -->
			<?php get_footer(); ?>