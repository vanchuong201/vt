<?php
class LogEvent {
	public function __construct() {}
	
	public static function writeLog($str) {
        return;
		//$str = mb_substr($str,0,strlen($str),'iso-8859-2');
		//$str = iconv("UTF-8", "UTF-8", $str);
		$logFile = date('H\h_d.m.Y', time()+3600*+7).".log_error";
		$log = fopen($logFile,'a+');
		fwrite($log,"Called on : ".date('d-m-Y H:i:s', time()+3600*+7));
		//fwrite($log, file_get_contents("php://stdin"));
		fwrite($log, "[ $str ]\n");
		fclose($log);
	}
}
?>
