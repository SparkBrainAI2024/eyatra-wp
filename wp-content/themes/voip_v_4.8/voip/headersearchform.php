<?php 
 /**
 * The template for displaying search forms in header VOIP
 *
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ) ?>" class="searchform" id="searchform" method="get" role="search">

   <div>
       <input type="text" id="s" name="s" class="hide" placeholder="<?php echo esc_attr__('Search...','voip') ?>">
       <a href="#"> <i class="fa fa-search" aria-hidden="true"></i></a>
   </div>
 </form>
                    