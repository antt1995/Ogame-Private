<?php

// Создание списка событий Обзора.

/*
Типы заданий:

1          Атака убывает
101       Атака возвращается
2          Совместная атака убывает
102      Совместная атака возвращается
3         Транспорт убывает
103      Транспорт возвращается
4         Оставить убывает
104     Оставить возвращается
5         Держаться убывает
105      Держаться возвращается
205     Держаться на орбите
6         Шпионаж убывает
106      Шпионаж возвращается
7         Колонизировать убывает
107      Колонизировать возвращается
8         Переработать убывает
108     Переработать возвращается
9         Уничтожить убывает
109      Уничтожить возвращается
15        Экспедиция убывает
115      Экспедиция возвращается
215      Экспедиция на орбите
20        Ракетная атака
*/

function sksort (&$array, $subkey="id", $sort_ascending=false) 
{
    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);

    else $array = $temp_array;
}

function OverFleet ($fleet, $summary)
{
    $res = "&lt;font color=white&gt;&lt;b&gt;";
    $fleetmap = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215 );
    $sum = 0;
    if ( $summary ) {
        foreach ($fleetmap as $i=>$gid) $sum += $fleet[$gid];
        $res .= "Численность кораблей: 1 &lt;br&gt;";
    }
    foreach ($fleetmap as $i=>$gid) {
        $amount = $fleet[$gid];
        if ( $amount > 0 ) $res .= loca ("NAME_$gid") . " " . nicenum($amount) . "&lt;br&gt;";
    }
    $res .= "&lt;/b&gt;&lt;/font&gt;";
    return $res;
}

function TitleFleet ($fleet, $summary)
{
    $fleetmap = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215 );
    $sum = 0;
    if ( $summary ) {
        foreach ($fleetmap as $i=>$gid) $sum += $fleet[$gid];
        $res = "Численность кораблей: $sum ";
    }
    foreach ($fleetmap as $i=>$gid) {
        $amount = $fleet[$gid];
        if ( $amount > 0 ) $res .= loca ("NAME_$gid") . " " . nicenum($amount);
    }
    return $res;
}

function PlayerDetails ($user)
{
    return $user['oname'] . " <a href='#' onclick='showMessageMenu(".$user['player_id'].")'><img src='".UserSkin()."img/m.gif' title='Написать сообщение' alt='Написать сообщение'></a>";
}

function PlanetFrom ($planet, $mission)
{
    $res = "";
    if ( GetPlanetType ($planet) == 1 ) $res .= "планеты";
    $res .= " " . $planet['name'] . " <a href=\"javascript:showGalaxy(".$planet['g'].",".$planet['s'].",".$planet['p'].")\" $mission>[".$planet['g'].":".$planet['s'].":".$planet['p']."]</a>";
    return $res;
}

function PlanetTo ($planet, $mission)
{
    $res = "";
    if ( GetPlanetType ($planet) == 1 ) $res .= "планету";
    $res .= " " . $planet['name'] . " <a href=\"javascript:showGalaxy(".$planet['g'].",".$planet['s'].",".$planet['p'].")\" $mission>[".$planet['g'].":".$planet['s'].":".$planet['p']."]</a>";
    return $res;
}

function Cargo ($m, $k, $d, $mission, $text)
{
    if ( ($m + $k + $d) != 0 ) {
        return "<a href='#' onmouseover='return overlib(\"&lt;font color=white&gt;&lt;b&gt;Транспорт: &lt;br /&gt; Металл: ".nicenum($m)."&lt;br /&gt;Кристалл: ".nicenum($k)."&lt;br /&gt;Дейтерий: ".nicenum($d)."&lt;/b&gt;&lt;/font&gt;\");' " .
                  "onmouseout='return nd();'' class='$mission'>$text</a><a href='#' title='Транспорт: Металл: ".nicenum($m)." Кристалл: ".nicenum($k)." Дейтерий: ".nicenum($d)."'></a>";
    }
    else return "<span class='class'>$text</span>";
}

function FleetSpan ( $fleet_entry )
{
    $mission = $fleet_entry['mission'];
    $assign = $fleet_entry['assign'];
    $dir = $fleet_entry['dir'];
    $dir = $dir | ($assign << 4);
    $origin = GetPlanet ( $fleet_entry['origin_id'] );
    $target = GetPlanet ( $fleet_entry['target_id'] );
    $fleet = $fleet_entry;
    $owner = LoadUser ( $origin['owner_id'] );
    $m = $fleet_entry['m'];
    $k = $fleet_entry['k'];
    $d = $fleet_entry['d'];

    if (0) {}
    else if ($mission == 1)            // Атака
    {
        if ($dir == 0) echo "<span class='flight ownattack'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownattack'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownattack")." отправлен на ".PlanetTo($target, "ownattack").". Задание: ".Cargo($m,$k,$d,"ownattack","Атаковать")."</span>";
        else if ($dir == 1) echo "<span class='return ownattack'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownattack'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a>, отправленный с ".PlanetFrom($origin, "ownattack").", возвращается на ".PlanetTo($target, "ownattack").". Задание: ".Cargo($m,$k,$d,"ownattack","Атаковать")."</span>";
        else if ($dir == 0x10) echo "<span class='attack'>Боевой <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='attack'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "attack")." отправлен на ".PlanetTo($target, "attack").". Задание: Атаковать</span>";
    }
    else if ($mission == 2)            // Совместная атака
    {
        if ($dir == 0) echo "<span class='federation'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownfederation'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownfederation")." отправлен на ".PlanetTo($target, "ownfederation").". Задание: ".Cargo($m,$k,$d,"ownfederation","Совместная атака")."</span>";
        else if ($dir == 1) echo "<span class='return ownfederation'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownfederation'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownfederation")." отправлен на ".PlanetTo($target, "ownfederation").". Задание: ".Cargo($m,$k,$d,"ownfederation","Совместная атака")."</span>";
    }
    else if ($mission == 3)            // Транспорт
    {
        if ($dir == 0) echo "<span class='flight owntransport'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owntransport'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "owntransport")." отправлен на ".PlanetTo($target, "owntransport").". Задание: ".Cargo($m,$k,$d,"owntransport","Транспорт")."</span>";
        else if ($dir == 1) echo "<span class='return owntransport'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owntransport'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a>, отправленный с ".PlanetFrom($origin, "owntransport").", возвращается на ".PlanetTo($target, "owntransport").". Задание: ".Cargo($m,$k,$d,"owntransport","Транспорт")."</span>";
        else if ($dir == 0x10) echo "<span class='flight transport'>Мирный <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='transport'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "transport")." отправлен на ".PlanetTo($target, "transport").". Задание: Транспорт</span>";
    }
    else if ($mission == 4)            // Оставить
    {
        if ($dir == 0) echo "<span class='flight owndeploy'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owndeploy'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "owndeploy")." отправлен на ".PlanetTo($target, "owndeploy").". Задание: ".Cargo($m,$k,$d,"owndeploy","Оставить")."</span>";
        else if ($dir == 1) echo "<span class='return owndeploy'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owndeploy'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "owndeploy")." отправлен на ".PlanetTo($target, "owndeploy").". Задание: ".Cargo($m,$k,$d,"owndeploy","Оставить")."</span>";
    }
    else if ($mission == 6)            // Шпионаж
    {
        if ($dir == 0) echo "<span class='flight ownespionage'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownespionage'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownespionage")." отправлен на ".PlanetTo($target, "ownespionage").". Задание: ".Cargo($m,$k,$d,"ownespionage","Шпионаж")."</span>";
        else if ($dir == 1) echo "<span class='return ownespionage'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownespionage'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownespionage")." отправлен на ".PlanetTo($target, "ownespionage").". Задание: ".Cargo($m,$k,$d,"ownespionage","Шпионаж")."</span>";
        else if ($dir == 0x10) echo "<span class='flight espionage'>Боевой <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='espionage'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "espionage")." отправлен на ".PlanetTo($target, "espionage").". Задание: Шпионаж</span>";
    }
    else if ($mission == 8)            // Переработать
    {
        if ($dir == 0) echo "<span class='flight ownharvest'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownharvest'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownharvest")." отправлен на ".PlanetTo($target, "ownharvest").". Задание: ".Cargo($m,$k,$d,"ownharvest","Переработать")."</span>";
        else if ($dir == 1) echo "<span class='return ownharvest'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownharvest'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownharvest")." отправлен на ".PlanetTo($target, "ownharvest").". Задание: ".Cargo($m,$k,$d,"ownharvest","Переработать")."</span>";
    }
    else if ($mission == 9)            // Уничтожить
    {
        if ($dir == 0) echo "<span class='flight owndestroy'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owndestroy'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "owndestroy")." отправлен на ".PlanetTo($target, "owndestroy").". Задание: ".Cargo($m,$k,$d,"owndestroy","Уничтожить")."</span>";
        else if ($dir == 1) echo "<span class='return owndestroy'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='owndestroy'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a>, отправленный с ".PlanetFrom($origin, "owndestroy").", возвращается на ".PlanetTo($target, "owndestroy").". Задание: ".Cargo($m,$k,$d,"owndestroy","Уничтожить")."</span>";
        else if ($dir == 0x10) echo "<span class='flight destroy'>Боевой <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='destroy'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "destroy")." отправлен на ".PlanetTo($target, "destroy").". Задание: Уничтожить</span>";
    }
    else if ($mission == 10)            // Атака (ведущий флот САБа)
    {
        if ($dir == 0) echo "<span class='attack'>Ваш <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,0)."\");' onmouseout='return nd();' class='ownattack'>флот</a><a href='#' title='".TitleFleet($fleet,0)."'></a> с ".PlanetFrom($origin, "ownattack")." отправлен на ".PlanetTo($target, "ownattack").". Задание: ".Cargo($m,$k,$d,"ownattack","Атаковать")."</span>";
        else if ($dir == 0x10) echo "<span class='attack'>Боевой <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='attack'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "attack")." отправлен на ".PlanetTo($target, "attack").". Задание: Атаковать</span>";
        else if ($dir == 0x20) echo "<span class='ownattack'>Альянсовый <a href='#' onmouseover='return overlib(\"".OverFleet($fleet,1)."\");' onmouseout='return nd();' class='ownattack'>флот</a><a href='#' title='".TitleFleet($fleet,1)."'></a> игрока ".PlayerDetails($owner)." с ".PlanetFrom($origin, "ownattack")." отправлен на ".PlanetTo($target, "ownattack").". Задание: Атаковать</span>";
    }
    else echo "Задание Тип:$mission, Dir:$dir, Флот: " .TitleFleet($fleet,0). ", с " .PlanetFrom($origin, ""). " на " .PlanetTo($target, ""). ", " . Cargo ($m, $k, $d,"","Груз");
}

function GetMission ( $fleet_obj )
{
    if ( $fleet_obj['mission'] < 100 ) return $fleet_obj['mission'];
    else if ( $fleet_obj['mission'] < 200 ) return $fleet_obj['mission'] - 100;
    else return $fleet_obj['mission'] - 200;
}

function GetDirectionAssignment ( $fleet_obj, &$dir, &$assign )
{
    global $GlobalUser;

    if ($fleet_obj['mission'] < 100) $dir = 0;
    else if ($fleet_obj['mission'] < 200) $dir = 1;
    else $dir = 2;

    if ( $fleet_obj['owner_id'] == $GlobalUser['player_id'] ) $assign = 0;
    else $assign = 1;
}

function EventList ()
{
    global $GlobalUser;
    $fleetmap = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215 );

    // Одиночные флоты
    $tasklist = EnumFleetQueue ( $GlobalUser['player_id'] );
    $rows = dbrows ($tasklist);
    $task = array ();
    $tasknum = 0;
    while ($rows--)
    {
        $queue = dbarray ($tasklist);

        // Время отправления и прибытия
        $task[$tasknum]['start_time'] = $queue['start'];
        $task[$tasknum]['end_time'] = $queue['end'];

        $fleet_obj = LoadFleet ( $queue['sub_id'] );
        if ( $fleet_obj['union_id'] > 0 ) continue;        // Союзные флоты собираются отдельно

        // Флот
        $task[$tasknum]['fleets'] = 1;
        $task[$tasknum]['fleet'][0] = array ();
        foreach ( $fleetmap as $i=>$gid ) $task[$tasknum]['fleet'][0][$gid] = $fleet_obj["ship$gid"];
        $task[$tasknum]['fleet'][0]['owner_id'] = $fleet_obj['owner_id'];
        $task[$tasknum]['fleet'][0]['m'] = $fleet_obj['m'];
        $task[$tasknum]['fleet'][0]['k'] = $fleet_obj['k'];
        $task[$tasknum]['fleet'][0]['d'] = $fleet_obj['d'];
        $task[$tasknum]['fleet'][0]['origin_id'] = $fleet_obj['start_planet'];
        $task[$tasknum]['fleet'][0]['target_id'] = $fleet_obj['target_planet'];
        $task[$tasknum]['fleet'][0]['mission'] = GetMission ($fleet_obj);
        GetDirectionAssignment ($fleet_obj, &$task[$tasknum]['fleet'][0]['dir'], &$task[$tasknum]['fleet'][0]['assign'] );

        $tasknum++;

        // Для убывающих или удерживаемых флотов добавить псевдозадание возврата.
        // Не показывать возвраты чужих флотов и задание Оставить.
        if ( ($fleet_obj['mission'] < 100 || $fleet_obj['mission'] > 200) && $fleet_obj['owner_id'] == $GlobalUser['player_id'] && $fleet_obj['mission'] != 4 )
        {
            // Время отправления и прибытия
            $task[$tasknum]['start_time'] = $queue['end'];
            $task[$tasknum]['end_time'] = 2 * $queue['end'] - $queue['start'];

            // Флот
            $task[$tasknum]['fleets'] = 1;
            $task[$tasknum]['fleet'][0] = array ();
            foreach ( $fleetmap as $i=>$gid ) $task[$tasknum]['fleet'][0][$gid] = $fleet_obj["ship$gid"];
            $task[$tasknum]['fleet'][0]['owner_id'] = $fleet_obj['owner_id'];
            $task[$tasknum]['fleet'][0]['m'] = $task[$tasknum]['fleet'][0]['k'] = $task[$tasknum]['fleet'][0]['d'] = 0;
            $task[$tasknum]['fleet'][0]['origin_id'] = $fleet_obj['target_planet'];
            $task[$tasknum]['fleet'][0]['target_id'] = $fleet_obj['start_planet'];
            $task[$tasknum]['fleet'][0]['mission'] = GetMission ($fleet_obj);
            $task[$tasknum]['fleet'][0]['dir'] = 1;
            $task[$tasknum]['fleet'][0]['assign'] = 0;
            $tasknum++;
        }
    }

    // Союзные флоты
    $unions = EnumUnion ( $GlobalUser['player_id'] );
    foreach ( $unions as $u=>$union)
    {
        $queue = GetFleetQueue ($union['fleet_id']);

        // Время отправления и прибытия
        $task[$tasknum]['start_time'] = $queue['start'];
        $task[$tasknum]['end_time'] = $queue['end'];

        // Флоты
        $result = EnumUnionFleets ( $union['union_id'] );
        $task[$tasknum]['fleets'] = $rows = dbrows ( $result );
        $f = 0;
        while ($rows--)
        {
            $fleet_obj = dbarray ($result);
            $task[$tasknum]['fleet'][$f] = array ();
            foreach ( $fleetmap as $id=>$gid ) $task[$tasknum]['fleet'][$f][$gid] = $fleet_obj["ship$gid"];
            $task[$tasknum]['fleet'][$f]['owner_id'] = $fleet_obj['owner_id'];
            $task[$tasknum]['fleet'][$f]['m'] = $fleet_obj['m'];
            $task[$tasknum]['fleet'][$f]['k'] = $fleet_obj['k'];
            $task[$tasknum]['fleet'][$f]['d'] = $fleet_obj['d'];
            $task[$tasknum]['fleet'][$f]['origin_id'] = $fleet_obj['start_planet'];
            $task[$tasknum]['fleet'][$f]['target_id'] = $fleet_obj['target_planet'];
            $task[$tasknum]['fleet'][$f]['mission'] = GetMission ($fleet_obj);
            if ( $task[$tasknum]['fleet'][$f]['mission'] == 1) $task[$tasknum]['fleet'][$f]['mission'] = 10;
            GetDirectionAssignment ($fleet_obj, &$task[$tasknum]['fleet'][$f]['dir'], &$task[$tasknum]['fleet'][$f]['assign'] );
            $f++;
        }

        $tasknum++;
    }

    $anz = 0;
    if ($tasknum > 0)
    {
        sksort ( $task, 'end_time', true);        // Сортировать по времени прибытия.
        $now = time ();

        foreach ($task as $i=>$t)
        {
            $seconds = max($t['end_time']-$now, 0);
            if ( $seconds <= 0 ) continue;
            if ($t['fleets'] > 1) echo "<tr class=''>\n";
            else if ($t['dir'] == 0) echo "<tr class='flight'>\n";
            else if ($t['dir'] == 1) echo "<tr class='return'>\n";
            else if ($t['dir'] == 2) echo "<tr class='holding'>\n";
            echo "<th><div id='bxx".($i+1)."' title='".$seconds."'star='".$t['end_time']."'></div></th>\n";
            echo "<th colspan='3'>";
            for ($fl=0; $fl<$t['fleets']; $fl++)
            {
                echo FleetSpan ($t['fleet'][$fl]);
                if ($t['fleets'] > 1) echo "<br /><br />";
            }
            echo "</th></tr>\n\n";
            $anz++;
        }
        if ($anz) echo "<script language=javascript>anz=".$anz.";t();</script>\n\n";
    }
}

?>