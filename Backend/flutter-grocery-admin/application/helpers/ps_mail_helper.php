<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Send Booking Request Email to hotel
 * @param  [type] $booking_id [description]
 * @return [type]             [description]
 */
if ( !function_exists( 'send_transaction_order_emails' )) {

	function send_transaction_order_emails( $trans_header_id, $to_who = "", $subject = "" )
	{
		// get ci instance
		$CI =& get_instance();
		
		$sender_name = $CI->Backend_config->get_one('be1')->sender_name;

		$trans_header_obj = $CI->Transactionheader->get_one($trans_header_id);
		$shop_name = $CI->Shop->get_one($trans_header_obj->shop_id)->name;

		$shop_email = $CI->Shop->get_one($trans_header_obj->shop_id)->email;

		$trans_currency = $CI->Shop->get_one($trans_header_obj->shop_id)->currency_symbol;

		$user_email =  $CI->User->get_one($trans_header_obj->added_user_id)->user_email;

		if ($user_email == "") {
			$user_email = $trans_header_obj->billing_email;
		}

		$user_name =  $CI->User->get_one($trans_header_obj->added_user_id)->user_name;

		//bank info 
		$bank_account = $CI->Shop->get_one($trans_header_obj->shop_id)->bank_account;
		$bank_name = $CI->Shop->get_one($trans_header_obj->shop_id)->bank_name;
		$bank_code = $CI->Shop->get_one($trans_header_obj->shop_id)->bank_code;
		$branch_code = $CI->Shop->get_one($trans_header_obj->shop_id)->branch_code;
		$swift_code = $CI->Shop->get_one($trans_header_obj->shop_id)->swift_code;

		$bank_info  = get_msg('bank_acc_label') . $bank_account . " <br> " .
					get_msg('bank_name_label') . $bank_name . " <br> " .
					get_msg('bank_code_label') . $bank_code . " <br> " .
					get_msg('branch_code_label') . $branch_code . " <br> " .
		            get_msg('swift_code_label') . $swift_code . " <br><br> " ;

		//For Payment Method 
		$payment_info = "";
		if($trans_header_obj->payment_method == "COD") {
			$payment_info = get_msg('pay_met_cod');
		} else if($trans_header_obj->payment_method == "PAYPAL") {
			$payment_info = get_msg('pay_met_paypal');
		} else if($trans_header_obj->payment_method == "STRIPE") {
			$payment_info = get_msg('pay_met_stripe');
		} else if($trans_header_obj->payment_method == "BANK") {
			$payment_info = get_msg('pay_met_bank') . $bank_info;
		}

		$conds['transactions_header_id'] = $trans_header_obj->id;

		$trans_details_obj = $CI->Transactiondetail->get_all_by($conds)->result();

		//For Transaction Detials
		for($i=0;$i<count($trans_details_obj);$i++) 
		{
				if($trans_details_obj[$i]->product_attribute_id != "") {
					

					$att_name_info  = explode("#", $trans_details_obj[$i]->product_attribute_name);
					
					$att_price_info = explode("#", $trans_details_obj[$i]->product_attribute_price);

					$att_info_str = "";
					$att_flag = 0;
					if( count($att_name_info[0]) > 0 ) {

						//loop attribute info
						for($k = 0; $k < count($att_name_info); $k++) {
							
							if($att_name_info[$k] != "") {
								$att_flag = 1;
								$att_info_str .= $att_name_info[$k] . " : " . $att_price_info[$k] . "(". $trans_currency ."),";

							}
						}


					} else {
						$att_info_str = "";
					}

					$att_info_str = rtrim($att_info_str, ","); 

					


					$order_items .= $i + 1 .". " . $trans_details_obj[$i]->product_name . 
					" (". get_msg('price_label') .   $trans_details_obj[$i]->original_price  . html_entity_decode($trans_currency) . 
					"," . get_msg('qty_label') ." : " . $trans_details_obj[$i]->qty . ",". get_msg('unit_label') ." : " . $trans_details_obj[$i]->product_unit_value .' ' . $trans_details_obj[$i]->product_unit . ") {". $att_info_str ."}<br>";





				} else {
					
					$order_items .= $i + 1 .". " . $trans_details_obj[$i]->product_name . 
					" (". get_msg('price_label') .   $trans_details_obj[$i]->original_price  . html_entity_decode($trans_currency) . 
					"," . get_msg('qty_label') ." : " . $trans_details_obj[$i]->qty . ",". get_msg('unit_label') ." : " . $trans_details_obj[$i]->product_unit_value .' ' . $trans_details_obj[$i]->product_unit . ") <br>";
					
				}
				
				$sub_total_amt += $trans_details_obj[$i]->original_price * $trans_details_obj[$i]->qty;
				
				
		}


		
		$trans_status = $CI->Transactionstatus->get_one($trans_header_obj->trans_status_id)->title;



		$total_amt = $total_amount .' ' . html_entity_decode($trans_currency);

		$coupon_discount_amount = $trans_header_obj->coupon_discount_amount;
		$tax_amount = $trans_header_obj->tax_amount;
		$shipping_method_amount = $trans_header_obj->shipping_method_amount;
		$shipping_tax_amount = $trans_header_obj->shipping_method_amount * $trans_header_obj->shipping_tax_percent;

		$total_balance_amount = ($trans_header_obj->sub_total_amount + ($trans_header_obj->tax_amount + $trans_header_obj->shipping_method_amount + ($trans_header_obj->shipping_method_amount * $trans_header_obj->shipping_tax_percent)));   

		//for msg label
		$hi = get_msg('hi_label');
    	$order_receive_info = get_msg('order_receive_info');
    	$trans_code = get_msg('trans_code');
    	$trans_status_label = get_msg('trans_status_label');
    	$memo_label = get_msg('memo_label');
    	$prd_detail_info = get_msg('prd_detail_info');
    	$sub_total = get_msg('sub_total');
    	$coupon_dis_amount = get_msg('coupon_dis_amount');
    	$overall_tax = get_msg('overall_tax');
    	$shipping_tax = get_msg('shipping_tax');
    	$total_bal_amt = get_msg('total_bal_amt');
    	$best_regards = get_msg( 'best_regards_label' );
		//Shop or User
		if($to_who == "shop") {
		
			$to = $shop_email;

			$msg = <<<EOL
<p>{$hi} {$shop_name},</p>

<p>{$order_receive_info}</p>

<p>
{$trans_code} : {$trans_header_obj->trans_code}<br/>
</p>

<p>
{$trans_status_label} : {$trans_status}<br/>
</p>

<p>
{$payment_info}<br/>
</p>

<p>
{$memo_label}: {$trans_header_obj->memo}
</p>


<p>{$prd_detail_info} :</p>
{$order_items}            


<p>
{$sub_total} : {$sub_total_amt} {$trans_currency}
</p>
<p>
{$coupon_dis_amount} : {$coupon_discount_amount} {$trans_currency}
</p>
<p>
{$overall_tax} : {$tax_amount} {$trans_currency}
</p>
<p>
{$shipping_tax} : {$shipping_tax_amount} {$trans_currency}
</p>
<p>
{$total_bal_amt} : {$total_balance_amount} {$trans_currency}
</p>


<p>
{$best_regards},<br/>
{$sender_name}
</p>
EOL;

		} else if ($to_who == "user") {

			$to = $user_email;

			$msg = <<<EOL
<p>{$hi} {$user_name},</p>

<p>{$order_receive_info}</p>

<p>
{$trans_code} : {$trans_header_obj->trans_code}<br/>
</p>

<p>
{$trans_status_label} : {$trans_status}<br/>
</p>

<p>
{$payment_info}<br/>
</p>


<p>
{$memo_label}: {$trans_header_obj->memo}
</p>

<p>{$prd_detail_info} :</p>
{$order_items}            


<p>
{$sub_total} : {$sub_total_amt} {$trans_currency}
</p>
<p>
{$coupon_dis_amount} : {$coupon_discount_amount} {$trans_currency}
</p>
<p>
{$overall_tax} : {$tax_amount} {$trans_currency}
</p>
<p>
{$shipping_tax} : {$shipping_tax_amount} {$trans_currency}
</p>
<p>
{$total_bal_amt} : {$total_balance_amount} {$trans_currency}
</p>


<p>
{$best_regards},<br/>
{$sender_name}
</p>
EOL;

		}

		// print_r($to); echo "<br><br>";
		// print_r($subject);   echo "<br><br>";
		// print_r($msg); echo "<br><br>";
		// echo "---------";

		// send email from admin
		return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
	}
}

if ( !function_exists( 'send_shop_registeration_emails' )) {

	function send_shop_registeration_emails( $shop_id, $to_who = "", $subject = "" )
	{
		// get ci instance
		$CI =& get_instance();


		$super_admin_email = $CI->config->item( 'super_admin_email' );
		$super_admin_name = $CI->config->item( 'super_admin_name' );
		$sender_name = $CI->Backend_config->get_one('be1')->sender_name;


		//for user shop
		$conds_shop['shop_id'] = $shop_id;

		//for shop
		$conds_shop_info['id'] = $shop_id;
		$conds_shop_info['no_publish_filter'] = 2;

		//to get shop information

		$shop_data = $CI->Shop->get_one_by($conds_shop_info);
		$shop_name = $shop_data->name;
		$shop_phone = $shop_data->about_phone1;
		$shop_address = $shop_data->address1;


		// get user email
		$user_shop =  $CI->User_shop->get_one_by($conds_shop);
		$conds_user['user_id'] = $user_shop->user_id;
		$user_email = $CI->User->get_one_by($conds_user)->user_email;
		$user_name = $CI->User->get_one_by($conds_user)->user_name;

		$hi = get_msg('hi_label');
		$shop_reg_label = get_msg('shop_reg_label');
		$shop_name = get_msg('shop_name');
		$shop_phone_label = get_msg('shop_phone_label');
		$shop_add_label = get_msg('shop_add_label');
		$like_user_name = get_msg('like_user_name');
		$user_email_label = get_msg('user_email_label');
		$best_regards = get_msg( 'best_regards_label' );
		$shop_reg_done = get_msg( 'shop_reg_done' );
		//Super Admin or User
		if($to_who == "super_admin") {
		
			$to = $super_admin_email;

			$msg = <<<EOL

		<p>{$hi} {$super_admin_name},</p>

<p>{$shop_reg_label} :</p>

<p>

{$shop_name} : {$shop_name}<br/>
</p>

<p>
{$shop_phone_label} : {$shop_phone}<br/>
</p>

<p>
{$shop_add_label} : {$shop_address}<br/>
</p>

<p>
{$like_user_name} : {$user_name}<br/>
</p>

<p>
{$user_email_label} : {$user_email}<br/>
</p>

<p>
{$best_regards},<br/>
{$sender_name}

EOL;

		} else if ($to_who == "user") {

			$to = $user_email;

			$msg = <<<EOL

		<p>Hi {$user_name},</p>

<p>{$shop_reg_done} :</p>

<p>

{$shop_name} : {$shop_name}<br/>
</p>

<p>
{$shop_phone_label} : {$shop_phone}<br/>
</p>

<p>
{$shop_add_label} : {$shop_address}<br/>
</p>

<p>
{$like_user_name} : {$user_name}<br/>
</p>

<p>
{$user_email_label} : {$user_email}<br/>
</p>

<p>
{$best_regards},<br/>
{$sender_name}

EOL;

		}


		


		
		
		// print_r($to); echo "<br><br>";
		// print_r($subject);   echo "<br><br>";
		// print_r($msg); echo "<br><br>";
		// echo "---------";

		// send email from admin
		return $CI->ps_mail->shop_registeration_send_from_admin( $to, $subject, $msg );
	}
}


if ( !function_exists( 'send_shop_approval_emails' )) {

	function send_shop_approval_emails( $shop_id, $to_who = "", $subject = "", $status )
	{
		// get ci instance
		$CI =& get_instance();

		$conds_shop['shop_id'] = $shop_id;
		$user_shop =  $CI->User_shop->get_one_by($conds_shop);
		$conds_user['user_id'] = $user_shop->user_id;
		//print_r($conds_user);die;
		$user_email = $CI->User->get_one_by($conds_user)->user_email;
		$user_name = $CI->User->get_one_by($conds_user)->user_name;

		$sender_name = $CI->Backend_config->get_one('be1')->sender_name;

		$to = $user_email;
		$shop_approve_label = get_msg('shop_approve_label');
		$best_regards = get_msg( 'best_regards_label' );
		$shop_reject_label = get_msg('shop_reject_label');
		$hi = get_msg('hi_label');
		if ( $status == 1 ) {

			$msg = <<<EOL

		<p>{$hi} {$user_name},</p>

<p>{$shop_approve_label}</p>

<p>
{$best_regards},<br/>
{$sender_name}

EOL;

		} else {

			$msg = <<<EOL

		<p>{$hi} {$user_name},</p>

<p>{$shop_reject_label} 
</p>

<p>
{$best_regards},<br/>
{$sender_name}

EOL;
		}


		
		
		// print_r($to); echo "<br><br>";
		// print_r($subject);   echo "<br><br>";
		// print_r($msg); echo "<br><br>";
		// echo "---------";

		// send email from admin
		return $CI->ps_mail->shop_approval_send_from_admin( $to, $subject, $msg );
	}
}

if ( !function_exists( 'send_user_register_email' )) {

  function send_user_register_email( $user_id, $subject = "" )
  {
     // get ci instance
    $CI =& get_instance();
    
    $user_info_obj = $CI->User->get_one($user_id);

    $user_name  = $user_info_obj->user_name;
    $user_email = $user_info_obj->user_email;
    $code = $user_info_obj->code;
    

    $to = $user_email;

	$sender_name = $CI->Backend_config->get_one('be1')->sender_name;
    $hi = get_msg('hi_label');
    $new_user_acc = get_msg('new_user_acc');
    $verify_code = get_msg('verify_code_label');
    $best_regards = get_msg( 'best_regards_label' );

    $msg = <<<EOL
<p>{$hi} {$user_name},</p>

<p>{$new_user_acc}</p>

<p>
{$verify_code} : {$code}<br/>
</p>


<p>
{$best_regards},<br/>
{$sender_name}
</p>
EOL;
    
    // send email from admin
    return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
  }
}

if ( !function_exists( 'send_contact_us_emails' )) {

  function send_contact_us_emails( $contact_id, $subject = "" )
  {
    // get ci instance  
    $CI =& get_instance();
    
    $contact_info_obj = $CI->Contact->get_one($contact_id);

    $contact_name  = $contact_info_obj->name;
    $contact_email = $contact_info_obj->email;
    $contact_phone = $contact_info_obj->phone;
    $contact_msg   = $contact_info_obj->message;
    

    $to = $CI->Backend_config->get_one('be1')->receive_email;
    $sender_name = $CI->Backend_config->get_one('be1')->sender_name;
    $hi_admin  = get_msg('hi_admin_label');
    $name = get_msg('name_label');
    $email = get_msg('email_label');
    $phone = get_msg('phone_label');
    $message = get_msg('msg_label');
    $best_regards = get_msg( 'best_regards_label' );

    $msg = <<<EOL
<p>{$hi_admin},</p>

<p>
{$name} : {$contact_name}<br/>
{$email} : {$contact_email}<br/>
{$phone} : {$contact_phone}<br/>
{$message} : {$contact_msg}<br/>
</p>


<p>
{$best_regards},<br/>
{$sender_name}
</p>
EOL;
    
    
    

    // send email from admin
    return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
  }
}



if ( !function_exists( 'send_user_register_email_without_verify' )) {

  function send_user_register_email_without_verify( $user_id, $subject = "" )
  {
     // get ci instance
    $CI =& get_instance();
    
    $user_info_obj = $CI->User->get_one($user_id);

    $user_name  = $user_info_obj->user_name;
    $user_email = $user_info_obj->user_email;
    
    

    $to = $user_email;

	$sender_name = $CI->Backend_config->get_one('be1')->sender_name;
    $hi = get_msg('hi_label');
    $user_auto_approved = get_msg('user_auto_approved');
    
    $best_regards = get_msg( 'best_regards_label' );

    $msg = <<<EOL
<p>{$hi} {$user_name},</p>

<p>{$user_auto_approved}</p>

<p>
{$best_regards},<br/>
{$sender_name}
</p>
EOL;
    
    // send email from admin
    return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
  }
}

