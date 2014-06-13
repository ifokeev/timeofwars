<?
include_once('db_config.php');
include_once('db.php');

if( !$db->queryArray("SELECT Username FROM ".SQL_PREFIX."new_year WHERE Username = '".$stat[0]."'") ){

$arr = $db->queryFetchArray("SELECT * FROM ".SQL_PREFIX."things_shop WHERE Amount != '0'"); shuffle($arr);
$db->query("INSERT INTO ".SQL_PREFIX."things (Owner, Id, Thing_Name, Slot, Cost, Level_need, Stre_need, Agil_need, Intu_need, Endu_need, Clan_need, Level_add, Stre_add, Agil_add, Intu_add, Endu_add, MINdamage, MAXdamage, Crit, AntiCrit, Uv, AntiUv, Armor1, Armor2, Armor3, Armor4, MagicID, NOWwear, MAXwear, Wear_ON, Srab) VALUES ('".$stat[0]."', '".$arr[0]['Id']."', '".$arr[0]['Thing_Name']."', '".$arr[0]['Slot']."', '".$arr[0]['Cost']."', '".$arr[0]['Level_need']."', '".$arr[0]['Stre_need']."', '".$arr[0]['Agil_need']."', '".$arr[0]['Intu_need']."', '".$arr[0]['Endu_need']."', '".$arr[0]['Clan_need']."', '".$arr[0]['Level_add']."', '".$arr[0]['Stre_add']."', '".$arr[0]['Agil_add']."', '".$arr[0]['Intu_add']."', '".$arr[0]['Endu_add']."', '".$arr[0]['MINdamage']."', '".$arr[0]['MAXdamage']."', '".$arr[0]['Crit']."', '".$arr[0]['AntiCrit']."', '".$arr[0]['Uv']."', '".$arr[0]['AntiUv']."', '".$arr[0]['Armor1']."', '".$arr[0]['Armor2']."', '".$arr[0]['Armor3']."', '".$arr[0]['Armor4']."', '".$arr[0]['MagicID']."', '".$arr[0]['NOWwear']."', '".$arr[0]['MAXwear']."', '0', '".$arr[0]['Srab']."')");
$db->query("INSERT INTO ".SQL_PREFIX."transfer (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', 'Елка', '".$stat[0]."', 'Предмет ".$arr[0]['Thing_Name']." получен на новый год, уникальный ID ".mysql_insert_id()." (".date('H:i').")')");

$db->execQuery("INSERT INTO ".SQL_PREFIX."new_year ( Username, present, time ) VALUES ( '".$stat[0]."', '".$arr[0]['Id']." / ".$arr[0]['Thing_Name']."', now() )");

echo "<script>alert('Дедушка Мороз подарил вам \"".$arr[0]['Thing_Name']."\"!');</script>";

} else {

echo "<script>alert('Вы уже получили свой подарок. Прекратите жадничать :)');</script>";

}
?>
