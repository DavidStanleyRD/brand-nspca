<?php

$image = get_sub_field('image');
$text = get_sub_field('text');
$card_border_radius = get_sub_field('card_border_radius');
$card_background_colour = get_sub_field('card_background_colour');
$card_text_colour = get_sub_field('card_text_colour');
$card_link = get_sub_field('card_link');

$inline_style = '';
if($card_background_colour) $inline_style .= 'background-color: ' . $card_background_colour . '; ';
if($card_text_colour) $inline_style .= 'color: ' . $card_text_colour . '; ';
if($card_border_radius) $inline_style .= 'border-radius: ' . $card_border_radius . 'px;';

?>

<?php if($card_link):?>
<a class="general-card<?= $card_link ? ' general-card--linked' : '';?>" href="<?= esc_url($card_link['url']);?>" <?php if($card_link['target']):?> target="<?= esc_attr($card_link['target']);?>"<?php endif;?><?= $inline_style ? ' style="' . esc_attr($inline_style) . '"' : '';?>>
<?php else:?>
<div class="general-card"<?= $inline_style ? ' style="' . esc_attr($inline_style) . '"' : '';?>>
<?php endif;?>

	<?php if($image):?>
		<div class="general-card__image">
			<?= wp_get_attachment_image( $image['id'], 'full', '', array('loading' => 'lazy'));?>
		</div>
	<?php endif;?>
	<?php if($text):?>
		<div class="general-card__text">
			<?= $text; ?>
		</div>
	<?php endif;?>

<?php if($card_link):?>
</a>
<?php else:?>
</div>
<?php endif;?>
