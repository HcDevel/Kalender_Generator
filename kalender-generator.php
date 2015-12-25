<?php
if (isset($_GET["jahr"]) and isset($_GET["start_monat"]) and isset($_GET["ende_monat"]) and isset($_GET["bundesland"])) {
  $jahr = $_GET["jahr"];
  $start_monat = $_GET["start_monat"];
  $ende_monat = $_GET["ende_monat"];
  $bundesland = $_GET["bundesland"];

  if ($start_monat<1 or $start_monat>12 or $ende_monat<1 or $ende_monat>12)
    die("Fehler: Bitte sinnvolle Start und Endparameter eingeben!");
} else
  die("Fehler: Es wurden die erforderlichen GET Parameter jahr, start_monat, ende_monat und bundesland nicht &uuml;bergeben!");

$monate_namen = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$tage_namen = array("Mo", "Di", "Mi", "Do", "Fr", "Sa", "So");

$monate = 12;
$monate_spalten[13][34]="";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.smartnoob.de/ferien/v1/feiertage/?bundesland=$bundesland&jahr=$jahr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5");
$feiertage = json_decode (curl_exec($ch));
if ($feiertage->error != 0) die ("Fehler: Abfrage der Feiertage nicht m&ouml;glich. <br>Der folgende Fehler ist aufgetreten: <b>".$feiertage->nachricht)."</b>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.smartnoob.de/ferien/v1/ferien/?bundesland=$bundesland&jahr=$jahr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5");
$ferien = json_decode (curl_exec($ch));
//Ferien können nicht deutschlandweit ausgegeben werden
if ($bundesland!="de" and $ferien->error != 0) die ("Fehler: Abfrage der Ferien nicht m&ouml;glich. <br>Der folgende Fehler ist aufgetreten: <b>".$ferien->nachricht)."</b>";


for($monat=1; $monat<=$monate; ++$monat) { //Namen der Tage
  $anzahl_tage = cal_days_in_month(CAL_GREGORIAN, $monat, $jahr); // 31
  for ($tag=1; $tag<=33; ++$tag) {
    if ($tag<=$anzahl_tage) {
      $timestamp = strtotime($tag-1 ."-$monat-$jahr");
      $monate_spalten[$monat][$tag] = $tag." ".$tage_namen[date("w", $timestamp)];

      foreach ($feiertage->daten as $feiertag) { //Feiertage
        if ($feiertag->beginn-172800<$timestamp and $feiertag->ende-172800>=$timestamp) {
          if ($feiertag->title=="Tag der Deutschen Einheit") $feiertag->title = "Tag der dt. Einheit"; //Nur eine Zeile verwenden
          $feiertag->title = str_replace("Weihnachtsfeiertag", "Weihnachtstag", $feiertag->title);
          $monate_spalten[$monat][$tag] .= " <b style=\"color:grey;\">".$feiertag->title."</b>";
        }
      }
    } else
      $monate_spalten[$monat][$tag] = "";
  }
}

echo "<h1 style=\"font-family:arial\"><center>$jahr</center></h1><table style=\"font-family:arial;font-size:10pt;border-collapse:collapse; position:relative; width:100%; table-layout: fixed;\"><tr>";
for($monat=$start_monat; $monat<=$ende_monat; ++$monat) {
  echo "<th style=\"border:1px solid black;border-collapse:collapse;background-color:#9bbb59\">$monate_namen[$monat]</th>";
}
echo "</tr>";
for ($tag=1; $tag<=33; ++$tag) {
  echo "<tr>";
  for($monat=$start_monat; $monat<=$ende_monat; ++$monat) {
    $timestamp = strtotime($tag-1 ."-$monat-$jahr");
    $tag_name = $tage_namen[date("w", $timestamp)];
    $sind_ferien = FALSE;
    if ($bundesland!="de") //Ferien können nicht deutschlandweit ausgegeben werden
      foreach ($ferien->daten as $ferie) { //Feiertage
        if ($ferie->beginn-86400<=$timestamp and $ferie->ende-86400>$timestamp and $monate_spalten[$monat][$tag] != "" and !($monate_spalten[$monat][$tag] != "" and ($tag_name=="Sa" or $tag_name=="So"))) {
          echo "<td style=\"background-color:#eaf1dd; border:1px solid black;border-collapse:collapse;\">".$monate_spalten[$monat][$tag]."</td>";
          $sind_ferien=TRUE;
        }
      }

    if ($sind_ferien==FALSE and $monate_spalten[$monat][$tag] != "" and ($tag_name=="Sa" or $tag_name=="So"))
      echo "<td style=\"border:1px solid black;border-collapse:collapse;background-color:#c2d69b;\">".$monate_spalten[$monat][$tag]."</td>";
    else if ($sind_ferien==FALSE and $monate_spalten[$monat][$tag] != "")
      echo "<td style=\"border:1px solid black;border-collapse:collapse;\">".$monate_spalten[$monat][$tag]."</td>";
    else if ($monate_spalten[$monat][$tag] == "")
      echo "<td></td>";
  }
  echo "</tr>";
}
echo "</table>";
?>
