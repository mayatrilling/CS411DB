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

$current_liked_person = $_GET["name"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//echo $current_liked_person;

$array = array();

$sql = "SELECT `name`					
		FROM `cast_crew`";

$result = $conn->query($sql);
	    		
if ($result->num_rows > 0) {		//Compare person of interest to every other person

	while($row = $result->fetch_assoc()) {
		if ($row["name"] != NULL) {
	    		$current_queried_person = $row["name"];	
					
			//echo $current_queried_person;			
			
			$sql2 = "SELECT * 
	    			FROM `worked_on_`
	    			WHERE `person_name` like '%$current_queried_person%'
	    			AND '$current_queried_person' <> '$current_liked_person'
	    			AND `wrote` = 0
				AND `movie_name` = ANY(SELECT `movie_name` FROM `worked_on_` WHERE `person_name` like '%$current_liked_person%')";	
					
			$result2 = $conn->query($sql2);
			
			if ($result2->num_rows > 0) {
    				while($row = $result2->fetch_assoc()) {
    					$person_name = $row["person_name"];
    					//echo $person_name . "<br />";
    					//echo $current_liked_person ."<br />";
    						
    					if($array[$person_name] < 1){
    						$array[$person_name] = 1;
    						//echo "Inserted";
    						//print_r($array);
    					} 
    					else{
    						$array[$person_name]++;
    					}
    						
		    			//$link = "<a href='./search_result_person.php?name=$person_name'> $person_name </a><br />";
					//echo $link;
					
		    		}	
		    	}	
	    		
		}
	}
	
}

arsort($array);
		    	
for ($x = 0; $x <= count($array); $x++) {
  	$person_name = key($array);
  	$link = "<a href='./search_result_person.php?name=$person_name'> $person_name </a><br />";
	echo $link;
  	next($array);
} 

$conn->close();
?>

<br>

  <!---  
 Recommend movies of the same genre and at least 1 similar cast member as a currently liked movie
	-Traverse through the "movies" table. Do the following computation for each movie in the table who has been "Liked":
		-Assign said movie as "current_liked_movie"
		-Query "worked_on" table for movies that don't have the same name as "current_liked_movie" but have at least 1 
		cast member name that is the same as any of the cast member names from tuples of the "current_liked_movie"
		and at least 1 genre in common with "current_liked_movie"
		
	This query will also be used for finding related movies when the user clicks on "search for similar movies"
	on a movie's page. In this case, simply replace "current_liked_movie" with the movie whose page we're currently on

	
	
If this yields nothing, just go for 
	SELECT title
	FROM worked_on_, movies
	WHERE title <> "current_liked_movie"
	AND title = title
	AND person_name = ANY(SELECT person_name FROM worked_on_ WHERE title = "current_liked_movie")
	
--->	
	
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