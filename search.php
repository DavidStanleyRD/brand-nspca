<?php get_header(); ?>

<section class="section pad-top-lg pad-bottom-lg">
    <div class="wrapper">

        <div class="row">
            <div class="col-xs-12">
                <h1>
                    <?php printf(
                        __( 'Search results for: %s', 'brand-nspca' ),
                        '<em>' . esc_html( get_search_query() ) . '</em>'
                    ); ?>
                </h1>
            </div>
        </div>

        <?php if ( have_posts() ) : ?>

            <div class="row">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-xs-12 col-md-6 col-lg-4 fade_in">
                        <a href="<?php the_permalink(); ?>" class="search-result-card">
                            <span class="result-type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
                            <h3><?php the_title(); ?></h3>
                            <?php if ( get_the_excerpt() ) : ?>
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php the_posts_pagination( [
                        'mid_size'  => 2,
                        'prev_text' => '&larr; Previous',
                        'next_text' => 'Next &rarr;',
                    ] ); ?>
                </div>
            </div>

        <?php else : ?>

            <div class="row">
                <div class="col-xs-12">
                    <p>No results found for <em><?php echo esc_html( get_search_query() ); ?></em>. Try a different search term.</p>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
