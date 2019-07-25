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
	<link href="../../../static/css/availability.css" rel="stylesheet">
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
	<style>
		.all-col-z i {
			cursor:pointer;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='房源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="houseinfo/house_info_list_page">买卖</a></li>
			<li class="active"><a href="houseinfo/house_info_rent_list_page">租赁</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源-租赁
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<ul class="sel-menu-ul"role="tablist">
			<li role="presentation" class="active sel-menu"><a href="#all" role="tab" data-toggle="tab" aria-expanded="true">全部房源</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu" @click="if(!subway_search.load) subway_search.load=true;"><a href="#subway" role="tab" data-toggle="tab" aria-expanded="false">地铁找房</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu" @click="if(!focus_search.load) focus_search.load=true;"><a href="#topic" role="tab" data-toggle="tab" aria-expanded="false">聚焦专题</a><div class="wh-line"></div></li>
			<?php if($employee['role'] > 0 || $employee['type'] != ADMIN_TYPE_NONE) { ?>
			<li role="presentation" class="sel-menu sel-menu-r"><a style="color:#fff;" target="_blank" href="houseinfo/house_info_add_page"><i class="fa fa-file-text-o">&nbsp;</i>录入房源</a></li>
			<?php } ?>
			<?php if($employee['batch_add_house'] == 1) { ?>
			<li role="presentation" class="sel-menu sel-menu-r"><a style="color:#fff;" target="_blank" href="houseinfo/houseinfo_batch_add_page"><i class="fa fa-file-text-o">&nbsp;</i>批量录入</a></li>
			<?php } ?>
			<li role="presentation" class="sel-menu sel-menu-d hide"><a href="#similar" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o">&nbsp;</i>待审核房源</a></li>
			<li style="clear:both"></li>
		</ul>
		
		<div class="tab-content" id="tab_content_b">
			<!--全部房源--->
			<div role="tabpanel" class="tab-pane active" id="all">
				<div class="list-page-div">
					<div class="form-group list-page-div-group">
						<div class="col-sm-3">
							<input type="text" class="form-control" placeholder="请输入楼盘名称"  v-model="all_community_name"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="楼栋" v-model="all_build_block"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="输入房源编号" v-model="all_house_info_id"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="请输入维护人姓名" v-model="all_maintain_name"></input>
						</div>
						<div class="col-sm-1">
							<span class="btn btn-success list-page-div-btn " @click="all_search.community_name=all_community_name;all_search.build_block=all_build_block;all_search.house_info_id=all_house_info_id;all_search.maintain_name=all_maintain_name;all_search.pi=1;">搜索</span>
						</div>
						<div class="col-sm-2">
							<a class="list-page-div-a col-sm-1" href="javascript:" @click="show_all_search=!show_all_search"><i :class="{fa:true,'fa-level-up':show_all_search,'fa-level-down':!show_all_search}"></i>{{show_all_search?'收起':'展开'}}</a>
						</div>
						
					</div>
					<div id="all_search_option">
						<div class="form-group form-option">
							<span style="padding-left:0px">范围：</span>
							<span :class="{active:all_search.range===''}" @click="all_search.range=''">不限</span>
							<span :class="{active:all_search.range===0}" @click="all_search.range=0">范围盘房源</span>
							<span :class="{active:all_search.range==1}" @click="all_search.range=1">维护盘房源</span>
							<span :class="{active:all_search.range==2}" @click="all_search.range=2">责任盘房源</span>
							<span :class="{active:all_search.range==3}" @click="all_search.range=3">角色房源</span>
							<span :class="{active:all_search.range==4}" @click="all_search.range=4">共享池房源</span>
							<span :class="{active:all_search.range==5}" @click="all_search.range=5">关注房源</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">片区：</span>
							<span :class="{active:all_search.area_id==''}" @click="all_search.area_id=''">不限</span>
							<span v-for="area in areas" v-html="area.name" :class="{active:all_search.area_id==area.area_id}" @click="all_search.area_id=area.area_id"></span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">价格：</span>
							<span :class="{active:all_search.min_price==''&&all_search.max_price==''}" @click="all_search.min_price='';all_search.max_price='';">不限</span>
							<span :class="{active:all_search.min_price==0&&all_search.max_price==2000}" @click="all_search.min_price=0;all_search.max_price=2000;">2000以下</span>
							<span :class="{active:all_search.min_price==2000&&all_search.max_price==4000}" @click="all_search.min_price=2000;all_search.max_price=4000;">2000-4000</span>
							<span :class="{active:all_search.min_price==4000&&all_search.max_price==6000}" @click="all_search.min_price=4000;all_search.max_price=6000;">4000-6000</span>
							<span :class="{active:all_search.min_price==6000&&all_search.max_price==9000}" @click="all_search.min_price=6000;all_search.max_price=9000;">6000-9000</span>
							<span :class="{active:all_search.min_price==9000&&all_search.max_price==15000}" @click="all_search.min_price=9000;all_search.max_price=15000;">9000-15000</span>
							<span :class="{active:all_search.min_price==15000}" @click="all_search.min_price=15000;all_search.max_price='';">15000以上</span>
							<input type="tel" class="form-control form-option-input" v-model="all_price_min" style="width:70px"></input>
							-
							<input type="tel" class="form-control form-option-input" v-model="all_price_max" style="width:70px"></input>
							<span class="form-option-btn" @click="onConfirmAllPrice()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">面积：</span>
							<span :class="{active:all_search.area_min==''&&all_search.area_max==''}" @click="all_search.area_min='';all_search.area_max='';">不限</span>
							<span :class="{active:all_search.area_min==0&&all_search.area_max==50}" @click="all_search.area_min=0;all_search.area_max=50;">50平米以下</span>
							<span :class="{active:all_search.area_min==50&&all_search.area_max==70}" @click="all_search.area_min=50;all_search.area_max=70;">50-70平米</span>
							<span :class="{active:all_search.area_min==70&&all_search.area_max==90}" @click="all_search.area_min=70;all_search.area_max=90;">70-90平米</span>
							<span :class="{active:all_search.area_min==90&&all_search.area_max==110}" @click="all_search.area_min=90;all_search.area_max=110;">90-110平米</span>
							<span :class="{active:all_search.area_min==100&&all_search.area_max==130}" @click="all_search.area_min=100;all_search.area_max=130;">100-130平米</span>
							<span :class="{active:all_search.area_min==130&&all_search.area_max==150}" @click="all_search.area_min=130;all_search.area_max=150;">130-150平米</span>
							<span :class="{active:all_search.area_min==150&&all_search.area_max==200}" @click="all_search.area_min=150;all_search.area_max=200;">150-200平米</span>
							<span :class="{active:all_search.area_min==200&&all_search.area_max==''}" @click="all_search.area_min=200;all_search.area_max='';">200平米以上</span>
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="all_area_min"></input>
							-
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="all_area_max"></input>
							<span class="form-option-btn" @click="onConfirmAllArea()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">居室：</span>
							<span :class="{active:all_search.room_count==''}" @click="all_search.room_count='';">不限</span>
							<span :class="{active:all_search.room_count==1}" @click="all_search.room_count=1;all_search.room_min='';all_search.room_max='';">1室</span>
							<span :class="{active:all_search.room_count==2}" @click="all_search.room_count=2;all_search.room_min='';all_search.room_max='';">2室</span>
							<span :class="{active:all_search.room_count==3}" @click="all_search.room_count=3;all_search.room_min='';all_search.room_max='';">3室</span>
							<span :class="{active:all_search.room_count==4}" @click="all_search.room_count=4;all_search.room_min='';all_search.room_max='';">4室</span>
							<span :class="{active:all_search.room_count==5}" @click="all_search.room_count=5;all_search.room_min='';all_search.room_max='';">5室</span>
							<span :class="{active:all_search.room_count>=6}" @click="all_search.room_count=6;all_search.room_min='';all_search.room_max='';">5室以上</span>
							<input type="tel" class="form-control form-option-input" v-model="all_room_min"></input>
							-
							<input type="tel" class="form-control form-option-input" v-model="all_room_max"></input>
							<span class="form-option-btn" @click="all_search.room_count='';all_search.room_min=all_room_min;all_search.room_max=all_room_max;">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">朝向：</span>
							<span :class="{active:all_search.orientation.length==0}" @click="all_search.orientation = [];">不限</span>
							<span :class="{active:all_search.orientation.indexOf('_e')>=0}" @click="if(all_search.orientation.indexOf('_e')<0) all_search.orientation.push('_e'); else all_search.orientation.splice(all_search.orientation.indexOf('_e'),1);">东</span>
							<span :class="{active:all_search.orientation.indexOf('es')>=0}" @click="if(all_search.orientation.indexOf('es')<0) all_search.orientation.push('es'); else all_search.orientation.splice(all_search.orientation.indexOf('es'),1);">东南</span>
							<span :class="{active:all_search.orientation.indexOf('_s')>=0}" @click="if(all_search.orientation.indexOf('_s')<0) all_search.orientation.push('_s'); else all_search.orientation.splice(all_search.orientation.indexOf('_s'),1);">南</span>
							<span :class="{active:all_search.orientation.indexOf('ws')>=0}" @click="if(all_search.orientation.indexOf('ws')<0) all_search.orientation.push('ws'); else all_search.orientation.splice(all_search.orientation.indexOf('ws'),1);">西南</span>
							<span :class="{active:all_search.orientation.indexOf('_w')>=0}" @click="if(all_search.orientation.indexOf('_w')<0) all_search.orientation.push('_w'); else all_search.orientation.splice(all_search.orientation.indexOf('_w'),1);">西</span>
							<span :class="{active:all_search.orientation.indexOf('wn')>=0}" @click="if(all_search.orientation.indexOf('wn')<0) all_search.orientation.push('wn'); else all_search.orientation.splice(all_search.orientation.indexOf('wn'),1);">西北</span>
							<span :class="{active:all_search.orientation.indexOf('_n')>=0}" @click="if(all_search.orientation.indexOf('_n')<0) all_search.orientation.push('_n'); else all_search.orientation.splice(all_search.orientation.indexOf('_n'),1);">北</span>
							<span :class="{active:all_search.orientation.indexOf('en')>=0}" @click="if(all_search.orientation.indexOf('en')<0) all_search.orientation.push('en'); else all_search.orientation.splice(all_search.orientation.indexOf('en'),1);">东北</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">楼层：</span>
							<span :class="{active:all_search.floor_type===''}" @click="all_search.floor_type='';all_search.floor_min='';all_search.floor_max='';">不限</span>
							<span :class="{active:all_search.floor_type===0}" @click="all_search.floor_type=0;all_search.floor_min='';all_search.floor_max='';">地下室</span>
							<span :class="{active:all_search.floor_type===1}" @click="all_search.floor_type=1;all_search.floor_min='';all_search.floor_max='';">一层</span>
							<span :class="{active:all_search.floor_type===2}" @click="all_search.floor_type=2;all_search.floor_min='';all_search.floor_max='';">顶层</span>
							<input type="text" class="form-control form-option-input" v-model="all_floor_min"></input>
							-
							<input type="text" class="form-control form-option-input" v-model="all_floor_max"></input>
							<span class="form-option-btn" @click="all_search.floor_type='';all_search.floor_min=all_floor_min;all_search.floor_max=all_floor_max;">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">筛选：</span>
							<span style="" class="active">不限</span>
							<select v-model="all_search.level">
								<option value="" disabled selected style="display:none">房屋等级</option>
								<option value="">不限</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
							<select v-model="all_search.real_check">
								<option value="" disabled selected style="display:none">实勘</option>
								<option value="">不限</option>
								<option value="0">无实勘</option>
								<option value="1">有实勘</option>
							</select>
							<select v-model="all_search.delegate_type">
								<option value="" disabled selected style="display:none">委托类别</option>
								<option value="">不限</option>
								<option value="0">无委托书</option>
								<option value="1">一般委托</option>
								<option value="2">信任委托</option>
								<option value="3">全权委托</option>
							</select>
							<select v-model="all_search.has_key">
								<option value="" disabled selected style="display:none">钥匙</option>
								<option value="">不限</option>			
								<option value="0">无钥匙</option>
								<option value="1">有钥匙</option>
							</select>
							<select v-model="all_search.my_role">
								<option value="" disabled selected style="display:none">我的角色</option>
								<option value="">不限</option>
								<option value="1">录入人</option>
								<option value="2">维护人</option>
								<option value="3">钥匙人</option>
								<option value="4">实勘人</option>
							</select>
							<select v-model="all_search.house_state">
								<option value="" disabled selected style="display:none">房屋现状</option>
								<option value="">不限</option>
								<option value="0">自住</option>
								<option value="1">出租中</option>
								<option value="2">空置</option>
								<option value="3">经营中</option>
							</select>
							<select v-model="all_search.building_type">
								<option value="" disabled selected style="display:none">建筑类型</option>
								<option value="">不限</option>
								<option value="0">板楼</option>
								<option value="1">塔楼</option>
								<option value="2">板塔结合</option>
								<option value="3">别墅</option>
								<option value="4">洋房</option>
							</select>
							<select v-model="all_search.houseage_type">
								<option value="" disabled selected style="display:none">房龄</option>
								<option value="">不限</option>
								<option value="2">两年内</option>
								<option value="5">五年内</option>
								<option value="10">十年内</option>
							</select>
							<select v-model="all_search.cert_full">
								<option value="" disabled selected style="display:none">证件状态</option>
								<option value="">不限</option>
								<option value="0">证件不全</option>
								<option value="1">证件齐全</option>
							</select>
							
							<select v-model="all_search.invalid">
								<option value="" disabled selected style="display:none">房源状态</option>
								<option value="">不限</option>
								<option value="0">有效</option>
								<option value="1">无效</option>
								<option value="2">成交</option>
							</select>
							
							<select v-model="all_search.info_complete">
								<option value="" disabled selected style="display:none">信息完整</option>
								<option value="">不限</option>
								<option value="0">信息不全</option>
								<option value="1">信息完全</option>
							</select>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">标签：</span>
							<span style="" class="active">不限</span>
							<span>聚焦</span>
							<span>不限购</span>
							<span>满五唯一</span>
							<span>满五</span>
							<span>满二</span>
							<span>租售</span>
							<span>学区房</span>
							<span>连环单</span>
							<span>法拍房</span>
							<span>掌上链家</span>
						</div>
					</div>
				</div>
				
				<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
					房源列表
					<span class="pull-right" style="font-size:1.2rem">
						符合要求的房源共有<span style="color:#FF6863" v-html="all_total_count"></span>套
					</span>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading panel-title"  style="border-top:1px solid #ddd">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">标题图片</div>
							<div class="col-sm-2 all-col all-col-z">楼盘名称</div>
							<div class="col-sm-1 all-col all-col-z" @click="setAllSearchOrder('room_count');">
								户型<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='room_count'&&all_search.order_type=='desc')||all_search.order_name!='room_count','fa-chevron-up':all_search.order_name=='room_count'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setAllSearchOrder('area');">
								面积<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='area'&&all_search.order_type=='desc')||all_search.order_name!='area','fa-chevron-up':all_search.order_name=='area'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setAllSearchOrder('price');">
								总价/单价<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='price'&&all_search.order_type=='desc')||all_search.order_name!='price','fa-chevron-up':all_search.order_name=='price'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setAllSearchOrder('floor');">
								楼层<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='floor'&&all_search.order_type=='desc')||all_search.order_name!='floor','fa-chevron-up':all_search.order_name=='floor'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">朝向</div>
							<div class="col-sm-1 all-col all-col-z" @click.stop="setAllSearchOrder('ss_distance',$event);">
								地铁距离<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='ss_distance'&&all_search.order_type=='desc')||all_search.order_name!='ss_distance','fa-chevron-up':all_search.order_name=='ss_distance'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setAllSearchOrder('update_time');">
								挂牌<i :class="{fa:true,'fa-chevron-down':(all_search.order_name=='update_time'&&all_search.order_type=='desc')||all_search.order_name!='update_time','fa-chevron-up':all_search.order_name=='update_time'&&all_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">维护人</div>
						</div>
					</div>
					<div class="panel-body">
						<house-item v-if="all_page_houses[all_search.pi]" v-for="h in all_page_houses[all_search.pi]" :house="h" :visited_houses="visited_houses"></house-item>


						<div class="col-sm-12" style="text-align:center">
							<ul class="pagination">
								<li :class="{disabled:all_search.pi<all_page_count}"><a href="javascript:" @click="if(all_search.pi>=all_page_count) {all_page_changed=true;all_search.pi--;}">&laquo;</a></li>

								<li v-for="p in all_page_count"  :class="{active:p==all_search.pi}"><a href="javascript:" v-html="p" @click="all_page_changed=true;all_search.pi=p;"></a></li>

								<li :class="{disabled:all_search.pi>=all_page_count}"><a href="javascript:" @click="if(all_search.pi<all_page_count) {all_page_changed=true;all_search.pi++;}">&raquo;</a></li>								
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--地铁找房--->
			<div role="tabpanel" class="tab-pane" id="subway">
				<div class="list-page-div">
					<div class="form-group form-option list-page-div-group-d">
						<span style="padding-left:0px">地铁：</span>
						<span :class="{active:subway_search.subway_id===''}" @click="subway_search.subway_id=''">不限</span>
						<span v-for="s in subways" v-html="s.name" :class="{active:s.subway_id==subway_search.subway_id}" @click="subway_search.subway_id=s.subway_id"></span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">距离：</span>
						<span :class="{active:subway_search.distance===''}" @click="subway_search.distance=''">不限</span>
						<span :class="{active:subway_search.distance==500}" @click="subway_search.distance=500">500米以内</span>
						<span :class="{active:subway_search.distance==800}" @click="subway_search.distance=800">500~800米以内</span>
						<span :class="{active:subway_search.distance==1200}" @click="subway_search.distance=1200">800~1200米以内</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">价格：</span>
						<span :class="{active:subway_search.min_price==''&&subway_search.max_price==''}" @click="subway_search.min_price='';subway_search.max_price='';">不限</span>
							<span :class="{active:subway_search.min_price==0&&subway_search.max_price==2000}" @click="subway_search.min_price=0;subway_search.max_price=100;">2000以下</span>
							<span :class="{active:subway_search.min_price==2000&&subway_search.max_price==4000}" @click="subway_search.min_price=2000;subway_search.max_price=4000;">2000-4000</span>
							<span :class="{active:subway_search.min_price==4000&&subway_search.max_price==6000}" @click="subway_search.min_price=4000;subway_search.max_price=6000;">4000-6000</span>
							<span :class="{active:subway_search.min_price==6000&&subway_search.max_price==9000}" @click="subway_search.min_price=6000;subway_search.max_price=9000;">6000-9000</span>
							<span :class="{active:subway_search.min_price==9000&&subway_search.max_price==15000}" @click="subway_search.min_price=9000;subway_search.max_price=15000;">9000-15000</span>
							<span :class="{active:subway_search.min_price==15000}" @click="subway_search.min_price=15000;subway_search.max_price='';">15000以上</span>
						<input type="tel" class="form-control form-option-input" v-model="subway_price_min" style="width:70px"></input>
						-
						<input type="tel" class="form-control form-option-input" v-model="subway_price_max" style="width:70px"></input>
						<span class="form-option-btn" @click="onConfirmSubwayPrice()">确定</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">面积：</span>
						<span :class="{active:subway_search.area_min==''&&subway_search.area_max==''}" @click="subway_search.area_min='';subway_search.area_max='';">不限</span>
						<span :class="{active:subway_search.area_min==0&&subway_search.area_max==50}" @click="subway_search.area_min=0;subway_search.area_max=50;">50平米以下</span>
						<span :class="{active:subway_search.area_min==50&&subway_search.area_max==70}" @click="subway_search.area_min=50;subway_search.area_max=70;">50-70平米</span>
						<span :class="{active:subway_search.area_min==70&&subway_search.area_max==90}" @click="subway_search.area_min=70;subway_search.area_max=90;">70-90平米</span>
						<span :class="{active:subway_search.area_min==90&&subway_search.area_max==110}" @click="subway_search.area_min=90;subway_search.area_max=110;">90-110平米</span>
						<span :class="{active:subway_search.area_min==100&&subway_search.area_max==130}" @click="subway_search.area_min=100;subway_search.area_max=130;">100-130平米</span>
						<span :class="{active:subway_search.area_min==130&&subway_search.area_max==150}" @click="subway_search.area_min=130;subway_search.area_max=150;">130-150平米</span>
						<span :class="{active:subway_search.area_min==150&&subway_search.area_max==200}" @click="subway_search.area_min=150;subway_search.area_max=200;">150-200平米</span>
						<span :class="{active:subway_search.area_min==200&&subway_search.area_max==''}" @click="subway_search.area_min=200;subway_search.area_max='';">200平米以上</span>
						<input type="tel" class="form-control form-option-input" style="width:70px" v-model="subway_area_min"></input>
						-
						<input type="tel" class="form-control form-option-input" style="width:70px" v-model="subway_area_max"></input>
						<span class="form-option-btn" @click="onConfirmSubwayArea()">确定</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">居室：</span>
						<span :class="{active:subway_search.room_count==''}" @click="subway_search.room_count='';">不限</span>
						<span :class="{active:subway_search.room_count==1}" @click="subway_search.room_count=1;subway_search.room_min='';subway_search.room_max='';">1室</span>
						<span :class="{active:subway_search.room_count==2}" @click="subway_search.room_count=2;subway_search.room_min='';subway_search.room_max='';">2室</span>
						<span :class="{active:subway_search.room_count==3}" @click="subway_search.room_count=3;subway_search.room_min='';subway_search.room_max='';">3室</span>
						<span :class="{active:subway_search.room_count==4}" @click="subway_search.room_count=4;subway_search.room_min='';subway_search.room_max='';">4室</span>
						<span :class="{active:subway_search.room_count==5}" @click="subway_search.room_count=5;subway_search.room_min='';subway_search.room_max='';">5室</span>
						<span :class="{active:subway_search.room_count>=6}" @click="subway_search.room_count=6;subway_search.room_min='';subway_search.room_max='';">5室以上</span>
						<input type="tel" class="form-control form-option-input" v-model="subway_room_min"></input>
						-
						<input type="tel" class="form-control form-option-input" v-model="subway_room_max"></input>
						<span class="form-option-btn" @click="subway_search.room_count='';subway_search.room_min=subway_room_min;subway_search.room_max=subway_room_max;">确定</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">朝向：</span>
						<span :class="{active:subway_search.orientation.length==0}" @click="subway_search.orientation = [];">不限</span>
						<span :class="{active:subway_search.orientation.indexOf('_e')>=0}" @click="if(subway_search.orientation.indexOf('_e')<0) subway_search.orientation.push('_e'); else subway_search.orientation.splice(subway_search.orientation.indexOf('_e'),1);">东</span>
						<span :class="{active:subway_search.orientation.indexOf('es')>=0}" @click="if(subway_search.orientation.indexOf('es')<0) subway_search.orientation.push('es'); else subway_search.orientation.splice(subway_search.orientation.indexOf('es'),1);">东南</span>
						<span :class="{active:subway_search.orientation.indexOf('_s')>=0}" @click="if(subway_search.orientation.indexOf('_s')<0) subway_search.orientation.push('_s'); else subway_search.orientation.splice(subway_search.orientation.indexOf('_s'),1);">南</span>
						<span :class="{active:subway_search.orientation.indexOf('ws')>=0}" @click="if(subway_search.orientation.indexOf('ws')<0) subway_search.orientation.push('ws'); else subway_search.orientation.splice(subway_search.orientation.indexOf('ws'),1);">西南</span>
						<span :class="{active:subway_search.orientation.indexOf('_w')>=0}" @click="if(subway_search.orientation.indexOf('_w')<0) subway_search.orientation.push('_w'); else subway_search.orientation.splice(subway_search.orientation.indexOf('_w'),1);">西</span>
						<span :class="{active:subway_search.orientation.indexOf('wn')>=0}" @click="if(subway_search.orientation.indexOf('wn')<0) subway_search.orientation.push('wn'); else subway_search.orientation.splice(subway_search.orientation.indexOf('wn'),1);">西北</span>
						<span :class="{active:subway_search.orientation.indexOf('_n')>=0}" @click="if(subway_search.orientation.indexOf('_n')<0) subway_search.orientation.push('_n'); else subway_search.orientation.splice(subway_search.orientation.indexOf('_n'),1);">北</span>
						<span :class="{active:subway_search.orientation.indexOf('en')>=0}" @click="if(subway_search.orientation.indexOf('en')<0) subway_search.orientation.push('en'); else subway_search.orientation.splice(subway_search.orientation.indexOf('en'),1);">东北</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">楼层：</span>
						<span :class="{active:subway_search.floor_type===''}" @click="subway_search.floor_type='';subway_search.floor_min='';subway_search.floor_max='';">不限</span>
						<span :class="{active:subway_search.floor_type===0}" @click="subway_search.floor_type=0;subway_search.floor_min='';subway_search.floor_max='';">地下室</span>
						<span :class="{active:subway_search.floor_type===1}" @click="subway_search.floor_type=1;subway_search.floor_min='';subway_search.floor_max='';">一层</span>
						<span :class="{active:subway_search.floor_type===2}" @click="subway_search.floor_type=2;subway_search.floor_min='';subway_search.floor_max='';">顶层</span>
						<input type="text" class="form-control form-option-input" v-model="subway_floor_min"></input>
						-
						<input type="text" class="form-control form-option-input" v-model="subway_floor_max"></input>
						<span class="form-option-btn" @click="subway_search.floor_type='';subway_search.floor_min=subway_floor_min;subway_search.floor_max=subway_floor_max;">确定</span>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">筛选：</span>
						<span style="" class="active">不限</span>
						<select v-model="subway_search.level">
							<option value="" disabled selected style="display:none">房屋等级</option>
							<option value="">不限</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
						</select>
						<select v-model="subway_search.real_check">
							<option value="" disabled selected style="display:none">实勘</option>
							<option value="">不限</option>
							<option value="0">无实勘</option>
							<option value="1">有实勘</option>
						</select>
						<select v-model="subway_search.delegate_type">
							<option value="" disabled selected style="display:none">委托类别</option>
							<option value="">不限</option>
							<option value="0">无委托书</option>
							<option value="1">一般委托</option>
							<option value="2">信任委托</option>
							<option value="3">全权委托</option>
						</select>
						<select v-model="subway_search.has_key">
							<option value="" disabled selected style="display:none">钥匙</option>
							<option value="">不限</option>			
							<option value="0">无钥匙</option>
							<option value="1">有钥匙</option>
						</select>
						<select v-model="subway_search.my_role">
							<option value="" disabled selected style="display:none">我的角色</option>
							<option value="">不限</option>
							<option value="1">录入人</option>
							<option value="2">维护人</option>
							<option value="3">钥匙人</option>
							<option value="4">实勘人</option>
						</select>
						<select v-model="subway_search.house_state">
							<option value="" disabled selected style="display:none">房屋现状</option>
							<option value="">不限</option>
							<option value="0">自住</option>
							<option value="1">出租中</option>
							<option value="2">空置</option>
							<option value="3">经营中</option>
						</select>
						<select v-model="subway_search.building_type">
							<option value="" disabled selected style="display:none">建筑类型</option>
							<option value="">不限</option>
							<option value="0">板楼</option>
							<option value="1">塔楼</option>
							<option value="2">板塔结合</option>
							<option value="3">别墅</option>
							<option value="4">洋房</option>
						</select>
						<select v-model="subway_search.houseage_type">
							<option value="" disabled selected style="display:none">房龄</option>
							<option value="">不限</option>
							<option value="2">两年内</option>
							<option value="5">五年内</option>
							<option value="10">十年内</option>
						</select>
						<select v-model="subway_search.cert_full">
							<option value="" disabled selected style="display:none">证件状态</option>
							<option value="">不限</option>
							<option value="0">证件不全</option>
							<option value="1">证件齐全</option>
						</select>
						<select v-model="subway_search.invalid">
							<option value="" disabled selected style="display:none">房源状态</option>
							<option value="">不限</option>
							<option value="0">有效</option>
							<option value="1">无效</option>
							<option value="2">成交</option>
						</select>
						
						<select v-model="subway_search.info_complete">
							<option value="" disabled selected style="display:none">信息完整</option>
							<option value="">不限</option>
							<option value="0">信息不全</option>
							<option value="1">信息完全</option>
						</select>
					</div>
					<div class="form-group form-option">
						<span style="padding-left:0px">标签：</span>
						<span style="" class="active">不限</span>
						<span>聚焦</span>
						<span>不限购</span>
						<span>满五唯一</span>
						<span>满五</span>
						<span>满二</span>
						<span>租售</span>
						<span>学区房</span>
						<span>连环单</span>
						<span>法拍房</span>
						<span>掌上链家</span>
					</div>
				</div>
				<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
					房源列表
					<span class="pull-right" style="font-size:1.2rem">
						符合要求的房源共有<span style="color:#FF6863" v-html="subway_total_count"></span>套
					</span>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading panel-title">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">标题图片</div>
							<div class="col-sm-2 all-col all-col-z">楼盘名称</div>
							<div class="col-sm-1 all-col all-col-z" @click="setSubwaySearchOrder('room_count');">
								户型<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='room_count'&&subway_search.order_type=='desc')||subway_search.order_name!='room_count','fa-chevron-up':subway_search.order_name=='room_count'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setSubwaySearchOrder('area');">
								面积<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='area'&&subway_search.order_type=='desc')||subway_search.order_name!='area','fa-chevron-up':subway_search.order_name=='area'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setSubwaySearchOrder('price');">
								总价/单价<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='price'&&subway_search.order_type=='desc')||subway_search.order_name!='price','fa-chevron-up':subway_search.order_name=='price'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setSubwaySearchOrder('floor');">
								楼层<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='floor'&&subway_search.order_type=='desc')||subway_search.order_name!='floor','fa-chevron-up':subway_search.order_name=='floor'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">朝向</div>
							<div class="col-sm-1 all-col all-col-z" @click.stop="setSubwaySearchOrder('ss_distance',$event);">
								地铁距离<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='ss_distance'&&subway_search.order_type=='desc')||subway_search.order_name!='ss_distance','fa-chevron-up':subway_search.order_name=='ss_distance'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setSubwaySearchOrder('update_time');">
								挂牌<i :class="{fa:true,'fa-chevron-down':(subway_search.order_name=='update_time'&&subway_search.order_type=='desc')||subway_search.order_name!='update_time','fa-chevron-up':subway_search.order_name=='update_time'&&subway_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">维护人</div>
						</div>
					</div>
					<div class="panel-body">
						<house-item v-if="subway_page_houses[subway_search.pi]" v-for="h in subway_page_houses[subway_search.pi]" :house="h" :visited_houses="visited_houses"></house-item>
						
						<div class="col-sm-12" style="text-align:center">
							<ul class="pagination">
								<li :class="{disabled:subway_search.pi<subway_page_count}"><a href="javascript:" @click="if(subway_search.pi>=subway_page_count) {subway_page_changed=true;subway_search.pi--;}">&laquo;</a></li>

								<li v-for="p in subway_page_count"  :class="{active:p==subway_search.pi}"><a href="javascript:" v-html="p" @click="subway_page_changed=true;subway_search.pi=p;"></a></li>

								<li :class="{disabled:subway_search.pi>=subway_page_count}"><a href="javascript:" @click="if(subway_search.pi<subway_page_count) {subway_page_changed=true;subway_search.pi++;}">&raquo;</a></li>								
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--聚焦专题--->
			<div role="tabpanel" class="tab-pane" id="topic">
				<div class="list-page-div">
					<div class="form-group list-page-div-group">
						<div class="col-sm-12">
							<div class="col-sm-12 list-page-div-group-div">
								<p class="list-page-div-group-p">聚焦房源</p>
								<!--
								<a class="list-page-div-a list-page-div-a-j" href="javascript:" @click="show_focus_search=!show_focus_search" v-html="show_focus_search?'收起':'展开'">收起</a>
								-->
							</div>
						</div>
						
					</div>
					
					<div class="form-group list-page-div-group">
						<div class="col-sm-3">
							<input type="text" class="form-control" placeholder="请输入楼盘名称"  v-model="focus_community_name"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="楼栋" v-model="focus_build_block"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="输入房源编号" v-model="focus_house_info_id"></input>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="请输入维护人姓名" v-model="focus_maintain_name"></input>
						</div>
						<div class="col-sm-1">
							<span class="btn btn-success list-page-div-btn " @click="focus_search.community_name=focus_community_name;focus_search.build_block=focus_build_block;focus_search.house_info_id=focus_house_info_id;focus_search.maintain_name=focus_maintain_name;focus_search.pi=1;">搜索</span>
						</div>
						<div class="col-sm-2">
							<a class="list-page-div-a col-sm-1" href="javascript:" @click="show_focus_search=!show_focus_search"><i :class="{fa:true,'fa-level-up':show_focus_search,'fa-level-down':!show_focus_search}"></i>{{show_focus_search?'收起':'展开'}}</a>
						</div>
						
					</div>
					<div id="show_focus_search">
						<div class="form-group form-option">
							<span style="padding-left:0px">范围：</span>
							<span :class="{active:focus_search.range===''}" @click="focus_search.range=''">不限</span>
							<span :class="{active:focus_search.range===0}" @click="focus_search.range=0">范围盘房源</span>
							<span :class="{active:focus_search.range==1}" @click="focus_search.range=1">维护盘房源</span>
							<span :class="{active:focus_search.range==2}" @click="focus_search.range=2">责任盘房源</span>
							<span :class="{active:focus_search.range==3}" @click="focus_search.range=3">角色房源</span>
							<span :class="{active:focus_search.range==4}" @click="focus_search.range=4">共享池房源</span>
							<span :class="{active:focus_search.range==5}" @click="focus_search.range=5">关注房源</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">片区：</span>
							<span :class="{active:focus_search.area_id==''}" @click="focus_search.area_id=''">不限</span>
							<span v-for="area in areas" v-html="area.name" :class="{active:focus_search.area_id==area.area_id}" @click="focus_search.area_id=area.area_id"></span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">价格：</span>
							<span :class="{active:focus_search.min_price==''&&focus_search.max_price==''}" @click="focus_search.min_price='';focus_search.max_price='';">不限</span>
							<span :class="{active:focus_search.min_price==0&&focus_search.max_price==2000}" @click="focus_search.min_price=0;focus_search.max_price=2000;">2000以下</span>
							<span :class="{active:focus_search.min_price==2000&&focus_search.max_price==4000}" @click="focus_search.min_price=2000;focus_search.max_price=4000;">2000-4000</span>
							<span :class="{active:focus_search.min_price==4000&&focus_search.max_price==6000}" @click="focus_search.min_price=4000;focus_search.max_price=6000;">4000-6000</span>
							<span :class="{active:focus_search.min_price==6000&&focus_search.max_price==9000}" @click="focus_search.min_price=6000;focus_search.max_price=9000;">6000-9000</span>
							<span :class="{active:focus_search.min_price==9000&&focus_search.max_price==15000}" @click="focus_search.min_price=9000;focus_search.max_price=15000;">9000-15000</span>
							<span :class="{active:focus_search.min_price==15000}" @click="focus_search.min_price=15000;focus_search.max_price='';">15000以上</span>
							<input type="tel" class="form-control form-option-input" v-model="focus_price_min" style="width:70px"></input>
							-
							<input type="tel" class="form-control form-option-input" v-model="focus_price_max" style="width:70px"></input>
							<span class="form-option-btn" @click="onConfirmAllPrice()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">面积：</span>
							<span :class="{active:focus_search.area_min==''&&focus_search.area_max==''}" @click="focus_search.area_min='';focus_search.area_max='';">不限</span>
							<span :class="{active:focus_search.area_min==0&&focus_search.area_max==50}" @click="focus_search.area_min=0;focus_search.area_max=50;">50平米以下</span>
							<span :class="{active:focus_search.area_min==50&&focus_search.area_max==70}" @click="focus_search.area_min=50;focus_search.area_max=70;">50-70平米</span>
							<span :class="{active:focus_search.area_min==70&&focus_search.area_max==90}" @click="focus_search.area_min=70;focus_search.area_max=90;">70-90平米</span>
							<span :class="{active:focus_search.area_min==90&&focus_search.area_max==110}" @click="focus_search.area_min=90;focus_search.area_max=110;">90-110平米</span>
							<span :class="{active:focus_search.area_min==100&&focus_search.area_max==130}" @click="focus_search.area_min=100;focus_search.area_max=130;">100-130平米</span>
							<span :class="{active:focus_search.area_min==130&&focus_search.area_max==150}" @click="focus_search.area_min=130;focus_search.area_max=150;">130-150平米</span>
							<span :class="{active:focus_search.area_min==150&&focus_search.area_max==200}" @click="focus_search.area_min=150;focus_search.area_max=200;">150-200平米</span>
							<span :class="{active:focus_search.area_min==200&&focus_search.area_max==''}" @click="focus_search.area_min=200;focus_search.area_max='';">200平米以上</span>
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="focus_area_min"></input>
							-
							<input type="tel" class="form-control form-option-input" style="width:70px" v-model="focus_area_max"></input>
							<span class="form-option-btn" @click="onConfirmAllArea()">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">居室：</span>
							<span :class="{active:focus_search.room_count==''}" @click="focus_search.room_count='';">不限</span>
							<span :class="{active:focus_search.room_count==1}" @click="focus_search.room_count=1;focus_search.room_min='';focus_search.room_max='';">1室</span>
							<span :class="{active:focus_search.room_count==2}" @click="focus_search.room_count=2;focus_search.room_min='';focus_search.room_max='';">2室</span>
							<span :class="{active:focus_search.room_count==3}" @click="focus_search.room_count=3;focus_search.room_min='';focus_search.room_max='';">3室</span>
							<span :class="{active:focus_search.room_count==4}" @click="focus_search.room_count=4;focus_search.room_min='';focus_search.room_max='';">4室</span>
							<span :class="{active:focus_search.room_count==5}" @click="focus_search.room_count=5;focus_search.room_min='';focus_search.room_max='';">5室</span>
							<span :class="{active:focus_search.room_count>=6}" @click="focus_search.room_count=6;focus_search.room_min='';focus_search.room_max='';">5室以上</span>
							<input type="tel" class="form-control form-option-input" v-model="focus_room_min"></input>
							-
							<input type="tel" class="form-control form-option-input" v-model="focus_room_max"></input>
							<span class="form-option-btn" @click="focus_search.room_count='';focus_search.room_min=focus_room_min;focus_search.room_max=focus_room_max;">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">朝向：</span>
							<span :class="{active:focus_search.orientation.length==0}" @click="focus_search.orientation = [];">不限</span>
							<span :class="{active:focus_search.orientation.indexOf('_e')>=0}" @click="if(focus_search.orientation.indexOf('_e')<0) focus_search.orientation.push('_e'); else focus_search.orientation.splice(focus_search.orientation.indexOf('_e'),1);">东</span>
							<span :class="{active:focus_search.orientation.indexOf('es')>=0}" @click="if(focus_search.orientation.indexOf('es')<0) focus_search.orientation.push('es'); else focus_search.orientation.splice(focus_search.orientation.indexOf('es'),1);">东南</span>
							<span :class="{active:focus_search.orientation.indexOf('_s')>=0}" @click="if(focus_search.orientation.indexOf('_s')<0) focus_search.orientation.push('_s'); else focus_search.orientation.splice(focus_search.orientation.indexOf('_s'),1);">南</span>
							<span :class="{active:focus_search.orientation.indexOf('ws')>=0}" @click="if(focus_search.orientation.indexOf('ws')<0) focus_search.orientation.push('ws'); else focus_search.orientation.splice(focus_search.orientation.indexOf('ws'),1);">西南</span>
							<span :class="{active:focus_search.orientation.indexOf('_w')>=0}" @click="if(focus_search.orientation.indexOf('_w')<0) focus_search.orientation.push('_w'); else focus_search.orientation.splice(focus_search.orientation.indexOf('_w'),1);">西</span>
							<span :class="{active:focus_search.orientation.indexOf('wn')>=0}" @click="if(focus_search.orientation.indexOf('wn')<0) focus_search.orientation.push('wn'); else focus_search.orientation.splice(focus_search.orientation.indexOf('wn'),1);">西北</span>
							<span :class="{active:focus_search.orientation.indexOf('_n')>=0}" @click="if(focus_search.orientation.indexOf('_n')<0) focus_search.orientation.push('_n'); else focus_search.orientation.splice(focus_search.orientation.indexOf('_n'),1);">北</span>
							<span :class="{active:focus_search.orientation.indexOf('en')>=0}" @click="if(focus_search.orientation.indexOf('en')<0) focus_search.orientation.push('en'); else focus_search.orientation.splice(focus_search.orientation.indexOf('en'),1);">东北</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">楼层：</span>
							<span :class="{active:focus_search.floor_type===''}" @click="focus_search.floor_type='';focus_search.floor_min='';focus_search.floor_max='';">不限</span>
							<span :class="{active:focus_search.floor_type===0}" @click="focus_search.floor_type=0;focus_search.floor_min='';focus_search.floor_max='';">地下室</span>
							<span :class="{active:focus_search.floor_type===1}" @click="focus_search.floor_type=1;focus_search.floor_min='';focus_search.floor_max='';">一层</span>
							<span :class="{active:focus_search.floor_type===2}" @click="focus_search.floor_type=2;focus_search.floor_min='';focus_search.floor_max='';">顶层</span>
							<input type="text" class="form-control form-option-input" v-model="focus_floor_min"></input>
							-
							<input type="text" class="form-control form-option-input" v-model="focus_floor_max"></input>
							<span class="form-option-btn" @click="focus_search.floor_type='';focus_search.floor_min=focus_floor_min;focus_search.floor_max=focus_floor_max;">确定</span>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">筛选：</span>
							<span style="" class="active">不限</span>
							<select v-model="focus_search.level">
								<option value="" disabled selected style="display:none">房屋等级</option>
								<option value="">不限</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
							<select v-model="focus_search.real_check">
								<option value="" disabled selected style="display:none">实勘</option>
								<option value="">不限</option>
								<option value="0">无实勘</option>
								<option value="1">有实勘</option>
							</select>
							<select v-model="focus_search.delegate_type">
								<option value="" disabled selected style="display:none">委托类别</option>
								<option value="">不限</option>
								<option value="0">无委托书</option>
								<option value="1">一般委托</option>
								<option value="2">信任委托</option>
								<option value="3">全权委托</option>
							</select>
							<select v-model="focus_search.has_key">
								<option value="" disabled selected style="display:none">钥匙</option>
								<option value="">不限</option>			
								<option value="0">无钥匙</option>
								<option value="1">有钥匙</option>
							</select>
							<select v-model="focus_search.my_role">
								<option value="" disabled selected style="display:none">我的角色</option>
								<option value="">不限</option>
								<option value="1">录入人</option>
								<option value="2">维护人</option>
								<option value="3">钥匙人</option>
								<option value="4">实勘人</option>
							</select>
							<select v-model="focus_search.house_state">
								<option value="" disabled selected style="display:none">房屋现状</option>
								<option value="">不限</option>
								<option value="0">自住</option>
								<option value="1">出租中</option>
								<option value="2">空置</option>
								<option value="3">经营中</option>
							</select>
							<select v-model="focus_search.building_type">
								<option value="" disabled selected style="display:none">建筑类型</option>
								<option value="">不限</option>
								<option value="0">板楼</option>
								<option value="1">塔楼</option>
								<option value="2">板塔结合</option>
								<option value="3">别墅</option>
								<option value="4">洋房</option>
							</select>
							<select v-model="focus_search.houseage_type">
								<option value="" disabled selected style="display:none">房龄</option>
								<option value="">不限</option>
								<option value="2">两年内</option>
								<option value="5">五年内</option>
								<option value="10">十年内</option>
							</select>
							<select v-model="focus_search.cert_full">
								<option value="" disabled selected style="display:none">证件状态</option>
								<option value="">不限</option>
								<option value="0">证件不全</option>
								<option value="1">证件齐全</option>
							</select>
							<select v-model="focus_search.invalid">
								<option value="" disabled selected style="display:none">房源状态</option>
								<option value="">不限</option>
								<option value="0">有效</option>
								<option value="1">无效</option>
								<option value="2">成交</option>
							</select>
							
							<select v-model="focus_search.info_complete">
								<option value="" disabled selected style="display:none">信息完整</option>
								<option value="">不限</option>
								<option value="0">信息不全</option>
								<option value="1">信息完全</option>
							</select>
						</div>
						<div class="form-group form-option">
							<span style="padding-left:0px">标签：</span>
							<span style="" class="active">不限</span>
							<span>聚焦</span>
							<span>不限购</span>
							<span>满五唯一</span>
							<span>满五</span>
							<span>满二</span>
							<span>租售</span>
							<span>学区房</span>
							<span>连环单</span>
							<span>法拍房</span>
							<span>掌上链家</span>
						</div>
					</div>
				</div>
				<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
					房源列表
					<span class="pull-right" style="font-size:1.2rem">
						符合要求的房源共有<span style="color:#FF6863" v-html="focus_total_count"></span>套
					</span>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading panel-title"  style="border-top:1px solid #ddd">
						<div class="col-sm-12">
							<div class="col-sm-2 all-col all-col-z">标题图片</div>
							<div class="col-sm-2 all-col all-col-z">楼盘名称</div>
							<div class="col-sm-1 all-col all-col-z" @click="setFocusSearchOrder('room_count');">
								户型<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='room_count'&&focus_search.order_type=='desc')||focus_search.order_name!='room_count','fa-chevron-up':focus_search.order_name=='room_count'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setFocusSearchOrder('area');">
								面积<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='area'&&focus_search.order_type=='desc')||focus_search.order_name!='area','fa-chevron-up':focus_search.order_name=='area'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setFocusSearchOrder('price');">
								总价/单价<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='price'&&focus_search.order_type=='desc')||focus_search.order_name!='price','fa-chevron-up':focus_search.order_name=='price'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setFocusSearchOrder('floor');">
								楼层<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='floor'&&focus_search.order_type=='desc')||focus_search.order_name!='floor','fa-chevron-up':focus_search.order_name=='floor'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">朝向</div>
							<div class="col-sm-1 all-col all-col-z" @click.stop="setFocusSearchOrder('ss_distance',$event);">
								地铁距离<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='ss_distance'&&focus_search.order_type=='desc')||focus_search.order_name!='ss_distance','fa-chevron-up':focus_search.order_name=='ss_distance'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z" @click="setFocusSearchOrder('update_time');">
								挂牌<i :class="{fa:true,'fa-chevron-down':(focus_search.order_name=='update_time'&&focus_search.order_type=='desc')||focus_search.order_name!='update_time','fa-chevron-up':focus_search.order_name=='update_time'&&focus_search.order_type=='asc'}"></i>
							</div>
							<div class="col-sm-1 all-col all-col-z">维护人</div>
						</div>
					</div>
					<div class="panel-body">
						<house-item v-if="focus_page_houses[focus_search.pi]" v-for="h in focus_page_houses[focus_search.pi]" :house="h" :visited_houses="visited_houses"></house-item>
						<div class="col-sm-12" style="text-align:center">
							<ul class="pagination">
								<li :class="{disabled:focus_search.pi<focus_page_count}"><a href="javascript:" @click="if(focus_search.pi>=focus_page_count) {focus_page_changed=true;focus_search.pi--;}">&laquo;</a></li>

								<li v-for="p in focus_page_count"  :class="{active:p==focus_search.pi}"><a href="javascript:" v-html="p" @click="focus_page_changed=true;focus_search.pi=p;"></a></li>

								<li :class="{disabled:focus_search.pi>=focus_page_count}"><a href="javascript:" @click="if(focus_search.pi<focus_page_count) {focus_page_changed=true;focus_search.pi++;}">&raquo;</a></li>								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	var visitedHouses = [];
	if($.cookie('visited_houses')) {
		visitedHouses = JSON.parse($.cookie('visited_houses'));
	}
	
	var houseItem = Vue.component('house-item', {
		props:['house', 'visited_houses'],
		template:	'<div :class="{\'col-sm-12\':true,\'school-district-div\':true,\'active\':visited}">'+
						'<div>'+
							'<div class="col-sm-2 all-col school-district-img">'+
								'<a target="_blank" href="javascript:" @click="clickHouse()"><img :src="house.house_img"/></a>'+
							'</div>'+
							'<div class="col-sm-2 all-col all-f">'+
								'<a target="_blank" href="javascript:" @click="clickHouse()"><h4 v-html="house.community_name"></h4></a>'+
								'<p>{{house.area_name}}<span v-html="house.house_info_id"></span></p>'+
								'<p class="all-f-x" v-html="house.has_school!=0?\'学区房\':\'\'">学区房</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col all-h">'+
								'<p>{{house.room_count}}-{{house.hall_count}}-{{house.kitchen_count}}-{{house.toilet_count}}</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col all-m">'+
								'<p>{{house.area}}平</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col all-j">'+
								'<p>{{house.price}}元/月</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col">'+
								'<p>{{house.floor}}/{{house.max_floor}}</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col">'+
								'<p v-html="orientation"></p>'+
							'</div>'+
							'<div class="col-sm-1 all-col">'+
								'<p v-html="distance_info">173米</p>'+
							'</div>'+
							'<div class="col-sm-1 all-col">'+
								'<p v-html="create_time"></p>'+
							'</div>'+
							'<div class="col-sm-1 all-col">'+
								'<p v-html="house.maintain_employee_name"></p>'+
							'</div>'+
						'</div>'+
						'<div>'+
							'<div class="col-sm-6 all-col address">'+
								'<div class="col-sm-3 all-col">详细地址：</div>'+
								'<div class="col-sm-8 all-col" v-html="address">深圳市龙岗区布吉南湾街道布岚路22号</div>'+
							'</div>'+
							'<div class="col-sm-6 all-col address">'+
								'<div class="col-sm-3 all-col">距离地铁详情：</div>'+
								'<div class="col-sm-8 all-col" v-if="house.stations.length>0" v-html="station_info">距离4号龙岗线明乐站173米</div>'+
							'</div>'+
						'</div>'+
					'</div>',
		created:function() {
			if(!(this.house.orientation instanceof Array)) {
				if(this.house.orientation) {
					this.house.orientation = this.house.orientation.split("|");
				} else {
					this.house.orientation = [];
				}
			}
			
			if(!this.house.sorted_station) {
				function sortStation(a,b) {
					if(a.distance < b.distance) {
						return 1;
					}
					return -1;
				}
				
				this.house.stations.sort(sortStation);
				this.house.sorted_station = true;
			}
		},
		mounted:function() {
		},
		computed:{
			visited:function() {
				if(this.visited_houses.indexOf(this.house.house_info_id) >= 0) {
					return true;
				} else {
					return false;
				}
			},
			station_info:function() {
				if(this.house.stations.length > 0) {
					s = this.house.stations[0];
					return '距离'+s.subway_name+s.station_name+s.distance+'米';
				}
				return '';
			},
			distance_info:function() {
				if(this.house.stations.length > 0) {
					s = this.house.stations[0];
					return s.distance+'米';
				}
				return '';
			},
			orientation:function() {
				var o = [];
				for(var i = 0; i < this.house.orientation.length; i++) {
					if(this.house.orientation[i] == '_e') {
						o.push('东');
					} else if(this.house.orientation[i] == 'es') {
						o.push('东南');
					} else if(this.house.orientation[i] == '_n') {
						o.push('北');
					} else if(this.house.orientation[i] == 'en') {
						o.push('东北');
					} else if(this.house.orientation[i] == '_s') {
						o.push('南');
					} else if(this.house.orientation[i] == '_w') {
						o.push('西');
					} else if(this.house.orientation[i] == 'wn') {
						o.push('西北');
					} else if(this.house.orientation[i] == 'ws') {
						o.push('西南');
					}
				}
				return o.join(",");
			},
			address:function() {
				return this.house.area_name+this.house.ta_name+this.house.community_name;
			},
			create_time:function() {
				var timestamp = new Date().getTime()/1000;
				if((timestamp - this.house.create_time) < 3600) {
					return Math.floor((timestamp - this.house.create_time)/60)+'分钟前';
				} else if((timestamp - this.house.create_time) < 3600*24) {
					return Math.floor((timestamp - this.house.create_time)/3600)+'小时前';
				} else {
					return Math.floor((timestamp - this.house.create_time)/86400)+'天前';
				}
			}
		},
		methods:{
			clickHouse:function() {
				location.href = 'houseinfo/house_info_detail_page?house_info_id='+this.house.house_info_id;
				if(!this.visited) {
					visitedHouses.push(this.house.house_info_id);
					var date = new Date();
					date.setTime(date.getTime()+3600*12000);
					$.cookie("visited_houses", JSON.stringify(visitedHouses), {expires:date});
				}
			}
		}
	});
	
	
	var schoolHouses = Vue.component('school-houses-item', {
		props:['school'],
		template:	'<div @click="showHouses()" style="cursor:pointer">'+
						'<div class="col-sm-12 school-district-div">'+
							'<div class="col-sm-2 school-district-img">'+
								'<img src="../../../static/img/fang1.png"/>'+
							'</div>'+
							'<div class="col-sm-5 school-district-d">'+
								'<h4 v-html="school.name"></h4>'+
								'<p v-html="school.position"></p>'+
								'<p>{{nature_str}}/{{upgrade_method_str}}/{{num_limit_str}}</p>'+
							'</div>'+
							'<div class="col-sm-3 school-district-j">'+
								'<h4 v-if="school.houses.length>0">{{min_price}}万<spam>起</spam></h4>'+
								'<p v-if="school.houses.length>0">{{min_area_price}}元/平 - {{max_area_price}}元/平</p>'+
							'</div>'+
							'<div class="col-sm-2 school-district-y">'+
								'<h4>{{school.houses.length}}套</h4>'+
								'<p>在售房源</p>'+
							'</div>'+
						'</div>'+
					'</div>',
		created:function() {
		},
		mounted:function() {
		},
		computed:{
			nature_str:function(){
				if(this.school.nature <= 0) {
					return '';
				}
				var natures = ['公立','私立','国际'];
				return natures[this.school.nature-1];
			},
			num_limit_str:function() {
				if(this.school.num_limit <= 0) {
					return '';
				}
				var num_limits = ['三年一名额','二年一名额','九年一名额','十二年一名额','五年一名额','六年一名额','无限制'];
				return num_limits[this.school.num_limit-1];
			},
			upgrade_method_str:function() {
				if(this.upgrade_method <= 0) {
					return '';
				}
				
				var upgrade_methods = ['特长生','推优','九年一贯制','对口直升','子弟学校','自主招生','大学区','十二年一贯'];
				return upgrade_methods[this.school.upgrade_method-1];
			},
			min_price:function() {
				var min = this.school.houses[0].price;
				for(var i = 1; i < this.school.houses.length; i++) {
					if(this.school.houses[i].price < min) {
						min = this.school.houses[i].price;
					}
				}
				return min;
			},
			min_area_price:function() {
				var min = this.school.houses[0].price/this.school.houses[0].area;
				for(var i = 1; i < this.school.houses.length; i++) {
					var a = this.school.houses[i].price/this.school.houses[i].area;
					if(a < min) {
						min = a*10000;
					}
				}
				return min;
			},
			max_area_price:function() {
				var max = this.school.houses[0].price/this.school.houses[0].area;
				for(var i = 1; i < this.school.houses.length; i++) {
					var a = this.school.houses[i].price/this.school.houses[i].area;
					if(a > max) {
						max = a*10000;
					}
				}
				return max;
			}
		},
		methods:{
			showHouses:function() {
				this.$emit('show_school_houses',this.school);
			}
		}
	});
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				show_all_search:true,
				visited_houses:visitedHouses,
				all_search:{
					community_name:'',//小区名称
					build_block:'',//楼栋
					house_info_id:'',//房源编号
					maintain_name:'',//维护人姓名
					range:'',
					area_id:'',
					min_price:'',
					max_price:'',
					area_min:'',
					area_max:'',
					room_count:'',
					room_min:'',
					room_max:'',
					floor_type:'',
					floor_min:'',
					floor_max:'',
					level:'',
					real_check:'',
					delegate_type:'',
					has_key:'',
					my_role:'',
					house_state:'',
					building_type:'',
					houseage_type:'',
					cert_full:'',
					orientation:[],
					invalid:'',
					info_complete:'',
					
					order_name:'update_time',
					order_type:'desc',
					
					pi:1,
					pc:12
				},
				all_page_changed:false,
				all_total_count:0,
				all_page_count:0,

				all_community_name:'',
				all_build_block:'',
				all_house_info_id:'',
				all_maintain_name:'',

				all_price_min:'',
				all_price_max:'',
				all_area_min:'',
				all_area_max:'',
				all_room_min:'',
				all_room_max:'',
				all_floor_min:'',
				all_floor_max:'',
				all_page_houses:{},
				
				//聚焦专题
				show_focus_search:true,
				focus_search:{
					load:false,
					community_name:'',//小区名称
					build_block:'',//楼栋
					house_info_id:'',//房源编号
					maintain_name:'',//维护人姓名
					range:'',
					area_id:'',
					min_price:'',
					max_price:'',
					area_min:'',
					area_max:'',
					room_count:'',
					room_min:'',
					room_max:'',
					floor_type:'',
					floor_min:'',
					floor_max:'',
					level:'',
					real_check:'',
					delegate_type:'',
					has_key:'',
					my_role:'',
					house_state:'',
					building_type:'',
					houseage_type:'',
					cert_full:'',
					orientation:[],
					invalid:'',
					info_complete:'',
					
					order_name:'update_time',
					order_type:'desc',
					
					pi:1,
					pc:12
				},
				focus_page_changed:false,
				focus_total_count:0,
				focus_page_count:0,

				focus_price_min:'',
				focus_price_max:'',
				focus_area_min:'',
				focus_area_max:'',
				focus_room_min:'',
				focus_room_max:'',
				focus_floor_min:'',
				focus_floor_max:'',
				focus_page_houses:{},
				
				focus_community_name:'',
				focus_build_block:'',
				focus_house_info_id:'',
				focus_maintain_name:'',
				
				
				subway_search:{
					load:false,
					subway_id:'',
					distance:'',
					min_price:'',
					max_price:'',
					area_min:'',
					area_max:'',
					room_count:'',
					room_min:'',
					room_max:'',
					orientation:[],
					floor_min:'',
					floor_max:'',
					floor_type:'',
					level:'',
					real_check:'',
					delegate_type:'',
					has_key:'',
					my_role:'',
					house_state:'',
					building_type:'',
					houseage_type:'',
					cert_full:'',
					invalid:'',
					info_complete:'',
					
					order_name:'update_time',
					order_type:'desc',
					
					pi:1,
					pc:12
				},
				subway_page_changed:false,
				subway_total_count:0,
				subway_page_count:0,
				subway_price_min:'',
				subway_price_max:'',
				subway_area_min:'',
				subway_area_max:'',
				subway_room_min:'',
				subway_room_max:'',
				subway_floor_min:'',
				subway_floor_max:'',
				subway_page_houses:{},
				
				
				school_search:{
					load:false,
					school_name:'',
					area_id:'',
					nature:'',
					upgrade_method:'',
					num_limit:'',
					
					pi:1,
					pc:12,
				},
				show_school_houses:false,
				school_name:'',
				school_page_changed:false,
				school_page_schools:{},
				school_page_count:0,
				school_total_count:0,
				curr_school:{},
				
				subways:<?=json_encode($subways)?>,
				employee:<?=json_encode($employee)?>,
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				house_infoes:<?=json_encode($house_infoes)?>,
			},
			created:function() {
				var that = this;
				API.invokeModuleCall(g_host_url, 'houseinfo', 'queryAllRentHouses', this.all_search, function(json) {
					that.all_total_count = json.total_count;
					that.all_page_count = json.page_count;
					that.all_page_houses[that.all_search.pi+''] = json.houses;
					that.$forceUpdate();
				});
			},
			computed:{
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				show_focus_search:function(val) {
					$("#show_focus_search").slideToggle();
				},
				show_all_search:function(val) {
					$("#all_search_option").slideToggle();
				},
				all_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.all_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.all_page_houses[that.all_search.pi]) == "undefined") {
								console.log("load1:"+that.all_search.pi);
								API.invokeModuleCall(g_host_url, 'houseinfo', 'queryAllRentHouses', this.all_search, function(json) {
									that.all_total_count = json.total_count;
									that.all_page_count = json.page_count;
									that.all_page_houses[that.all_search.pi+''] = json.houses;
									that.$forceUpdate();
								});
							}
							this.all_page_changed = false;
						} else {
							this.all_page_houses = {};
							API.invokeModuleCall(g_host_url, 'houseinfo', 'queryAllRentHouses', this.all_search, function(json) {
								that.all_total_count = json.total_count;
								that.all_page_count = json.page_count;
								that.all_page_houses[that.all_search.pi+''] = json.houses;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				},
				focus_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.focus_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.focus_page_houses[that.focus_search.pi]) == "undefined") {
								console.log("load1:"+that.focus_search.pi);
								API.invokeModuleCall(g_host_url, 'houseinfo', 'queryFocusRentHouses', this.focus_search, function(json) {
									that.focus_total_count = json.total_count;
									that.focus_page_count = json.page_count;
									that.focus_page_houses[that.focus_search.pi+''] = json.houses;
									that.$forceUpdate();
								});
							}
							this.focus_page_changed = false;
						} else {
							this.focus_page_houses = {};
							API.invokeModuleCall(g_host_url, 'houseinfo', 'queryFocusRentHouses', this.focus_search, function(json) {
								that.focus_total_count = json.total_count;
								that.focus_page_count = json.page_count;
								that.focus_page_houses[that.focus_search.pi+''] = json.houses;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				},
				subway_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.subway_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.subway_page_houses[that.subway_search.pi]) == "undefined") {
								console.log("load1:"+that.subway_search.pi);
								API.invokeModuleCall(g_host_url, 'houseinfo', 'querySubwayRentHouses', this.subway_search, function(json) {
									that.subway_total_count = json.total_count;
									that.subway_page_count = json.page_count;
									that.subway_page_houses[that.subway_search.pi+''] = json.houses;
									that.$forceUpdate();
								});
							}
							this.subway_page_changed = false;
						} else {
							this.subway_page_houses = {};
							API.invokeModuleCall(g_host_url, 'houseinfo', 'querySubwayRentHouses', this.subway_search, function(json) {
								that.subway_total_count = json.total_count;
								that.subway_page_count = json.page_count;
								that.subway_page_houses[that.subway_search.pi+''] = json.houses;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				},
				school_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.school_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.school_page_schools[that.school_search.pi]) == "undefined") {
								console.log("load1:"+that.school_search.pi);
								API.invokeModuleCall(g_host_url, 'houseinfo', 'querySchoolRentHouses', this.school_search, function(json) {
									for(var i = 0; i < json.sch_coms.length; i++) {
										json.sch_coms[i].houses = [];
										for(var j = 0; j < json.houses.length; j++) {
											if(json.houses[j].community_id == json.sch_coms[i].community_id) {
												json.sch_coms[i].houses.push(json.houses[j]);
											}
										}
									}
									
									
									for(var i = 0; i < json.schools.length; i++) {
										json.schools[i].communities = [];
										for(var j = 0; j < json.sch_coms.length; j++) {
											if(json.sch_coms[j].sc_id == json.schools[i].sc_id) {
												json.schools[i].communities.push(json.sch_coms[j]);
											}
										}
									}
									
									for(var i = 0; i < json.schools.length; i++) {
										json.schools[i].houses = [];
										for(var j = 0;j < json.schools[i].communities.length; j++) {
											json.schools[i].houses = json.schools[i].houses.concat(json.schools[i].communities[j].houses);
										}
									}
									
									that.school_total_count = json.total_count;
									that.school_page_count = json.page_count;
									that.school_page_schools[that.school_search.pi+''] = json.schools;
									that.$forceUpdate();
								});
							}
							this.school_page_changed = false;
						} else {
							this.school_page_schools = {};
							API.invokeModuleCall(g_host_url, 'houseinfo', 'querySchoolRentHouses', this.school_search, function(json) {
								for(var i = 0; i < json.sch_coms.length; i++) {
									json.sch_coms[i].houses = [];
									for(var j = 0; j < json.houses.length; j++) {
										if(json.houses[j].community_id == json.sch_coms[i].community_id) {
											json.sch_coms[i].houses.push(json.houses[j]);
										}
									}
								}
								
								
								for(var i = 0; i < json.schools.length; i++) {
									json.schools[i].communities = [];
									for(var j = 0; j < json.sch_coms.length; j++) {
										if(json.sch_coms[j].sc_id == json.schools[i].sc_id) {
											json.schools[i].communities.push(json.sch_coms[j]);
										}
									}
								}
								
								for(var i = 0; i < json.schools.length; i++) {
									json.schools[i].houses = [];
									for(var j = 0;j < json.schools[i].communities.length; j++) {
										json.schools[i].houses = json.schools[i].houses.concat(json.schools[i].communities[j].houses);
									}
								}
								
								
								that.school_total_count = json.total_count;
								that.school_page_count = json.page_count;
								that.school_page_schools[that.school_search.pi+''] = json.schools;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				}
			},
			methods:{
				setSubwaySearchOrder:function(v) {
					if(this.subway_search.order_name != v) {
						this.subway_search.order_name = v;
						this.subway_search.order_type = 'asc';
					} else {
						if(this.subway_search.order_type == 'desc') {
							this.subway_search.order_type = 'asc';
						} else {
							this.subway_search.order_type = 'desc';
						}
					}
				},
				setFocusSearchOrder:function(v) {
					if(this.focus_search.order_name != v) {
						this.focus_search.order_name = v;
						this.focus_search.order_type = 'asc';
					} else {
						if(this.focus_search.order_type == 'desc') {
							this.focus_search.order_type = 'asc';
						} else {
							this.focus_search.order_type = 'desc';
						}
					}
				},
				setAllSearchOrder:function(v) {
					if(this.all_search.order_name != v) {
						this.all_search.order_name = v;
						this.all_search.order_type = 'asc';
					} else {
						if(this.all_search.order_type == 'desc') {
							this.all_search.order_type = 'asc';
						} else {
							this.all_search.order_type = 'desc';
						}
					}
				},
				showSchoolHouses:function(school) {
					this.show_school_houses = true;
					this.curr_school = school;
				}
			}
		})
	});
</script>
</html>