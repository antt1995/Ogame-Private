<?php

// Флот 2: подготавливает координаты цели

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( key_exists ('cp', $_GET)) SelectPlanet ($GlobalUser['player_id'], $_GET['cp']);
$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( $GlobalUser['aktplanet'], $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];

if ( method() !== "POST" )
{
    echo "<html><head><meta http-equiv='refresh' content='0;url=index.php?page=flotten1&session=$session' /></head><body></body>";
    ob_end_flush ();
    die ();
}

PageHeader ("flotten2");
?>

<!-- CONTENT AREA -->
<div id='content'>
<center>


  <script language="JavaScript" src="js/flotten.js"></script>
  <script language="JavaScript" src="js/ocnt.js"></script>

  <script type="text/javascript">

  function getStorageFaktor(){
    return 1  }

  </script>
  
 <!-- <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>  -->

<center>
<table width="519" border="0" cellpadding="0" cellspacing="1">
<form action="index.php?page=flotten3&session=<?=$session;?>" method="POST">
<input name="thisgalaxy" type="hidden" value="<?=$aktplanet['g'];?>" />
<input name="thissystem" type="hidden" value="<?=$aktplanet['s'];?>" />
<input name="thisplanet" type="hidden" value="<?=$aktplanet['p'];?>" />
<input name="thisplanettype" type="hidden" value="<?=GetPlanetType($aktplanet);?>" />
<input name="speedfactor" type="hidden" value="1" />
<input name="thisresource1" type="hidden" value="<?=floor($aktplanet['m']);?>" />
<input name="thisresource2" type="hidden" value="<?=floor($aktplanet['k']);?>" />
<input name="thisresource3" type="hidden" value="<?=floor($aktplanet['d']);?>" />

<?php

    // Список флотов.

    $fleetmap = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215 );

    $total = 0;
    foreach ($fleetmap as $i=>$gid) 
    {
        $total += $_POST["ship$gid"];
        if ( key_exists("ship$gid", $_POST) ) echo "   <input type=\"hidden\" name=\"ship$gid\" value=\"".$_POST["ship$gid"]."\" />\n";
        if ( key_exists("consumption$gid", $_POST) ) echo "   <input type=\"hidden\" name=\"consumption$gid\" value=\"".$_POST["consumption$gid"]."\" />\n";
        if ( key_exists("speed$gid", $_POST) ) echo "   <input type=\"hidden\" name=\"speed$gid\" value=\"".$_POST["speed$gid"]."\" />\n";
        if ( key_exists("capacity$gid", $_POST) ) echo "   <input type=\"hidden\" name=\"capacity$gid\" value=\"".$_POST["capacity$gid"]."\" />\n";
    }

    if ( $total == 0 )    // Флот не выбран.
    {
        ob_end_clean ();
        echo "<html><head><meta http-equiv='refresh' content='0;url=index.php?page=flotten1&session=$session' /></head><body></body>";
        die ();
    }

?>


    <tr height="20">
  <td colspan="2" class="c">Отправление флота</td>
 </tr>

 <tr height="20">
  <th width="50%">Координаты цели</th>
  <th>
   <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="<?=$aktplanet['g'];?>" />
   <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="<?=$aktplanet['s'];?>" />
   <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="<?=$aktplanet['p'];?>" />
   <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">
     <option value="1" ><?=loca("FLEET_PLANETTYPE_1");?> </option>

  <option value="2" ><?=loca("FLEET_PLANETTYPE_2");?> </option>
  <option value="3" ><?=loca("FLEET_PLANETTYPE_3");?> </option>
   </select>
 </tr>
 <tr height="20">
  <th>Скорость</th>
  <th>

   <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">
         <option value="10">100</option>
         <option value="9">90</option>
         <option value="8">80</option>
         <option value="7">70</option>
         <option value="6">60</option>

         <option value="5">50</option>
         <option value="4">40</option>
         <option value="3">30</option>
         <option value="2">20</option>
         <option value="1">10</option>
       </select> %
  </th>

 </tr>
 <tr height="20">
  <th>Расстояние</th><th><div id="distance">-</div></th>
 </tr>
 <tr height="20">
  <th>Продолжительность (в одну сторону)</th><th><div id="duration">-</div></th>
 </tr>

 <tr height="20">
  <th>Потребление топлива</th><th><div id="consumption">-</div></th>
 </tr>
 <tr height="20">
  <th>Максимальная скорость</th><th><div id="maxspeed">-</div></th>
 </tr>
 <tr height="20">

  <th>Грузоподъёмность</th><th><div id="storage">572.500</div></th>
 </tr>

  <tr height="20">
  <td colspan="2" class="c">Планета</td>

  </tr>

<?php

    // Список планет.
    $result = EnumPlanets ();
    $rows = dbrows ($result);
    $leftcol = true;
    while ($rows--)
    {
        $planet = dbarray ($result);
        if ( $planet['planet_id'] == $aktplanet['planet_id'] || GetPlanetType($planet) == 2 ) continue;
        if ( $leftcol ) echo "<tr height=\"20\">\n";
        echo "<th><a href=\"javascript:setTarget(".$planet['g'].",".$planet['s'].",".$planet['p'].",".GetPlanetType($planet)."); shortInfo()\">\n".$planet['name']." ".$planet['g'].":".$planet['s'].":".$planet['p']."</a></th>\n";
        if ( !$leftcol ) echo "</tr>\n";
        $leftcol ^= 1;
    }
    if ( !$leftcol ) {
        echo "     <th>&nbsp; </th>\n";
        echo "</tr>\n";
    }

?>

   </th>
  </tr>

  <tr height="20">
     <td colspan="2" class="c">Боевые союзы  </tr>
 <tr height="20"><th colspan="2">-</th></tr>
<tr height="20">
 <th colspan="2">
  <input type="submit" value="Дальше" />
 </th>
</tr>

</form>
</table>

<script>
window.onload=shortInfo;
</script><br><br><br><br>
</center>
</div>
<!-- END CONTENT AREA -->

<?php
PageFooter ();
ob_end_flush ();
?>