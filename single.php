<?php
/**
 * The template for displaying all single posts
 *
 */
 ?>							

<?php get_header(); ?>


<?php
// Start the loop.
while ( have_posts() ) : the_post();
?>




<!-- -------------------------------------------------------------------------------------------------- -->
<!-- // Main Content  -->
<!-- -------------------------------------------------------------------------------------------------- -->		
<section class="section-single pad-top-md m-bottom-md">
	
	<div class="max-width-container">	
		<div class="row">						
			
			<div class="col-sm-4">
				
				<div class="featured-image-wrapper">
					<?php the_post_thumbnail('medium_large'); ?>
				</div><!--/.icon-wrapper-->
				
				
			</div>
			<div class="col-sm-8">
				
				<div class="main-content-container">
					
					<?php the_content(); ?>
				
				</div><!--/.main-content-container-->

			</div>			
			
		</div><!--/.row-->		
		
	</div><!--/.container-->

</section><!--/.section-->
				
				

				
<?php			
// End the loop.
endwhile;
?>


<?php get_footer(); ?>