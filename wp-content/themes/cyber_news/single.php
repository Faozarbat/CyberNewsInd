<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_format('video')): ?>
                    <div class="video-wrapper">
                        <?php
                        $video_url = get_post_meta(get_the_ID(), '_video_url', true);
                        if ($video_url) {
                            // Mengekstrak ID video YouTube
                            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches);
                            if (isset($matches[1])) {
                                $video_id = $matches[1];
                                ?>
                                <div class="responsive-video">
                                    <iframe width="100%" height="480" 
                                            src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen></iframe>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    <div class="entry-meta">
                        <?php
                        // Tampilkan meta informasi
                        echo sprintf(
                            '%s | %s',
                            get_the_date('l, j M Y - H:i') . ' WIB',
                            get_the_author()
                        );
                        ?>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<div class="share-buttons">
    <button class="copy-url" data-url="<?php echo get_permalink(); ?>">
        <i class="fas fa-link"></i> Salin URL
    </button>
    <button class="share-facebook" data-url="<?php echo get_permalink(); ?>">
        <i class="fab fa-facebook"></i> Share
    </button>
    <button class="share-twitter" 
            data-url="<?php echo get_permalink(); ?>"
            data-title="<?php echo get_the_title(); ?>">
        <i class="fab fa-twitter"></i> Tweet
    </button>
    <button class="share-whatsapp"
            data-url="<?php echo get_permalink(); ?>"
            data-title="<?php echo get_the_title(); ?>">
        <i class="fab fa-whatsapp"></i> WhatsApp
    </button>
</div>

<?php if(has_post_thumbnail()): ?>
<div class="post-thumbnail wp-caption">
    <?php the_post_thumbnail('large'); ?>
    <?php
    $thumbnail_id = get_post_thumbnail_id();
    $caption = wp_get_attachment_caption($thumbnail_id);
    if($caption):
    ?>
    <p class="wp-caption-text"><?php echo esc_html($caption); ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>