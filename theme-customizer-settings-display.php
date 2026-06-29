<?php

    /**=======================================================================
	 * Topic: 1 - Register Customizer Sections, Settings & Fields
	 * ====================================================================== */

    function cust_register_customizer($wp_customizer)
    {

    $wp_customizer->add_panel('cust_theme_customizer', [
        'title'       => __('Customizer Theme Customizer'),
        'description' => __('Customization Sections and Fields for Customizer Theme'),
        'priority'    => 90, // the position of the menus in customizer lists
    ]);

    // section is container, collection of fields
    $wp_customizer->add_section('banner', [
        'title'           => __('Banner Section', 'cust'),
        'priority'        => 30,
        'panel'           => 'cust_theme_customizer',
        'active_callback' => 'is_front_page', 'is_home',
    ]);

    // setting id is required for display the control or fields value in front end
    $wp_customizer->add_setting('banner_heading', [
        'default'           => 'Write your banner heading',
        'type'              => 'theme_mod', // which field name in database the value will save, value: theme_mod or option
        'transport'         => 'postMessage',
        'sanitize_callback' => '', // callback function for sanitize and checks the value of this setting,
    ]);

    // types of fields
    $wp_customizer->add_control('banner_heading_text', [
        'label'    => __('Banner Heading Text'),
        'type'     => 'text',
        'section'  => 'banner',
        'settings' => 'banner_heading',
    ]);

    $wp_customizer->add_setting('banner_sub_heading', [
        'default'   => 'Write your banner sub heading',
        'transport' => 'refresh',
    ]);
    $wp_customizer->add_control('banner_sub_heading_text', [
        'label'           => __('Banner Sub Heading Text'),
        'type'            => 'textarea',
        'section'         => 'banner',
        'settings'        => 'banner_sub_heading',
        'active_callback' => 'cust_banner_sub_heading_control',
    ]);

    $wp_customizer->add_setting('banner_sub_heading_checkbox', [
        'default'  => 1,
        'tranport' => 'refresh',
    ]);
    $wp_customizer->add_control('banner_sub_heading_checkbox', [
        'label'   => __('Display Banner Sub Heading'),
        'section' => 'banner',
        'type'    => 'checkbox',
    ]);

    $wp_customizer->add_setting('select_pages', [
        'transport' => 'refresh',
    ]);
    $wp_customizer->add_control('select_relative_pages', [
        'label'          => __('Select Relative Pages'),
        'section'        => 'banner',
        'settings'       => 'select_pages',
        'type'           => 'dropdown-pages',
        'allow_addition' => true,
    ]);

    /** Services Section */
    $wp_customizer->add_section('service', [
        'title'           => 'Service Section',
        'panel'           => 'cust_theme_customizer',
        'active_callback' => function () { // callback or anonymous function for display the sections based on conditions
            if (is_front_page() || is_home()) {
                return true;
            }
        },
    ]);
    $wp_customizer->add_setting('service_icon', [
        'default'           => '#dd2d6a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);
    $wp_customizer->add_control(new WP_Customize_Color_Control($wp_customizer, 'service_icon_color', [
        'label'    => __('Select icon color'),
        'section'  => 'service',
        'settings' => 'service_icon',
    ]));

    /** About page */
    $wp_customizer->add_section('about_page', [
        'title'           => __('About Page Content'),
        'priority'        => '50',
        'panel'           => 'cust_theme_customizer',
        'active_callback' => function () {
            if (is_page_template('page-templates/about-page.php')) {
                return true;
            }
        },
    ]);
    $wp_customizer->add_setting('about_heading', [
        'default'   => __('About Page Title'),
        'transport' => 'postMessage',
    ]);
    $wp_customizer->add_control('about_heading_text', [
        'label'    => __('About Page Heading Title'),
        'section'  => 'about_page',
        'settings' => 'about_heading',
        'type'     => 'text',
    ]);

    $wp_customizer->add_setting('about_description', [
        'default'   => __('This is the sub heading of about page'),
        'transport' => 'postMessage',
    ]);
    $wp_customizer->add_control('about_description', [
        'label'   => __('About Page Description Texts'),
        'section' => 'about_page',
        'type'    => 'textarea',
    ]);

    // image field
    $wp_customizer->add_setting('about_image', [
        'default'   => '',
        'transport' => 'postMessage',
    ]);

    /** Image Control */
    $wp_customizer->add_control(new WP_Customize_Image_Control($wp_customizer, 'about_image', [
        'label'   => __('About Page Featured Image'),
        'section' => 'about_page',
    ]));

    // image field
    $wp_customizer->add_setting('about_media', [
        'default'   => '',
        'transport' => 'postMessage',
    ]);

    /** Media Control */
    $wp_customizer->add_control(new WP_Customize_Media_Control($wp_customizer, 'about_media', [
        'label'     => __('About Media'),
        'section'   => 'about_page',
        'mime_type' => 'image',
    ]));

    // upload field
    $wp_customizer->add_setting('about_upload', [
        'default'   => 'Upload File',
        'transport' => 'postMessage',
    ]);

    /** Upload Control */
    $wp_customizer->add_control(new WP_Customize_Upload_Control($wp_customizer, 'about_upload', [
        'label'   => __('Upload Attachments'),
        'section' => 'about_page',
    ]));

    // cropped image field
    $wp_customizer->add_setting('about_crop_image', [
        'default'   => 'Select Preview Image',
        'transport' => 'postMessage',
    ]);

    /** Cropped Image Control */
    $wp_customizer->add_control(new WP_Customize_Cropped_Image_Control($wp_customizer, 'about_crop_image', [
        'label'   => __('Select Preview Image'),
        'section' => 'about_page',
    ]));

    /** =======================================================================
     * Topic: 4 - Live Preview features without js (Selective Refresh - Partial)
     * ====================================================================== */
    $wp_customizer->selective_refresh->add_partial('about_heading', [
        'selector'        => '#about-heading', // marker icon for changing front end html markup selector field
        'settings'        => 'about_heading',  // setting field name
        'render_callback' => function () {     // return the value of this setting field for display on the front end live update
            return get_theme_mod('about_heading');
        },
    ]);

    $wp_customizer->selective_refresh->add_partial('about_description', [
        'selector'        => '.about-description',
        'settings'        => 'about_description',
        'render_callback' => function () {
            return apply_filters('the_content', get_theme_mod('about_description'));
        },
    ]);

    $wp_customizer->selective_refresh->add_partial('about_attachment', [
        'selector'        => '.about-featured-image',
        'settings'        => 'about_image',
        'render_callback' => function () {
            $about_image_id = attachment_url_to_postid(get_theme_mod('about_image'));
            return wp_get_attachment_image($about_image_id, 'large');
        },
    ]);
    $wp_customizer->selective_refresh->add_partial('about_media_control', [
        'selector'        => '.about-media',
        'settings'        => 'about_media',
        'render_callback' => function () {
            $about_media_id = get_theme_mod('about_media');
            return wp_get_attachment_image($about_media_id, 'thumbnail');
        },
    ]);

    }
    add_action('customize_register', 'cust_register_customizer'); // hook for register customizer

    /** Callback functions of customizer settings fields conditional display */
    function cust_banner_sub_heading_control()
    {
    if (get_theme_mod('banner_sub_heading_checkbox') == 1) {
        return true;
    }
    return false;
    }

    /**=======================================================================
 	 * Topic: 2 - Display customizer values in front end
 	 * ====================================================================== */

    //---------------- Display html fields (text, image) value on theme content display files(such as: index.php, content.php)

    if ('' === get_theme_mod('banner_heading')) { // first check is there any value in this field
    return;
    } else {
    echo esc_html__(get_theme_mod('banner_heading', 'Default Banner Heading text'));
    }

    //---------------- Display image
    // at first we need the check what we get, image id or image src

    /* If get image src,
	 we can use that src to an anchor or image src property to display the image */
     ?>
     <img src="<?php 
            if(get_theme_mod('about_image') !== ''){
                echo get_theme_mod('about_image');  
            }
            else { // if there is no image src given we display a default image here
                echo "https://images.unsplash.com/photo-1675000946368-eb38f577a1e6";
            }?>"
            width="full" height="auto" alt="feature-image">
	<?php 
	
	/* or just first getting image id from image src then display the image with desired sizes, this will automatically generates a image tag */
    $image_id = attachment_url_to_postid(get_theme_mod('about_image'));
    echo wp_get_attachment_image($image_id, 'large');

    /* If get image id,
	 only use one function for display the image with desired sizes */
    $media_id = get_theme_mod('about_media');
    echo wp_get_attachment_image($media_id, 'thumbnail');

    //----------------- Display or change css styles

    /* There are two ways to display or changes the css properties on front end,
	 Way: 1 - first way, using wp_head() function and change the property value with the field value, in this way the styles will be added on wp_head tag */
    function cust_customizer_styles()
    {
    ?>
	<style>
		.service i {
			color: <?php echo get_theme_mod('service_icon', '#dd2d6a') ?>;
		}
	</style>
	<?php
        }
    add_action('wp_head', 'cust_customizer_styles');

	/* ------------
	 Way: 2 -, via inline-style, adding inline styles to theme style files, in wp_enqueue_scripts hooks add a function called wp_add_inline_style(), then name the main style file handle for overridding and then a variable that consists of all styles properties

	 ** Use a heredoc for all style properties to be override */
	function cust_assets()
	{
		wp_enqueue_style('cust-main', get_stylesheet_uri(), [], time());

		/* icon color */
		$service_icon_color = get_theme_mod('service_icon', '#dd2d6a');
		$customizer_styles  = <<<STYLE
			.service i {
				color: {$service_icon_color};
			}
STYLE;

        wp_add_inline_style('cust-main', $customizer_styles);
    }
    add_action('wp_enqueue_scripts', 'cust_assets');

	/**=======================================================================
	 * Topic: 3 - Js for customizer live preview without refreshing the whole page
	 * ====================================================================== */
	/*
		For changing the values using js there is two things need to do

		1 = enqueue the js file using customize_preview_init hook with customize-preview dependency

		2 = write the script for handling the values */

	// enqueue customizer js file
	function cust_customizer_scripts()
	{
		wp_enqueue_script('cust-customizer-script', get_theme_file_uri('/assets/js/customizer.js'), ['jquery', 'customize-preview'], time(), true);
	}
	add_action('customize_preview_init', 'cust_customizer_scripts');
    ?>
	<!-- js for customizer live preview and value changing -->
	<script>
	;(function($){
			wp.customize('banner_heading', function(value){		// ('') customizer setting name
        value.bind(function(newValue){
            $('.banner-heading-text').html(newValue);			// ('') front end markup selector
        });
    });

    wp.customize('service_icon', function(value){				// ('') customizer setting name
        value.bind( function (newValue) {
            $('.service i').css('color', newValue);				// ('') front end markup selector
        })
    })
	})(jQuery)
	</script>