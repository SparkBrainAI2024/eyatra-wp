<article>
  <div>
    <?php the_post_thumbnail('voip_blog-thumb'); ?>
  </div>
  <h2 class="node-title" datatype="" property="dc:title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
  <header>
    <ul class="post-infos clearfix">
      <li><?php echo get_the_date('d-m-y'); ?></li>
      <li><?php echo esc_html__('By: ','voip');  the_author() ?></li>
      <li>
        <?php echo esc_html__('Category: ','voip');    the_category(', '); ?>
      </li>
      <li class="comment-count"><?php comments_number( '0', '1', '% responses' ); echo esc_html__(' comment', 'voip') ?></li>
    </ul>
  </header>
  <div class="body text-secondary">
    <p><?php echo wp_trim_words(get_the_content(),60); ?></p>
  </div>
  <div class="read-more button"><a href="<?php esc_url(the_permalink()); ?>"><?php echo esc_html__('Read More', 'voip'); ?></a></div>
</article>