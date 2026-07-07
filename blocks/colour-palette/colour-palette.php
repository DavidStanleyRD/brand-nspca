<?php include get_template_directory() . '/content-blocks/partials/block-section-options.php'; ?>

<?php
$randomString        = generateRandomString();
$panel_border_radius = get_field('panel_border_radius');
$title               = get_field('title');
$text                = get_field('text');
?>

<?php if ($background_image): ?>
    <style>
        .section-<?= $randomString; ?> {
            background-image: url('<?= $background_image['url']; ?>');
            background-position: <?= $background_position; ?>;
            background-size: <?= $background_size; ?>;
        }
        @media (max-width: 976px) {
            .section-<?= $randomString; ?> {
                background-image: url('<?= ($background_image_mobile ? $background_image_mobile['url'] : $background_image['url']); ?>');
            }
        }
    </style>
<?php endif; ?>

<style>
    .section-<?= $randomString; ?> {
        background-color: <?= $background_colour; ?>;
        color: <?= $text_colour; ?>;
    }
</style>

<section <?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']); ?>" <?php endif; ?> class="section section-text_panels section-<?= $randomString; ?>">
    <div class="wrapper <?= $padding_top; ?> <?= $padding_bottom; ?>">

        <?php if ($title || $text): ?>
            <div class="row">
                <div class="col-xs-12 col-md-8 col-xl-6">
                    <?php if ($title): ?><h2><b><?= esc_html($title); ?></b></h2><?php endif; ?>
                    <?php if ($text): ?><?= $text; ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('buttons')): ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-wrapper pad-top-md">
                        <?php while (have_rows('buttons')): the_row();
                            $btn        = get_sub_field('button');
                            $btn_style  = get_sub_field('button_style');
                            $btn_bg     = get_sub_field('background_colour');
                            $btn_text   = get_sub_field('text_colour');
                            $icon_col   = get_sub_field('icon_colour');
                            if ($btn && $btn['url']): ?>
                            <a href="<?= esc_url($btn['url']); ?>"
                               class="btn <?= esc_attr($btn_style); ?> <?= esc_attr($icon_col); ?>"
                               style="<?= $btn_bg ? "background-color: {$btn_bg};" : ''; ?><?= $btn_text ? " color: {$btn_text};" : ''; ?>"
                               target="<?= esc_attr($btn['target'] ?: '_self'); ?>">
                                <?= esc_html($btn['title']); ?>
                            </a>
                        <?php endif; endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('text_panels')): ?>
            <div class="row">
                <?php while (have_rows('text_panels')): the_row();
                    $panel_colour      = get_sub_field('panel_colour');
                    $panel_text_colour = get_sub_field('text_colour');
                    $panel_title       = get_sub_field('title');
                    $description       = get_sub_field('description');
                    $hex_value         = get_sub_field('hex_value');
                    $rgb_value         = get_sub_field('rgb_value');
                    $cmyk_value        = get_sub_field('cmyk_value');
                    $pms_value         = get_sub_field('pms_value');
                    $panel_style       = '';
                    if ($panel_colour) $panel_style       .= "background-color: {$panel_colour};";
                    if ($panel_text_colour) $panel_style  .= " color: {$panel_text_colour};";
                    if ($panel_border_radius) $panel_style .= " border-radius: {$panel_border_radius}px;";
                ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 fade_in">
                        <div class="panel" <?= $panel_style ? "style=\"{$panel_style}\"" : ''; ?>>
                            <?php if ($panel_title): ?><h3><?= esc_html($panel_title); ?></h3><?php endif; ?>
                            <?php if ($description): ?><p class="description"><?= esc_html($description); ?></p><?php endif; ?>
                            <div class="text-wrapper">
                                <?php if ($hex_value): ?>
                                    <div class="value" data-copy="<?= esc_attr($hex_value); ?>">
                                        <strong>HEX</strong>
                                        <p><?= esc_html(ltrim($hex_value, '#')); ?></p>
                                        <span class="tooltip">Click to copy</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($rgb_value): ?>
                                    <div class="value" data-copy="<?= esc_attr($rgb_value); ?>">
                                        <strong>RGB</strong>
                                        <p><?= esc_html($rgb_value); ?></p>
                                        <span class="tooltip">Click to copy</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($cmyk_value): ?>
                                    <div class="value" data-copy="<?= esc_attr($cmyk_value); ?>">
                                        <strong>CMYK</strong>
                                        <p><?= esc_html($cmyk_value); ?></p>
                                        <span class="tooltip">Click to copy</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pms_value): ?>
                                    <div class="value" data-copy="<?= esc_attr($pms_value); ?>">
                                        <strong>PMS</strong>
                                        <p><?= esc_html($pms_value); ?></p>
                                        <span class="tooltip">Click to copy</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
