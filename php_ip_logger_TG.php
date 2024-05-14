<?php
$ip = $_SERVER['REMOTE_ADDR']; 
$REQUEST_TIME_FLOAT = $_SERVER['REQUEST_TIME_FLOAT'];
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$SERVER_PROTOCOL = $_SERVER['SERVER_PROTOCOL'];
$REQUEST_TIME = $_SERVER['REQUEST_TIME'];
date_default_timezone_set('Asia/Yekaterinburg');
$TIME = date("d-m-Y H:i:s");

/* получить информацию о примерном местоположении */
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

/* библиотека для получения информации о браузере */
include('./assets/php/Browser.php');
$browser = new Browser();

/* ввести токен бота ТГ */
$token = ""; /* ввести токен бота ТГ */
$chat_id = ""; /* id чата, куда бот посылает логи */

$arr = array(
"айпи" => $ip,
"время" => $TIME."%0A<b>_____________________________</b>",
'браузер' => $browser->getBrowser(),
'версия' => $browser->getVersion(),
'платформа' => $browser->getPlatform()."%0A<b>_____________________________</b>",
"Страна" => $details ->country,
"Регион" =>  $details -> region,
"Город" => $details ->city,
);

foreach($arr as $key => $value) {
    $txt .= "<b>".$key."</b>: ".$value."%0A";
}

if (strcmp($ip, '192.168.31.1') != 0): /* игнорирование IP-адреса роутера в локальной сети*/
	$fp=fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
endif;
?>