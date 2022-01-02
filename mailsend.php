<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dubemail Anonymous Email</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
/* 
This is the segement of code that is used to send the email.
 */
$timestart = microtime();

unset($_POST['Submit']);

if (count($_POST) < 1)
	die('You need to fill out the fields! <br />You must access this script from <a href="index.php">here</a>');

#VALIDATION

$_POST['message'] = trim(htmlspecialchars($_POST['message']));

echo '<h3>Validate Form Fields</h3>';

function is_valid_email_address($email)
	{
	$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
	$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
	$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
		'\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
	$quoted_pair = '\\x5c[\\x00-\\x7f]';
	$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
	$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
	$domain_ref = $atom;
	$sub_domain = "($domain_ref|$domain_literal)";
	$word = "($atom|$quoted_string)";
	$domain = "$sub_domain(\\x2e$sub_domain)*";
	$local_part = "$word(\\x2e$word)*";
	$addr_spec = "$local_part\\x40$domain";
	
	return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
	}
	
function is_real_email_address($email)
	{
	$error = 0;
      $target = $email;
      $msg = ('<p><b>'._NQ_EMAIL_ALT.' '._NQ_RESULT.' [<a href="../../webroot/netquery/nquser.php?formtype=email">'._NQ_CLEAR.'</a>]:</b></p><p>');
      if ((preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $target)) || (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$target))) {
        $addmsg = "Format Check: Correct format.";
        $msg .= $addmsg;
        list ($username,$domain) = split ("@",$target,2);
        if (!$winsys || $dns_dig_enabled) {
          if (checkdnsrr($domain.'.', 'MX') ) $addmsg = "<br />DNS Record Check: MX record returned OK.";
          else if (checkdnsrr($domain.'.', 'A') ) $addmsg = "<br />DNS Record Check: A record returned OK.";
          else if (checkdnsrr($domain.'.', 'CNAME') ) $addmsg = "<br />DNS Record Check: CNAME record returned OK.";
          else 
		  	{
			$addmsg = "<br />DNS Record Check: DNS record not returned.)";
			$error++;
			}
          $msg .= $addmsg;
          if ($query_email_server) {
            if (getmxrr($domain, $mxhost))  {
              $address = $mxhost[0];
            } else {
              $address = $domain;
            }
            $addmsg = "<br />MX Server Address Check: Address accepted by ".$address;
            if (!$sock = @fsockopen($address, 25, $errnum, $error, 10)) {
              unset($sock);
              $addmsg = "<br />MX Server Address Check: Cannot connect to ".$address." (".$error.")";
            } else {
              if (ereg("^220", $out = fgets($sock, 1024))) {
                fputs ($sock, "HELO ".$_SERVER['HTTP_HOST']."\r\n");
                $out = fgets ( $sock, 1024 );
                fputs ($sock, "MAIL FROM: <{$target}>\r\n");
                $from = fgets ( $sock, 1024 );
                fputs ($sock, "RCPT TO: <{$target}>\r\n");
                $to = fgets ($sock, 1024);
                fputs ($sock, "QUIT\r\n");
                fclose($sock);
                if (!ereg ("^250", $from) || !ereg ( "^250", $to )) {
                	$addmsg = "<br />MX Server Address Check: Address rejected by ".$address;
					$error++;
                }
              } else {
              	$addmsg = "<br />MX Server Address Check: No response from ".$address;
				$error++;
              }
            }
            $msg .= $addmsg;
          }
        }
      } else {
        $addmsg = "Format check: Incorrect format.";
		$error++;
        $msg .= $addmsg;
      }
      $msg .= '<br /><hr /></p>';
      $results .= $msg;
		if ($error > 0)
			return $results;
		else
			return FALSE;
	}
#echo checkEmail('cjd@aertawtawetaertaertraet.com');
	

$errors = 0;
if(is_real_email_address($_POST['to']))
	{
	echo 'Your <strong>to</strong> address is invalid<br />';
	$errors++;
	}

if ($_POST['cc'])
	{
	if(is_real_email_address($_POST['cc']))
		{
		echo 'Your <strong>cc</strong> address is invalid<br />';
		$errors++;
		}
	}

if ($_POST['cc'])
	{
	if(is_real_email_address($_POST['bcc']))
		{
		echo 'Your <strong>bcc</strong> address is invalid<br />';
		$errors++;
		}
	}

if(!is_valid_email_address($_POST['from']))
	{
	echo 'Your <strong>from</strong> address is invalid<br />';
	$errors++;
	}

if(!eregi ('^[[:print:]].+$',$_POST['subject']))
	{
	echo 'Fix your <strong>subject</strong><br />';
	$errors++;
	}

if(!eregi ('^[[:print:]].+$',$_POST['message']))
	{
	echo 'Fix your <strong>message</strong><br />';
	$errors++;
	}


if ($errors>0)
	{
	die ("<br />There are <strong>$errors</strong> errors. Email addresses <strong>must be valid</strong> and may only have:<br /><ul>Characters A-Z</ul><ul>Characters a-z</ul><ul>These characters: +-_.</ul>" . '<strong>Please go <input type="button" value="Back" onclick="history.back()"> and fix these.</strong>');
	}
	else
		{
		echo 'Validation Passed!<br />';
		}

# Date: Tue, Mar 18 1997 14:36:14 PST
$showmessage = "Sending <strong>{$_POST['select']}</strong> copies of an email to <strong>{$_POST['to']}</strong> with a subject of <strong>{$_POST['subject']}</strong>. From <strong>{$_POST['from']}</strong>";
$headers='';
$headers .= "$xmailer\n";
$headers .= "X-Sender: {$_POST['from']}\n";
$headers .= "From: {$_POST['from']}\n";
$headers .= "Return-Path: {$_POST['from']}\n";
$headers .= "Reply-To: {$_POST['from']}\n";
$headers .= "Date: ".date("r")."\n";
if ($_POST['cc'])
	{
	$headers .= "Cc: {$_POST['cc']}\n";
	$showmessage .= ", CC <strong>{$_POST['cc']}</strong>";
	}
if ($_POST['bcc'])
	{
	$headers .= "Bcc: {$_POST['bcc']}\n";
	$showmessage .= ", BCC <strong>{$_POST['bcc']}</strong>";
	}
$showmessage .= ". The message follows:<br />";

$linedmessage = nl2br(htmlspecialchars($_POST['message']));
echo $showmessage."<table width='650' border='1' cellspacing='1' cellpadding='1'>
  <tr>
    <td bgcolor='#DDEEFF'><font face='Courier New, Courier, monospace'>$linedmessage</font></td>
  </tr>
</table>";


#SEND SECTION

echo '<h3>Attempting to Send:</h3><br />';
$runsleft = $_POST['select'];
while($runsleft > 0)
	{
	$mail = mail($_POST['to'],$_POST['subject'],$_POST['message'],$headers);
	if ($mail == FALSE)
		{
		die ("Error Sending, $runs sends left. You may have filled out the form wrong, or not.
		<input type='button' value='Back' onclick='history.back()'><br />");
		}
	echo "Sent, $runsleft sends left. <br />";
	$runsleft--;
	}



#MySQL logging part
#require(conf.php);

$mysqladdress = 'localhost';
$mysqldb = 'dubemail_mailscript';
$mysqlaccount = 'dubemail_maillog';
$mysqlpass = 'happy';
$tablename = "EmailSent";

$browser = $_SERVER['HTTP_USER_AGENT'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$datetime = date ('Y-m-d H:i:s');

$connect = mysqli_connect($mysqladdress,$mysqlaccount,$mysqlpass,$mysqldb);
if (!$connect)
	die("Could not connect to MySQL database");


$query = "INSERT INTO `EmailSent` 
(`ip` , `browser` , `datetime` , `to` , `cc` , `bcc` , `from` , `subject` , `runs` , `message` )
	VALUES ('$ipaddress', '$browser', NOW( ) , '{$_POST[to]}', '{$_POST[cc]}', '{$_POST[bcc]}', '{$_POST[from]}', '{$_POST[subject]}', '5{$_POST[runs]}', '{$_POST[message]}')";

$quer = mysqli_query($connect,$query);
if (!$quer)
	echo"<!--Could not add data to table.-->";
else 
	echo "<!--Data succesfully added to table.-->";


echo '</table><br />Done! <a href="index.php">Send another email</a> <br />';
$timeend = microtime();
$diff = number_format(((substr($timeend,0,9)) + (substr($timeend,-10)) - (substr($timestart,0,9)) - (substr($timestart,-10))),4);
echo "This took $diff s";
?>
</body>
</html>