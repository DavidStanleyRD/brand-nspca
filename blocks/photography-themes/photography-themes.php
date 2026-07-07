<?php include get_template_directory() . '/content-blocks/partials/block-section-options.php'; ?>

<?php
$randomString = generateRandomString();
$title        = get_field('title');
$text         = get_field('text');
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

<section <?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']); ?>" <?php endif; ?> class="section section-<?= $randomString; ?>">
    <div class="wrapper <?= $padding_top; ?> <?= $padding_bottom; ?>">

        <?php if ($title || $text): ?>
            <div class="row">
                <div class="col-xs-12">
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
                            $btn       = get_sub_field('button');
                            $btn_style = get_sub_field('button_style');
                            $btn_bg    = get_sub_field('background_colour');
                            $btn_text  = get_sub_field('text_colour');
                            $icon_col  = get_sub_field('icon_colour');
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

        <?php if (have_rows('photography_themes')): ?>
            <div class="photography-themes">
                <?php while (have_rows('photography_themes')): the_row();
                    $panel_colour      = get_sub_field('panel_colour');
                    $panel_text_colour = get_sub_field('text_colour');
                    $panel_text        = get_sub_field('text');
                    $visual_type       = get_sub_field('visual_type');
                    $image             = get_sub_field('image');
                    $video             = get_sub_field('video');
                    $panel_style       = '';
                    if ($panel_colour) $panel_style      .= "background-color: {$panel_colour};";
                    if ($panel_text_colour) $panel_style .= " color: {$panel_text_colour};";
                ?>
                    <div class="photography-themes-single">

                        <div class="photography-themes-panel" <?= $panel_style ? "style=\"{$panel_style}\"" : ''; ?>>
                            <?php if ($panel_text): ?><?= $panel_text; ?><?php endif; ?>

                            <?php if (have_rows('buttons')): ?>
                                <div class="btn-wrapper pad-top-md">
                                    <?php while (have_rows('buttons')): the_row();
                                        $btn       = get_sub_field('button');
                                        $btn_style = get_sub_field('button_style');
                                        $btn_bg    = get_sub_field('background_colour');
                                        $btn_text  = get_sub_field('text_colour');
                                        $icon_col  = get_sub_field('icon_colour');
                                        if ($btn && $btn['url']): ?>
                                        <a href="<?= esc_url($btn['url']); ?>"
                                           class="btn <?= esc_attr($btn_style); ?> <?= esc_attr($icon_col); ?>"
                                           style="<?= $btn_bg ? "background-color: {$btn_bg};" : ''; ?><?= $btn_text ? " color: {$btn_text};" : ''; ?>"
                                           target="<?= esc_attr($btn['target'] ?: '_self'); ?>">
                                            <?= esc_html($btn['title']); ?>
                                        </a>
                                    <?php endif; endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="photography-themes-image">
                            <?php if ($visual_type === 'image' && $image): ?>
                                <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>">

                            <?php elseif ($visual_type === 'carousel' && have_rows('carousel')): ?>
                                <div class="swiper photography-carousel">
                                    <div class="swiper-wrapper">
                                        <?php while (have_rows('carousel')): the_row();
                                            $slide = get_sub_field('image');
                                            if ($slide): ?>
                                            <div class="swiper-slide">
                                                <img src="<?= esc_url($slide['url']); ?>" alt="<?= esc_attr($slide['alt']); ?>">
                                            </div>
                                        <?php endif; endwhile; ?>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>

                            <?php elseif ($visual_type === 'video' && $video): ?>
                                <div class="video-embed"><?= $video; ?></div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
