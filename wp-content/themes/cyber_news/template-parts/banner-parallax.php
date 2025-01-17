<div id="sidebar-banner-mobile-top-header-parallax">
    <a href="#" title="close" class="close-button">CLOSE ADS</a>
    <div class="sidebar-banner-mobile-top-header-parallax-wrap">
        <div class="banner-content">
            <?php
            // Ambil banner dari pengaturan tema
            $banner_image = get_theme_mod('mobile_top_banner');
            if($banner_image) {
                echo '<img src="'.esc_url($banner_image).'" alt="Advertisement">';
            }
            ?>
        </div>
        <p class="scroll-to-continue">SCROLL TO CONTINUE WITH CONTENT</p>
    </div>
</div>