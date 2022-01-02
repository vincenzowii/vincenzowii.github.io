<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>Untitled Document</title>
</head>

<body>
<h1 align='center'>Mail Script First Time Setup</h1>
<?php 

switch($_POST['do'])
{
case 'step2':
$hostname = $_POST['hostname'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];

echo 'Trying to connect to the database:<br>';

$connection = mysqli_connect($hostname,$username,$password,$database);
if (!$connection)
{
die('<strong><br>Please check the MySQL form on the last page</strong>
 Please make sure the database is set up. Error:<br />');
}
echo 'Yay! The server has been connected to, and the database selected.<br><hr>';


#install, step 2

$sql = "CREATE TABLE `$database`.`EmailSent2` (
`id` int( 7 ) unsigned NOT NULL AUTO_INCREMENT ,
`ip` varchar( 16 ) NOT NULL ,
`browser` varchar( 200 )  NULL ,
`datetime` datetime NOT NULL,
`to` varchar( 80 ) NOT NULL ,
`cc` varchar( 80 )  NULL ,
`bcc` varchar( 80 )  NULL ,
`from` varchar( 80 ) NOT NULL ,
`subject` varchar( 30 ) NOT NULL ,
`runs` int( 1 ) unsigned NOT NULL ,
`message` text NOT NULL ,
PRIMARY KEY ( `id` ) 
)" ;


echo 'The following SQL query is being performed:';
echo '<br><form>
  <textarea name="" cols="40" rows="20">' . $sql . '</textarea>
</form>';

$query = mysqli_query($connection,$sql);
if (!$query)
	die("Could not perforrm the query.");

#Adding stuff to conf.php


@ $chmod = chmod("conf.php", 0777); 
	@ $fp = fopen("conf.php", 'w');

	if (!$fp)
	{
		die("Could not open the configuration file");
	}
echo 'The chmod has been done!, set to 777, so that the server only can access it.<br>';


$text = '<?php ' . '; $xmailer = ' . "'$hostname'" .  '$mysqladdress = ' . "'$hostname'" . '; $mysqldb = ' . "'$database'" . '; $mysqlaccount = ' . "'$username'" . '; $mysqlpass = ' . "'$password'" . ';  ?>';
echo $text;

	if(fwrite($fp, $text))
	{
		echo "conf.php Successfully Created<br/>";
	}
	else
	{
		die("conf.php is not successfully created. Try CHMODDING it to 600");
	}
	fclose($fp);



echo "Yay - the table has been set up.<br><ul>Try sending mail by going to the send page at <a href=\"script.php\">script.php</a>.<br>You can access the admin and view emails at <a href=\"admin.php\">admin.php</a></ul>";

$delete = unlink("nstall.php");
if ($delete)
	{
	echo 'Files deleted succesfully.  <a href="index.php">Test your script</a>';
	}
else
	{
	echo 'Can not delete these files.  You need to delete nstall.php manually';
	}
break;

default:
echo "
<form action='#' method='post'>
  <p>MySQL Username: 
    <input type='text' name='username' />
  </p>
  <p>MySQL Password:
    <input type='text' name='password' />
  </p>
  <p>MySQL Database:
    <input type='text' name='database' /> (Already created)
  </p>
  <p>
    <label>Hostname of server running MySQL:
    <input name='hostname' type='text' value='localhost' />
    </label>
  </p>
  <p>
    <label>X-Mailer: 
	<input type='text' name='username' /> (The name of your anonymous mailer)
	</label>
  </p>
  <p>
  	<input name='do' type='hidden' value='step2'>
    <input name='submit' type='submit' value='Submit' />
    <input name='reset' type='reset' value='Reset' />
  </p>
</form>";
break;
}

?>
<br />
<strong>!DELETE THIS FILE WHEN YOU ARE DONE WITH IT</strong>
</body>
</html>
