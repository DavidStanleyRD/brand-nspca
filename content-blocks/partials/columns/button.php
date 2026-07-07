<?php if(have_rows('buttons')):?>
	<?php while(have_rows('buttons')):the_row();?>
		<?php 	$button = get_sub_field('button');
				$button_style = get_sub_field('button_style');
				$background_colour = get_sub_field('background_colour');
				$text_colour = get_sub_field('text_colour');
				$icon_style = get_sub_field('icon_style');
				
				// Handle both array and string returns from ACF link field
				if (is_array($button)) {
					$button_url = $button['url'] ?? '';
					$button_title = $button['title'] ?? '';
					$button_target = $button['target'] ?? '_self';
				} else {
					// If it's a string, use it as the URL
					$button_url = $button;
					$button_title = get_sub_field('button_text') ?: 'Click here';
					$button_target = '_self';
				}
				?>

	<div class="btn-wrapper pad-top-md">
		<?php if($button_url):?>
		<a href="<?php echo esc_url( $button_url ); ?>" class="btn <?= $button_style;?> <?= $icon_style;?>" style="<?php if($background_colour):?>background-color: <?= $background_colour;?>;<?php endif;?><?php if($text_colour):?> color: <?= $text_colour;?>;<?php endif;?>" target="<?php echo esc_attr( $button_target ); ?>">
			<?php echo esc_html( $button_title ); ?>
		</a>
		<?php endif;?>
	</div>

	<?php endwhile;?>
<?php endif;?>

