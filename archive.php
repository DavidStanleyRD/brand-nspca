<?php
/**
 * The template for displaying archive pages
 *
 */
?>
<?php get_header(); ?>



<!-- -------------------------------------------------------------------------------------------------- -->
<!-- // Articles Listing																		  -->
<!-- -------------------------------------------------------------------------------------------------- -->		

<section class="section-featured-articles pad-top-md pad-bottom-lg">
					
	<div class="max-width-container">			
		
		<?php if ( have_posts() ) : ?>
			
			<div class="row">
		
				<?php		
					$count = 0;
					while ( have_posts() ) : the_post();

					$categories = get_the_category();

					$count++;
				  setup_postdata( $post ); ?>	


						<div class="col-md-4">		
							<article>
								
							
								<a href="<?php the_permalink(); ?>">
									<h3><?php the_title(); ?></h3>
								</a>
							
								<?php $post_thumbnail_id = get_post_thumbnail_id( $post ); ?>
								<?php $thumbnail_url = get_the_post_thumbnail_url( $post->ID, "medium_large"); ?>
								
								<img src="<?php echo $thumbnail_url; ?>" />
							</article>
						</div><!--/.col-md-4-->
						
						
					<?php
					endwhile;
					?>
		

			</div><!--/.row-->
					
			<div class="row">
				<div class="col-sm-12 center pad-top-sm">
					<a href="#" class="btn">Load More</a>
				</div>
			</div>

			<?php endif; ?>
					
			<?php wp_reset_postdata(); ?>
			
			
			

	</div><!--.max-width-container-->
	
</section>
	  	
	  	

<?php get_footer(); ?>