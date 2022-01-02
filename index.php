<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>Dubemail Anonymous Email</title>
<link href='../style.css' rel='stylesheet' type='text/css' />
</head>

<body>
<h1><a href="../index.php">Dubemail</a> Anonymous Email Script <img src="help.gif" alt="help" width="24" height="24" longdesc="help.php" onclick="window.open('help.php','Help','scrollbars=yes,resizable=yes,width=500,height=600')" /></h1>

<form method='post' action='mailsend.php' >
  <p>To:
    <input name='to' type='text' size='50' maxlength='100' />
    *
    <br />
    CC: 
    <input name='cc' type='text' size='50' maxlength='100' />
    <br />
  BCC: 
  <input name='bcc' type='text' size='50' maxlength='100' />
  </p>
  <p>From: 
    <input name='from' type='text' size='50' maxlength='100' />
  *</p>
  <p>Subect: 
    <input name='subject' type='text' size='50' maxlength='100' />
  *</p>
  <p>Message:<br />
    <textarea name='message' cols='70' rows='15' ></textarea>
  *</p>
  <p>Number of sends: 
    <select name='select'>
      <option value='1'>1</option>
	  <option value='2'>2</option>
	  <option value='3'>3</option>
	  <option value='4'>4</option>
	  <option value='5'>5</option>
	  <option value='6'>6</option>
	  <option value='7'>7</option>
	  <option value='8'>8</option>
	  <option value='9'>9</option>
    </select>
  *</p>
  <p>
    <input type='submit' name='Submit' value='Send' />
    <input type='reset' name='reset' value='Reset' />
  </p>
</form>
<p>* = Required </p>
<hr />
<p>
  <script type="text/javascript"><!--
google_ad_client = "pub-9451443632331166";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text";
google_ad_channel ="";
google_color_border = "CCCCCC";
google_color_bg = "FFFFFF";
google_color_link = "000000";
google_color_url = "666666";
google_color_text = "333333";
//--></script>
  <script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p>
<!--<p><a href="http://validator.w3.org/check?verbose=1&amp;uri=http://dubemail.com/mail/index.php"><img src="../valid-xhtml10.png" alt="Valid XHTML 1.0 Transitional" width="88" height="31" border="0" /></a></p> -->
</body>
</html>
