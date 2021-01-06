<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Discounts Controller
*/
class Discounts extends BE_Controller {


  /**
  * Construt required variables
  */
  function __construct() {

  parent::__construct( MODULE_CONTROL, 'DISCOUNTS' );
  ///start allow module check by MN
    $selected_shop_id = $this->session->userdata('selected_shop_id');
    $shop_id = $selected_shop_id['shop_id'];
    
    $conds_mod['module_name'] = $this->router->fetch_class();
    $module_id = $this->Module->get_one_by($conds_mod)->module_id;
    
    $logged_in_user = $this->ps_auth->get_user_info();

    $user_id = $logged_in_user->user_id;
    if(empty($this->User->has_permission( $module_id,$user_id )) && $logged_in_user->user_is_sys_admin!=1){
      return redirect( site_url('/admin/'.$shop_id) );
    }
    ///end check
  }

      /**
      * List down the registered users
      */
      function index() {

        // no publish filter
        $conds['no_publish_filter'] = 1;

        $selected_shop_id = $this->session->userdata('selected_shop_id');
        $shop_id = $selected_shop_id['shop_id'];

        $conds['shop_id'] = $shop_id;
        
        // get rows count
        $this->data['rows_count'] = $this->Discount->count_all_by( $conds );

        // get discounts
        $this->data['discounts'] = $this->Discount->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

        // load index logic
        parent::index();
      }

      /**
      * Searches for the first match.
      */
      function search() {


        // breadcrumb urls
        $this->data['action_title'] = get_msg( 'discount_search' );

        // condition with search term
        $conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
        // no publish filter
        $conds['no_publish_filter'] = 1;

        // pagination
        $this->data['rows_count'] = $this->Discount->count_all_by( $conds );

        // search data
        $this->data['discounts'] = $this->Discount->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

        // load add list
        parent::search();
      }

      /**
      * Create discount one
      */
      function add() {

        // no publish filter
        $conds['no_publish_filter'] = 1;

        // breadcrumb urls
        $this->data['action_title'] = get_msg( 'Dis_add' );

        // get rows count
        $this->data['rows_count'] = $this->Product->count_all_by( $conds );

        // get Product
        $this->data['prds_list'] = $this->Product->get_all_by( $conds, 40, $this->uri->segment( 4 ) );

        // call the core add logic
        parent::add();
      }

      /**
      * Update the existing one
      */
      /**
      * Update the existing one
      */
      function edit( $id ) {

        // no publish filter
        $conds['no_publish_filter'] = 1;

        // breadcrumb urls
        $this->data['action_title'] = get_msg( 'dis_edit' );

        // get rows count
        $this->data['rows_count'] = $this->Product->count_all_by( $conds );

        // get Product
        $this->data['prds_list'] = $this->Product->get_all_by( $conds, 40, $this->uri->segment( 5 ) );

        // load user
        $this->data['discount'] = $this->Discount->get_one( $id );

        // call the parent edit logic
        parent::edit( $id );
      }



      /**
      * Saving Logic
      * 1) upload image
      * 2) save discount
      * 3) save image
      * 4) check transaction status
      *
      * @param      boolean  $id  The user identifier
      */
      function save( $id = false ) {

        $data['prdcheck'] = explode(",", $this->get_data( 'newchkval' ));

          $prdcheck = "";

          if($id == "") {
            //for first time save 
            $prdcheck = $data['prdcheck'][1];
          
          } else {
            //for edit case
            $prdcheck = $data['prdcheck'][0];

          }

          if($prdcheck != "") {
           
             $logged_in_user = $this->ps_auth->get_user_info();

             /** 
              * Insert Discount Records 
              */
             $data = array();
             $discount_percent = $this->get_data( 'percent' );
             
             // product check count
             if($id) {
              $check_count = $this->get_data( 'prdcheck' );
              $edit_dis_id = $id;
             }
             
             // prepare discount name
             if ( $this->has_data( 'name' )) {
              $data['name'] = $this->get_data( 'name' );
             }

             
             // prepare discount percent unicode
             if ( $this->has_data( 'percent' )) {
              $data['percent'] = $this->get_data( 'percent' )/100;
              
             }

             // if 'status' is checked,
             if ( $this->has_data( 'status' )) {
              $data['status'] = 1;
             } else {
              $data['status'] = 0;
             }
           
           // set timezone
           $data['added_user_id'] = $logged_in_user->user_id;

           if($id == "") {
            //save
            $data['added_date'] = date("Y-m-d H:i:s");
           } else {
            //edit
            unset($data['added_date']);
            $data['updated_date'] = date("Y-m-d H:i:s");
            $data['updated_user_id'] = $logged_in_user->user_id;
           }
           $selected_shop_id = $this->session->userdata('selected_shop_id');
           $data['shop_id'] = $selected_shop_id['shop_id'];
          
           //save discount
           if ( ! $this->Discount->save( $data, $id )) {
           // if there is an error in inserting user data, 
            
            // rollback the transaction
            $this->db->trans_rollback();

            // set error message
            $this->data['error'] = get_msg( 'err_model' );
            
            return;
           }
          
           /** 
            * Upload Image Records 
            */
           if ( !$id ) {
           // if id is false, this is adding new record

            if ( ! $this->insert_images( $_FILES, 'discount', $data['id'] )) {
            // if error in saving image

             // commit the transaction
             $this->db->trans_rollback();
             
             return;
            }
           }
         

           //get inserted discount id
           $id = ( !$id )? $data['id']: $id ;

           // prepare product checkbox
           if ( $id ) {
            $conds['discount_id'] = $id;
            $prd_dis = $this->ProductDiscount->get_all_by($conds)->result();

            //update product before product discount save
            for($i=0; $i<count($prd_dis);$i++) {
              $before_dis_product['id'] = $prd_dis[$i]->product_id;
              $before_dis_product['is_discount'] = 0;
              $before_dis_product['unit_price'] = $this->Product->get_one($prd_dis[$i]->product_id)->original_price;
              $this->Product->save($before_dis_product, $prd_dis[$i]->product_id);
            }

            $data['prdcheck'] = explode(",", $this->get_data( 'newchkval' ));
            //loop and insert
            if(!$this->ps_delete->delete_prd_discount( $id )) {
             for($i=0; $i<count($data['prdcheck']);$i++) {

              if($data['prdcheck'][$i] != "") {
               $check_data['discount_id'] = $id;
               $check_data['product_id'] = $data['prdcheck'][$i];
               $check_data['added_date'] = date("Y-m-d H:i:s");
               $check_data['added_user_id'] = $logged_in_user->user_id;
              
               $this->ProductDiscount->save($check_data);

               $discount_product['id'] = $data['prdcheck'][$i];
               $discount_product['is_discount'] = 1;

               if($discount_percent != 0 ) {
               
                 $product_original_price = $this->Product->get_one($data['prdcheck'][$i])->original_price;
                 //$discount_price = $product_original_price - intval($product_original_price * ($discount_percent/100));
                 $discount_price = $product_original_price - round($product_original_price * ($discount_percent/100), 2);
                 
                 $discount_product['unit_price'] = round($discount_price, 2);
                 
               }

               $this->Product->save($discount_product, $data['prdcheck'][$i]);
              }

             }
            }
         }


       // commit the transaction
       if ( ! $this->check_trans()) {
           
          // set flash error message
          $this->set_flash_msg( 'error', get_msg( 'err_model' ));
         } else {

          if ( $edit_dis_id  ) {

          // if user id is not false, show success_add message
           
           $this->set_flash_msg( 'success', get_msg( 'success_dis_edit' ));
          } else {
          // if user id is false, show success_edit message
           
           $this->set_flash_msg( 'success', get_msg( 'success_dis_add' ));
          }
       }

          redirect( $this->module_site_url());
        } else {
        
         // set flash error message
         $this->set_flash_msg( 'error', get_msg( 'please_select_product' ) );
          if ( !$id ){
           redirect( site_url() . '/admin/discounts/add');
          } else {
           redirect( site_url() . '/admin/discounts/edit/' . $id);
          }
       
       // redirect( $this->module_site_url());
       }

      }

      /**
      * Determines if valid input.
      *
      * @return     boolean  True if valid input, False otherwise.
      */
      function is_valid_input( $id = 0 ) {

        $rule = 'required|callback_is_valid_name['. $id  .']';

        $this->form_validation->set_rules( 'name', get_msg( 'name' ), $rule);

        if ( $this->form_validation->run() == FALSE ) {
        // if there is an error in validating,

         return false;
        }

        return true;
      }

      /**
      * Determines if valid name.
      *
      * @param      <type>   $name  The  name
      * @param      integer  $id     The  identifier
      *
      * @return     boolean  True if valid name, False otherwise.
      */
      function is_valid_name( $name, $id = 0, $shop_id = 0 )
      {  

         $conds['name'] = $name;
         $selected_shop_id = $this->session->userdata('selected_shop_id');
         $shop_id = $selected_shop_id['shop_id'];
         $conds['shop_id'] = $shop_id;

            if ( strtolower( $this->Discount->get_one( $id )->name ) == strtolower( $name )) {
            // if the name is existing name for that user id,
              return true;
            } else if ( $this->Discount->exists( ($conds ))) {
            // if the name is existed in the system,
              $this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
              return false;
            }
            return true;
      }

      /**
      * Check discount name via ajax
      *
      * @param      boolean  $cat_id  The cat identifier
      */
      function ajx_exists( $id = false )
      {
        // get discount name
        $name = $_REQUEST['name'];

        if ( $this->is_valid_name( $name, $id )) {
        // if the discount name is valid,
         
         echo "true";
        } else {
        // if invalid discount name,
         
         echo "false";
        }
      }

      /**
      * Publish the record
      *
      * @param      integer  $discount_id  The discount identifier
      */
      function ajx_publish( $discount_id = 0 )
      {
        // check access
        $this->check_access( PUBLISH );

        // prepare data
        $discount_data = array( 'status'=> 1 );
         
        // save data
        if ( $this->Discount->save( $discount_data, $discount_id )) {
         echo true;
        } else {
         
         echo false;
        }
      }

      /**
      * Unpublish the records
      *
      * @param      integer  $discount_id  The discount identifier
      */
      function ajx_unpublish( $discount_id = 0 )
      {
        // check access
        $this->check_access( PUBLISH );

        // prepare data
        $discount_data = array( 'status'=> 0 );
         
        // save data
        if ( $this->Discount->save( $discount_data, $discount_id )) {
         echo true;
        } else {
         echo false;
        }
      }

      /**
      * Delete the record
      * 1) delete discount
      * 2) check transactions
      */
      function delete( $id ) {

        // start the transaction
        $this->db->trans_start();

        // check access
        $this->check_access( DEL );

        // enable trigger to delete all products related data
        $enable_trigger = true;

        if ( ! $this->ps_delete->delete_discount( $id, $enable_trigger )) {
        // if there is an error in deleting products,

         // rollback
         $this->trans_rollback();

         // error message
         $this->set_flash_msg( 'error', get_msg( 'err_model' ));
         redirect( $this->module_site_url());
        }

        $conds['discount_id'] = $id;
        $prd_discount = $this->ProductDiscount->get_all_by($conds)->result();
         for ($i=0; $i < count( $prd_discount); $i++) { 
              $prd_org_price = $this->Product->get_one($prd_discount[$i]->product_id)->original_price;
              $prd_discount_update['is_discount'] = 0;
              $prd_discount_update['unit_price'] = $prd_org_price;
              $this->Product->save(  $prd_discount_update , $prd_discount[$i]->product_id );
         }
        //Need to product discount table delete by id
        
        if ( !$this->ProductDiscount->delete_by( $conds )) {
       
         // rollback
         $this->db->trans_rollback();

         // error message
         $this->set_flash_msg( 'error', get_msg( 'err_model' ));

         redirect( $this->module_site_url());
      }
   
      /**
       * Check Transcation Status
       */
      if ( !$this->check_trans()) {

         $this->set_flash_msg( 'error', get_msg( 'err_model' )); 
        } else {
               
         $this->set_flash_msg( 'success', get_msg( 'success_dis_delete' ));
        }

        redirect( $this->module_site_url());
      }


    /**
    * Delete all the discount 
    *
    * @param      integer  $discount_id  The category identifier
    */
    function delete_all( $id = 0 )
    {
      // start the transaction
      $this->db->trans_start();

      // check access
      $this->check_access( DEL );

      // delete discount and images
      $enable_trigger = true; 

      /** Note: enable trigger will delete discount and all discount related data */
      if ( $this->ps_delete->delete_prd_discount( $id, $enable_trigger ) ) {
      // if error in deleting category,

       // set error message
       $this->set_flash_msg( 'error', get_msg( 'err_model' ));

       // rollback
        $this->trans_rollback();

       // redirect to list view
       redirect( $this->module_site_url());
      }

      if ( !$this->ps_delete->delete_discount( $id, $enable_trigger )) {
      // if error in deleting category,

       // set error message
       $this->set_flash_msg( 'error', get_msg( 'err_model' ));

       // rollback
       $this->trans_rollback();

       // redirect to list view
       redirect( $this->module_site_url());
      }
       
      /**
       * Check Transcation Status
       */
      if ( !$this->check_trans()) {

       $this->set_flash_msg( 'error', get_msg( 'err_model' )); 
      } else {
             
       $this->set_flash_msg( 'success', get_msg( 'success_Prd_delete' ));
      }

      redirect( $this->module_site_url());
    }
}

