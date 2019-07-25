<?php
// 目录入口
define('QCLOUDAPI_ROOT_PATH', dirname(__FILE__));
define('qcloud_secretkey','96731fdbaa1288de5eaf96d533726b9f');
define('QCLOUD_BIZID', 5229);
/**
 * QcloudApi
 * SDK入口文件
 */

class QcloudApi
{
		private $qcloud_secretkey = '';
		private $qcloud_bizid = 0;
    /**
     * MODULE_ACCOUNT
     * 用户账户
     */
    const MODULE_ACCOUNT   = 'account';
    
    /**
     * MODULE_CVM
     * 云服务器
     */
    const MODULE_CVM   = 'cvm';

    /**
     * MODULE_CDB
     * CDB数据库
     */
    const MODULE_CDB   = 'cdb';

    /**
     * MODULE_LB
     * 负载均衡
     */
    const MODULE_LB    = 'lb';

    /**
     * MODULE_TRADE
     * 产品售卖
     */
    const MODULE_TRADE = 'trade';
    
    /**
     * MODULE_BILL
     * 账单
     */
    const MODULE_BILL = 'bill';

    /**
     * MODULE_SEC
     * 云安全
     */
    const MODULE_SEC = 'sec';

    /**
     * MODULE_IMAGE
     * 镜像
     */
    const MODULE_IMAGE = 'image';

    /**
     * MODULE_MONITOR
     * 云监控
     */
    const MODULE_MONITOR = 'monitor';

    /**
     * MODULE_CDN
     * CDN
     */
    const MODULE_CDN = 'cdn';

    /**
     * MODULE_VPC
     * VPC
     */
    const MODULE_VPC = 'vpc';

    /**
     * MODULE_VOD
     * VOD
     */
    const MODULE_VOD = 'vod';
    
    /**
     * YUNSOU
     */
    const MODULE_YUNSOU = 'yunsou';
	
	  /**
     * cns
     */
    const MODULE_CNS = 'cns';
	
	  /**
     * wenzhi
     */
    const MODULE_WENZHI = 'wenzhi';
    
    /**
     * MARKET
     */
    const MODULE_MARKET = 'market';
    
    /**
     * MODULE_EIP
     * 弹性公网Ip
     */
    const MODULE_EIP = 'eip';
    
    /**
     * MODULE_LIVE
     * 直播
     */
    const MODULE_LIVE = 'live';

    /**
     * MODULE_SNAPSHOT
     * 快照
     */
    const MODULE_SNAPSHOT = 'snapshot';

    /**
     * MODULE_CBS
     * 云硬盘
     */
    const MODULE_CBS = 'cbs';
    
    /**
     * MODULE_SCALING
     * 弹性伸缩
     */
    const MODULE_SCALING = 'scaling';
    
    /**
     * MODULE_CMEM
     * 云缓存
     */
    const MODULE_CMEM = 'cmem';
    
    /**
     * MODULE_TDSQL
     * 云数据库TDSQL
     */
    const MODULE_TDSQL = 'tdsql';
    
        /**
     * MODULE_BM
     * 黑石BM
     */
    const MODULE_BM = 'bm';

		public function __construct($config) {
			$this->qcloud_secretkey = $config['qcloud_secretkey'];
			$this->qcloud_bizid = $config['qcloud_bizid'];
		}
    /**
     * load
     * 加载模块文件
     * @param  string $moduleName   模块名称
     * @param  array  $moduleConfig 模块配置
     * @return
     */
    public static function load($moduleName, $moduleConfig = array())
    {
        $moduleName = ucfirst($moduleName);
        $moduleClassFile = QCLOUDAPI_ROOT_PATH . '/Module/' . $moduleName . '.php';

        if (!file_exists($moduleClassFile)) {
            return false;
        }

        require_once $moduleClassFile;
        $moduleClassName = 'QcloudApi_Module_' . $moduleName;
        $moduleInstance = new $moduleClassName();

        if (!empty($moduleConfig)) {
            $moduleInstance->setConfig($moduleConfig);
        }

        return $moduleInstance;
    }
      			
		/**
		 * 获取推流地址
		 * 如果不传key和过期时间，将返回不含防盗链的url
		 * @param bizId 您在腾讯云分配到的bizid
		 *        streamId 您用来区别不通推流地址的唯一id
		 *        key 安全密钥（这里要传的是防盗链key不是appsecret）
		 *        time 过期时间 sample 2016-11-12 12:00:00
		 * @return String url
		 */
		function getPushUrl($streamId, $record = null, $time = null){
				$livecode = $this->qcloud_bizid."_".$streamId; //直播码
		    if($time){
		        $txTime = strtoupper(base_convert(strtotime($time),10,16));
		        //txSecret = MD5( KEY + livecode + txTime )
		        //livecode = bizid+"_"+stream_id  如 8888_test123456
		       
		        $txSecret = md5($this->qcloud_secretkey.$livecode.$txTime);
		        $ext_str = "?".http_build_query(array(
		           // "bizid"=> $this->qcloud_bizid,//这个参数没用，不知道原来为什么加的
		            "txSecret"=> $txSecret,
		            "txTime"=> $txTime
		        ));
		    }
		    
		    if($record) {
		    	if(isset($ext_str)) {
		    		$ext_str .= "&record=".$record;
		    	} else {
		    		$ext_str = "?record=".$record;
		    	}
		    }
		    return "rtmp://".$this->qcloud_bizid.".livepush.myqcloud.com/live/".$livecode.(isset($ext_str) ? $ext_str : "");
		}
		
		//echo getPushUrl("8888","123456","69e0daf7234b01f257a7adb9f807ae9f","2016-09-11 20:08:07");
		//echo "<br />";
		/**
		 * 获取播放地址
		 * @param bizId 您在腾讯云分配到的bizid
		 *        streamId 您用来区别不通推流地址的唯一id
		 * @return String url
		 */
		function getPlayUrl($streamId){
		    $livecode = $this->qcloud_bizid."_".$streamId; //直播码
		    return array(
		        "rtmp://".$this->qcloud_bizid.".liveplay.myqcloud.com/live/".$livecode,
		        "http://".$this->qcloud_bizid.".liveplay.myqcloud.com/live/".$livecode.".flv",
		        "http://".$this->qcloud_bizid.".liveplay.myqcloud.com/live/".$livecode.".m3u8"
		    );
		}
		//print_r(getPlayUrl("8888","123456"));
}
