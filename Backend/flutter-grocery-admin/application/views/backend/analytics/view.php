<?php
//$this->lang->load('ps', 'english');
$attributes = array('class' => 'form-inline','method' => 'POST');
echo form_open($module_site_url, $attributes);
?>
  	<div class="form-group">
  		<label>
			<?php echo get_msg( 'cat_name' )?>
			<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_name_tooltips')?>">
				<span class='glyphicon glyphicon-info-sign menu-icon mr-3'>
			</a>
		</label>
  		
  		<?php 
  		$options = array();
  		$options[0] = get_msg( 'select_cat' );
  		foreach ( $this->Category->get_all()->result() as $cat) {
			$options[$cat->cat_id] = $cat->cat_name;
		}

		echo form_dropdown(
			'cat_id',
			$options,
			set_value( 'cat_id', show_data( @$news->cat_id ), false ),
			'class="form-control form-control-sm mr-3" id="cat_id"'
		);
  		?>
  		</select>
  	</div>
  	
  	<button type="submit" class="btn btn-primary">Generate Report</button>
<?php echo form_close(); ?>
<?php if($count > 0):?>
	<div id="chart_div" style="height: 500px;width: 800px;"></div>
	<div id="piechart" style="height: 400px;width: 700px;"></div>
<?php endif;?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawGraphChart);
	google.setOnLoadCallback(drawPieChart);
	
	function drawGraphChart() {
		
		var data = google.visualization.arrayToDataTable(<?php echo $graph_items;?>);
		var options = {
			title: 'Total Touch Counts (All Items From ' + '<?php echo $cat_name;?>' + ')',
			vAxis: {title: 'Items',  titleTextStyle: {color: 'red'}, minValue:0, maxValue:1000},
			colors:['#e57373'],
			backgroundColor: { fill:'transparent' }
		};
		
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
	
	function drawPieChart() {
     	
     	var data = google.visualization.arrayToDataTable(<?php echo $pie_items;?>);
     	var options = {
       		title: 'Top 5 Popular Items From ' + '<?php echo $cat_name;?> and ',
       		backgroundColor: { fill:'transparent' }
     	};

     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     	chart.draw(data, options);
   }
   
</script>