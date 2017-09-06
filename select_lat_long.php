<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale:1.0, user-scaleable=0">
<style>
body{
	margin:0 auto;
    text-align: center;
    color:#eee;
    background-color: #2c3e50;
}
header{
	margin:0 auto;
	padding: 1px;
	background-color: #1f2d3a;
}
h1{
	font-size: 60px;
}

div#para{
		margin-top: 30px;
	}

span{
	font-size: 20px;
}
form{
	margin-top: 30px;
}

form input{
	font-style: bold;
	margin-top: 5px;
	background-color: #ddd;
	text-align: center;
}

@media only screen and (max-width:700px){
	body{
		background-color: #2c3e50;
		color: #fff;
	}
	header{
		margin:0 auto;
		padding: 10px;
		background-color: #1f2d3a;
	}
	h1{
		color: #fff;
		font-size: 25px;
	}
	div#para{
		font-size: 13px;
		margin-top: 40px;
	}
	div#error{
		font-size: 13px;
		margin-top: 5px;
	}
}
</style>

</head>
<body>
<div class="bg">
<div class="bgin">

	<header>
		<h1>Car Parking System (IOT)</h1>
	</header>
	<div id="para">Click the button to get your coordinates.

	<button onclick="getLocation()">Get Coordinates</button></div>

	<div id="error"></div>
	<br>
	<hr>
	<br>

	<script>
		var x = document.getElementById("error");
		function getLocation() {
		    if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition, showError);
		    } else { 
		        x.innerHTML = "Geolocation is not supported by this browser.";
		    }
		}
		function showPosition(position) {
			document.getElementById("Latitude").value = position.coords.latitude;
			document.getElementById("Longitude").value = position.coords.longitude;
		}
		function showError(error) {
		    switch(error.code) {
		        case error.PERMISSION_DENIED:
		            x.innerHTML = "User denied the request for Geolocation."
		            break;
		        case error.POSITION_UNAVAILABLE:
		            x.innerHTML = "Location information is unavailable."
		            break;
		        case error.TIMEOUT:
		            x.innerHTML = "The request to get user location timed out."
		            break;
		        case error.UNKNOWN_ERROR:
		            x.innerHTML = "An unknown error occurred."
		            break;
		    }
		}
	</script>


	<form action="showTable.php" >
		  <span>Latitude:</span><br>
		  <input type="text" name="Latitude" id="Latitude"><br><br>
		  <span>Longitude:</span><br>
		  <input type="text" name="Longitude" id="Longitude"><br><br>
		  <input type="submit" value="Search">
		</form> 

	</body>
	<script type="text/javascript">
		function myTableWithData(){
			<?php
			require "conn.php";
			echo '<table>';
			echo '<th>Parking Name</th>';
			echo '<th>Parkings Available</th>';
			echo '<th>Location of Parking</th>';
			echo '<th> distance</th>';
			$userlat = "<script>document.write(position.coords.latitude)</script>";
			$userlong= "<script>document.write(position.coords.longitude)</script>";
			// $query = "SELECT name, venue, num_avail , lati, longi FROM cpsi_parkings ORDER BY `cpsi_parkings`.`num_avail` DESC";
			$query = "SELECT name, venue, num_avail , lati, longi, SQRT(
	POW(69.1 * (lati - $userlat), 2) +
	POW(69.1 * ($userlong - longi) * COS(lati / 57.3), 2)) AS distance
	FROM cpsi_parkings HAVING distance < 25 ORDER BY distance;";

			
			//$data = mysql_fetch_assoc($query);
			//$mysqli_result  = mysqli_query($conn,$query);
			$result = mysqli_query($conn,$query);
			while($data = mysqli_fetch_assoc($result)){
				// $id = $data['id'];
				$name = $data['name'];
				$venue = $data['venue'];
				$num_avail = $data['num_avail'];
				$lati = $data['lati'];
				$longi = $data['longi'];
				$distance=$data['distance'];
				echo '<tr>';
				// echo '<td>'.$id.'</td>';
				echo '<td>'.$name.', '.$venue.'</td>'; 
				echo '<td>'.$num_avail.'</td>'; 
				echo '<td><a href="https://www.google.co.in/maps/place/'.$lati.','.$longi.'" target="_blank">Location - '.$name.'</td>'; 
				echo '<td>'.$distance.'</td>'; 
				echo '</tr>';
			}
			echo '</table>';
			?>
		}
	</script>
	</div>
	</div>	
</body>		
</html>
