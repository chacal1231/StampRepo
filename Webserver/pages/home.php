 <style type="text/css">
        .map-responsive{
    overflow:hidden;
    padding-bottom:56.25%;
    position:relative;
    height:0;
}
    </style>

   <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDzaa4MZ7r4s26i54PwErpKTynKAaWVxTc&v=3&language=en"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
    <script type="text/javascript">
var marker;
var map = null;
var markersArray = [];

    //--------------------- Sample code written by vIr ------------
    var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png",
               new google.maps.Size(32, 32), new google.maps.Point(0, 0),
               new google.maps.Point(16, 32));
                    var center = null;
                    var currentPopup;
                    var bounds = new google.maps.LatLngBounds();
                    var infoWindow = new google.maps.InfoWindow;
                    function addMarker(lat, lng, info, i) {
                        var pt = new google.maps.LatLng(lat, lng);
                        bounds.extend(pt);
                            marker = new google.maps.Marker({
                            position: pt,
                            draggable: true,
                            raiseOnDrag: true,
                            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+i+'|FE6256|000000',
                            map: map
                        });
                         markersArray.push(marker);
                        var popup = new google.maps.InfoWindow({
                            content: info,
                            maxWidth: 300
                        });
                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                infoWindow.setContent(info);
                                infoWindow.setOptions({maxWidth: 200});
                                infoWindow.open(map, marker);
                            }
                        }) (marker, i));
                        /*google.maps.event.addListener(popup, "closeclick", function() {
                            map.panTo(pt);
                            currentPopup = null;
                        });*/

                        
                        map.setCenter(pt);
                        map.setZoom(15);

                    }

                             
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {

                            center: new google.maps.LatLng(0, 0),
                            zoom: 18,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: true,
                            mapTypeControlOptions: {
                                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
                            },
                            navigationControl: true,
                            navigationControlOptions: {
                                style: google.maps.NavigationControlStyle.ZOOM_PAN
                            }
                        });
   

  setInterval(function mapload(){
    
                $.ajax({
                            type: "POST", 
                            url: 'data2.php',
                           // data: form_data,
                            success: function(data)
                            {
                                
                           // var json_obj = $.parseJSON(data);//parse JSON
                                var json_obj = jQuery.parseJSON(JSON.stringify(data));
                                for (var i in json_obj) 
                                {   addMarker(json_obj[i].lat, json_obj[i].lon,"Fecha: " + json_obj[i].fecha + "<br>" + "Velocidad: " +  json_obj[i].sp + " Km/h", i);
                                
                                }
                            },
                            dataType: "json"//set to JSON    
                        })    
    
   
  },1000);

   center = bounds.getCenter();
   map.fitBounds(bounds);

   }
  

    setInterval(function removeMarker() {
    if (markersArray) {
        for (i=0; i < markersArray.length; i++) {
            markersArray[i].setMap(null);
             marker=null;
        }
    markersArray.length = 0;
    }
},1000);
   </script>

<script src="backend/js/jquery.min.js" type="text/javascript"></script>
     <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
               <div id="status"></div>
            </header>
            <section class="panel">
                        <div class="panel-body"> 
                            <head>
	                    	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		                      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js"></script>
		                      <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		                      <script type="text/javascript" language="javascript" src="js/dataTables.scroller.js"></script>
			    <script type="text/javascript" language="javascript" >
                            $(document).ready(function() {
                                var dataTable = $('#employee-grid').DataTable( {
                                    "processing": true,
                                    "serverSide": true,
                                    "searching": false,
                                    "columnDefs": [
                                    { className: "dt-body-center", "targets": [ 0 ] }
                                    ],
                                    "ajax":{
                                    url :"data.php", // json datasource
                                    type: "post",  // method  , by default get
                                    error: function(){  // error handling
                                        $(".employee-grid-error").html("");
                                        $("#employee-grid_processing").css("display","none");
                                    }
                                }
                            } );
                                setInterval( function () {
                                    dataTable.ajax.reload();
                                }, 10000 );
                            } );
                        </script>
                        <style>
                        div.container {
                            margin: 0 auto;
                            max-width:980px;
                        }
                        div.header {
                            margin: 100px auto;
                            line-height:30px;
                            max-width:980px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="table-responsive"> 
                            <table id="employee-grid" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                                <th>Velocidad (Km/h)</th>

                            </tr>
                        </thead>
                        </div>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>

<div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
               Mapa
            </header>
            <div class="panel-body">
		<div id="map" class="map-responsive"></div>
        <script type="text/javascript">initMap();</script>
            </div>
        </section>
</div>

    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
               Velocidad del vehiculo
            </header>
            <div class="panel-body"> 
                <div class="table-responsive">
                    <table class="display table table-bordered table-striped">
                    <!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
                var dataLength = 0;
                var data = [];
                var updateInterval = 500;
                updateChart();
                function updateChart() {
                    $.getJSON("pages/jsonchar.php", function (result) {
                        if (dataLength !== result.length) {
                            for (var i = dataLength; i < result.length; i++) {
                                data.push({
                                    label: (result[i].valorx),
                                    y: parseFloat(result[i].valory)
                                });
                            }
                            dataLength = result.length;
                            chart.render();

                        }
                    });
                }
                var chart = new CanvasJS.Chart("chart", {
                    zoomEnabled: true,
                    title: {
                        text: "Velocidad Km/h"
                    },
                    axisX: {
                        title: "chart updates every " + 60 + " secs"
                    },
                    axisY: {
                        title: "Velocidad",

                        suffix: "Km/h",

                    },
                    data: [{type: "line",
                            toolTipContent: "{label} : {y} Km/h",
                             lineColor: "red", 
                            dataPoints: data}],
                });
                setInterval(function () {
                    updateChart()
                }, updateInterval);

                //Chart 2

                var dataLength2 = 0;
                var data2 = [];
                var updateInterval2 = 500;
                updateChart2();
                function updateChart2() {
                    $.getJSON("pages/jsoncharoil.php", function (result2) {
                        if (dataLength2 !== result2.length) {
                            for (var i = dataLength2; i < result2.length; i++) {
                                data2.push({
                                    label: (result2[i].valorx),
                                    y: parseFloat(result2[i].valory)
                                });
                            }
                            dataLength2 = result2.length;
                            chart2.render();
                        }
                    });
                }
                var chart2 = new CanvasJS.Chart("chart2", {
                    zoomEnabled: true,
                    title: {
                        text: "Liquid Flow Rate"
                    },
                    axisX: {
                        title: "chart updates every " + 60 + " secs"
                    },
                    axisY: {
                        title: "Sm3/d",

                        suffix: " Sm3/d",

                    },
                    data: [{type: "line",
                             toolTipContent: "{label} : {y} Sm3/d",
                             lineColor: "red", 

                            dataPoints: data2}],
                });
                setInterval(function () {
                    updateChart2()
                }, updateInterval);

                //Chart 3

                var dataLength3 = 0;
                var data3 = [];
                var updateInterval3 = 500;
                updateChart3();
                function updateChart3() {
                    $.getJSON("pages/jsonchargvf.php", function (result3) {
                        if (dataLength3 !== result3.length) {
                            for (var i = dataLength3; i < result3.length; i++) {
                                data3.push({
                                    label: (result3[i].valorx),
                                    y: parseFloat(result3[i].valory)
                                });
                            }
                            dataLength3 = result3.length;
                            chart3.render();
                        }
                    });
                }
                var chart3 = new CanvasJS.Chart("chart3", {
                    zoomEnabled: true,
                    title: {
                        text: "GVF"
                    },
                    axisX: {
                        title: "chart updates every " + 60 + " secs"
                    },
                    axisY: {
                        title: "%",

                        suffix: " %",

                    },
                    data: [{type: "line",
                             toolTipContent: "{label} : {y} %",
                             lineColor: "red", 

                            dataPoints: data3}],
                });
                setInterval(function () {
                    updateChart3()
                }, updateInterval);

                //Chart 4

                var dataLength4 = 0;
                var data4 = [];
                var updateInterval4 = 500;
                updateChart4();
                function updateChart4() {
                    $.getJSON("pages/jsoncharpress.php", function (result4) {
                        if (dataLength4 !== result4.length) {
                            for (var i = dataLength4; i < result4.length; i++) {
                                data4.push({
                                    label: (result4[i].valorx),
                                    y: parseFloat(result4[i].valory)
                                });
                            }
                            dataLength4 = result4.length;
                            chart4.render();
                        }
                    });
                }
                var chart4 = new CanvasJS.Chart("chart4", {
                    zoomEnabled: true,
                    title: {
                        text: "Pressure"
                    },
                    axisX: {
                        title: "chart updates every " + 60 + " secs"
                    },
                    axisY: {
                        title: "kPa",

                        suffix: " kPa",

                    },
                    data: [{type: "line",
                             toolTipContent: "{label} : {y} kPa",
                             lineColor: "red", 

                            dataPoints: data4}],
                });
                setInterval(function () {
                    updateChart4()
                }, updateInterval);


}
</script>
</head>
<body>
<div id="chart" style="height: 350px; max-width: 920px; margin: 0px auto;""></div>
<script src="backend/js/canvasjs.min.js"></script>
</body>
</html>  



