<?
error_reporting(-1);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Istanbul');

include_once( "../Class/11_Control.php" );

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
// Tools
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string, $ini, $len);
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
// Connecting database
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
Control::ConnectDatabase();
Control::InitialiseSystem();

$errmsg = "";
$r_source = "NONE";
$rUSD = (float)System::$forex[0];
$rEUR = (float)System::$forex[1];;
$rGBP = (float)System::$forex[2];;

$rUSDold = $rUSD;
$rEURold = $rEUR;
$rGBPold = $rGBP;
// BEGIN XML FETCH
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
// http://themoneyconverter.com/rss-feed/TRY/rss.xml
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
$xml = file_get_contents("http://themoneyconverter.com/rss-feed/TRY/rss.xml");
if( strpos($xml, "<title>Exchange Rates For Turkish Lira</title>")	!== false
	&& strpos($xml, " United States Dollar</description>")			!== false
	&& strpos($xml, " Euro</description>")							!== false
	&& strpos($xml, " British Pound Sterling</description>")		!== false
)
{
	$r_source = "http://themoneyconverter.com/rss-feed/TRY/rss.xml";
	
	$rUSD = round(
		1/floatval(
			str_replace(",", "", 
				get_string_between(
					get_string_between(
						$xml, "<title>USD/TRY</title>", "</description>"
					), "1 Turkish Lira = ", " United States Dollar"
				)
			)
		), 2
	);
	
	$rEUR = round(
		1/floatval(
			str_replace(",", "", 
				get_string_between(
					get_string_between(
						$xml, "<title>EUR/TRY</title>", "</description>"
					), "1 Turkish Lira = ", " Euro"
				)
			)
		), 2
	);
	
	$rGBP = round(
		1/floatval(
			str_replace(",", "", 
				get_string_between(
					get_string_between(
						$xml, "<title>GBP/TRY</title>", "</description>"
					), "1 Turkish Lira = ", " British Pound Sterling"
				)
			)
		), 2
	);
}
else
{
	$errmsg .= "<span style='color:#A00;'>Couldn't reach any currency feed. Exchange rates are not updated!</span><br>";
}

System::$forex[0] = $rUSD;
System::$forex[1] = $rEUR;
System::$forex[2] = $rGBP;

if($errmsg == "") $errmsg .= "<span style='color:#0A0;'>All correct. No errors occured.</span><br>";

$r_mailbody = "<b>FEED SOURCE:</b> $r_source<br>
<br>
<u><b>OLD VALUES</b></u><br>
<b>\$ = </b>$rUSDold<br>
<b>€ = </b>$rEURold<br>
<b>£ = </b>$rGBPold<br>
<br>
<u><b>NEW VALUES</b></u><br>";
if($rUSD < $rUSDold) $r_mailbody .= "<b>\$ = <span style='color:#A00;'>$rUSD &#8595;</span></b><br>";
if($rUSD > $rUSDold) $r_mailbody .= "<b>\$ = <span style='color:#0A0;'>$rUSD &#8593;</span></b><br>";
if($rUSD == $rUSDold) $r_mailbody .= "<b>\$ = <span style='color:#00A;'>$rUSD &#8226;</span></b><br>";

if($rEUR < $rEURold) $r_mailbody .= "<b>€ = <span style='color:#A00;'>$rEUR &#8595;</span></b><br>";
if($rEUR > $rEURold) $r_mailbody .= "<b>€ = <span style='color:#0A0;'>$rEUR &#8593;</span></b><br>";
if($rEUR == $rEURold) $r_mailbody .= "<b>€ = <span style='color:#00A;'>$rEUR &#8226;</span></b><br>";

if($rGBP < $rGBPold) $r_mailbody .= "<b>£ = <span style='color:#A00;'>$rGBP &#8595;</span></b><br>";
if($rGBP > $rGBPold) $r_mailbody .= "<b>£ = <span style='color:#0A0;'>$rGBP &#8593;</span></b><br>";
if($rGBP == $rGBPold) $r_mailbody .= "<b>£ = <span style='color:#00A;'>$rGBP &#8226;</span></b><br>";

$r_mailbody .= "<br>
<b><u>STATUS</u><br>
$errmsg</b>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'To: Mahmut Akkus <yepisyenilmis@gmail.com>' . "\r\n";
$headers .= 'From: reception.secondhomehostel.com <sys'.mt_rand().mt_rand().'@secondhomehostel.com.com>' . "\r\n";
mail("", '-- CURRENCY UPDATE REPORT --', $r_mailbody, $headers);

Control::Conclude();
?>