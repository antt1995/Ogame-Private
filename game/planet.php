<?php

// Управление планетами и лунами: создание/колонизация, уничтожение, загрузка планет из БД, переименование.

/*
Позиции:
1-3: trockenplanet    101...110
4-6: dschjungel 18...30  201...210
7-9: normaltempplanet 301...307
10-12: wasserplanet 401...409
13-15: eisplanet -90...-82 501...510

Картинка случайным образом.

Диаметр планеты:
1-3: DIAM = RAND (50, 120) * 72
4-6: DIAM = RAND (50, 150) * 120
7-9: DIAM = RAND (50, 120) * 120
10-12: DIAM = RAND (50, 120) * 96
13-15: DIAM = RAND (50, 150) * 96

Температура (планеты):
1-3: 75 77 79 84 80 83
4-6: 22 29 25 24 25 21 27 21 26 20 22 21 21 20 23 28 27 30 18 19 25 31
7-9: -1 -3 -6 3 -4
10-12: -27 -34 -23 -27 -31 -25 -21 -29
13-15: -77 -90 -84 -85

Температура (луны):
1-3: 67 56 
4-6: 0 ... 19
7-9: -13 -15 -22 -17 -10 -17 -21 -16 -16 -22 -10 -19 -17 -13 -16 -10 -17 -20 -17 -18 -18 -28 -13 -19 -23 -11 -19 -23
10-12: -39 -40 -32 -42 -37 -45 -40 -49 -38 -39 -39 -38 -49 -51 -50 -33 -40 
13-15: -101 -93 -107 -102 -95 -105 -94 -98 -93 -97 -91  -95

Формулы для расчета размера луны:
Минимальный = floor (1000*(10 + 3 * Шанс)^0,5) km
Максимальный = floor (1000*(20 + 3 * Шанс)^0,5) km 

FIELDS = FLOOR ( (DIAM / 1000) ^ 2 )
DIAM = FX? ( FIELDS )

*/

/*
planet_id: Порядковый номер
name: Название планеты CHAR(20)
R type: тип планеты (порядковый номер картинки), если 0 - то это луна, если 10000 - это поле обломков, 10001 - уничтоженная планета, 10002 - фантом для колонизации, 10003 - уничтоженная луна
g,s,p: координаты где расположена планета
owner_id: Порядковый номер пользователя-владельца
R diameter: Диаметр планеты
R temp: Минимальная температура
fields: Количество застроенных полей
R maxfields: Максимальное количество полей
date: Дата создания
bXX: Уровень постройки
dXX: Количество оборонительных сооружений
fXX: Количество флота каждого типа
m, k, d: Металла, кристалла, дейтерия
mprod, kprod, dprod: Процент выработки шахт металла, кристалла, дейтерия ( 0...1 FLOAT)
sprod, fprod, ssprod: Процент выработки солнечной электростанции, термояда и солнечных спутников ( 0...1 FLOAT)
lastpeek: Время последнего обновления состояния планеты (INT UNSIGNED time)
lastakt: Время последней активности (INT UNSIGNED time)
gate_until: Время остывания  ворот. (INT UNSIGNED time)

R - случайные параметры

чистка систем от "уничтоженных планет" происходит каждые сутки в 01-10 по серверу.
существует "уничтоженная планета" 1 сутки (24 часа) + остаток времени до 01-10 серверного следующего за этими сутками дня.

поля обломков - это специальный тип планеты. (type: 10000)

*/

// Создать планету. Возвращает planet_id, или 0 если позиция занята.
// colony: 1 - создать колонию, 0 - Главная планета
// moon: 1 - создать луну
// moonchance: шанс возникновения луны (для размера луны)
function CreatePlanet ( $g, $s, $p, $owner_id, $colony=1, $moon=0, $moonchance=0)
{
    global $db_prefix;

    // Получить следующий уникальный номер
    $query = "SELECT * FROM ".$db_prefix."uni".";";
    $result = dbquery ($query);
    $unitab = dbarray ($result);
    $id = $unitab['nextplanet']++;

    // Проверить не занято-ли место?
    if ($moon) $query = "SELECT * FROM ".$db_prefix."planets WHERE g = '".$g."' AND s = '".$s."' AND p = '".$p."' AND ( type = 0 OR type = 10003 )";
    else $query = "SELECT * FROM ".$db_prefix."planets WHERE g = '".$g."' AND s = '".$s."' AND p = '".$p."' AND ( ( type > 0 AND type < 10000) OR type = 10001 )";
    $result = dbquery ($query);
    if ( dbrows ($result) != 0 ) return 0;

    // Название планеты.
    if ($moon) $name = "Луна";
    else
    {
        if ($colony) $name = "Колония";
        else $name = "Главная планета";
    }

    // Тип планеты.
    if ($moon) $type = 0;
    else
    {
        if ($p <= 3) $type = mt_rand (101, 110);
        else if ($p >= 4 && $p <= 6) $type = mt_rand (201, 210);
        else if ($p >= 7 && $p <= 9) $type = mt_rand (301, 307);
        else if ($p >= 10 && $p <= 12) $type = mt_rand (401, 409);
        else if ($p >= 13 && $p <= 15) $type = mt_rand (501, 510);
    }

    // Диаметр.
    if ($moon) $diam = floor ( 1000 * sqrt (mt_rand (10, 20) + 3*$moonchance)  );
    else
    {
        if ($colony)
        {
            if ($p <= 3) $diam = mt_rand ( 50, 120 ) * 72;
            else if ($p >= 4 && $p <= 6) $diam = mt_rand ( 50, 150 ) * 120;
            else if ($p >= 7 && $p <= 9) $diam = mt_rand ( 50, 120 ) * 120;
            else if ($p >= 10 && $p <= 12) $diam = mt_rand ( 50, 120 ) * 96;
            else if ($p >= 13 && $p <= 15) $diam = mt_rand ( 50, 150 ) * 96;
        }
        else $diam = 12800;
    }
    
    // Максимальное количество полей.
    $fields = floor (pow (($diam / 1000), 2));

    // Температура
    if ($p <= 3) $temp = mt_rand (75, 84);
    else if ($p >= 4 && $p <= 6) $temp = mt_rand (18, 31);
    else if ($p >= 7 && $p <= 9) $temp = mt_rand (-6, 3);
    else if ($p >= 10 && $p <= 12) $temp = mt_rand (-34, -21);
    else if ($p >= 13 && $p <= 15) $temp = mt_rand (-90, -77);
    if ( $moon ) $temp -= mt_rand (10, 20);

    // Добавить планету
    $now = time();
    if ($moon) $planet = array( $id, $name, $type, $g, $s, $p, $owner_id, $diam, $temp, 0, 0, $now,
                                          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
                                          0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                          0, 0, 0, 1, 1, 1, 1, 1, 1, $now, $now, 0 );
    else $planet = array( $id, $name, $type, $g, $s, $p, $owner_id, $diam, $temp, 0, $fields, $now,
                                 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
                                 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                 500, 500, 0, 1, 1, 1, 1, 1, 1, $now, $now, 0 );
    AddDBRow ( $planet, "planets" );

    // Увеличить уникальный номер на 1 для следующей планеты.
    $query = "UPDATE ".$db_prefix."uni"." SET nextplanet = ".$unitab['nextplanet'].";";
    dbquery ($query);
    return $id;
}

// Перечислить все планеты пользователя. Возвратить результат SQL-запроса.
function EnumPlanets ()
{
    global $db_prefix, $GlobalUser;
    $player_id = $GlobalUser['player_id'];

    // Получить тип сортировки.
    // sortby: Порядок сортировки планет: 0 - порядку колонизации (planet_id), 1 - координатам, 2 - алфавиту
    // sortorder: Порядок: 0 - по возрастанию, 1 - по убыванию
    $asc = $GlobalUser['sortorder'] == 0 ? "ASC" : "DESC";
    if ($GlobalUser['sortby'] == 0) $order = " ORDER BY planet_id $asc";
    else if ($GlobalUser['sortby'] == 1) $order = " ORDER BY g $asc, s $asc, p $asc";
    else if ($GlobalUser['sortby'] == 2) $order = " ORDER BY name $asc";    
    else $order = "";

    $query = "SELECT * FROM ".$db_prefix."planets WHERE owner_id = '".$player_id."' AND type < 10000".$order;
    $result = dbquery ($query);
    return $result;
}

// Перечислить все планеты в Галактике.
function EnumPlanetsGalaxy ($g, $s)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE g = '".$g."' AND s = '".$s."' AND (type > 0 AND type < 10002) AND type <> 10000 ORDER BY p ASC";
    $result = dbquery ($query);
    return $result;
}

// Получить состояние планеты (массив).
function GetPlanet ( $planet_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE planet_id = '".$planet_id."'";
    $result = dbquery ($query);
    if ( dbrows($result) == 0 ) return NULL;
    $planet = dbarray ($result);
    $user = LoadUser ( $planet['owner_id'] );
    $planet['mmax'] = store_capacity ( $planet['b22'] );
    $planet['kmax'] = store_capacity ( $planet['b23'] );
    $planet['dmax'] = store_capacity ( $planet['b24'] );
    $planet['emax'] = prod_solar($planet['b4'], $planet['sprod'])  + 
				       prod_fusion($planet['b12'], $user['r113'], $planet['fprod'])  + 
					 prod_sat($planet['temp']+40) * $planet['f212'] * $planet['ssprod'] ;

    $planet['econs'] = ( cons_metal ($planet['b1']) * $planet['mprod'] + 
                                 cons_crys ($planet['b2']) * $planet['kprod'] + 
                                 cons_deut ($planet['b3']) * $planet['dprod'] );

    $planet['e'] = floor ( $planet['emax'] - $planet['econs'] );
    $planet['factor'] = 1;
    if ( $planet['e'] < 0 ) $planet['factor'] = max (0, 1 - abs ($planet['e']) / $planet['econs']);
    return $planet;
}

// Загрузить состояние планеты по указанным координатам (без предварительной обработки)
// Вернуть массив $planet, или NULL.
function LoadPlanet ($g, $s, $p, $type)
{
    global $db_prefix;
    if ($type == 1) $query = "SELECT * FROM ".$db_prefix."planets WHERE g=$g AND s=$s AND p=$p AND (type > 0 AND type < 10000);";
    else if ($type == 2) $query = "SELECT * FROM ".$db_prefix."planets WHERE g=$g AND s=$s AND p=$p AND type=10000;";
    else if ($type == 3) $query = "SELECT * FROM ".$db_prefix."planets WHERE g=$g AND s=$s AND p=$p AND type=0;";
    else return NULL;
    $result = dbquery ($query);
    if ( $result ) return dbarray ($result);
    else return NULL;
}

// Если у планеты есть луна (даже уничтоженная), возвратить её ID, иначе возвратить 0.
function PlanetHasMoon ( $planet_id )
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE planet_id = '".$planet_id."'";
    $result = dbquery ($query);
    if ( dbrows ($result) == 0) return 0;    // Планета не найдена
    $planet = dbarray ($result);
    if ( $planet['type'] == 0) return 0;        // Планета сама является луной
    $query = "SELECT * FROM ".$db_prefix."planets WHERE g = '".$planet['g']."' AND s = '".$planet['s']."' AND p = '".$planet['p']."' AND type = 0 OR type = 10003";
    $result = dbquery ($query);
    if ( dbrows ($result) == 0) return 0;    // Луна у планеты не найдена.
    $planet = dbarray ($result);
    return $planet['planet_id'];
}

// Длина имени планеты не более 20 символов (слово (Луна) тоже учитывается)
// Из имени вырезаются следующие символы: / ' " * ( )
// Если в имени пристутствуют символы ; , < > \ ` то имя не изменяется.
// Если имя планеты пустое, она называется "планета"
// Больше одного пробела вырезается.
function RenamePlanet ($planet_id, $name)
{
    // Найти планету.
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE planet_id = '".$planet_id."'";
    $result = dbquery ($query);
    if ( dbrows ($result) == 0) return;    // Планета не найдена
    $planet = dbarray ($result);

    // Проверить название.
    if ( $planet['type'] == 0) $name = mb_substr ($name, 0, 20-mb_strlen(" (Луна)", "UTF-8"), "UTF-8");    // Ограничить длину имени.
    else $name = mb_substr ($name, 0, 20, "UTF-8");
    $pattern = '/[;,<>\`]/';
    if (preg_match ($pattern, $name)) return;    // Запрещенные символы.
    $pattern = '/[\\\\()*\"\']/';
    $name = preg_replace ($pattern, '', $name);
    if (strlen ($name) == 0) $name = "планета";
    $name = preg_replace ('/\s\s+/', ' ', $name);    // Вырезать лишние пробелы.

    // Если всё нормально - сменить имя планеты.
    $query = "UPDATE ".$db_prefix."planets SET name = '".$name."' WHERE planet_id = $planet_id";
    dbquery ($query);
}

// НИКАКИХ ПРОВЕРОК НЕ ПРОИЗВОДИТСЯ!!
function DestroyPlanet ($planet_id)
{
    global $db_prefix;
    $query = "DELETE FROM ".$db_prefix."planets WHERE planet_id = $planet_id";
    dbquery ($query);
}

// Обновить активность на планете
function UpdatePlanetActivity ( $planet_id)
{
    global $db_prefix;
    $now = time ();
    $query = "UPDATE ".$db_prefix."planets SET lastakt = $now WHERE planet_id = $planet_id";
    dbquery ($query);
}

// Управление полями обломков.
// Загрузка ПО осуществляется вызовом GetPlanet. Удаление ПО осуществляется вызовом DestroyPlanet.

// Проверяет, есть ли на данных координатах ПО. Возвращает id ПО, или 0.
function HasDebris ($g, $s, $p)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE g = $g AND s = $s AND p = $p AND type = 10000";
    $result = dbquery ($query);
    if ( dbrows ($result) == 0 ) return 0;
    $debris = dbarray ($result);
    return $debris['planet_id'];
}

// Создаёт новое ПО по указанным координатам
function CreateDebris ($g, $s, $p, $owner_id)
{
    global $db_prefix;
    $debris_id = HasDebris ($g, $s, $p);
    if ($debris_id > 0 ) return $debris_id;
    $now = time();
    $id = IncrementDBGlobal ( 'nextplanet' );
    $planet = array ( $id, "Поле обломков", 10000, $g, $s, $p, $owner_id, 0, 0, 0, 0, $now,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, $now, $now, 0 );
    AddDBRow ( $planet, 'planets' );
    return $id;
}

// Собрать ПО указанной грузоподъёмностью. В переменные m/k попадает собранное ПО.
function HarvestDebris ($id, $cargo, &$m, &$k)
{
    global $db_prefix;
    $debris = GetPlanet ($id);
    $m = max (min ($debris['m'], $cargo / 2), 0);
    $k = max (min ($debris['k'], $cargo / 2), 0);
    $now = time ();
    $planet_id = $debris['planet_id'];
    $query = "UPDATE ".$db_prefix."planets SET m = m - $m, k = k - $k, lastpeek = $now WHERE planet_id = $planet_id";
    dbquery ($query);
}

// Насыпать лома в указанное ПО
function AddDebris ($id, $m, $k)
{
    global $db_prefix;
    $now = time ();
    $query = "UPDATE ".$db_prefix."planets SET m = m + $m, k = k + $k, lastpeek = $now WHERE planet_id = $id";
    dbquery ($query);
}

// Получить игровой тип планеты.
function GetPlanetType ($planet)
{
    if ( $planet['type'] == 0) return 3;
    else if ( $planet['type'] == 10000) return 2;
    else return 1;
}

// Создать фантом колонизации. Вернуть ID.
function CreateColonyPhantom ($g, $s, $p, $owner_id)
{
    $id = IncrementDBGlobal ( 'nextplanet' );
    $planet = array( $id, "Planet", 10002, $g, $s, $p, $owner_id, 0, 0, 0, 0, time(),
                             0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
                             0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                             0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                             0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
    AddDBRow ( $planet, 'planets' );
    return $id;
}

// Покинуть планету.
function AbandonPlanet ($g, $s, $p)
{
    global $db_prefix;
    $now = time ();

    // Если на заданных координатах нет планеты, то просто добавить Уничтоженную планету.
    $query = "SELECT * FROM ".$db_prefix."planets WHERE g=$g AND s=$s AND p=$p AND ( type <> 0 AND type <> 10000 AND type <> 10003 );";
    $result = dbquery ($query);
    if ( dbrows ($result) == 0 ) 
    {
        $id = IncrementDBGlobal ( 'nextplanet' );
        $planet = array( $id, "Уничтоженная планета", 10001, $g, $s, $p, 99999, 0, 0, 0, 0, $now,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, $now, $now, 0 );
        AddDBRow ( $planet, 'planets' );
    }

    // Иначе изменить тип планеты на "Уничтоженная" и удалить луну, если есть.
    else
    {
        $planet = dbarray ($result);
        $query = "UPDATE ".$db_prefix."planets SET type = 10001, name = 'Уничтоженная планета', owner_id = 99999, date = $now, lastakt = $now WHERE planet_id = " . $planet['planet_id'] . ";";
        dbquery ( $query );
    }
}

// Проверить есть ли уже планета на заданных координатах (для Колонизации). Учитываются также уничтоженные планеты.
// Фантомы колонизации не учитываются (кто первый долетит)
function HasPlanet ($g, $s, $p)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."planets WHERE g=$g AND s=$s AND p=$p AND ( ( type > 0 AND type < 10000) OR type = 10001 );";
    $result = dbquery ($query);
    if ( dbrows ($result) ) return 1;
    else return 0;
}

// Название планеты / луны
function PlanetName ($planet)
{
    if ( $planet['type'] == 0 ) return $planet['name'] . " (".loca("MOON").")";
    else return $planet['name'];
}

// Изменить количество ресурсов на планете.
function AdjustResources ($m, $k, $d, $planet_id, $sign)
{
    global $db_prefix;
    $query = "UPDATE ".$db_prefix."planets SET m=m $sign '".$m."', k=k $sign '".$k."', d=d $sign '".$d."' WHERE planet_id=$planet_id;";
    //echo "$query<br>";
    dbquery ($query);
}

?>