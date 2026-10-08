<article <?php post_class(); ?>>
    <div class="quote-format">
        <blockquote>
            <span class="leftq quotes">&ldquo;</span> <?php the_excerpt()  ?> <span class="rightq quotes">&bdquo; </span>
            <h2>-<?php the_title() ?></h2>
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
           
        </blockquote>
    </div>
</article>