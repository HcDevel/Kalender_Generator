<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
  "http://www.w3.org/TR/html4/frameset.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>SmartNOOB Kalender Generator</title>
  </head>
  <frameset rows="100, *">
    <frame src="auswahl.php" name="auswahl">
    <frame src="kalender-generator.php?jahr=<?php echo date("Y") ?>&start_monat=1&ende_monat=12&bundesland=nw" name="kalender">
  </frameset>
</html>
