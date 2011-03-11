<?php

// Строительство построек.

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( key_exists ('cp', $_GET)) SelectPlanet ( $GlobalUser['player_id'], $_GET['cp']);

// Обработка параметров.
if ( key_exists ('modus', $_GET) )
{
    if ( $_GET['modus'] === 'add' ) BuildEnque ( $_GET['planet'], $_GET['techid'], 0 );
    else if ( $_GET['modus'] === 'destroy' ) BuildEnque ( $_GET['planet'], $_GET['techid'], 1 );
    else if ( $_GET['modus'] === 'remove' ) BuildDeque ( $_GET['planet'], $_GET['listid'] );
}

$now = time();
UpdateQueue ( $now );
$aktplanet = GetPlanet ( $GlobalUser['aktplanet'] );
ProdResources ( $GlobalUser['aktplanet'], $aktplanet['lastpeek'], $now );
UpdatePlanetActivity ( $aktplanet['planet_id'] );
UpdateLastClick ( $GlobalUser['player_id'] );
$session = $_GET['session'];
$prem = PremiumStatus ($GlobalUser);

$unitab = LoadUniverse ( );
$speed = $unitab['speed'];

PageHeader ("b_building");

$buildmap = array ( 1, 2, 3, 4, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 41, 42, 43, 44 );

// Краткое описание
$shortdesc[1] = "Основной поставщик сырья для строительства несущих структур построек и кораблей.";
$shortdesc[2] = "Основной поставщик сырья для электронных строительных элементов и сплавов.";
$shortdesc[3] = "Извлекает из воды на планете незначительную долю дейтерия.";
$shortdesc[4] = "Производит энергию из солнечных лучей. Энергия требуется для работы большинства построек.";
$shortdesc[12] = "Добывает энергию из процесса образования атома гелия двумя атомами тяжёлого водорода.";
$shortdesc[14] = "Предоставляет простую рабочую силу, которую можно применять при строительстве планетарной инфраструктуры. Каждый уровень развития фабрики повышает скорость строительства зданий.";
$shortdesc[15] = "Представляет собой венец робототехники. Каждый уровень укорачивает время строительства зданий, кораблей и оборонительных сооружений вдвое.";
$shortdesc[21] = "В строительной верфи производятся все виды кораблей и оборонительных сооружений.";
$shortdesc[22] = "Хранилище для необработанных руд металлов до их дальнейшей переработки.";
$shortdesc[23] = "Хранилище для необработанного кристалла до его дальнейшей переработки.";
$shortdesc[24] = "Огромные ёмкости для хранения добытого дейтерия.";
$shortdesc[31] = "Необходима для исследования новых технологий.";
$shortdesc[33] = "Терраформер увеличивает пригодную для застройки площадь";
$shortdesc[34] = "Склад альянса предоставляет возможность обеспечения топливом дружественных флотов, которые помогают при обороне и находятся на орбите";
$shortdesc[41] = "Луна не располагает атмосферой, поэтому перед заселением требуется соорудить лунную базу.";
$shortdesc[42] = "Позволяет наблюдать за передвижениями флота. Чем выше уровень развития, тем больше радиус действия фаланги.";
$shortdesc[43] = "Ворота - это огромные телепортеры, которые могут пересылать между собой флоты любых размеров без временных затрат.";
$shortdesc[44] = "Служит для хранения ракет.";

echo "<!-- CONTENT AREA -->\n";
echo "<div id='content'>\n";
echo "<center>\n";

echo "<script type=\"text/javascript\">\n";
echo "<!--\n";
echo "function t() {\n";
echo "	v = new Date();\n";
echo "	var bxx = document.getElementById('bxx');\n";
echo "	var timeout = 1;\n";
echo "	n=new Date();\n";
echo "	ss=pp;\n";
echo "	aa=Math.round((n.getTime()-v.getTime())/1000.);\n";
echo "	s=ss-aa;\n";
echo "	m=0;\n";
echo "	h=0;\n";
echo "	if ((ss + 3) < aa) {\n";
echo "	  bxx.innerHTML=\"Окончено<br>\"+\"<a href=index.php?page=b_building&session=\"+ps+\"&planet=\"+pl+\">Дальше</a>\";\n";
echo "	  if ((ss + 6) >= aa) {	    \n";
echo "	  	window.setTimeout('document.location.href=\"index.php?page=b_building&session='+ps+'&planet='+pl+'\";', 3500);\n";
echo "  	  }\n";
echo "	} else {\n";
echo "	if(s < 0) {\n";
echo "            timeout = 0;\n";
echo "            bxx.innerHTML=\"Окончено<br>\"+\"<a href=index.php?page=b_building&session=\"+ps+\"&planet=\"+pl+\">Дальше</a>\";\n";
echo "	} else {\n";
echo "		if(s>59){\n";
echo "			m=Math.floor(s/60);\n";
echo "			s=s-m*60;\n";
echo "		}\n";
echo "        if(m>59){\n";
echo "        	h=Math.floor(m/60);\n";
echo "        	m=m-h*60;\n";
echo "        }\n";
echo "        if(s<10){\n";
echo "        	s=\"0\"+s;\n";
echo "        }\n";
echo "        if(m<10){\n";
echo "        	m=\"0\"+m;\n";
echo "        }\n";
echo "        bxx.innerHTML=h+\":\"+m+\":\"+s+\"<br><a href=index.php?page=b_building&session=\"+ps+\"&listid=\"+pk+\"&modus=\"+pm+\"&planet=\"+pl+\">Отменить</a>\";\n";
echo "	}    \n";
echo "	pp=pp-1;\n";
echo "	if (timeout == 1) {\n";
echo "    	window.setTimeout(\"t();\", 999);\n";
echo "    }\n";
echo "    }\n";
echo "}\n";
echo "//-->\n";
echo "</script>\n";

echo "<table align=top ><tr><td style='background-color:transparent;'>\n";
echo "<table width=\"530\">\n";

// Проверить ведется ли исследование или нет.
$result = GetResearchQueue ( $GlobalUser['player_id'] );
$resqueue = dbarray ($result);
$reslab_operating = ($resqueue != null);

// Вывести очередь построек (если активен Командир)
$result = GetBuildQueue ( $aktplanet['planet_id'] );
$cnt = dbrows ( $result );
for ( $i=0; $i<$cnt; $i++ )
{
    $queue = dbarray ($result);
    if ($i == 0) $queue0 = $queue;
    if ( $prem['commander'] )
    {
        echo "<tr><td class=\"l\" colspan=\"2\">".($i+1).".: ".$desc[$queue['obj_id']]. " ".$queue['type']. " ".date ( "D M j G:i:s", $queue['end'])." , уровень ".$queue['level'];
        if ($i==0) {
            echo "<td class=\"k\"><div id=\"bxx\" class=\"z\"></div><SCRIPT language=JavaScript>\n";
            echo "                  pp=\"".($queue['end']-$queue['start'])."\"\n";
            echo "                  pk=\"1\"\n";
            echo "                  pm=\"remove\"\n";
            echo "                  pl=\"".$aktplanet['planet_id']."\"\n";
            echo "                  ps=\"$session\"\n";
            echo "                  t();\n";
            echo "                  </script></tr>\n";
        }
        else {
            echo "<td class=\"k\"><font color=\"red\"><a href=\"index.php?page=b_building&session=$session&modus=remove&listid=".($i+1)."&planet=".$aktplanet['planet_id']."\">удалить</a></font></td></td></tr>\n";
        }
    }
}

foreach ( $buildmap as $i => $id )
{
    if ( ! BuildMeetRequirement ( $GlobalUser, $aktplanet, $id ) ) continue;
    $lvl = $aktplanet['b'.$id];
    echo "<tr><td class=l>";
    echo "<a href=index.php?page=infos&session=$session&gid=".$id.">";
    echo "<img border='0' src=\"".UserSkin()."gebaeude/".$id.".gif\" align='top' width='120' height='120'></a></td>";
    echo "<td class=l>";
    echo "<a href=index.php?page=infos&session=$session&gid=".$id.">".$desc[$id]."</a></a>";
    if ( $lvl ) echo " (уровень ".$lvl.")";
    echo "<br>". $shortdesc[$id];
    $m = $k = $d = $e = 0;
    BuildPrice ( $id, $lvl+1, &$m, &$k, &$d, &$e );
    echo "<br>Стоимость:";
    if ($m) echo " Металл: <b>".nicenum($m)."</b>";
    if ($k) echo " Кристалл: <b>".nicenum($k)."</b>";
    if ($d) echo " Дейтерий: <b>".nicenum($d)."</b>";
    if ($e) echo " Энергия: <b>".nicenum($e)."</b>";
    $t = BuildDuration ( $id, $lvl+1, $aktplanet['b14'], $aktplanet['b15'], $speed );
    echo "<br>Длительность: ".BuildDurationFormat ( $t )."<br>";

    if ( $prem['commander'] ) {
        if ( $cnt ) {
            if ( $cnt < 5) echo "<td class=k><a href=\"index.php?page=b_building&session=$session&modus=add&techid=$id&planet=".$aktplanet['planet_id']."\">В очередь на строительство</a></td>";
            else echo "<td class=k>";
        }
        else
        {
			if ( $id == 31 && $reslab_operating ) {
				echo "<td class=l><font  color=#FF0000>В процессе</font> <br>";
			}
   			else if ( $lvl == 0 )
      		{
        		if ( IsEnoughResources ( $aktplanet, $m, $k, $d, $e )) echo "<td class=l><a href='index.php?page=b_building&session=$session&modus=add&techid=".$id."&planet=".$aktplanet['planet_id']."'><font color=#00FF00> строить </font></a>\n";
          		else echo "<td class=l><font color=#FF0000> строить </font>\n";
			}
   			else
      		{
        		if ( IsEnoughResources ( $aktplanet, $m, $k, $d, $e )) echo "<td class=l><a href='index.php?page=b_building&session=$session&modus=add&techid=".$id."&planet=".$aktplanet['planet_id']."'><font color=#00FF00>Совершенствовать <br> до уровня  ".($lvl+1)."</font></a>\n";
          		else echo "<td class=l><font color=#FF0000>Совершенствовать <br> до уровня  ".($lvl+1)."</font>";
			}
        }
    }
    else {
        if ( $cnt ) {
            if ( $queue0['obj_id'] == $id )
            {
                $left = $queue0['end'] - time ();
                echo "<td class=k><div id=\"bxx\" class=\"z\"></div><SCRIPT language=JavaScript>pp='".$left."'; pk='1'; pm='remove'; pl='".$aktplanet['planet_id']."'; ps='".$_GET['session']."'; t();</script>\n";
            }
			else echo "<td class=k>";
        }
        else {
			if ( $id == 31 && $reslab_operating ) {
				echo "<td class=l><font  color=#FF0000>В процессе</font> <br>";
			}
   			else if ( $lvl == 0 )
      		{
        		if ( IsEnoughResources ( $aktplanet, $m, $k, $d, $e )) echo "<td class=l><a href='index.php?page=b_building&session=$session&modus=add&techid=".$id."&planet=".$aktplanet['planet_id']."'><font color=#00FF00> строить </font></a>\n";
          		else echo "<td class=l><font color=#FF0000> строить </font>\n";
			}
   			else
      		{
        		if ( IsEnoughResources ( $aktplanet, $m, $k, $d, $e )) echo "<td class=l><a href='index.php?page=b_building&session=$session&modus=add&techid=".$id."&planet=".$aktplanet['planet_id']."'><font color=#00FF00>Совершенствовать <br> до уровня  ".($lvl+1)."</font></a>\n";
          		else echo "<td class=l><font color=#FF0000>Совершенствовать <br> до уровня  ".($lvl+1)."</font>";
			}
		}
    }
    echo "</td></tr>\n";
}

echo "  </table>\n</tr>\n</table>\n";

echo "<br><br><br><br>\n";
echo "</center>\n";
echo "</div>\n";
echo "<!-- END CONTENT AREA -->\n";

PageFooter ();
ob_end_flush ();
?>