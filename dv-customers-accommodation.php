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
   if(isset($_GET['debug']) && $_GET['debug'] === 'add_new_user'){

   }
});

//função teste remover em breve
function ReadIcsFile(){
    //read ics file
    header( 'Content-Type: text/plain; charset=UTF-8' );
    $lines = file_get_contents( 'https://calendar.google.com/calendar/ical/32261e647b15d49cb0247baf0e12a2ddae078f2e11e1bbdaedb0961f227e6b62%40group.calendar.google.com/private-29944e6745c816e846acbf3fff74064f/basic.ics' );
    $convert = explode("\n", $lines); //create array separate by new line
    //$convert = explode(":", $lines); //create array separate by new line
    $linesArr = array();
    echo '<pre>';
    $headElements = array(
        'PRODID', 'VERSION', 'CALSCALE', 'METHOD', 'X-WR-CALNAME', 'X-WR-TIMEZONE', 'X-WR-CALDESC'
    );
    $pineOne = -1;
    $pineTwo = 0;
    $firstBegin = null;
    $othersBegins = null;
    foreach ($convert as $line){
        $theLine = explode(':', $line);

        $isEnd = false;
        if(isset($theLine[0], $theLine[1])){

            if($theLine[0] === 'BEGIN' && $firstBegin === null){
                $firstBegin = $theLine[1];
                $pineOne++;
            }else if($theLine[0] === 'BEGIN'){
                $linesArr[$pineOne][$firstBegin]['items'][$pineTwo][$theLine[0]] = $theLine[1];
            }

            if($theLine[1] !== $firstBegin){

                $FindItem = array_search($theLine[0], $headElements);
                if(is_int($FindItem)){
                    $linesArr[$pineOne][$firstBegin][$theLine[0]] = $theLine[1];
                }else{
                    $linesArr[$pineOne][$firstBegin]['items'][$pineTwo][$theLine[0]] = $theLine[1];
                }

                if($theLine[0] === 'END'){
                    $pineTwo++;
                }

            }elseif($theLine[0] === 'END' && $theLine[1] === $firstBegin){
                $firstBegin = null;
            }
        }
    }

    print_r($linesArr);
}

//função teste remover em breve
function AutomaticLogin(){
    $username = 'davigasparino';
    $password = 'escreva a senha aqui';

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
}