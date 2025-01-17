<?php
/**
 * Header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header>
    <div class="header-fixed">
        <div class="header-top">
			<div class="container">
				<div class="header-wrap">
					<div class="logo">
						<a href="<?php echo home_url('/'); ?>">
							<?php 
							if(has_custom_logo()):
								the_custom_logo();
							else:
								echo '<h1>' . get_bloginfo('name') . '</h1>';
							endif;
							?>
						</a>
					</div>
					
					<div class="right-header">
						<form method="get" class="search-form" action="<?php echo home_url('/'); ?>">
							<input type="text" class="search-field" name="s" placeholder="Cari Berita" value="">
							<button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
						</form>

						<div class="social-icons">
							<a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
							<a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
							<a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
							<a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

        <nav class="main-navigation">
            <div class="container">
            <!-- Hamburger hanya tampil di mobile -->
            <div class="hamburger-button d-block d-md-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'menu-utama',
                'container'      => false
            ));
            ?>
        </div>
        </nav>
		<div class="marquee-wrap">
    <div class="marquee">
        <?php
        // Query untuk berita terbaru
        $latest_posts = new WP_Query(array(
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if($latest_posts->have_posts()): ?>
            <div class="marquee-content">
                <?php while($latest_posts->have_posts()): $latest_posts->the_post(); ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <?php endwhile; ?>
            </div>
        <?php 
        endif;
        wp_reset_postdata();
        ?>
    </div>
</div>
    </div>
</header>
<?php if(get_theme_mod('banner_left') || get_theme_mod('banner_right')): ?>
<!-- Banner Kiri dan Kanan -->
<div class="banner-container">
    <?php if(get_theme_mod('banner_left')): ?>
    <div class="banner-left">
        <div class="banner-sticky">
            <img src="<?php echo esc_url(get_theme_mod('banner_left')); ?>" alt="Advertisement">
        </div>
    </div>
    <?php endif; ?>

    <?php if(get_theme_mod('banner_right')): ?>
    <div class="banner-right">
        <div class="banner-sticky">
            <img src="<?php echo esc_url(get_theme_mod('banner_right')); ?>" alt="Advertisement">
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>