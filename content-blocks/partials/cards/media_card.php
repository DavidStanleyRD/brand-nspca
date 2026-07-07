<?php

$media_type = get_sub_field('media_type');

if($media_type == 'image'):

	$image = get_sub_field('image');

elseif($media_type == 'inline-video'):
	$video = get_sub_field('video_url');
	$video_poster = get_sub_field('video_poster');
endif;

$text = get_sub_field('text');
$card_link = get_sub_field('card_link');
$media_border_radius = get_sub_field('media_border_radius');



?>

<div class="media-card">
	<?php if($card_link):?> <a class="media-card__link" href="<?= $card_link['url'];?>"> <?php endif;?>
	<div class="media-card__media" <?php if($media_border_radius):?> style="border-radius: <?= $media_border_radius;?>px;" <?php endif;?>>
		<?php if($media_type == 'image'):?>
		<?php if($image):?>

			<?= wp_get_attachment_image( $image['id'], 'full', '', array('loading' => 'lazy'));?>

		<?php endif;?>
		<?php elseif($media_type == 'inline-video'):?>
		<?php if($video):?>
			<video playsinline autoplay loop muted <?php if($video_poster):?> poster="<?php echo $video_poster['url'];?>" <?php endif;?>>
					<source src="<?php echo $video;?>" format="video/mp4" />
			</video>
		<?php endif;?>
	<?php endif;?>
	</div>
	<div class="media-card__text">
		<?= $text;?>
	</div>
	<?php if($card_link):?> </a> <?php endif;?>
</div>