<?php
$randomString       = generateRandomString();
$section_layout     = get_field('section_layout') ?: 'horizontal';
$background_colour  = get_field('background_colour');
$text_colour        = get_field('text_colour');
$panel_border_radius = get_field('panel_border_radius');
$panel_border_size  = get_field('panel_border_size');
$panel_border_colour = get_field('panel_border_colour');
$title              = get_field('title');
$text               = get_field('text');
$optional_button    = get_field('optional_button');

$panel_style = '';
if ($panel_border_radius) $panel_style .= "border-radius: {$panel_border_radius}px;";
if ($panel_border_size && $panel_border_colour) $panel_style .= " border: {$panel_border_size}px solid {$panel_border_colour};";
?>

<style>
    .section-<?= $randomString; ?> {
        background-color: <?= $background_colour; ?>;
        color: <?= $text_colour; ?>;
    }
</style>

<section <?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']); ?>" <?php endif; ?> class="section section-text_panels section-<?= $randomString; ?>">
    <div class="wrapper">

        <?php if ($title || $text): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php if ($title): ?><h2><?= esc_html($title); ?></h2><?php endif; ?>
                    <?php if ($text): ?><?= $text; ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($optional_button && $optional_button['url']): ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-wrapper pad-top-md">
                        <a href="<?= esc_url($optional_button['url']); ?>"
                           class="btn download"
                           target="<?= esc_attr($optional_button['target'] ?: '_self'); ?>">
                            <?= esc_html($optional_button['title']); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('text_panels')): ?>
            <div class="row pt-medium <?= $section_layout === 'vertical' ? 'flex-column' : ''; ?>">
                <?php while (have_rows('text_panels')): the_row();
                    $panel_colour      = get_sub_field('panel_colour');
                    $panel_text_colour = get_sub_field('text_colour');
                    $panel_title       = get_sub_field('title');
                    $description       = get_sub_field('description');
                    $icon              = get_sub_field('icon');
                    $download_link     = get_sub_field('download_link');
                    $col_style         = $panel_style;
                    if ($panel_colour) $col_style      .= " background-color: {$panel_colour};";
                    if ($panel_text_colour) $col_style .= " color: {$panel_text_colour};";
                    $col_class = $section_layout === 'vertical' ? 'col-xs-12' : 'col-xs-12 col-sm-6 col-md-4';
                ?>
                    <div class="<?= $col_class; ?> fade_in">
                        <div class="column" <?= $col_style ? "style=\"{$col_style}\"" : ''; ?>>
                            <?php if ($panel_title): ?><h3><b><?= esc_html($panel_title); ?></b></h3><?php endif; ?>
                            <?php if ($description): ?><p><?= esc_html($description); ?></p><?php endif; ?>
                            <?php if ($download_link && $download_link['url']): ?>
                                <a href="<?= esc_url($download_link['url']); ?>"
                                   class="download-link"
                                   target="<?= esc_attr($download_link['target'] ?: '_self'); ?>">
                                    <?php if ($icon): ?>
                                        <img src="<?= esc_url($icon['url']); ?>" alt="<?= esc_attr($icon['alt']); ?>">
                                    <?php endif; ?>
                                    <?= esc_html($download_link['title'] ?: $panel_title); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
