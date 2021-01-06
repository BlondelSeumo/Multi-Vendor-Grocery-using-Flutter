<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Empty Class
 */
class My_Model {}

/**
 * PanaceaSoft Base Model
 */
class PS_Model extends CI_Model {
	
	// name of the database table
	protected $table_name;

	// name of the ID field
	public $primary_key;

	// name of the key prefix
	protected $key_prefix;

	/**
	 * constructs required data
	 */
	function __construct( $table_name, $primary_key = false, $key_prefix = false )
	{
		parent::__construct();

		// set the table name
		$this->table_name = $table_name;
		$this->primary_key = $primary_key;
		$this->key_prefix = $key_prefix;
	}

	/**
	 * Empty class to be extended
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array()) {

	}

	/**
	 * Generate the TeamPS Unique Key
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function generate_key()
	{
		return $this->key_prefix . md5( $this->key_prefix . microtime() . uniqid() . 'teamps' );
	}

    /**
     * Determines if exist.
     *
     * @param      <type>   $id     The identifier
     *
     * @return     boolean  True if exist, False otherwise.
     */
    function is_exist( $id ) {
    	
    	// from table
    	$this->db->from( $this->table_name );

    	// where clause
		$this->db->where( $this->primary_key, $id );
		
		// get query
		$query = $this->db->get();

		// return the result
		return ($query->num_rows()==1);
    }

    /**
     * Save the data if id is not existed
     *
     * @param      <type>   $data   The data
     * @param      boolean  $id     The identifier
     */
	function save( &$data, $id = false ) {

		if ( !$id ) {
		// if id is not false and id is not yet existed,
			if ( !empty( $this->primary_key ) && !empty( $this->key_prefix )) {
			// if the primary key and key prefix is existed,
			
				// generate the unique key
				$data[ $this->primary_key ] = $this->generate_key();
			}

			// insert the data as new record
			return $this->db->insert( $this->table_name, $data );
			// print_r($this->db->last_query());die;

		} else {
		// else
			// where clause
			$this->db->where( $this->primary_key, $id);

			// update the data
			return $this->db->update($this->table_name,$data);
			 //print_r($this->db->last_query());die;

		}
	}

	/**
	 * Returns all the records
	 *
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 */
	function get_all( $limit = false, $offset = false ) {

		// where clause
		$this->custom_conds();

		// from table
		$this->db->from($this->table_name);

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		
		return $this->db->get();
	}

	/**
  * Gets all by the conditions
  *
  * @param      array    $conds   The conds
  * @param      boolean  $limit   The limit
  * @param      boolean  $offset  The offset
  *
  * @return     <type>   All by.
  */
	 function get_all_in( $conds = array(), $limit = false, $offset = false ) {

	  // where clause
	  $this->db->where_in('id', $conds);

	  // from table
	  $this->db->from( $this->table_name );

	  if ( $limit ) {
	  // if there is limit, set the limit
	   
	   $this->db->limit($limit);
	  }
	  
	  if ( $offset ) {
	  // if there is offset, set the offset,
	   
	   $this->db->offset($offset);
	  }
	  
	   return $this->db->get();
	    //print_r($this->db->last_query());die;
	 }

	/**
  * Gets all by the conditions
  *
  * @param      array    $conds   The conds
  * @param      boolean  $limit   The limit
  * @param      boolean  $offset  The offset
  *
  * @return     <type>   All by.
  */
	 function get_all_in_discount( $conds = array(), $limit = false, $offset = false ) {

	  // where clause
	  $this->db->where_in('discount_id', $conds);

	  // from table
	  $this->db->from( $this->table_name );

	  if ( $limit ) {
	  // if there is limit, set the limit
	   
	   $this->db->limit($limit);
	  }
	  
	  if ( $offset ) {
	  // if there is offset, set the offset,
	   
	   $this->db->offset($offset);
	  }
	  
	   return $this->db->get();
	 }
	 

	/**
	  * Gets all by the conditions
	  *
	  * @param      array    $conds   The conds
	  * @param      boolean  $limit   The limit
	  * @param      boolean  $offset  The offset
	  *
	  * @return     <type>   All by.
	*/
	 function get_all_not_in_discount( $conds = array(), $limit = false, $offset = false ) {

	  // where clause
	  $this->db->where_not_in('discount_id', $conds);

	  // from table
	  $this->db->from( $this->table_name );

	  if ( $limit ) {
	  // if there is limit, set the limit
	   
	   $this->db->limit($limit);
	  }
	  
	  if ( $offset ) {
	  // if there is offset, set the offset,
	   
	   $this->db->offset($offset);
	  }
	  
	   return $this->db->get();
	 }

	function get_all_not_shop( $conds = array() ) {
	  	$this->db->select('rt_shops.*'); 
	  	$this->db->from('rt_shops');
	  	// where clause
	  	if(isset($conds['shop_id'])) {

			if ($conds['shop_id'] != "" || $conds['shop_id'] != 0) {
					
					$this->db->where_not_in( 'id',$conds['shop_id'] );	

			}

		}

	   	return $this->db->get();
	   	// print_r($this->db->last_query());die;
	 }

	/**
	 * Returns all the records from not in
	 *
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 */
	function get_all_not_in($ignore, $limit = false, $offset = false ) {
		// where clause
		//$this->custom_conds();

		$this->db->where_not_in('id', $ignore);
		//$this->db->where('status', 1);

		// from table
		$this->db->from($this->table_name);

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		//$this->db->order_by("added_date", "DESC");
		
		return $this->db->get();
	}

	/**
	 * Returns all the records from not 
	 *
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 */

	function get_all_not($collection_id, $limit = false, $offset = false ) {

		$this->db->where('collection_id !=', $collection_id);

		// from table
		$this->db->from($this->table_name);

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		$this->db->order_by("added_date", "DESC");
		
		return $this->db->get();

	}

	/**
	 * Returns the total count
	 */
	function count_all() {
		// from table
		$this->db->from( $this->table_name );

		// where clause
		$this->custom_conds();

		// return the count all results
		return $this->db->count_all_results();
	}

	/**
	 * Return the info by Id
	 *
	 * @param      <type>  $id     The identifier
	 */
	function get_one( $id,$shop_id = 0 ) {

		
		// query the record
		if ( $shop_id != 0 ) 
		{
			$query = $this->db->get_where( $this->table_name, array( $this->primary_key => $id, "shop_id" => $shop_id ));
		} else {
			$query = $this->db->get_where( $this->table_name, array( $this->primary_key => $id ));
		}
		if ( $query->num_rows() == 1 ) {

		// if there is one row, return the record
			
			 return $query->row();
			
		} else {
		// if there is no row or more than one, return the empty object
			
			return $this->get_empty_object( $this->table_name );
		}
	}

	/**
	 * Returns the multiple Info by Id
	 *
	 * @param      array  $ids    The identifiers
	 */
	function get_multi_info( $ids = array()) {
		
		// from table
		$this->db->from( $this->table_name );

		// where clause
		$this->db->where_in( $this->primary_key, $ids );

		// returns
		return $this->db->get();
	}

	/**
	 * Delete the records by condition
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function get_product_favourite( $conds = array(), $limit = false, $offset = false  )
	{
		$this->db->select('rt_products.*'); 
		$this->db->from('rt_products');
		$this->db->join('rt_favourites', 'rt_favourites.product_id = rt_products.id');

		if(isset($conds['user_id'])) {

			if ($conds['user_id'] != "" || $conds['user_id'] != 0) {
					
					$this->db->where( 'user_id', $conds['user_id'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}
		
		return $this->db->get();
 	}

 	/**
	 * Return all related products trending
	 */
	function get_all_related_product_trending( $conds = array(), $limit = false, $offset = false ) 
	{

		// where clause
		// inner join with products and touches
		$this->db->select("prd.*");
		$this->db->from($this->table_name . ' as prd');
		$this->db->join('rt_touches as tou', 'prd.id = tou.type_id');
		$this->db->where( "tou.type_name", "product");
		$this->db->where( "prd.status", "1" );
		$this->db->where( "tou.type_id !=", $conds['id']);
		$this->db->where( "prd.cat_id =", $conds['cat_id']);

		$this->db->group_by("tou.type_id");
		$this->db->order_by("count(DISTINCT tou.id)", "DESC");

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}
		
	  return $this->db->get();

	}

	function all_products_by_collection( $conds = array(), $limit = false, $offset = false ) 
	{
		
		// from table
		$this->db->select('rt_products.*');
		$this->db->from('rt_products');
		$this->db->where('rt_products_collection.collection_id', $conds['id']);
		$this->db->where('rt_products.status', 1);
		$this->db->join('rt_products_collection', 'rt_products.id = rt_products_collection.product_id');

		

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

  		$this->db->order_by('rt_products.added_date', "DESC");
		
		return $this->db->get();


	}

 	/**
	 * Delete the records by condition
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function get_product_like( $conds = array(), $limit = false, $offset = false  )
	{
		$this->db->select('rt_products.*'); 
		$this->db->from('rt_products');
		$this->db->join('rt_likes', 'rt_likes.product_id = rt_products.id');

		if(isset($conds['user_id'])) {

			if ($conds['user_id'] != "" || $conds['user_id'] != 0) {
					
					$this->db->where( 'user_id', $conds['user_id'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}

		return $this->db->get();
		
 	}

 	 /**
	 * Return all collections
	 */
	function get_all_collections( $conds = array(), $limit = false, $offset = false ) 
	{
		
		$this->db->distinct();
		$this->db->select('prd.*');    
		$this->db->from('rt_products as prd');
		$this->db->join('rt_products_collection as cp', 'prd.id = cp.product_id');
		$this->db->where('cp.collection_id',  $conds['collection_id']);
		$this->db->where('prd.status', 1);
		$this->db->order_by("prd.added_date", "DESC");

		if ( $limit ) {
		// if there is limit, set the limit
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}

		return $this->db->get();

	}

	/**
	 * Return all trending categories
	 */
	function get_all_trending_category( $conds = array(), $limit = false, $offset = false ) 
	{

		// where clause
		//$this->custom_conds( $conds );

		// inner join with products and touches
		$this->db->select("cat.*");
		$this->db->from($this->table_name . ' as cat');
		$this->db->join('rt_touches as tou', 'cat.id = tou.type_id');
		$this->db->where( "tou.type_name", "category");
		$this->db->where( "cat.status", "1");

		$this->db->group_by("tou.type_id");
		$this->db->order_by("count(DISTINCT tou.id)", "DESC");

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		
		 return $this->db->get();

	}

	/**
	 * Delete the records by Id
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function delete( $id )
	{
		// where clause
		$this->db->where( $this->primary_key, $id );

		// delete the record
		return $this->db->delete( $this->table_name );
		// print_r($this->db->last_query());die;
 	}

 	/**
 	 * Delete the records by ids
 	 *
 	 * @param      array   $ids    The identifiers
 	 *
 	 * @return     <type>  ( description_of_the_return_value )
 	 */
 	function delete_list( $ids = array()) {
 		
 		// where clause
		$this->db->where_in( $this->primary_key, $id );

		// delete the record
		return $this->db->delete( $this->table_name );
 	}

	/**
	 * returns the object with the properties of the table
	 *
	 * @return     stdClass  The empty object.
	 */
    function get_empty_object()
    {   
        $obj = new stdClass();
        
        $fields = $this->db->list_fields( $this->table_name );
        foreach ( $fields as $field ) {
            $obj->$field = '';
        }
        $obj->is_empty_object = true;
        return $obj;
    }

   	/**
   	 * Execute The query
   	 *
   	 * @param      <type>   $sql     The sql
   	 * @param      <type>   $params  The parameters
   	 *
   	 * @return     boolean  ( description_of_the_return_value )
   	 */
	function exec_sql( $sql, $params = false )
	{
		if ( $params ) {
		// if the parameter is not false

			// bind the parameter and run the query
			return $this->db->query( $sql, $params );	
		}

		// if there is no parameter,
		return $this->db->query( $sql );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function conditions( $conds = array())
	{
		// if condition is empty, return true
		if ( empty( $conds )) return true;
	}

	/**
	 * Check if the key is existed,
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function exists( $conds = array()) {
		// where clause
		$this->custom_conds( $conds );

		// from table
		$this->db->from( $this->table_name );

		// get query
		$query = $this->db->get();
		
		// return the result
		return ($query->num_rows() == 1);
	}

	/**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_by( $conds = array(), $limit = false, $offset = false ) {
		//print_r($conds);die;
		// where clause
		if($conds['lat'] != "" && $conds['lng'] != "") {
			$this->db->select('*,( 3959
		      * acos( cos( radians('. $conds['lat'] .') )
		              * cos(  radians( lat )   )
		              * cos(  radians( lng ) - radians('. $conds['lng'] .') )
		            + sin( radians('. $conds['lat'] .') )
		              * sin( radians( lat ) )
		            )
		    ) as distance');

		    if ($conds['miles'] == "") {
		    	$conds['miles'] = 0;
		    	$this->db->having('distance < ' .  $conds['miles'] );
		    } else {
		    	$this->db->having('distance < ' .  $conds['miles'] );

		    }

		   
		}
		
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		return $this->db->get();
		 //print_r($this->db->last_query());die;
	}

	function get_all_by1( $conds = array(), $limit = false, $offset = false ) {
		//print_r($conds);die;
		// where clause
		if($conds['lat'] != "" && $conds['lng'] != "") {
			$this->db->select('*,( 3959
		      * acos( cos( radians('. $conds['lat'] .') )
		              * cos(  radians( lat )   )
		              * cos(  radians( lng ) - radians('. $conds['lng'] .') )
		            + sin( radians('. $conds['lat'] .') )
		              * sin( radians( lat ) )
		            )
		    ) as distance');

		    if ($conds['miles'] == "") {
		    	$conds['miles'] = 0;
		    	$this->db->having('distance < ' .  $conds['miles'] );
		    } else {
		    	$this->db->having('distance < ' .  $conds['miles'] );

		    }

		   
		}
		
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		 $this->db->get();
		 print_r($this->db->last_query());die;
	}



	function get_all_by_type($img_parent_id, $img_type, $limit=false, $offset=false)
 	{
 		$this->db->from($this->table_name);
 		$this->db->where('img_parent_id',$img_parent_id);
 		$this->db->where('img_type', $img_type);
 		
 		if ($limit) {
 			$this->db->limit($limit);
 		}
 		
 		if ($offset) {
 			$this->db->offset($offset);
 		}
 		
 		return $this->db->get();
 	}

	/**
	 * Counts the number of all by the conditions
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  Number of all by.
	 */
	function count_all_by( $conds = array()) {
		
		// where clause
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		// return the count all results
		return $this->db->count_all_results();
		 //print_r($this->db->last_query());die;
	}


	/**
	 * Sum the number of all by the conditions
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  Number of all by.
	 */
	function sum_all_by( $conds = array()) {
		
		// where clause
		$this->custom_conds( $conds );
		
		$this->db->select_sum('rating');
		// from table
		$this->db->from( $this->table_name );

		// return the count all results
		//return $this->db->count_all_results();
		return $this->db->get();
	}

	/**
	 * Gets the information by.
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  The information by.
	 */
	function get_one_by( $conds = array()) {

		// where clause
		$this->custom_conds( $conds );

		// query the record
		$query = $this->db->get( $this->table_name );

		if ( $query->num_rows() == 1 ) {
		// if there is one row, return the record
			return $query->row();
		} else {
		// if there is no row or more than one, return the empty object
			 return $this->get_empty_object( $this->table_name );
			
		}

	}

	/**
	 * Delete the records by condition
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function delete_by( $conds = array() )
	{
		// where clause
		$this->custom_conds( $conds );
		// delete the record
	    return $this->db->delete( $this->table_name );
	  //print_r($this->db->last_query());die;
	 
 	}

	/**
	* Gets popular categories record
	*/
	function get_category_by ( $conds = array(), $limit = false, $offset = false ){

		//$this->custom_conds();
		//where clause
		$this->db->select('rt_categories.*, count(rt_touches.type_id) as t_count');    
  		$this->db->from('rt_categories');
  		$this->db->join('rt_touches', 'rt_categories.id = rt_touches.type_id');
  		$this->db->where('rt_touches.type_name','category');
  		$this->db->where('rt_categories.status',1);
  		$this->db->where('rt_touches.shop_id',$conds['shop_id']);

  		if ( isset( $conds['search_term'] )) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_touches.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_touches.added_date) <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_touches.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_touches.added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			}
			 
	    }

		
  		$this->db->group_by('rt_touches.type_id');
  		$this->db->order_by('t_count', "DESC");
  		$this->db->order_by( 'rt_touches.added_date', "desc" );
  		

  		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

  		return $this->db->get();

	}

	/**
	Returns popular categories count
	*/
	function count_category_by($conds = array()){
		$this->custom_conds();
		//where clause
		
		$this->db->select('rt_categories.*, count(rt_touches.type_id) as t_count');    
  		$this->db->from('rt_categories');
  		$this->db->join('rt_touches', 'rt_categories.id = rt_touches.type_id');
  		$this->db->where('rt_touches.type_name','category');
  		$this->db->where('rt_categories.status',1);
  		$this->db->where('rt_touches.shop_id',$conds['shop_id']);

  		

		if ( isset( $conds['search_term'] )) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}

			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_touches.added_date >=', $mindate );
   					$this->db->where( 'rt_touches.added_date <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_touches.added_date >=', $mindate );
   					$this->db->where( 'rt_touches.added_date <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
				
			}
			 
	    }
		

  		$this->db->group_by('rt_touches.type_id');
  		$this->db->order_by('t_count', "DESC");


  		return $this->db->count_all_results();
	}

	/**
	Returns popular products count
	*/
	function count_product_by($conds = array()){
		$this->custom_conds();
		//where clause
		$this->db->select('rt_products.*, count(rt_touches.type_id) as t_count');    
  		$this->db->from('rt_products');
  		$this->db->join('rt_touches', 'rt_products.id = rt_touches.type_id');
  		$this->db->where('rt_touches.type_name','product');
  		$this->db->where('rt_products.status',1);
  		$this->db->where('rt_touches.shop_id',$conds['shop_id']);

  		if ( isset( $conds['cat_id'] )) {
			if ($conds['cat_id'] != "" ) {
				if ($conds['cat_id'] != '0') {
					$this->db->where( 'rt_products.cat_id', $conds['cat_id'] );	
				} 
				
			}
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			if ($conds['sub_cat_id'] != "" ) {
				if ($conds['sub_cat_id'] != '0') {
					$this->db->where( 'rt_products.sub_cat_id', $conds['sub_cat_id'] );
				}
				
			}
			
		}

		if ( isset( $conds['search_term'] ) || isset( $conds['date'] ) ) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_touches.added_date >=', $mindate );
   					$this->db->where( 'rt_touches.added_date <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_touches.added_date >=', $mindate );
   					$this->db->where( 'rt_touches.added_date <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
				
			}
			 
	    }
  		$this->db->group_by('rt_touches.type_id');
  		$this->db->order_by('t_count', "DESC");


  		return $this->db->count_all_results();
	}

	/**
	* Gets popular products record
	*/
	function get_product_by ( $conds = array(), $limit = false, $offset = false ){

		//where clause
		$this->db->select('rt_products.*, count(rt_touches.type_id) as t_count');    
  		$this->db->from('rt_products');
  		$this->db->join('rt_touches', 'rt_products.id = rt_touches.type_id');
  		$this->db->where('rt_touches.type_name','product');
  		$this->db->where('rt_products.status',1);
  		$this->db->where('rt_touches.shop_id',$conds['shop_id']);

  		if ( isset( $conds['cat_id'] )) {
			if ($conds['cat_id'] != "" ) {
				if ($conds['cat_id'] != '0') {
					$this->db->where( 'rt_products.cat_id', $conds['cat_id'] );	
				} 
				
			}
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			if ($conds['sub_cat_id'] != "" ) {
				if ($conds['sub_cat_id'] != '0') {
					$this->db->where( 'rt_products.sub_cat_id', $conds['sub_cat_id'] );
				}
				
			}
			
		}
  		
		if ( isset( $conds['search_term'] ) || isset( $conds['date'] )) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_touches.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_touches.added_date) <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_touches.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_touches.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_touches.added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
				
			}
			 
	    }

  		$this->db->group_by('rt_touches.type_id');
  		$this->db->order_by('t_count', "DESC");
  		$this->db->order_by('rt_touches.added_date', "desc");
  		

  		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

  		return $this->db->get();
  		//print_r($this->db->last_query());die;

	}

	/**
	* Returns purchased categories count
	*/

	 function count_purchased_category_by( $conds = array() ) {

		$this->db->select('rt_categories.*, count(rt_transactions_counts.cat_id) as t_count');    
		$this->db->from('rt_categories');
		$this->db->join('rt_transactions_counts', 'rt_categories.id = rt_transactions_counts.cat_id');
		$this->db->where('rt_categories.status',1);
		$this->db->where('rt_transactions_counts.shop_id',$conds['shop_id']);



  		if ( isset( $conds['search_term'] )) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_transactions_counts.added_date >=', $mindate );
   					$this->db->where( 'rt_transactions_counts.added_date <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );

			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_transactions_counts.added_date >=', $mindate );
   					$this->db->where( 'rt_transactions_counts.added_date <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
				
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			}
			 
	    }
		

  		$this->db->group_by('rt_transactions_counts.cat_id');
  		$this->db->order_by('t_count', "DESC");

  		return $this->db->count_all_results();
}

/**
	* Gets purchased categories record
	*/

public function get_purchased_category_by ( $conds = array(), $limit = false, $offset = false ){
		//$this->custom_conds();
		//where clause
		$this->db->select('rt_categories.*, count(rt_transactions_counts.cat_id) as t_count');    
  		$this->db->from('rt_categories');
  		$this->db->join('rt_transactions_counts', 'rt_categories.id = rt_transactions_counts.cat_id');
  		$this->db->where('rt_categories.status',1);
  		$this->db->where('rt_transactions_counts.shop_id',$conds['shop_id']);

  		

		if ( isset( $conds['search_term'] )) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates			
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_transactions_counts.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_transactions_counts.added_date) <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_transactions_counts.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_transactions_counts.added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			}
			 
			 
	    }

  		$this->db->group_by('rt_transactions_counts.cat_id');
  		$this->db->order_by('t_count', "DESC");
  		$this->db->order_by('rt_transactions_counts.added_date', "desc");
  		

  		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

  		return $this->db->get();

	}

	/**
	Returns purchased products count
	*/
	function count_purchased_product_by($conds = array()){
		$this->custom_conds();
		//where clause		
		$this->db->select('rt_products.*, count(rt_transactions_counts.product_id) as t_count');    
  		$this->db->from('rt_products');
  		$this->db->join('rt_transactions_counts', 'rt_products.id = rt_transactions_counts.product_id');
  		$this->db->where('rt_products.status',1);
  		$this->db->where('rt_transactions_counts.shop_id',$conds['shop_id']);

  		if ( isset( $conds['cat_id'] )) {
			if ($conds['cat_id'] != "" ) {
				if ($conds['cat_id'] != '0') {
					$this->db->where( 'rt_products.cat_id', $conds['cat_id'] );	
				} 
				
			}
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			if ($conds['sub_cat_id'] != "" ) {
				if ($conds['sub_cat_id'] != '0') {
					$this->db->where( 'rt_products.sub_cat_id', $conds['sub_cat_id'] );
				}
				
			}
			
		}

  		if ( isset( $conds['search_term'] ) || isset( $conds['date'] ) ) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			

			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates				
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_transactions_counts.added_date >=', $mindate );
   					$this->db->where( 'rt_transactions_counts.added_date <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );
			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {
					$this->db->where( 'rt_transactions_counts.added_date >=', $mindate );
   					$this->db->where( 'rt_transactions_counts.added_date <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			}
			 
	    }

  		$this->db->group_by('rt_transactions_counts.product_id');
  		$this->db->order_by('t_count', "DESC");


  		return $this->db->count_all_results();
	}

	/**
	* Gets purchased products record
	*/
	function get_purchased_product_by ( $conds = array(), $limit = false, $offset = false ){

		//$this->custom_conds();
		//where clause
		$this->db->select('rt_products.*, count(rt_transactions_counts.product_id) as t_count');    
  		$this->db->from('rt_products');
  		$this->db->join('rt_transactions_counts', 'rt_products.id = rt_transactions_counts.product_id');
  		$this->db->where('rt_products.status',1);
  		$this->db->where('rt_transactions_counts.shop_id',$conds['shop_id']);

  		if ( isset( $conds['cat_id'] )) {
			if ($conds['cat_id'] != "" ) {
				if ($conds['cat_id'] != '0') {
					$this->db->where( 'rt_products.cat_id', $conds['cat_id'] );	
				} 
				
			}
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			if ($conds['sub_cat_id'] != "" ) {
				if ($conds['sub_cat_id'] != '0') {
					$this->db->where( 'rt_products.sub_cat_id', $conds['sub_cat_id'] );
				}
				
			}
			
		}

		if ( isset( $conds['search_term'] ) || isset( $conds['date'] ) ) {
			$dates = $conds['date'];

			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['search_term'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates			
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(rt_transactions_counts.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_transactions_counts.added_date) <=', $maxdate );

				}
				$this->db->like( '(name', $conds['search_term'] );
				$this->db->or_like( 'name)', $conds['search_term'] );

			} else if ($conds['search_term'] != "" && $mindate != "" && $maxdate != "") {
				//got name and 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("rt_transactions_counts.added_date BETWEEN DATE('".$mindate."') AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}
					
					$this->db->where( 'date(rt_transactions_counts.added_date) >=', $mindate );
   					$this->db->where( 'date(rt_transactions_counts.added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();

			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'name', $conds['search_term'] );
				$this->db->or_like( 'name', $conds['search_term'] );
				$this->db->group_end();
			}
			 
	    }

  		$this->db->group_by('rt_transactions_counts.product_id');
  		$this->db->order_by('t_count', "DESC");
  		$this->db->order_by('rt_transactions_counts.added_date',"desc");

  		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

  		return $this->db->get();
  		 //print_r($this->db->last_query());die;

	}

 	/**
	 * Delete the records by condition
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function get_all_shop_by_tag_id( $conds = array(), $limit = false, $offset = false )
	{
		
		$this->db->select('rt_shops.*'); 
		$this->db->from('rt_shops');
		$this->db->join('rt_shops_tags', 'rt_shops_tags.shop_id = rt_shops.id');
		$this->db->where('rt_shops.status',1);

		if(isset($conds['tag_id'])) {

			if ($conds['tag_id'] != "" || $conds['tag_id'] != 0) {
					
					$this->db->where( 'tag_id', $conds['tag_id'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		$this->db->group_by("rt_shops_tags.shop_id");
		$this->db->order_by("count(DISTINCT rt_shops_tags.shop_id)", "DESC");
		$this->db->order_by("rt_shops.added_date", "DESC");
		
		return $this->db->get();
		 // print_r($this->db->last_query());die;
 	}

	function get_transaction_status_count( $conds = array() )
	{
		$this->db->select(' count(trans_status_id) as s_count'); 
		$this->db->from('rt_transactions_header');
		$this->db->join('rt_transactions_status','rt_transactions_header.trans_status_id = rt_transactions_status.id');

		if(isset($conds['trans_status_id'])) {

			if ($conds['trans_status_id'] != "" || $conds['trans_status_id'] != 0) {
					
					$this->db->where( 'trans_status_id', $conds['trans_status_id'] );	

			}

		}

		if(isset($conds['shop_id'])) {

			if ($conds['shop_id'] != "" || $conds['shop_id'] != 0) {
					
					$this->db->where( 'shop_id', $conds['shop_id'] );	

			}

		}

	
	  return $this->db->get();
 	}

 	/**
	Returns purchased products count
	*/
	function get_purchased_count( $conds = array() )
	{
		
		$this->db->select('rt_products.*, count(rt_transactions_counts.product_id) as t_count');    
  		$this->db->from('rt_products');
  		$this->db->join('rt_transactions_counts', 'rt_products.id = rt_transactions_counts.product_id');
  		$this->db->where('rt_products.status',1);
  		$this->db->where('rt_products.shop_id',$conds['shop_id']);
  		$this->db->limit(5);
  		$this->db->group_by('rt_transactions_counts.product_id');
  		$this->db->order_by("t_count", "DESC");
		return $this->db->get();
		 // print_r($this->db->last_query());die;
	}

	/**
	Returns purchased products count
	*/
	function get_transaction_by_month($conds = array())
	{
		//print_r("asdfasd" .$conds);die;
		$this->db->select('rt_transactions_counts.*');    
  		$this->db->from('rt_transactions_counts');
  		$this->db->where('month(added_date)',$conds['added_date']);
  		$this->db->where('rt_transactions_counts.shop_id',$conds['shop_id']);

		return $this->db->get();
		 // print_r($this->db->last_query());die;
	}

	/**
	Returns Shop Admin 
	*/
	function get_shop_admin($conds = array())
	{
	
		$this->db->select('rt_user_shops.*');    
  		$this->db->from('rt_user_shops');
  		$this->db->where('rt_user_shops.shop_id',$conds['shop_id']);

		return $this->db->get();
		// print_r($this->db->last_query());die;
		
	}

	/**
	 * Gets the allowed modules.
	 *
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  The allowed modules.
	 */
	function get_shop_id( $conds = array() )
	{
		$this->db->select('rt_user_shops.*');    
  		$this->db->from('rt_user_shops');
  		$this->db->where('rt_user_shops.user_id',$conds['user_id']);

  		return $this->db->get();
  		
	}

	/**
	Returns Shop Admin 
	*/
	function get_all_module( )
	{
	
		$this->db->select('core_modules.*');    
  		$this->db->from('core_modules');
  		$this->db->where('is_show_on_menu',1);
  		$this->db->order_by('group_id','AESC');
		return $this->db->get();
		
	}

	/**
	Returns recent product
	*/
	function get_rec_product( $conds = array() )
	{
	
		$this->db->select('rt_products.*');    
  		$this->db->from('rt_products');
  		$this->db->limit(4);
  		if(isset($conds['shop_id'])) {

			if ($conds['shop_id'] != "" || $conds['shop_id'] != 0) {
					
					$this->db->where( 'shop_id', $conds['shop_id'] );	

			}

		}
		
  		$this->db->order_by('added_date','DESC');
		return $this->db->get();
		
	}

	/**
	Returns recent product
	*/
	function get_all_product_by_rating( $conds = array() )
	{
		$this->db->select('rt_products.*');    
  		$this->db->from('rt_products');
  		$this->db->where_in('overall_rating', $conds);

		$this->db->order_by('added_date','DESC');
		return $this->db->get();
		
	}

	/**
	Returns recent product
	*/
	function get_all_product( $conds = array() )
	{



		if($conds['prd_ids_from_dis_other'] != "") {

			if($conds['prd_ids_from_dis'] != "") {

				//Both have filder values 
				
				$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' and id NOT IN(". $conds['prd_ids_from_dis_other'] .")  ORDER BY CASE WHEN id in (". $conds['prd_ids_from_dis'] .") then -1 else id end,id, is_discount asc";

			} else {

				//Disocunt not yet selected the product so no need ordering
				$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' and id NOT IN(". $conds['prd_ids_from_dis_other'] .")";


			}



		} else if($conds['prd_ids_from_dis_other'] == "") {

			if($conds['prd_ids_from_dis'] != "") {

				//Products from other discount don't have but current have the products
				$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' ORDER BY CASE WHEN id in (". $conds['prd_ids_from_dis'] .") then -1 else id end,id, is_discount asc";

			} else {
				//Disocunt not yet selected the product so no need ordering
				$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."'";
			}

		}
		// else if($conds['prd_ids_from_dis'] != "") {
		// 	echo "dasdasd"; die;
		// 	$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' and id NOT IN(". $conds['prd_ids_from_dis_other'] .")  ORDER BY CASE WHEN id in (". $conds['prd_ids_from_dis'] .") then -1 else id end,id, is_discount asc";
		// 	echo $sql; die;

		// } else {
		// 	echo "333"; die;
		// 	$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' ORDER BY CASE WHEN id in (". $conds['prd_ids_from_dis'] .") then -1 else id end,id, is_discount asc";
		// 	echo $sql; die;
		// }


		
		$query = $this->db->query($sql);

		return $query;
		
	}

	/**
	Returns recent product
	*/
	function get_all_product_collection( $conds = array() )
	{
	
		$sql = "SELECT *  FROM rt_products WHERE shop_id = '". $conds['shop_id'] ."' ORDER BY CASE WHEN id in (". $conds['prd_ids_from_coll'] .") then -1 else id end,id, is_discount asc";
		$query = $this->db->query($sql);

		return $query;
		
	}

	/**
	Returns total product count from transaction
	*/
	function get_product_count_from_transaction( $conds = array() )
	{
	
		$sql = "SELECT SUM(`qty`) as total FROM `rt_transactions_detail` WHERE `transactions_header_id` = '" . $conds['trans_header_id'] . "'";


		$query = $this->db->query($sql);

		return $query;
		
	}
	function get_all_by_shop( $conds = array(), $limit = false, $offset = false ) {
		
		$this->custom_conds();

		$this->db->select('rt_shops.*');    
  		$this->db->from('rt_shops');
  		$this->db->where('status', $conds['status']);
		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		return $this->db->get();
		// print_r($this->db->last_query());die;
	}

	// get user with status 2 for request code

	function user_exists( $conds = array()) {
		//print_r($conds);die;
		$sql = "SELECT * FROM core_users WHERE `user_email` = '" . $conds['user_email'] . "' AND `status` = '" . $conds['status'] . "' ";

		$query = $this->db->query($sql);

		return $query;

		//print_r($this->db->last_query());die;
	}

	// get user with status 2 for verify code

	function get_one_user( $conds = array()) {

		$sql = "SELECT * FROM core_users WHERE `status` = '" . $conds['status'] . "' AND `code` = '" . $conds['code'] . "' ";

		$query = $this->db->query($sql);

		return $query;
	}



	function get_shop_by_id( $conds = array(), $limit = false, $offset = false  )
	{
		$this->db->select('rt_shops.*'); 
		$this->db->from('rt_shops');

		if(isset($conds['id'])) {

			if ($conds['id'] != "" || $conds['id'] != 0) {
					
					$this->db->where_in( 'id', $conds['id'] );	

			}

		}
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,

			$this->db->offset($offset);
		}
		
		return $this->db->get();
	}

	// get user with email conds

	function get_one_user_email( $conds = array()) {

		$sql = "SELECT * FROM core_users WHERE `user_email` = '" . $conds['user_email'] . "' ";

		$query = $this->db->query($sql);

		return $query;
	}

	// get user with email and phone

	function get_email_phone( $conds = array()) {

		$sql = "SELECT * FROM core_users WHERE `user_email` = '" . $conds['user_email'] . "' AND `phone_id` = '" . $conds['phone_id'] . "' ";

		$query = $this->db->query($sql);

		return $query;
	}

	/**
	Returns recent product
	*/
	function get_all_image_update( $conds1 = array() )
	{
	
		$sql = "UPDATE core_images SET is_default=0 WHERE img_id IN ( ". $conds1['img_id'] ." )";
		
		$query = $this->db->query($sql);

		return $query;
		
	}

	function get_all_not_in_lang( $id, $limit = false, $offset = false ) {
		// where clause
		$this->db->where_not_in('id', $id);

		// from table
		$this->db->from( $this->table_name );

		if ( $limit ) {
		  // if there is limit, set the limit
		   
		   $this->db->limit($limit);
		}
		  
		if ( $offset ) {
		  // if there is offset, set the offset,
		   
		   $this->db->offset($offset);
		}
		  
		return $this->db->get();
		// print_r($this->db->last_query());die;
	}

	function get_language_string( $conds = array() ){

		// from table
	  	$this->db->from( $this->table_name );

	  	if(isset($conds['language_id'])) {

			if ($conds['language_id'] != "" || $conds['language_id'] != 0) {
					
					$this->db->where( 'language_id', $conds['language_id'] );	

			}

		}

		if(isset($conds['key'])) {

			if ($conds['key'] != "" || $conds['key'] != 0) {
					
					$this->db->where( 'key', $conds['key'] );	

			}

		}
		return $this->db->get();

	}

	// get name with status 0 or 1

	function lang_exists( $conds = array()) {

		$sql = "SELECT * FROM rt_language WHERE `name` = '" . $conds['name'] . "' ";


		$query = $this->db->query($sql);

		return $query;
	}
	
	// get symbol with status 0 or 1

	function symbol_exists( $conds = array()) {

		$sql = "SELECT * FROM rt_language WHERE `symbol` = '" . $conds['symbol'] . "' ";
		

		$query = $this->db->query($sql);

		return $query;
	}

	function get_all_order_delivery( $conds = array() ){

		// from table
	  	$this->db->from( $this->table_name );

	  	if(isset($conds['delivery_boy_id'])) {

			if ($conds['delivery_boy_id'] != "" || $conds['delivery_boy_id'] != 0) {
					
					$this->db->where( 'delivery_boy_id', $conds['delivery_boy_id'] );	

			}

		}

		if ($conds['status'] == "pending") {
			if(isset($conds['trans_status_id'])) {

				if ($conds['trans_status_id'] != "" || $conds['trans_status_id'] != 0) {
						
						$this->db->where( 'trans_status_id!=', $conds['trans_status_id'] );	

				}

			}
		} else {
			if(isset($conds['trans_status_id'])) {

				if ($conds['trans_status_id'] != "" || $conds['trans_status_id'] != 0) {
						
						$this->db->where( 'trans_status_id', $conds['trans_status_id'] );	

				}

			}
		}
		
		return $this->db->get();
		//print_r($this->db->last_query());die;
	}

	function get_all_addon($addon_id= array())
	{
		$this->db->select('rt_additional.*'); 
		$this->db->from('rt_additional');
		$this->db->where_in('id', $addon_id);
		return $this->db->get();
	}

	/**
	Update trans start stage update
	*/
	function update_start_stage( $conds = array() )
	{

		$sql = "UPDATE rt_transactions_status SET start_stage = '0' WHERE id != '". $conds['id'] ."' ";
		
		$query = $this->db->query($sql);

		return $query;
		
	}

	/**
	Update trans final stage update
	*/
	function update_final_stage( $conds = array() )
	{

		$sql = "UPDATE rt_transactions_status SET final_stage = '0' WHERE id != '". $conds['id'] ."' ";
		
		$query = $this->db->query($sql);

		return $query;
		
	}

	function update_shop_status_prd( $conds_prd_shop = array() )
	{

		$sql = "UPDATE rt_products SET shop_status = '". $conds_prd_shop['shop_status'] ."' WHERE shop_id = '". $conds_prd_shop['shop_id'] ."' ";


		
		$query = $this->db->query($sql);

		return $query;
		
	}

	function update_shop_status_collection( $conds_collection_shop = array() )
	{

		$sql = "UPDATE rt_collections SET shop_status = '". $conds_collection_shop['shop_status'] ."' WHERE shop_id = '". $conds_collection_shop['shop_id'] ."' ";


		
		$query = $this->db->query($sql);

		return $query;
		
	}

	function update_shop_status_blog( $conds_blog_shop = array() )
	{

		$sql = "UPDATE rt_feeds SET shop_status = '". $conds_blog_shop['shop_status'] ."' WHERE shop_id = '". $conds_blog_shop['shop_id'] ."' ";


		
		$query = $this->db->query($sql);

		return $query;
		
	}

	/** get all deli boy */

	function get_deli_boy( $conds = array(), $limit = false, $offset = false )
	{

		$this->custom_conds();
		$this->db->select('core_users.*'); 
		$this->db->from('core_users');
		$this->db->where('role_id', $conds['role_id']);
		$this->db->where('status!=', $conds['status']);


		//  deli status condition 
		if ( isset( $conds['deliboy_status'] )) {
			if ($conds['deliboy_status'] != "" ) {
				if ($conds['deliboy_status'] != '0') {
					$this->db->where( 'status', $conds['deliboy_status'] );
				}
				
			}
			
		}

		//print_r($conds);die;


		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		return $this->db->get();
		//print_r($this->db->last_query());die;
	}

	/** count all deli boy */

	function count_deli_boy( $conds = array() )
	{
		$this->custom_conds();
		$this->db->select('core_users.*'); 
		$this->db->from('core_users');
		$this->db->where('status!=', $conds['status']);
		$this->db->where('role_id', $conds['role_id']);

		//  deli status condition 
		if ( isset( $conds['deliboy_status'] )) {
			if ($conds['deliboy_status'] != "" ) {
				if ($conds['deliboy_status'] != '0') {
					$this->db->where( 'status', $conds['deliboy_status'] );
				}
				
			}
			
		}

		return $this->db->count_all_results();
	}

	// get categories by shop id filter

 	function get_category( $conds = array(), $limit = false, $offset = false  )
	{
		$this->db->select('rt_categories.*'); 
		$this->db->from('rt_categories');
		$this->db->join('rt_products', 'rt_products.cat_id = rt_categories.id');

		if ( isset( $conds['shop_id'] )) {
			if ($conds['shop_id'] != "" ) {
				if ($conds['shop_id'] != '0') {
					$this->db->where( 'rt_products.shop_id', $conds['shop_id'] );
				}
				
			}
			
		}

		if ( !isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'rt_categories.status', 1 );
		}

		if ( $limit ) {
		// if there is limit, set the limit
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}

		//$this->db->order_by("count(DISTINCT rt_subcategories.id)", "DESC");
		$this->db->distinct();
		return $this->db->get();

 	}

 	// get user with phone conds

	function get_one_user_phone( $conds = array()) {

		$sql = "SELECT * FROM core_users WHERE `user_phone` = '" . $conds['user_phone'] . "' ";

		$query = $this->db->query($sql);

		return $query;
	}

	/**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_user( $conds = array(), $limit = false, $offset = false ) {
		//print_r($conds);die;
		
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		return $this->db->get();
		 //print_r($this->db->last_query());die;
	}


}