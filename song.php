
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <script src="./search.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

    <title>Music-Net: Song</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <script>
    $(document).ready(function() {
      $("#play-button").on('click', function() {
        play();
      });
      $('#one').on('click', function(){ 
        rate(1);
      });
      $('#two').on('click', function(){ 
        rate(2);
      });
      $('#three').on('click', function(){ 
        rate(3);
      });
      $('#four').on('click', function(){ 
        rate(4);
      });
      $('#five').on('click', function(){ 
        rate(5);
      });
    });

    function rate(num){
      $.ajax({
        // Query DB for 50 Results
        type: 'POST',
        url: 'rate.php',
        data: {data:document.getElementById('data-div').getAttribute("data-content")+':'+num},
        success: function(response) {
          console.log(response);
          // Append results to marketing
          $('.btn-group').empty();
          $('.btn-group').append('spanks!');
        },
        error: function(response) {
          console.log(arguments);
        }
      });
    };
    function play(sid) {
      $.ajax({
        // Query DB for 50 Results
        type: 'POST',
        url: 'played.php',
        data: {data:document.getElementById('data-div').getAttribute("data-content")},
        success: function(response) {
          console.log(response);
          // Append results to marketing
          $('.playing').empty();
          $('.playing').append(response);
        },
        error: function(response) {
          console.log(arguments);
        }
      });
    };
    </script>
    <!-- Custom styles for this template -->
    <style>
    /* Space out content a bit */
body {
  padding-top: 20px;
  padding-bottom: 20px;
  background-color: #202020;
}

/* Everything but the jumbotron gets side spacing for mobile first views */
.header,
.marketing,
.footer {
  padding-right: 15px;
  padding-left: 15px;
}


/* Custom page header */
.header {
  border-bottom: 1px solid #e5e5e5;
}
/* Make the masthead heading the same height as the navigation */
.header h3 {
  padding-bottom: 19px;
  margin-top: 0;
  margin-bottom: 0;
  line-height: 40px;
}

/* Custom page footer */
.footer {
  padding-top: 19px;
  color: #777;
  border-top: 1px solid #e5e5e5;
}

/* Customize container */
@media (min-width: 768px) {
  .container {
    max-width: 730px;
  }
}
.container-narrow > hr {
  margin: 30px 0;
}

.control-group{
  float: left;
}


/* Main marketing message and sign up button */
.jumbotron {
  text-align: center;
  border-bottom: 1px solid #e5e5e5;
}
.jumbotron .btn {
  padding: 14px 24px;
  font-size: 21px;
}

/* Supporting marketing content */
.marketing {
  margin: 40px 0;
}
.marketing p + h4 {
  margin-top: 28px;
}
/* Responsive: Portrait tablets and up */
@media screen and (min-width: 768px) {
  /* Remove the padding we set earlier */
  .header,
  .marketing,
  .footer {
    padding-right: 0;
    padding-left: 0;
  }
  /* Space out the masthead */
  .header {
    margin-bottom: 30px;
  }
  /* Remove the bottom border on the jumbotron for visual effect */
  .jumbotron {
    border-bottom: 0;
  }
}
    </style>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!-- Jquery meep! -->

    
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="/php-wrapper/adh/search_page.php">Home</a></li>
          <li><a href="/php-wrapper/adh/logintest.php">Login/Out</a>
        </ul>
        <h3 class="text-muted">Music-Net</h3>
      </div>

      <div id="jumbo" class="jumbotron">
      <?php
        $sid = $_GET["sid"];
        $connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
        if ($connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
        }

        $query="SELECT * FROM Songs WHERE sid = '".$sid."'";
        $result=$connection->query($query);
        $row=$result->fetch_array(MYSQLI_NUM);
        $name = $row[1];
        $duration = $row[2];
        $loudness = $row[3];
        $year= $row[4];
        $albid=$row[5];
        $artid=$row[6];

        if(strlen($name) > 19){
          echo '<p><b>'.$name.'</b></p><br>';
        }
        else{
          echo '<h1>'.$name.'</h1>';
        }

        $query="SELECT * FROM Artists WHERE artid = '".$artid."'";
        $result=$connection->query($query);
        $row=$result->fetch_array(MYSQLI_NUM);
        echo '<p>Artist: <a href="./artist.php?artid='.$artid.'">'.$row[1].'</a></p>';
        $query="SELECT * FROM Albums WHERE albid = '".$albid."'";
        $result=$connection->query($query);
        $row=$result->fetch_array(MYSQLI_NUM);
        echo '<p>Album: <a href="./artist.php?albid='.$albid.'">'.$row[1].'</a></p>';
        echo '<div class="playing"><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></div>';
        //update average rating for this song
        $query="SELECT avgrating FROM Songstats WHERE sid = '".$sid."'";
        $result=$connection->query($query);
        $row=$result->fetch_array(MYSQLI_NUM);
        echo '<p>Year: '.$year.'&nbsp;&nbsp;&nbsp;Duration: '.$duration.'&nbsp;&nbsp;&nbsp;Avg Rating: '.round($row[0],3).'</p>';


        // Create play button if user is logged in
        if(isset($_COOKIE["username"])){
          echo '<div id="data-div" data-content="'.$sid.':'.$_COOKIE["login"].'"></div>
          <div class="control-group">
          <label class="control-label" for="singlebutton"></label>
            <button id="play-button" type="button" name="singlebutton" class="btn btn-primary">Play</button>
          </div>
          ';
        }
        
      ?>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Rate<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><button id="one" type="button" name="singlebutton" class="btn btn-primary">1</button></li>
            <li><button id="two" type="button" name="singlebutton" class="btn btn-primary">2</button></li>
            <li><button id="three" type="button" name="singlebutton" class="btn btn-primary">3</button></li>
            <li><button id="four" type="button" name="singlebutton" class="btn btn-primary">4</button></li>
            <li><button id="five" type="button" name="singlebutton" class="btn btn-primary">5</button></li>
          </ul>
        </div>
      </div>
      <div class="footer">
        <p>&copy; Information Systems</p>
      </div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>