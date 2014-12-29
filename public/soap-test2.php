<?php
require($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");

//function request_SubmitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7)

//var_dump(request_GetAppVersion(10));
//var_dump(request_GetContentVersion(829));
//var_dump(request_GetContentDetail(829));

var_dump(request_GetAppVersion(61));
var_dump(request_GetContentVersion(823));
var_dump(request_GetContentDetail(823));

require($_SERVER["DOCUMENT_ROOT"]."/lib/common.end.php");
?>