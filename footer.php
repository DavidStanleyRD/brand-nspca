<?php
/**
 * The template for displaying the footer
 *
 */
?>
   
<?php $footer_bg = get_field('footer_background_colour', 'options');
	  $footer_text = get_field('footer_text_colour', 'options');
	  $footer_tagline = get_field('footer_tagline', 'options');
	  $website_link = get_field('website_link', 'options');
	  $footer_logo = get_field('footer_logo', 'options');
	  $footer_hover = get_field('footer_menu_hover_colour', 'options');
	  $lower_footer = get_field('lower_footer', 'options');
	  $lower_footer_copy = $lower_footer['lower_footer_copy'];
	  ?>

<style type="text/css">
	footer a {
		color: <?php echo $footer_text;?>;
	}
	footer a:hover {
		color: <?php echo $footer_hover;?>;
	}
</style>

<footer class="pad-top-lg pad-bottom-lg" style="background: <?php echo $footer_bg;?>; color: <?php echo $footer_text;?>;">
	<div class="wrapper">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<?php if($footer_tagline):?>
					
					<h3><b><?php echo $footer_tagline;?></b></h3>
				<?php endif;?>
				<?php if($website_link):?>
					<a class="website-link" href="<?php echo $website_link['url'];?>" ?> <?php echo $website_link['title'];?> </a>
				<?php endif;?>
			</div>
			<div class="col-xs-6 col-sm-3">
				<?php 
					// $defaults = array('menu' => 'Footer Menu', 'container' => '', 'items_wrap' => '<ul>%3$s</ul>');
					// echo wp_nav_menu( $defaults ); 
				?>
			</div>
			<div class="col-xs-12 col sm-6 col-md-3 col-md-offset-3">
				<?php if($footer_logo):?>
					<img class="footer-logo" src="<?php echo $footer_logo['url'];?>" alt="<?php echo $footer_logo['title'];?>" />
				<?php endif;?>
			</div>
		</div>
	</div>
</footer>
<div class="lower-footer">
	<div class="wrapper">
		<div class="row pad-top-sm pad-bottom-xl">
			<div class="col-xs-12">
				<div class="lower-footer-inner">
					<a href="https://reddog.ie"><?php echo $lower_footer_copy;?> © Red Dog, <?php echo date('Y');?></a>
					<img src="<?php echo get_template_directory_uri();?>/src/images/rd-logo.svg" />
				</div>
			</div>
		</div>
	</div>
</div>


<?php wp_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js" integrity="sha512-jEnuDt6jfecCjthQAJ+ed0MTVA++5ZKmlUcmDGBv2vUI/REn6FuIdixLNnQT+vKusE2hhTk2is3cFvv5wA+Sgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html> 
