<html>
<head>
<title>Car Parking</title>
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
table {
    background-color: #fff;
	border-collapse: collapse;
    width: 100%;
    color:#000;
	margin:0 auto;
}

th, td {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #2c3e50;
    color:#eee;
    font-size: 18px;
}
form{
	margin-top: 30px;
}

@media only screen and (max-width:700px){
	body{
		background-color: #2c3e50;
		color: #fff;
	}
	a{
		text-decoration: none;
		text-decoration: underline;
		color: #1f6593;
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
	table{
		width: 100%;
	}
	th{
		font-size: 14px;
	}
	td{
		color: #000;
		font-size: 12px;
	}
}
</style>



</head>

<body>
	<header>
	<h1>Car Parking System (IOT)</h1>
	</header>
	<table>
	<!-- <th>ID</th> -->
	<th>Parking Name</th>
	<th>Parkings Available</th>
	<th>Distance (Km)</th>
	<?php
		require "conn.php";
		if(!empty($_GET['Latitude']) && !empty($_GET['Longitude'])){
			$userlat=$_GET["Latitude"];
			$userlong=$_GET["Longitude"];
		} else {
			$userlat=28.691798;
			$userlong=77.2935442;
		}

		// $query = "SELECT name, venue, num_avail , lati, longi FROM cpsi_parkings ORDER BY `cpsi_parkings`.`num_avail` DESC";
		$query = "SELECT name, venue, num_avail , lati, longi, (1.60934 * SQRT( POW(69.1 * (lati - $userlat), 2) + POW(69.1 * ($userlong - longi) * COS(lati / 57.3), 2))) AS distance FROM cpsi_parkings HAVING distance < 25 ORDER BY distance;";

		
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
			echo '<td><a href="https://www.google.co.in/maps/place/'.$lati.','.$longi.'" target="_blank">'.$name.', '.$venue.'</a></td>'; 
			echo '<td>'.$num_avail.'</td>'; 
			// echo '<td><a href="https://www.google.co.in/maps/place/'.$lati.','.$longi.'" target="_blank">Location - '.$name.'</td>'; 
			echo '<td>'.$distance.'</td>'; 
			echo '</tr>';
		}
	?>
	</table>

</body>
</html>