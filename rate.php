<?php
$data=$_POST['data'];
$parts=explode(':',$data);
$rating = $parts[2];
$login = $parts[1];
$sid = $parts[0];

$connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
}

$query = "SELECT login,rating FROM Rates WHERE login='".$login."'";
$result= $connection->query($query);
if($row=$result->fetch_array(MYSQLI_NUM)){
//If the user has rated this song, increment the rating count
$update = "UPDATE Rates SET Rates.rating='"./*rating value*/."' WHERE Rates.login='".$login."' AND Rates.sid='".$sid."'";
$connection->query($update);
//update average rating for this song
$update = "UPDATE Songstats SET Songstats.totalratings=((Songstats.totalratings)*(Songstats.avgrating)+'"./*rating value*/."')/(Songstats.totalratings+1) WHERE Songstats.sid='".$sid."'";
$connection->query($update);
//increment user's total ratings
$update = "UPDATE Users SET Users.totalratings=Users.totalratings+1 WHERE Users.login='".$login."'";
$connection->query($update);
}
else{
//if the user hasn't rated this song, add new row to Rates table, intialize to one rating
$insert = "INSERT INTO Rates (login,sid,rating) VALUES ('".$login."','".$sid."','"./*rating value*/."')";
//update average rating for this song
$update = "UPDATE Songstats SET Songstats.totalratings=((Songstats.totalratings)*(Songstats.avgrating)+'"./*rating value*/."')/(Songstats.totalratings+1) WHERE Songstats.sid='".$sid."'";
$connection->query($update);
//increment user's total ratings
$update = "UPDATE Users SET Users.totalratings=Users.totalratings+1 WHERE Users.login='".$login."'";
$connection->query($update);
}
?>