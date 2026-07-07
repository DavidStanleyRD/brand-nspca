<?php
/**
 * The template for displaying standard pages
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
<?php if ( post_password_required() ) : ?>
	<!-- Show default WordPress password form if page is password protected -->
	<?php echo get_the_password_form(); ?>
<?php else : ?>
	<div class="page_builder">

		<?php the_content(); ?>

	</div>
<?php endif; ?>

				
<?php			
// End the loop.
endwhile;
?>


<?php get_footer(); ?>