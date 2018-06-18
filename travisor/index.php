<?php

	include('connections/conn.php');
	
	if (isset($_POST["search"])) {
    

		$catagory = mysqli_real_escape_string($conn, $_POST['catagory']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);

		$query = "SELECT travisor_tradesperson.name, travisor_catagory.catname, travisor_city.cityname, travisor_company.cname, travisor_company.description 
				FROM `travisor_tradesperson`
				INNER JOIN travisor_company 
				ON travisor_tradesperson.company = travisor_company.id
				INNER JOIN travisor_catagory 
				ON travisor_tradesperson.catagory = travisor_catagory.id	
				INNER JOIN travisor_city 
				ON travisor_tradesperson.city = travisor_city.id	
				WHERE travisor_catagory.catname = '$catagory'
				AND travisor_city.cityname = '$city'";

		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

		mysqli_close($conn);
	
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
        <link rel="stylesheet" href="Styles/custom.css" />
		
    </head>

    <body>

	<nav class="navbar navbar-inverse navbar-fixed-top">

            <div class="container">

                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                        <span class="sr-only">Toggle navigation</span>

                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="index.php" class="navbar-brand navbar-left ">TRAVISOR</a>


                </div> 



                <div id="navbar" class="navbar-collapse collapse">

                    <div class="navbar-form navbar-right ">	
                        <form method="POST">
							<a href=""><button type="button" class="btn btn-default">Sign Up</button></a>
                            <button type="submit" class="btn btn-primary" name='sign'>Sign in</button>
                        </form>



                    </div>
                </div><!--/.navbar-collapse -->
            </div>
    </nav>
	
	<div class="background1">
	<div class="white">
		<div class="container">
			<div class="row">
				<div class="vSpacer"></div>
			</div>
			<div class="row">
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
				<div class="col-sm-10 col-md-8 col-lg-6">
					<h1>Search for a trades person...</h1>

					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST'>
						<div class="form-group">
						   <label>I am looking for a...</label>
							<select class="form-control" name="catagory">
							  <option disabled selected value> Select an option </option>
							  <option <?php if (isset($catagory) && $catagory=="Plummer") echo "selected";?>>Plummer</option>
							  <option <?php if (isset($catagory) && $catagory=="Electrician") echo "selected";?>>Electrician</option>
							  <option <?php if (isset($catagory) && $catagory=="Mechanic") echo "selected";?>>Mechanic</option>
							  <option <?php if (isset($catagory) && $catagory=="Carpenter") echo "selected";?>>Carpenter</option>
							  <option <?php if (isset($catagory) && $catagory=="Builder") echo "selected";?>>Builder</option>
							</select>
						</div>
						<span class="form-group">
						<label>in...</label>
							<input type="text" placeholder="Enter city or town" class="form-control" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>">
						</span>
						<br>
						<!--<span class="form-group">
						<label>Or search by trades person name...</label>
							<input type="text" placeholder="Enter trades person name..." class="form-control" name="name">
						</span>
						<br>
						<span class="form-group">
						<label>Or search by company name...</label>
							<input type="text" placeholder="Enter company name..." class="form-control" name="name">
						</span>
						<br>-->
						<button type="submit" class="btn btn-primary" name='search'>Search</button>
					</form>

				</div>
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
			</div>
		</div>
		</div>		
	
			<div class="container">
			<div class="row">
				<div class="vSpacer"></div>
			</div>
			<div class="row">
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
				<div class="col-sm-10 col-md-8 col-lg-6">
				<?php
					
					if (isset($_POST["search"])) {
					  
						if(mysqli_num_rows($result) == 0) {
							
							echo "No trades people meet your search criteria";
							
						}
						
						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {

								$name = $row["name"];
								$cname = $row["cname"];
								$description = $row["description"];

								echo "<div class='panel panel-default'>
										<div class='panel-body'><p>$name - $cname</p><br /><p>$description</p></div>
									</div>";
							}
						}
					}
				?>

				</div>
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
			</div>
		</div>
				
	
		</div>
    </body>
</html>