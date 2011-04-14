<?php

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( key_exists ('cp', $_GET)) SelectPlanet ($GlobalUser['player_id'], $_GET['cp']);
$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( $GlobalUser['aktplanet'], $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];

PageHeader ("galaxy");

function empty_row ($p)
{
    echo "<tr><th width=\"30\"><a href=\"#\" >".$p."</a></th><th width=\"30\"></th><th width=\"130\" style='white-space: nowrap;'></th><th width=\"30\" style='white-space: nowrap;'></th><th width=\"30\"></th><th width=\"150\"></th><th width=\"80\"></th><th width=\"125\" style='white-space: nowrap;'></th></tr>\n\n";
}

// Выбрать солнечную систему.
if ( key_exists ('session', $_POST)) $coord_g = $_POST['galaxy'];
else if ( key_exists ('galaxy', $_GET)) $coord_g = $_GET['galaxy'];
else $coord_g = $aktplanet['g'];
if ( key_exists ('session', $_POST)) $coord_s = $_POST['system'];
else if ( key_exists ('system', $_GET)) $coord_s = $_GET['system'];
else $coord_s = $aktplanet['s'];
if ( key_exists ('session', $_POST)) $coord_p = 0;
else if ( key_exists ('position', $_GET)) $coord_p = $_GET['position'];
else $coord_p = $aktplanet['p'];

echo "<!-- CONTENT AREA -->\n";
echo "<div id='content'>\n";
echo "<center>\n\n";

/***** Скрипты. *****/

?>

  <script  language="JavaScript">
  function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
  }

  function fenster(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'scrollbars=yes,menubar=no,top=0,left=0,toolbar=no,width=550,height=280,resizable=yes');
  new_win.focus();
  }


  var IE = document.all?true:false;

  function mouseX(e){
    if (IE) { // grab the x-y pos.s if browser is IE
        return event.clientX + document.body.scrollLeft;
    } else {
        return e.pageX
    }
  }
  function mouseY(e) {
    if (IE) { // grab the x-y pos.s if browser is IE
        return event.clientY + document.body.scrollTop;
    }else {
        return e.pageY;
    }
  }

  </script>
  <script language="JavaScript" src="js/tw-sack.js"></script>
  <script type="text/javascript">
  var ajax = new sack();
  var strInfo = "";

  function whenLoading(){
      //var e = document.getElementById('fleetstatus');
      //e.innerHTML = "Флот отсылается...";
  }

  function whenLoaded(){
      //    var e = document.getElementById('fleetstatus');
      // e.innerHTML = "Флот отослан...";
  }

  function whenInteractive(){
      //var e = document.getElementById('fleetstatus');
      // e.innerHTML = "Получение данных...";
  }

  /*
  We can overwrite functions of the sack object easily. :-)
  This function will replace the sack internal function runResponse(),
  which normally evaluates the xml return value via eval(this.response).
  */
  function whenResponse(){

      /*
      *
      *  600   OK
      *  601   no planet exists there
      *  602   no moon exists there
      *  603   player is in noob protection
      *  604   player is too strong
      *  605   player is in u-mode
      *  610   not enough espionage probes, sending x (parameter is the second return value)
      *  611   no espionage probes, nothing send
      *  612   no fleet slots free, nothing send
      *  613   not enough deuterium to send a probe
      *
      */
      // the first three digit long return value
      retVals = this.response.split(" ");
      // and the other content of the response
      // but since we only got it if we can send some but not all probes
      // theres no need to complicate things with better parsing

      // each case gets a different table entry, no language file used :P
      switch(parseInt(retVals[0])) {
          case 600:
          addToTable("done", "success");
                    changeSlots(retVals[1]);
          setShips("probes", retVals[2]);
          setShips("recyclers", retVals[3]);
          setShips("missiles", retVals[4]);
                    break;
          case 601:
          addToTable("Произошла ошибка", "error");
          break;
          case 602:
          addToTable("Ошибка, луны не существует", "error");
          break;
          case 603:
          addToTable("Ошибка! К игроку невозможно подлететь, т.к. он находится под защитой для новичков! ", "error");
          break;
          case 604:
          addToTable("Ошибка! К игроку невозможно подлететь, т.к. он находится под защитой для новичков! ", "error");
          break;
          case 605:
          addToTable("Невозможно, игрок находится в режиме отпуска", "vacation");
          break;
          case 610:
          addToTable("Ошибка, возможно послать только "+retVals[1]+" зондов, шлите", "notice");
          break;
          case 611:
          addToTable("Шпионаж невозможен, у Вас нет зондов", "error");
          break;
          case 612:
          addToTable("Недостаточно места для флота", "error");
          break;
          case 613:
          addToTable("У Вас недостаточно дейтерия", "error");
          break;
          case 614:
          addToTable("Здесь планеты нет", "error");
          break;
          case 615:
          addToTable("Ошибка! Недостаточная грузоподъёмность!", "error");
          break;
          case 616:
          addToTable("Одинаковый ай-пи!", "error");
          break;
      }
  }

  function doit(order, galaxy, system, planet, planettype, shipcount){
      strInfo = "  Отправка "+shipcount+" кораблей"+(shipcount>1?"":"")+" на "+galaxy+":"+system+":"+planet+" ";
      ajax.requestFile = "index.php?ajax=1&page=flottenversand&session=cabc5002190c";

      // no longer needed, since we don't want to write the cryptic
      // response somewhere into the output html
      //ajax.element = 'fleetstatus';
      //ajax.onLoading = whenLoading;
      //ajax.onLoaded = whenLoaded;
      //ajax.onInteractive = whenInteractive;

      // added, overwrite the function runResponse with our own and
      // turn on its execute flag
      ajax.runResponse = whenResponse;
      ajax.execute = true;

      ajax.setVar("session", "<?=$session;?>");
      ajax.setVar("order", order);
      ajax.setVar("galaxy", galaxy);
      ajax.setVar("system", system);
      ajax.setVar("planet", planet);
      ajax.setVar("planettype", planettype);
      ajax.setVar("shipcount", shipcount);
      ajax.setVar("speed", 10);
      ajax.setVar("reply", "short");
      ajax.runAJAX();
  }

  /*
  * This function will manage the table we use to output up to three lines of
  * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
  * will be hidden (display: none;) - if we want to output a line, its display
  * value is cleaned and therefore its visible. If there are more than 2 lines
  * we want to remove the first row to restrict the history to not more than
  * 3 entries. After using the object function of the table we fill the newly
  * created row with text. Let the browser do the parsing work. :D
  */
  function addToTable(strDataResult, strClass) {
      var e = document.getElementById('fleetstatusrow');
      var e2 = document.getElementById('fleetstatustable');
      // make the table row visible
      e.style.display = '';
      if(e2.rows.length > 98) {
          e2.deleteRow(98);
      }
      var row = e2.insertRow('test');
      var td1 = document.createElement("td");
      var td1text = document.createTextNode(strInfo);
      td1.appendChild(td1text);
      var td2 = document.createElement("td");
      var span = document.createElement("span");
      var spantext = document.createTextNode(strDataResult);
      var spanclass = document.createAttribute("class");
      spanclass.nodeValue = strClass;
      span.setAttributeNode(spanclass);
      span.appendChild(spantext);
      td2.appendChild(span);
      row.appendChild(td1);
      row.appendChild(td2);

  }

  function changeSlots(slotsInUse) {
      var e = document.getElementById('slots');
      e.innerHTML = slotsInUse;
  }

  function setShips(ship, count) {
      var e = document.getElementById(ship);
      e.innerHTML = count;
  }

  function cursorevent(evt) {
      evt = (evt) ? evt : ((event) ? event : null);
      if(evt.keyCode == 37) {
          galaxy_submit('systemLeft');
      }

      if(evt.keyCode == 39) {
          galaxy_submit('systemRight');
      }

      if(evt.keyCode == 38) {
          galaxy_submit('galaxyRight');
      }

      if(evt.keyCode == 40) {
          galaxy_submit('galaxyLeft');
      }

  }
  document.onkeydown = cursorevent;
</script>

<?php

/***** Меню выбора солнечной системы. *****/

echo "  <center>\n<form action=\"index.php?page=galaxy&no_header=1&session=".$_GET['session']."\" method=\"post\" id=\"galaxy_form\">\n";
echo "<input type=\"hidden\" name=\"session\" value=\"".$_GET['session']."\">\n";
echo "<input type=\"hidden\" id=\"auto\" value=\"dr\">\n";
echo "<table border=1 class='header' id='t1'>\n\n";
echo "<tr class='header'>\n";
echo "    <td class='header'><table class='header' id='t2'>\n";
echo "    <tr class='header'><td class=\"c\" colspan=\"3\">Галактика</td></tr>\n";
echo "    <tr class='header'>\n";
echo "    <td class=\"l\"><input type=\"button\" name=\"galaxyLeft\" value=\"<-\" onClick=\"galaxy_submit('galaxyLeft')\"></td>\n";
echo "    <td class=\"l\"><input type=\"text\" name=\"galaxy\" value=\"".$coord_g."\" size=\"5\" maxlength=\"3\" tabindex=\"1\"></td>\n";
echo "    <td class=\"l\"><input type=\"button\" name=\"galaxyRight\" value=\"->\" onClick=\"galaxy_submit('galaxyRight')\"></td>\n";
echo "    </tr></table></td>\n\n";
echo "    <td class='header'><table class='header' id='t3'>\n";
echo "    <tr class='header'><td class=\"c\" colspan=\"3\">Солнечная система</td></tr>\n";
echo "    <tr class='header'>\n";
echo "    <td class=\"l\"><input type=\"button\" name=\"systemLeft\" value=\"<-\" onClick=\"galaxy_submit('systemLeft')\"></td>\n";
echo "    <td class=\"l\"><input type=\"text\" name=\"system\" value=\"".$coord_s."\" size=\"5\" maxlength=\"3\" tabindex=\"2\"></td>\n";
echo "    <td class=\"l\"><input type=\"button\" name=\"systemRight\" value=\"->\" onClick=\"galaxy_submit('systemRight')\"></td>\n";
echo "    </tr></table></td>\n";
echo "</tr>\n\n";
echo "<tr class='header'>\n";
echo "    <td class='header' style=\"background-color:transparent;border:0px;\" colspan=\"2\" align=\"center\"> <input type=\"submit\" value=\"Показать\"></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form>\n";

/***** Форма запуска межпланетных ракет *****/

    if (0) {

?>

   <form action="index.php?page=raketenangriff&session=f4fdf56ce44c&p1=6&p2=123&ft3=5&zp=4333060&pid=1343882027"  method="POST">   <tr>
   <table border="0">
    <tr>
     <td class="c" colspan="2">
      Запустить ракету на <a href="?cmd=0&id=http://www.ogame.freequenzart.de/skins/deepsunrise/&action=galaxy&no_header=1" >[1:1:15]</a>     </td>

    </tr>
    <tr>
     <td class="c">
     Кол-во ракет (5 в наличии):     <input type="text" name="anz" size="2" maxlength="2" /></td>
    <td class="c">
    Цель:
     <select name="pziel">
      <option value="0" selected>Все</option>
<?php
    $defmap = array ( 401, 402, 403, 404, 405, 406, 407, 408 );
    foreach ($defmap as $i=>$gid)
    {
        echo "       <option value=\"$gid\">".loca("NAME_$gid")."</option>\n";
    }
?>
           </select>
    </td>
   </tr>
   <tr>
    <td class="c" colspan="2"><input type="submit" name="aktion" value="Атаковать"></td>
   </tr>

  </table>
 </form>

<?php
    }

/***** Заголовок таблицы *****/

echo "<table width=\"569\">\n";
echo "<tr><td class=\"c\" colspan=\"8\">Солнечная система ".$coord_g.":".$coord_s."</td></tr>\n";
echo "<tr>\n";
echo "<td class=\"c\">Коорд.</td>\n";
echo "<td class=\"c\">Планета</td>\n";
echo "<td class=\"c\">Название (активность)</td>\n";
echo "<td class=\"c\">луна</td>\n";
echo "<td class=\"c\">поле обломков</td>\n";
echo "<td class=\"c\">игрок (статус)</td>\n";
echo "<td class=\"c\">Альянс</td>\n";
echo "<td class=\"c\">Действия</td>\n";
echo "</tr>\n";

/***** Перечислить планеты *****/

$p = 1;
$tabindex = 3;
$result = EnumPlanetsGalaxy ( $coord_g, $coord_s );
$num = $planets = dbrows ($result);

while ($num--)
{
    $planet = dbarray ($result);
    $user = LoadUser ( $planet['owner_id']);
    $own = $user['player_id'] == $GlobalUser['player_id'];
    for ($p; $p<$planet['p']; $p++) empty_row ($p);

    // Коорд.
    echo "<tr>\n";
    echo "<th width=\"30\"><a href=\"#\"  tabindex=\"".($tabindex++)."\" >".$p."</a></th>\n";

    // Планета
    echo "<th width=\"30\">\n";
    if ( $planet['type'] != 10001 )
    {
        echo "<a style=\"cursor:pointer\" onmouseover='return overlib(\"<table width=240>";
        echo "<tr><td class=c colspan=2 >Планета ".$planet['name']." [".$planet['g'].":".$planet['s'].":".$planet['p']."]</td></tr>";
        echo "<tr><th width=80 ><img src=".GetPlanetSmallImage ( UserSkin(), $planet['type'] )." height=75 width=75 /></th>";
        echo "<th align=left >";
        if ($own)
        {
            echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$planet['g']."&system=".$planet['s']."&planet=".$planet['p']."&planettype=1&target_mission=4 >Оставить</a><br />";
            echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$planet['g']."&system=".$planet['s']."&planet=".$planet['p']."&planettype=1&target_mission=3 >Транспорт</a><br />";
        }
        else
        {
            echo "<a href=# onclick=doit(6,".$planet['g'].",".$planet['s'].",".$planet['p'].",1,1) >Шпионаж</a><br><br />";
            echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$planet['g']."&system=".$planet['s']."&planet=".$planet['p']."&planettype=1&target_mission=1 m>Атака</a><br />";
            echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$planet['g']."&system=".$planet['s']."&planet=".$planet['p']."&planettype=1&target_mission=5 >Удерживать</a><br />";
            echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$planet['g']."&system=".$planet['s']."&planet=".$planet['p']."&planettype=1&target_mission=3 >Транспорт</a><br />";
        }
        echo "</th></tr></table>\", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' onmouseout=\"return nd();\">\n";
        echo "<img src=\"".GetPlanetSmallImage ( UserSkin(), $planet['type'] )."\" height=\"30\" width=\"30\"/></a>\n";
    }
    echo "</th>\n";

    // Название (активность)
    $now = time ();
    $ago15 = $now - 15 * 60;
    $ago60 = $now - 60 * 60;
    $akt = "";
    if (!$own)
    {
        if ( $planet['lastakt'] > $ago15 ) $akt = "&nbsp;(*)";
        else if ( $planet['lastakt'] > $ago60) $akt = "&nbsp;(".floor(($now - $planet['lastakt'])/60)." min)";
    }
    if ( $planet['type'] == 10001 ) echo "<th width=\"130\" style='white-space: nowrap;'>Уничтоженная планета$akt</th>\n";
    else echo "<th width=\"130\" style='white-space: nowrap;'>".$planet['name']."$akt</th>\n";

    // луна
    echo "<th width=\"30\" style='white-space: nowrap;'>\n";
    $moon_id = PlanetHasMoon ( $planet['planet_id'] );
    if ($moon_id)
    {
        $moon = GetPlanet ( $moon_id );
        if (!$moon['destroyed'])
        {
            echo "<a onmouseout=\"return nd();\" onmouseover=\"return overlib('<table width=240 ><tr>";
            echo "<td class=c colspan=2 >Луна ".$moon['name']." [".$moon['g'].":".$moon['s'].":".$moon['p']."]</td></tr>";
            echo "<tr><th width=80 ><img src=".GetPlanetSmallImage ( UserSkin(), $moon['type'] )." height=75 width=75 alt=\'Луна (размер: ".$moon['diameter'].")\'/></th>";
            echo "<th><table width=120 ><tr><td colspan=2 class=c >Свойства</td></tr>";
            echo "<tr><th>размер:</td><th>".nicenum($moon['diameter'])."</td></tr>";
            echo "<tr><th>температура:</td><th>".$moon['temp']."</td></tr>";
            echo "<tr><td colspan=2 class=c >Действия:</td></tr>";
            echo "<tr><th align=left colspan=2 >";
            if ($own)
            {
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=3 >Транспорт</a><br />";
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=4 >Оставить</a><br />";
            }
            else
            {
                echo "<font color=#808080 >Шпионаж</font><br><br />";
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=3 >Транспорт</a><br />";
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=1 >Атака</a><br />";
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=5 >Удерживать</a><br />";
                echo "<a href=index.php?page=flotten1&session=".$_GET['session']."&galaxy=".$moon['g']."&system=".$moon['s']."&planet=".$moon['p']."&planettype=3&target_mission=9 >Уничтожить</a><br />";
            }
            echo "</th></tr></table></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -110 );\" style=\"cursor: pointer;\">\n";
            echo "<img width=\"22\" height=\"22\" alt=\"Луна (размер: 4358)\" src=\"".GetPlanetSmallImage ( UserSkin(), $moon['type'] )."\"/></a>\n";
        }
        else echo "<div style=\"border: 2pt solid #FF0000;\"><img src=\"".GetPlanetSmallImage ( UserSkin(), $moon['type'] )."\" alt=\"Луна (размер: ".$moon['diameter'].")\" height=\"22\" width=\"22\" onmouseover=\"return overlib('<font color=white><b>Покинута</b></font>', WIDTH, 75);\" onmouseout=\"return nd();\"/></div>\n";
    }
    echo "</th>\n";

    // поле обломков (не показывать ПО < 500 единиц)
    echo "<th width=\"30\">";
    $debris_id = HasDebris ($coord_g, $coord_s, $p);
    if ( $debris_id )
    {
        $debris = GetPlanet ($debris_id);
        $harvesters = ceil ( ($debris['m'] + $debris['k']) / $UnitParam[209][3]);
        if ( ($debris['m'] + $debris['k']) >= 500 )
        {
?>
    <a style="cursor:pointer"
       onmouseover="return overlib('<table width=240 ><tr><td class=c colspan=2 ></td></tr><tr><th width=80 ><img src=<?=UserSkin();?>planeten/debris.jpg height=75 width=75 alt=T /></th><th><table><tr><td class=c colspan=2>Ресурсы:</td></tr><tr><th>металл:</th><th><?=nicenum($debris['m']);?></th></tr><tr><th>кристалл:</th><th><?=nicenum($debris['k']);?></th></tr><tr><td class=c colspan=2>Действия:</tr><tr><th colspan=2 align=left ><a href=# onclick=doit(8,<?=$coord_g;?>,<?=$coord_s;?>,<?=$p;?>,2,<?=$harvesters;?>) >Переработать</a></tr></table></th></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );" onmouseout="return nd();"
href='#' onclick='doit(8, <?=$coord_g;?>, <?=$coord_s;?>, <?=$p;?>, 2, <?=$harvesters;?>)'
>
<img src="<?=UserSkin();?>planeten/debris.jpg" height="22" width="22" /></a>
<?php
        }
    }
    echo "</th>\n";

    // игрок (статус)
    // Новичек или Сильный или Обычный
    // Приоритеты Обычного: Режим отпуска -> Заблокирован -> Давно неактивен -> Неактивен -> Без статуса
    $stat = "";
    echo "<th width=\"150\">\n";
    if ( $planet['type'] != 10001 )
    {
        echo "<a style=\"cursor:pointer\" onmouseover=\"return overlib('<table width=240 >";
        echo "<tr><td class=c >Игрок ".$user['oname'].". Место в рейтинге - ".$user['place1']."</td></tr>";
        echo "<th><table>";
        if (!$own)
        {
            echo "<tr><td><a href=index.php?page=writemessages&session=".$_GET['session']."&messageziel=".$planet['owner_id']." >Написать сообщение</a></td></tr>";
            echo "<tr><td><a href=index.php?page=buddy&session=".$_GET['session']."&action=7&buddy_id=".$planet['owner_id']." >Предложение подружиться</a></td></tr>";
        }
        echo "<tr><td><a href=index.php?page=statistics&session=".$_GET['session']."&start=".(floor($user['place1']/100)*100+1)." >Статистика</a></td></tr></table>";
        echo "</th></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETY, -40 );\" onmouseout=\"return nd();\">\n";
        if ( IsPlayerNewbie ( $user['player_id'] ) )
        {
            $pstat = "noob"; $stat = "<span class='noob'>н</span>";
        }
        else if ( IsPlayerStrong ( $user['player_id'] ) )
        {
            $pstat = "strong"; $stat = "<span class='strong'>с</span>";
        }
        else
        {
            $week = time() - 604800;
            $week3 = time() - 604800*3;
            $pstat = "normal";
            if ( $user['lastclick'] <= $week ) { $stat .= "<span class='inactive'>i</span>"; $pstat = "inactive"; }
            if ( $user['banned'] ) { if(mb_strlen($stat, "UTF-8")) $stat .= " "; $stat .= "<a href='index.php?page=pranger&session=".$_GET['session']."'><span class='banned'>з</span></a>"; $pstat = "banned"; }
            if ( $user['lastclick'] <= $week3 ) { if(mb_strlen($stat, "UTF-8")) $stat .= " "; $stat .= "<span class='longinactive'>I</span>";  if($pstat !== "banned") $pstat = "longinactive"; }
            if ( $user['vacation'] ) { if(mb_strlen($stat, "UTF-8")) $stat .= " "; $stat .= "<span class='vacation'>РО</span>";  $pstat = "vacation"; }
        }
        echo "<span class=\"$pstat\">".$user['oname']."</span></a>\n";
        if ($pstat !== "normal") echo "($stat)\n";
    }
    echo "</th>\n";

    // Альянс
    if ($user['ally_id'] && $planet['type'] != 10001)
    {
        $ally = LoadAlly ( $user['ally_id']);
        $allytext = $ally['tag'];
    }
    else $allytext = "";
    echo "<th width=\"80\">$allytext</th>\n";

    // Действия
    echo "<th width=\"125\" style='white-space: nowrap;'>\n";
    if ( !$planet['type'] != 10001 && !$own)
    {
        echo "<a style=\"cursor:pointer\" onclick=\"javascript:doit(6, 1, 399, 4, 1, 1);\"><img src=\"".UserSkin()."img/e.gif\" border=\"0\" alt=\"Шпионаж\" title=\"Шпионаж\" /></a>\n";
        echo "<a href=\"index.php?page=writemessages&session=".$_GET['session']."&messageziel=".$planet['owner_id']."\"><img src=\"".UserSkin()."img/m.gif\" border=\"0\" alt=\"Написать сообщение\" title=\"Написать сообщение\" /></a>\n";
        echo "<a href=\"index.php?page=buddy&session=".$_GET['session']."&action=7&buddy_id=".$planet['owner_id']."\"><img src=\"".UserSkin()."img/b.gif\" border=\"0\" alt=\"Предложение подружиться\" title=\"Предложение подружиться\" /></a>\n";
//<a href="index.php?page=galaxy&session=$session&mode=1&p1=1&p2=260&ft3=14&pdd=34430944&zp=172794"><img src="http://localhost/evolution/img/r.gif" border="0" alt="Ракетная атака" title="Ракетная атака" /></a>
    }
    echo "</th>\n";

    echo "</tr>\n\n";
    $p++;
}
for ($p; $p<=15; $p++) empty_row ($p);

/***** Низ таблицы *****/
echo "<tr><th style='height:32px;'>16</th><th colspan='7'><a href ='#'>Бесконечные дали</a></th></tr>\n\n";

echo "<tr><td class=\"c\" colspan=\"6\">(Заселено ".$planets." планет)</td>\n";
echo "<td class=\"c\" colspan=\"2\"><a href='#' onmouseover='return overlib(\"<table><tr><td class=c colspan=2>Легенда</td></tr><tr><td width=125>сильный игрок</td><td><span class=strong>с</span></td></tr><tr><td>нуб</td><td><span class=noob>н</span></td></tr><tr><td>режим отпуска</td><td><span class=vacation>РО</span></td></tr><tr><td>заблокирован</td><td><span class=banned>з</span></td></tr><tr><td>неактивен 7 дней</td><td><span class=inactive>i</span></td></tr><tr><td>неактивен 28 дней</td><td><span class=longinactive>I</span></td></tr></table>\", ABOVE, WIDTH, 150, STICKY, MOUSEOFF, DELAY, 500, CENTER);' onmouseout='return nd();'>Легенда</a></td>\n";
echo "</tr>\n";

echo "</table>\n\n";

echo "<br><br><br><br>\n";
echo "</center>\n";
echo "</div>\n";
echo "<!-- END CONTENT AREA -->\n\n";

PageFooter ();
ob_end_flush ();
?>