<?php



$image = get_sub_field('image');
$icon = get_sub_field('icon');
$text = get_sub_field('text');

$icon_do = get_field('icon_do', 'options');
$icon_dont = get_field('icon_dont', 'options');

$media_border_radius = get_sub_field('media_border_radius');


?>

<div class="usage-card">
	<div class="usage-card__media" <?php if($media_border_radius):?> style="border-radius: <?= $media_border_radius;?>px;" <?php endif;?>>

		<?php if($image):?>

			<?= wp_get_attachment_image( $image['id'], 'full', '', array('loading' => 'lazy'));?>

		<?php endif;?>


	</div>
	<div class="usage-card__icon">
		<?php if($icon == 'cross'):?>
			<?= wp_get_attachment_image( $icon_dont['id'], 'full', '', array('loading'=>'lazy'));?>
		<?php else:?>
			<?= wp_get_attachment_image( $icon_do['id'], 'full', '', array('loading'=>'lazy'));?>
		<?php endif;?>
	</div>

	<div class="usage-card__text">
		<?= $text;?>
	</div>
</div>