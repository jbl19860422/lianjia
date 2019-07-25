<?php
/**
* 	配置账号信息
*/
class WxPayConfig
{
	//=======【基本信息设置】=====================================
	//
	/**
	 * 
	 * 微信公众号信息配置
	 * APPID：绑定支付的APPID（必须配置）
	 * MCHID：商户号（必须配置）
	 * KEY：商户支付密钥，参考开户邮件设置（必须配置）
	 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置）
	 * @var string
	 */
	public static $WX_APPID = '';
	public static $WX_APPSECRET = '';
	public static $WX_MCHID = '';
	public static $WX_MKEY = '';
	
	static public function APPID(){
		return self::$WX_APPID;
		//return "wx0523023df5aa4bf1";
	}
	
	static public function APPSECRET(){
		return self::$WX_APPSECRET;
		//return "2cad1eb85f9b6202d723677296bc1fb7";
	}

	static public function MCHID(){
		return self::$WX_MCHID;
		//return "1354449802";
	}

	static public function MKEY(){
		return self::$WX_MKEY;
		//return "8fee31e1dd223e73cbec60b23bde0b46";
	}

	//=======【证书路径设置】=====================================
	/**
	 * 
	 * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要）
	 * @var path
	 */
	const SSLCERT_PATH = '/home/www-ci/application/libraries/cert/apiclient_cert.pem';
	const SSLKEY_PATH = '/home/www-ci/application/libraries/cert/apiclient_key.pem';
	
	//=======【curl代理设置】===================================
	/**
	 * 
	 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
	 * 默认0.0.0.0和0，此时不开启代理（如有需要才设置）
	 * @var unknown_type
	 */
	const CURL_PROXY_HOST = "0.0.0.1";
	const CURL_PROXY_PORT = 0;
	
	//=======【上报信息配置】===================================
	/**
	 * 
	 * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	 * @var int
	 */
	const REPORT_LEVENL = 1;
}
