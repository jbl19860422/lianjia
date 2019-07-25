<?php
	function http_request($url, $data = null, $headers = null) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);//不需要返回头部信息 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		if(!empty($headers)) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($curl);
		if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == '200') {
		    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		    $header = substr($response, 0, $headerSize);
		    $body = substr($response, $headerSize);
		}
		curl_close($curl);
		return $response;
	}
?>