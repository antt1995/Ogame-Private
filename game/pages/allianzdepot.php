<?php

// Продление флота на удержании складом альянса

$DepotError = "";

loca_add ( "common" );
loca_add ( "menu", $GlobalUser['lang'] );

if ( key_exists ('cp', $_GET)) SelectPlanet ($GlobalUser['player_id'], intval($_GET['cp']));
$GlobalUser['aktplanet'] = GetSelectedPlanet ($GlobalUser['player_id']);
$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( &$aktplanet, $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];

PageHeader ("allianzdepot");

echo "<!-- CONTENT AREA -->\n";
echo "<div id='content'>\n";
echo "<center>\n";

// Запустить ракету со снабжением
if ( $DepotError === "" )
{
}

print_r ( $_POST );

echo "</center>\n";
echo "</div>\n";
echo "<!-- END CONTENT AREA -->\n\n";

PageFooter ("", $DepotError);
ob_end_flush ();
?>