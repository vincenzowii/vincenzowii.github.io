<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dube Mail Script View Message page</title>
<link href="malistyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

  #FIGURING OUT THE TOTAL TIME
$timestart = microtime();
$mysqladdress = 'localhost';
$mysqldb = 'dubemail_mailscript';
$mysqlaccount = 'dubemail_maillog';
$mysqlpass = 'happy';
$tablename = "EmailSent";

$connect = mysqli_connect($mysqladdress,$mysqlaccount,$mysqlpass,$mysqldb) or die("Could not connect to MySQL database");

echo "<h1>BIG BROTHER IS WATCHING (The log page) | <a href='index.php'>Send An email</a></h1>";


switch ($_GET['do'])
{
case 'viewmessage':

if (!is_numeric($_GET['id']) )
	die('bad id');

$data = mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM `EmailSent` WHERE `id` = {$_GET['id']} LIMIT 1"));
echo "
<form action='../webroot/netquery/nquser.php' method='post'><strong>IP: </strong><input type='hidden' name='querytype' value='whoisip' /><input type='text' name='host' id='host' value='{$data['ip']}' size='13' maxlength='15' /><input type='submit' value='Whois?' /></form>
<strong>To:</strong> {$data['to']}<br />
<strong>CC:</strong> {$data['cc']}<br />
<strong>BCC:</strong> <{$data['bcc']}br />
<strong>From:</strong> {$data['from']}<br />
<strong>Date:</strong> {$data['datetime']}<br />
<strong>Sends:</strong> {$data['runs']}<br />
<strong>Subject:</strong> {$data['subject']}<br /><br />

Message Follows:<br />";
echo "<table width='650' border='1' cellspacing='1' cellpadding='1'>
  <tr>
    <td bgcolor='#DDEEFF'><font face='Courier New, Courier, monospace'>" . nl2br(htmlspecialchars($data['message'])) . "</font></td></tr>
</table>

<a href='admin.php#r{$data['id']}'>Go back</a>";

break;

default:
#SOME STATS
#syntax:  $var = mysql_fetch_array(mysql_query(''));

echo "<h3>Stats</h3>";
$num_rows = mysqli_num_rows(mysqli_query($connect,'SELECT * FROM EmailSent'));		#SOME STATISTICS USING SQL's MATH
$tot_email = mysqli_fetch_array(mysqli_query($connect,'SELECT SUM(`runs`) FROM EmailSent'));
$avg_send_per_use = mysqli_fetch_array(mysqli_query($connect,'SELECT AVG( `runs` ) FROM `EmailSent`'));
$distinct_ip = mysqli_fetch_array(mysqli_query($connect,'SELECT COUNT(DISTINCT(`ip`)) FROM EmailSent'));

echo "
<ul>
  <li>The script has ben used <strong>$num_rows</strong> times. </li>
  <li> A total of <strong>$tot_email[0]</strong> emails have been sent. (This is the sum of the number of sends.)</li>
  <li>For every use of the script, an average of <strong>$avg_send_per_use[0]</strong> sends have been made.</li>
  <li> There have been sends by <strong>$distinct_ip[0]</strong> different (distinct) IP addresses. </li>
</ul><br />
<br />
Hint: to go to a specific message that you know the id of, go to <a href='http://dubemail.com/mail/admin.php#r354'>http://dubemail.com/mail/admin.php#r[id]</a>";

#ALL THE DATA
#The header row for the table
echo "
<table width='100%' border='0' class='smalltable'>
<tr>
	
	<th scope='col'>id</th>
	<th scope='col'>to</th>
	<th scope='col'>cc</th>
	<th scope='col'>bcc</th>
	<th scope='col'>from</th>
	<th scope='col'>subject</th>
	<th scope='col'>message</th>
	<th scope='col'>runs</th>
	<th scope='col' width='100'>ip</th>
	<th scope='col'>datetime</th>
	<th scope='col'>os</th>
	<th scope='col'>browser</th>
</tr>";
#does the while loop for each row
include_once('../browser.php');
$bgcolorswitch = "<tr bgcolor='#EEEEEE'>";

$all = mysqli_query($connect,"SELECT * FROM EmailSent ORDER BY `id` DESC");
$i = $num_rows;
while ($data = mysqli_fetch_array($all))
	{
	$data['to'] = htmlspecialchars( $data['to'] );
	$data['cc'] = htmlspecialchars( $data['cc'] );
	$data['bcc'] = htmlspecialchars( $data['bcc'] );
	$data['from'] = htmlspecialchars( $data['from'] );
	$data['subject'] =  htmlspecialchars( $data['subject'] );
	$data['message'] = htmlspecialchars( $data['message'] );
	$br = new browser($data['browser']);
	if ($bgcolorswitch == "<tr bgcolor='#EEEEEE'>")
		{
		echo $bgcolorswitch;
		$bgcolorswitch = "<tr bgcolor='#FFFFFF'>";
		}
	else
		{
		echo "<tr bgcolor='#FFFFFF'>";
		$bgcolorswitch = "<tr bgcolor='#EEEEEE'>";
		}
	
	echo "

	<td><a name='{$data['id']}' id='r{$data['id']}'></a>{$data['id']}</td>
	<td>{$data['to']}</td>
	<td>{$data['cc']}</td>
	<td>{$data['bcc']}</td>
	<td>{$data['from']}</td>
	<td>{$data['subject']}</td>
	<td>";
	if ( strlen($data['message']) > 32 )
		{
		echo"
	<a href='admin.php?do=viewmessage&amp;id={$data[id]}'>Click to open</a>";
		}
	else
		{
		echo $data['message'];
		}
	echo"</td>
	<td>{$data['runs']}</td>
	<td><form action='../webroot/netquery/nquser.php' method='post'><input type='hidden' name='querytype' value='whoisip' /><input type='hidden' name='host' value='{$data['ip']}' size='13' maxlength='15' /><input type='submit' value='{$data['ip']}' /></form></td>
	<td>{$data['datetime']}</td>
	<td>$br->Platform</td>
	<td>$br->Name version $br->Version</td>
</tr>
		";
	
	$i--;
	}

/* 
$i = 1;
while ($i <= $num_rows)
	{
	$query = mysql_query("SELECT * FROM EmailSent WHERE `id` = '$i'");
	$data = mysql_fetch_row($query);
	#echoes out the array into each column (in each row) */

echo '</table>';
echo '<br />Done!';
break;
}
$timeend = microtime();
$diff = number_format(((substr($timeend,0,9)) + (substr($timeend,-10)) - (substr($timestart,0,9)) - (substr($timestart,-10))),4);
echo "<br /><br /><small>script generation took $diff s </small>";
?>
<p>
    <a href="http://validator.w3.org/check?verbose=1&amp;uri=http%3A%2F%2Fdubemail.com%2Fmail%2Fadmin.php"><img
        src="../valid-xhtml10.png"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  </p>
</body>
</html>
