<?php
  include_once("udpRequest.php");
  include_once("accessDatabase.php");

  error_reporting(E_ERROR);

  if(isset($_POST["ip_address"])) 
    $ip_Address=trim($_POST["ip_address"]);
  if(isset($_POST["udp_port"])) 
    $udp_Port=trim($_POST["udp_port"]);
  if(isset($_POST["tempval"]))
    $tempVal=trim($_POST["tempval"]);
  if(isset($_POST["device_name"]))
    $deviceName=trim($_POST["device_name"]);

  //echo "updateStatus.php: \$ip_address = $ip_Address, \$udp_Port = $udp_Port, \$deviceName = $deviceName,  \$tempVal=$tempVal<br />";
  
  //echo "\$upperTempc = $upperTempc, \$upperTempf = $upperTempf, \$upperDelay = $upperDelay<br />\$lowerTempc = $lowerTempc, \$lowerTempf = $lowerTempf, \$lowerDelay = $lowerDelay<br />";

  if(isset($_POST["setUpdate"]))
  {
    $in = "$setTempName$tempVal$deviceName\n";
    $udpStatus = udpRequest($ip_Address, $udp_Port, $in);
//    echo "$udpStatus<br />";
    $titleStr = "<h2><font color = \"red\">Temp$tempVal Name Updated</font></h2>";    
  }else{
    $titleStr = "<h2><font color = \"blue\">Modify Temp$tempVal Name</font></h2>";
  }
  
  $headStr =
    "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
    <html>
    <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">
    <title> Temperature Data </title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>
    <script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js\"></script>
    <!-- <script type=\"text/javascript\" src=\"js/jquery.js\"></script> -->
    <style>
    input[type='text'] { font-size: 18px; text-align: center;}
    input:focus, textarea:focus{background-color: lightgrey;}
    </style>
    </head>
      <body>";

  $headerStr =
  "
    <table height=\"250\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\">
      <tr>
        <td>
          <a href=\"http://".$_SERVER['HTTP_HOST']."/esp8266t/SensorStatus.php\">
            <img src=\"/images/ESP8266Net.png\" width=\"100%\" height=\"250\" border=\"0\" alt=\"logo\">
          </a>
        </td>
      </tr>
    </table>
  ";

  $bodyStr =
  "
  <!-- Table for Main Body -->
  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
    <tr>
      <td  align=\"center\" colspan=\"6\">
        <table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"2\">
          <tr>
            <td align=\"center\" border=\"2\" colspan=\"6\">
              $titleStr
            </td>
          </tr>
          </table>      
      </td>
    </tr>  
    <tr>
      <td align=\"center\" border=\"2\" colspan=\"6\">
        <form method=\"post\" action=\"modifySettings.php\">
         <input type=\"hidden\" name=\"ip_address\" value=\"".$ip_Address."\">
         <input type=\"hidden\" name=\"udp_port\" value=\"".$udp_Port."\">
         <input type=\"text\" size=\"10\" name=\"device_name\" value=\"$deviceName\">
         <input type=\"hidden\" name=\"setUpdate\" value=\"setUpdate\">
         <input type=\"hidden\" name=\"tempval\" value=\"$tempVal\">
         <input type=\"submit\" value=\"SAVE\">  
      </td>
    </tr>
  </table>
  ";

  $footStr =
    "
      </body>
      </html>
    ";
  echo "$headStr$headerStr$bodyStr$footStr";
?>
