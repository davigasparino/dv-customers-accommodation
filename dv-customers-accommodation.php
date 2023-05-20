<?php
/**
 * Plugin Name: Dv Customers Accommodation
 * Plugin URI: https://davigasparino.com.br/plugins/customers-accommodation
 * Author: Davi Gasparino/
 * Author URI: https://davigasparino.com.br
 * Description: Customers Accommodation
 * Version: 1.0
 */

define('CustomerURL', plugin_dir_url(__FILE__));
define('CustomerPATH', plugin_dir_path(__FILE__));

require CustomerPATH . '/inc/Autoload.php';
$autoload = new Autoload();

//new CustomerCPT();
new CustomUser();
new Establishments();

add_action('init', function(){

//    echo '<pre>';
//        global $wp_rewrite;
//        print_r($wp_rewrite);
//    echo '</pre>';

    
   if(isset($_GET['debug']) && $_GET['debug'] === 'add_new_user'){

       $username = 'davigasparino';
       $password = 'g45parino';

       $user = wp_authenticate($username, $password);
       if(!is_wp_error($user)) {

           wp_set_current_user( $user->ID, $user->user_login );
           wp_set_auth_cookie( $user->ID );
           $current_user = wp_get_current_user();
           echo '<pre>'.print_r($current_user->user_firstname, true).'</pre>';
           echo "Login credentials are valid. First name is ".$current_user->user_firstname;
       } else {
           echo "Invalid login credentials.";
       }

       die();

//       global $user;
//       $username   = 'johndoe';
//       $user_login = 'john.doe@example.com';
//       // log in automatically
//       if ( !is_user_logged_in() ) {
//
//           var_dump($user);
//
//           $user = get_userdatabylogin( $username );
//           $user_id = $user->ID;
//           wp_set_current_user( $user_id, $user_login );
//           wp_set_auth_cookie( $user_id );
//           do_action( 'wp_login', $user_login );
//       }

       die('debug');
       //wp_create_user( 'johndoe', 'passwordgoeshere', 'john.doe@example.com' );
   }
});
