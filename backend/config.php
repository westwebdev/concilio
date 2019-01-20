<?
/*// $db_server   ="db21.freehost.com.ua";*/
$db_server   ="db21.freehost.com.ua";
$db_user     ="wwd_testBD";
$db_password ="bp111692";
$db_name="wwd_testbd";
	// ������������ � ������� ��
$mysql = mysql_connect($db_server, $db_user, $db_password);
if (!$mysql) { die ('Connection error: ' . mysql_error()); }
	// �������� ��
$db = mysql_select_db($db_name, $mysql);
if (!$db) { die ('Error select db : ' . mysql_error()); }
	// ������������� ��������� �����������
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
session_start();
?>
