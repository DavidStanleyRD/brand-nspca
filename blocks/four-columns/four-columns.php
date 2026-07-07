<?php include get_template_directory() . '/content-blocks/partials/block-section-options.php'; ?>

<?php
$randomString                         = generateRandomString();
$verticalAlignment                    = get_field('vertical_alignment');
$left_column_background_colour        = get_field('left_column_background_colour');
$left_column_text_colour              = get_field('left_column_text_colour');
$left_middle_column_background_colour = get_field('left_middle_column_background_colour');
$left_middle_column_text_colour       = get_field('left_middle_column_text_colour');
$right_middle_column_background_colour = get_field('right_middle_column_background_colour');
$right_middle_column_text_colour      = get_field('right_middle_column_text_colour');
$right_column_background_colour       = get_field('right_column_background_colour');
$right_column_text_colour             = get_field('right_column_text_colour');
?>

<?php if ($background_image): ?>
    <style>
        .section-<?php echo $randomString; ?> {
            background-image: url('<?php echo $background_image['url']; ?>');
            background-position: <?php echo $background_position; ?>;
            background-size: <?= $background_size; ?>;
        }
        @media (max-width: 976px) {
            .section-<?php echo $randomString; ?> {
                background-image: url('<?php echo ($background_image_mobile ? $background_image_mobile['url'] : $background_image['url']); ?>');
            }
        }
    </style>
<?php endif; ?>

<style>
    .section-<?php echo $randomString; ?> {
        background-color: <?= $background_colour; ?>;
        color: <?= $text_colour; ?>;
    }
    .section-<?php echo $randomString; ?> .media-card a {
        color: <?= $text_colour; ?>;
    }
</style>

<section <?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']); ?>" <?php endif; ?> class="section section-<?= $randomString; ?>">

    <div class="wrapper <?= $padding_top; ?> <?= $padding_bottom; ?>">

        <div class="row four-columns <?= $verticalAlignment; ?>">

            <div class="col-xs-12 col-md-3 fade_in">
                <?php if (have_rows('left_column')): ?>
                    <?php $wrapper_attrs = column_wrapper_attrs($left_column_background_colour, $left_column_text_colour, $column_border_radius); ?>
                    <?php if ($wrapper_attrs): ?><div<?= $wrapper_attrs; ?>><?php endif; ?>
                    <?php while (have_rows('left_column')): the_row(); ?>
                        <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
                    <?php endwhile; ?>
                    <?php if ($wrapper_attrs): ?></div><?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-xs-12 col-md-3 fade_in">
                <?php if (have_rows('left_middle_column')): ?>
                    <?php $wrapper_attrs = column_wrapper_attrs($left_middle_column_background_colour, $left_middle_column_text_colour, $column_border_radius); ?>
                    <?php if ($wrapper_attrs): ?><div<?= $wrapper_attrs; ?>><?php endif; ?>
                    <?php while (have_rows('left_middle_column')): the_row(); ?>
                        <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
                    <?php endwhile; ?>
                    <?php if ($wrapper_attrs): ?></div><?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-xs-12 col-md-3 fade_in">
                <?php if (have_rows('right_middle_column')): ?>
                    <?php $wrapper_attrs = column_wrapper_attrs($right_middle_column_background_colour, $right_middle_column_text_colour, $column_border_radius); ?>
                    <?php if ($wrapper_attrs): ?><div<?= $wrapper_attrs; ?>><?php endif; ?>
                    <?php while (have_rows('right_middle_column')): the_row(); ?>
                        <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
                    <?php endwhile; ?>
                    <?php if ($wrapper_attrs): ?></div><?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-xs-12 col-md-3 fade_in">
                <?php if (have_rows('right_column')): ?>
                    <?php $wrapper_attrs = column_wrapper_attrs($right_column_background_colour, $right_column_text_colour, $column_border_radius); ?>
                    <?php if ($wrapper_attrs): ?><div<?= $wrapper_attrs; ?>><?php endif; ?>
                    <?php while (have_rows('right_column')): the_row(); ?>
                        <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
                    <?php endwhile; ?>
                    <?php if ($wrapper_attrs): ?></div><?php endif; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>
