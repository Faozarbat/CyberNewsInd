<?php
/**
 * Theme functions
 */

function cybernews_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Menu Utama', 'cybernews'),
        'footer'  => esc_html__('Menu Footer', 'cybernews'),
    ));

    // Custom logo
    add_theme_support('custom-logo', array(
        'height'      => 77,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'cybernews_setup');

// Enqueue scripts and styles
function cybernews_scripts() {
    // Styles
    wp_enqueue_style('cybernews-style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    wp_enqueue_style('flexslider', get_template_directory_uri() . '/assets/css/flexslider.css');
    wp_enqueue_style('lightslider', get_template_directory_uri() . '/assets/css/lightslider.min.css');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.css');
    
    // Scripts
    wp_enqueue_script('cybernews-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.0', true);
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider.js', array('jquery'), '2.7.2', true);
    wp_enqueue_script('lightslider', get_template_directory_uri() . '/assets/js/lightslider.min.js', array('jquery'), '1.1.6', true);
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), '7.0.0', true);
    
    if(is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cybernews_scripts');

// Di functions.php
function cybernews_create_default_menu() {
    // Cek apakah menu sudah ada
    $main_menu_exists = wp_get_nav_menu_object('Menu Utama');
    
    if(!$main_menu_exists) {
        $menu_id = wp_create_nav_menu('Menu Utama');
        
        // Buat menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Home',
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Bisnis',
            'menu-item-url' => home_url('/bisnis/'),
            'menu-item-status' => 'publish'
        ));
        
        // Menu Daerah dengan submenu
        $daerah = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Daerah',
            'menu-item-url' => '#',
            'menu-item-status' => 'publish'
        ));
        
        // Submenu Daerah
        $daerah_items = array('Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Palembang');
        foreach($daerah_items as $item) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $item,
                'menu-item-url' => home_url('/' . strtolower($item) . '/'),
                'menu-item-parent-id' => $daerah,
                'menu-item-status' => 'publish'
            ));
        }
        
        // Menu items lainnya
        $other_items = array(
            'Internasional',
            'Pemerintahan',
            'Kesehatan',
            'Kriminal',
            'Nasional',
            'Pendidikan',
            'Politik',
            'Teknologi',
            'Wisata',
            'Sport'
        );
        
        foreach($other_items as $item) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $item,
                'menu-item-url' => home_url('/' . strtolower($item) . '/'),
                'menu-item-status' => 'publish'
            ));
        }
        
        // Tetapkan menu ke lokasi 'primary'
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'cybernews_create_default_menu');


// Fungsi untuk menambahkan watermark pada thumbnail
function cybernews_add_watermark($image_path) {
    // Memastikan GD Library tersedia
    if (!extension_loaded('gd')) {
        return false;
    }

    // Load gambar berdasarkan tipe file
    $image_info = getimagesize($image_path);
    switch ($image_info[2]) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($image_path);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($image_path);
            break;
        default:
            return false;
    }

    // Load watermark
    $watermark = imagecreatefrompng(get_template_directory() . '/assets/images/watermark.png');
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    // Set posisi watermark (pojok kanan bawah)
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $dest_x = $image_width - $watermark_width - 10;
    $dest_y = $image_height - $watermark_height - 10;

    // Merge watermark dengan gambar
    imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

    // Simpan gambar
    switch ($image_info[2]) {
        case IMAGETYPE_JPEG:
            imagejpeg($image, $image_path, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $image_path, 9);
            break;
    }

    // Bersihkan memory
    imagedestroy($image);
    imagedestroy($watermark);

    return true;
}

// Hook untuk menambahkan watermark saat upload gambar
function cybernews_add_watermark_upload($metadata) {
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
    
    // Tambahkan watermark ke gambar utama
    cybernews_add_watermark($file_path);
    
    // Tambahkan watermark ke ukuran thumbnail lainnya
    if (isset($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size => $size_info) {
            $size_file_path = $upload_dir['basedir'] . '/' . dirname($metadata['file']) . '/' . $size_info['file'];
            cybernews_add_watermark($size_file_path);
        }
    }
    
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'cybernews_add_watermark_upload');

// Mendaftarkan post format
function cybernews_post_formats() {
    add_theme_support('post-formats', array('video'));
}
add_action('after_setup_theme', 'cybernews_post_formats');

// Menambahkan meta box untuk URL video YouTube
function cybernews_add_video_metabox() {
    add_meta_box(
        'video_url', // ID unik
        'URL Video YouTube', // Judul
        'cybernews_video_metabox_callback', // Callback function
        'post', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'cybernews_add_video_metabox');

// Callback function untuk meta box
function cybernews_video_metabox_callback($post) {
    wp_nonce_field('cybernews_video_metabox', 'cybernews_video_metabox_nonce');
    $value = get_post_meta($post->ID, '_video_url', true);
    ?>
    <input type="text" id="video_url" name="video_url" value="<?php echo esc_attr($value); ?>" style="width:100%">
    <p class="description">Masukkan URL video YouTube (contoh: https://www.youtube.com/watch?v=XXXX)</p>
    <?php
}

// Menyimpan data meta box
function cybernews_save_video_metabox($post_id) {
    if (!isset($_POST['cybernews_video_metabox_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['cybernews_video_metabox_nonce'], 'cybernews_video_metabox')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['video_url'])) {
        update_post_meta($post_id, '_video_url', sanitize_text_field($_POST['video_url']));
    }
}
add_action('save_post', 'cybernews_save_video_metabox');

function cybernews_floating_video_scripts() {
    wp_enqueue_script('floating-video', get_template_directory_uri() . '/assets/js/floating-video.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'cybernews_floating_video_scripts');

// Tambah meta box untuk Editor dan Sumber Berita
function cybernews_add_post_meta_boxes() {
    add_meta_box(
        'editor_info',
        'Informasi Editor',
        'cybernews_editor_info_callback',
        'post',
        'normal',
        'high'
    );
    
    add_meta_box(
        'news_source',
        'Sumber Berita',
        'cybernews_news_source_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cybernews_add_post_meta_boxes');

// Callback untuk meta box Editor
function cybernews_editor_info_callback($post) {
    wp_nonce_field('cybernews_editor_info', 'cybernews_editor_info_nonce');
    $editor_name = get_post_meta($post->ID, '_editor_name', true);
    ?>
    <p>
        <label for="editor_name">Nama Editor:</label>
        <input type="text" id="editor_name" name="editor_name" value="<?php echo esc_attr($editor_name); ?>" style="width:100%">
    </p>
    <?php
}

// Callback untuk meta box Sumber Berita
function cybernews_news_source_callback($post) {
    wp_nonce_field('cybernews_news_source', 'cybernews_news_source_nonce');
    $news_source = get_post_meta($post->ID, '_news_source', true);
    ?>
    <p>
        <label for="news_source">Sumber Berita:</label>
        <input type="text" id="news_source" name="news_source" value="<?php echo esc_attr($news_source); ?>" style="width:100%">
    </p>
    <?php
}

// Simpan data meta box
function cybernews_save_post_meta($post_id) {
    // Cek nonce untuk editor
    if (isset($_POST['cybernews_editor_info_nonce'])) {
        if (!wp_verify_nonce($_POST['cybernews_editor_info_nonce'], 'cybernews_editor_info')) {
            return;
        }
        if (isset($_POST['editor_name'])) {
            update_post_meta($post_id, '_editor_name', sanitize_text_field($_POST['editor_name']));
        }
    }

    // Cek nonce untuk sumber berita
    if (isset($_POST['cybernews_news_source_nonce'])) {
        if (!wp_verify_nonce($_POST['cybernews_news_source_nonce'], 'cybernews_news_source')) {
            return;
        }
        if (isset($_POST['news_source'])) {
            update_post_meta($post_id, '_news_source', sanitize_text_field($_POST['news_source']));
        }
    }
}
add_action('save_post', 'cybernews_save_post_meta');

function cybernews_customize_register($wp_customize) {
    // Seksi Banner
    $wp_customize->add_section('banner_settings', array(
        'title' => 'Pengaturan Banner',
        'priority' => 30,
    ));

    // Setting untuk Mobile Top Banner
    $wp_customize->add_setting('mobile_top_banner', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobile_top_banner', array(
        'label' => 'Banner Mobile Atas',
        'section' => 'banner_settings',
        'settings' => 'mobile_top_banner'
    )));

    // Setting untuk Banner Floating
    $wp_customize->add_setting('floating_banner', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'floating_banner', array(
        'label' => 'Banner Floating',
        'section' => 'banner_settings',
        'settings' => 'floating_banner'
    )));
}
add_action('customize_register', 'cybernews_customize_register');

function cybernews_customize_font_colors($wp_customize) {
    // Font Settings
    $wp_customize->add_section('font_settings', array(
        'title' => 'Pengaturan Font',
        'priority' => 35,
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default' => 'Poppins',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('heading_font', array(
        'label' => 'Font Judul',
        'section' => 'font_settings',
        'type' => 'select',
        'choices' => array(
            'Poppins' => 'Poppins',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Montserrat' => 'Montserrat',
            'Raleway' => 'Raleway'
        )
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default' => 'Poppins',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('body_font', array(
        'label' => 'Font Konten',
        'section' => 'font_settings',
        'type' => 'select',
        'choices' => array(
            'Poppins' => 'Poppins',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Montserrat' => 'Montserrat',
            'Raleway' => 'Raleway'
        )
    ));

    // Color Settings
    $wp_customize->add_section('color_settings', array(
        'title' => 'Pengaturan Warna',
        'priority' => 40,
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default' => '#21409A',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => 'Warna Utama',
        'section' => 'color_settings'
    )));

    // 15 pilihan warna preset
    $color_schemes = array(
        'blue' => '#21409A',
        'red' => '#E63946',
        'green' => '#2A9D8F',
        'purple' => '#7209B7',
        'orange' => '#F4A261',
        'teal' => '#264653',
        'pink' => '#FF006E',
        'brown' => '#774936',
        'navy' => '#003049',
        'lime' => '#84B082',
        'maroon' => '#9B2226',
        'cyan' => '#00B4D8',
        'olive' => '#606C38',
        'violet' => '#7400B8',
        'gray' => '#6B705C'
    );

    $wp_customize->add_setting('color_scheme', array(
        'default' => 'blue',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('color_scheme', array(
        'label' => 'Skema Warna',
        'section' => 'color_settings',
        'type' => 'select',
        'choices' => array_combine(array_keys($color_schemes), array_keys($color_schemes))
    ));
}
add_action('customize_register', 'cybernews_customize_font_colors');

// Menerapkan pengaturan font dan warna
function cybernews_customize_css() {
    $primary_color = get_theme_mod('primary_color', '#21409A');
    $heading_font = get_theme_mod('heading_font', 'Poppins');
    $body_font = get_theme_mod('body_font', 'Poppins');
    ?>
    <style type="text/css">
        /* Font Settings */
        h1, h2, h3, h4, h5, h6, .menu-utama > li > a {
            font-family: '<?php echo esc_html($heading_font); ?>', sans-serif;
        }
        
        body, p, .entry-content {
            font-family: '<?php echo esc_html($body_font); ?>', sans-serif;
        }

        /* Color Settings */
        .main-navigation, 
        .menu-utama > li > a:hover,
        .headline-label,
        .category-label,
        .btn-primary,
        .pagination .current {
            background-color: <?php echo esc_html($primary_color); ?>;
        }

        a:hover,
        .news-title a:hover,
        .category a {
            color: <?php echo esc_html($primary_color); ?>;
        }

        .btn-primary,
        .form-control:focus {
            border-color: <?php echo esc_html($primary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'cybernews_customize_css');

// Memuat Google Fonts
function cybernews_load_google_fonts() {
    $heading_font = get_theme_mod('heading_font', 'Poppins');
    $body_font = get_theme_mod('body_font', 'Poppins');
    
    $fonts_url = "https://fonts.googleapis.com/css2?family=";
    $fonts_url .= str_replace(' ', '+', $heading_font);
    if($body_font !== $heading_font) {
        $fonts_url .= "|" . str_replace(' ', '+', $body_font);
    }
    $fonts_url .= ":wght@400;500;600;700&display=swap";

    wp_enqueue_style('google-fonts', $fonts_url, array(), null);
}
add_action('wp_enqueue_scripts', 'cybernews_load_google_fonts');

// Registrasi post meta untuk Berita Pilihan dan Rekomendasi
function cybernews_register_post_meta() {
    register_post_meta('post', '_featured_news', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'boolean',
        'default' => false
    ));

    register_post_meta('post', '_recommended_news', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'boolean',
        'default' => false
    ));
}
add_action('init', 'cybernews_register_post_meta');

// Tambah meta box untuk Berita Pilihan dan Rekomendasi
function cybernews_add_news_meta_boxes() {
    add_meta_box(
        'news_options',
        'Opsi Berita',
        'cybernews_news_options_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'cybernews_add_news_meta_boxes');

// Callback untuk meta box
function cybernews_news_options_callback($post) {
    $featured = get_post_meta($post->ID, '_featured_news', true);
    $recommended = get_post_meta($post->ID, '_recommended_news', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="featured_news" value="1" <?php checked($featured, '1'); ?>>
            Berita Pilihan
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" name="recommended_news" value="1" <?php checked($recommended, '1'); ?>>
            Berita Rekomendasi
        </label>
    </p>
    <?php
}

// Simpan meta box data
function cybernews_save_news_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    $featured = isset($_POST['featured_news']) ? '1' : '0';
    $recommended = isset($_POST['recommended_news']) ? '1' : '0';
    
    update_post_meta($post_id, '_featured_news', $featured);
    update_post_meta($post_id, '_recommended_news', $recommended);
}
add_action('save_post', 'cybernews_save_news_meta');

function cybernews_pagination() {
    global $wp_query;
    
    if ($wp_query->max_num_pages <= 1) return;
    
    $big = 999999999;
    
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '&laquo; Sebelumnya',
        'next_text' => 'Selanjutnya &raquo;',
        'type' => 'array',
        'mid_size' => 2
    ));
    
    if ($pagination) {
        echo '<nav class="pagination-wrap">';
        echo '<div class="nav-links">';
        foreach ($pagination as $page) {
            echo $page;
        }
        echo '</div>';
        echo '</nav>';
    }
}

class CyberNews_Popular_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'cybernews_popular_posts',
            'CyberNews - Berita Populer',
            array('description' => 'Widget untuk menampilkan berita populer')
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Berita Populer';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        
        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        $popular_posts = new WP_Query(array(
            'posts_per_page' => $number,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        ));
        
        if ($popular_posts->have_posts()):
            echo '<ul class="popular-posts-list">';
            while ($popular_posts->have_posts()): $popular_posts->the_post();
                ?>
                <li>
                    <?php if(has_post_thumbnail()): ?>
                    <div class="popular-post-thumbnail">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="popular-post-content">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                    </div>
                </li>
                <?php
            endwhile;
            echo '</ul>';
        endif;
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Berita Populer';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Judul:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">Jumlah post:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" 
                   name="<?php echo $this->get_field_name('number'); ?>" type="number" 
                   step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

// Register widget
function cybernews_register_widgets() {
    register_widget('CyberNews_Popular_Posts_Widget');
}
add_action('widgets_init', 'cybernews_register_widgets');

function cybernews_set_post_views() {
    if (is_single()) {
        $post_id = get_the_ID();
        $count = get_post_meta($post_id, 'post_views_count', true);
        
        if ($count == '') {
            delete_post_meta($post_id, 'post_views_count');
            add_post_meta($post_id, 'post_views_count', '1');
        } else {
            update_post_meta($post_id, 'post_views_count', $count + 1);
        }
    }
}
add_action('wp', 'cybernews_set_post_views');

function cybernews_customize_banners($wp_customize) {
    // Banner Settings
    $wp_customize->add_section('banner_settings', array(
        'title' => 'Pengaturan Banner',
        'priority' => 120,
    ));
    
    // Floating Banner
    $wp_customize->add_setting('banner_floating');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_floating', array(
        'label' => 'Banner Floating',
        'section' => 'banner_settings'
    )));
    
    // Left Banner
    $wp_customize->add_setting('banner_left');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_left', array(
        'label' => 'Banner Kiri',
        'section' => 'banner_settings'
    )));
    
    // Right Banner
    $wp_customize->add_setting('banner_right');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_right', array(
        'label' => 'Banner Kanan',
        'section' => 'banner_settings'
    )));
}
add_action('customize_register', 'cybernews_customize_banners');

function cybernews_enqueue_caption_scripts() {
    if(is_single()) {
        wp_enqueue_script('caption-toggle', get_template_directory_uri() . '/assets/js/caption-toggle.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'cybernews_enqueue_caption_scripts');

function cybernews_widgets_init() {
    register_sidebar(array(
        'name'          => 'Sidebar Kanan',
        'id'            => 'sidebar-right',
        'description'   => 'Widget area untuk sidebar kanan',
        'before_widget' => '<div class="before-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="judul-sidebar-right">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'cybernews_widgets_init');

function cybernews_enqueue_styles() {
    wp_enqueue_style('cybernews-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'cybernews_enqueue_styles');

// Fungsi untuk menambahkan iklan setelah paragraf tertentu
function cybernews_insert_post_ads($content) {
    if(is_single() && is_main_query()) {
        $ad_code = get_theme_mod('post_content_ad'); // Iklan dari customizer
        if(!$ad_code) return $content;

        $paragraphs = explode('</p>', $content);
        
        foreach($paragraphs as $index => $paragraph) {
            if(trim($paragraph)) {
                if($index === 2 || $index === 6) { // Setelah paragraf 3 dan 7
                    $paragraphs[$index] .= '<div class="post-banner">' . $ad_code . '</div>';
                }
            }
        }
        
        return implode('</p>', $paragraphs);
    }
    return $content;
}
add_filter('the_content', 'cybernews_insert_post_ads');

function cybernews_ads_customizer($wp_customize) {
    $wp_customize->add_section('ads_settings', array(
        'title' => 'Pengaturan Iklan',
        'priority' => 120,
    ));
    
    // Iklan Kiri
    $wp_customize->add_setting('banner_left');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_left', array(
        'label' => 'Banner Kiri',
        'section' => 'ads_settings'
    )));
    
    // Iklan Kanan
    $wp_customize->add_setting('banner_right');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_right', array(
        'label' => 'Banner Kanan',
        'section' => 'ads_settings'
    )));
    
    // Iklan Antara Post
    $wp_customize->add_setting('between_posts_ad');
    $wp_customize->add_control('between_posts_ad', array(
        'label' => 'Kode Iklan Antara Post',
        'section' => 'ads_settings',
        'type' => 'textarea'
    ));
    
    // Iklan Dalam Konten Post
    $wp_customize->add_setting('post_content_ad');
    $wp_customize->add_control('post_content_ad', array(
        'label' => 'Kode Iklan Dalam Konten',
        'section' => 'ads_settings',
        'type' => 'textarea'
    ));
}
add_action('customize_register', 'cybernews_ads_customizer');

// Custom Logo Setup
function cybernews_custom_logo_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 77,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}
add_action('after_setup_theme', 'cybernews_custom_logo_setup');