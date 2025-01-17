<div id="berita-rekomendasi">
    <p class="judul-berita-rekomendasi">Berita Rekomendasi</p>
    <div class="owl-carousel">
        <?php
        $recommended_args = array(
            'posts_per_page' => 6,
            'meta_key' => '_recommended_news',
            'meta_value' => '1'
        );
        $recommended_query = new WP_Query($recommended_args);
        
        while($recommended_query->have_posts()): $recommended_query->the_post();
        ?>
        <div class="berita-rekomendasi-box">
            <?php if(has_post_thumbnail()): ?>
                <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
            <div class="text-berita-rekomendasi">
                <p class="kategori-berita-rekomendasi">
                    <?php echo get_the_category_list(', '); ?>
                </p>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        </div>
        <?php 
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>