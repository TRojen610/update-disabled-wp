<?php
/**
 * Plugin Name: Fatih Yaşar - XPerformance
 * Plugin URI: http://fatihyaşar.com.tr
 * Description:  Genel performans yaması, çalışan eklentilerdeki gereksiz kullanımları düzeltir ve siteyi besler. 
 * Version: 1.5.0
 * Author: Fatih Yaşar
 * Author URI: http://fatihyaşar.com.tr
 * License: GPL2
 */

function wpb_remove_version() {
return '';
}
add_filter('the_generator', 'wpb_remove_version');

add_filter( 'automatic_updater_disabled', '__return_true' );
add_filter( 'auto_update_core', '__return_false' );

function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

remove_action( 'wp_head', 'wp_generator'); // Removes the WordPress version i.e. - WordPress 2.8.4
//Remove generator name and version from your Website pages and from the RSS feed.
function completely_remove_wp_version() {
return ''; //returns nothing, exactly the point.
}
add_filter('the_generator', 'completely_remove_wp_version');

function remove_cssjs_ver( $src ) {
    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

add_filter('login_errors',create_function('$a', "return null;"));

remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}


function remove_footer_admin () {
 
echo 'Bu Panel <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Tarafından Yazılmış Olup, <a href="https://fatihyaşar.com.tr" target="_blank">Fatih Yaşar</a> Tarafından Güclendirilmiştir.</p>';
 
}
 
add_filter('admin_footer_text', 'remove_footer_admin');


