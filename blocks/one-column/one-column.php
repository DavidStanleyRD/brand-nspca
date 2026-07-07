<?php include get_template_directory() . '/content-blocks/partials/block-section-options.php'; ?>

<?php
$randomString    = generateRandomString();
$columnWidth     = get_field('column_width');
$columnOffset    = get_field('column_offset');
$columnAlignment = get_field('column_alignment');
?>

<?php if ($background_image): ?>
    <style>
        .section-<?php echo $randomString; ?> {
            background-image: url('<?php echo $background_image['url']; ?>');
            background-position: <?php echo $background_position; ?>;
            background-color: <?= $background_colour; ?>;
            background-size: <?= $background_size; ?>;
            color: <?= $text_colour; ?>;
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

<section <?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']); ?>" <?php endif; ?> class="single-column section section-<?php echo $randomString; ?>">
    <?php if ($columnWidth == 'no-wrapper'): ?>
        <div class="relative z-2 <?php echo $padding_top; ?> <?php echo $padding_bottom; ?>">
            <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
        </div>
    <?php else: ?>
        <div class="wrapper relative z-2 <?php echo $padding_top; ?> <?php echo $padding_bottom; ?>">
            <div class="row <?= $columnAlignment; ?>">
                <div class="col-xs-12 <?= $columnWidth; ?> <?= $columnOffset; ?>">
                    <?php if ($column_border_radius): ?><div style="border-radius: <?= $column_border_radius; ?>px;"><?php endif; ?>
                    <?php include get_template_directory() . '/content-blocks/partials/columns/column-content.php'; ?>
                    <?php if ($column_border_radius): ?></div><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
