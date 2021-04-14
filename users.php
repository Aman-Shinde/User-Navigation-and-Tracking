<?php
include_once 'dbconnect.php';
if(isset($_SESSION['User']))
{
  header("location:index.php");
}
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/users.css">
    <script>
      var map;
      var pos;
      var marker
      var data= {};
      var temp = [];
      function initMap() 
      {
        map = new google.maps.Map(document.getElementById("map"), {
          disableDefaultUI:true,
          center: { lat: -34.397, lng: 150.644 },
          zoom: 8,
        });
        marker = new google.maps.Marker({
                        position:{ lat: -34.397, lng: 150.644 },
                        map: map,
                    });
        getLocation();
      }
      function getLocation() 
      {
        if (navigator.geolocation) 
        {
          navigator.geolocation.getCurrentPosition(showPosition);
        } 
        else
        { 
          console.log("Geolocation is not supported by this browser.");
        }
      }
      function showPosition(position) 
      {
        pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
        data.latitude = position.coords.latitude;
        data.longitude = position.coords.longitude;
        temp.push(data);
         $.ajax({
            url:"process1.php",
            method:"post",
            data:{emp:JSON.stringify( data )},
          })
          map.setCenter(pos);
          marker.setPosition(pos);
  }
function refreshPage()
   {
		location.reload();			
   }
function goBack() 
{
  window.history.back();
}
function pass()
{
    var add = document.getElementById("txtAddress").value;
    localStorage.setItem("textvalue",add);
    return false;
}
    </script>
  </head>
  <body>
  <button class="btn" onclick='goBack()'><i class="fa fa-home"></i> Home</button>
  <div style="padding-top:0px; padding-right:0px; padding-bottom:0px; padding-left:40%;">
  <form action="process2.php" method="POST">
  <input type="text" name ="dest" id="txtAddress" value="" style = "width:200px" />
  <input type="submit" value="Get Route"/>
</form>
</div>
  <button class="btn topright" onclick='refreshPage()'><i class="fa fa-refresh"> Refresh</i></button>
  <br />
  <div id="map" style="height:100%" ></div>  
    <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>