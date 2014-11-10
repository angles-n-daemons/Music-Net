<html>
<head>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<script>
$(document).ready(function() {
  $("#search-button").on('click', function() {
    var input = $("#searchinput").val();
    search(input);
  });
});

function search(str)
{
  // If string empty, exit function
  if(!str){
    return;
  }
  // Board represents query type
  board = 0;
  if($('#radios-0').is(':checked')){
    board = 'Songs';
  }
  if($('#radios-1').is(':checked')){
    board = 'Artists';
  }
  if($('#radios-2').is(':checked')){
    board = 'Albums';
  }
  $.ajax({
    // Query DB for 50 Results
    type: 'POST',
    url: 'querydb.php',
    data: {data:board+':'+str.replace(':','')},
    success: function(response) {
      console.log(response);
      // Append results to marketing
      $('.marketing').empty();
      $('.marketing').append(response);
      // Adjust type
      $('.type').empty();
      $('.type').append(board+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    },
    error: function(response) {
      console.log(arguments);
      $('.marketing').append('lnions');
    }
  });
}
</script>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Music-Net: Search</title>

    <!-- Bootstrap core CSS -->

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

.type{
  text-align: center;
  color: #66FFFF;
  font-size: 200%;
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

</head>
<body>

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->




<div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="/php-wrapper/adh/search_page.php">Home</a></li>
          <li><a href="/php-wrapper/adh/logintest.php">Login/Out</a>
        </li>
        </ul>
        <h3 class="text-muted">Music-Net</h3>
      </div>

      <div id="jumbo" class="jumbotron">
        <!-- Multiple Radios -->
        <?php
        if(isset($_COOKIE["admin"])){
          if($_COOKIE["admin"]>0){
            echo '<a href="./admin_injector.php"><button type="button">Admin</button></a>';
          }
        }
        ?>
        <h1>Ear Candy Engine</h1>
        <div class="control-group">
          <label class="control-label" for="radios"></label>
          <div class="controls">
            <label class="radio" for="radios-0">
              <input type="radio" name="radios" id="radios-0" value="Song" checked="checked">
              Song
            </label>
            <label class="radio" for="radios-1">
              <input type="radio" name="radios" id="radios-1" value="Artist">
              Artist
            </label>
            <label class="radio" for="radios-2">
              <input type="radio" name="radios" id="radios-2" value="Album">
              Album
            </label>
          </div>
        </div>

        <!-- Search input-->
        <div class="control-group">
          <label class="control-label" for="searchinput"></label>
          <div class="controls">
            <input id="searchinput" name="searchinput" type="text" placeholder="search for" class="input-xlarge search-query">
            
          </div>
        </div>
        <br>
        <!-- Button -->
        <div class="control-group">
          <label class="control-label" for="singlebutton"></label>
        <button id="search-button" type="button" name="singlebutton" class="btn btn-primary">Search</button>
        </div>
      </div>
      <div class="type"></div>
      <div class="row marketing">

      </div>
      <div class="footer">
        <p>&copy; Information Systems</p>
      </div>

    </div>

</fieldset>
</form>
</body>
</html>