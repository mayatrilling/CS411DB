<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <title>Movie Databaes</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/half-slider.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://databaes411.web.engr.illinois.edu/?#">Movie Databaes</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Half Page Image Background Carousel Header -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('https://images6.alphacoders.com/322/322791.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Adventure Movies!</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url('http://s1.picswalls.com/wallpapers/2015/07/31/inside-out-desktop-wallpaper_123104808_260.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Animated Movies!</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="fill" style="background-image:url('http://s1.picswalls.com/wallpapers/2015/11/22/deadpool-desktop-wallpapers_103659927_293.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Action Movies!</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>

<?php
$servername = "databaes411.web.engr.illinois.edu";
$username = "databaes_kjabon";
$password = "n35xray";
$dbname = "databaes_imdb";

$name = $_GET["name"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
/*
$sql = "SELECT * FROM cast_crew WHERE name like '%$name%'";
$result = $conn->query($sql);

$p_name;

if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
    	if ($row["name"] != NULL) {
    		$p_name = $row["name"];
       		//"name: " . $row["name"]."<br>";
       		echo "Name: " . $p_name."<br>";
        }
    }
}*/

echo "Name:" .$name. "<br />";

echo "<br />";
echo "Acted in:<br />";
$sql2 = "SELECT * FROM worked_on_ WHERE person_name like '%$name%' AND acted_in = 1";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
    	if ($row["movie_name"] != NULL) {
                $movie_title = $row["movie_name"];
		$link = "<a href='./searchresult.php?name=$movie_title'> $movie_title </a><br />";
		echo $link;
        }
    }
}

echo "<br />";
echo "Directed:<br />";
$sql3 = "SELECT * FROM worked_on_ WHERE person_name like '%$name%' AND directed = 1";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
    	if ($row["movie_name"] != NULL) {
       		$movie_title = $row["movie_name"];
		$link = "<a href='./searchresult.php?name=$movie_title'> $movie_title </a><br />";
		echo $link;
        }
    }
}

echo "<br />";
echo "Wrote:<br />";
$sql4 = "SELECT * FROM worked_on_ WHERE person_name like '%$name%' AND wrote = 1";
$result4 = $conn->query($sql4);

if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
    	if ($row["movie_name"] != NULL) {
       		$movie_title = $row["movie_name"];
		$link = "<a href='./searchresult.php?name=$movie_title'> $movie_title </a><br />";
		echo $link;
        }
    }
}

echo "<br />";
echo "Award nominations:<br />";
$sql5 = "SELECT * FROM nominated_person WHERE person_name like '%$name%'";
$result5 = $conn->query($sql5);

if ($result5->num_rows > 0) {
    // output data of each row
    while ($row = $result5->fetch_assoc()) {
    	if ($row["recognition"] != NULL) {
       		echo $row["recognition"]. ", " . $row["award_show_title"] . "<br>";
        }
    } 
}

echo "<br />";
echo "Awards won:<br />";
$sql6 = "SELECT * FROM awarded_person WHERE person_name like '%$name%'";
$result6 = $conn->query($sql6);

if ($result6->num_rows > 0) {
    // output data of each row
    while ($row = $result6->fetch_assoc()) {
    	if ($row["recognition"] != NULL) {
       		echo $row["recognition"]. ", " . $row["award_show_title"] . "<br>";
        }
    } 
}

echo "<br />";
echo "<br />";
$link = "<a href='./data2.php?name=$name'> View movie statistics </a><br />";
echo $link;

$conn->close();
?>

<br>

      
  <form action = "recommendedpeople.php" method="get">   
    <input type = "hidden" name = "name" value = "<?php echo $name ?>">
    <button type="submit" value = "$name" class="btn btn-default btn-lg">
    <span class="glyphicon glyphicon-film" aria-hidden="true"></span> Click to see more cast members like this!
  </form>
  
  <form action = "update_like_person.php" method = "post">
	<input type = "hidden" name = "name" value = "<?php echo $name ?>">
	<button type="submit" class="btn btn-default btn-lg" id = "likebutton">
  	<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Like this cast member? 
  </button>
  </form>
  

   <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Databaes CS411 2016</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>
</html>