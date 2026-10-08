<?php
/**
 * The template for displaying search forms in VOIP
 *
 */
 if(is_404()) {
 	?>
 	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="serch" method="get">
					   <input type="text" class="text-input" id="s" name="s" value="<?php echo esc_attr__('Type & hit enter...', 'voip'); ?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Type & hit enter...';}">
					   <input  type="submit" class="submit-input" value="<?php echo esc_attr__('Search', 'voip'); ?>">
				    </form>
 	
 	<?php
 }else {
 	

?>

<form action="<?php echo esc_url( home_url( '/' ) ) ?>" class="searchform" id="searchform" method="get" role="search">
	<div>
		<input type="text" id="s" name="s" value="" placeholder="<?php echo esc_attr__('Search...','voip') ?>">
		<button type="submit" value="Search" id="searchsubmit"> <i class="fa fa-search" aria-hidden="true"></i> </button>
	</div>
</form>
<?php
}
