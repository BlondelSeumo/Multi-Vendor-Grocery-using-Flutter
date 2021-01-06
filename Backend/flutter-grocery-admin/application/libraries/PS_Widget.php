<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Widget {

	// codeigniter instance
	protected $CI;

	// template path
	protected $template_path;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();

		// load authetication library
		$this->CI->load->library( "PS_Auth" );
	}

	/**
	 * Default Conditions
	 *
	 * @param      <type>  $conds  The conds
	 */
	function base_conds()
	{
		if ( $this->CI->ps_auth->is_logged_in()) {
		// if there is logged in user, all news will be filterd by user id

			return array( 'login_user_id' => $this->CI->ps_auth->get_user_info()->user_id, 'filter_subscribe_category' => '1' );
		}

		return array();
	}

	/**
	 * Sets the template path.
	 *
	 * @param      <type>  $path   The path
	 */
	function set_template_path( $path )
	{
		$this->template_path = $path;
	}

	/**
	 * Widget for aboutus
	 */
	function aboutus_sm()
	{
		$data['aboutus'] = $this->CI->About->get_one_by( array());

		$this->CI->load->view( $this->template_path .'/components/aboutus_sm', $data );
	}

	/**
	 * Widget for contactus
	 */
	function contactus_sm()
	{
		$this->CI->load->view( $this->template_path .'/components/contactus_sm');
	}

	/**
	 * Widget for articles list
	 */
	function articles_list( $news )
	{
		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ){
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$news_list[] = $n;
			}
		}

		$data['article_list'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/articles_list', $data );
	}

	/**
	 * Widget for breaking news
	 */
	function breaking_news()
	{
		// get 5 featured news
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;
		
		$conds['editor_picked'] = 1;

		$data['news'] = $this->CI->NewsModel->get_all_by( $conds, 5 )->result();

		$this->CI->load->view( $this->template_path .'/components/breaking_news', $data );
	}

	/**
	 * Widget for categories list
	 */
	function categories_list( $limit = false )
	{
		$cats = array();

		if ( $limit ) {
			$cats = $this->CI->Category->get_all( $limit )->result();

		} else {

			$cats = $this->CI->Category->get_all()->result();
		}

		$categories = array();
		if ( !empty( $cats )) {
			foreach ( $cats as $cat ) {
				$cat->images = $this->CI->Image->get_all_by( array( 'img_type' => 'category', 'img_parent_id' => $cat->cat_id ))->result();

				if ( $this->CI->ps_auth->is_logged_in()) {
					if ( $this->CI->UserCategory->exists( array( 'cat_id' => $cat->cat_id, 'user_id' => $this->CI->ps_auth->get_user_info()->user_id ))) {
						$cat->is_subscribed = "1";
					}
				}

				$categories[] = $cat;
			}
		}

		$data['limit'] = $limit;
		$data['cats'] = $categories;

		$this->CI->load->view( $this->template_path .'/components/categories_list', $data );
	}

	/**
	 * Widget for comments
	 */
	function comments( $news_id )
	{	

		$limit = $this->CI->config->item( 'comments_display_limit' );
		$offset = 0;

		// get all comments
		$comments = $this->CI->Comment->get_all_by( array( 'news_id' => $news_id, 'added_date_asc' => '1' ), $limit, $offset )->result();

		// get all users
		$cmts = array();
		if( !empty( $comments )) {
			foreach ( $comments as $comment ) {
				$comment->user = $this->CI->User->get_one( $comment->user_id );
				$cmts[] = $comment;
			}
		}

		$data['comments'] = $comments;
		$data['comments_count'] = $this->CI->Comment->count_all_by( array( 'news_id' => $news_id ) );
		$data['comments_limit'] = $limit;

		$this->CI->load->view( $this->template_path .'/components/comments', $data );
	}

	/**
	 * Widget for editor pick
	 */
	function editor_pick()
	{
		// get 5 featured news		
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;
		
		$conds['editor_picked'] = 1;

		$news = $this->CI->NewsModel->get_all_by( $conds, 4 )->result();

		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ) {
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$news_list[] = $n;
			}
		}

		$data['editor_pick'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/editor_pick', $data );
	}

	/**
	 * Widget for featured articles
	 */
	function featured_articles()
	{
		// get 5 featured news		
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;
		
		$conds['editor_picked'] = 1;

		$news = $this->CI->NewsModel->get_all_by( $conds, 3, 4 )->result();

		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ) {
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$n->user = $this->CI->User->get_one( $n->user_id );

				$news_list[] = $n;
			}
		}

		$data['featured_articles'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/featured_articles', $data );
	}

	/**
	 * Widget for featured articles
	 */
	function trending_articles()
	{
		// get 5 featured news		
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;
		
		$conds['trending'] = 1;

		$news = $this->CI->NewsModel->get_all_by( $conds, 3, 4 )->result();

		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ) {
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$n->user = $this->CI->User->get_one( $n->user_id );

				$news_list[] = $n;
			}
		}

		$data['featured_articles'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/trending_articles', $data );
	}

	/**
	 * Widget for latest news
	 */
	function latest_news()
	{
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;

		// get latest 6
		$news = $this->CI->NewsModel->get_all_by( $conds, 6, 10 )->result();

		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ) {
				$n->category = $this->CI->Category->get_one( $n->cat_id );

				$news_list[] = $n;
			}
		}

		$data['latest_news'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/latest_news', $data );
	}

	/**
	 * Widget for recent articles
	 */
	function recent_articles()
	{
		$conds = $this->base_conds();
		$conds['news_is_published'] = 1;

		// get latest 6
		$news = $this->CI->NewsModel->get_all_by( $conds, 5 )->result();

		$news_list = array();
		if ( !empty( $news )) {
			foreach ( $news as $n ) {
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$news_list[] = $n;
			}
		}

		$data['recent_articles'] = $news_list;

		$this->CI->load->view( $this->template_path .'/components/recent_articles', $data );
	}

	/**
	 * Widget for favourite articles
	 */
	function favourite_articles()
	{
		if ( !$this->CI->ps_auth->is_logged_in()) {
			return false;
		}

		$conds = array( 'user_id' => $this->CI->ps_auth->get_user_info()->user_id );

		// get latest 6
		$limit = $this->CI->config->item( 'fav_display_limit' );
		$favs = $this->CI->Favourite->get_all_by( $conds, $limit )->result();

		$news_list = array();
		if ( !empty( $favs )) {
			foreach ( $favs as $fav ) {
				
				$n = $this->CI->NewsModel->get_one( $fav->news_id );
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$news_list[] = $n;
			}
		}

		$data['favourite_articles'] = $news_list;
		$data['fav_limit'] = $limit;
		$data['total_favs'] = $this->CI->Favourite->count_all_by( $conds );

		$this->CI->load->view( $this->template_path .'/components/favourite_articles', $data );
	}

	/**
	 * Widget for like articles
	 */
	function like_articles()
	{
		if ( !$this->CI->ps_auth->is_logged_in()) {
			return false;
		}

		$conds = array( 'user_id' => $this->CI->ps_auth->get_user_info()->user_id );

		// get latest 6
		$limit = $this->CI->config->item( 'like_display_limit' );
		$favs = $this->CI->Like->get_all_by( $conds, $limit )->result();

		$news_list = array();
		if ( !empty( $favs )) {
			foreach ( $favs as $fav ) {
				
				$n = $this->CI->NewsModel->get_one( $fav->news_id );
				$n->images = $this->CI->Image->get_all_by( array( 'img_type' => 'news', 'img_parent_id' => $n->news_id ))->result();

				$news_list[] = $n;
			}
		}

		$data['like_articles'] = $news_list;
		$data['like_limit'] = $limit;
		$data['total_likes'] = $this->CI->Like->count_all_by( $conds );

		$this->CI->load->view( $this->template_path .'/components/like_articles', $data );
	}

	/**
	 * Widget for recent comments
	 */
	function recent_comments()
	{
		$this->CI->load->view( $this->template_path .'/components/recent_comments');
	}

	/**
	 * Widget for popular post
	 */
	function popular_posts()
	{
		$this->CI->load->view( $this->template_path .'/components/popular_posts');
	}

	/**
	 * Widget for today pick
	 */
	function today_pick()
	{
		$this->CI->load->view( $this->template_path .'/components/today_pick');
	}

	/**
	 * Social Share
	 *
	 * @param      <type>  $news   The news
	 */
	function social_share( $news )
	{
		$data['news'] = $news;

		$this->CI->load->view( $this->template_path .'/components/social_share', $data );
	}

	/**
	 * News Social such as like, fav, comments
	 *
	 * @param      <type>  $news   The news
	 */
	function social_info( $news )
	{
		// total likes
		$news->total_likes = $this->CI->Like->count_all_by( array( 'news_id' => $news->news_id ));
		
		// total comments
		$news->total_comments = $this->CI->Comment->count_all_by( array( 'news_id' => $news->news_id ));
		
		// total favourites
		$news->total_favourites = $this->CI->Favourite->count_all_by( array( 'news_id' => $news->news_id ));

		if ( $this->CI->ps_auth->is_logged_in()) {
		// if there is logged in user,

			$user_id = $this->CI->ps_auth->get_user_info()->user_id;

			// check if the user like the news
			$news->is_user_liked = ( $this->CI->Like->count_all_by( array( 'news_id' => $news->news_id, 'user_id' => $user_id )) > 0 )? 1: 0;
			
			// check if the user comment the news
			$news->is_user_commented = ( $this->CI->Comment->count_all_by( array( 'news_id' => $news->news_id, 'user_id' => $user_id )) > 0 )? 1: 0;
			
			// check if the user favourites
			$news->is_user_favourited = ( $this->CI->Favourite->count_all_by( array( 'news_id' => $news->news_id, 'user_id' => $user_id )) > 0 )? 1: 0;
		}

		$data['news'] = $news;

		$this->CI->load->view( $this->template_path .'/components/social_info', $data );
	}

	/**
	 * Youtube List
	 *
	 * @param      <type>  $news_id  The news identifier
	 */
	function youtubes_list( $news_id )
	{
		$youtubes = $this->CI->NewsYoutube->get_all_by( array( 'news_id' => $news_id ))->result();

		$data['youtubes'] = $youtubes;

		$this->CI->load->view( $this->template_path .'/components/youtubes_list', $data );
	}

	/**
	 * News Slider
	 */
	function news_slider( $news_id )
	{
		$images = $this->CI->Image->get_all_by( array( 'img_parent_type' => 'news', 'img_parent_id' => $news_id ))->result();

		$data['images'] = $images;
		$this->CI->load->view( $this->template_path .'/components/news_slider', $data );
	}

	/**
	 * Gets the default news.
	 *
	 * @return     <type>  The default news.
	 */
	function get_dummy_news()
	{
		$news = $this->CI->NewsModel->get_empty_object();

		$news->news_id = "dummyid";
		$news->news_title = "Lorem ipsum dolor sit amet, consectetur adipisicing elit";
		$news->news_desc = "Lorem ipsum dolor sit amet, consectetur adipisicing elit";
		$news->user = $this->CI->User->get_one_by( array( 'user_is_sys_admin' => '1' ));
		$news->user_id = $news->user->user_id;

		return $news;
	}

	/**
	 * Gets the default photo.
	 */
	function get_dummy_photo()
	{
		$img = $this->CI->Image->get_empty_object();

		$img->img_path = "default_news.jpeg";

		return $img;
	}
}