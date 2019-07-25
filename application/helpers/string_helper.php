<?php
	function genRandomStr($length = 8) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}

	function getMicroTimestamp() {
		return floor(microtime(true)*1000);
	}
	
	function trimall($str)//删除空格
	{
	    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
	    return str_replace($qian,$hou,$str);    
	}
	
	function mkdirs($path){
		if(!is_dir($path)){
			mkdirs(dirname($path));
			if(!mkdir($path, 0777)){
				return false;
			}
		}
		return true;
	}
  
	function decodeQueryStr($str) {
		$tmp = unescape($str);
		$str = str_replace('&amp;','&',$tmp);
		$a = explode("&",$str);
		$param = [];
		for($i = 0; $i < count($a); $i++) {
			$p = explode("=",$a[$i]);
			$param[$p[0]] = $p[1];
		}
		return $param;
	}

	function escape($str) {
		$ch = curl_init();
		$esc_str = curl_escape($ch, $str);
		curl_close($ch);
		return $esc_str;
	}
	
	function unescape($str) {
		$ch = curl_init();
		$unesc_str = curl_unescape($ch, $str);
		curl_close($ch);
		return $unesc_str;
	}
?>