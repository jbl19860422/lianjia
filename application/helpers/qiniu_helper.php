<?php
	use \Pili\Transport;
	use \Pili\Api;
	require(join(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), 'helpers/pili-sdk-php-master/lib', 'Pili.php')));
	
	// Replace with your keys here
	define('ACCESS_KEY', 'H-XXK1YKv9S1Btd2fcXC2NaQb-KvrTUHCxhhJTRJ');
	define('SECRET_KEY', 'tKGq-NeRWt_c8rCt_o3WsIHOtkTsHAK7hF3VGYVS');
	
	// Replace with your hub name
	define('HUB', 'yunzhong'); // The Hub must be exists before use
	
	class Qiniupili {
		private $credentials;
		private $hub;
		public function __construct($config) {
			if(!$config) {
				$this->credentials = new \Qiniu\Credentials(ACCESS_KEY, SECRET_KEY); #=> Credentials Object
				$this->hub = new \Pili\Hub($this->credentials, HUB); # => Hub Object
			} else {
				$this->credentials = new \Qiniu\Credentials($config['ak'], $config['sk']); #=> Credentials Object
				$this->hub = new \Pili\Hub($this->credentials, $config['hub']); # => Hub Object
			}
		}
		/*
		* 功能：创建七牛云直播
		* @return
		* array (
				'push_url' => 推流地址,
				'hls_play_url' => hls播放地址,
				'rtmp_play_url' => rtmp播放地址,
				'flv_play_url' => flv播放地址,
				'stream_id' => 流id
		* )
		*/
		public function create_stream() {
			$stream = $this->hub->createStream();
			if(!$stream) {
				return null;
			}
			//var_dump($stream);
			$live_info = [];
			$live_info['push_url'] = $stream->rtmpPublishUrl();
			$hlsLiveUrls = $stream->hlsLiveUrls();
			$live_info['hls_play_url'] = $hlsLiveUrls['ORIGIN'];
			$rtmpLiveUrls = $stream->rtmpLiveUrls();
			$live_info['rtmp_play_url'] = $rtmpLiveUrls['ORIGIN'];
			$httpFlvLiveUrls = $stream->httpFlvLiveUrls();
			$live_info['flv_play_url'] = $httpFlvLiveUrls['ORIGIN'];
			$live_info['stream_id'] = $stream->id;
			return $live_info;
		}
		
		/*
		* 功能：创建录播
		* @param[in] streamId 流id
		* @return array(
				'url' => 录像地址,
				'duration' => 录像时长 
		* )
		*/
		public function generate_record($streamId, $notifyUrl = NULL, $start = 0, $end = 0) {
			$stream = $this->hub->getStream($streamId);
			$name      = $streamId.'.mp4'; // required
	    $format    = NULL;            // optional
	    $pipeline  = NULL;            // optional
	    $start = -1;
	    $end = -1;
	    $result = $stream->hlsPlaybackUrls($start,$end);
			//$result = $stream->saveAs($name, $format, $start, $end, $notifyUrl, $pipeline); # => Array
			//echo 'streamid='.$streamId;
			//var_dump($result);
			if($result) {
				if(isset($result['ORIGIN'])) {
					$result['url'] = $result['ORIGIN'];
					//$result['url'] = str_replace('pili-media.karenwan.cn', 'oo4sp462c.bkt.clouddn.com', $result['url']);
				} else {
					$result['url'] = "";
				}
			}
			
			$seg = $stream->segments(NULL, NULL, NULL);
			$duration = 0;
			$segs = $seg['segments'];
			for($i = 0; $i < count($segs); $i++) {
				$duration += $segs[$i]['end']-$segs[$i]['start'];
			}
			$result['duration'] = $duration;
			return $result;
		}
	}
	
?>