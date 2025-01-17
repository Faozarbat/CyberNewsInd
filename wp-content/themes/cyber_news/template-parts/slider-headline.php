<?php
// Query untuk headline posts
$args = array(
    'posts_per_page' => 5,
    'meta_key' => 'headline',
    'meta_value' => 'yes',
    'post_type' => 'post'
);
$headline_posts = new WP_Query($args);
?>

<!-- Desktop Slider -->
<div class="flexslider desktop-slider">
    <ul class="slides">
        <?php while($headline_posts->have_posts()): $headline_posts->the_post(); ?>
            <li>
                <?php if(has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('headline-large'); ?>
                <?php endif; ?>
                <div class="headline-caption">
                    <p class="headline-label"><?php echo get_the_category_list(', '); ?></p>
                    <h2 class="headline-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                </div>
            </li>
        <?php endwhile; wp_reset_postdata(); ?>
    </ul>
</div>

<!-- Mobile Slider -->
<div class="mobile-slider">
    <ul id="lightSliderMobile">
        <?php 
        $headline_posts->rewind_posts();
        while($headline_posts->have_posts()): $headline_posts->the_post(); 
        ?>
            <li>
                <div class="headline-mobile-item">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('headline-mobile'); ?>
                    <?php endif; ?>
                    <div class="headline-mobile-caption">
                        <p class="mobile-category"><?php echo get_the_category_list(', '); ?></p>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="mobile-date"><?php echo get_the_date('l, j M Y - H:i'); ?> WIB</p>
                    </div>
                </div>
            </li>
        <?php endwhile; wp_reset_postdata(); ?>
    </ul>
</div>

<!-- Swiper Slider -->
<div class="swiper-container headline-swiper">
    <div class="swiper-wrapper">
        <?php 
        $headline_posts->rewind_posts();
        while($headline_posts->have_posts()): $headline_posts->the_post(); 
        ?>
            <div class="swiper-slide">
                <?php if(has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('headline-swiper'); ?>
                <?php endif; ?>
                <div class="swiper-caption">
                    <div class="swiper-category"><?php echo get_the_category_list(', '); ?></div>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>