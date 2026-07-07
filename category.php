<?php
/**
 * The template for displaying category pages
 *
 */
?>
<?php get_header(); ?>

	
<!-- -------------------------------------------------------------------------------------------------- -->
<!-- // Section																	  -->
<!-- -------------------------------------------------------------------------------------------------- -->		
<section class="section pad-top-xlg m-bottom-xlg">
	
	<div class="max-width-container">
		<div class="row">
				<div class="col-sm-12">
					
				<?php
				$count = 0;
				// Start the loop.
				while ( have_posts() ) : the_post();
				?>

										
							<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="btn">Read more</a>

					
				<?php			
				// End the loop.
				endwhile;
				?>
				
				</div>
		</div>
	</div><!--/.max-width-container-->
	
</section>


<?php get_footer(); ?>