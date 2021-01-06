<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Database Trigger
 */
class PS_Delete {

	// codeigniter instance
	protected $CI;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();

		// load image library
		$this->CI->load->library( 'PS_Image' );
	}

	/**
	 * Delete the category and image under the category
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_category( $category_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Category->delete( $category_id )) {
		// if there is an error in deleting category,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'category', 'img_parent_id' => $category_id );

		if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'category-icon', 'img_parent_id' => $category_id );

			if ( !$this->CI->delete_images_by( $conds )) {
			// if error in deleting image, 

				return false;
			}
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data
			if ( ! $this->delete_category_trigger( $category_id )) {
			// if error in deleteing wallpaper and wallpaper related data

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete the user
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_user( $user_id )
	{	
		$conds_user['user_id'] = $user_id;	
		if ( ! $this->CI->User->delete( $user_id )) {
		// if there is an error in deleting category,
			
			return false;
		}

		//delete user city
		if ( ! $this->CI->User_shop->delete_by( $conds_user )) {
			// if there is an error in deleting comment header,
			
			return false;
		}

		return true;
	}

	/**
	 * Delete the rating
	 *
	 * @param      <type>  $id     The identifier
	*/
	function delete_rating( $id )
	{	

		if ( ! $this->CI->Rate->delete( $id )) {
		// if there is an error in deleting Product,
			
			return false;
		}

		return true;
	}

	/**
	 * Delete the notification and image under the notification
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_noti( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Noti->delete( $id )) {
		// if there is an error in deleting notification,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'noti', 'img_parent_id' => $id );

		if ( !$this->CI->delete_images_by( $conds )) {
		// if error in deleting image, 

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data

			if ( ! $this->delete_noti_trigger( $id )) {
			// if error in deleteing wallpaper and wallpaper related data

				return false;
			}
		}

		return true;
	}

	/**
	 * Trigger to delete wallpaper and related data when category is deleted
	 * delete wallpaper
	 * delete wallpaper images
	 * call delete_wallpaper_trigger
	 */
	function delete_category_trigger( $cat_id )
	{
		//sub category condition
		$subcategory = $this->CI->Subcategory->get_all_by( array( 'cat_id' => $cat_id ))->result();
		foreach ( $subcategory as $subcat ) {
			
			if ( !$this->delete_subcategory( $subcat->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		// get all wallpaper and delete the wallpaper under the category
		$products = $this->CI->Product->get_all_by( array( 'cat_id' => $cat_id, 'no_publish_filter' => 1 ))->result();

		if ( !empty( $products )) {
		// if the wallpaper list not empty
			
			// loop all the wallpaper
			foreach ( $products as $product ) {

				// delete wallpaper and images
				$enable_trigger = true;

				if ( !$this->delete_product( $product->id, $enable_trigger )) {
				// if error in deleting wallpaper,

					return false;
				} 
			}
		}

		return true;
	}

	/**
	 * Delete the Color 
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_color( $product_id )
	{		
		$conds = array( 'product_id' => $product_id );
		if ( ! $this->CI->Color->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
		return true;
	}

	/**
	 * Delete the Specification 
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_spec( $product_id )
	{		
		$conds = array( 'product_id' => $product_id );
		if ( ! $this->CI->Specification->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
		return true;
	}

	/**
	 * Delete the category and image under the category
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_subcategory( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Subcategory->delete( $id )) {
		// if there is an error in deleting category,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'sub_category', 'img_parent_id' => $id );

		if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'subcat_icon', 'img_parent_id' => $id );

			if ( !$this->CI->delete_images_by( $conds )) {
			// if error in deleting image, 

				return false;
			}	
		}
		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data

			if ( !$this->delete_subcat_trigger( $sub_cat_id )) {
			// if error in deleting wallpaper related data,

				return false;
			}
			
		}

		return true;
	}

	function delete_subcat_trigger( $sub_cat_id )
	{
		// get all product and delete the wallpaper under the subcategory
		$products = $this->CI->Product->get_all_by( array( 'sub_cat_id' => $sub_cat_id, 'no_publish_filter' => 1 ))->result();
		if ( !empty( $products )) {
		// if the wallpaper list not empty
			
			// loop all the wallpaper
			foreach ( $products as $product ) {
				// delete wallpaper and images
				$enable_trigger = true;

				if ( !$this->delete_product( $product->id, $enable_trigger )) {
				// if error in deleting wallpaper,

					return false;
				} 
			}
		}
		return true;
	}

	function delete_language( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Language->delete( $id )) {
		// if there is an error in deleting language,
			
			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete language related data
			if ( ! $this->delete_language_trigger( $id )) {
			// if error in deleteing language and language related data

				return false;
			}
		}

		return true;
	}

	/**
	* Trigger to delete language related data when language is deleted
	* delete language related data
	*/
	function delete_language_trigger( $id )
	{
		$conds['language_id'] = $id;

		// delete Item
		if ( !$this->CI->Language_string->delete_by( $conds )) {

			return false;
		}
		return true;
	}

	/**
	 * Delete the transaction
	 *
	 * @param      <type>  $id     The identifier
	*/
	function delete_transaction( $id ,$enable_trigger = false)
	{	

		if ( ! $this->CI->Transactionheader->delete( $id )) {
		// if there is an error in deleting Product,
			
			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data
			
			if ( !$this->delete_transaction_trigger( $id )) {
			// if error in deleting wallpaper related data,

				return false;
			}
			
		}
		
		return true;
	}

	/**
	* Trigger to delete wallpaper related data when wallpaper is deleted
	* delete wallpaper related data
	*/
	function delete_transaction_trigger( $id )
	{
		$conds = array( 'transactions_header_id' => $id );
		
		// delete touches
		if ( !$this->CI->Transactiondetail->delete_by( $conds )) {

			return false;
		}

		return true;
	}

	/**
	 * Delete the product and image under the product
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_product( $product_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Product->delete( $product_id )) {
		// if there is an error in deleting product,
			
			return false;
		} 

		// prepare condition
		$conds = array( 'img_type' => 'product', 'img_parent_id' => $product_id );

		if ( !$this->CI->delete_images_by( $conds )) {
			
			// if error in deleting image, 

			return false;
			
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data

			if ( !$this->delete_product_trigger( $product_id )) {
			// if error in deleting wallpaper related data,

				return false;
			}
			
		}

		return true;
	}

	/**
	 * Delete history for API
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_history( $type_id, $type_name, $enable_trigger = false )
	{		

		if( $type_name == "product") {


			if ( ! $this->CI->Product->delete( $type_id )) {
			// if there is an error in deleting product,
				
				return false;
			} else {
				//product is successfully deleted so need to save in log table
				$data_delete['type_id']   = $type_id;
				$data_delete['type_name'] = $type_name;


				//$this->CI->Product_delete->save($data_delete);
				$this->CI->Delete_history->save($data_delete);
			}

		} else if ( $type_name == "category" ) {


			if ( ! $this->CI->Category->delete( $type_id )) {
			// if there is an error in deleting product,
				
				return false;
			} else {
				//product is successfully deleted so need to save in log table
				$data_delete['type_id']   = $type_id;
				$data_delete['type_name'] = $type_name;


				//$this->CI->Product_delete->save($data_delete);
				$this->CI->Delete_history->save($data_delete);
			}



		} else if ( $type_name == "shop" ) {

			if ( ! $this->CI->Shop->delete( $type_id )) {
			// if there is an error in deleting product,
				
				return false;
			} else {
				//product is successfully deleted so need to save in log table
				$data_delete['type_id']   = $type_id;
				$data_delete['type_name'] = $type_name;


				//$this->CI->Product_delete->save($data_delete);
				$this->CI->Delete_history->save($data_delete);
			}



		} else if ( $type_name == "subcategory" ) {


			if ( ! $this->CI->Subcategory->delete( $type_id )) {
			// if there is an error in deleting product,
				
				return false;
			} else {
				//product is successfully deleted so need to save in log table
				$data_delete['type_id']   = $type_id;
				$data_delete['type_name'] = $type_name;


				//$this->CI->Product_delete->save($data_delete);
				$this->CI->Delete_history->save($data_delete);
			}



		}


		// prepare condition
		if($type_name == "product") {
		
			$conds = array( 'img_type' => 'product', 'img_parent_id' => $type_id );
			if ( !$this->CI->delete_images_by( $conds )) {
			
				// if error in deleting image, 

				return false;
				
			}
		
		} else if($type_name == "category") {

			$conds = array( 'img_type' => 'category', 'img_parent_id' => $type_id );
			if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'category-icon', 'img_parent_id' => $type_id );
			// if error in deleting image,
				if ( !$this->CI->delete_images_by( $conds )) {
				
				// if error in deleting image, 

					return false;
				
				} 
			}

		} else if($type_name == "shop") {

			$conds = array( 'img_type' => 'shop', 'img_parent_id' => $type_id );
			if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'shop-icon', 'img_parent_id' => $type_id );
			// if error in deleting image,
				if ( !$this->CI->delete_images_by( $conds )) {
				
				// if error in deleting image, 

					return false;
				
				} 
			}
		
		} else if($type_name == "subcategory") {

			$conds = array( 'img_type' => 'sub_category', 'img_parent_id' => $type_id );
			if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'subcat_icon', 'img_parent_id' => $type_id );
			// if error in deleting image,
				if ( !$this->CI->delete_images_by( $conds )) {
				
				// if error in deleting image, 

					return false;
				
				} 
			}
		
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data
			if( $type_name == "product" ) {
				if ( !$this->delete_product_trigger( $type_id )) {
				// if error in deleting wallpaper related data,

					return false;
				}
			} else if( $type_name == "category" ) {

				if ( !$this->delete_category_trigger( $type_id )) {
				// if error in deleting wallpaper related data,
					return false;
				}

			} else if( $type_name == "shop" ) {

				if ( !$this->delete_shop_trigger( $type_id )) {
				// if error in deleting wallpaper related data,
					return false;
				}

			} else if( $type_name == "subcategory" ) {

				if ( !$this->delete_subcat_trigger( $type_id )) {
				// if error in deleting wallpaper related data,
					return false;
				}

			}
			
		}

		return true;
	}

	/**
	* Trigger to delete wallpaper related data when wallpaper is deleted
	* delete wallpaper related data
	*/
	function delete_product_trigger( $product_id )
	{
		$conds = array( 'product_id' => $product_id );

		// delete touches
		if ( !$this->CI->Productcollection->delete_by( $conds )) {

			return false;
		}

		if ( !$this->CI->ProductDiscount->delete_by( $conds )) {

			return false;
		}

		if ( !$this->CI->Attribute->delete_by( $conds )) {

			return false;
		}

		if ( !$this->CI->Attributedetail->delete_by( $conds )) {

			return false;
		}

		if ( !$this->CI->Color->delete_by( $conds )) {

			return false;
		}

		if ( !$this->CI->Specification->delete_by( $conds )) {

			return false;
		}

		return true;
	}

	/**
	 * Delete Image by id and type
	 *
	 * @param      <type>  $conds  The conds
	 */
	function delete_images_by( $conds )
	{
		// get all images
		$images = $this->CI->Image->get_all_by( $conds );

		if ( !empty( $images )) {
		// if images are not empty,

			foreach ( $images->result() as $img ) {
			// loop and delete each image

				if ( ! $this->CI->ps_image->delete_images( $img->img_path ) ) {
				// if there is an error in deleting images

					return false;
				}
			}
		}

		if ( ! $this->CI->Image->delete_by( $conds )) {
		// if error in deleting from database,

			return false;
		}

		return true;
	}

	/**
	 * Delete the Product Discount
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_prd_discount( $discount_id )
	{		
		$conds = array( 'discount_id' => $discount_id );
		if ( ! $this->CI->ProductDiscount->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
	}

	/**
	 * Delete the Product Collection
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_prd_collection( $collection_id )
	{		
		$conds = array( 'collection_id' => $collection_id );
		if ( ! $this->CI->Productcollection->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
	}

	/**
	 * Delete the Shop Tags
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_user_shop( $user_id )
	{		
		$conds = array( 'user_id' => $user_id );
		if ( ! $this->CI->User_shop->delete_by( $conds )) {


		// if there is an error in deleting Product,
			return false;
		}
		return true;
	}

	/**
	 * Delete the group
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_module_group( $group_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Module_group->delete( $group_id )) {
		// if there is an error in deleting Coupon,
			
			return false;
		}
		return true;
	}

	/**
	 * Delete the module
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_module( $module_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Module->delete( $module_id )) {
		// if there is an error in deleting Coupon,
			
			return false;
		}
		return true;
	}

	/**
	 * Delete the User Shop
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_shop_tag( $shop_id )
	{		
		$conds = array( 'shop_id' => $shop_id );
		if ( ! $this->CI->Shoptag->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
	}

	/**
	 * Delete the collection and image under the collection
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_collection( $collection_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Collection->delete( $collection_id )) {
		// if there is an error in deleting category,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'collection', 'img_parent_id' => $collection_id );

		if ( !$this->CI->delete_images_by( $conds )) {
			
			return false;
			
		}
		return true;
	}

	/**
	 * Delete the Discount and image under the Product
	 *
	 * @param      <type>  $id     The identifier
	*/
	function delete_discount( $discount_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Discount->delete( $discount_id )) {
		// if there is an error in deleting Product,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'discount', 'img_parent_id' => $discount_id );

		if ( !$this->CI->delete_images_by( $conds )) {
			
			return false;
			
		}
		return true;
	}

	/**
	 * Delete the Discount and image under the Product
	 *
	 * @param      <type>  $id     The identifier
	*/
	function delete_feed( $feed_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Feed->delete( $feed_id )) {
		// if there is an error in deleting Product,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'feed', 'img_parent_id' => $feed_id );

		if ( !$this->CI->delete_images_by( $conds )) {
			
			return false;
			
		}
		return true;
	}

	// /**
	//  * Delete the Discount and image under the Product
	//  *
	//  * @param      <type>  $id     The identifier
	//  */
	function delete_shop( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Shop->delete( $id )) {
		// if there is an error in deleting Product,
			
			return false;
		} 

		// prepare condition
		$conds = array( 'img_type' => 'shop', 'img_parent_id' => $id );

		if ( !$this->CI->delete_images_by( $conds )) {
		// if error in deleting image, 

			return false;
		}
	

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete wallpaper related data

			if ( !$this->delete_shop_trigger( $id )) {
			// if error in deleting wallpaper related data,
				return false;
			}
			
		}

		return true;
	}

	/**
	* Trigger to delete wallpaper related data when wallpaper is deleted
	* delete wallpaper related data
	*/
	function delete_shop_trigger( $id )
	{

		$conds['shop_id'] = $id;
		$conds['no_publish_filter'] = 1;
		//category condition
		$category = $this->CI->Category->get_all_by($conds)->result();
		foreach ( $category as $cat ) {
			
			if ( !$this->delete_category( $cat->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		//sub category condition
		$subcategory = $this->CI->Subcategory->get_all_by($conds)->result();
		foreach ( $subcategory as $subcat ) {
			
			if ( !$this->delete_subcategory( $subcat->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		//product condition
		$product = $this->CI->Product->get_all_by($conds)->result();
		foreach ( $product as $prd ) {
			// delete product and images
			$enable_trigger = true;
			if ( !$this->delete_product( $prd->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		//discount condition
		$discount = $this->CI->Discount->get_all_by($conds)->result();
		foreach ( $discount as $dis ) {
			
			if ( !$this->delete_discount( $dis->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		//collection condition
		$collection = $this->CI->Collection->get_all_by($conds)->result();
		foreach ( $collection as $collect ) {
			
			if ( !$this->delete_collection( $collect->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		//feed condition
		$feeds = $this->CI->Feed->get_all_by($conds)->result();
		foreach ( $feeds as $feed ) {
			
			if ( !$this->delete_feed( $feed->id, $enable_trigger )) {
			// if error in deleting wallpaper,

				return false;
			}
		}

		// delete Shipping area
		if ( !$this->CI->Shipping_area->delete_by( $conds )) {

			return false;
		}

		
		// delete Comment Header
		if ( !$this->CI->Commentheader->delete_by( $conds )) {

			return false;
		}

		// delete Comment Detail
		if ( !$this->CI->Commentdetail->delete_by( $conds )) {

			return false;
		}
		
		// delete like
		if ( !$this->CI->Like->delete_by( $conds )) {

			return false;
		}

		// delete Favourite
		if ( !$this->CI->Favourite->delete_by( $conds )) {

			return false;
		}

		// delete Touch
		if ( !$this->CI->Touch->delete_by( $conds )) {

			return false;
		}

		// delete Coupon
		if ( !$this->CI->Coupon->delete_by( $conds )) {

			return false;
		}

		// delete Transaction header
		if ( !$this->CI->Transactionheader->delete_by( $conds )) {

			return false;
		}

		// delete Transaction detail
		if ( !$this->CI->Transactiondetail->delete_by( $conds )) {

			return false;
		}

		// delete Shop tag
		if ( !$this->CI->Shoptag->delete_by( $conds )) {

			return false;
		}

		// delete User Shop
		if ( !$this->CI->User_shop->delete_by( $conds )) {

			return false;
		}
		return true;
	}


	 /* Delete the Attributeheader and image under the Attributeheader
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_attribute( $attribute_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Attribute->delete( $attribute_id )) {
		// if there is an error in deleting Attributeheader,
			return false;
		}
		return true;
	}
	/**
	 * Delete the Attributeheader and image under the Attributeheader
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_attdetail( $attdetail_id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Attributedetail->delete( $attdetail_id )) {
		// if there is an error in deleting Attributeheader,
			
			return false;
		}
		
		return true;
	}

	// /**
	//  * Delete the Coupon
	//  *
	//  * @param      <type>  $id     The identifier
	//  */
	function delete_coupon( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Coupon->delete( $id )) {
		// if there is an error in deleting Coupon,
			
			return false;
		}
		return true;
	}

	// /**
	//  * Delete the Tag
	//  *
	//  * @param      <type>  $id     The identifier
	//  */
	function delete_tag( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Tag->delete( $id )) {
		// if there is an error in deleting tag,
			
			return false;
		}

		// prepare condition
		$conds = array( 'img_type' => 'tag', 'img_parent_id' => $id );

		if ( $this->CI->delete_images_by( $conds )) {
			$conds = array( 'img_type' => 'tag-icon', 'img_parent_id' => $id );

			if ( !$this->CI->delete_images_by( $conds )) {
			// if error in deleting image, 

				return false;
			}
		}
		return true;
	}

	/**
	 * Delete the Zone
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_transaction_status ( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Transactionstatus->delete( $id )) {
		// if there is an error in deleting Zone,
			
			return false;
		}

		return true;
	}

	/**
	 * Delete the Zone
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_payment_status ( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Paymentstatus->delete( $id )) {
		// if there is an error in deleting Zone,
			
			return false;
		}

		return true;
	}

	/**
	 * Delete the food addon
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_food_addon( $product_id )
	{		
		$conds = array( 'product_id' => $product_id );
		if ( ! $this->CI->Food_additional->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
	}

	/**
	 * Delete the User Shop
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_shipping_area( $id )
	{		
		if ( ! $this->CI->Shipping_area->delete( $id )) {
		// if there is an error in deleting category,
			
			return false;
		}
		return true;
	}

	/* Delete the Coupon
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_additional( $id, $enable_trigger = false )
	{		
		if ( ! $this->CI->Additional->delete( $id )) {
		// if there is an error in deleting Coupon,
			
			return false;
		}
		return true;
	}

}