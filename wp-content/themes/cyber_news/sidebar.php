<div id="sidebar-right">
    <div class="sidebar-right-wrap">
        <!-- Widget Trending/Populer -->
        <div class="before-widget">
            <h2 class="judul-sidebar-right">Trending</h2>
            <div class="textwidget">
                <ul class="wpp-list">
                    <?php
                    $popular_posts = get_posts(array(
                        'meta_key' => 'post_views_count',
                        'orderby' => 'meta_value_num',
                        'posts_per_page' => 10
                    ));
                    
                    foreach($popular_posts as $post):
                        setup_postdata($post);
                    ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" class="wpp-post-title">
                                <?php the_title(); ?>
                            </a>
                        </li>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>

        <!-- Widget Topik Populer -->
        <div class="before-widget">
            <h2 class="judul-sidebar-right">Topik Populer</h2>
            <nav aria-label="Topik Populer">
                <div class="tagcloud">
                    <?php
                    $args = array(
                        'number' => 10,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    );
                    $tags = get_tags($args);
                    
                    foreach($tags as $tag) {
                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-cloud-link">';
                        echo $tag->name . '<span class="tag-link-count"> (' . $tag->count . ')</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </nav>
        </div>

        <!-- Widget Kategori (misal: Internasional) -->
        <div class="before-widget">
            <h2 class="judul-sidebar-right">Internasional</h2>
            <div class="text-wrap">
                <?php
                $international_posts = get_posts(array(
                    'category_name' => 'internasional',
                    'posts_per_page' => 3
                ));
                
                foreach($international_posts as $post):
                    setup_postdata($post);
                ?>
                    <div class="recent-post-widget">
                        <p>
                            <?php if(has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('sidebar-thumb'); ?>
                            <?php endif; ?>
                        </p>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p class="waktu"><?php echo get_the_date('j F Y | H:i'); ?> WIB</p>
                        <div class="clr"></div>
                    </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        </div>

        <!-- Area untuk Widget Dinamis -->
        <?php dynamic_sidebar('sidebar-right'); ?>
        
    </div><!-- akhir sidebar right wrap -->
</div><!-- akhir #sidebar-right -->