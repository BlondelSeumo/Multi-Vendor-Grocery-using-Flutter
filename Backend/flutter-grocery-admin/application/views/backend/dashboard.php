 <div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Welcome, <?php echo $this->ps_auth->get_user_info()->user_name;?>!</h1>
            <?php flash_msg(); ?>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content -->

<div class="container-fluid">
  <div class="card-body">
  <!-- Small boxes (Stat box) -->
    <div class="row">
       <div class="col-lg-4">
        <!-- small box -->
        <?php 

        $selected_shop_id = $this->session->userdata('selected_shop_id');
        $shop_id = $selected_shop_id['shop_id'];
        $conds['shop_id'] = $shop_id;

        $submit = $this->Transactionheader->get_transaction_status_count($conds)->result();
        $result = $submit[0]->s_count;
       
        $data = array(
            'label' => get_msg( 'order_count'),
            'total_count' => $result,
            'status_id' => '0',
            'icon' => "fa fa-shopping-bag",
            'color' => "bg-dark"
          );
         $this->load->view( $template_path .'/components/ps_badge_count', $data ); 
        ?>
      </div>

      <div class="col-lg-4">
        <!-- small box -->
        <?php 

          $selected_shop_id = $this->session->userdata('selected_shop_id');
          $shop_id = $selected_shop_id['shop_id'];
          $conds['shop_id'] = $shop_id;
          $conds['trans_status_id'] = 'trans_sts29a4b0cd2fa6ae0449e47e9568320f3a';

          $submit = $this->Transactionheader->get_transaction_status_count($conds)->result();
          $result = $submit[0]->s_count;
          // print_r($pending);die;
          $data = array(
            'label' => get_msg( 'order_submit'),
            'total_count' => $result,
            'status_id' => '1',
            'icon' => "fa fa-shopping-bag",
            'color' => "bg-secondary"
          );
          $this->load->view( $template_path .'/components/ps_badge_count', $data ); 
        ?>
      </div>
      <!-- ./col -->
      <div class="col-lg-4">
        <!-- small box -->
        <?php 

        $selected_shop_id = $this->session->userdata('selected_shop_id');
        $shop_id = $selected_shop_id['shop_id'];
        $conds['shop_id'] = $shop_id;
        $conds['trans_status_id'] = 'trans_sts159cbfb84410ebea91919234532885ec';
       
        $delivered = $this->Transactionheader->get_transaction_status_count($conds)->result();
        $result = $delivered[0]->s_count;
        $data = array(
            'label' => get_msg( 'deliveried'),
            'total_count' => $result,
            'status_id' => '2',
            'icon' => "fa fa-shopping-bag",
            'color' => "bg-primary"
          );
          $this->load->view( $template_path .'/components/ps_badge_count', $data );  
        ?>
      </div>
      <!-- ./col -->
      <div class="col-md-6">
        <div class="card">
          <?php
            $selected_shop_id = $this->session->userdata('selected_shop_id');
            $shop_id = $selected_shop_id['shop_id'];
            $conds1['shop_id'] = $shop_id;

            $data = array(
              'panel_title' => get_msg('purchased_prd_info'),
              'module_name' => 'purchasedproduct' ,
              'total_count' => $this->Purchasedproduct->count_all_by($conds1),
              'data' => $this->Purchasedproduct->get_purchased_count($conds1,5)->result()
            );

            $this->load->view( $template_path .'/components/d2_most_purchased_product_panel', $data ); 
          ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <?php

            $data = array(
              'panel_title' => get_msg('total_revenue'),
              'module_name' => 'purchasedproduct' ,
              'total_count' => $this->Transactioncount->count_all_by($conds1),
             
            );

            $this->load->view( $template_path .'/components/d2_total_revenue_panel', $data ); 
          ?>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <?php
            $selected_shop_id = $this->session->userdata('selected_shop_id');
            $shop_id = $selected_shop_id['shop_id'];
            $conds1['shop_id'] = $shop_id;

            $data = array(
              'panel_title' => get_msg('transaction_table'),
              'module_name' => 'transactionheaders' ,
              'total_count' => $this->Transactionheader->count_all_by($conds1),
              'data' => $this->Transactionheader->get_all_by($conds1,4)->result()
            );

            $this->load->view( $template_path .'/components/d2_transaction_panel', $data ); 
          ?>
        </div>
      </div>

      <div class="col-md-4 col-xlg-3">
        <div class="card earning-widget">
          <?php 

            $data = array(
              'panel_title' => get_msg('performance_label'),
             
            );

            $this->load->view( $template_path .'/components/d2_performance_panel', $data ); 
          ?>
        </div>
      </div>

      <div class="col-md-4 col-xlg-3">
        <div class="card earning-widget">
          <?php 
            $selected_shop_id = $this->session->userdata('selected_shop_id');
            $shop_id = $selected_shop_id['shop_id'];
            $conds1['shop_id'] = $shop_id;

            $data = array(
              'panel_title' => get_msg('comment_label'),
              'total_count' => $this->Commentheader->count_all_by($conds1),
              'data' => $this->Commentheader->get_all_by($conds1,3)->result()
            );

            $this->load->view( $template_path .'/components/d2_comment_panel', $data ); 
          ?>
        </div>
      </div>

      <div class="col-md-4 col-xlg-3">
        <div class="card card-widget widget-user-2">
          <?php 
            $selected_shop_id = $this->session->userdata('selected_shop_id');
            $shop_id = $selected_shop_id['shop_id'];
            $conds1['shop_id'] = $shop_id;

            $data = array(
              'panel_title' => get_msg('rec_prd_info'),
              'total_count' => $this->Product->count_all_by($conds1),
              'data' => $this->Product->get_rec_product($conds1,4)->result()
            );

            $this->load->view( $template_path .'/components/d2_rec_product_panel', $data ); 
          ?>
        </div>
      </div>

     

    </div>
  <!-- /.row -->
  </div>
</div>
<!-- contain fluid -->






 


