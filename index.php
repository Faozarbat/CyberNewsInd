<<<<<<< HEAD
<?php get_header(); ?>

<div id="content-wrap">
    <div id="content-left-wrap">
        <!-- Slider Headline -->
        <?php get_template_part('template-parts/slider-headline'); ?>
        
        <!-- Slider Mobile -->
        <div class="lSSlideOuter">
            <?php get_template_part('template-parts/slider-mobile'); ?>
        </div>
        
        <!-- Slider Swiper -->
        <div class="slider-container">
            <?php get_template_part('template-parts/slider-swiper'); ?>
        </div>

        <!-- News Feed - Berita Terkini -->
        <div id="news-feed">
            <p class="news-feed-judul-block"><span>BERITA TERKINI</span></p>
            
            <?php if(have_posts()): ?>
                <?php $post_counter = 0; ?>
                <?php while(have_posts()): the_post(); ?>
                    <div class="news-feed-list">
                        <a class="news-feed-link" href="<?php the_permalink(); ?>">
                            <figure>
                                <?php if(has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('news-feed-thumb', array('class' => 'newsfeed-image')); ?>
                                    <?php the_post_thumbnail('news-feed-mobile', array('class' => 'newsfeed-image-mobile')); ?>
                                <?php endif; ?>
                            </figure>
                            <div class="news-feed-text-block">
                                <p class="kategori"><?php echo get_the_category_list(', '); ?></p>
                                <h2 class="news-feed-judul"><?php the_title(); ?></h2>
                                <p class="tanggal">
                                    <?php echo get_the_date('l, j M Y - H:i'); ?> WIB
                                </p>
                                <div class="the-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </a>
                    </div>

                    <?php $post_counter++; ?>
                    
                    <?php if($post_counter == 3): ?>
                        <!-- Banner setelah post ke-3 -->
                        <div class="newsfeed-satu-container">
                            <?php get_template_part('template-parts/banner', 'newsfeed-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($post_counter == 5): ?>
                        <!-- Berita Pilihan setelah post ke-5 -->
                        <?php get_template_part('template-parts/berita-pilihan'); ?>
                    <?php endif; ?>

                    <?php if($post_counter == 8): ?>
                        <!-- Banner setelah post ke-8 -->
                        <div class="newsfeed-dua-container">
                            <?php get_template_part('template-parts/banner', 'newsfeed-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($post_counter == 10): ?>
                        <!-- Berita Rekomendasi setelah post ke-10 -->
                        <?php get_template_part('template-parts/berita-rekomendasi'); ?>
                    <?php endif; ?>

                <?php endwhile; ?>

                <!-- Pagination -->
                <div class="next-wrap">
                    <?php cybernews_pagination(); ?>
                </div>

            <?php endif; ?>
            
        </div><!-- akhir #news-feed -->
        
        <div class="clr"></div>
    </div><!-- akhir #content-left-wrap -->

    <?php get_sidebar(); ?>

    <div class="clr"></div>
</div><!-- akhir #content-wrap -->

<?php get_footer(); ?>
=======
<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
>>>>>>> b376964 (First commit)
