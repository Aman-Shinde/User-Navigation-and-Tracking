<?php
include_once 'dbconnect.php';
session_start();
    if(!isset($_SESSION['User']))
    {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div>
<button class="btn" onclick='goBack()'><i class="fa fa-home"></i> Home</button>
<button class="btn topright" onclick='refreshPage()'><i class="fa fa-refresh"> Refresh</i></button>
</div>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>


  <div id="map">
  <?php  
        $result = mysqli_query($conn,"SELECT * FROM user");
        $result2 = mysqli_query($conn,"SELECT * FROM user");
    ?>
    <script>
        function initMap() {
                            // Map options
                            var options =   {
                                                disableDefaultUI:true,
                                                zoom:7, 
                                                center:{lat:19.7515,lng:75.7139},
                                            }

                            // New map
                            var map = new google.maps.Map(document.getElementById('map'), options);
                            var markers =   [
                                                <?php if($result->num_rows > 0)
                                                {
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                        echo '['.$row['Latitude'].', '.$row['Longitude'].'],';
                                                    }
                                                }
                                                ?>
                                            ];
                    var infoWindowContent = [
                                                <?php if($result2->num_rows > 0)
                                                {
                                                    while($row = $result2->fetch_assoc())
                                                    { ?>
                                                        ['Name:- <?php echo $row['Email_ID'];?><br>Timestamp:- <?php echo $row['Timestamp'];?>'],
                                              <?php }
                                                }
                                                ?>
                                            ];       

                    var infoWindow = new google.maps.InfoWindow({ maxWidth: 450 }), marker, i;


                            for( i = 0; i < markers.length; i++ ) 
                            {
                                
                                var position = new google.maps.LatLng(markers[i][0], markers[i][1]);
                                marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                    Animation: google.maps.Animation.DROP,    
                                });
                                
                                // Add info window to marker    
                                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                    return function() {
                                        infoWindow.setContent(infoWindowContent[i][0]);
                                        infoWindow.open(map, marker);
                                    }
                                })(marker, i));
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
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY&callback=initMap&libraries=&v=weekly">
    </script>
   </div>
</body>
</html>