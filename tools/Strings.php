<?php
class Strings {
    
    public static function utf8ToLatin1($txt, $flag=null) {
		$pattern = "Ă Â Á À Ả Ã Ạ Ắ Ằ Ẳ Ẵ Ặ Ấ Ầ Ẩ Ẫ Ậ";	   		
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "A", $txt);}		
		$pattern = "ă â á à ả ã ạ ắ ằ ẳ ẵ ặ ấ ầ ẩ ẫ ậ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "a", $txt);}		
		$pattern = "Ê É È Ẻ Ẽ Ẹ Ế Ề Ể Ễ Ệ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "E", $txt);}		
		$pattern = "ê é è ẻ ẽ ẹ ế ề ể ễ ệ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "e", $txt);}		
		$pattern = "Ô Ơ Ó Ò Ỏ Õ Ọ Ố Ồ Ổ Ỗ Ộ Ớ Ờ Ở Ỡ Ợ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "O", $txt);}		
		$pattern = "ô ơ ó ò ỏ õ ọ ố ồ ổ ỗ ộ ớ ờ ở ỡ ợ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "o", $txt);}		
		$pattern = "Ư Ú Ù Ủ Ũ Ụ Ứ Ừ Ử Ữ Ự";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "U", $txt);}		
		$pattern = "ư ú ù ủ ũ ụ ứ ừ ử ữ ự";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "u", $txt);}		
		$pattern = "Í Ì Ỉ Ĩ Ị";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "I", $txt);}		
		$pattern = "í ì ỉ ĩ ị";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "i", $txt);}		
		$pattern = "Ý Ỳ Ỷ Ỹ Ỵ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "Y", $txt);}		
		$pattern = "ý ỳ ỷ ỹ ỵ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "y", $txt);}		
		$pattern = "Đ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "D", $txt);}		
		$pattern = "đ";	   
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], "d", $txt);}		
		$pattern = "” @ # $ % ^ & * ! + = / : ; - @ \ ? . , ' [ ] | ^ ` { } - _ ~ ( ) < > \" ‘ ’";
		$ar = explode(' ', $pattern);for($i=0; $i<sizeof($ar); $i++){$txt = str_replace($ar[$i], " ", $txt);}
		
		if (!$flag)
			$txt = strtolower(preg_replace("/\s+/", "-", trim($txt)));
		else
			$txt = strtolower(preg_replace("/\s+/", "-", trim($txt)).'.htm');

		return $txt;
	}
}
?>
