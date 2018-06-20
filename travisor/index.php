<?php
	session_start();

	include('connections/conn.php');
	
	if (isset($_POST["search"])) {
    

		$catagory = mysqli_real_escape_string($conn, $_POST['catagory']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$companyName = mysqli_real_escape_string($conn, $_POST['cname']);

		if ($name == '' && $companyName == '') {
			$query = "SELECT travisor_tradesperson.name, travisor_tradesperson.id, travisor_catagory.catname, 
						travisor_company.cname, travisor_company.description, travisor_company.city, travisor_company.address, travisor_company.postcode, travisor_company.phone, 
						ROUND(AVG(travisor_review.rating)) as RoundAvgRating, AVG(travisor_review.rating) as AvgRating, COUNT(travisor_review.rating) as NumReviews
				FROM `travisor_tradesperson`
				INNER JOIN travisor_company 
				ON travisor_tradesperson.company = travisor_company.id
				INNER JOIN travisor_catagory 
				ON travisor_tradesperson.catagory = travisor_catagory.id		
				INNER JOIN travisor_review 
				ON travisor_review.tradesperson = travisor_tradesperson.id 
				WHERE travisor_catagory.catname = '$catagory'
				AND travisor_company.city = '$city'
				GROUP BY travisor_tradesperson.name, travisor_catagory.catname, travisor_company.cname, 
					travisor_company.description
				ORDER BY AvgRating DESC, NumReviews DESC";
		}
		
		if ($name != '') {
			$query = "SELECT travisor_tradesperson.name, travisor_tradesperson.id, travisor_catagory.catname, 
						travisor_company.cname, travisor_company.description, travisor_company.city, travisor_company.address, travisor_company.postcode, travisor_company.phone,
						ROUND(AVG(travisor_review.rating)) as RoundAvgRating, AVG(travisor_review.rating) as AvgRating, COUNT(travisor_review.rating) as NumReviews
				FROM `travisor_tradesperson`
				INNER JOIN travisor_company 
				ON travisor_tradesperson.company = travisor_company.id
				INNER JOIN travisor_catagory 
				ON travisor_tradesperson.catagory = travisor_catagory.id	
				INNER JOIN travisor_review 
				ON travisor_review.tradesperson = travisor_tradesperson.id
				WHERE travisor_tradesperson.name = '$name'
				GROUP BY travisor_tradesperson.name, travisor_catagory.catname, travisor_company.cname, 
					travisor_company.description
				ORDER BY AvgRating DESC, NumReviews DESC";
		}
		
		if ($companyName != '' && $name == '') {
			$query = "SELECT travisor_tradesperson.name, travisor_tradesperson.id, travisor_catagory.catname, 
						travisor_company.cname, travisor_company.description, travisor_company.city, travisor_company.address, travisor_company.postcode, travisor_company.phone,
						ROUND(AVG(travisor_review.rating)) as RoundAvgRating, AVG(travisor_review.rating) as AvgRating, COUNT(travisor_review.rating) as NumReviews
				FROM `travisor_tradesperson`
				INNER JOIN travisor_company 
				ON travisor_tradesperson.company = travisor_company.id
				INNER JOIN travisor_catagory 
				ON travisor_tradesperson.catagory = travisor_catagory.id	
				INNER JOIN travisor_review 
				ON travisor_review.tradesperson = travisor_tradesperson.id				
				WHERE travisor_company.cname = '$companyName'
				GROUP BY travisor_tradesperson.name, travisor_catagory.catname, travisor_company.cname, 
					travisor_company.description
				ORDER BY AvgRating DESC, NumReviews DESC";
		}
		
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

		mysqli_close($conn);
	
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
        <title>Travisor</title>
		
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
        <link rel="stylesheet" href="Styles/custom.css" />
		
		
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
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
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
				<div class="col-sm-12 col-md-8 col-lg-6">
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
						<span class="form-group">
						<label>Or search by trades person name...</label>
							<input type="text" placeholder="Enter trades person name..." class="form-control" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">
						</span>
						<br>
						<span class="form-group">
						<label>Or search by company name...</label>
							<input type="text" placeholder="Enter company name..." class="form-control" name="cname" value="<?php echo isset($_POST['cname']) ? $_POST['cname'] : '' ?>">
						</span>
						<br>
						<button type="submit" class="btn btn-primary" name='search'>Search</button>
					</form>

				</div>
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
			</div>
		</div>
		</div>		
	
		<div class="container">
			<div class="row">
				<div class="vSpacer"></div>
			</div>
			<div class="row">
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
				<div class="col-sm-12 col-md-8 col-lg-6">
					
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
									$rating = $row["RoundAvgRating"];
									$NumReviews = $row["NumReviews"];
									$city = $row["city"];
									$address = $row["address"];
									$postcode = $row["postcode"];
									$phone = $row["phone"];
									$id = $row["id"];

									echo 	"<div class='panel panel-default'>";
									echo		"<div class='panel-body'>";
									echo			"<h3>$name - $cname</h3>";
									echo        	"<div class='panelBodyOne' style='float: left; width: 50%;'>";
									
									if ($rating == 1) {
										echo "<p><img src='images/1star.png' /> - <a href ='#'>$NumReviews reviews</a></p>";
									}
									
									if ($rating == 2) {
										echo "<p><img src='images/2star.png' /> - <a href ='#'>$NumReviews reviews</a></p>";
									}
									
									if ($rating == 3) {
										echo "<p><img src='images/3star.png' /> - <a href ='#'>$NumReviews reviews</a></p>";
									}
									
									if ($rating == 4) {
										echo "<p><img src='images/4star.png' /> - <a href ='#'>$NumReviews reviews</a></p>";
									}
									
									if ($rating == 5) {
										echo "<p><img src='images/5star.png' /> - <a href ='#'>$NumReviews reviews</a></p>";
									}
									
									echo				"<p>$description</p>";
									echo            "</div>";
									echo            "<div class='panelBodyTwo' style='float: right; width: 50%;'>";
									echo				"<p>Phone - $phone</p>";
									echo				"<p>Address - $address, $city, $postcode</p>";
									echo           "</div>";
									
									echo				"<p><a class='btn btn-primary' href='leavereview.php?id=$id' role='button'>Leave a review</a></p>";
									
									echo		"</div>";
									echo	"</div>";
								}
							}
						}
					?>
				
				</div>
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
			</div>
		</div>
				
	</div>
		
    </body>
</html>