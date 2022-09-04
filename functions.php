<?php

function get_the_user_ip() {

if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

//check ip from share internet

$ip = $_SERVER['HTTP_CLIENT_IP'];

} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

//to check ip is pass from proxy

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

} else {

$ip = $_SERVER['REMOTE_ADDR'];

}

return apply_filters( 'wpb_get_ip', $ip );

}

add_shortcode('display_ip', 'get_the_user_ip');

function theme_styles() {

	wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'my_style_css', get_template_directory_uri() . '/style.css');
	wp_enqueue_style( 'font_awasome_css', get_template_directory_uri() . '/font_awasome/css/font-awesome.min.css');
	wp_enqueue_style( 'coookiesbar_css', get_template_directory_uri() . '/css/jquery.cookiebar.css');
	if ( is_page_template( 'slot-review-page-writers-template.php' ) || is_page_template( 'casino-review-page-writers-template.php' ) ) {
        wp_enqueue_style( 'mycss', 'https://www.bonocasino.es/wp-content/plugins/js_composer5.1.1/assets/css/js_composer.min.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

function theme_js() {
	global $wp_scripts;

	wp_register_script( 'html5_shiv', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', '', '', false );
	wp_register_script( 'respond_js', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', '', '', false );

	$wp_scripts->add_data( 'html5_shiv', 'conditional', 'lt IE 9' );
	$wp_scripts->add_data( 'respond_js', 'conditional', 'lt IE 9' );
	//wp_enqueue_script( 'extr_js_mobile', get_template_directory_uri() . '/js/external.js', array('jquery'), '', true);
 //wp_enqueue_script( 'coookiesbar_js', get_template_directory_uri() . '/js/jquery.cookiebar.js', array('jquery'), '', true);
	if ( wp_is_mobile() ) {
	    //wp_enqueue_script( 'bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true);
		  
   wp_enqueue_script( 'extr_js_mobile', get_template_directory_uri() . '/js/external.js', array('jquery'), '', true);
		//wp_enqueue_script( 'setbackdesk_js_mobile', get_template_directory_uri() . '/js/setscript.js', array('jquery'), '', true);
} else {
   wp_enqueue_script( 'extr_desktop', get_template_directory_uri() . '/js/externaldesk.js', array('jquery'), '', true);
		//wp_enqueue_script( 'setbackdesk_desktop', get_template_directory_uri() . '/js/setbackdesk.js', array('jquery'), '', true);
}
   //wp_enqueue_script( 'extr_js', get_template_directory_uri() . '/js/external.js', array('jquery'), '', true);
  
	wp_enqueue_script( 'imge_js', get_template_directory_uri() . '/js/DMCABadgeHelper.min.js', array('jquery'), '', true);
	//wp_enqueue_script( 'slider_carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1.js', array('jquery'), '', true);	
    
}

add_action( 'wp_enqueue_scripts', 'theme_js' );

/*
add_action('admin_enqueue_scripts', 'unload_all_jquery');
function unload_all_jquery() {
    //wp_enqueue_script("jquery");
    $jquery_ui = array(
        "jquery-ui-tooltip"
    );

    foreach($jquery_ui as $script){
        wp_deregister_script($script);
    }
}
*/

add_action( 'wp_enqueue_scripts', 'my_deregister_javascript' );
function my_deregister_javascript() {
   if ( is_front_page() || is_page() ||is_single() || is_home()  ) {
        wp_deregister_script('jquery-ui-tooltip');
        wp_deregister_script('jquery-ui-widget');
       wp_deregister_script('jquery-ui-progressbar');
   }
}


add_theme_support( 'post-thumbnails' ); 

add_theme_support( 'menus' );

function register_theme_menus() {

	register_nav_menus(

		array(

			'header-menu' => __( 'Header Menu' )

		)

	);

}

add_action( 'init', 'register_theme_menus' );

add_theme_support( 'custom-background' );

add_theme_support( 'custom-header' );

$defaults = array(

	'default-image'          => get_template_directory_uri() . '/img/banner.png',

	'width'                  => 0,

	'height'                 => 0,

	'flex-height'            => false,

	'flex-width'             => false,

	'uploads'                => true,

	'random-default'         => false,

	'header-text'            => true,

	'default-text-color'     => '',

	'wp-head-callback'       => '',

	'admin-head-callback'    => '',

	'admin-preview-callback' => '',

);

add_theme_support( 'custom-header', $defaults );



/* Logo Change Start */

	  function m1_customize_register( $wp_customize ) {

		  $wp_customize->add_setting( 'm1_logo' ); // Add setting for logo uploader

		  // Add control for logo uploader (actual uploader)

		  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'm1_logo', array(

			  'label'    => __( 'Upload Logo (replaces text)', 'm1' ),

			  'section'  => 'title_tagline',

			  'settings' => 'm1_logo',

		  ) ) );

	  }

	  add_action( 'customize_register', 'm1_customize_register' );

/* Logo Change End */


/*expert length in home page*/
    function get_the_homepage_excerpt(){
        $excerpt = get_the_content();
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);
        $the_str = substr($excerpt, 0, 150);
        return $the_str;
    }
/*expert length in home page*/




///////// Custom Color Change Start ////////////

class MyTheme_Customize {

   /**

    * This hooks into 'customize_register' (available as of WP 3.4) and allows

    * you to add new sections and controls to the Theme Customize screen.

    * Note: To enable instant preview, we have to actually write a bit of custom

    * javascript. See live_preview() for more.

    * @see add_action('customize_register',$func)

    * @param \WP_Customize_Manager $wp_customize

    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/

    * @since MyTheme 1.0

    */

   public static function register ( $wp_customize ) {

      //1. Define a new section (if desired) to the Theme Customizer

      $wp_customize->add_section( 'mytheme_options', 

         array(

            'title' => __( 'MyTheme Options', 'mytheme' ), //Visible title of section

            'priority' => 35, //Determines what order this appears in

            'capability' => 'edit_theme_options', //Capability needed to tweak

            'description' => __('Allows you to customize some example settings for MyTheme.', 'mytheme'), //Descriptive tooltip

         ) 

      );      



      //2. Register new settings to the WP database...

      $wp_customize->add_setting( 'container_boxcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record

         array(

            'default' => '#2BA6CB', //Default setting/value to save

            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?

            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.

            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?

         ) 

      );      



      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...

      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class

         $wp_customize, //Pass the $wp_customize object (required)

         'mytheme_container_boxcolor', //Set a unique ID for the control

         array(

            'label' => __( 'Container Color', 'mytheme' ), //Admin-visible name of the control

            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)

            'settings' => 'container_boxcolor', //Which setting to load and manipulate (serialized is okay)

            'priority' => 10, //Determines the order this control appears in for the specified section

         ) 

      ) );

}



public static function header_output() {

      ?>

      <!--Customizer CSS--> 

      <style type="text/css">

           <?php self::generate_css('#container', 'background-color', 'container_boxcolor', ''); ?> 

      </style> 

      <!--/Customizer CSS-->

      <?php

   }



 public static function live_preview() {

      wp_enqueue_script( 

           'mytheme-themecustomizer', // Give the script a unique ID

           get_template_directory_uri() . '/assets/js/theme-customizer.js', // Define the path to the JS file

           array(  'jquery', 'customize-preview' ), // Define dependencies

           '', // Define a version (optional) 

           true // Specify whether to put in footer (leave this true)

      );

   }



 public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {

      $return = '';

      $mod = get_theme_mod($mod_name);

      if ( ! empty( $mod ) ) {

         $return = sprintf('%s { %s:%s; }',

            $selector,

            $style,

            $prefix.$mod.$postfix

         );

         if ( $echo ) {

            echo $return;

         }

      }

      return $return;

    }

}

// Setup the Theme Customizer settings and controls...

add_action( 'customize_register' , array( 'MyTheme_Customize' , 'register' ) );

// Output custom CSS to live site

add_action( 'wp_head' , array( 'MyTheme_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen

add_action( 'customize_preview_init' , array( 'MyTheme_Customize' , 'live_preview' ) );

///////// Custom Color Change End ////////////



/************* Inside Menu in Page   *************/



function shortcode_show_menu( $atts, $content, $tag ) {

	global $post;

	

	// Set defaults

	$defaults = array(

		'menu'        	  => '',

		'container'       => 'div', 

		'container_class' => 'navbar', 

		'container_id'    => '',

		'menu_class'      => 'nav navbar-nav', 

		'menu_id'         => '',

		'fallback_cb'     => 'wp_page_menu',

		'before'          => '',

		'after'           => '',

		'link_before'     => '',

		'link_after'      => '',

		'depth'			  => 0,

		'echo' 			  => false

	);

	// Merge user provided atts with defaults

	$atts = shortcode_atts( $defaults, $atts );



	// Create output

	$out = wp_nav_menu( $atts );

	return apply_filters( 'shortcode_show_menu', $out, $atts, $content, $tag );

}

add_shortcode( 'show-menu', 'shortcode_show_menu' );

/************** End *********/

/* Create Widgets */
function wpt_create_widget($name, $id, $description)
{	
	register_sidebar(array(
	'name' => __($name),
	'id' => __($id),
	'description' => __($description),
	'before_widget' => '<div class="widget"><div class="widget_inner">',
	'after_widget' => '</div></div>',
	'before_title' => '<h3 class="widget-title"><i class="fa fa-chevron-circle-right"></i>',
	'after_title' => '</h3>'
	));
}

create_widget( 'Banner Part', 'banner_part', 'Displays Banner');

create_widget( 'Poker Sites', 'poker_sites', 'Displays Poker Sites');

create_widget( 'Mejores Bonos sticky', 'mejores_bonos_sticky', 'Displays Mejores Bonos Sticky');

create_widget( 'Best Poker Sites', 'best_poker_sites', 'Displays Best Poker Sites');

create_widget( 'Popular Games Sidebar', 'popular_games_sidebar', 'Displays Popular Games on sidebar');

create_widget( 'Recent Posts', 'recent_posts', 'Displays Recent Posts');

create_widget( 'Our Featured Casino', 'our_featured_casino', 'Displays Our Featured Casino');

create_widget( 'Email Subscription', 'email_subscription', 'Displays Email Subscription');

create_widget( 'Big Banner Img', 'big_banner_img', 'Displays oBig Banner Img');


/* Create Widgets */

function create_widget($name, $id, $description)

{	

	register_sidebar(array(

	'name' => __($name),

	'id' => __($id),

	'description' => __($description),

	'before_widget' => '<div class="widget"><div class="widget_inner">',

	'after_widget' => '</div></div>',

	'before_title' => '<h3>',

	'after_title' => '</h3>'

	));

}

create_widget( 'Front Page Left', 'front-left', 'Displays on the left of the homepage');

create_widget( 'Front Page Center', 'front-center', 'Displays on the center of the homepage');

create_widget( 'Front Page Right', 'front-right', 'Displays on the right of the homepage');

create_widget( 'Page Sidebar', 'page', 'Displays on the side of the page with Sidebar');

create_widget( 'Blog Sidebar', 'blog', 'Displays on the side of the page in the Blog section');

create_widget( 'Sidebar Bottom Video', 'sidebar_bottom_video', 'Displays Sidebar Bottom Video');

// custom admin login logo

function custom_login_logo() {

 echo '<style type="text/css">

 h1 a { background-image: url('.get_bloginfo('template_directory').'/img/bonocasino.png) !important; background-size:300px !important; width:100% !important;height: 50px !important;}

 </style>';

}
add_action('login_head', 'custom_login_logo');

/********************* For change schema lang from Yoast SEO and disable Author*********************/
add_filter( 'wpseo_schema_needs_author', '__return_false' );
add_filter( 'wpseo_schema_needs_breadcrumb', '__return_false' );

add_filter( 'wpseo_schema_webpage', 'change_article_author' );
function change_article_author( $data ) {
  $data['author'] = array();
  return $data;
} 
/********************* For change schema lang from Yoast SEO and disable Author *********************/


/********************* For Disable RSS Feed *********************
function itsme_disable_feed() {
    wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}
add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);

/***** Remove the header links to your RSS feeds *****
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
/********************* For Disable RSS Feed *********************/


/********************* to remove Anterior/page/1/ ********************/
add_filter('paginate_links', function($link) {
    $pos = strpos($link, 'page/1/');
    if($pos !== false) {
        $link = substr($link, 0, $pos);
    }
    return $link;
});
/********************* to remove Anterior/page/1/ ********************/

add_action('wp_print_scripts', 'wra_filter_scripts', 100000);
add_action('wp_print_footer_scripts',  'wra_filter_scripts', 100000);
 
function wra_filter_scripts(){
    #wp_deregister_script($handle);
    #wp_dequeue_script($handle);

    wp_deregister_script('wpb_composer_front_js');
    wp_deregister_script('waypoints');
}


/********** Change Excerpt Length in Latest Posts *********/
function custom_length_excerpt($word_count_limit) {
    $content = wp_strip_all_tags(get_the_content() , true );
    echo wp_trim_words($content, $word_count_limit);
}
/********** Change Excerpt Length in Latest Posts *********/


/********************* For Performance Enable Contact Plugin Css & Js only in Contactus Page *********************/
//********** For Js ***
add_action( 'wp_print_scripts', 'deregister_cf7_javascript', 100 );
function deregister_cf7_javascript() {
    if ( !is_page(array(841)) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}

//********** For Css ***
add_action( 'wp_print_styles', 'deregister_cf7_styles', 100 );
function deregister_cf7_styles() {
    if ( !is_page(array(841)) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}
/********************* For Performance Enable Contact Plugin Css & Js only in Contactus Page *********************/

/********************* For Disable/Hide/Remove Unwanted menu's from Admin Menu for AUTHORs Only ********************/
if ( current_user_can( 'author' ) ) {
	// Redirect to dashboard page when the Author goto profile page
	add_action( 'load-profile.php', function() {
		exit( wp_safe_redirect( admin_url() ) );
	} );
	
    add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );
    function wpse_136058_remove_menu_pages() {
        remove_menu_page( 'wpcf7' );
        remove_menu_page( 'vc-welcome' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit.php?post_type=onerow_tablepress' );
        remove_menu_page( 'profile.php' );
    }
    
    add_action( 'admin_footer', 'wpse_136058_remove_menu_pages_22' );
    function wpse_136058_remove_menu_pages_22() {
        echo "<style>
            #wp-admin-bar-new-onerow_tablepress, #wp-admin-bar-new-media, .acf-field-5dd25285ee439, .acf-field-5dd2529dee43a, .acf-field-5df9b33d447c5, #wp-admin-bar-edit-profile, #toplevel_page_wpseo_workouts, .acf-field-5a530752db9c6, .acf-field-5a53076fdb9c7, #wp-admin-bar-new-apl_post_list
            { display: none; }
        </style>";
        echo "<script>
            jQuery('#wp-admin-bar-new-onerow_tablepress').remove();
            jQuery('#wp-admin-bar-new-media').remove();
			jQuery('#toplevel_page_WFLS').remove();
        </script>";
    }
}    
/********************* For Disable/Hide/Remove Unwanted menu's from Admin Menu for AUTHORs Only ********************/

/************* For Remove Goto Pages Editor & Author Role Only ****************/
function prasath_exclude_pages_from_admin($query) {
	global $pagenow, $post_type;
	if ( current_user_can( 'author' ) && $pagenow == 'edit.php' && $post_type == 'page' )
	{
    	$query->query_vars['post_parent__not_in'] = array( '335'); // Enter your page IDs here
		$query->query_vars['post__not_in'] = array( '335');
	}
}
add_filter( 'parse_query', 'prasath_exclude_pages_from_admin' ); 
/************* For Remove Goto Pages Editor & Author Role Only *****************/

/******************** For Search Results Code *******************/
function wpshock_search_filter( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', array('post','page') );
		//$query->set( 'exact', true );
		$query->set( 'posts_per_page', '-1' );
		$query->set( 'order', 'ASC' );
    }
    return $query;
}
add_filter('pre_get_posts','wpshock_search_filter');  

add_filter('posts_search', 'my_search_is_exact', 20, 2);
function my_search_is_exact($search, $wp_query){

    global $wpdb;

    if(empty($search))
        return $search;

    $q = $wp_query->query_vars;
    //$n = !empty($q['exact']) ? '' : '%';

    $search = $searchand = '';

    foreach((array)$q['search_terms'] as $term) :

        $term = esc_sql(like_escape($term));

        $search.= "{$searchand}($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]') OR ($wpdb->posts.post_content REGEXP '[[:<:]]{$term}[[:>:]]')";

        $searchand = ' AND ';

    endforeach;

    if(!empty($search)) :
        $search = " AND ({$search}) ";
        if(!is_user_logged_in())
            $search .= " AND ($wpdb->posts.post_password = '') ";
    endif;
    return $search;
}
/******************** For Search Results Code *******************/

/********** Remove goto from search pages **************/
function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_parent__not_in', array(335)); // here 335 is id of goto page or parent page which we don't need
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');
/********** Remove goto from search pages **************/


	
	/**
 * Validate IP Address During Authentication - For A Given User *
add_filter( 'authenticate', function( $user )
{
    // Adjust to your needs:
    $allowed_user_ip1        = '127.0.0.1';
    $ip_restricted_user_id  = 1;
				    $current_user_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : null;

				$allowed_user_ip = "85.94.182.86,185.230.124.2,103.59.133.22,188.72.97.133,188.72.97.137,78.129.249.186,95.154.253.78,104.250.170.32,109.123.90.94,78.129.249.56,78.129.249.243,188.72.97.185,82.145.51.107,95.154.253.187,45.74.40.133";
	
//Using the explode method
$arr_ph = explode(",",$allowed_user_ip);

//foreach loop to display the returned array
foreach($arr_ph as $i){
	if( $current_user_ip === $i )
        return $user;
    
} 

    // Current user's IP address

    // Nothing to do for valid IP address
    

    // Nothing to do for users that are not IP restricted 
    if( 
           $user instanceof \WP_User 
        && $user->ID > 0
        && $ip_restricted_user_id != $user->ID
    )   
        return $user;

    // Add an 'Invalid IP address' error
    if( is_wp_error( $user ) )
        $user->add( 
            'invalid_ip', 
            sprintf(
            '<strong>%s</strong>: %s',
            esc_html__( 'ERROR', 'mydomain' ),
            esc_html__( 'IP address is invalid.', 'mydomain' )
        )
    ); 
    // Create a new 'Invalid IP address' error
    else
        $user = new WP_Error(
            'invalid_ip', 
            sprintf(
                '<strong>%s</strong>: %s',
                esc_html__( 'ERROR', 'mydomain' ),
                esc_html__( 'IP address is invalid.', 'mydomain' )
            )
        ); 

    return $user;
}, 100 ); 

/*recaptcha language*
add_action( 'wpcf7_enqueue_scripts', 'custom_recaptcha_enqueue_scripts', 11 );

function custom_recaptcha_enqueue_scripts() {
	wp_deregister_script( 'google-recaptcha' );

	$url = 'https://www.google.com/recaptcha/api.js';
	$url = add_query_arg( array(
		'onload' => 'recaptchaCallback',
		'render' => 'explicit',
	 	'hl' => 'es' ), $url );

	wp_register_script( 'google-recaptcha', $url, array(), '2.0', true );
}
/*recaptcha language*/

/****************** Remove Recaptcha - Except Contact page ****************/
add_action( 'wp_enqueue_scripts', 'custom_load_contact_form_resources', 1 );
function custom_load_contact_form_resources() {
	global $post;
	if ( isset( $post ) && is_singular() && has_shortcode( $post->post_content, 'contact-form-7' ) ) {
		return;
	}
	remove_action( 'wp_enqueue_scripts', 'wpcf7_do_enqueue_scripts' );
	remove_action( 'wp_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts', 20 );
}
/****************** Remove Recaptcha - Except Contact page ****************/

/********************* Move page/1/ to blog/ ********************/
add_filter('paginate_links', function($link) {
    $pos = strpos($link, 'page/1/');
    if($pos !== false) {
        $link = substr($link, 0, $pos);
    }
    return $link;
});
/********************* Move page/1/ to blog/ ********************/

add_filter( 'wpseo_breadcrumb_single_link', 'wpseo_remove_breadcrumb_link', 10 ,2);
function wpseo_remove_breadcrumb_link( $link_output , $links ){
	$page_src = $links['url'];
	$last_word = basename( $page_src );
	$text_to_remove = 'tragaperras';

	if( $last_word == $text_to_remove ) {
	  $link_output = '<a href="https://www.bonocasino.es/tragaperras-online/">Tragaperras</a>';
	}

	return $link_output;
}

/********************* to enable HTML tags for Author Biographical Info ************************/
remove_filter('pre_user_description', 'wp_filter_kses');
/********************* to enable HTML tags for Author Biographical Info ************************/
/************************ To change the automated error log mail address *******************************/
add_filter( 'recovery_mode_email', 'recovery_email_update', 10, 2 );
  function recovery_email_update( $email, $url ) {
    $email['to'] = 'mithu@epicorns.com';
    return $email;
 }
/************************ To change the automated error log mail address *******************************/

/********************* For Disable/Hide/Remove Unwanted menu's from Admin Menu for contributor Only ********************
if ( current_user_can( 'contributor' ) ) {
    add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );
    function wpse_136058_remove_menu_pages() {
        remove_menu_page( 'wpcf7' );
        remove_menu_page( 'vc-welcome' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit.php?post_type=onerow_tablepress' );			
        //remove_menu_page( 'upload.php' );
    }
    
    add_action( 'admin_footer', 'wpse_136058_remove_menu_pages_22' );
    function wpse_136058_remove_menu_pages_22() {
        echo "<style>
            #wp-admin-bar-new-onerow_tablepress, #wp-admin-bar-new-media
            { display: none; }
        </style>";
        echo "<script>
            jQuery('#wp-admin-bar-new-onerow_tablepress').remove();
            jQuery('#wp-admin-bar-new-media').remove();
			jQuery('#toplevel_page_WFLS').remove();
        </script>";
    }	
}    
/********************* For Disable/Hide/Remove Unwanted menu's from Admin Menu for contributor Only ********************/

/****************** To Remove Schema from YASR plugin ******************/
add_filter('yasr_filter_schema_jsonld', function () {return false;});
/****************** To Remove Schema from YASR plugin ******************/
function my_admin_enqueue_scripts() {

	wp_enqueue_script( 'my-admin-js', get_template_directory_uri() . '/js/custom-field.js', array(), '1.0.0', true );

}

add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');
/****************** For ACF - show_in_tables as no ******************/
add_action('acf/save_post', 'my_acf_save_post');
function my_acf_save_post( $post_id ) {
    // Get newly saved values.
    $values = get_fields( $post_id );
    // Check the new value of a specific field.
    $active_or_not_working = get_field('active_or_not_working', $post_id);
	$no="no";
    if( $active_or_not_working=='notworking' ) {
        update_field('show_in_tables', $no);
    }
}
/****************** For ACF - show_in_tables as no ******************/
/********************* casino tablepress shortcode *********************/
include_once('casino-tablepress.php');
include_once('casino-tablepress-ajax.php');
require_once('shortcodes/casino-list-with-multiple-design.php');
//one row for pages
require_once('shortcodes/one-row-pages.php');
require_once('shortcodes/page-top-rated-cta-link.php');
/********************* casino tablepress shortcode *********************/
add_filter( 'tablepress_use_default_css', '__return_false' );


function remove_default_css() {
    wp_dequeue_style( 'bsf-Defaults' );
 }
add_action('wp_enqueue_scripts','remove_default_css',999);

/**************Disable backend js****************/
function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    //wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . '/myscript.js');
	 wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery-1.12.4-wp.js' ,array(),'1.12.4');		
	wp_enqueue_script('jquery');
	wp_deregister_script( 'jquery-migrate' );
 wp_register_script( 'jquery-migrate', '/wp-includes/js/jquery/jquery-migrate-1.4.1-wp.js', null, null, true);		
	wp_enqueue_script('jquery-migrate');
	wp_deregister_script( 'jquery-ui-core' );
 wp_register_script( 'jquery-ui-core', '/wp-includes/js/jquery/ui/core.min.js' );		
	wp_enqueue_script('jquery-ui-core');
	
}
add_action('admin_enqueue_scripts', 'my_enqueue', 0);
define('CONCATENATE_SCRIPTS', false);



/********************* WordPress Featured Image in WordPress Admin Panel ********************
add_image_size( 'crunchify-admin-post-featured-image', 120, 120, false );
 
// Add the posts and pages columns filter. They can both use the same function.
add_filter('manage_posts_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
 
// Add the column
function crunchify_add_post_admin_thumbnail_column($crunchify_columns){
	$crunchify_columns['crunchify_thumb'] = __('Featured Image');
	return $crunchify_columns;
}
 
// Let's manage Post and Page Admin Panel Columns
add_action('manage_posts_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
 
// Here we are grabbing featured-thumbnail size post thumbnail and displaying it
function crunchify_show_post_thumbnail_column($crunchify_columns, $crunchify_id){
	switch($crunchify_columns){
		case 'crunchify_thumb':
		if( function_exists('the_post_thumbnail') )
			echo the_post_thumbnail( 'crunchify-admin-post-featured-image' );
		else
			echo 'hmm... your theme doesn\'t support featured image...';
		break;
	}
}
/********************* WordPress Featured Image in WordPress Admin Panel ********************/


// PHP code to obtain country, city, 
// continent, etc using IP Address
  

  
// Use JSON encoded string and converts
// it into a PHP variable
$ipdat = @json_decode(file_get_contents(
    "http://www.geoplugin.net/json.gp?ip=" . $ip));
// echo  $ip;
// echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n";
// echo 'City Name: ' . $ipdat->geoplugin_city . "\n";
// echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n";
// echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n";
// echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n";
// echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n";
// echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n";
// echo 'Timezone: ' . $ipdat->geoplugin_timezone;



function get_client_ip() {
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
     else
        $ipaddress = 'UNKNOWN';

     return $ipaddress;
}

function ip_details($url) {
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   $data = curl_exec($ch);
   curl_close($ch);

   return $data;
}
 $myipd = get_client_ip(); 
    $url = 'http://www.geoplugin.net/json.gp?ip='.$myipd; 
    $details    =   ip_details($url); 
    $v = json_decode($details);
    $mycountry = $v->geoplugin_countryName;

//echo  $mycountry;


// function getVisIpAddr() {
      
//     if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
//         return $_SERVER['HTTP_CLIENT_IP'];
//     }
//     else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//         return $_SERVER['HTTP_X_FORWARDED_FOR'];
//     }
//     else {
//         return $_SERVER['REMOTE_ADDR'];
//     }
// }
  
// // Store the IP address
// $ip = getVisIPAddr();

// $ipdat = @json_decode(file_get_contents(
//     "http://www.geoplugin.net/json.gp?ip=" . $ip));
   
// echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n";
// echo 'City Name: ' . $ipdat->geoplugin_city . "\n";
// echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n";
// echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n";
// echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n";
// echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n";
// echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n";
// echo 'Timezone: ' . $ipdat->geoplugin_timezone;


// if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
//     $ip = $_SERVER['HTTP_CLIENT_IP'];
// } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
// } else {
//     $ip = $_SERVER['REMOTE_ADDR'];
// }
// $ip = $_SERVER['REMOTE_ADDR'];
// $ip = do_shortcode( '[display_ip]' );

// // For https://ipinfo.io/
// $token = "24f65472b7bb9b";
// // For https://ipinfo.io/

// $details1 = json_decode(file_get_contents("https://ipinfo.io/" . $ip . "?token=" . $token));
// $details2 = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
// $details3 = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
// // echo $details->country; // -> "Mountain View"
// echo $details1->country.' - http://ipinfo.io/';
// echo '<br>';
// echo $details2->country.' - http://ip-api.com';
// echo '<br>';
// echo $details3->geoplugin_countryName.' - http://www.geoplugin.net';




/****************** For ACF - Getting Images URL ******************/
add_action('acf/save_post', 'prasath_acf_save_post', 10, 2 );
function prasath_acf_save_post( $post_id ) {
	if ( get_post_type( $post_id ) == 'slotsdb' ) {
    // Get newly saved values.
    $values = get_fields( $post_id );	
    // Check the new value of a specific field.
    $hero_image = get_field('logo_1_big', $post_id);
	$fimgID = attachment_url_to_postid( $hero_image ); 	
	$heroine_image = get_field('logo_1_url', $post_id);
	$fimgID2 = attachment_url_to_postid( "https://epicornsqa.com/bonocasino-es".$heroine_image ); 
	
	//update_field('logo_2_alt', 'Prasath');
	
	if( ($hero_image != '') && ($heroine_image == '') ) {
		$finalImgLink = str_replace("https://epicornsqa.com/bonocasino-es","",$hero_image);
		update_field('logo_1_url', $finalImgLink); //." - ".$fimgID." - ".$fimgID2);
    }
	else if( $heroine_image != '' ) {
		$finalImgLink = str_replace("https://epicornsqa.com/bonocasino-es","",$hero_image);
		update_field('logo_1_big', $fimgID2);
    }
	else { update_field('logo_1_url', ''); }
 }
}

/* For Dynamically change input value change when remove Image Thumb */
add_action( 'admin_footer', 'prasath_dynamically_change_value' );
function prasath_dynamically_change_value() {
    echo '<script>jQuery(document).ready(function(){
        var closeIcon = jQuery(".acf-field-5e5796ea02109 .acf-icon.dark");
        jQuery(closeIcon).click(function(){
            jQuery(".acf-field-5f5c9e046fee0 input").val("");
        });
    });	
    </script>';
}
/****************** For ACF - Getting Images URL ******************/
// $post_id             = 70915; // Set this to the ID of the post you want to update.
// $post_obj            = get_post( $post_id );
// $post_obj->post_type = 'india'; // Set this to the slug of your custom post type.
// wp_update_post( $post_obj );  

//    $post_id = 70915;
//     $post = (array) get_post( $post_id ); // Post to duplicate.

// echo count($post);
//     unset($post['ID']); // Remove id, wp will create new post if not set.
//    // wp_insert_post($post);

/*********************** For update specified CPT custom field ********************/

function update_my_metadata(){
    $args = array(
        'post_type' => 'any', // get the all posts,page,custom post type
        'post_status' => 'publish', // Only the posts that are published
        'posts_per_page'   => -1 // Get every post
    );
	$posts = get_posts($args);
	foreach ( $posts as $post ) {
	$current_id = $post->ID;
	$casinos = get_field('locations', $current_id);	
	$country_name = get_field('country_name', $casinos->ID);
	$radio= get_field('active_or_not_working', $casinos->ID);
	$checkbox= get_field('dont_show_in_game_and_payment_methods_page', $casinos->ID);
	$images = get_field('images', $casinos->ID);
	$select = get_field('game_providers', $casinos->ID);
		if($casinos != ''){ 
			update_post_meta( $current_id, 'locations', '' );
			update_post_meta( $current_id, 'country_name', $country_name );
			update_post_meta( $current_id, 'active_or_not_working', $radio );
			update_post_meta( $current_id, 'dont_show_in_game_and_payment_methods_page', $checkbox );
			update_post_meta( $current_id, 'images', $images );
			update_post_meta( $current_id, 'game_providers', $select );
		}
	}
}

//add_action('init','update_my_metadata');
add_action('acf/save_post','update_my_metadata');

/*********************** For update specified CPT custom field ********************/


// function codex_custom_init() {

//       register_post_type(
//         'testimonials', array(
//           'labels' => array('name' => __( 'Careers' ), 'singular_name' => __( 'Career' ) ),
//           'public' => true,
//           'has_archive' => true,
//  		  'show_in_menu' => 'edit.php?post_type=countries'
//         )
//       );

//       register_post_type(
//         'home-messages', array(
//           'labels' => array('name' => __( 'Emps Comnts' ), 'singular_name' => __( 'Emp Comnt' ) ),
//           'public' => true,
//           'has_archive' => true,
//  		  'show_in_menu' => 'edit.php?post_type=countries'
//         )
//       );

//     }
//     add_action( 'init', 'codex_custom_init' );

/**************** For Post Object autocomplete field working ***********************/

// Extend search to include pages and posts
function wp_search_filter( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', array('india') );
    }
    return $query;
}
add_filter('pre_get_posts','wp_search_filter');

/**************** For Post Object autocomplete field working ***********************/

$a = 12;
?>
