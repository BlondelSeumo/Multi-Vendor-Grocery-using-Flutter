<!-- DONUT CHART -->
<div class="card-header" style="border-top: 2px solid red;">
  <h3 class="card-title">
     <span class="badge badge-warning" style="height: 30px; padding: 10px; font-size: 14px;">
         <?php echo $panel_title; ?>
     </span>
  </h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
    </button>
    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
    </button>
  </div>
</div>

<div class="box-body chart-responsive">
  <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
</div>
    <!-- /.box-body -->
    <?php 
        $color = array("1"=>"#3c8dbc","2"=>"#f56954","3"=>"#00a65a","4"=>"#17a2b8","5"=>"#007bff");
       
        $i = 0;
        foreach ($data as $d):
            $i++;
            $data_str .= "{
                  value    : '".$d->t_count."',
                  color    : '" .$color[$i]."',
                  highlight: '".$color[$i]."',
                  label    : '".$d->name."'
               },
                ";
    ?>
       <?php endforeach; ?>
<script>
  $(function () {
  "use strict";
       //DONUT CHART
    var donut = new Morris.Donut({
      element: 'sales-chart',
      resize: true,
      data: [
         <?php echo htmlspecialchars_decode($data_str); ?>
      ],
      hideHover: 'auto'
    });
   
  });
</script>