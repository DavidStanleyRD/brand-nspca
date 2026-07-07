<?php
/**
 * The template for displaying 404 pages
 *
 */
 ?>
<?php get_header(); ?>

<?php
// Start the loop.
while ( have_posts() ) : the_post();
?>
		
<section class="section-404-not-found">
		
		<div class="max-width-container">
				

			<div class="row">			
				
				<div class="col-md-12">

					<h1>404: Page not Found</h1>
					<p>The page you are looking for could not be found!</p>
												
				</div><!--/col-md-12-->
				
			</div><!--/.row-->
			
		</div><!--/.container-->
		
</section>
				
<?php			
// End the loop.
endwhile;
?>
	  	

<?php get_footer(); ?>