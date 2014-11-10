<?php 
$data=$_POST['data'];
$parts=explode(':',$data);
$login=$parts[1];
$sid=$parts[0];
$connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
}
$query = "SELECT login,count FROM Plays WHERE login='".$login."'";
$result= $connection->query($query);

if($row=$result->fetch_array(MYSQLI_NUM)){
//If the user has played this song, increment the play count
$update = "UPDATE Plays SET Plays.count=Plays.count+1 WHERE Plays.login='".$login."' AND Plays.sid='".$sid."'";
$connection->query($update);

//increment the total plays for this song
$update = "UPDATE Songstats SET Songstats.totalplays=Songstats.totalplays + 1 WHERE Songstats.sid='".$sid."'";
$connection->query($update);
//increment user's total plays
$update = "UPDATE Users SET Users.totalplays=Users.totalplays+1 WHERE Users.login='".$login."'";
$connection->query($update);
}
else{
//if the user hasn't played this song, add new row to Plays table, intialize to one play
$insert = "INSERT INTO Plays (login,sid,count) VALUES ('".$login."','".$sid."',1)";
//increment the total plays for this song
$update = "UPDATE Songstats SET Songstats.totalplays=Songstats.totalplays + 1 WHERE Songstats.sid='".$login."'";
$connection->query($update);
//increment user's total plays
$update = "UPDATE Users SET Users.totalplays=Users.totalplays+1 WHERE Users.login='".$sid."'";
$connection->query($update);
}

$colors = array('#FF0000','#00FF00','#FF00FF','#FFFF00','#00FFFF','#180000','0066FF','33CC33','669966','FF3399','FF3333');
$imagination = array('Woah what a great example of #', 'I love me some #', 'This is a mediocre attempt at #', 'This totally satisfies my need for #', 'Cant get enough of #',
	'This is the best ever #', 'Ill never get sick of #', '# makes me feel giddy inside', '# is what keeps me from quitting my job!', 'Let the # feel you with feelings of happiness',
	'Why isnt there more # like this?', 'Do you want to continue #ing your brainz out>','please give us a good grade...', 'What great developers our group is',
	'I hear michael jordan shares our love for #', 'I think ive listened to enough # today','let the # take over your soul','Vote # in the 2014 election');

shuffle($imagination);
shuffle($colors);

$update = "SELECT term FROM Describes WHERE sid='".$sid."' ORDER BY RAND() LIMIT 4";
$result=$connection->query($update);

$count=0;
echo '<p>&nbsp;</p>';
while($row=$result->fetch_array(MYSQLI_NUM)){
	echo '<p><font color="'.$colors[$count].'">'.str_replace('#',$row[0],$imagination[$count]).'</font></p>';
	$count++;
}
echo '<p>&nbsp;</p>';

?>