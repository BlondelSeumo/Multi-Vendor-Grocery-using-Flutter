<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Adapter {

	// codeigniter instance
	protected $CI;

	// login user
	protected $login_user_id;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
	}

	/**
	 * Sets the login user.
	 */
	function set_login_user_id( $user_id )
	{
		$this->login_user_id = $user_id;
	}

	/**
	 * Sets the login user.
	 */
	function get_login_user_id()
	{
		return $this->login_user_id;
	}
	
	/**
	 * Customize wallpaper object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_image( &$obj )
	{

	}
	/**
	 * Gets the default photo.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $type   The type
	 */
	function get_default_photo( $id, $type )
	{
		$default_photo = "";

		// get all images
		$img = $this->CI->Image->get_all_by( array( 'img_parent_id' => $id, 'img_type' => $type ))->result();

		if ( count( $img ) > 0 ) {
		// if there are images for wallpaper,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $this->CI->Image->get_empty_object();
		}

		return $default_photo;
	}

	/**
	 * Gets the default photo.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $type   The type
	 */
	function get_default_photo_for_gallery( $id, $type )
	{
		$default_photo = "";
		$conds['img_parent_id'] = $id;
		$conds['img_type'] = $type;

		// get all images
		$img = $this->CI->Image->get_all_by($conds)->result();
		
		if ( count( $img ) == 1 ) {
			// if there are images for gallery,
			$default_photo = $img[0];
			
		} elseif ( count( $img ) > 1 ) {
			$conds['is_default'] = "1";
			$image = $this->CI->Image->get_all_by($conds)->result();
			// if there are images for gallery,
			if(count($image) != 0) {
				$default_photo = $image[0];
			} else {
				$default_photo = $img[0];
			}

		} else {
			// if no image, return empty object
			$default_photo = $this->CI->Image->get_empty_object();
		}

		return $default_photo;
	}


	/**
	 * Customize category object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_category( &$obj )
	{
		// added_date timestamp string
		$obj->added_date_str = ago( $obj->added_date );

		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'category' );

		// set default icon 
		$obj->default_icon = $this->get_default_photo( $obj->id, 'category-icon' );
	}

	/**
	 * Customize sub category object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_sub_category( &$obj )
	{
		
		// added_date timestamp string
		$obj->added_date_str = ago( $obj->added_date );
		
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'sub_category' );

		// set default icon 
		$obj->default_icon = $this->get_default_photo( $obj->id, 'subcat_icon' );
	}

	/**
	 * Customize product object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_product( &$obj , $need_return = false)
	{

		//Transaction Status 
		if(isset($obj->trans_status)) {

			if($obj->trans_status != "") {
				$obj->trans_status = $obj->trans_status;
			} else {
				$obj->trans_status = "";
			}

		} else {
			$obj->trans_status = "";
		}
		

		// set default photo
		$obj->default_photo = $this->get_default_photo_for_gallery( $obj->id, 'product' );

		// shop object
		if ( isset( $obj->shop_id )) {
			$tmp_shop = $this->CI->Shop->get_one( $obj->shop_id );

			$this->convert_shop( $tmp_shop );

			$obj->shop= $tmp_shop;
		}

		// category object
		if ( isset( $obj->cat_id )) {
			$tmp_category = $this->CI->Category->get_one( $obj->cat_id );

			$this->convert_category( $tmp_category );

			$obj->category = $tmp_category;
		}

		// Sub Category Object
		if ( isset( $obj->sub_cat_id )) {
			$tmp_sub_category = $this->CI->Subcategory->get_one( $obj->sub_cat_id );

			$this->convert_sub_category( $tmp_sub_category );

			$obj->sub_category = $tmp_sub_category;
		}

		$conds['product_id'] = $obj->id;

		// Add On Object
		$food_addons = $this->CI->Food_additional->get_all_by( $conds )->result(); 
		foreach ($food_addons as $addon) {
			$tmp_result .= $addon->add_on_id .",";
			  
		}
		$add_on_id = rtrim($tmp_result,",");
		$addon_id = explode(",", $add_on_id);
		if (empty($addon_id[0])) {
			$addon_dummy = $this->CI->Additional->get_empty_object();
			$this->convert_additional( $addon_dummy );
			$tmp_add_on[] = $addon_dummy;
			$obj->addon = $tmp_add_on;
		} else {
			$tmp_addons = $this->CI->Additional->get_all_addon($addon_id)->result();
			foreach ($tmp_addons as $tmp_addon) {
				$this->CI->Subcategory->get_one( $tmp_addon->id );
				$this->convert_additional( $tmp_addon );
			}			
			$obj->addon = $tmp_addons;
		}

		// Colors Object 
		$color_count = $this->CI->Color->count_all_by( $conds );

		if ( $color_count > 0 ) {
			$tmp_colors = $this->CI->Color->get_all_by( $conds )->result();
			$obj->colors = $tmp_colors;
		} else {
			$color_dummy[] = $this->CI->Color->get_empty_object();
			$obj->colors = $color_dummy;
		}

		// Spec Object 
		$spec_count = $this->CI->Specification->count_all_by( $conds );

		

		if ( $spec_count > 0 ) {
			$tmp_spec = $this->CI->Specification->get_all_by( $conds )->result();
			$obj->specs = $tmp_spec;
		} else {
			$spec_dummy[] = $this->CI->Specification->get_empty_object();
			$obj->specs = $spec_dummy;
		}

		//Need to check for Like and Favourite
		$obj->is_liked = 0;
		$obj->is_favourited = 0;
		
		if($this->get_login_user_id() != "") {
			//Need to check for Fav
			$conds['product_id'] = $obj->id;
			$conds['user_id']    = $this->get_login_user_id();
		
			// checking for like product by user
			$like_id = $this->CI->Like->get_one_by($conds)->id;
			$obj->is_liked = 0;
			if($like_id != "") {
				$obj->is_liked = 1;
			} else {
				$obj->is_liked = 0;
			}


			$fav_id = $this->CI->Favourite->get_one_by($conds)->id;
			$obj->is_favourited = 0;
			if($fav_id != "") {
				$obj->is_favourited = 1;
			} else {
				$obj->is_favourited = 0;
			}

		} else if($obj->login_user_id_post != "") {
			$conds['product_id'] = $obj->id;
			$conds['user_id']    = $obj->login_user_id_post;

			// checking for like product by user
			$like_id = $this->CI->Like->get_one_by($conds)->id;
			$obj->is_liked = 0;
			if($like_id != "") {
				$obj->is_liked = 1;
			} else {
				$obj->is_liked = 0;
			}

			$fav_id = $this->CI->Favourite->get_one_by($conds)->id;
			$obj->is_favourited = 0;
			if($fav_id != "") {
				$obj->is_favourited = 1;
			} else {
				$obj->is_favourited = 0;
			}

		}

		
		unset($obj->login_user_id_post);

		$obj->is_liked = $obj->is_liked;
		$obj->is_favourited = $obj->is_favourited;

		// like count
	    $obj->like_count = $this->CI->Like->count_all_by(array("product_id" => $obj->id));

	    // fav count
		//$obj->favourite_count =  $this->CI->Favourite->count_all_by(array("product_id" => $obj->id));

	    // image count 
		$obj->image_count =  $this->CI->Image->count_all_by(array("img_parent_id" => $obj->id));

		// touch count
		//$obj->touch_count =  $this->CI->Touch->count_all_by(array("type_id" => $obj->id, "type_name" => "product"));

		// Comment count
		$obj->comment_header_count =  $this->CI->Commentheader->count_all_by(array("product_id" => $obj->id));
		
		$obj->currency_symbol = $this->CI->Shop->get_one( $obj->shop_id )->currency_symbol;

		$obj->currency_short_form = $this->CI->Shop->get_one( $obj->shop_id )->currency_short_form;

		//Discount Checking 
		$conds['product_id'] = $obj->id;
		$discount_id = $this->CI->ProductDiscount->get_one_by( $conds )->discount_id;

		if($discount_id != "") { 
			$discount_percent = $this->CI->Discount->get_one( $discount_id )->percent;

			$obj->discount_amount = $obj->original_price * $discount_percent;

			$obj->discount_percent = $discount_percent * 100;

			$obj->discount_value = $discount_percent;


		} else {


			$obj->discount_amount = 0;

			$obj->discount_percent = 0;

			$obj->discount_value = 0;

		}

		// Attribute Object
		// Get Header Object First
		$att_header_count = $this->CI->Attribute->count_all_by( $conds );

		if ( $att_header_count > 0 ) {
			for($i = 0; $i < $att_header_count; $i++) {
				//Need to check for that header got details or not
				$tmp_header = $this->CI->Attribute->get_all_by( $conds )->result();
				$att_conds['header_id'] = $tmp_header[$i]->id;
				$att_header_count_from_detail = $this->CI->Attributedetail->count_all_by( $att_conds );

				if( $att_header_count_from_detail > 0 ) {
					//if got details, need to put those details data at one header

					$tmp_detail = $this->CI->Attributedetail->get_all_by( $att_conds )->result();
					$obj->customized_header[$i] = $tmp_header[$i];
					$obj->customized_header[$i]->customized_detail = $tmp_detail;

				} else {
					$att_detail_dummy[] = $this->CI->Attributedetail->get_empty_object();

					$obj->customized_header[$i] = $tmp_header[$i];
					$obj->customized_header[$i]->customized_detail = $att_detail_dummy;
				}
			}

		} else {
			$header_dummy[] = $this->CI->Attribute->get_empty_object();
			$obj->customized_header = $header_dummy;

			$att_detail_dummy[] = $this->CI->Attributedetail->get_empty_object();
			$obj->customized_header[0]->customized_detail = $att_detail_dummy;
		}

		//rating details 
		
		// $obj->like_count = $this->CI->Like->count_all_by(array("product_id" => $obj->id));

		
		$total_rating_count = 0;
		$total_rating_value = 0;

		$five_star_count = 0;
		$five_star_percent = 0;

		$four_star_count = 0;
		$four_star_percent = 0;

		$three_star_count = 0;
		$three_star_percent = 0;

		$two_star_count = 0;
		$two_star_percent = 0;

		$one_star_count = 0;
		$one_star_percent = 0;


		

		//Rating Total how much ratings for this product
		$conds_rating['product_id'] = $obj->id;
		$total_rating_count = $this->CI->Rate->count_all_by($conds_rating);
		$sum_rating_value = $this->CI->Rate->sum_all_by($conds_rating)->result()[0]->rating;

		//Rating Value such as 3.5, 4.3 and etc
		if($total_rating_count > 0) {
			$total_rating_value = number_format((float) ($sum_rating_value  / $total_rating_count), 1, '.', '');
		} else {
			$total_rating_value = 0;
		}

		//For 5 Stars rating

		$conds_five_star_rating['rating'] = 5;
		$conds_five_star_rating['product_id'] = $obj->id;
		$five_star_count = $this->CI->Rate->count_all_by($conds_five_star_rating);
		if($total_rating_count > 0) {
			$five_star_percent = number_format((float) ((100 / $total_rating_count) * $five_star_count), 1, '.', '');
		} else {
			$five_star_percent = 0;
		}

		//For 4 Stars rating
		$conds_four_star_rating['rating'] = 4;
		$conds_four_star_rating['product_id'] = $obj->id;
		$four_star_count = $this->CI->Rate->count_all_by($conds_four_star_rating);
		if($total_rating_count > 0) {
			$four_star_percent = number_format((float) ((100 / $total_rating_count) * $four_star_count), 1, '.', '');
		} else {
			$four_star_percent = 0;
		}


		//For 3 Stars rating
		$conds_three_star_rating['rating'] = 3;
		$conds_three_star_rating['product_id'] = $obj->id;
		$three_star_count = $this->CI->Rate->count_all_by($conds_three_star_rating);
		if($total_rating_count > 0) {
			$three_star_percent = number_format((float) ((100 / $total_rating_count) * $three_star_count), 1, '.', '');
		} else {
			$three_star_percent = 0;
		}


		//For 2 Stars rating
		$conds_two_star_rating['rating'] = 2;
		$conds_two_star_rating['product_id'] = $obj->id;
		$two_star_count = $this->CI->Rate->count_all_by($conds_two_star_rating);

		if($total_rating_count > 0) {
			$two_star_percent = number_format((float) ((100 / $total_rating_count) * $two_star_count), 1, '.', '');
		} else {
			$two_star_percent = 0;
		}

		//For 1 Stars rating
		$conds_one_star_rating['rating'] = 1;
		$conds_one_star_rating['product_id'] = $obj->id;
		$one_star_count = $this->CI->Rate->count_all_by($conds_one_star_rating);

		if($total_rating_count > 0) {
		$one_star_percent = number_format((float) ((100 / $total_rating_count) * $one_star_count), 1, '.', '');
		} else {
			$one_star_percent = 0;
		}


		$rating_std = new stdClass();
		@$rating_std->five_star_count = $five_star_count; 
		$rating_std->five_star_percent = $five_star_percent;

		$rating_std->four_star_count = $four_star_count;
		$rating_std->four_star_percent = $four_star_percent;

		$rating_std->three_star_count = $three_star_count;
		$rating_std->three_star_percent = $three_star_percent;

		$rating_std->two_star_count = $two_star_count;
		$rating_std->two_star_percent = $two_star_percent;

		$rating_std->one_star_count = $one_star_count;
		$rating_std->one_star_percent = $one_star_percent;

		$rating_std->total_rating_count = $total_rating_count;
		$rating_std->total_rating_value = $total_rating_value;


		$obj->rating_details = $rating_std;

		if($need_return)
		{
			return $obj;
		} 

	}

	/**
	 * Customize collection object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_collection( &$obj )
	{
		

		$conds['collection_id'] = $obj->id;

		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'collection' );

		$collection_id = $this->CI->get_collection_id();

		$count_product = 0;
		if($collection_id == "")
		{
			$count_product_collection = $this->CI->Api->get_one_by( array( 'api_constant' => GET_ALL_COLLECTIONS ) )->count;
		} else {
			$count_product = $this->CI->Productcollection->count_all_by( $conds );
		}


		if ( $count_product_collection > 0 ) {

			for($i = 0; $i < $count_product_collection ; $i++) {
				

				$tmp_collection = $this->CI->Productcollection->get_all_collections( $conds )->result();


				if(isset($tmp_collection[$i]->id)) {

					$prd_conds['id'] = $tmp_collection[$i]->id;
					$prd_conds['delete_flag'] = 0;

					$tmp_product = $this->CI->Product->get_one_by( $prd_conds );
					$obj->products[] = $this->convert_product($tmp_product, true);
				}

			}

		}

	}

	/**
	 * Customize noti object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_noti( &$obj )
	{
		
		
		if($this->get_login_user_id() != "") {
			$noti_user_data = array(
	        	"noti_id" => $obj->id,
	        	"user_id" => $this->get_login_user_id()
	    	);
			if ( !$this->CI->Notireaduser->exists( $noti_user_data )) {
				$obj->is_read = 0;
			} else {
				$obj->is_read = 1;
			}
		} 
		
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'noti' );
	}

	/**
	 * Customize user object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_user( &$obj )
	{
		//user flag
		$conds['user_id'] = $obj->user_id;
		$role_id = $this->CI->User->get_one_by($conds)->role_id;
		$status = $this->CI->User->get_one_by($conds)->status;

		if ($role_id == 5 && $status == 1) {
			$obj->user_flag = "Approved";
		}elseif ($role_id == 5 && $status == 2) {
			$obj->user_flag = "Pending";
		}elseif ($role_id == 5 && $status == 3) {
			$obj->user_flag = "Rejected";
		}elseif ($role_id == 4) {
			$obj->user_flag = "Normal User";
		}else{
			$obj->user_flag = "Admin";
		}
		// area object
		if ( isset( $obj->user_area_id )) {
			$tmp_area = $this->CI->Shipping_area->get_one( $obj->user_area_id );

			$this->convert_areas( $tmp_area );

			$obj->user_area = $tmp_area;
		}
	}

	/**
	 * Customize about object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_about( &$obj )
	{

        $obj->privacypolicy =$this->CI->Privacy_policy->get_one('privacy1')->content;
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->about_id, 'about' );


	}

	/**
	 * Checking for transaction
	 *
	 * 
	 */
	function transaction_checking( $trans_details = array())
	{
		$failed_records = array();

		$failed_price = array();

		$failed_available = array();

		$failed_delete = array();


		for($i=0; $i<count($trans_details); $i++) 
		{
			
			// Rule 1 : Need to check the product whether delete or not?
			//$product_is_delete = $this->CI->Product_delete->get_one($trans_details[$i]['product_id'])->product_id;
			$product_is_delete = $this->CI->Delete_history->get_one($trans_details[$i]['product_id'])->product_id;
			if($product_is_delete != "")
			{
				//delete_flag '1' is deleted
				$failed_delete[$i] = $trans_details[$i]['product_id'];

			} else {

				//Rule 2 : Need to check availability of the product
				$product_is_available = $this->CI->Product->get_one($trans_details[$i]['product_id'])->is_available;
				if($product_is_available == 0)
				{
					//is_available '0' is No More Stock
					$failed_available[$i] = $trans_details[$i]['product_id'];
				} else {

					// Rule 3 : Need to check the product price 
					$product_unit_price = $this->CI->Product->get_one($trans_details[$i]['product_id'])->unit_price;

					if($product_unit_price != $trans_details[$i]['price']) 
					{
						
						//Price not same
						$failed_price[$i] = $trans_details[$i]['product_id'];

					} else {
						//Product Price is same but attribute price is not same
						$att_additional_price = $this->CI->Attributedetail->get_one($trans_details[$i]['product_attribute_id'])->additional_price;

						if($att_additional_price != $trans_details[$i]['product_attribute_price'])  {

							//att price not same
							$failed_price[$i] = $trans_details[$i]['product_id'];

						}

					}

				}

			}

		}
		
		$failed_records[] = array_unique($failed_price);
		$failed_records[] = array_unique($failed_available);
		$failed_records[] = array_unique($failed_delete);

		//print_r($failed_records); die;

		return $failed_records;
	}

	/*
	 * Customize tag object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_tag( &$obj )
	{
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'tag' );

		// set default icon 
		$obj->default_icon = $this->get_default_photo( $obj->id, 'tag-icon' );

	}


	/*
	 * Customize shop object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_shop( &$obj )
	{
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'shop' );

		// set default icon 
		$obj->default_icon = $this->get_default_photo( $obj->id, 'shop-icon' );

		// touch count
		$obj->touch_count =  $this->CI->Touch->count_all_by(array("type_id" => $obj->id, "type_name" => "shop"));

		//rating details 
		
		// $obj->like_count = $this->CI->Like->count_all_by(array("product_id" => $obj->id));

		
		$total_rating_count = 0;
		$total_rating_value = 0;

		$five_star_count = 0;
		$five_star_percent = 0;

		$four_star_count = 0;
		$four_star_percent = 0;

		$three_star_count = 0;
		$three_star_percent = 0;

		$two_star_count = 0;
		$two_star_percent = 0;

		$one_star_count = 0;
		$one_star_percent = 0;

		//Rating Total how much ratings for this product
		$conds_rating['shop_id'] = $obj->id;
		$total_rating_count = $this->CI->Shop_rate->count_all_by($conds_rating);
		$sum_rating_value = $this->CI->Shop_rate->sum_all_by($conds_rating)->result()[0]->rating;

		//Rating Value such as 3.5, 4.3 and etc
		if($total_rating_count > 0) {
			$total_rating_value = number_format((float) ($sum_rating_value  / $total_rating_count), 1, '.', '');
		} else {
			$total_rating_value = 0;
		}

		//For 5 Stars rating

		$conds_five_star_rating['rating'] = 5;
		$conds_five_star_rating['shop_id'] = $obj->id;
		$five_star_count = $this->CI->Shop_rate->count_all_by($conds_five_star_rating);
		if($total_rating_count > 0) {
			$five_star_percent = number_format((float) ((100 / $total_rating_count) * $five_star_count), 1, '.', '');
		} else {
			$five_star_percent = 0;
		}

		//For 4 Stars rating
		$conds_four_star_rating['rating'] = 4;
		$conds_four_star_rating['shop_id'] = $obj->id;
		$four_star_count = $this->CI->Shop_rate->count_all_by($conds_four_star_rating);
		if($total_rating_count > 0) {
			$four_star_percent = number_format((float) ((100 / $total_rating_count) * $four_star_count), 1, '.', '');
		} else {
			$four_star_percent = 0;
		}


		//For 3 Stars rating
		$conds_three_star_rating['rating'] = 3;
		$conds_three_star_rating['shop_id'] = $obj->id;
		$three_star_count = $this->CI->Shop_rate->count_all_by($conds_three_star_rating);
		if($total_rating_count > 0) {
			$three_star_percent = number_format((float) ((100 / $total_rating_count) * $three_star_count), 1, '.', '');
		} else {
			$three_star_percent = 0;
		}


		//For 2 Stars rating
		$conds_two_star_rating['rating'] = 2;
		$conds_two_star_rating['shop_id'] = $obj->id;
		$two_star_count = $this->CI->Shop_rate->count_all_by($conds_two_star_rating);

		if($total_rating_count > 0) {
			$two_star_percent = number_format((float) ((100 / $total_rating_count) * $two_star_count), 1, '.', '');
		} else {
			$two_star_percent = 0;
		}

		//For 1 Stars rating
		$conds_one_star_rating['rating'] = 1;
		$conds_one_star_rating['shop_id'] = $obj->id;
		$one_star_count = $this->CI->Shop_rate->count_all_by($conds_one_star_rating);

		if($total_rating_count > 0) {
		$one_star_percent = number_format((float) ((100 / $total_rating_count) * $one_star_count), 1, '.', '');
		} else {
			$one_star_percent = 0;
		}


		$rating_std = new stdClass();
		@$rating_std->five_star_count = $five_star_count; 
		$rating_std->five_star_percent = $five_star_percent;

		$rating_std->four_star_count = $four_star_count;
		$rating_std->four_star_percent = $four_star_percent;

		$rating_std->three_star_count = $three_star_count;
		$rating_std->three_star_percent = $three_star_percent;

		$rating_std->two_star_count = $two_star_count;
		$rating_std->two_star_percent = $two_star_percent;

		$rating_std->one_star_count = $one_star_count;
		$rating_std->one_star_percent = $one_star_percent;

		$rating_std->total_rating_count = $total_rating_count;
		$rating_std->total_rating_value = $total_rating_value;


		$obj->rating_details = $rating_std;

		// grocery branch object
		if ( isset( $obj->id )) {
			$conds['shop_id'] = $obj->id;
			$tmp_grocery_branch_count = $this->CI->Grocery_branch->count_all_by( $conds );
			if( $tmp_res_branch_count > 0 ) {
				$tmp_grocery_branch = $this->CI->Grocery_branch->get_all_by( $conds )->result();
				
			} else {
				$tmp_grocery_branch[] = $this->CI->Grocery_branch->get_empty_object();
			}
			$obj->grocery_branch = $tmp_grocery_branch;
		}

		if($need_return)
		{
			return $obj;
		}	
	}

	/*
	 * Customize feed object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_feed( &$obj )
	{
		// set default photo
		$obj->default_photo = $this->get_default_photo_for_gallery( $obj->id, 'feed' );

		// shop object
		if ( isset( $obj->shop_id )) {
			$tmp_shop = $this->CI->Shop->get_one( $obj->shop_id );

			$this->convert_shop( $tmp_shop );

			$obj->shop = $tmp_shop;
		}
		
	}

	/**
	 * Customize tag object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_rating( &$obj )
	{
		// set user object
		if ( isset( $obj->user_id )) {
			$tmp_user = $this->CI->User->get_one( $obj->user_id );

			$this->convert_user( $tmp_user );

			$obj->user = $tmp_user;
		}
	}


	/*
	 * Customize Transaction Header object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_transaction_header( &$obj )
	{
		// set total qty
		//$conds['trans_header_id'] = $obj->id;

		//$rst = $this->CI->Transactionheader->get_product_count_from_transaction($conds)->result();


		//$obj->total_item_qty = $rst[0]->total;

		// shop object
		if ( isset( $obj->shop_id )) {
			$tmp_shop = $this->CI->Shop->get_one( $obj->shop_id );

			$this->convert_shop( $tmp_shop );

			$obj->shop = $tmp_shop;
		}
		
	}

	/*
	 * Customize Transaction Detail object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_transaction_detail( &$obj )
	{

		// shop object
		if ( isset( $obj->shop_id )) {
			$tmp_shop = $this->CI->Shop->get_one( $obj->shop_id );

			$this->convert_shop( $tmp_shop );

			$obj->shop = $tmp_shop;
		}
		
	}

	/**
	 * Customize shop rating object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_shop_rating( &$obj )
	{
		// set user object
		if ( isset( $obj->user_id )) {
			$tmp_user = $this->CI->User->get_one( $obj->user_id );

			$this->convert_user( $tmp_user );

			$obj->user = $tmp_user;
		}
	}

	/**
	 * Customize tag object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_areas( &$obj )
	{
		$shop_id = $obj->shop_id;

		$obj->currency_symbol = $this->CI->Shop->get_one( $shop_id )->currency_symbol;

		$obj->currency_short_form = $this->CI->Shop->get_one( $shop_id )->currency_short_form;

	}

	/**
	 * Customize food additional object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_additional( &$obj )
	{
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->id, 'food-additional' );

	}

	/**
	 * Customize food transaction status object
	 *
	 * @param      <type>  $obj    The object
	 */

	function convert_transaction_status( &$obj )
	{

	}


}