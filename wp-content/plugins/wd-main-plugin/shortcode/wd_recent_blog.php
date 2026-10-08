<?php
function wd_recent_blog($atts)
{

  extract(shortcode_atts(array(
    'itemperpage' => '3',
    'blog_style' => 'style2',
    'columns' => '3',
    'show_pagination' => ''
  ), $atts));

  ob_start();
  $i = 0;

  if ($blog_style == 'style1') {
    ?>
    <div class="view view-blog view-id-blog">
      <div class="view-content">
        <div style="padding: 0px;" class="unique-d squares">
          <div class='row unique-d squares'>
            <?php

            if (!empty($show_pagination)) {
              $show_pagination = false;
            } else {
              $show_pagination = true;
            };

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $loop = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $itemperpage, 'paged' => $paged, 'no_found_rows' => $show_pagination));
            while ($loop->have_posts()) : $loop->the_post();
              $i++;
              $content = get_the_content();
              if ($i == 1) {
                ?>
                <div style="padding: 0px; height: 486px;" class="large-4 columns  square-row square-bottom  color-4">
                  <div class="square-txt color-4">
                    <span class="arrow">&nbsp;</span>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                    <div class="post_text"><p><?php echo substr($content, 0, 200); ?></p></div>
                    <div class="post-read-more right"><a href="<?php the_permalink(); ?>">Read more</a></div>
                  </div>
                  <div class="square-img"><i class="fa fa-plus"></i><a href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail('voip_recent-blog-v'); ?>
                    </a></div>
                </div>
              <?php } else { ?>
                <div style="padding: 0px;" class="large-8 columns  p-0 m-0">
                  <?php if ($i == 2) { ?>
                    <div style="min-height: 243px;" class="row square-row square-left color-5">
                      <div class="square-txt color-5" style="left: 0px;">
                        <span class="arrow" style="right: -20px; border-left-width: 20px; border-right-width: 0px;">&nbsp;</span>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                        <div class="post_text"><p><?php echo substr($content, 0, 200); ?></p></div>
                        <div class="post-read-more right"><a href="<?php the_permalink(); ?>">Read more</a></div>
                      </div>
                      <div class="square-img" style="right: 0px;"><i class="fa fa-plus"></i><a
                          href="<?php the_permalink(); ?>">
                          <?php the_post_thumbnail('voip_recent-blog-h'); ?></a></div>
                    </div>
                  <?php } else if ($i == 3) { ?>
                    <div style="min-height: 243px;" class="row square-row square-right color-3">
                      <div class="square-img" style="left: 0px;"><i class="fa fa-plus"></i><a
                          href="<?php the_permalink(); ?>">
                          <?php the_post_thumbnail('voip_recent-blog-h'); ?></a></div>
                      <div class="square-txt color-3" style="right: 0px;">
                        <span class="arrow" style="right: 312px; border-right-width: 20px; border-left-width: 0px;">&nbsp;</span>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                        <div class="post_text"><p><?php echo substr($content, 0, 200); ?></p></div>
                        <div class="post-read-more right"><a href="<?php the_permalink(); ?>">Read more</a></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            <?php endwhile;
            ?>

          </div>
        </div>
      </div>
      <?php
      if (function_exists('voip_pagination')) {
        voip_pagination($loop->max_num_pages, "", $paged);
      }
      ?>
    </div>
  <?php } else { ?>

    <ul class='simple-blog small-block-grid-1 large-block-grid-<?php echo $columns; ?>'>
      <?php

      if (!empty($show_pagination)) {
        $show_pagination = false;
      } else {
        $show_pagination = true;
      };

      $paged = get_query_var('paged') ? get_query_var('paged') : 1;
      $loop = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $itemperpage, 'paged' => $paged, 'no_found_rows' => $show_pagination));

      while ($loop->have_posts()) : $loop->the_post(); ?>

        <li>
          <div class="wd-blog-post">
            <?php the_post_thumbnail('voip_650x350') ?>
            <div class="wd-blog-post-detail">
              <div class="wd-blog-detail">
                <span><?php echo get_the_date('M, d, Y') ?></span> -
                <span><?php the_author() ?></span> -
                <span><?php the_category(' - ') ?></span>
              </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p>
                <?php echo wp_trim_words(get_the_content(), 25); ?>
              </p>
              <a href="<?php the_permalink() ?>" class='tiny button'>Read More </a>
            </div>
          </div>
        </li>

      <?php endwhile; ?>
    </ul>

    <?php
    if (function_exists('voip_pagination')) {
      voip_pagination($loop->max_num_pages, "", $paged);
    }

  } ?>
  <?php return ob_get_clean();

}

add_shortcode('wd_blog', 'wd_recent_blog'); ?>