
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

    <title>Music-Net: Album</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

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
        $albid = $_GET["albid"];
        $connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
        if ($connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
        }

        $query="SELECT Al.albid,Al.albname,Ar.artid,Ar.artname FROM Albums Al, Artists Ar WHERE Al.artid=Ar.artid AND Al.albid = '".$albid."'";
        $result=$connection->query($query);
        $row=$result->fetch_array(MYSQLI_NUM);
        $albname = $row[1];
        $artid = $row[2];
        $artname = $row[3];
        $location = $row[2];
        if(strlen($albname) > 19){
          echo '<p><b>'.$albname.'</b></p><br>';
        }
        else{
          echo '<h1>'.$albname.'</h1>';
        }
        echo '<p>Artist: <a href="./artist.php?artid='.$artid.'">'.$artname.'</a></p>';

        $query="SELECT * FROM Songs WHERE albid = '".$albid."'";
        $result=$connection->query($query);
        
        echo '<p>Tracks:</p>';
        while($row=$result->fetch_array(MYSQLI_NUM)){
          echo "<p><a href=/song.php?sid=$row[0]>$row[1]</a></p>";
        }

      ?>
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