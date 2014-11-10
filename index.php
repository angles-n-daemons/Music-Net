<html>
 <head>
  <title>Link Page</title>
 </head>
 <body>
 <?php 
$thefile = file('db.txt');
foreach($thefile as $line){
	echo '<p>' .$line.'</p>';
}
echo '<p><a href="./search.php"><button type="button">Click Me!</button></a></p>'; ?> 
 </body>
</html>