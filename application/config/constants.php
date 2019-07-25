<?php


defined('BASEPATH') OR exit('No direct script access allowed');

defined('DEBUG')  OR define('DEBUG', 1);

/*
身份类别,0：游客，1：独立经纪人，2：职业经纪人
*/
defined('ROLE_GUEST') OR define('ROLE_GUEST', 0);
defined('ROLE_DEP_AGENT') OR define('ROLE_DEP_AGENT', 1);
defined('ROLE_IND_AGENT') OR define('ROLE_IND_AGENT', 2);

defined('ADMIN_TYPE_NONE') OR define('ADMIN_TYPE_NONE', 0);
defined('ADMIN_TYPE_C') OR define('ADMIN_TYPE_C', 1);
defined('ADMIN_TYPE_B') OR define('ADMIN_TYPE_B', 2);
defined('ADMIN_TYPE_A') OR define('ADMIN_TYPE_A', 3);

/*
* 消息类别
*/
defined('MSG_CREATE_TEAM') OR define('MSG_CREATE_TEAM', 1);
defined('MSG_VERIFY_USER') OR define('MSG_VERIFY_USER', 2);
defined('MSG_APPLY_AGENT') OR define('MSG_APPLY_AGENT', 3);//申请独立经纪人
defined('MSG_APPLY_JOIN_TEAM') OR define('MSG_APPLY_JOIN_TEAM', 4);//申请加入团队
defined('MSG_UPLOAD_HOUSE_CERT') OR define('MSG_UPLOAD_HOUSE_CERT', 5);//上传房产证消息
defined('MSG_UPLOAD_HOUSE_AGENT_CERT') OR define('MSG_UPLOAD_HOUSE_AGENT_CERT', 6);//上传委托书
defined('MSG_UPLOAD_HOUSE_CONTRACT') OR define('MSG_UPLOAD_HOUSE_CONTRACT', 7);//上传房产证
defined('MSG_UPLOAD_IDPAPER') OR define('MSG_UPLOAD_IDPAPER', 8);//上传身份证明
defined('MSG_UPLOAD_TAXTICKET') OR define('MSG_UPLOAD_TAXTICKET', 9);//上传身份证明
defined('MSG_UPLOAD_VERIREPORT') OR define('MSG_UPLOAD_VERIREPORT', 10);//上传房屋核验报告
defined('MSG_UPLOAD_HOUSE_NUMBER') OR define('MSG_UPLOAD_HOUSE_NUMBER', 11);//上传房源编号
defined('MSG_APPLY_INVALID_HOUSE') OR define('MSG_APPLY_INVALID_HOUSE', 12);//申请无效房源
defined('MSG_APPLY_HOUSE_FOCUS') OR define('MSG_APPLY_HOUSE_FOCUS', 13);
defined('MSG_APPLY_PROF') OR define('MSG_APPLY_PROF', 14);
defined('MSG_RECOMMEND_HOUSE') OR define('MSG_RECOMMEND_HOUSE', 15);
defined('MSG_PLAYSEE_HOUSE') OR define('MSG_PLAYSEE_HOUSE', 16);
defined('MSG_APPLY_FOLLOW_IMG') OR define('MSG_APPLY_FOLLOW_IMG', 17);//申请实勘图片上传消息
defined('MSG_INVITE_JOIN_TEAM') OR define('MSG_INVITE_JOIN_TEAM', 18);//申请实勘图片上传消息
defined('MSG_APPLY_MODIFY_REALINFO') OR define('MSG_APPLY_MODIFY_REALINFO', 19);//申请修改实名信息


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when workingf
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('ADMIN_PAGE_TITLE') OR define ('ADMIN_PAGE_TITLE', '房产中介管理系统');

/*
* 自定义错误码
*/
defined('ERROR_SUCCESS') OR define('ERROR_SUCCESS', 0);
defined('ERROR_NOT_LOGIN') OR define('ERROR_NOT_LOGIN', -1001);
defined('ERROR_USER_PASSWORD') OR define('ERROR_USER_PASSWORD', -1002);
defined('ERROR_PARAM') OR define('ERROR_PARAM', -1003);
defined('ERROR_MYSQL') OR define('ERROR_MYSQL', -1004);
defined('ERROR_NOT_ENOUGH_MONEY') OR define('ERROR_NOT_ENOUGH_MONEY', -1005);
defined('ERROR_REDIS') OR define('ERROR_REDIS', -1006);
defined('ERROR_USER_EXIST') OR define('ERROR_USER_EXIST', -1007);
defined('ERROR_USER_UNKNOWN') OR define('ERROR_USER_UNKNOWN', -1008);
defined('ERROR_USER_NOT_EXIST') OR define('ERROR_USER_NOT_EXIST', -1009);
defined('ERROR_HAS_JOINED') OR define('ERROR_HAS_JOINED', -1010);
defined('ERROR_UNKNOWN') OR define('ERROR_UNKNOWN', -1011);
defined('ERROR_USER_NOT_VALID') OR define('ERROR_USER_NOT_VALID', -1012);

/*
* 购物车错误码，从-2000开始
*/
defined('ERROR_MAX_CARTCOUNT') OR define('ERROR_MAX_CARTCOUNT', -2000);
defined('ERROR_ALREADY_IN_CART') OR define('ERROR_ALREADY_IN_CART', -2001);

/*
订单错误
*/
defined('ERROR_NO_GOODS')  OR define('ERROR_NO_GOODS', -3000);
defined('ERROR_GOODS_NOT_ENOUGH')  OR define('ERROR_GOODS_NOT_ENOUGH', -3001);
defined('ERROR_USER_ADDRESS')  OR define('ERROR_USER_ADDRESS', -3003);
defined('ERROR_NO_USER_ADDRESS')  OR define('ERROR_NO_USER_ADDRESS', -3004);
defined('ERROR_NOT_ENOUGH_MONEY')  OR define('ERROR_NOT_ENOUGH_MONEY', -3005);
defined('TICKET_ALREADY_EXIST') OR define('TICKET_ALREADY_EXIST', -3006);//待撤销
/*
* 订单状态
*/
defined('ORDER_STATUS_WAIT_FOR_PAY') OR define('ORDER_STATUS_WAIT_FOR_PAY', 0);//待付款
defined('ORDER_STATUS_WAIT_FOR_SEND') OR define('ORDER_STATUS_WAIT_FOR_SEND', 1);//待发货
defined('ORDER_STATUS_WAIT_FOR_RECV') OR define('ORDER_STATUS_WAIT_FOR_RECV', 2);//待收获
defined('ORDER_STATUS_WAIT_FOR_COMMENT') OR define('ORDER_STATUS_WAIT_FOR_COMMENT', 3);//待评论
defined('ORDER_STATUS_COMMENTED') OR define('ORDER_STATUS_COMMENTED', 4);//已经评论
defined('ORDER_STATUS_WAIT_FOR_CANCEL') OR define('ORDER_STATUS_WAIT_FOR_CANCEL', 5);//待撤销


/*
* redpacket
*/
defined('REDPACKET_NOT_START') OR define('REDPACKET_NOT_START', -4000);
defined('REDPACKET_ENDED') OR define('REDPACKET_ENDED', -4001);
defined('REDPACKET_LIMITED') OR define('REDPACKET_LIMITED', -4002);
defined('REDPACEKT_NOT_EXIST') OR define('REDPACKET_NOT_EXIST', -4003);
defined('REDPACKET_ALLREADY_GOT') OR define('REDPACKET_ALLREADY_GOT', -4004);
defined('REDPACKET_INVALID') OR define('REDPACKET_INVALID', -4005);
defined('REDPACKET_WXAPI') OR define('REDPACKET_WXAPI', -4006);

/*
* 融云错误码
*/
defined('ERROR_SEND_CHECKCODE') OR define('ERROR_SEND_CHECKCODE', -5001);
defined('ERROR_SEND_CHECKCODE_TOOOFTEN') OR define('ERROR_SEND_CHECKCODE_TOOOFTEN', -5002);
defined('ERROR_VERIFY_FAILED') OR define('ERROR_VERIFY_FAILED', -5003);
defined('ERROR_USER_ALLREADY_EXISTS') OR define('ERROR_USER_ALLREADY_EXISTS', -5004);

/*
* 七牛云错误
*/

defined('ERROR_GEN_RECORD') OR define('ERROR_GEN_RECORD', -6001);
defined('ERROR_QINIUCONFIG') OR define('ERROR_QINIUCONFIG', -6002);
/*
* 资格缺少类错误码
*/
defined('ERROR_NO_ITEM') OR define('ERROR_NO_ITEM', -7001);
defined('ERROR_NOT_ENOUGH_ITEM') OR define('ERROR_NOT_ENOUGH_ITEM', -7002);

/*
* 活动错误码
*/
defined('ERROR_ACT_NOT_BEGIN') OR define('ERROR_ACT_NOT_BEGIN', -8001);
defined('ERROR_ACT_END') OR define('ERROR_ACT_END', -8002);
defined('ERROR_ACT_NOT_ONLINE') OR define('ERROR_ACT_NOT_ONLINE', -8003);
defined('ERROR_ACT_GLOAL_DAYLIMIT') OR define('ERROR_ACT_GLOAL_DAYLIMIT', -8004);
defined('ERROR_ACT_GLOAL_TOTALLIMIT') OR define('ERROR_ACT_GLOAL_TOTALLIMIT', -8005);

defined('ERROR_ACT_USER_DAYLIMIT') OR define('ERROR_ACT_USER_DAYLIMIT', -8006);
defined('ERROR_ACT_USER_TOTALLIMIT') OR define('ERROR_ACT_USER_TOTALLIMIT', -8007);

defined('ERROR_ACT_ITEM_NOT_EXIST') OR define('ERROR_ACT_ITEM_NOT_EXIST', -8008);
defined('ERROR_ACT_NOT_ENOUGH_ITEM') OR define('ERROR_ACT_NOT_ENOUGH_ITEM', -8009);

defined('ERROR_WX_DOWNLOAD') OR define('ERROR_WX_DOWNLOAD', -9001);
defined('ERROR_FFMPEG') OR define('ERROR_FFMPEG', -9002);



defined('ERROR_MY_TEAM') OR define('ERROR_MY_TEAM', -10001);//我自己的团队，不能加
defined('ERROR_ALREADY_JOIN') OR define('ERROR_ALREADY_JOIN', -10002);//已经加入，不能再加入1123455    
defined('ERROR_NO_TRADE_EMPLOYEE') OR define('ERROR_NO_TRADE_EMPLOYEE', -10003);//不存在商圈管理员
defined('ERROR_DELAREA_COMMUNITY_EXISTS') OR define('ERROR_DELAREA_COMMUNITY_EXISTS', -10004);//存在小区，无法删除片区
defined('ERROR_COMMUNITY_EXISTS') OR define('ERROR_COMMUNITY_EXISTS', -10005);//存在小区  
defined('ERROR_GUEST_EXISTS') OR define('ERROR_GUEST_EXISTS', -10006);//客源已经存在
require_once('base_config.php');
?>