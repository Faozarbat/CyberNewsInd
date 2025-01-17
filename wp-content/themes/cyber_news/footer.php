<?php if(get_theme_mod('floating_banner')): ?>
<div class="floating-banner" style="display:none;">
    <a href="#" class="close-button">×</a>
    <img src="<?php echo esc_url(get_theme_mod('floating_banner')); ?>" alt="Advertisement">
</div>
<?php endif; ?>

<?php if(get_theme_mod('banner_floating')): ?>
<div class="banner-floating">
    <button class="close-banner">×</button>
    <img src="<?php echo esc_url(get_theme_mod('banner_floating')); ?>" alt="Advertisement">
</div>
<?php endif; ?>

<?php if(get_theme_mod('banner_left')): ?>
<div class="banner-left">
    <img src="<?php echo esc_url(get_theme_mod('banner_left')); ?>" alt="Advertisement">
</div>
<?php endif; ?>

<?php if(get_theme_mod('banner_right')): ?>
<div class="banner-right">
    <img src="<?php echo esc_url(get_theme_mod('banner_right')); ?>" alt="Advertisement">
</div>
<?php endif; ?>