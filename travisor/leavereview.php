<?php
	session_start();

	include('connections/conn.php');
	
	$id = $_GET['id'];
	
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
				WHERE travisor_tradesperson.id = '$id'
				GROUP BY travisor_tradesperson.name, travisor_catagory.catname, travisor_company.cname, 
					travisor_company.description";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	if (isset($_POST["leave"])) {
		
		$lreview = mysqli_real_escape_string($conn, $_POST['lreview']);
		$srating = mysqli_real_escape_string($conn, $_POST['srating']);

		$query2 = "INSERT INTO travisor_review (tradesperson, rating, review)
			VALUES('$id', '$srating', '$lreview')";

		$result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
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
	
		<div class="container">
			<div class="row">
				<div class="vSpacer"></div>
			</div>
			<div class="row">
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
				<div class="col-sm-12 col-md-8 col-lg-6">
	
					<?php
							
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
									echo		"</div>";
									echo	"</div>";
								}
							}
					?>
					
					<form action="<?php echo "leavereview.php?id=$id"?>" method='POST'>
						<div class="form-group">
						   <label>Star rating...</label>
							<select class="form-control" name="srating" required>
							  <option disabled selected value> Select an option </option>
							  <option>1</option>
							  <option>2</option>
							  <option>3</option>
							  <option>4</option>
							  <option>5</option>
							</select>
						</div>
						<br>
						<div class="form-group">
						  <label for="comment">Review</label>
						  <textarea class="form-control" rows="5" id="comment" name="lreview" maxlength="499" required></textarea>
						</div>
						<br>
						<button type="submit" class="btn btn-primary" name='leave'>Leave review</button>
					</form>
					
					<?php
	
						if (isset($_POST["leave"])) {
						
							echo "<h3>Thanks, your review has been saved.</h3>";
							
							echo "<form action='index.php'>
									<input type='submit' class='btn btn-default' value='back to search' />
								</form>";
							
						}
					?>
					
				</div>
				<div class="col-sm-0 col-md-2 col-lg-3"></div>
			</div>
		</div>
		
    </body>
</html>