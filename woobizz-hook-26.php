<?php
/*
Plugin Name: Woobizz Hook 26 
Plugin URI: http://woobizz.com
Description: Change Login text on checkout page for non logged users
Author: Woobizz
Author URI: http://woobizz.com
Version: 1.0.0
Text Domain: woobizzhook26
Domain Path: /lang/
*/
//Prevent direct acces
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Load translation
add_action( 'plugins_loaded', 'woobizzhook26_load_textdomain' );
function woobizzhook26_load_textdomain() {
  load_plugin_textdomain( 'woobizzhook26', false, basename( dirname( __FILE__ ) ) . '/lang' ); 
}
//Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	//echo "woocommerce is active";
    add_filter( 'woocommerce_coupons_enabled', 'woobizzhook26_change_login_text' );
}else{
	//Show message on admin
	//echo "woocommerce is not active";
	add_action( 'admin_notices', 'woobizzhook26_admin_notice' );
}

//Hook26 Notice
function woobizzhook26_admin_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Woobizz hook 26 needs woocommerce to work properly, please install and activate woocommerce or disable this plugin.', 'woobizzhook26' ); ?></p>
    </div>
    <?php
}

//Add Hook 26 
function woobizzhook26_change_login_text() {
        $woobizzhook26_login_text= __('if it is your first purchase, your account will be automatically created and sent to your email, if you are already a customer and want to buy faster','woobizzhook26');
	    return $woobizzhook26_login_text;
}
function redirect() {
  if (!is_user_logged_in() ) {
      add_filter( 'woocommerce_checkout_login_message', 'woobizzhook26_change_login_text' );
  }
}
add_action( 'wp', 'redirect' );
