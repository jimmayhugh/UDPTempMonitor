<?php

  include_once("udpRequest.php");
  include_once("accessDatabase.php");


  $temp0Name = 0;
  $temp0Val  = 1;
  $temp1Name = 2;
  $temp1Val  = 3;
  $temp2Name = 4;
  $temp2Val  = 5;
  $temp3Name = 6;
  $temp3Val  = 7;

  if(isset($_POST["MODIFY"])) 
  {
    $ip_address=$_POST["ip_address"];
    $deviceName=$_POST["device_name"];
    $tempVal=$_POST["tempval"];
    
//      echo "updateStatus.php: \$ip_address = $ip_address, \$deviceName = $deviceName,  \$tempVal=$tempVal<br />";
  }

  $query = "SELECT * FROM `Addresses` WHERE 1";
//  echo "\$query = $query <br />";
  if($result = mysqli_query($link, $query))
  {
    $numAddresses = mysqli_num_rows($result);
//    printf("Select returned %d rows.\n", mysqli_num_rows($result));
  }

  $dataTimer = date("s");
  $setDebug = 0;

  for($x = 0; $x < $numAddresses; $x++)
  {
    $ipAddressObj = mysqli_fetch_object($result);
    $ip_Address = $ipAddressObj->ipAddress;
    $udp_Port = $ipAddressObj->udpPort;
//    echo "\$ip_Address = ".$ipAddressObj->ipAddress.", \$udp_Port = ".$ipAddressObj->udpPort."<br />";
    $in = $getStatus."\n";
    $udpStatus = udpRequest($ip_Address, $udp_Port, $in);
//    echo "\$udpStatus = ".$udpStatus."<br />";

    $udpType = explode(",", $udpStatus);
    $tempStr =
    "<div id=\"temp\"; position: relative; width: 100%>
       <td align=\"center\" width=\"20%\">
         <form method=\"post\" action=\"SensorStatus.php\">
           <input type=\"hidden\" name=\"ip_address\" value=\"".$ip_Address."\">
           <input type=\"hidden\" name=\"udp_port\" value=\"".$udp_Port."\">
           <input type=\"submit\" name=\"remove\" value=\"REMOVE\">
         </form>
         <font size=\"10\"><strong>".$ip_Address."</strong></font><br />
        </td>";
        
    for($udpCnt = 0; $udpCnt < 8; $udpCnt+=2)
    {
      $udpCnt0 = $udpCnt / 2;
      $udpCnt1 = $udpCnt+1;
      $tempStr .=
      "<td align=\"center\" width=\"20%\">
         <form method=\"post\" action=\"modifySettings.php\">
           <input type=\"hidden\" name=\"tempval\" value=\"$udpCnt0\">
           <input type=\"hidden\" name=\"ip_address\" value=\"$ip_Address\">
           <input type=\"hidden\" name=\"udp_port\" value=\"$udp_Port\">
           <input type=\"hidden\" name=\"device_name\" value=\"$udpType[$udpCnt]\">
           <input type=\"submit\" value=\"MODIFY\">
         </form>
         <font size=\"5\"><strong>$udpType[$udpCnt]</strong></font>
         <br />
         <font size=\"10\"><strong>".$udpType[$udpCnt1]."&deg;</strong></font>
         <form method=\"post\" action=\"plotData.php\">
           <input type=\"hidden\" name=\"ip_address\" value=\"$ip_Address\">
           <input type=\"hidden\" name=\"udp_port\" value=\"$udp_Port\">
           <input type=\"hidden\" name=\"device_name\" value=\"$udpType[$udpCnt]\">
           <input type=\"hidden\" name=\"temptype\" value=\"temp$udpCnt0\">
           <input type=\"submit\" value=\"GRAPH\">
         </form>
       </td>";
     }
    echo "<table width=\"100%\" align=\"center\" border=\"2\">\n<tr>\n$tempStr</tr>\n</table>";
    if($setDebug > 0)
      echo "\$dataTimer = $dataTimer\n";
    if($dataTimer == "00" || $dataTimer == "01")
    {
      $time = time("U");
      $switch1 = trim($udpType[2]);
      $switch2 = trim($udpType[3]);
      $insertQuery = "INSERT INTO device SET `ipaddress`=\"$ip_Address\",`port`=$udp_Port,`time`=$time,`temp0`=$udpType[$temp0Val],`temp1`=$udpType[$temp1Val],`temp2`=$udpType[$temp2Val],`temp3`=$udpType[$temp3Val]";
      if($setDebug != 0)
        echo $insertQuery."\n";
      $insertResult = mysqli_query($link, $insertQuery);
      if($insertResult === FALSE && $setDebug != 0)
      {
        echo "Data Insert Failed\n";
        printf("Error: %s\n", mysqli_error($link));
      }

      if($insertResult === TRUE && $setDebug != 0)
      {
        echo "Data Insert Success\n";
      }
      mysqli_free_result($insertResult);
    }
  }
/* free result set */
mysqli_free_result($result);
?>
