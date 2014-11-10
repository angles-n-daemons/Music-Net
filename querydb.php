<?php 
// Connect to DB
$connection = new mysqli("cs445sql", "jphogan", "EL011jph","adh");
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $mysqli->connect_error;
}

$count = 0;
$data=$_POST['data'];
$parts=explode(':',$data);

//$parts[0] is type of query
//$parts[1] is the string to match

// Generate query based on $parts[1]
$query = '';
if($parts[0] == 'Songs'){
	$query="SELECT S.sid,S.title,A.artid,A.artname FROM Songs S,Artists A WHERE A.artid=S.artid AND S.title LIKE '%".$parts[1]."%'";
	$result=$connection->query($query);
}
if($parts[0]=='Artists'){
	$query="SELECT Ar.artid,Ar.artname FROM Artists Ar WHERE Ar.artname LIKE '%".$parts[1]."%'";
	$result=$connection->query($query);
}
if($parts[0]=='Albums'){
	$query="SELECT Al.albid,Al.albname,Ar.artid,Ar.artname FROM Artists Ar,Albums Al WHERE Ar.artid=Al.artid AND Al.albname LIKE '%".$parts[1]."%'";
	$result=$connection->query($query);
}

// Query DB using $connection
$result=$connection->query($query);
while($row=$result->fetch_array(MYSQLI_NUM)){

	// Generate html for response
	if(strlen($row[1]) > 25){
			$row[1] = substr($row[1],0,22).'...';
	}
	if($parts[0] == 'Songs' && count($row) > 3){
		if(strlen($row[3]) > 35){
			$row[3] = substr($row[3],0,32).'...';
		}
		echo '<div class="col-lg-6"><h4>Title: <a href="/php-wrapper/adh/song.php?sid='.$row[0].'">'.$row[1].'</a></h4>';
		echo '<p>Artist: <a href="/php-wrapper/adh/artist.php?artid='.$row[2].'">'.$row[3].'</a></p></div>';
	}
	if($parts[0] == 'Artists'){
		echo '<div class="col-lg-6"><h4>Name: <a href="/php-wrapper/adh/artist.php?artid='.$row[0].'">'.$row[1].'</a></h4></div>';
	}
	if($parts[0] == 'Albums' && count($row) > 3){
		if(strlen($row[3]) > 35){
			$row[3] = substr($row[3],0,32).'...';
		}
		echo '<div class="col-lg-6"><h4><a href="/php-wrapper/adh/album.php?albid='.$row[0].'">Name: '.$row[1].'</a></h4>';
		echo '<p>Artist: <a href="/php-wrapper/adh/artist.php?artid='.$row[2].'">'.$row[3].'</a></p></div>';
	}

	// Increment count and return after 50 rows
	$count++;
	if($count > 49){
		break;
	}
}
?>