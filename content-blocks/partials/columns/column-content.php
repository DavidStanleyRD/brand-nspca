<?php if(have_rows('column_content')):?>
	<?php while(have_rows('column_content')):the_row();?>
		<?php if(get_row_layout() == 'text'):?>
			<?php include get_template_directory() . '/content-blocks/partials/columns/text.php'; ?>
		<?php elseif(get_row_layout() == 'media'):?>
			<?php include get_template_directory() . '/content-blocks/partials/columns/media.php'; ?>
		<?php elseif(get_row_layout() == 'button'):?>
			<?php include get_template_directory() . '/content-blocks/partials/columns/button.php'; ?>
		<?php elseif(get_row_layout() == 'accordion'):?>
			<?php include get_template_directory() . '/content-blocks/partials/columns/accordion.php'; ?>
		<?php elseif(get_row_layout() == 'media_card'):?>
			<?php include get_template_directory() . '/content-blocks/partials/cards/media_card.php'; ?>
		<?php elseif(get_row_layout() == 'usage_card'):?>
			<?php include get_template_directory() . '/content-blocks/partials/cards/usage_card.php'; ?>
		<?php elseif(get_row_layout() == 'general_card'):?>
			<?php include get_template_directory() . '/content-blocks/partials/cards/general_card.php'; ?>

		<?php endif;?>
	<?php endwhile;?>
<?php endif;?>

