<?php

// Настройки.

$OptionsMessage = "";
$OptionsError = "";

SecurityCheck ( '/[0-9a-f]{12}/', $_GET['session'], "Манипулирование публичной сессией" );
if (CheckSession ( $_GET['session'] ) == FALSE) die ();

loca_add ( "common", $GlobalUser['lang'] );
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

function IsChecked ($option)
{
    global $GlobalUser;
    if ( $GlobalUser[$option] ) return "checked=checked";
    else return "";
}

function IsSelected ($option, $value)
{
    global $GlobalUser;
    if ( $GlobalUser[$option] == $value ) return "selected";
    else return "";
}

PageHeader ("options");

$unitab = LoadUniverse ();
$speed = $unitab['speed'];
?>

<!-- CONTENT AREA -->
<div id='content'>
<center>
 <table width="519">

<?php

    // Выключить Режим Отпуска.
    if ( method () === "POST") {

        if ( time () >= $GlobalUser['vacation_until'] && $_POST['urlaub_aus'] === "on" && $GlobalUser['vacation'] )
        {
            $OptionsError = "Ну что, ".$GlobalUser['oname'].", как был отдых?. Не забудьте восстановить производство сырья и удачи в дальнейшей игре.\n<br/>\n";
            $query = "UPDATE ".$db_prefix."users SET vacation=0,vacation_until=0 WHERE player_id=".$GlobalUser['player_id'];
            dbquery ($query);
            $GlobalUser['vacation'] = $GlobalUser['vacation_until'] = 0;
        }
    }

    // ======================================================================================
    // Аккаунт неактивирован.

    if ( $GlobalUser['validated'] == 0 ) {

        // Обработать POST-запрос.
        if ( method () === "POST") {

            print_r ($_POST);
        }

?>

 <form action="index.php?page=options&session=<?=$session;?>&mode=change" method="POST" > 
        <input type="hidden" name="design"     value='on' /> 
    <tr><td class="c" colspan ="2">Данные пользователя</td></tr> 
    <tr> 
        <th><a title="Этот адрес можно в любое время изменить. Через 7 дней без изменений он станет постоянным.">Адрес</a></th> 
        <th><input type="text" name="db_email" maxlength="100" size="20" value="<?=$GlobalUser['email'];?>" /></th> 
    </tr> 
    <tr> 
        <th>Пароль</th> 
        <th><input type="password" name="db_password" size ="20" value="" /></th> 
    </tr> 
    <tr> 
        <th colspan=2><input type="submit" value="Используйте введённый адрес" /></th> 
    </tr> 
    </form> 
    <form action="index.php?page=options&session=<?=$session;?>" method="POST" > 
    <input type=hidden name="validate" value="1"> 
    <tr> 
        <th colspan=2> 
                    <p style="color:#ff0000;padding-top:10px;padding-bottom:5px;">Ваш игровой акаунт ещё не активирован. Тут Вы можете заказать письмо с активационной ссылкой.</p> 
            <input type="submit" value="Заказать активационную ссылку" /> 
        </th> 
    </tr> 
   </form> 
 </table> 

<?php
    // ======================================================================================
    // Режим отпуска включен.

    }
    else if ( $GlobalUser['vacation'] )
    {

?>

 <form action="index.php?page=options&session=<?=$session;?>&mode=change" method="POST" >
  <tr> <td class="c" colspan="2">Режим отпуска</td>  </tr>
  <tr>   </tr>
  <tr> <th colspan=2>   Режим отпуска включён. Отпуск минимум до:<br />
     <?=date ("d.m.Y. H:i:s", $GlobalUser['vacation_until']);?>   </th>   </tr>
<?php
    if ( time () >= $GlobalUser['vacation_until'] )
    {
?>
     <tr>
   <th>
      отключить   </th>
   <th><input type="checkbox" name="urlaub_aus" />
   </th>
  </tr>
<?php
    }
    else
    {
?>
             <tr>
               <th><a title="Если поставить здесь галочку, то через 7 дней аккаунт автоматически полностью удалится.">Удалить аккаунт</a></th>
               <th><input type="checkbox" name="db_deaktjava" <?=IsChecked("disable");?> />
      <?php
    if ($GlobalUser['disable']) echo "am: " . date ("Y-m-d H:i:s", $GlobalUser['disable_until']) . "<input type='hidden' name=loeschen_am value=".date ("Y-m-d H:i:s", $GlobalUser['disable_until']).">";
?>           </th>
              </tr>
<?php
    }
?>

     <tr>   <th colspan=2><input type="submit" value="Сохранить изменения" /></th>  </tr>
 </form>
 </table>

<?php
    // ======================================================================================
    // Обычное меню.

    }
    else
    {

        // Обработать POST-запрос.
        if ( method () === "POST" && !key_exists ( 'urlaub_aus', $_POST) ) {

            if ( $GlobalUser['name_changed'] == 0 && $_POST['db_character'] !== $GlobalUser['oname'] ) {        // Сменить имя.
                $forbidden = explode ( ",", "hitler, fick, adolf, legor, aleena, ogame, mainman, fishware, osama, bin laden, stalin, goebbels, drecksjude, saddam, space, ringkeeper, administration" );
                if ( IsUserExist ( $_POST['db_character'] )) $OptionsError = "Это имя уже существует.";
                else if ( mb_strlen ($_POST['db_character']) < 3 || mb_strlen ($_POST['db_character']) > 20 ) $OptionsError = "Имя должно содержать от 3-х до 20-ти символов.";
                else if ( preg_match ( '/[<>()\[\]{}\\\\\/\`\"\'.,:;*+]/', $_POST['db_character'] )) $OptionsError = "Имя не должно содержать спец-символы.";
                $lower = mb_strtolower ($_POST['db_character'], 'UTF-8');
                foreach ( $forbidden as $i=>$name) {
                    if ( $lower === $name ) $OptionsError = "Недопустимое имя!";
                }

                if ( $OptionsError === "" )
                {
                    ChangeName ( $GlobalUser['player_id'], $_POST['db_character'] );
                    $OptionsError = "Имя пользователя изменено. Раз в неделю это возможно. Войдите снова.";
                    $GlobalUser['name_changed'] = 1;
                    $GlobalUser['oname'] = $_POST['db_character'] ;
                    Logout ( $GlobalUser['session'] );
                }
            }

            else if ( $_POST['newpass1'] !== "" ) {        // Сменить пароль

                if ( $_POST['newpass1'] !== $_POST['newpass2'] ) $OptionsError = "Новые пароли не совпадают.";
                else if ( !preg_match ( "/^[_a-zA-Z0-9]+$/", $_POST['newpass1'] ) ) $OptionsError = "Пароль содержит особый символ.";
                else if ( strlen ( $_POST['newpass1'] ) < 8 ) $OptionsError = "Пароль должен состоять минимум из 8 символов";
                else if ( $GlobalUser['password'] !== md5 ($_POST['db_password'] . $db_secret ) ) $OptionsError = "Неправильный старый пароль.";

                //Вы хотите использовать небезопасный пароль, измените его на более безопасный.

                if ( $OptionsError === "" )
                {
                    $md5 = md5 ($_POST['newpass1'] . $db_secret );
                    $query = "UPDATE ".$db_prefix."users SET password = '".$md5."' WHERE player_id = " . $GlobalUser['player_id'];
                    dbquery ($query);
                    $OptionsError = "Пароль изменён.";
                    Logout ( $GlobalUser['session'] );
                }
            }

            else if ( $_POST['db_email'] !== $GlobalUser['pemail'] && $_POST['db_email'] !== "" ) {        // Сменить адрес
                echo "Сменить адрес<br>";
            }

            if ( $_POST['urlaubs_modus'] === "on" && $GlobalUser['vacation'] == 0 ) {        // Включить режим отпуска
                $vacation_min = max ( 12*60*60, (2 * 24 * 60 * 60) / $speed);    // не менее 12 часов
                $vacation_until = time() + $vacation_min;

                if ( CanEnableVacation ($GlobalUser['player_id']) ) {
                    $query = "UPDATE ".$db_prefix."users SET vacation=1,vacation_until=$vacation_until WHERE player_id=".$GlobalUser['player_id'];
                    dbquery ($query);
                    $GlobalUser['vacation'] = 1;
                    $GlobalUser['vacation_until'] = $vacation_until;
                    $query = "UPDATE ".$db_prefix."planets SET mprod = 0, kprod = 0, dprod = 0, sprod = 0, fprod = 0, ssprod = 0 WHERE owner_id = " . $GlobalUser['player_id'];
                    dbquery ($query);
                    MyGoto ( "options" );
                }
                else $OptionsError = "Режим отпуска включается только тогда, когда на планете ничего не строится и не исследуется.";
            }

            if ( $_POST['db_deaktjava'] === "on" && $GlobalUser['disable'] == 0 ) {        // Поставить аккаунт на удаление
                $disable_until = time() + (7 * 24 * 60 * 60);

                $query = "UPDATE ".$db_prefix."users SET disable=1,disable_until=$disable_until WHERE player_id=".$GlobalUser['player_id'];
                dbquery ($query);
                $GlobalUser['disable'] = 1;
                $GlobalUser['disable_until'] = $disable_until;
            }

            if ( !key_exists("db_deaktjava", $_POST) && $GlobalUser['disable'] ) {    // Отменить удаление аккаунта
                $query = "UPDATE ".$db_prefix."users SET disable=0,disable_until=0 WHERE player_id=".$GlobalUser['player_id'];
                dbquery ($query);
                $GlobalUser['disable'] = 0;
                $GlobalUser['disable_until'] = 0;
            }

            // Сохранить путь к скину + галочка показывать/выключить скин.
            //Это внешний путь для скина. ID этой сессии на используемом сервере может быть опознан!
            ChangeSkinPath ( $GlobalUser['player_id'], $_POST['dpath'] );
            EnableSkin ( $GlobalUser['player_id'], ($_POST['design']==="on"?1:0) );

            $redesign = ( $_POST['dpath'] === "redesign" ) ? 1 : 0;
            $lang = substr ( addslashes($_POST['lang']), 0, 2 );
            $sortby = min ( max(0, intval($_POST['settings_sort'])), 2);
            $sortorder = min ( max(0, intval($_POST['settings_order'])), 1);
            $deactip = (int) key_exists ( 'noipcheck', $_POST );
            $maxspy = min( max (1, intval($_POST['spio_anz'])), 99);
            $maxfleetmsg = min( max (1, intval($_POST['settings_fleetactions'])), 99);
            $query = "UPDATE ".$db_prefix."users SET redesign=$redesign, deact_ip=$deactip, sortby=$sortby, sortorder=$sortorder, maxspy=$maxspy, maxfleetmsg=$maxfleetmsg, lang='".$lang."' WHERE player_id=".$GlobalUser['player_id'];
            dbquery ($query);
            $GlobalUser['sortby'] = $sortby;
            $GlobalUser['sortorder'] = $sortorder;
            $GlobalUser['maxspy'] = $maxspy;
            $GlobalUser['maxfleetmsg'] = $maxfleetmsg;
            $GlobalUser['lang'] = $lang;
            $GlobalUser['deact_ip'] = $deactip;
            $GlobalUser['redesign'] = $redesign;
            $GlobalUser['skin'] = $_POST['dpath'];
            $GlobalUser['useskin'] = ($_POST['design']==="on"?1:0);
        }
?>

 <form action="index.php?page=options&session=<?=$session;?>&mode=change" method="POST" >
     <tr><td class="c" colspan ="2">Данные пользователя</td></tr>
<tr>
<?php
    if ( $GlobalUser['name_changed'] )
    {
?>
      <th><a title="Имя можно изменять только раз в 7 дней.">Имя</a></th>
   <th><?=$GlobalUser['oname'];?></th>
<?php
    }
    else
    {
?>
      <th>Имя</th>
   <th><input type="text" name="db_character" size ="20" value="<?=$GlobalUser['oname'];?>" /><br/></th>
<?php
    }
?>

    </tr>
  <tr>
  <th>Старый пароль</th>

   <th><input type="password" name="db_password" size ="20" value="" /></th>
  </tr>
  <tr>
  <th>Новый пароль (мин. 8 символов)</th>
   <th><input type="password" name="newpass1" size="20" maxlength="40" /></th>
  </tr>
  <tr>
  <th>Новый пароль (подтверждение)</th>

   <th><input type="password" name="newpass2" size="20" maxlength="40" /></th>
  </tr>
  <tr>
  <th><a title="Этот адрес можно в любое время изменить. Через 7 дней без изменений он станет постоянным.">Адрес</a></th>
  <th><input type="text" name="db_email" maxlength="100" size="20" value="<?=$GlobalUser['email'];?>" /></th>
  </tr>
  <tr>
  <th>Постоянный адрес</th>

   <th><?=$GlobalUser['pemail'];?></th>
  </tr>
   <tr><th colspan="2">
  </tr>
  <tr>
  <td class="c" colspan="2">Общие настройки</td>
  </tr>
  <tr>

   <th>Язык:</th>
   <th>
   <select name="lang">
<?php
    foreach ( $Languages as $lang_id=>$lang_name ) {
        echo "    <option value=\"".$lang_id."\" " . IsSelected("lang", $lang_id)." >$lang_name</option>\n";
    }
?>
   </select>
   </th>
  </tr>

   <th>Сортировка планет по:</th>
   <th>
   <select name="settings_sort">
    <option value="0" <?=IsSelected("sortby", 0);?> >порядку колонизации</option>
    <option value="1" <?=IsSelected("sortby", 1);?> >координатам</option>
    <option value="2" <?=IsSelected("sortby", 2);?> >алфавиту</option>
   </select>

   </th>
  </tr>
  <tr>
   <th>Порядок сортировки:</th>
   <th>
   <select name="settings_order">
     <option value="0" <?=IsSelected("sortorder", 0);?>>по возрастанию</option>
     <option value="1" <?=IsSelected("sortorder", 1);?>>по убыванию</option>

   </select>
   </th>
 </tr>

  <th>Путь для скинов (напр. C:/ogame/kartinki/)<br /> <a href="http://oldogame.ru/download/" target="_blank">Скачать</a></th>
   <th><input type=text name="dpath" maxlength="80" size="40" value="<?=$GlobalUser['skin'];?>" /> <br />
  <?php
            // Если путь к скину пустой выдать список доступных скинов на сервере графики.
            if ( $GlobalUser['skin'] === "" ) {
    ?>
  <select name="dpath" size="1" >
   <option selected>  </option>
      <option value="http://oldogame.ru/download/use/allesnurgeklaut/">allesnurgeklaut </option>
      <option value="http://oldogame.ru/download/use/ally-cpb/">allycpb </option>
      <option value="http://oldogame.ru/download/use/asgard/">asgard </option>
      <option value="http://oldogame.ru/download/use/aurora/">aurora </option>
      <option value="http://oldogame.ru/download/use/bluedream/">bluedream </option>
      <option value="http://oldogame.ru/download/use/bluegalaxy/">bluegalaxy </option>
      <option value="http://oldogame.ru/download/use/blueplanet/">blueplanet </option>
      <option value="http://oldogame.ru/download/use/bluechaos/">bluechaos </option>
      <option value="http://oldogame.ru/download/use/bluemx/">blue-mx </option>
      <option value="http://oldogame.ru/download/use/brace/">brace </option>
      <option value="http://oldogame.ru/download/use/brotstyle/">brotstyle </option>
      <option value="http://oldogame.ru/download/use/dd/">dd </option>
      <option value="http://oldogame.ru/download/use/eclipse/">eclipse </option>
      <option value="http://oldogame.ru/download/use/empire/">empire </option>
      <option value="http://oldogame.ru/download/use/EpicBlue/">epicblue </option>
      <option value="http://oldogame.ru/download/use/evolution/">evolution </option>
      <option value="http://oldogame.ru/download/use/freakyfriday/">freakyfriday </option>
      <option value="http://oldogame.ru/download/use/g3cko/">g3cko </option>
      <option value="http://oldogame.ru/download/use/gruen/">gruen </option>
      <option value="http://oldogame.ru/download/use/infraos/">infraos </option>
      <option value="http://oldogame.ru/download/use/lambda/">lambda </option>
      <option value="http://oldogame.ru/download/use/lego/">lego </option>
      <option value="http://oldogame.ru/download/use/militaryskin/">militaryskin </option>
      <option value="http://oldogame.ru/download/use/okno/">okno </option>
      <option value="http://oldogame.ru/download/use/ovisio/">ovisio </option>
      <option value="http://oldogame.ru/download/use/ovisiofarbig/">ovisiofarbig </option>
      <option value="http://oldogame.ru/download/use/Paint/">paint </option>
      <option value="http://oldogame.ru/download/use/quadratorstyle/">quadratorstyle </option>
      <option value="http://oldogame.ru/download/use/real/">real </option>
      <option value="http://oldogame.ru/download/use/redfuturistisch/">redfuturistisch </option>
      <option value="http://oldogame.ru/download/use/redvision/">redvision </option>
      <option value="http://oldogame.ru/download/use/reloaded/">reloaded </option>
      <option value="http://oldogame.ru/download/use/shadowpato/">shadowpato </option>
      <option value="http://oldogame.ru/download/use/simpel/">simpel </option>
      <option value="http://oldogame.ru/download/use/starwars/">starwars </option>
      <option value="http://oldogame.ru/download/use/w4wooden4ce/">w4wooden4ce </option>
      <option value="http://oldogame.ru/download/use/xonic/">xonic </option>
    <?php
            }
  ?>
  </select>

   </th>
  </tr>
  <tr>
  <th>Показать скин</th>
   <th>
    <input type="checkbox" name="design"
    <?=IsChecked("useskin");?> />
   </th>
  </tr>

  <tr>
    <th><a title="Проверка IP означает, что автоматически последует выгрузка, если меняется IP или двое людей с разными IP зашли под одним аккаунтом. Отключение проверки IP может быть небезопасным!">Деактивировать проверку IP</a></th>
   <th><input type="checkbox" name="noipcheck"  <?=IsChecked("deact_ip");?>/></th>
  </tr>
  <tr>
   <td class="c" colspan="2">Настройки просмотра галактики</td>
  </tr>
  <tr>

   <th><a title="Кол-во шпионских зондов, которые при каждом сканировании посылаются из меню Галактика.">Кол-во шпионских зондов</a></th>
   <th><input type="text" name="spio_anz" maxlength="2" size="2" value="<?=$GlobalUser['maxspy'];?>" /></th>
  </tr>
  <!--<tr>
   <th>Просмотреть название</th>
   <th><input type="text" name="settings_tooltiptime" maxlength="2" size="2" value="0" /> сек.</th>
  </tr>-->
  <tr>
   <th>Максимальные сообщения о флоте</th>
   <th><input type="text" name="settings_fleetactions" maxlength="2" size="2" value="<?=$GlobalUser['maxfleetmsg'];?>" /></th>
  </tr>

<?php
    if (0)    // Дополнительные настройки Командира
    {
?>
  </tr>
     <tr>
   <th>Сочетания клавиш</th>
   <th>показать</th>
  </tr>
      <tr>
   <th><img src="<?=UserSkin();?>img/e.gif" alt="" />   Шпионаж</th>

   <th><input type="checkbox" name="settings_esp" checked='checked'/></th>
   </tr>
      <tr>
   <th><img src="<?=UserSkin();?>img/m.gif" alt="" />   Написать сообщение</th>
   <th><input type="checkbox" name="settings_wri" checked='checked'/></th>
   </tr>
      <tr>
   <th><img src="<?=UserSkin();?>img/b.gif" alt="" />   Предложение стать другом</th>

   <th><input type="checkbox" name="settings_bud" checked='checked'/></th>
   </tr>
      <tr>
   <th><img src="<?=UserSkin();?>img/r.gif" alt="" />   Ракетная атака</th>
   <th><input type="checkbox" name="settings_mis" checked='checked'/></th>
   </tr>
      <tr>
   <th><img src="<?=UserSkin();?>img/s.gif" alt="" />   Просмотреть сообщение</th>

   <th><input type="checkbox" name="settings_rep" checked='checked'/></th>
   </tr>
      <tr>
   <td class="c" colspan="2">Настройки сообщений</td>
   <tr>
   <th>не сортировать по папкам</th>
  <th><input type="checkbox" name="settings_folders"  checked='checked'/></th>
</tr>

<tr>
    <td class="c" colspan="2"><font color='FF8900'>Newsfeed</font></td>
</tr>
<tr>
    <th>Активировать<input type=hidden name="feed_submit" value="1"></th>
    <th><input type="checkbox" name="feed_activated"  /></th>
</tr>
<?php
    }
?>

      
  <tr>
     <td class="c" colspan="2">Режим отпуска / Удалить аккаунт</td>
  </tr>
  <tr>
     <th><a title="Режим отпуска предназначен для того, чтобы оберегать Вас во время длительного отсутствия. Его можно активировать только тогда, когда ничего не строится (флоты, постройки или оборона) и не исследуется, а также если Вы никуда не посылали свои флоты. Когда он активирован, он защищает Вас от атак, однако уже начатые атаки продолжаются. Во время режима отпуска производство снижается до нуля, и после окончания этого режима надо его вручную выставлять на 100%. Режим отпуска длится минимум 2 дня, деактивировать его возможно только после этого срока.">Активировать режим отпуска</a></th>
   <th>
    <input type="checkbox" name="urlaubs_modus"
     />
   </th>

  </tr>
  <tr>
   <th><a title="Если поставить здесь галочку, то через 7 дней аккаунт автоматически полностью удалится.">Удалить аккаунт</a></th>
   <th><input type="checkbox" name="db_deaktjava"  <?=IsChecked("disable");?>/>
      <?php
    if ($GlobalUser['disable']) echo "am: " . date ("Y-m-d H:i:s", $GlobalUser['disable_until']);
?> </th>
  </tr>
  <tr>
   <th colspan=2><input type="submit" value="Сохранить изменения" /></th>

  </tr>
   
 </form>
 </table>

<?php
    }
?>

<br><br><br><br>
</center>
</div>
<!-- END CONTENT AREA -->

<?php
PageFooter ($OptionsMessage, $OptionsError);
ob_end_flush ();
?>