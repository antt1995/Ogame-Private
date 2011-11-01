<?php

// Альянсовая система.

// Аббревиатуры не могут совпадать, а названия могут.

// Записи альянса в БД (ally).
// ally_id: Порядковый номер альянса (INT)
// tag: Аббревиатура альянса, 3-8 символов (CHAR(8))
// name: Название альянса, 3-30 символов (CHAR(30))
// owner_id: ID основателя
// homepage: URL домашней страницы
// imglogo: URL картинки логотипа
// open: 0 - заявки запрещены (набор в альянс закрыт), 1 - заявки разрешены.
// insertapp: 1 - автоматически подставлять шаблон заявки, 0 - не вставлять шаблон
// exttext: Внешний текст (TEXT)
// inttext: Внутренний текст (TEXT)
// apptext: Текст заявки (TEXT)
// nextrank: Порядковый номер следующего ранга (INT)

// Создать альянс. Возвращает ID альянса.
function CreateAlly ($owner_id, $tag, $name)
{
    global $db_prefix;
    $tag = mb_substr ($tag, 0, 8, "UTF-8");    // Огранчить длину строк
    $name = mb_substr ($name, 0, 30, "UTF-8");

    // Добавить альянс.
    $ally = array( '', $tag, $name, $owner_id, "", "", 1, 0, "Добро пожаловать на страничку альянса", "", "", 0, "", "", 0, 0,
                        0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0, 0, 0, 0 );
    $id = AddDBRow ( $ally, "ally" );

    // Добавить ранги "Основатель" (0) и "Новичок" (1) .
    SetRank ( $id, AddRank ( $id, "Основатель" ), 0x1FF );
    SetRank ( $id, AddRank ( $id, "Новичок" ), 0 );

    // Обновить информацию пользователя-основателя.
    $joindate = time ();
    $query = "UPDATE ".$db_prefix."users SET ally_id = $id, joindate = $joindate, allyrank = 0 WHERE player_id = $owner_id";
    dbquery ($query);

    return $id;
}

// Распустить альянс.
function DismissAlly ($ally_id)
{
}

// Перечислить всех игроков альянса.
function EnumerateAlly ($ally_id, $sort_by=0, $order=0)
{
    global $db_prefix;
    if ($ally_id <= 0) return NULL;
    $query = "SELECT * FROM ".$db_prefix."users WHERE ally_id = $ally_id";
    $result = dbquery ($query);
    return $result;
}

// Узнать существует-ли альянс с указанной аббревиатурой.
function IsAllyTagExist ($tag)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."ally WHERE tag = '".$tag."'";
    $result = dbquery ($query);
    if (dbrows ($result)) return true;
    else return false;
}

// Загрузить альянс.
function LoadAlly ($ally_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."ally WHERE ally_id = $ally_id";
    $result = dbquery ($query);
    return dbarray ($result);
}

// Поиск альянсов по аббревиатуре. Возвращает результат SQL-запроса.
function SearchAllyTag ($tag)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."ally WHERE tag LIKE '%".$tag."%' LIMIT 30";
    $result = dbquery ($query);
    return $result;
}

// Посчитать количество пользователей в альянсе.
function CountAllyMembers ($ally_id)
{
    global $db_prefix;
    if ( $ally_id <= 0 ) return 0;
    $result = EnumerateAlly ($ally_id);
    return dbrows ($result);
}

// Изменить аббревиатуру альянса. Можно делать раз в 7 дней.
function AllyChangeTag ($ally_id, $tag)
{
    global $db_prefix;
    $now = time ();
    $ally = LoadAlly ($ally_id);
    if ( $now < $ally['tag_until'] ) return false;    // Время ещё пришло.
    if ( $ally['tag'] === $tag ) return false;
    $until = $now + 7 * 24 * 60 * 60;
    $query = "UPDATE ".$db_prefix."ally SET old_tag = tag, tag = '".$tag."', tag_until = $until WHERE ally_id = $ally_id";
    dbquery ($query);
    return true;
}

// Изменить название альянса. Можно делать раз в 7 дней.
function AllyChangeName ($ally_id, $name)
{
    global $db_prefix;
    $now = time ();
    $ally = LoadAlly ($ally_id);
    if ( $now < $ally['name_until'] ) return false;    // Время ещё пришло.
    if ( $ally['name'] === $name ) return false;
    $until = $now + 7 * 24 * 60 * 60;
    $query = "UPDATE ".$db_prefix."ally SET old_name = name, name = '".$name."', name_until = $until WHERE ally_id = $ally_id";
    dbquery ($query);
    return true;
}

// Пересчитать места всех альянсов.
function RecalcAllyRanks ()
{
    global $db_prefix;

    // Очки
    dbquery ("SET @pos := 0;");
    $query = "UPDATE ".$db_prefix."ally
              SET place1 = (SELECT @pos := @pos+1)
              ORDER BY score1 DESC";
    dbquery ($query);

    // Флот
    dbquery ("SET @pos := 0;");
    $query = "UPDATE ".$db_prefix."ally
              SET place2 = (SELECT @pos := @pos+1)
              ORDER BY score2 DESC";
    dbquery ($query);

    // Исследования
    dbquery ("SET @pos := 0;");
    $query = "UPDATE ".$db_prefix."ally
              SET place3 = (SELECT @pos := @pos+1)
              ORDER BY score3 DESC";
    dbquery ($query);
}

// ****************************************************************************
// Ранги.

// Разрешенные символы в названии ранга: [a-zA-Z0-9_-.]. Макс. длина - 30 символов
// Названия могут совпадать.
// Не более 25 рангов на альянс.

// 0x001: Распустить альянс
// 0x002: Выгнать игрока
// 0x004: Посмотреть заявления
// 0x008: Посмотреть список членов
// 0x010: Редактировать заявления
// 0x020: Управление альянсом
// 0x040: Посмотреть статус "он-лайн" в списке членов
// 0x080: Составить общее сообщение
// 0x100: 'Правая рука' (необходимо для передачи статуса основателя)

// Записи рангов в БД (allyranks).
// rank_id: Порядковый номер ранга (INT)
// ally_id: ID альянса, которому принадлжит ранг
// name: Название ранга (CHAR(30))
// rights: Права (OR маска)

// Добавить ранг с нулевыми правами в альянс. Возвращает порядковый номер ранга.
function AddRank ($ally_id, $name)
{
    global $db_prefix;
    if ($ally_id <= 0) return 0;
    $ally = LoadAlly ($ally_id);
    $rank = array ( $ally['nextrank'], $ally_id, $name, 0 );
    $opt = " (";
    foreach ($rank as $i=>$entry)
    {
        if ($i != 0) $opt .= ", ";
        $opt .= "'".$rank[$i]."'";
    }
    $opt .= ")";
    $query = "INSERT INTO ".$db_prefix."allyranks VALUES".$opt;
    dbquery ($query);
    $query = "UPDATE ".$db_prefix."ally SET nextrank = nextrank + 1 WHERE ally_id = $ally_id";
    dbquery ($query);
    return $ally['nextrank'];
}

// Сохранить права для ранга.
function SetRank ($ally_id, $rank_id, $rights)
{
    global $db_prefix;
    $query = "UPDATE ".$db_prefix."allyranks SET rights = $rights WHERE ally_id = $ally_id AND rank_id = $rank_id";
    dbquery ($query);
}

// Удалить ранг из альянса.
function RemoveRank ($ally_id, $rank_id)
{
    global $db_prefix;
    $query = "DELETE FROM ".$db_prefix."allyranks WHERE ally_id = $ally_id AND rank_id = $rank_id";
    dbquery ($query);
}

// Перечислить все ранги в альянсе.
function EnumRanks ($ally_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."allyranks WHERE ally_id = $ally_id";
    return dbquery ($query);
}

// Назначить ранг определенному игроку.
function SetUserRank ($player_id, $rank)
{
    global $db_prefix;
    $query = "UPDATE ".$db_prefix."users SET allyrank = $rank WHERE player_id = $player_id";
    dbquery ($query);
}

// Загрузить ранг.
function LoadRank ($ally_id, $rank_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."allyranks WHERE ally_id = $ally_id AND rank_id = $rank_id";
    $result = dbquery ($query);
    return dbarray ($result);
}

// ****************************************************************************
// Заявки на вступление в альянс.

// Записи заявок в БД (allyapps).
// app_id: Порядковый номер заявки (INT)
// ally_id: ID альянса, которому принадлежит заявка
// player_id: Номер пользователя, отправившего заявку 
// text: Текст заявки (TEXT)
// date: Дата подачи заявления time() (INT UNSIGNED)

// Добавить заявку в альянс. Возвращает порядковый номер заявки.
function AddApplication ($ally_id, $player_id, $text)
{
    $app = array ( '', $ally_id, $player_id, $text, time() );
    $id = AddDBRow ( $app, "allyapps" );
    return $id;
}

// Удалить заявку.
function RemoveApplication ($app_id)
{
    global $db_prefix;
    $query = "DELETE FROM ".$db_prefix."allyapps WHERE app_id = $app_id";
    dbquery ($query);
}

// Перечислить все заявки в альянсе.
function EnumApplications ($ally_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."allyapps WHERE ally_id = $ally_id";
    return dbquery ($query);
}

// Пользователь уже подал заявку в альянс ? Если да - вернуть ID заявления, иначе вернуть 0.
function GetUserApplication ($player_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."allyapps WHERE player_id = $player_id";
    $result = dbquery ($query);
    if ( dbrows ($result) > 0 )
    {
        $app = dbarray ($result);
        return $app['app_id'];
    }
    else return 0;
}

// Загрузить заявление.
function LoadApplication ($app_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."allyapps WHERE app_id = $app_id";
    $result = dbquery ($query);
    return dbarray ($result);
}

// ****************************************************************************

// Малая альянсовая система (Друзья). Не более 16 друзей.

// Записи в БД (buddy)
// buddy_id: Порядковый номер записи в таблице
// request_from: Номер пользователя который послал запрос
// request_to: Номер пользователя которому послали запрос
// text: Текст запроса (TEXT)
// accepted: Запрос подвержден. Пользователи - друзья.

// Возвращает ID запроса, если запрос  послан, или 0, если предложение подружиться уже подано.
function AddBuddy ($from, $to, $text)
{
    global $db_prefix;
    $text = mb_substr ($text, 0, 5000, "UTF-8");    // Огранчить длину строк
    if ($text === "") $text = "пусто";

    // Проверить заявки, ожидающие подтверждения.
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE ((request_from = $from AND request_to = $to) OR (request_from = $to AND request_to = $from)) AND accepted = 0";
    $result = dbquery ($query);
    if ( dbrows($result) ) return 0;

    // Пользователи уже друзья?
    if ( IsBuddy ($from, $to) ) return 0;

    // Добавить запрос.
    $buddy = array( '', $from, $to, $text, 0 );
    $id = AddDBRow ( $buddy, "buddy" );
    return $id;
}

// Удалить запрос дружбы.
function RemoveBuddy ($buddy_id)
{
    global $db_prefix;
    $query = "DELETE FROM ".$db_prefix."buddy WHERE buddy_id = $buddy_id";
    dbquery ($query);
}

// Подтвердить запрос дружбы.
function AcceptBuddy ($buddy_id)
{
    global $db_prefix;
    $query = "UPDATE ".$db_prefix."buddy SET accepted = 1 WHERE buddy_id = $buddy_id";
    dbquery ($query);
}

// Загрузить запос.
function LoadBuddy ($buddy_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE buddy_id = $buddy_id";
    $result = dbquery ($query);
    return dbarray ($result);
}

// Перечислить все отправленные запросы игрока (свои).
function EnumOutcomeBuddy ($player_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE request_from = $player_id AND accepted = 0";
    return dbquery ($query);
}

// Перечислить все входящие запросы (чужие).
function EnumIncomeBuddy ($player_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE request_to = $player_id AND accepted = 0";
    return dbquery ($query);
}

// Перечислить всех друзей игрока.
function EnumBuddy ($player_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE (request_from = $player_id OR request_to = $player_id) AND accepted = 1";
    return dbquery ($query);
}

// Проверить являются-ли игроки друзьями.
function IsBuddy ($player1, $player2)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."buddy WHERE ((request_from = $player1 AND request_to = $player2) OR (request_from = $player2 AND request_to = $player1)) AND accepted = 1";
    $result = dbquery ($query);
    if ( dbrows($result)) return true;
    else return false;
}

?>