<?php
$section_options = get_field('section_options') ?: [];

// Section options are cloned seamlessly on column blocks, so values may be stored flat.
$padding_top             = $section_options['padding_top']          ?? get_field('padding_top');
$padding_bottom          = $section_options['padding_bottom']       ?? get_field('padding_bottom');
$background_colour       = $section_options['background_colour']    ?? get_field('background_colour');
$background_image        = $section_options['background_image']     ?? get_field('background_image');
$background_image_mobile = $section_options['background_image_mobile'] ?? get_field('background_image_mobile');
$background_position     = $section_options['background_position'] ?? get_field('background_position');
$background_size         = $section_options['background_size']    ?? get_field('background_size');
$text_colour             = $section_options['text_colour']        ?? get_field('text_colour');
$column_border_radius    = $section_options['column_border_radius'] ?? get_field('column_border_radius');
?>
