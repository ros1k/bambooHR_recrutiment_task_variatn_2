<?php
add_filter( 'show_admin_bar', '__return_false' );
function _theme_assets() {

    wp_enqueue_style( 'theme-bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '1.2.1', 'all' );
    wp_enqueue_style( 'theme-fontawesome-stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css', array(), '', 'all' );
    wp_enqueue_style( 'theme-stylesheet', get_template_directory_uri() . '/dist/css/style.css', array(), '1.2.1', 'all' );


    wp_enqueue_script('theme-jquery-scripts','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js','','',true);
    wp_enqueue_script('theme-popper-scripts','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js','','',true);
    wp_enqueue_script('theme-bootstrap-scripts','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js','','',true);
    wp_enqueue_script('theme-fontawesome-scripts','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js','','',true);
    wp_enqueue_script('theme-bamboo-scripts', get_template_directory_uri() . '/dist/js/app.js', array('jquery'), '1.2.1', true );
}
add_action('wp_enqueue_scripts', '_theme_assets');



if( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
        'page_title' 	=> 'Ustawienia motywu',
        'menu_title'	=> 'Ustawienia motywu',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ]);
}

register_nav_menus(array(
    'main_menu' => 'Menu główne',
    'second_menu' => 'Menu Podstrony',
    'footer_menu' => 'Menu stopka',
    'tablet_menu' => 'Menu Tablet'

));


add_theme_support('post-thumbnails');
add_image_size('featured_preview', 55, 55, true);
add_image_size('my_size', 375, 220, true);
add_image_size('my_large', 825, 500, true);




function get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}


function init_custom_slide_block(){
	if( function_exists('acf_register_block_type')){
		acf_register_block_type(array(
			'name' =>'rdslider',
			'title' => 'RD slider',
			'description' => 'a custom slider block made for recruitment purpose',
			'render_template' => 'custom_blocks/custom-gutenberg-block.php',
			'category'=>'layout',
			'icon' => 'slides',
			'align'             => 'full',
			'keywords' => array('custom slider','slider'),
			'enqueue_assets' => function(){
				wp_enqueue_style( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css', array(), '1.8.1' );
                wp_enqueue_style( 'slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css', array(), '1.8.1' );
                wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true );

                wp_enqueue_style( 'block-slider', get_template_directory_uri() . '/assets/css/custom-slider.css', array(), '1.0.0' );
                wp_enqueue_script( 'block-slider', get_template_directory_uri() . '/assets/js/custom-slider.js', array(), '1.0.0', true );
			}
		));
	}
}
add_action( 'init', 'init_custom_slide_block' );
