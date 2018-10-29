<?php
$jsonTable = json_encode($pieData); 
echo "<script type ='text/javascript'>
google.charts.load('visualization', '1', {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {

var data = google.visualization.arrayToDataTable(".$jsonTable.
");

var options = {
	title:'Wydatki',
	backgroundColor:'transparent',
	pieResidueSliceLabel: 'Pozostałe'
};

var chart = new google.visualization.PieChart(document.getElementById('piechart'));
chart.draw(data, options);
}
</script>";