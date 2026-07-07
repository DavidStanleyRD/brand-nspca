<?php
/**
 * Template Name: Homepage
 *
 */
?>

<?php get_header(); ?>

<?php
// Start the loop.
while ( have_posts() ) : the_post();
?>



<!-- ------------------------------------------------------------------------------------- -->
<!-- Flexible Content Blocks																															 -->
<!-- ------------------------------------------------------------------------------------- -->
<div class="page_builder">

	<?php the_content(); ?>

</div>


				
<?php			
// End the loop.
endwhile;
?>
			

<?php get_footer('with-footer'); ?>