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

//Get list of liked movies





// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT `movie_name`			
	FROM `worked_on_`
	WHERE `person_name` = ANY (SELECT `name` FROM `cast_crew` WHERE `Liked` > '0')";
$result = $conn->query($sql);

$ar = array();

if ($result->num_rows > 0) {
    // output data of each row
    echo "Movies of cast members you like"."<br>";
   
    while($row = $result->fetch_assoc()) {
    	if ($row["movie_name"] != NULL) {
    		$title = $row["movie_name"];
		$ar[$title]++;
       		//echo "Title: " . $row["title"]."<br>";
        }
        
    }
} else {
    echo "0 results";
}

arsort($ar);

for ($x = 0; $x <= count($ar); $x++) {
	$movie_name = key($ar);
	$link = "<a href='./searchresult.php?name=$movie_name'> $movie_name </a><br />";
	echo $link;
	next($ar);
}  


$sql2 = "SELECT `title`			
	FROM `movies`
	WHERE `Liked` > '0'";
$result2 = $conn->query($sql2);


//Second pass for recommendations
if ($result2->num_rows > 0) {

	while($row = $result2->fetch_assoc()) {
		if ($row["title"] != NULL) {
			$current_liked_movie = $row["title"];
			echo "<br />";
			echo "Because you liked ".$current_liked_movie. "<br>";
	    		$sql3 = "SELECT *
				FROM `worked_on_`, `movies`
				WHERE `movie_name` <> '$current_liked_movie'
				AND `movie_name` = `title`
				AND `person_name` = ANY(SELECT `person_name` FROM `worked_on_` WHERE `movie_name` = '$current_liked_movie')
				AND ((`genre_1` = (SELECT `genre_1` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_1` = (SELECT `genre_2` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_1` = (SELECT `genre_3` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_1` = (SELECT `genre_4` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_1` = (SELECT `genre_5` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_2` = (SELECT `genre_1` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_2` = (SELECT `genre_2` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_2` = (SELECT `genre_3` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_2` = (SELECT `genre_4` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_2` = (SELECT `genre_5` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_3` = (SELECT `genre_1` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_3` = (SELECT `genre_2` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_3` = (SELECT `genre_3` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_3` = (SELECT `genre_4` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_3` = (SELECT `genre_5` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_4` = (SELECT `genre_1` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_4` = (SELECT `genre_2` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_4` = (SELECT `genre_3` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_4` = (SELECT `genre_4` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_4` = (SELECT `genre_5` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_5` = (SELECT `genre_1` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_5` = (SELECT `genre_2` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_5` = (SELECT `genre_3` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_5` = (SELECT `genre_4` FROM `movies` WHERE `title` like '%$current_liked_movie%'))
					 OR (`genre_5` = (SELECT `genre_5` FROM `movies` WHERE `title` like '%$current_liked_movie%')))";
				
			$result3 = $conn->query($sql3);
			
			$array = array();
			
			if ($result3->num_rows > 0) {
				// output data of each row			   
				while($row = $result3->fetch_assoc()) {
					if ($row["movie_name"] != NULL) {
				    		$movie_name = $row["movie_name"];    		
    						$array[$movie_name]++;
				       		//echo "Title: " . $row["title"]."<br>";
				        }
		        
		    		}
			} else {
	    			echo "0 results";
			}
			
			arsort($array);
			
			for ($x = 0; $x <= count($array); $x++) {
				$movie_name = key($array);
				$link = "<a href='./searchresult.php?name=$movie_name'> $movie_name </a><br />";
				echo $link;
				next($array);
			}  

	    	}
	}
}else {
    echo "0 results";
}

$title = $row["title"];

$conn->close();


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 




  

$conn->close();
?>

<br>


	
   <script type = "text/javascript">
   	var urlTitle = $(location).attr('search').substring(6);
   	var parsedUrlTitle = urlTitle.replace(/#|+/g,'');
   	
   	$(document).ready(function() {
   	$("#likebutton").click(function() {
   		$.ajax({
   		  url:"updatelike.php",
   		  data:{
   		  	original_title = parsedUrlTitle
   		  },
   		  async: true,
   		  type: "POST",
   		  success:function(result) {
   		  	alert(result);
   		  },
   		  error:function(request, status, error) {
   		  	alert(request.responseText);
   		  }
   		});
   	});
   	})
   </script>

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