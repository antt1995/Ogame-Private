<?php

// Подача заявки в альянс.

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( key_exists ('cp', $_GET)) SelectPlanet ($GlobalUser['player_id'], $_GET['cp']);
$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( $GlobalUser['aktplanet'], $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];

PageHeader ("bewerben");
?>

<!-- CONTENT AREA -->
<div id='content'>
<center>
<h1>Регистрироваться</h1>
<table width=519>
<form action="index.php?page=bewerben&session=<?=$session;?>&allyid=24440" method=POST>
<tr><td class=c colspan=2>Заявка в альянс [123] написать</td></tr>
<tr><th>Сообщение (<span id="cntChars">0</span> / 6000 символов)</th><th><textarea name="text" cols=40 rows=10 onkeyup="javascript:cntchar(6000)"></textarea></th></tr>
<tr><th>Маленькая помощь</th><th><input type=submit name="weiter" value="Образец"></th></tr>
<tr><th colspan=2><input type=submit name="weiter" value="Отправить"></th></tr>
</table></form></center><br><br><br><br>
</center>
</div>
<!-- END CONTENT AREA -->

<?php
PageFooter ();
ob_end_flush ();
?>