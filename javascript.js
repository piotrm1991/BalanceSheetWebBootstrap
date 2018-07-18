window.addEventListener("load", function() { dateToday(); });

function dateToday()
	{
	var today = new Date();
		
	var day = today.getDate();
	var monthToday = today.getMonth()+1;
	var year = today.getFullYear();
		
	var month;
		
	if (monthToday==1) month = "Styczeń";
	else if (monthToday==2) month = "Luty";
	else if (monthToday==3) month = "Marzec";
	else if (monthToday==4) month = "Kwiecień";
	else if (monthToday==5) month = "Maj";
	else if (monthToday==6) month = "Czerwiec";
	else if (monthToday==7) month = "Lipiec";
	else if (monthToday==8) month = "Śierpień";
	else if (monthToday==9) month = "Wrzesień";
	else if (monthToday==10) month = "Październik";
	else if (monthToday==11) month = "Listopad";
	else if (monthToday==12) month = "Grudzień";
	
	document.getElementById("dateToday").innerHTML = day+" "+month+" "+year;
}

function chart()
{
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() 
	{
	  var data = google.visualization.arrayToDataTable([
	  ['Category', 'Cost'],
	  ['Jedzenie', 1500.00],
	  ['Mieszkanie', 500.00],
	  ['Transport', 300.00],
	  ['Telekomunikacja', 200.00],
	  ['Opieka zdrowotna', 200.00],
	  ['Ubranie', 200.00],
	  ['Higiena', 200.00],
	  ['Dzieci', 200.00],
	  ['Rozrywka', 200.00],
	  ['Wycieczka', 500.00],
	  ['Szkolenia', 300.00],
	  ['Książki', 200.00],
	  ['Oszczędności', 200.00],
	  ['Emerytura', 200.00],
	  ['Spłata długów', 200.00],
	  ['Darowizna', 200.00],
	  ['Inne wydatki', 200.00]

	]);

	  var options = {'title':'Wydatki', 'backgroundColor':'transparent'};

	  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	  chart.draw(data, options);
	}
}

$(window).on("throttledresize", function (event) {
    var options = {
        width: '100%',
        height: '100%'
    };

    var data = google.visualization.arrayToDataTable([]);
    drawChart(data, options);
});
