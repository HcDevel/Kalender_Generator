<html>
<head>
  <title>Kalender Auswahl</title>

  <script type="text/javascript" language="JavaScript">
  function drucken() {
     parent.frames.kalender.focus();
     parent.frames.kalender.print();
  }
  </script>
</head>
<body>
  <form action="kalender-generator.php" method="get" target="kalender">
  Von Monat:
  <select name="start_monat">
    <option value="1">Januar</option>
    <option value="2">Februar</option>
    <option value="3">M&auml;rz</option>
    <option value="4">April</option>
    <option value="5">Mai</option>
    <option value="6">Juni</option>
    <option value="7">Juli</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Dezember</option>
  </select>
  Bis Monat:
  <select name="ende_monat">
    <option value="1">Januar</option>
    <option value="2">Februar</option>
    <option value="3">M&auml;rz</option>
    <option value="4">April</option>
    <option value="5">Mai</option>
    <option value="6">Juni</option>
    <option value="7">Juli</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option selected="selected" value="12">Dezember</option>
  </select>
  Jahr:
  <select name="jahr">
    <option><?php echo date("Y") ?></option>
    <option><?php echo date("Y") +1 ?></option>
    <option><?php echo date("Y") +2 ?></option>
    <option><?php echo date("Y") +3 ?></option>
    <option><?php echo date("Y") +4 ?></option>
    <option><?php echo date("Y") +5 ?></option>
  </select>
  Bundesland:
  <select name="bundesland">
    <option value="de">Deutschland (Nur Feiertage)</option>
    <option value="bw">Baden-W&uuml;rttemberg</option>
    <option value="by">Bayern</option>
    <option value="be">Berlin</option>
    <option value="bb">Brandenburg</option>
    <option value="hb">Bremen</option>
    <option value="hh">Hamburg</option>
    <option value="he">Hessen</option>
    <option value="mw">Mecklenburg-Vorpommern</option>
    <option value="ni">Niedersachsen</option>
    <option selected="selected" value="nw">Nordrhein-Westfalen</option>
    <option value="rp">Rheinland-Pfalz</option>
    <option value="sl">Saarland</option>
    <option value="sn">Sachsen</option>
    <option value="st">Sachsen-Anhalt</option>
    <option value="sh">Schleswig-Holstein</option>
    <option value="th">Th&uuml;ringen</option>
  </select>
  <input type="Submit" value="Kalender erzeugen" />
  </form>

  Ein kostenloser Service von <a href="https://blog.smartnoob.de/" target="_blank">blog.smartnoob.de</a>
  <button onclick="drucken()">Kalender drucken</button>
</body>
</html>
