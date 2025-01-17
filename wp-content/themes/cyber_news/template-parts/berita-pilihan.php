<div id="berita-pilihan">
    <p class="judul-berita-pilihan">Berita Pilihan</p>
    <div class="owl-carousel">
        <?php
        $featured_args = array(
            'posts_per_page' => 6,
            'meta_key' => '_featured_news',
            'meta_value' => '1'
        );
        $featured_query = new WP_Query($featured_args);
        
        while($featured_query->have_posts()): $featured_query->the_post();
        ?>
        <div class="berita-pilihan-box">
            <?php if(has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium'); ?>
            <?php endif; ?>
            <p class="kategori-berita-pilihan">
                <?php echo get_the_category_list(', '); ?>
            </p>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <?php 
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>