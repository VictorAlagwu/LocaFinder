<?php
// @author Victor Alagwu
// @email victoralagwu@gmail.com
// @+234(817)-044-9567
// @project Integrating REST APIs in web Applications(Using PHP)
// @Date May 2017
if (empty($_GET['location'])) {

	?>
<!DOCTYPE html>
<html>
<head>
	<title>Location API</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
		body{
			padding-top: 70px;
		}
		button.hover{
			color:green;
		}
	</style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class='jumbotron' align="center"><h2 style="font-family: Arie Black;">Welcome to the LocationImage Finder</h2><p style="font-family: Monotype Cor;"><small>Here,you can get the image of any location</small></p></div>

	</div>
	<div class="row">
		<form>
				<div class="input-group">
					<label for="location">Location</label>
					<input type="text" name="location" class="form-control" required><br>
				</div>

				<button type="submit" class="btn btn-default">Submit</button>

		</form>
	</div>
	<div class="row">
		<?php
} else {
	//Get the location from the user
	$location = $_GET['location'];

	//Start
	//Google Map APIs
	$map_url = 'https://' .
		'maps.googleapis.com/maps' .
		'/api/geocode/json' .
		'?address=' . $location .
		'&key='; //Generate a GoogleMap API key online

	//Get API Content
	$map_json = file_get_contents($map_url);

	//Decode and convert json information to arrays
	$map_array = json_decode($map_json, true);

	//Get the Latitute and Longitute
	$lat = $map_array['results'][0]['geometry']['location']['lat'];
	$lng = $map_array['results'][0]['geometry']['location']['lng'];
	//End

	//Instagram Developer APIs
	$insta_url = 'https://' .
	'api.instagram.com/v1/media/search' .
	'?lat=' . $lat . //Latitute Value
	'&lng=' . $lng . //Longitute Value
	'&access_token=ACCESS_TOKEN'; //Generate a new Access token online

	//Get contents of Instagram API
	$insta_json = file_get_contents($insta_url);

	//Decode and convert json information to arrays
	$insta_array = json_decode($insta_json, true);
	echo "Data gotten ";
	echo '<p>The latitute is' . $lat . 'while the longitute is ' . $lng . '</p>';
	if (!empty($insta_array)) {
		?>

  				<div class="col-xs-6 col-md-3">
			<?php
foreach ($insta_array['data'] as $image) {
			?>
		<p><a href="#" class="thumbnail"><?php echo '<img src="' . $image['images']['low_resolution']['url'] . '" alt=\'ss\'>'; ?></a></p>
		<?php
}
	}
}
?>				</div>
	</div>

</div>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js'></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>