<?php
require_once __DIR__ . '/php-sdk-7.0.8/autoload.php';

// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

define('CDN_AK', 'H-XXK1YKv9S1Btd2fcXC2NaQb-KvrTUHCxhhJTRJ');
define('CDN_SK', 'tKGq-NeRWt_c8rCt_o3WsIHOtkTsHAK7hF3VGYVS');
define('CDN_DOMAIN', 'http://o95rd8icu.bkt.clouddn.com/');
define('CDN_BUCKET', 'yihui');
class Qiniusdk {
	private $bucket;
	private $auth;
	private $conf;
	public function __construct($config) {
		$this->conf = $config;
		if($config) {
			// 要上传的空间
			$this->bucket = $config['cdn_bucket'];
			// 构建鉴权对象
			$this->auth = new Auth($config['cdn_ak'], $config['cdn_sk']);
		} else {
			// 要上传的空间
			$this->bucket = CDN_BUCKET;
			// 构建鉴权对象
			$this->auth = new Auth(CDN_AK, CDN_SK);
		}
	}
	
	public function uploadFile($filePath, $key, $expires, $policy) {
		// 生成上传 Token
		if($this->conf) {
			$token = $this->auth->uploadToken($this->conf['cdn_bucket'], $key, $expires, $policy);
		} else {
			$token = $this->auth->uploadToken(CDN_BUCKET, $key, $expires, $policy);
		}
		// 初始化 UploadManager 对象并进行文件的上传。
		$uploadMgr = new UploadManager();
		// 调用 UploadManager 的 putFile 方法进行文件的上传。
		list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
		if ($err !== null) {
		   return "";
		} else {
			if($this->conf) {
				return $this->conf['cdn_domain'].$key;
			} else {
				return CDN_DOMAIN.$key;
			}
		   
		}
	}
}