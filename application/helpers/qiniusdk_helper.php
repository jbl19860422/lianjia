<?php
require_once __DIR__ . '/php-sdk-7.0.8/autoload.php';

// �����Ȩ��
use Qiniu\Auth;

// �����ϴ���
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
			// Ҫ�ϴ��Ŀռ�
			$this->bucket = $config['cdn_bucket'];
			// ������Ȩ����
			$this->auth = new Auth($config['cdn_ak'], $config['cdn_sk']);
		} else {
			// Ҫ�ϴ��Ŀռ�
			$this->bucket = CDN_BUCKET;
			// ������Ȩ����
			$this->auth = new Auth(CDN_AK, CDN_SK);
		}
	}
	
	public function uploadFile($filePath, $key, $expires, $policy) {
		// �����ϴ� Token
		if($this->conf) {
			$token = $this->auth->uploadToken($this->conf['cdn_bucket'], $key, $expires, $policy);
		} else {
			$token = $this->auth->uploadToken(CDN_BUCKET, $key, $expires, $policy);
		}
		// ��ʼ�� UploadManager ���󲢽����ļ����ϴ���
		$uploadMgr = new UploadManager();
		// ���� UploadManager �� putFile ���������ļ����ϴ���
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