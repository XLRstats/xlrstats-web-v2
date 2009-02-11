<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
" ?>
<countrydata>

<state id="default_color"><color>000000</color></state>
<state id="background_color"><color>333333</color></state>
<state id="outline_color"><color>404040</color></state>
<state id="default_point"><color>00ff00</color></state>
<state id="scale_points"><data>50</data></state>

<state id="zoom_out_button">
	<name>Zoom Out</name>
	<data>SE</data>
	<font_size>12</font_size>
	<font_color>00cc00</font_color>
	<background_color>000000</background_color>
</state>

<?php
  include("../geoipcity.inc");
  include("geoipregionvars.php");
  include('../../func-globallogic.php');
  include('../../func-playerlistlogic.php');

  // If statsconfig.php exists, we won't enable multiconfig functionality
  if (file_exists("../../config/statsconfig.php"))
  {
    $currentconfig = "../../config/statsconfig.php";
    $currentconfignumber = 0;
  }
  elseif (file_exists("../../config/statsconfig1.php"))
  {
    $currentconfig = "../../config/statsconfig1.php";
    $currentconfignumber = 1;
    // Was a config set in the url?
    if (isset($_GET['config'])) 
    {
      $currentconfignumber = escape_string($_GET['config']);
      $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
      $_SESSION['currentconfignumber'] = $currentconfignumber;
    }
    if (isset($_SESSION['currentconfignumber']))
    {
      $currentconfignumber = $_SESSION['currentconfignumber'];
      $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
    }
  }
  require_once($currentconfig);
  //echo $_SESSION['currentconfignumber'];
  //include('../config/statsconfig.php');
  
  $clients = array();
  loadSimpleData();
  
  $geocity = $geoip_path."GeoLiteCity.dat";
  $gi = geoip_open($geocity,GEOIP_STANDARD);
  foreach($clients as $client)
  {
    if ($client -> level == "BOT")
    {
      $tip = explode(":", $public_ip);
      $ip = $tip[0];
    }
    else
      $ip = $client -> ip;
    $playername = htmlspecialchars(utf2iso($client -> name));

    $record = geoip_record_by_addr($gi,$ip);
    $latitude = $record->latitude;
    $longitude = $record->longitude;
    $cityname = utf8_decode($record->city);
    $region = utf8_decode($GEOIP_REGION_NAME[$record->country_code][$record->region]);
    $country = utf8_decode($record->country_name);

    //$results = file_get_contents("http://api.hostip.info/get_html.php?ip=$ip&position=true"); //catch errors later
    //parse response
    //preg_match('/Latitude: (.*)/', $results, $lat);
    //preg_match('/City: (.*)/', $results, $city);
    //preg_match('/Longitude: (.*)/', $results, $lon);
    
    //printf("<state id=\"point\"><loc>%s,%s</loc><name>%s</name><size>%s</size><opacity>%s</opacity></state>\n", $row[0], $row[1], utf8_encode($row[2]), round($diameter,2), round($calculated_opacity,2) );
    $diameter = 3;
    $opacity = 75;
    //printf("<state id=\"point\"><loc>%s,%s</loc><name>%s</name><hover>$playername , $ip</hover><size>%s</size><opacity>%s</opacity></state>\n", $lat[1], $lon[1], $city[1], $diameter, $opacity );
    printf("<state id=\"point\"><loc>$latitude,$longitude</loc><name>$cityname, ($region) $country</name><hover>Playername: $playername</hover><size>$diameter</size><opacity>$opacity</opacity></state>\n");
  }
  geoip_close($gi);
?>

<state id="AF"><name>Afghanistan</name></state>
<state id="AL"><name>Albania</name></state>
<state id="AG"><name>Algeria</name></state>
<state id="AN"><name>Andorra</name></state>
<state id="AO"><name>Angola</name></state>
<state id="AC"><name>Antigua and Barbuda</name></state>
<state id="AR"><name>Argentina</name></state>
<state id="AM"><name>Armenia</name></state>
<state id="AA"><name>Aruba</name></state>
<state id="AS"><name>Australia</name></state>
<state id="AU"><name>Austria</name></state>
<state id="AJ"><name>Azerbaijan</name></state>
<state id="BF"><name>The Bahamas</name></state>
<state id="BA"><name>Bahrain</name></state>
<state id="FQ"><name>Baker Island</name></state>
<state id="BG"><name>Bangladesh</name></state>
<state id="BB"><name>Barbados</name></state>
<state id="BO"><name>Belarus</name></state>
<state id="BE"><name>Belgium</name></state>
<state id="BH"><name>Belize</name></state>
<state id="BN"><name>Benin</name></state>
<state id="BD"><name>Bermuda</name></state>
<state id="BT"><name>Bhutan</name></state>
<state id="BL"><name>Bolivia</name></state>
<state id="BK"><name>Bosnia and Herzegovina</name></state>
<state id="BC"><name>Botswana</name></state>
<state id="BV"><name>Bouvet Island</name></state>
<state id="BR"><name>Brazil</name></state>
<state id="IO"><name>British Indian Ocean Territory</name></state>
<state id="VI"><name>British Virgin Islands</name></state>
<state id="BX"><name>Brunei</name></state>
<state id="BU"><name>Bulgaria</name></state>
<state id="UV"><name>Burkina Faso</name></state>
<state id="BY"><name>Burundi</name></state>
<state id="CB"><name>Cambodia</name></state>
<state id="CM"><name>Cameroon</name></state>
<state id="CA"><name>Canada</name></state>
<state id="CV"><name>Cape Verde</name></state>
<state id="CJ"><name>Cayman Islands</name></state>
<state id="CT"><name>Central African Republic</name></state>
<state id="CD"><name>Chad</name></state>
<state id="CI"><name>Chile</name></state>
<state id="CH"><name>China</name></state>
<state id="CO"><name>Colombia</name></state>
<state id="CN"><name>Comoros</name></state>
<state id="CF"><name>Congo</name></state>
<state id="CW"><name>Cook Islands</name></state>
<state id="CS"><name>Costa Rica</name></state>
<state id="IV"><name>Cote d'Ivoire</name></state>
<state id="HR"><name>Croatia</name></state>
<state id="CU"><name>Cuba</name></state>
<state id="CY"><name>Cyprus</name></state>
<state id="EZ"><name>Czech Republic</name></state>
<state id="CG"><name>Democratic Republic of the Congo</name></state>
<state id="DA"><name>Denmark</name></state>
<state id="DJ"><name>Djibouti</name></state>
<state id="DO"><name>Dominica</name></state>
<state id="DR"><name>Dominican Republic</name></state>
<state id="EC"><name>Ecuador</name></state>
<state id="EG"><name>Egypt</name></state>
<state id="ES"><name>El Salvador</name></state>
<state id="EK"><name>Equatorial Guinea</name></state>
<state id="ER"><name>Eritrea</name></state>
<state id="EN"><name>Estonia</name></state>
<state id="ET"><name>Ethiopia</name></state>
<state id="FK"><name>Falkland Islands (Islas Malvinas)</name></state>
<state id="FO"><name>Faroe Islands</name></state>
<state id="FM"><name>Federated States of Micronesia</name></state>
<state id="FJ"><name>Fiji</name></state>
<state id="FI"><name>Finland</name></state>
<state id="FR"><name>France</name></state>
<state id="FG"><name>French Guiana</name></state>
<state id="FP"><name>French Polynesia</name></state>
<state id="GB"><name>Gabon</name></state>
<state id="GA"><name>The Gambia</name></state>
<state id="GG"><name>Georgia</name></state>
<state id="GM"><name>Germany</name></state>
<state id="GH"><name>Ghana</name></state>
<state id="GI"><name>Gibraltar</name></state>
<state id="GO"><name>Glorioso Islands</name></state>
<state id="GR"><name>Greece</name></state>
<state id="GL"><name>Greenland</name></state>
<state id="GJ"><name>Grenada</name></state>
<state id="GP"><name>Guadeloupe</name></state>
<state id="GQ"><name>Guam</name></state>
<state id="GT"><name>Guatemala</name></state>
<state id="GK"><name>Guernsey</name></state>
<state id="PU"><name>Guinea-Bissau</name></state>
<state id="GV"><name>Guinea</name></state>
<state id="GY"><name>Guyana</name></state>
<state id="HA"><name>Haiti</name></state>
<state id="HM"><name>Heard Island &amp; McDonald Islands</name></state>
<state id="HO"><name>Honduras</name></state>
<state id="HU"><name>Hungary</name></state>
<state id="IC"><name>Iceland</name></state>
<state id="IN"><name>India</name></state>
<state id="IO"><name>British Indian Ocean Territory</name></state>
<state id="ID"><name>Indonesia</name></state>
<state id="IR"><name>Iran</name></state>
<state id="IZ"><name>Iraq</name></state>
<state id="EI"><name>Ireland</name></state>
<state id="IM"><name>Isle of Man</name></state>
<state id="IS"><name>Israel</name></state>
<state id="GZ"><name>Palestinian Authority</name></state>
<state id="IT"><name>Italy</name></state>
<state id="JM"><name>Jamaica</name></state>
<state id="JN"><name>Jan Mayen</name></state>
<state id="JA"><name>Japan</name></state>
<state id="DQ"><name>Jarvis Island</name></state>
<state id="JE"><name>Jersey</name></state>
<state id="JQ"><name>Johnston Atoll</name></state>
<state id="JO"><name>Jordan</name></state>
<state id="JU"><name>Juan De Nova Island</name></state>
<state id="KZ"><name>Kazakhstan</name></state>
<state id="KE"><name>Kenya</name></state>
<state id="KR"><name>Kiribati</name></state>
<state id="KS"><name>South Korea</name></state>
<state id="KU"><name>Kuwait</name></state>
<state id="KG"><name>Kyrgyzstan</name></state>
<state id="LA"><name>Laos</name></state>
<state id="LG"><name>Latvia</name></state>
<state id="LE"><name>Lebanon</name></state>
<state id="LT"><name>Lesotho</name></state>
<state id="LI"><name>Liberia</name></state>
<state id="LY"><name>Libya</name></state>
<state id="LS"><name>Liechtenstein</name></state>
<state id="LH"><name>Lithuania</name></state>
<state id="LU"><name>Luxembourg</name></state>
<state id="MC"><name>Macau</name></state>
<state id="MK"><name>Macedonia</name></state>
<state id="MA"><name>Madagascar</name></state>
<state id="MI"><name>Malawi</name></state>
<state id="MY"><name>Malaysia</name></state>
<state id="MV"><name>Maldives</name></state>
<state id="ML"><name>Mali</name></state>
<state id="MT"><name>Malta</name></state>
<state id="RM"><name>Marshall Islands</name></state>
<state id="MB"><name>Martinique</name></state>
<state id="MR"><name>Mauritania</name></state>
<state id="MP"><name>Mauritius</name></state>
<state id="MF"><name>Mayotte</name></state>
<state id="MX"><name>Mexico</name></state>
<state id="MQ"><name>Midway Islands</name></state>
<state id="MD"><name>Moldova</name></state>
<state id="MN"><name>Monaco</name></state>
<state id="MG"><name>Mongolia</name></state>
<state id="MH"><name>Montserrat</name></state>
<state id="MO"><name>Morocco</name></state>
<state id="MZ"><name>Mozambique</name></state>
<state id="BM"><name>Myanmar (Burma)</name></state>
<state id="WA"><name>Namibia</name></state>
<state id="NR"><name>Nauru</name></state>
<state id="NP"><name>Nepal</name></state>
<state id="NT"><name>Netherlands Antilles</name></state>
<state id="NL"><name>Netherlands</name></state>
<state id="NC"><name>New Caledonia</name></state>
<state id="NZ"><name>New Zealand</name></state>
<state id="NU"><name>Nicaragua</name></state>
<state id="NG"><name>Niger</name></state>
<state id="NI"><name>Nigeria</name></state>
<state id="NE"><name>Niue</name></state>
<state id="NF"><name>Norfolk Island</name></state>
<state id="KN"><name>North Korea</name></state>
<state id="CQ"><name>Northern Mariana Islands</name></state>
<state id="NO"><name>Norway</name></state>
<state id="MU"><name>Oman</name></state>
<state id="PS"><name>Pacific Islands (Palau)</name></state>
<state id="PK"><name>Pakistan</name></state>
<state id="PM"><name>Panama</name></state>
<state id="PP"><name>Papua New Guinea</name></state>
<state id="PA"><name>Paraguay</name></state>
<state id="PE"><name>Peru</name></state>
<state id="RP"><name>Philippines</name></state>
<state id="PL"><name>Poland</name></state>
<state id="PO"><name>Portugal</name></state>
<state id="RQ"><name>Puerto Rico</name></state>
<state id="QA"><name>Qatar</name></state>
<state id="RE"><name>Reunion</name></state>
<state id="RO"><name>Romania</name></state>
<state id="RS"><name>Russia</name></state>
<state id="RW"><name>Rwanda</name></state>
<state id="SM"><name>San Marino</name></state>
<state id="TP"><name>Sao Tome and Principe</name></state>
<state id="SA"><name>Saudi Arabia</name></state>
<state id="SG"><name>Senegal</name></state>
<state id="KV"><name>Kosovo</name></state>
<state id="MW"><name>Montenegro</name></state>
<state id="SR"><name>Serbia</name></state>
<state id="SE"><name>Seychelles</name></state>
<state id="SL"><name>Sierra Leone</name></state>
<state id="SN"><name>Singapore</name></state>
<state id="LO"><name>Slovakia</name></state>
<state id="SI"><name>Slovenia</name></state>
<state id="BP"><name>Solomon Islands</name></state>
<state id="SO"><name>Somalia</name></state>
<state id="SF"><name>South Africa</name></state>
<state id="SX"><name>South Georgia and the South Sandwich Is</name></state>
<state id="SP"><name>Madrid</name></state>
<state id="SP"><name>Spain</name></state>
<state id="PG"><name>Spratly Islands</name></state>
<state id="CE"><name>Sri Lanka</name></state>
<state id="SC"><name>St. Kitts and Nevis</name></state>
<state id="ST"><name>St. Lucia</name></state>
<state id="SB"><name>St. Pierre and Miquelon</name></state>
<state id="VC"><name>St. Vincent and the Grenadines</name></state>
<state id="SU"><name>Sudan</name></state>
<state id="NS"><name>Suriname</name></state>
<state id="SV"><name>Svalbard</name></state>
<state id="WZ"><name>Swaziland</name></state>
<state id="SW"><name>Sweden</name></state>
<state id="SZ"><name>Switzerland</name></state>
<state id="SY"><name>Syria</name></state>
<state id="TE"><name>East Timor</name></state>
<state id="TW"><name>Taiwan</name></state>
<state id="TI"><name>Tajikistan</name></state>
<state id="TZ"><name>United Republic of Tanzania</name></state>
<state id="TH"><name>Thailand</name></state>
<state id="TO"><name>Togo</name></state>
<state id="TL"><name>Tokelau</name></state>
<state id="TN"><name>Tonga</name></state>
<state id="TD"><name>Trinidad and Tobago</name></state>
<state id="TS"><name>Tunisia</name></state>
<state id="TU"><name>Turkey</name></state>
<state id="TX"><name>Turkmenistan</name></state>
<state id="TK"><name>Turks and Caicos Islands</name></state>
<state id="TV"><name>Tuvalu</name></state>
<state id="UG"><name>Uganda</name></state>
<state id="UP"><name>Ukraine</name></state>
<state id="TC"><name>United Arab Emirates</name></state>
<state id="UK"><name>United Kingdom</name></state>
<state id="US"><name>United States</name></state>
<state id="UY"><name>Uruguay</name></state>
<state id="UZ"><name>Uzbekistan</name></state>
<state id="NH"><name>Vanuatu</name></state>
<state id="VE"><name>Venezuela</name></state>
<state id="VM"><name>Vietnam</name></state>
<state id="WQ"><name>Wake Island</name></state>
<state id="WI"><name>Western Sahara</name></state>
<state id="WS"><name>Western Samoa</name></state>
<state id="YM"><name>Yemen</name></state>
<state id="ZA"><name>Zambia</name></state>
<state id="ZI"><name>Zimbabwe</name></state>
</countrydata>
