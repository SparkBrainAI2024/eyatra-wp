<?php function voip_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>">
      <header class="comment-author clearfix">
        <?php echo get_avatar($comment,$size='48'); ?>
        <div class="author-meta">
          <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?>
          <time datetime="<?php echo comment_date('c') ?>"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s', 'voip'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(esc_html__('(Edit)', 'voip'), '', '') ?>
        </div>
      </header>
      
      <?php if ($comment->comment_approved == '0') : ?>
            <div class="notice alert-box">
              <p class="bottom"><?php esc_html_e('Your comment is awaiting moderation.', 'voip') ?></p>
            </div>
      <?php endif; ?>
      
      <section class="comment clearfix">
        <?php comment_text() ?>
        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </section>

    </article>
<?php } ?>

<?php
  if ( post_password_required() ) { ?>
  <section id="comments">
    <div class="notice alert-box">
      <p class="bottom"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'voip'); ?></p>
    </div>
  </section>
  <?php
    return;
  }
?>
<?php // You can start editing here. Customize the respond form below ?>
<?php if ( have_comments() ) : ?>
  <section id="comments">
    <h3><?php comments_number(esc_html__('No Responses to', 'voip'), esc_html__('One Response to', 'voip'), esc_html__('% Responses to', 'voip') ); ?> &#8220;<?php the_title(); ?>&#8221;</h3>
    <ol class="commentlist">
    <?php wp_list_comments('type=comment&callback=voip_comments'); ?>
    
    </ol>
    <footer>
      <nav id="comments-nav">
        <div class="comments-previous"><?php previous_comments_link( esc_html__( '&larr; Older comments', 'voip' ) ); ?></div>
        <div class="comments-next"><?php next_comments_link( esc_html__( 'Newer comments &rarr;', 'voip' ) ); ?></div>
      </nav>
    </footer>
  </section>
<?php else : // this is displayed if there are no comments so far ?>
  <?php if ( comments_open() ) : ?>
  <?php else : // comments are closed ?>
  <section id="comments">
    <div class="notice alert-box">
      <p class="bottom"><?php esc_html_e('Comments are closed.', 'voip') ?></p>
    </div>
  </section>
  <?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
  <?php
  $fields =  array(

    'author' =>
      '<div class="large-4 columns pl0"><input type="text" placeholder="'. esc_attr__('Name','voip').'" required class="five" name="author" id="author" value="ccc" size="22" tabindex="1" >

    </div>',

    'email' =>
      '<div class="large-4 columns pl0"> <input type="text" placeholder="'. esc_attr__('E-mail','voip').'" required class="five" name="email" id="email" value="'. esc_attr($comment_author_email).'" size="22" tabindex="2" >

    </div>',

    'url' =>
      '<div class="large-4 columns pl0">  <input type="text" placeholder="'. esc_attr__('Sitweb','voip').'" required class="five" name="url" id="url" value="'. esc_attr($comment_author_url) .'" size="22" tabindex="3">

    </div>',
  );
  $args = array(
    'class_submit'      => 'small radius button',
    'label_submit'      => esc_html__( 'Post Comment','voip' ),
    'comment_notes_before' => '',
    'fields' => apply_filters( 'comment_form_default_fields', $fields ),
  );
  comment_form($args);

  ?>
<?php endif; // if you delete this the sky will fall on your head ?>