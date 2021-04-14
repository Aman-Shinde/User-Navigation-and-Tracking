<?php
include_once 'dbconnect.php';
session_start();
$add = $_POST["dest"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/process2.css">
    <script>
    var data= {};
    var temp = [];
    var add = <?php echo json_encode($add, JSON_PRETTY_PRINT) ?>;
    function GetRoute() {
    var markers = new Array();
    var myLatLng;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (p) {
            var myLatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
            var m = {};
            m.title = "Your location";
            m.lat = p.coords.latitude;
            m.lng = p.coords.longitude;
            data.latitude = p.coords.latitude;
            data.longitude = p.coords.longitude;
            temp.push(data);
            $.ajax({
            url:"process1.php",
            method:"post",
            data:{emp:JSON.stringify( data )},
            })
            markers.push(m); 
            //Find specified address location.
            var address = add;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    m = {};
                    m.title = address;
                    m.lat = results[0].geometry.location.lat();
                    m.lng = results[0].geometry.location.lng();
                    markers.push(m);
                    var mapOptions = {
                        disableDefaultUI:true,
                        center: myLatLng,
                        zoom: 18,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();
 
                    for (i = 0; i < markers.length; i++) {
                        var data = markers[i];
                        var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title: data.title,
                        });
                        latlngbounds.extend(marker.position);
                        (function (marker, data) {
                            google.maps.event.addListener(marker, "click", function (e) {
                                infoWindow.setContent(data.title);
                                infoWindow.open(map, marker);
                            });
                        })(marker, data);
                    }
                    //map.setCenter(latlngbounds.getCenter());
                    //map.fitBounds(latlngbounds);
 
                    //***********ROUTING****************//
 
                    //Initialize the Path Array.
                    var path = new google.maps.MVCArray();
 
                    //Initialize the Direction Service.
                    var service = new google.maps.DirectionsService();
 
                    //Set the Path Stroke Color.
                    var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
 
                    //Loop and Draw Path Route between the Points on MAP.
                    for (var i = 0; i < lat_lng.length; i++) {
                        if ((i + 1) < lat_lng.length) {
                            var src = lat_lng[i];
                            var des = lat_lng[i + 1];
                            path.push(src);
                            poly.setPath(path);
                            service.route({
                                origin: src,
                                destination: des,
                                travelMode: google.maps.DirectionsTravelMode.DRIVING
                            }, function (result, status) {
                                if (status == google.maps.DirectionsStatus.OK) {
                                    for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                                        path.push(result.routes[0].overview_path[i]);
                                    }
                                } else {
                                    //If the location specified is invalid, show error.
                                    alert("Invalid location for plotting route.");
                                    window.location.href = window.location.href;
                                }
                            });
                        }
                    }
                } else {
                    alert("Request failed.")
                }
            });
 
        });
    }
    else {
        alert('Geo Location feature is not supported in this browser.');
        return;
    }
}
function refreshPage()
   {
		location.reload();			
   }
   function goBack() 
   {
    window.history.back();
   }
    </script>
  </head>
  <body>
  <form action="index.html">
  <button class="btn" onclick='goBack()'><i class="fa fa-home"></i> Home</button>
  </form>
  <button class="btn topright" onclick='refreshPage()'><i class="fa fa-refresh"> Refresh</i></button>
  <br />
  <div id="map" style="height:100%" ></div>  
    <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY&callback=GetRoute&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>
