<div class="invoice p-3 mb-3">
  	<!-- title row -->
  	<div class="row">
    	<div class="col-12">
      		<h4>
        	<?php echo get_msg('trans_detail'); ?>
        	<small class="float-right">Date: <?php echo $transaction->added_date; ?></small>
      		</h4>
    	</div>
    <!-- /.col -->
  	</div>
  <!-- info row -->
	<div class="row invoice-info">

		<div class="col-sm-4 invoice-col">
			<b><u>Customer Information</u></b> <br><br>
			 	<address>
			    	Name: <?php echo $transaction->contact_name; ?><br>
				    Email: <?php echo $transaction->contact_email; ?><br>
				    Phone: <?php echo $transaction->contact_phone;?><br>
				    Address: <?php echo $transaction->contact_address;?>
			 	</address>
		</div>
		<!-- /.col -->
		<div class="col-sm-4 invoice-col">
		  	<b><u>Customer Location</u></b> <br><br>
		  		<div id="transaction_map" style="width: 200px; height: 150px;"></div>

				<div class="clearfix">&nbsp;</div>
		</div>
	
		<div class="col-sm-4 invoice-col">
		  <b>Invoice <?php echo $transaction->trans_code?></b><br>
		  <br>
		  	
				<?php
					$attributes = array('class' => 'form-inline');
						echo form_open('/admin/transactions/update', $attributes);
				
				?>
					<div class="table-responsive">
            			<table class="table">
            				<tr>
            					<th>Transaction Status:</th>
            					<td><select  name="trans_status_id" id="trans_status_id">
						
										<option value="0"><?php echo get_msg('select_status'); ?></option>
										<?php
											$status = $this->Transactionstatus->get_all();
											foreach ($status->result() as $status) 
											{
												echo "<option value='".$status->id."'";
													if($transaction->trans_status_id == $status->id) 
													{
														echo " selected ";
													}
														echo ">".$status->title."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
            					<th>Payment Status:</th>
            					<td><select  name="payment_status_id" id="payment_status_id">
										<option value="0"><?php echo get_msg('select_pay_status'); ?></option>
										<?php
											$status = $this->Paymentstatus->get_all();
											foreach ($status->result() as $status) 
											{
												echo "<option value='".$status->id."'";
													if($transaction->payment_status_id == $status->id) 
													{
														echo " selected ";
													}
														echo ">".$status->title."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<?php if($transaction->pick_at_shop != 1) { ?>
							<tr>
            					<th>Delivery Boy:</th>
            					<td><select  name="delivery_boy_id" id="delivery_boy_id">
										<option value="0"><?php echo get_msg('select_deli_boy'); ?></option>
										<?php
											$conds['role_id'] = 5;
											$conds['no_publish_filter']= 1;
											$deli_boys = $this->User->get_all_by($conds);
											foreach ($deli_boys->result() as $boy) 
											{
												echo "<option value='".$boy->user_id."'";
													if($transaction->delivery_boy_id == $boy->user_id) 
													{
														echo " selected ";
													}
														echo ">".$boy->user_name."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<?php } ?>
						</table>
					</div>	

				<input type="hidden" name="trans_header_id" value=<?php  echo $transaction->id;  ?>>
					<button type="submit" class="btn btn-sm btn-primary <?php echo $langauge_class; ?>" style="padding : 2px 5px; margin: 5px;"><?php echo get_msg('btn_update')?></button>
				<?php echo form_close(); ?>	
		
		  		<b>Account:</b> <?php echo $transaction->sub_total_amount ." ". $transaction->currency_short_form; ?>		
		</div>	
	</div>

	<div class="row">
		<div class="col-12 table-responsive">
		  <table class="table table-striped">
		    <thead>
			    <tr>
			      	<th><?php echo get_msg('Prd_name'); ?></th>
					<th><?php echo get_msg('Prd_price'); ?></th>
					<!-- <th><?php echo get_msg('Prd_dis_price'); ?></th> -->
					<th><?php echo get_msg('Prd_qty'); ?></th>
					<th><?php echo get_msg('Prd_dis'); ?></th>
					<th><?php echo get_msg('Prd_amt'); ?></th>
			    </tr>
		    </thead>
		    <tbody>
		    	<?php 
					$conds['transactions_header_id'] = $transaction->id;
					$all_detail =  $this->Transactiondetail->get_all_by( $conds );
					
					foreach($all_detail->result() as $transaction_detail):

				?>
				<tr>
					<td>
						<?php 

						
						$att_name_info  = explode("#", $transaction_detail->product_customized_name);
						$att_price_info = explode("#", $transaction_detail->product_customized_price);

						$addon_name_info  = explode("#", $transaction_detail->product_addon_name);
						$addon_price_info = explode("#", $transaction_detail->product_addon_price);


						$att_info_str = "";
						$att_flag = 0;
						if( count($att_name_info[0]) > 0 ) {

							//loop attribute info
							for($k = 0; $k < count($att_name_info); $k++) {
								
								if($att_name_info[$k] != "") {
									$att_flag = 1;
									$att_info_str .= $att_name_info[$k] . " : " . $att_price_info[$k] . "(". $transaction->currency_symbol ."),";

								}
							}


						} else {
							$att_info_str = "";
						}

						

						$att_info_str = rtrim($att_info_str, ","); 


						///addon

						$addon_info_str = "";
						$addon_flag = 0;
						if( count($addon_name_info[0]) > 0 ) {

							//loop attribute info
							for($k = 0; $k < count($addon_name_info); $k++) {
								
								if($addon_name_info[$k] != "") {
									$addon_flag = 1;
									$addon_info_str .= $addon_name_info[$k] . " : " . $addon_price_info[$k] . "(". $transaction->currency_symbol ."),";

								}
							}


						} else {
							$addon_info_str = "";
						}

						

						$addon_info_str = rtrim($addon_info_str, ","); 

						///end addon


						if( $att_flag == 1 || $addon_flag == 1 ) {

							echo $this->Product->get_one($transaction_detail->product_id)->name .'<br> ' . $att_info_str  .'<br>' . $addon_info_str  .'<br>'; 

						} else {

							echo $this->Product->get_one($transaction_detail->product_id)->name .'<br>';

						}

						if ($transaction_detail->product_color_id != "") {

							echo "Color:";

							$color_value =  $this->Color->get_one($transaction_detail->product_color_id)->color_value . '}';
							

							} 

						?>

						<div style="background-color:<?php echo  $this->Color->get_one($transaction_detail->product_color_id)->color_value ; ?>; width: 20px; height: 20px; margin-top: -20px; margin-left: 50px;"> 
						</div>
						<?php echo "Product Unit : " . $transaction_detail->product_unit_value . " " . $transaction_detail->product_unit; ?> <br>


					</td>
					<td><?php echo $transaction_detail->original_price ." ". $transaction->currency_symbol; ?></td>
					<!-- <td><?php echo $transaction_detail->price ." ". $transaction->currency_symbol; ?></td> -->
					<td><?php echo $transaction_detail->qty ?></td>
					<td><?php echo "-" . $transaction_detail->discount_amount . $transaction->currency_symbol . " (" .$transaction_detail->discount_percent . "% off)"; ?></td>

					<td>
						<?php 

							echo $transaction_detail->qty * $transaction_detail->original_price  ." ". $transaction->currency_symbol; 
						?>
					</td>
				</tr>

					<?php endforeach; ?>
		    </tbody>
		  </table>
		</div>
	<!-- /.col -->
	</div>

	<div class="row">
        <!-- accepted payments column -->
       
        <div class="col-6">
        	 <br>
          <p><?php echo get_msg('trans_payment_method'); ?>

          <?php 

          echo $transaction->payment_method; 

          if($transaction->razor_id != "") {
          	echo "( ID : " . $transaction->razor_id . " )";
          }

          ?>
          	

          </p>

          <p> <?php echo get_msg('trans_memo'); ?> <?php echo $transaction->memo; ?></p>

          <?php if($transaction->pick_at_shop == 1) { ?>
          <p><?php echo get_msg('cus_pick_up_order'); ?></p>
      	  <?php } ?>

         <p> <?php echo get_msg('trans_delivery_pickup_date'); ?> <?php echo $transaction->delivery_pickup_date; ?></p>

         <p> <?php echo get_msg('trans_delivery_pickup_time'); ?> <?php echo $transaction->delivery_pickup_time; ?></p>
        </div>

        <!-- /.col -->
        <div class="col-6">
         

          <div class="table-responsive">
            <table class="table">

              <tr>
                <th><?php echo get_msg('trans_coupon_discount_amount'); ?></th>
                <td><?php echo $transaction->coupon_discount_amount . " ". $transaction->currency_symbol;; ?></td>
              </tr>	

              <tr>
                <th style="width:50%"><?php echo get_msg('trans_item_sub_total'); ?></th>
                <td><?php echo $transaction->sub_total_amount . " ". $transaction->currency_symbol; ?></td>
              </tr>

              <tr>
                <th><?php echo get_msg('trans_overall_tax'); ?> <?php echo "(" . $transaction->tax_percent * 100 . "%)"  ?> : (+)</th>
                <td><?php echo $transaction->tax_amount . " ". $transaction->currency_symbol;; ?></td>
              </tr>
              <tr>
                <th><?php echo get_msg('trans_shipping_cost'); ?><?php echo $transaction->shipping_method_name ?>): (+)</th>
                <td><?php echo $transaction->shipping_amount . " ". $transaction->currency_symbol;; ?></td>
              </tr>
              <tr>
                <th><?php echo get_msg('trans_shipping_tax'); ?> <?php echo "(" . $transaction->shipping_tax_percent * 100 . ")"  ?>% : (+)</th>
                <td><?php echo $transaction->shipping_amount * $transaction->shipping_tax_percent . " ". $transaction->currency_symbol;; ?></td>
              </tr>
            
              
              <tr>
                <th><?php echo get_msg('trans_total_balance_amount'); ?></th>
                <td>
                	
                	<?php 

                	//balance_amount = total_item_amount - coupon_discont + (overall_tax + shipping_cost + shipping_tax (based on shipping cost)) 

                	echo  ($transaction->sub_total_amount + ($transaction->tax_amount + $transaction->shipping_amount + ($transaction->shipping_amount * $transaction->shipping_tax_percent)) );  
                	echo " ". $transaction->currency_symbol;
                	?>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
    </div>
</div>