<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<base href="<?=HOST_URL?>/"/>
	<meta charset="utf-8" />
	<link href="" rel="shortcut icon" />
	<title><?=ADMIN_PAGE_TITLE?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/css/availability.css?v=1" rel="stylesheet">
		<link href="../../../static/css/guest.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=2"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='客源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="guest/guest_list_page">买卖</a></li>
			<li class="active"><a href="guest/rent_guest_list_page">租赁</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				客源-买卖-我的客源 
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<ul class="sel-menu-ul"role="tablist">
			<li role="presentation" class="active sel-menu"><a href="#customer_source" role="tab" data-toggle="tab" aria-expanded="true">我的客源</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu"><a href="#cooperation" role="tab" data-toggle="tab" aria-expanded="false">我的合作</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu"><a href="#shared" role="tab" data-toggle="tab" aria-expanded="false">推荐与共享</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu sel-menu-r"><a style="color:#fff;" target="_blank" href="guest/buy_guest_add_page"><i class="fa fa-file-text-o">&nbsp;</i>录入客源</a></li>
			<li style="clear:both"></li>
		</ul>
		<div class="tab-content" id="tab_content_b">
			<!--我的客源--->
			<div role="tabpanel" class="tab-pane active" id="customer_source">
				<div class="list-page-div">
					<div class="form-group list-page-div-group">
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="请输入姓名、联系方式或客源编号"  v-model="my_like_name"></input>
						</div>
						<div class="col-sm-1">
							<span class="btn btn-success list-page-div-btn " @click="my_search.guest.like_name=my_like_name">搜索</span>
						</div>
						<div class="col-sm-1">
							<a class="list-page-div-a" href="javascript:" @click="show_my_search=!show_my_search"><i :class="{fa:true,'fa-level-up':show_my_search,'fa-level-down':!show_my_search}"></i>{{show_my_search?'收起':'展开'}}</a>
						</div>
					</div>
					<div id="show_my_search">
						<div class="form-group form-option">
							<span style="padding-left:0px">星级：</span>
							<span :class="{active:my_search.guest.intention===''}" @click="my_search.guest.intention=''">不限</span>
							<span :class="{active:my_search.guest.intention===3}" @click="my_search.guest.intention=3">强烈（{{my_guest_count.intention[3]}}）</span>
							<span :class="{active:my_search.guest.intention===2}" @click="my_search.guest.intention=2">一般（{{my_guest_count.intention[2]}}）</span>
							<span :class="{active:my_search.guest.intention===1}" @click="my_search.guest.intention=1">较弱（{{my_guest_count.intention[1]}}）</span>
							<span :class="{active:my_search.guest.intention===0}" @click="my_search.guest.intention=0">暂不关注（{{my_guest_count.intention[0]}}）</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">进度：</span>
							<span :class="{active:my_search.guest.curr_progress===''}" @click="my_search.guest.curr_progress=''">不限</span>
							<span :class="{active:my_search.guest.curr_progress===0}" @click="my_search.guest.curr_progress=0">未带看（{{my_guest_count.curr_progress[0]}}）</span>
							<span :class="{active:my_search.guest.curr_progress==1}" @click="my_search.guest.curr_progress=1">首看（{{my_guest_count.curr_progress[1]}}）</span>
							<span :class="{active:my_search.guest.curr_progress==2}" @click="my_search.guest.curr_progress=2">已签约（{{my_guest_count.curr_progress[2]}}）</span>
							<span :class="{active:my_search.guest.curr_progress==3}" @click="my_search.guest.curr_progress=3">已结单（{{my_guest_count.curr_progress[3]}}）</span>
							<!--
							<span>二看（88）</span>
							<span>复看（0）</span>
							<span>意向（23）</span>
							<span>下定（22）</span>
							<span>签约（88）</span>
							<span>过户（0）</span>
							-->
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">价格：</span>
							<span :class="{active:my_search.guest.min_price==''&&my_search.guest.max_price==''}" @click="my_search.guest.min_price='';my_search.guest.max_price='';">不限</span>
							<span :class="{active:my_search.guest.min_price==0&&my_search.guest.max_price==100}" @click="my_search.guest.min_price=0;my_search.guest.max_price=100;">100万以下</span>
							<span :class="{active:my_search.guest.min_price==100&&my_search.guest.max_price==150}" @click="my_search.guest.min_price=100;my_search.guest.max_price=150;">100-150万</span>
							<span :class="{active:my_search.guest.min_price==150&&my_search.guest.max_price==200}" @click="my_search.guest.min_price=150;my_search.guest.max_price=200;">150-200万</span>
							<span :class="{active:my_search.guest.min_price==200&&my_search.guest.max_price==250}" @click="my_search.guest.min_price=200;my_search.guest.max_price=250;">200-250万</span>
							<span :class="{active:my_search.guest.min_price==300&&my_search.guest.max_price==500}" @click="my_search.guest.min_price=300;my_search.guest.max_price=500;">300-500万</span>
							<span :class="{active:my_search.guest.min_price==500&&my_search.guest.max_price==1000}" @click="my_search.guest.min_price=500;my_search.guest.max_price=1000;">500-1000万</span>
							<span :class="{active:my_search.guest.min_price==1000}" @click="my_search.guest.min_price=1000;my_search.guest.max_price='';">1000万以上</span>
							<input type="tel" class="form-control form-option-input" v-model="my_price_min" style="width:70px"></input>
							-
							<input type="tel" class="form-control form-option-input" v-model="my_price_max" style="width:70px"></input>
							<span class="form-option-btn" @click="onConfirmMyPrice()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">面积：</span>
							<span :class="{active:my_search.guest.min_area==''&&my_search.guest.max_area==''}" @click="my_search.guest.min_area='';my_search.guest.max_area='';">不限</span>
							<span :class="{active:my_search.guest.min_area==0&&my_search.guest.max_area==50}" @click="my_search.guest.min_area=0;my_search.guest.max_area=50;">50平米以下</span>
							<span :class="{active:my_search.guest.min_area==50&&my_search.guest.max_area==70}" @click="my_search.guest.min_area=50;my_search.guest.max_area=70;">50-70平米</span>
							<span :class="{active:my_search.guest.min_area==70&&my_search.guest.max_area==90}" @click="my_search.guest.min_area=70;my_search.guest.max_area=90;">70-90平米</span>
							<span :class="{active:my_search.guest.min_area==90&&my_search.guest.max_area==110}" @click="my_search.guest.min_area=90;my_search.guest.max_area=110;">90-110平米</span>
							<span :class="{active:my_search.guest.min_area==100&&my_search.guest.max_area==130}" @click="my_search.guest.min_area=100;my_search.guest.max_area=130;">100-130平米</span>
							<span :class="{active:my_search.guest.min_area==130&&my_search.guest.max_area==150}" @click="my_search.guest.min_area=130;my_search.guest.max_area=150;">130-150平米</span>
							<span :class="{active:my_search.guest.min_area==150&&my_search.guest.max_area==200}" @click="my_search.guest.min_area=150;my_search.guest.max_area=200;">150-200平米</span>
							<span :class="{active:my_search.guest.min_area==200&&my_search.guest.max_area==''}" @click="my_search.guest.min_area=200;my_search.guest.max_area='';">200平米以上</span>
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="my_area_min"></input>
							-
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="my_area_max"></input>
							<span class="form-option-btn" @click="onConfirmMyArea()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">居室：</span>
							<span :class="{active:my_search.guest.room_count==''}" @click="my_search.guest.room_count='';">不限</span>
							<span :class="{active:my_search.guest.room_count==1}" @click="my_search.guest.room_count=1;">1室</span>
							<span :class="{active:my_search.guest.room_count==2}" @click="my_search.guest.room_count=2;">2室</span>
							<span :class="{active:my_search.guest.room_count==3}" @click="my_search.guest.room_count=3;">3室</span>
							<span :class="{active:my_search.guest.room_count==4}" @click="my_search.guest.room_count=4;">4室</span>
							<span :class="{active:my_search.guest.room_count==5}" @click="my_search.guest.room_count=5;">5室</span>
							<span :class="{active:my_search.guest.room_count>=6}" @click="my_search.guest.room_count=6;">5室以上</span>
						</div>
						<div class="form-group form-option">
							<div>
								<span style="padding-left:0px">标签：</span>
								<span :class="{active:my_search.guest.label==''}" @click="my_search.guest.label=''">不限</span>
								<span :class="{active:my_search.guest.label=='即将逾期'}" @click="my_search.guest.label='即将逾期'">即将逾期</span>
								<span :class="{active:my_search.guest.label=='即将共享'}" @click="my_search.guest.label='即将共享'">即将共享</span>
								<span :class="{active:my_search.guest.label=='连环单'}" @click="my_search.guest.label='连环单'">连环单</span>
								<span :class="{active:my_search.guest.label=='链家APP'}" @click="my_search.guest.label='链家APP'">链家APP</span>
								<span :class="{active:my_search.guest.label=='链家网'}" @click="my_search.guest.label='链家网'">链家网</span>
								<span :class="{active:my_search.guest.label=='接收推荐'}" @click="my_search.guest.label='接收推荐'">接收推荐</span>
								<span :class="{active:my_search.guest.label=='他签'}" @click="my_search.guest.label='他签'">他签</span>
								<span :class="{active:my_search.guest.label=='合作'}" @click="my_search.guest.label='合作'">合作</span>
								<span :class="{active:my_search.guest.label=='疑似同业'}" @click="my_search.guest.label='疑似同业'">疑似同业</span><br/>
							</div>
							<div style="margin-top:10px">
								<span :style="[index==0?{'margin-left':'90px'}:{}]" :class="{active:my_search.guest.label==l.name}" v-for="(l,index) in my_labels" v-html="l.name" @click="my_search.guest.label=l.name"></span>
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
				客源列表
				<span class="pull-right" style="font-size:1.2rem">
					共计<span style="color:#FF6863" v-html="my_total_count"></span>有效客源
				</span>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading panel-title" style="border-top:1px solid #ddd">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">姓名</div>
							<div class="col-sm-3 all-col all-col-z">需求</div>
							<div class="col-sm-1 all-col all-col-z">进度</div>
							<div class="col-sm-1 all-col all-col-z">约看<i class="fa fa-chevron-down" aria-hidden="true"></i></div>
							<div class="col-sm-1 all-col all-col-z">带看<i class="fa fa-chevron-down" aria-hidden="true"></i></div>
							<div class="col-sm-1 all-col all-col-z">委托时间<i class="fa fa-chevron-down" aria-hidden="true"></i></div>
							<div class="col-sm-2 all-col all-col-z">上次维护时间<i class="fa fa-chevron-down" aria-hidden="true"></i></div>
							<div class="col-sm-1 all-col all-col-z">操作</div>
							<!--<div class="col-sm-1 all-col all-col-z">
								<select class="all-select">
									<option value="" disabled selected style="display:none">户型</option>
									<option value="0">不限</option>
								</select>
							</div>-->
						</div>
					</div>
					<div class="panel-body">
						<guest-item v-if="my_page_guests[my_search.pi]" v-for="g in my_page_guests[my_search.pi]" :guest="g" :visited_guests="visited_guests"></guest-item>
						
						
						<div class="col-sm-12" style="text-align:center">
							<ul class="pagination">
								<li :class="{disabled:my_search.pi<my_page_count}"><a href="javascript:" @click="if(my_search.pi>=my_page_count) {my_page_changed=true;my_search.pi--;}">&laquo;</a></li>

								<li v-for="p in my_page_count"  :class="{active:p==my_search.pi}"><a href="javascript:" v-html="p" @click="my_page_changed=true;my_search.pi=p;"></a></li>

								<li :class="{disabled:my_search.pi>=my_page_count}"><a href="javascript:" @click="if(my_search.pi<my_page_count) {my_page_changed=true;my_search.pi++;}">&raquo;</a></li>								
							</ul>
						</div>
					</div>
				</div>
				
			</div>
			<!--我的合作--->
			<div role="tabpanel" class="tab-pane" id="cooperation">
				<div class="list-page-div">
					<div class="form-group form-option cooperation-form">
						<span style="padding-left:0px">列表：</span>
						<span style="" class="active">发起/取消合作记录</span>
						<span>收到邀请记录</span>
						<span>合作中</span>
						<span>已成交</span>
						<span>已退出/已取消</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">类型：</span>
						<span style="" class="active">不限</span>
						<span>合作邀请</span>
						<span>取消合作申请</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">状态：</span>
						<span style="" class="active">不限</span>
						<span>待处理</span>
						<span>已处理</span>
						<span>合作建立成功</span>
						<span>合作建立失败</span>
						<span>合作取消成功</span>
						<span>合作取消失败</span>
					</div>
				</div>
				<div class="panel panel-default margin2">
					<div class="panel-heading panel-title">
						<p class="panel-p">需要我处理的合作列表</p>
						<div style="float:right">
							共计<span style="color:#FF6863">0</span>个合作相关申请
						</div>
					</div>
					<div class="panel-body">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">客户姓名</div>
							<div class="col-sm-1 all-col all-col-z">类型</div>
							<div class="col-sm-2 all-col all-col-z">发起人</div>
							<div class="col-sm-2 all-col all-col-z">发起时间</div>
							<div class="col-sm-2 all-col all-col-z">剩余处理时间</div>
							<div class="col-sm-2 all-col all-col-z">状态</div>
							<div class="col-sm-1 all-col all-col-z">操作</div>
							<!--<div class="col-sm-1 all-col all-col-z">
								<select class="all-select">
									<option value="" disabled selected style="display:none">户型</option>
									<option value="0">不限</option>
								</select>
							</div>-->
						</div>
						<div class="col-sm-12 school-district-div">
							<p style="text-align: center;">暂无需要我处理的合作邀请</p>
						</div>	
					</div>
				</div>
			</div>
			<!--推荐与共享--->
			<div role="tabpanel" class="tab-pane" id="shared">
				<div class="list-page-div">
					<div class="form-group form-option cooperation-form">
						<span style="padding-left:0px">列表：</span>
						<span style="" class="active">推荐出去的客源</span>
						<span>共享池客源</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">上次推荐时间：</span>
						<span style="" class="active">本周</span>
						<span>本月</span>
						<input type="text" placeholder="开始时间" class="form-control form-option-input"></input>
						-
						<input type="text" placeholder="结束时间" class="form-control form-option-input"></input>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">标签：</span>
						<span style="" class="active">不限</span>
						<span>带看</span>
						<span>接收人带看</span>
						<span>连环单</span>
						<span>链家APP</span>
						<span>链家网</span>
						<span>他签</span>
						<span>合作</span>
						<span>疑似同业</span>
						<span>成交客户</span><br/>
						<span style="margin-left: 90px;">洗的盘客</span>
						<span>新上客户</span>
						<span>新进线</span>
						<span>业主客户</span>
						<span>豪宅客户</span>
						<span>不是很急的</span>
					</div>
				</div>
				
				<div class="panel panel-default margin2">
					<div class="panel-heading panel-title">
						<p class="panel-p">需要我处理的合作列表</p>
						<div style="float:right">
							共计<span style="color:#FF6863">0</span>个合作相关申请
						</div>
					</div>
					<div class="panel-body">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">姓名</div>
							<div class="col-sm-3 all-col all-col-z">需求</div>
							<div class="col-sm-1 all-col all-col-z">有效带看</div>
							<div class="col-sm-1 all-col all-col-z">推荐记录</div>
							<div class="col-sm-2 all-col all-col-z">上次推荐时间</div>
							<div class="col-sm-2 all-col all-col-z">委托时间</div>
							<div class="col-sm-1 all-col all-col-z">操作</div>
							<!--<div class="col-sm-1 all-col all-col-z">
								<select class="all-select">
									<option value="" disabled selected style="display:none">户型</option>
									<option value="0">不限</option>
								</select>
							</div>-->
						</div>
						<!--
						<div class="col-sm-12 school-district-div">
							<div class="col-sm-2 all-col">
								<h4 class="customer-h4">钟小姐</h4>
							</div>
							<div class="col-sm-3 all-col">
								<p class="customer-p-x">800-1200万</p>
								<div class="customer-div-x">120-170平/米、4-5居、前海</div>
							</div>
							<div class="col-sm-1 all-col">
								<p class="customer-p-x">2次</p>
								<div class="customer-div-x">2天前</div>
							</div>
							<div class="col-sm-1 all-col">
								<p class="customer-p-x">2次</p>
							</div>
							<div class="col-sm-2 all-col">
								<p class="customer-p-j">2016-06-09</p>
							</div>
							<div class="col-sm-2 all-col">
								<p class="customer-p-j">2016-01-09</p>
							</div>
							<div class="col-sm-1 all-col">
								<p class="customer-p-s">查看详情</p>
							</div>
						</div>	
						-->
					</div>
				</div>
			</div>
			<!--聚焦专题--->
			<div role="tabpanel" class="tab-pane" id="topic"></div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	var visitedGuests = [];
	if($.cookie('visited_guests')) {
		visitedGuests = JSON.parse($.cookie('visited_guests'));
	}
	
	var guestItem = Vue.component('guest-item', {
		props:['guest', 'visited_guests'],
		template:'<div :class="{\'col-sm-12\':true,\'school-district-div\':true,active:visited}">'+
					'<div>'+
						'<div class="col-sm-2 all-col">'+
							'<h4 class="customer-h4" style="font-weight:bold">{{guest.name}}<span>({{guest.type==1?\'代理人\':\'决策人\'}})</span></h4>'+
							'<p class="customer-p"><i :class="{fa:true,\'fa-star-o\':i>guest.intention,\'fa-star\':i<=guest.intention}" v-for="i in 3"></i></p>'+
						'</div>'+
						'<div class="col-sm-3 all-col">'+
							'<p class="customer-p-x" v-if="guest.requires.length>0">{{guest.requires[0].buy_price_min}}-{{guest.requires[0].buy_price_max}}万</p>'+
							'<div class="customer-div-x" v-if="guest.requires.length>0">{{guest.requires[0].buy_area_min}}-{{guest.requires[0].buy_area_max}}平/米、{{guest.requires[0].buy_room_min}}-{{guest.requires[0].buy_room_max}}居、{{require_trade_areas}}</div>'+
						'</div>'+
						'<div class="col-sm-1 all-col">'+
							'<p class="customer-p-j" style="font-weight:bold" v-html="progress"></p>'+
						'</div>'+
						'<div class="col-sm-1 all-col">'+
							'<p class="customer-p-x">下次带看</p>'+
							'<div class="customer-div-x">暂未安排</div>'+
						'</div>'+
						'<div class="col-sm-1 all-col">'+
							'<p class="customer-p-x">{{guest.takesee_count}}次</p>'+
							'<div class="customer-div-x">{{takesee_time}}</div>'+
						'</div>'+
						'<div class="col-sm-1 all-col">'+
							'<p class="customer-p-j" v-html="create_time"></p>'+
						'</div>'+
						'<div class="col-sm-2 all-col">'+
							'<p class="customer-p-j">8-20 17:11</p>'+
						'</div>'+
						'<div class="col-sm-1 all-col">'+
							'<a class="customer-p-c" style="cursor:pointer" target="_blank" @click="clickGuest()" href="javascript:">查看详情</a>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both">'+
						'<p class="customer-b" style="float:left;margin-right:10px;" v-for="l in guest.labels" v-html="l"></p>'+
					'</div>'+
				'</div>',
		created:function() {
			if(this.guest.labels && !(this.guest.labels instanceof Array)) {
				this.guest.labels = this.guest.labels.split("|");
			} else {
				this.guest.labels = [];
			}
			
			for(var i = 0; i < this.guest.requires.length; i++) {
				try {
					this.guest.requires[i].buy_trade_areas = JSON.parse(this.guest.requires[i].buy_trade_areas);
				} catch(e) {
					this.guest.requires[i].buy_trade_areas = [];
				}
			}
			
			function sortRequire(a,b) {
				if(a.create_time < b.create_time) {
					return 1;
				}
				return -1;
			}
			
			this.guest.requires.sort(sortRequire);
		},
		mounted:function() {
		},
		computed:{
			visited:function() {
				if(this.visited_guests.indexOf(this.guest.guest_id) >= 0) {
					return true;
				} else {
					return false;
				}
			},
			require_trade_areas:function() {
				var names = [];
				for(var i = 0;i < this.guest.requires[0].buy_trade_areas.length; i++) {
					names.push(this.guest.requires[0].buy_trade_areas[i].name);
				}
				return names.join(",");
			},
			progress:function() {
				var s = ['未带看','首看','已签约','已结单'];
				return s[this.guest.curr_progress];
			},
			create_time:function() {
				var timestamp = new Date().getTime()/1000;
				if((timestamp - this.guest.create_time) < 3600) {
					return Math.floor((timestamp - this.guest.create_time)/60)+'分钟前';
				} else if((timestamp - this.guest.create_time) < 3600*24) {
					return Math.floor((timestamp - this.guest.create_time)/3600)+'小时前';
				} else {
					return Math.floor((timestamp - this.guest.create_time)/86400)+'天前';
				}
			},
			takesee_time:function() {
				var timestamp = new Date().getTime()/1000;
				var timestamp2 = Date.parse(new Date(this.guest.takesee_time))/1000;
				if((timestamp - timestamp2) < 3600) {
					return Math.floor((timestamp - timestamp2)/60)+'分钟前';
				} else if((timestamp - timestamp2) < 3600*24) {
					return Math.floor((timestamp - timestamp2)/3600)+'小时前';
				} else {
					return Math.floor((timestamp - timestamp2)/86400)+'天前';
				}
			}
		},
		methods:{
			clickGuest:function() {
				if(!this.visited) {
					visitedGuests.push(this.guest.guest_id);
					var date = new Date();
					date.setTime(date.getTime()+3600*12000);
					$.cookie("visited_guests", JSON.stringify(visitedGuests), {expires:date});
				}
				location.href = 'guest/guest_detail_page?guest_id=' + this.guest.guest_id;
			}
		}
	});
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				visited_guests:visitedGuests,
				show_my_search:true,
				my_labels:<?=json_encode($labels)?>,
				my_search:{
					guest:{
						like_name:'',//名词搜索
						intention:'',
						curr_progress:'',
						min_price:'',
						max_price:'',
						min_area:'',
						max_area:'',
						room_count:'',
						label:''
					},

					house_info_id:'',//房源编号
					maintain_name:'',//维护人姓名
					pi:1,
					pc:12
				},
				my_page_changed:false,
				my_total_count:0,
				my_page_count:0,
				my_page_guests:{},
				my_guest_count:{
					intention:[0,0,0,0],
					curr_progress:[0,0,0,0],
				},
				my_price_min:'',
				my_price_max:'',
				my_area_min:'',
				my_area_max:'',
				my_like_name:'',
				
				employee:<?=json_encode($employee)?>,
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				house_infoes:<?=json_encode($house_infoes)?>,
			},
			created:function() {
				var that = this;
				API.invokeModuleCall(g_host_url,'guest','initQueryMyRentGuest', {}, function(json) {
					for(var i = 0; i < json.intention.length; i++) {
						that.my_guest_count.intention[i] = json.intention[i];
					}
					
					for(var i = 0; i < json.curr_progress.length; i++) {
						that.my_guest_count.curr_progress[i] = json.curr_progress[i];
					}
					that.$forceUpdate();
				});
				
				this.my_page_guests = [];
				this.my_search.pi = 1;
				
				var that = this;
				console.log("load:"+that.my_search.pi);
				API.invokeModuleCall(g_host_url, 'guest', 'queryMyRentGuest', this.my_search, function(json) {
					that.my_total_count = json.total_count;
					that.my_page_count = json.page_count;
					that.my_page_guests[that.my_search.pi+''] = json.guests;
				});
				
			},
			computed:{
				
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				show_my_search:function(val) {
					$("#show_my_search").slideToggle();
				},
				my_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.my_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.my_page_guests[that.my_search.pi]) == "undefined") {
								console.log("load1:"+that.my_search.pi);
								API.invokeModuleCall(g_host_url, 'guest', 'queryMyRentGuest', this.my_search, function(json) {
									that.my_total_count = json.total_count;
									that.my_page_count = json.page_count;
									that.my_page_guests[that.my_search.pi+''] = json.guests;
									that.$forceUpdate();
								});
							}
							this.my_page_changed = false;
						} else {
							this.my_page_guests = {};
							console.log("load2:"+that.my_search.pi);
							API.invokeModuleCall(g_host_url, 'guest', 'queryMyRentGuest', this.my_search, function(json) {
								that.my_total_count = json.total_count;
								that.my_page_count = json.page_count;
								that.my_page_guests[that.my_search.pi+''] = json.guests;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				}
			},
			methods:{
				onConfirmMyPrice:function() {
					this.my_search.guest.min_price = this.my_price_min;
					this.my_search.guest.max_price = this.my_price_max;
				},
				onConfirmMyArea:function() {
					this.my_search.guest.min_area = this.my_area_min;
					this.my_search.guest.max_area = this.my_area_max;
				},
				setMySearchIntention:function(i) {
					this.my_search.guest.intention = i;
				}
			}
		})
	});
</script>
</html>