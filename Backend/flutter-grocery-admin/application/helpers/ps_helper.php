<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Read More
 *
 * @param      string  $string   string
 * @param      integer  $limit   character limit
 *
 * @return     string   ( description_of_the_return_value )
 */
if ( !function_exists( 'read_more' )) 
{
	function read_more( $string, $limit )
	{
		$string = strip_tags($string);
		
		if (strlen($string) > $limit) {
		
		    // truncate string
		    $stringCut = substr($string, 0, $limit);
		
		    // make sure it ends in a word so assassinate doesn't become ass...
		    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
		}
		return $string;
	}
}

/**
 * transform 'added date' display
 *
 * @param      integer  $time   The time
 *
 * @return     string   ( description_of_the_return_value )
 */
if ( ! function_exists( 'ago' ))
{
	function ago( $time )
	{
		// get ci instance
		$CI =& get_instance();
		//for language
		$conds['status'] = 1;
		$language = $CI->Language->get_one_by($conds);
		$language_id = $language->id;
		//for today language string
		$conds_today['key'] = "today_label";
		$conds_today['language_id'] = $language_id;
		$today_string = $CI->Language_string->get_one_by( $conds_today );
		$today_now = $just_string->value;
		if ( empty( $time )) return '"'.$today_now.'"';

		// get ci instance
		$CI =& get_instance();
		
		$time = mysql_to_unix( $time );
		$now = $CI->db->query('SELECT NOW( ) as now')->row()->now;
		$now = mysql_to_unix( $now );

		$periods = array("second_ago", "minute_ago", "hour_ago", "day_ago", "week_ago", "month_ago", "year_ago", "decade_ago");
		$lengths = array("60","60","24","7","4.35","12","10");

		$difference = $now - $time;

		for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		// if ($difference != 1) {
			// load the language
			$conds_str['key'] = $periods[$j];
			$conds_str['language_id'] = $language_id;
			$lang_string = $CI->Language_string->get_one_by( $conds_str );
			$message = $lang_string->value;
		//}
		//for just now language string
		$conds_now['key'] = "just_now_label";
		$conds_now['language_id'] = $language_id;
		$just_string = $CI->Language_string->get_one_by( $conds_now );
		$just_now = $just_string->value;
		//for ago language string
		$conds_ago['key'] = "ago_label";
		$conds_ago['language_id'] = $language_id;
		$ago_string = $CI->Language_string->get_one_by( $conds_ago );
		$ago = $ago_string->value;
		if ($difference==0) {
			return '"'.$just_now.'"';
		} else {
			return "$difference $message $ago";
		}
	}
}
/**
 * return the message
 *
 * @param      <type>  $key    The key
 */
if ( ! function_exists( 'get_msg' ))
{
	function get_msg( $key )
	{
		// get ci instance
		$CI =& get_instance();
		$conds['status'] = 1;
		$language = $CI->Language->get_one_by($conds);
		$language_id = $language->id;
		// load the language
		$conds_str['key'] = $key;
		$conds_str['language_id'] = $language_id;
		$lang_string = $CI->Language_string->get_one_by( $conds_str );
		$message = $lang_string->value;
		
		if ( empty( $message )) {
		// if message is empty, return the key
			return $key;
		}

		// return the message
		return $message;
	}
}

/**
 * return the message
 *
 * @param      <type>  $key    The key
 */
if ( ! function_exists( 'smtp_config' ))
{
	function smtp_config( )
	{
		// get ci instance
		$CI =& get_instance();
		$smtp_host = $CI->Backend_config->get_one('be1')->smtp_host;
		$smtp_port = $CI->Backend_config->get_one('be1')->smtp_port;
		$smtp_user = $CI->Backend_config->get_one('be1')->smtp_user;
		$smtp_pass = $CI->Backend_config->get_one('be1')->smtp_pass;

		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => $smtp_host,
		    'smtp_port' => $smtp_port,
		    'smtp_user' => $smtp_user, //sender@blog.panacea-soft.com //azxcvbnm
		    'smtp_pass' => $smtp_pass,
		    'mailtype'  => 'text', 
		    'charset'   => 'iso-8859-1'
		);
		
		return $config;
	}
}

/**
 * Show the flash message
 */
if ( ! function_exists( 'flash_msg')) 
{
	function flash_msg()
	{
		// get ci instance
		$CI =& get_instance();

		$CI->load->view( 'common/flash_msg' );
	}
}

/**
 * Shows the analytic.
 */
if ( ! function_exists( 'show_analytic' ))
{
	function show_analytic()
	{
		// get ci instance
		$CI =& get_instance();

		$CI->load->view( 'ps/analytic' );
	}
}

/**
 * Shows the ads.
 */
if ( ! function_exists( 'show_ads' ))
{
	function show_ads()
	{
		// get ci instance
		$CI =& get_instance();

		$CI->load->view( 'ps/ads' );
	}
}

/**
 * Shows the breadcrumb.
 *
 * @param      <type>  $urls   The urls
 */
if ( ! function_exists( 'show_breadcrumb' )) 
{
	function show_breadcrumb( $urls = array() )
	{
		// get ci instance
		$CI =& get_instance();

		$template_path = $CI->config->item( 'be_view_path' );

		// load breadcrumb
		$CI->load->view( $template_path .'/partials/breadcrumb', array( 'urls' => $urls )); 
	}
}

/**
 * Shows the breadcrumb.
 *
 * @param      <type>  $urls   The urls
 */
if ( ! function_exists( 'show_breadcrumb_att_detail' )) 
{
	function show_breadcrumb_att_detail( $urls = array() )
	{
		// get ci instance
		$CI =& get_instance();

		$template_path = $CI->config->item( 'be_view_path' );

		// load breadcrumb
		$CI->load->view( $template_path .'/partials/breadcrumb_attribute', array( 'urls' => $urls )); 
	}
}

/**
 * Shows the data.
 *
 * @param      <type>  $string  The string
 */
if ( ! function_exists( 'show_data' )) 
{
	function show_data( $string )
	{
		// get ci instance
		$CI =& get_instance();
		$CI->load->library( 'PS_Security' );

		return $CI->ps_security->clean_output( $string );
	}
}

/**
 * Determines if view exists.
 *
 * @param      <type>   $path   The path
 *
 * @return     boolean  True if view exists, False otherwise.
 */
if ( ! function_exists( 'is_view_exists' )) 
{
	function is_view_exists( $path )
	{
		return file_exists( APPPATH .'views/'. $path .'.php' );
	}
}

/**
 * Gets the dummy photo.
 *
 * @return     <type>  The dummy photo.
 */
if ( ! function_exists( 'get_dummy_photo' )) 
{
	function get_dummy_photo()
	{
		return "default_news.jpeg";
	}
}

/**
 * Gets the configuration.
 *
 * @param      <type>  $key    The key
 *
 * @return     <type>  The configuration.
 */
if ( ! function_exists( 'get_app_config' )) 
{
	function get_app_config( $key )
	{
		// get ci instance
		$CI =& get_instance();

		$CI->load->model( 'About' );
		$abt = $CI->About->get_one( 'abt1' );

		if ( isset( $abt->{$key} )) {
			return $abt->{$key};
		}

		return false;
	}
}

/**
 * Image URL Path
 *
 * @param      <type>  $path   The path
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists( 'img_url' ))
{
	function img_url( $path = false )
	{
		return base_url( '/uploads/'. $path );
	}
}

/**
 * Gets the default photo.
 *
 * @param      <type>  $id     The identifier
 * @param      <type>  $type   The type
 */
if ( ! function_exists( 'get_default_photo' ))
{
	function get_default_photo( $id, $type )
	{
		$default_photo = "";

		// get ci instance
		$CI =& get_instance();

		// get all images
		$img = $CI->Image->get_all_by( array( 'img_parent_id' => $id, 'img_type' => $type ))->result();

		if ( count( $img ) > 0 ) {
		// if there are images for news,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $CI->Image->get_empty_object();
		}

		return $default_photo;
	}
}

/**
 * Gets the generate_random_string
 *
 * @param      <type>  $id     The identifier
 * @param      <type>  $type   The type
 */
if ( ! function_exists( 'generate_random_string' ))
{
	function generate_random_string($length = 5) {
	    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}

/**
	Global User Ban or Delete Checking
 */
if ( ! function_exists( 'global_user_check' )) 
{
	function global_user_check( $user_id )
	{
		// get ci instance
		$CI =& get_instance();

		$CI->load->model( 'User' );
		$conds['user_id'] = $user_id;
		$user_data = $CI->User->get_one_by($conds);
		$is_ban = $user_data->is_banned;

		if ($user_data->is_empty_object == 1) {
			$CI->error_response( get_msg( 'err_user_not_existed' ));
		} elseif ($is_ban == '1') {
			$CI->error_response( get_msg( 'user_banned' ));
		}

		return true;
	}
}


/**
	lat lng checking
 */
if ( ! function_exists( 'location_check' )) 
{
	function location_check( $trans_lat, $trans_lng )
	{

		// get ci instance
		$CI =& get_instance();

		if ($lat == "0.0" || $lng == "0.0") {
			$CI->error_response( get_msg( 'err_lat_lng' ));
		}elseif ($lat < -90 || $lat > 90) {
			$CI->error_response( get_msg( 'lat_invlaid' ));
		}elseif ($lng < -180 || $lng > 180){
			$CI->error_response( get_msg( 'lng_invlaid' ));
		}	

		return true;
	}
}


/**
* Deep linking output short url
*/
if ( ! function_exists( 'deep_linking_shorten_url' ))
{
	function deep_linking_shorten_url ($description,$title,$img,$id) {
		// get ci instance
		$CI =& get_instance();

		$longUrl = $CI->Backend_config->get_one('be1')->dyn_link_deep_url.$id;
	  
		//Web API Key From Firebase   
		$key = $CI->Backend_config->get_one('be1')->dyn_link_key;

		//Firebase Rest API URL 
		$url = $CI->Backend_config->get_one('be1')->dyn_link_url . $key;

		//To link with Android App, so need to provide with android package name
		$androidInfo = array(
		    "androidPackageName" => $CI->Backend_config->get_one('be1')->dyn_link_package_name
		);

		//For iOS

		$iOSInfo = array(
		   "iosBundleId" => $CI->Backend_config->get_one('be1')->ios_boundle_id ,
		   "iosAppStoreId" => $CI->Backend_config->get_one('be1')->ios_appstore_id
		);

		//For meta data when share the URL 
		$socialMetaTagInfo = array(
		    "socialDescription" => $description,
		    "socialImageLink"   => $img,
		    "socialTitle"       => $title
		);
		
		//For only 4 character at url 
		$suffix = array(
		    "option" => "SHORT"
		);

		$data = array(
		     "dynamicLinkInfo" => array(
		        "dynamicLinkDomain" => $CI->Backend_config->get_one('be1')->dyn_link_domain,
		        "link" => $longUrl,
		        "androidInfo" => $androidInfo,
		         "iosInfo" => $iOSInfo,
		        "socialMetaTagInfo" => $socialMetaTagInfo
		     ),
		     "suffix" => $suffix
		);

		$headers = array('Content-Type: application/json');

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

		$data = curl_exec ( $ch );
		curl_close ( $ch );

		$short_url = json_decode($data);
		  
		if(isset($short_url->error)){
		    //return $short_url->error->message;
		    return $short_url->error->message;
		} else {
		    //return $short_url->shortLink;
		    return $short_url->shortLink;
		}



	}
}