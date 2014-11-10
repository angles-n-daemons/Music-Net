<?php
  if (isset($_POST["deletecookie"])) {
    setcookie("username", "", time()-3600);
    unset($_COOKIE["username"]);
  }
  else if (isset($_POST["uid"]) && isset($_POST["password"]) && $_POST["uid"] != "" && $_POST["password"] != "") {
    $connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
    if ($connection->connect_errno) {
      echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
    }
/*    if (!$connection) {
      die ("Couldn't connect to mysql server!<br>The error was: " . mysql_error());
    }
    if (!mysql_select_db("adh")) { 
      die ("Couldn't select a database!<br> Error: " . mysql_error());
    }
*/
    $query = "SELECT username, password FROM Users WHERE login='" . $_POST["uid"] ."'";
/*    $result = mysql_query($query);
*/
	$result=$connection->query($query);
/*    if ($row = mysql_fetch_array($result)) {
*/ 
  if ($row = $result->fetch_array(MYSQLI_NUM)) {
      $name = $row[0];
      $pass = $row[1];
      if ($pass == $_POST["password"]) {
        setcookie("username", $name, time()+3600);
        $_COOKIE["username"] = $name;
      } else {
        echo '<div class="alert alert-danger alert-dismissable">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo 'Incorrect password.</div>';
        }
    } else {
      echo '<div class="alertalert-danger alert-dismissable">';
      echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      echo 'User not found.</div>';
    }
  }
  if (isset($_COOKIE["username"])) {
?>

<html>
<head>
<title>Authentication example</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

  <center>
  <p>Welcome, <?php echo $_COOKIE["username"]; ?>!</p>
  <form method="post" action="logintest.php">
	<a href="./search.php"><button type="button" class="btn btn-danger">Search</button></a>
    <input type="hidden" name="deletecookie">
    <button type="submit" class="btn btn-danger">Logout</button>
  </form>
  </center>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
  }
  else {
?>
<html>
<head>
<title>Authentication example</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

<form role="form" method="post" action="logintest.php" style="margin-left:auto; margin-right:auto; width:200px">

  <div class="form-group">
    <label for="uid">Account</label>
    <input type="text" class="form-control" name="uid" placeholder="Enter user-id">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
<?php
  }
?>

