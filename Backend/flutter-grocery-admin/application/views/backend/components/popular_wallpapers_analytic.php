<?php
// get all wallpapers
$wallpapers = $this->Wallpaper->get_all_by( array( 'popular' => 1 ), 5 )->result();

// get wallpaper total touches
$wallpapers_arr = array();
foreach ( $wallpapers as $wallpaper ) {
	$wallpapers_arr[ $wallpaper->wallpaper_name ] = $this->Touch->count_all_by( array( 'wallpaper_id' => $wallpaper->wallpaper_id ));
}

// get graph side bar title
$graph_arr = array();
foreach ( $wallpapers_arr as $name => $count ) {
	$graph_arr[] = "['".$name."',".$count."]";
}

// sort the wallpaper array
arsort($wallpapers_arr);
$pie_arr = array();
$i = 0;
foreach ( $wallpapers_arr as $name => $count ) {
	if(($i++) < 5){
		$pie_arr[] = "['".$name."',".$count."]";
	}
}

$count = count( $wallpapers );
$graph_items = "[['Wallpapers','Touches'],".implode(',',$graph_arr)."]";
$pie_items = "[['Wallpapers','Touches'],".implode(',',$pie_arr)."]";
?>

<div class="row my-4">
	<div class="col-6">

		<div id="chart_div" style="height: 300px;width: 100%;"></div>
	
	</div>
	<div class="col-6">

		<div id="piechart" style="height: 300px;width: 100%;"></div>

	</div>
</div>

<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawGraphChart);
	google.setOnLoadCallback(drawPieChart);
	
	function drawGraphChart() {
		
		var data = google.visualization.arrayToDataTable(<?php echo $graph_items;?>);
		var options = {
			title: 'Total Touch Counts (Top 5 popular Wallpapers ) ',
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
       		title: 'Top 5 Popular Wallpapers ',
       		backgroundColor: { fill:'transparent' }
     	};

     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     	chart.draw(data, options);
   }
   
</script>
