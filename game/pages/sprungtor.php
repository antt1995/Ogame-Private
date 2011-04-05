<?php

// Переброс флота воротами

$GateError = "";

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( key_exists ('cp', $_GET)) SelectPlanet ($GlobalUser['player_id'], $_GET['cp']);
$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( $GlobalUser['aktplanet'], $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];

PageHeader ("sprungtor");

echo "<!-- CONTENT AREA -->\n";
echo "<div id='content'>\n";
echo "<center>\n";

$fleetmap = array ( 215, 214, 213, 211, 210, 209, 208, 207, 206, 205, 204, 203, 202 );

if ( key_exists ( 'qm', $_POST) ) $source_id = $_POST['qm'];
else $source_id = 0;
if ( key_exists ( 'zm', $_POST) ) $target_id = $_POST['zm'];
else $target_id = 0;

$total = 0;
foreach ( $fleetmap as $i=>$gid)
{
    if ( !key_exists ( "c$gid", $_POST) )  $_POST["c$gid"] = 0;
    $total += $_POST["c$gid"];
}

$source = GetPlanet ( $source_id );
$target = GetPlanet ( $target_id );

if ( $source['type'] != 0 ) $GateError .= "<center>\nС какой луны?<br></center>\n";
if ( $target['type'] != 0 ) $GateError .= "<center>\nНа какую луну?<br></center>\n";

if ( $GateError === "" )
{
    if ( $source["b43"] == 0 ) $GateError .= "<center>\nНа исходной луне нет ворот<br></center>\n";
    if ( $target["b43"] == 0 ) $GateError .= "<center>\nНа целевой луне нет ворот<br></center>\n";
}

if ( $GateError === "" )
{
    if ( ($source['owner_id'] != $GlobalUser['player_id']) ||
         ($target['owner_id'] != $GlobalUser['player_id'])  ) $GateError .= "<center>\nЛибо целевая либо исходная луна Вам не принадлежит<br></center>\n";
}

if ( $GateError === "" )
{
    if ( $total == 0 ) $GateError .= "<center>\nНе выбрано ни одного корабля<br></center>\n";
}

// Подготовить список флота для переброски.
if ( $GateError === "" )
{
    $fleet = array ();
    foreach ( $fleetmap as $i=>$gid)
    {
        if ( $_POST["c$gid"] > $source["f$gid"] ) 
        {
            $GateError .= "<center>\nНедостаточно кораблей в наличии.<br></center>\n";
            break;
        }
        $fleet[$gid] = $_POST["c$gid"];
    }
    $fleet[212] = 0;    // лампы.
}

// Сделать переход
if ( $GateError === "" )
{
    // Перебросить флот
    AdjustShips ( $fleet, $source_id, '-' );
    AdjustShips ( $fleet, $target_id, '+' );

    // Нагреть ворота
    $now = time ();
    $query = "UPDATE ".$db_prefix."planets SET gate_until=".($now+60*60)." WHERE planet_id=$source_id";
    dbquery ($query);
    $query = "UPDATE ".$db_prefix."planets SET gate_until=".($now+60*60)." WHERE planet_id=$target_id";
    dbquery ($query);

    // Сделать редирект на ворота целевой луны
    ob_end_clean ();
    $url = "index.php?page=infos&session=$session&cp=$target_id&gid=43";
    echo "<html><head><meta http-equiv='refresh' content='0;url=$url' /></head><body></body>";
    die ();
}

echo "</center>\n";
echo "</div>\n";
echo "<!-- END CONTENT AREA -->\n\n";

PageFooter ("", $GateError);
ob_end_flush ();
?>