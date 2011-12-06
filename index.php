<?php
// Get params from URL if exist
$status = $_GET['status'];
$array = unserialize(rawurldecode($_GET['array']));
//
?>
<html>
	<head>
		<title>LivingSocial Data Engineering Challenge</title>
		<script src="js/jquery-1.7.1.js"></script>
		<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
		<script type="text/javascript">
		$(document).ready(function() {
		$("#submit").button();
		<?php
		if (strcmp($status, "Submitted") == 0) {
		// Unhide DB success message and display calculated revenue
		echo "$('.ui-widget_fail').css('display', 'none');";
		echo "$('.ui-widget').css('display', 'inline');";
		echo "$('#totalRevenue').css('display', 'inline');";
		//
		}
		elseif (strcmp($status, "Failed") == 0)  {
		// Unhide DB fail message
		echo "$('.ui-widget_fail').css('display', 'inline');";
		echo "$('#totalRevenue').css('display', 'inline');";
		//
		}
		else {
		echo "$('#totalRevenue').css('display', 'none');";
		}
		?>
		});
		</script>
	</head>
		<body>
			<div id="mainWrap">
				<div class="ui-widget">
					<div class="ui-state-highlight ui-corner-all"> 
						<p><span class="ui-icon ui-icon-info"></span>
						<strong>Success!</strong><br/> Your data has been uploaded to the MySQL database.</p>
					</div>
				</div>
			<div class="ui-widget_fail">
				<div class="ui-state-highlight ui-corner-all"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Error!</strong><br/> Unable to authenticate with MySQL server.</p>
				</div> <!-- /.styling -->
			</div> <!-- /.ui-widget_fail -->
				<h2 class="heading">Data Normalization</h2>
					<div id="form">
					<form action="dbFunctions.php" method="post" enctype="multipart/form-data">
					<label for="file" class="heading">File:</label>
					<input type="file" name="file" id="file" />
					<br />
					<input type="submit" name="submit" id="submit" value="Submit for Normalization" />
					</form>
					</div> <!-- /#form -->
				<div id="totalRevenue">
					<h3>Total Revenue:</h3>
					<?php
						// Display unserialized, decoded array from URL param
						print_r($array);
						//
					?>
				</div> <!-- /#totalRevenue -->
			</div>  <!-- /#mainWrap -->
		</body>
</html>
