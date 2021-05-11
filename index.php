<?php
require_once './vendor/autoload.php';
var_dump((new \Rc\Pms\OpenApi('app_key','channel_key'))->sendRequest('Hotel.GetOrgs',['Name'=>'xiaoA','mobile'=>'13111111111','CardNo'=>'']));
