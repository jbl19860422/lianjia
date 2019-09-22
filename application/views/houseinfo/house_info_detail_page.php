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
	<link href="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/css/availability.css?v=3" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<!--<link rel="stylesheet" href="/resources/demos/style.css">-->
	
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=3"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="static/js/moxie.js?v=2"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.2/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	<style>
		.more-item {
			color:#fff;padding-top:5px;padding-bottom:5px;;padding-left:5px;padding-bottom:5px;display:block;
			text-decoration:none;
		}
		
		.form-horizontal .form-group>label {
			text-align:left;
		}
		
		.description-x {
			cursor:pointer;
		}
		
		
	</style>
	
	<style>
		.more-op div{
			display:none;
		}
		
		.more-op:hover div {
			display:block;
		}
		.more-item {
			color:#fff;padding-top:5px;padding-bottom:5px;;padding-left:5px;padding-bottom:5px;display:block;
			text-decoration:none;
		}
		
		.dim-item {
			margin-bottom:10px;
			border:1px solid #4cae4c;
			color:#4cae4c;
			border-radius: 4px;
			cursor:pointer;
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 10px;
			font-size: 14px;
			font-weight: normal;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			background-image: none;
			border-radius: 4px;
		}
		
		.dim-item.sel {
			color: #fff;
			background-color: #5cb85c;
			border-color: #4cae4c;
		}
		
		.del-btn {
			color: #4cae4c;
			float:right;
			cursor:pointer;
		}
		
		.follow-up-img {
			cursor:pointer;
		}

		.green {
			color:green;
		}
	</style>
	
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
			<li :class="{active:house_info.entrust_type==1}"><a href="houseinfo/house_info_list_page">买卖{{house_info.type}}</a></li>
			<li :class="{active:house_info.entrust_type==2}"><a href="houseinfo/house_info_rent_list_page">租赁</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源-房源详情
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p" style="color:#000;font-size:1.8rem;font-weight:bolder;" v-html="community?community.name:''"></p>
				<span v-html="'编号：['+house_info.house_info_id+']'" style="color:#aaa;margin-left:10px;font-size:1.5rem;"></span>
				<div class="panel-right">
					<div class="panel-right-div" style="cursor:pointer" @click="setFollow()"><i :class="{'fa':true,'fa-star':follow, 'fa-star-o':!follow}"></i><span style="font-size:1.3rem" v-html="follow?'已关注':'未关注'"></span></div>
					<div class="panel-right-er">
						<img src="../../../static/img/er.jpg" />
					</div>
					<div class="panel-right-d-er">
						<img src="../../../static/img/er.jpg" />
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-sm-3 availability-img">
					<img :src="house_info.house_img" style="cursor:pointer" id="ID_houseImg"></img>
				</div>
				<div class="col-sm-8">
					<div class="form-group"style="accelerator:60px;">
						<div class="col-sm-5">
							<div class="price"><p style="width:150px">{{house_info.price}}</p><div>
								<p>万</p>
								<i style="font-size:" :class="{green:house_info.price_state==2, fa:true,'fa-arrow-circle-down':house_info.price_state==2,'fa-arrow-circle-up':house_info.price_state==1}"></i>
							</div>
							</div>	
						</div>
						<div class="col-sm-6 price-d">
							<div style="cursor:pointer" @click="show_dlg_edit_price=true">调整房源售价</div>
							<div>单价：<span>{{parseInt(house_info.price*10000/house_info.area)}}元/平米</span></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 availability-f">
							<div class="fl-l huxing">
								<div>
									<b>{{house_info.room_count}}-{{house_info.hall_count}}-{{house_info.kitchen_count}}-{{house_info.toilet_count}}</b>
									<p>户型</p>
								</div>
							</div>
							<div class="fl-l area">
								<div>
									<b>{{house_info.area}}<span v-if="house_info.inner_area">(套内{{house_info.inner_area}})</span>m2</b>
									<p>面积</p>
								</div>
							</div>
							<div class="fl-l orientation">
								<div>
									<b v-html="orientation"></b>
									<p>朝向</p>
								</div>
							</div>
							<div class="fl-l floor">
								<div>
									<b>{{house.floor}}（{{house.floor}}/{{building_block.max_floor}}）</b>
									<p>楼层</p>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 availability-x">
							<div class="col-sm-5">挂牌时间：{{listing_dur}}天（{{listing_date}}）</div>
							<div class="col-sm-4">历史委托记录：{{house_infoes.length-1}}次</div>
							<div class="col-sm-3">房源等级：{{house_info.level}}级</div>
						</div>
						<div class="col-sm-12 availability-x">
							<div class="col-sm-5">委托来源：{{entrust_src}}</div>
							<div class="col-sm-4">聚焦信息：暂无</div>
						</div>
						<div class="col-sm-12 availability-x">
							<div class="col-sm-5" v-html="house_info.key_number?'钥匙信息：'+house_info.key_number:'钥匙信息：暂无'">钥匙信息：暂无</div>
							<div class="col-sm-4">委托信息：暂无</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-5 availability-c">
							<div class="fl-l">
								<span class="availability-span-t" data-container="body" data-toggle="popover" data-placement="top"
									:data-content="contact_info">查看电话</span>
								<span>|</span>
								<span class="availability-span-d"data-container="body" data-toggle="popover" data-placement="top"
									:data-content="house_address">查看地址</span>
							</div>
						</div>
						<div class="col-sm-7 availability-c">
							<div class="fl-l availability-c-div" style="position:relative">
								<span><a style="color:inherit" href="javascript:" @click="show_add_follow_panel=true;if(location.hash=='#add_follow_panel') location.hash='';location.hash='add_follow_panel'">录入跟进</a></span>
								<span>|</span>
								<span @click="jumpMaintain()">维护信息</span>
								<span>|</span>
								<span @click="jumpComment()">房源点评</span>
								<span>|</span>
								<span style="width:40px;position:relative" class="more-op"><span style="color:#fff;width:40px;" @click="onShowMore()">更多</span>
									<div style="position:absolute;background:#36a765;left:-40px;width:80px;z-index:1000;top:36px;">
										<a class="more-item" :href="'houseinfo/house_info_edit_page?house_info_id='+house_info.house_info_id">修改</a>
										<a class="more-item" @click="showEditLevel();show_more=false;">修改等级</a>
										<a class="more-item" @click="applyHouseFocus()">申请聚焦</a>
										<a class="more-item" @click="applyInvalidHouse();show_more=false;">申请无效</a>
										<a class="more-item">申请特殊</a>
										<a class="more-item" @click="if(employee.employee_id==house_info.maintain_employee_id) show_dlg_recomment_house=true; else showMsg('只有维护人才可以推荐')">推荐房源</a>
										<a class="more-item">操作日志</a>
										<a class="more-item">修改日志</a>
									</div>
								</span>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</div>
		
		
		<ul class="nav nav-pills nav-justified availability-ul" role="tablist">
	        <li :class="{active:curr_tab=='description'}"><a href="javascript:" @click="location.hash='description';curr_tab='description'">房源描述</a></li>
	        <li :class="{active:curr_tab=='information'}"><a href="javascript:" @click="location.hash='information';curr_tab='information'">实勘信息</a></li>
	        <li :class="{active:curr_tab=='follow-up'}"><a href="javascript:" @click="location.hash='follow-up';curr_tab='follow-up'">跟进</a></li>
	        <li :class="{active:curr_tab=='look-with'}"><a href="javascript:" @click="location.hash='look-with';curr_tab='look-with'">带看</a></li>
	        <li :class="{active:curr_tab=='similar'}"><a href="javascript:" @click="location.hash='similar';curr_tab='similar'">相似房源</a></li>
	    </ul>
		<div class="tab-content" id="tab_content_b">
			<!----房源描述---->
			<div role="tabpanel" class="tab-pane active" id="description">
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
						<p class="panel-p">基础信息</p>
						<i :class="{fa:true,'fa-angle-double-down':!show_base_info,'fa-angle-double-up':show_base_info}" @click="show_base_info=!show_base_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
					</div>
					<div class="panel-body" id="show_base_info">
						<div class="form-group">
							<label class="col-sm-12">小区信息</label>
							<div class="col-sm-12">
								<div class="col-sm-3">小区名称<span class="information-s" v-html="community.name"></span></div>
								<div class="col-sm-3">所在城区：<span class="information-s" v-html="area?area.name:''"></span></div>
								<div class="col-sm-3">所在商圈：<span class="information-s" v-html="trade_area?trade_area.name:''"></span></div>
								<div class="col-sm-3">物业费：<span class="information-s" v-html="community.pm_fee"></span></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12">建筑信息</label>
							<ul class="col-sm-12">
								<li class="col-sm-3">交易权属：<span class="information-s" v-html="community.transaction_ownership"></span></li>
								<li class="col-sm-3">建筑结构：<span class="information-s"></span></li>
								<li class="col-sm-3">产权年限：<span class="information-s" v-html="community.property_year"></span></li>
								<li class="col-sm-3">凶宅信息：<span class="information-s"></span></li>
								<li class="col-sm-3">房屋用途：<span class="information-s" v-html="getUsage(community.usage)"></span></li>
								<li class="col-sm-3">建筑类型：<span class="information-s" v-html="getBuildingType(community.building_type)">塔板结合</span></li>
								<li class="col-sm-3">嫌恶设施：<span class="information-s" v-html="community.bad_thing"></span></li>
								<li class="col-sm-3">梯户比例：<span class="information-s" v-html="community.lift_user_rate">2梯6户</span></li>
								<li class="col-sm-3">建筑时间：<span class="information-s" v-html="build_time"></span></li>
							</ul>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12">生活信息</label>
							<ul class="col-sm-12">
								<li class="col-sm-3">供暖类型：<span class="information-s" v-html="community.heat_type"></span></li>
								<li class="col-sm-3">用电类型：<span class="information-s" v-html="community.electro_type"></span></li>
								<li class="col-sm-3">车位配比：<span class="information-s" v-html="community.car_rate">1:0.55</span></li>
								<li class="col-sm-3">停车服务费：<span class="information-s" v-html="community.car_manager_fee">250(元/月)</span></li>
								<li class="col-sm-3">供暖费用：<span class="information-s" v-html="community.heat_fee"></span></li>
								<li class="col-sm-3">用水类型：<span class="information-s" v-html="community.water_use_type"></span></li>
								<li class="col-sm-3">地上车位数：<span class="information-s" v-html="community.ground_car_park_count">30</span></li>
								<li class="col-sm-3">是否有电梯：<span class="information-s" v-html="community.has_lift?'有':'无'">有</span></li>
								<li class="col-sm-3">是否有燃气：<span class="information-s" v-html="community.has_gas?'有':'无'">有</span></li>
								<li class="col-sm-3">燃气费：<span class="information-s" v-html="community.gas_fee">3.5</span></li>
								<li class="col-sm-3">地下车位数：<span class="information-s" v-html="community.underground_car_park_count">405</span></li>
								<li class="col-sm-3">是否有热水：<span class="information-s" v-html="community.has_hot_water?'有':'无'">无</span></li>
								<li class="col-sm-3">热水费：<span class="information-s" v-html="community.hot_water_fee">0.0</span></li>
								<li class="col-sm-3">学区信息：<span class="information-s" v-html="community.school_info"></span></li>
								<li class="col-sm-3">是否有中水：<span class="information-s" v-html="community.has_warm_water?'有':'无'">无</span></li>
								<li class="col-sm-3">中水费：<span class="information-s" v-html="community.warm_water_fee">0.0</span></li>
								<li class="col-sm-3">开发商：<span class="information-s" v-html="community.developer"></span></li>
								<li class="col-sm-3">物业：<span class="information-s" v-html="community.prop_company"></span></li>
								<li class="col-sm-3">容积率：<span class="information-s" v-html="community.plot_ratio"></span></li>
								<li class="col-sm-3">绿化率：<span class="information-s" v-html="community.green_rate"></span></li>
							</ul>
						</div>
					</div>
					
					
				</div>

				<div class="panel panel-default" id="ID_maintain_info">
					<div class="panel-heading panel-title">
						<p class="panel-p">维护信息</p>
						<i :class="{fa:true,'fa-angle-double-down':!show_maintain_info,'fa-angle-double-up':show_maintain_info}" @click="show_maintain_info=!show_maintain_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
						<div class="panel-r" @click="edit_t()" v-show = "!edit_maintaininfo" v-if="employee.employee_id==house_info.maintain_employee_id">
							<i class="fa fa-pencil-square-o"></i>编辑
						</div>
						<div class="panel-r" v-show = "edit_maintaininfo" @click="edit_t()">取消</div>
					</div>
					<div class="panel-body" id="maintain_info">
						<div class="form-group">
							<label class="col-sm-12">业主相关</label>
							<ul class="col-sm-12">
								<li class="col-sm-6">售房原因：<span class="information-s" v-html="sold_reason">换房</span></li>
								<li class="col-sm-6">预计出售周期：<span class="information-s" v-html="selling_cycle">一个月</span></li>
								<li class="col-sm-6">婚姻状况：<span class="information-s" v-html="marry_state">已婚  有小孩</span></li>
								<li class="col-sm-6">业主交房时间：<span class="information-s" v-html="house_info.launch_time"></span></li>
								<li class="col-sm-6">是否共有：<span class="information-s" v-html="house_info.is_shared?'是':'否'"></span></li>
								<li class="col-sm-6">联系人是否为业主本人：<span class="information-s" v-html="house_info.is_contact_self?'是':'否'">是</span></li>
								<li class="col-sm-6">是否唯一：<span class="information-s" v-html="house_info.is_uniq?'是':'否'">是</span></li>
								<li class="col-sm-6">户口是否可迁出：<span class="information-s" v-html="house_info.residence?'有户口，不可迁出':'有户口，可迁出'"></span></li>
							</ul>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12">房屋相关</label>
							<ul class="col-sm-12">
								<li class="col-sm-6">看房时间：<span class="information-s" v-html="openhome_time"></span></li>
								<li class="col-sm-6">装修状况：<span class="information-s" v-html="decoration_state">精装</span></li>
								<li class="col-sm-6">房屋现状：<span class="information-s" v-html="getHouseState(house_info.house_state)"></span></li>
								<li class="col-sm-6">装修成本：<span class="information-s" v-html="house_info.decoration_money+'万'"></span></li>
								<li class="col-sm-6">是否随时可签：<span class="information-s" v-html="house_info.can_sign_any_time?'是':'否'">否</span></li>
								<li class="col-sm-6">装修时间：<span class="information-s" v-html="house_info.decoration_time"></span></li>
								<li class="col-sm-6">是否有车位：<span class="information-s" v-html="house_info.has_car_pos?'是':'否'">是</span></li>
								<li class="col-sm-6">赠送面积：<span class="information-s" v-html="house_info.gift_area+'㎡'"></span></li>
								<li class="col-sm-6">是否有学区名额：<span class="information-s" v-html="house_info.has_school_quota?'是':'否'"></span></li>
								<li class="col-sm-6">房屋格局是否有变动：<span class="information-s" v-html="house_info.house_pattern_changed?'是':'否'"></span></li>
								<li class="col-sm-6">名额可用时间：<span class="information-s" v-html="house_info.school_quota_time"></span></li>
							</ul>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12">购买相关</label>
							<ul class="col-sm-12">
								<li class="col-sm-6">是否有抵押：<span class="information-s" v-html="house_info.has_mortgage?'有抵押':'无抵押'">无抵押</span></li>
								<li class="col-sm-6">付款需求：<span class="information-s" v-html="house_info.pay_require"></span></li>
								<li class="col-sm-6">过户指导价：<span class="information-s" v-html="house_info.transfer_guidance_price"></span></li>
								<li class="col-sm-6">是否限购：<span class="information-s" v-html="house_info.limit_buy?'是':'否'"></span></li>
								<li class="col-sm-6">原网	签价：<span class="information-s" v-html="house_info.net_sign_price">否</span></li>
								<li class="col-sm-6">是否提供原始税票：<span class="information-s" v-html="house_info.has_tax_ticket?'是':'否'"></span></li>
								
							</ul>
						</div>
						
						<div class="form-group">
							<div class="col-sm-12"style="border:1px solid #ccc"></div>
							<div class="col-sm-12">备注：<span v-html="house_info.maintain_mark"></span></div>
						</div>
					</div>
					<div class="panel-body" v-show = "edit_maintaininfo">
						<form class="form-horizontal">
							<fieldset>
								<legend>业主相关</legend>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">售房原因</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.sold_reason" style="display:inline;width:auto">
								    		<option v-for="(reason,index) in sold_reasons" :value="index" v-html="reason.name"></option>
								    	</select>
								    	<span v-if="sold_reasons[house_info_edit.sold_reason].subreasons.length>0||house_info_edit.sold_reason==3">-</span>
								    	<select class="form-control" v-model="house_info_edit.sold_reason1" v-if="sold_reasons[house_info_edit.sold_reason].subreasons.length>0&&house_info_edit.sold_reason!=3" style="display:inline;width:auto">
								    		<option v-for="(r,ind) in sold_reasons[house_info_edit.sold_reason].subreasons" :value="ind" v-html="r"></option>
								    	</select>
								    	<input type="text" class="form-control" v-if="house_info_edit.sold_reason==3" v-model="house_info_edit.sold_reason2" style="display:inline;width:auto"></input>
								    </div>
									
									<label class="col-sm-2 edit_label text-right">预计出售周期</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.selling_cycle" style="display:inline;width:auto">
								    		<option value="0">一周内</option>
								    		<option value="1">一个月内</option>
								    		<option value="2">三个月内</option>
								    	</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">业主交房时间</label>
								    <div class="col-sm-4">
								    	<input class="form-control" style="display:inline;width:auto" placeholder="选择或者输入一个日期：yyyy-MM-dd" id="ID_launchTime"></input>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">是否共有</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.is_shared">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								    <label class="col-sm-2 edit_label text-right">是否唯一</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.is_uniq">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">联系人是否为业主本人</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.is_contact_self">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">户口情况</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.residence">
										  	<option value="1">有户口，可迁出</option>
										  	<option value="0">有户口，不可迁出</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">婚姻状况</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.marry_state">
										  	<option value="1">已婚</option>
										  	<option value="0">未婚</option>
										</select>
								    </div>
								    
								    <div class="col-sm-4">
								    	<input type="text" class="form-control" placeholder="" v-model="house_info_edit.child_info">
								    </div>
								</div>
								
								<legend>房屋相关</legend>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">房屋现状</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.house_state">
										  	<option value="0">自住</option>
										  	<option value="1">出租</option>
											<option value="2">空置</option>
											<option value="3">经营中</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">看房时间</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.openhome_time">
											<option value="1">下班后</option>
											<option value="2">提前预约随时可看</option>
											<option value="3">只能周末看</option>
											<option value="4">有租户需要预约</option>
										</select>
								    </div>
								    <label class="col-sm-2 edit_label text-right">是否随时可签</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.can_sign_any_time">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">是否有学区名额</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.has_school_quota">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								    <label class="col-sm-2 edit_label text-right" v-show="house_info_edit.has_school_quota==1">名额可用时间</label>
								    <div class="col-sm-4" v-show="house_info_edit.has_school_quota==1">
								    	<input class="form-control" style="display:inline;width:auto" placeholder="选择或者输入一个日期：yyyy-MM-dd" id="ID_school_quota_time"></input>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">装修状况</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.decoration_state">
										  	<option value="0">毛胚</option>
										  	<option value="1">清水简装</option>
											<option value="2">精装</option>
											<option value="3">豪装</option>
											<option value="4">需重装</option>
										</select>
								    </div>
								    <label class="col-sm-2 edit_label text-right">装修成本</label>
								    <div class="col-sm-4">
								    	<input class="form-control" style="display:inline;width:auto" v-model="house_info_edit.decoration_money"></input>
										<span>万</span>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">装修时间</label>
								    <div class="col-sm-4">
								    	<input class="form-control" style="display:inline;width:auto" placeholder="选择或者输入一个日期：yyyy-MM-dd" id="ID_decoration_time"></input>
								    </div>
								    <label class="col-sm-2 edit_label text-right">赠送面积</label>
								    <div class="col-sm-4">
								    	<input class="form-control" style="display:inline;width:auto" v-model="house_info_edit.gift_area"></input>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">是否有车位</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.has_car_pos">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">房屋格局是否有变动</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.house_pattern_changed">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<legend>购买相关</legend>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">是否限购</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.limit_buy">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								    <label class="col-sm-2 edit_label text-right">付款需求</label>
								    <div class="col-sm-4">
								    	<input type="text" class="form-control" placeholder="" v-model="house_info_edit.pay_require">
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">是否有抵押</label>
								    <div class="col-sm-4">
								    	<select class="form-control" v-model="house_info_edit.has_mortgage">
										  	<option value="1">有抵押</option>
										  	<option value="0">无抵押</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">过户指导价</label>
								    <div class="col-sm-4">
								    	<input type="tel" class="form-control" placeholder="元/平" v-model="house_info_edit.transfer_guidance_price">
								    </div>
								    <label class="col-sm-2 edit_label text-right">是否提供原始税票</label>
								    <div class="col-sm-4">
								    	<select class="form-control">
										  	<option value="1">是</option>
										  	<option value="0">否</option>
										</select>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">原网签价</label>
								    <div class="col-sm-4">
								    	<input type="tel" class="form-control" placeholder="万" v-model="house_info_edit.net_sign_price">
								    </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 edit_label text-right">备注</label>
								    <div class="col-sm-10">
								    	<textarea name="description" class="form-control" v-model="house_info_edit.maintain_mark"></textarea>
								    </div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-6 text-right">
										<a class="btn edit_btn" @click="closeMaintain()">关闭</a>
									</div>
								    <div class="col-sm-6">
								    	<a class="btn edit_btn" @click="saveMaintainInfo()">保存</a>
								    </div>
								</div>
							</fieldset>
						</form>
					</div>
					
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
						<p class="panel-p">证件信息</p>
						<i :class="{fa:true,'fa-angle-double-down':!show_cert_info,'fa-angle-double-up':show_cert_info}" @click="show_cert_info=!show_cert_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
					</div>
					<div class="panel-body" id="show_cert_info">
						<div class="form-group">
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="if(house_info.has_cert==1) show_dlg_house_cert=true">房产证</label>
								<div class="col-sm-5 description-z" v-if="house_info.has_cert==1">登记日期{{house_info.house_cert.time|formatTime}}，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="house_info.has_cert==1">{{upload_cert_employee.name}}（维护人）-{{upload_cert_employee.team_name}}-{{upload_cert_employee.mobile}}</div>
								<div class="col-sm-5 description-z" v-if="house_info.has_cert==0"></div>
								<div class="col-sm-4 description-r" v-if="house_info.has_cert==0"></div>
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_house_cert=true">修改</div>
							</div>
							
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="if(house_info.has_agent_cert) show_dlg_house_agent_cert=true">书面委托协议</label>
								<div class="col-sm-5 description-z" v-if="house_info.has_agent_cert==1">登记日期{{house_info.agent_cert.time|formatTime}}，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="house_info.has_agent_cert==1">{{upload_agent_cert_employee.name}}（维护人）-{{upload_agent_cert_employee.team_name}}-{{upload_agent_cert_employee.mobile}}</div>
								<div class="col-sm-5 description-z" v-if="house_info.has_agent_cert==0"></div>
								<div class="col-sm-4 description-r" v-if="house_info.has_agent_cert==0"></div>
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_agent_cert=true;">修改</div>
							</div>
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="if(house_info.has_contract) show_dlg_contract=true">原始购房合同</label>
								<div class="col-sm-5 description-z">-</div>
								<div class="col-sm-4 description-r"></div>
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_contract=true">上传</div>
							</div>
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="show_dlg_idpaper=true">业主身份证明</label>
								<div class="col-sm-5 description-z" v-if="house_info.upload_idpaper_employee">已上传，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="house_info.upload_idpaper_employee">{{upload_idpaper_employee.name}}（维护人）-{{upload_idpaper_employee.team_name}}-{{upload_idpaper_employee.mobile}}</div>
								<div class="col-sm-5 description-z" v-if="!house_info.upload_idpaper_employee"></div>
								<div class="col-sm-4 description-r" v-if="!house_info.upload_idpaper_employee"></div>
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_idpaper=true">修改</div>
							</div>
							
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="show_dlg_tax_ticket=true">契税票</label>
								<div class="col-sm-5 description-z" v-if="house_info.deed_tax_ticket">已上传，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="upload_taxticket_employee">{{upload_taxticket_employee.name}}（维护人）-{{upload_taxticket_employee.team_name}}-{{upload_taxticket_employee.mobile}}</div>
								<div class="col-sm-5 description-z" v-if="!house_info.deed_tax_ticket"></div>
								<div class="col-sm-4 description-r" v-if="!upload_taxticket_employee"></div>
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_taxticket=true">上传</div>
							</div>
							
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="show_dlg_veri_report=true">房屋核验报告</label>
								<div class="col-sm-5 description-z" v-if="house_info.veri_report">已上传，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="upload_verireport_employee">{{upload_verireport_employee.name}}（维护人）-{{upload_verireport_employee.team_name}}-{{upload_verireport_employee.mobile}}</div>
								
								<div class="col-sm-5 description-z" v-if="!house_info.veri_report"></div>
								<div class="col-sm-4 description-r" v-if="!upload_verireport_employee"></div>
								
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_veri_report=true">上传</div>
							</div>
							<div class="col-sm-12 follow-up-li">
								<label class="col-sm-2 description-z" style="cursor:pointer" @click="show_dlg_house_number=true">认证房源编号</label>
								<div class="col-sm-5 description-z" v-if="house_info.house_number">已上传，商圈经理审核通过</div>
								<div class="col-sm-4 description-r" v-if="upload_housenumber_employee">{{upload_housenumber_employee.name}}（维护人）-{{upload_housenumber_employee.team_name}}-{{upload_housenumber_employee.mobile}}</div>
								
								<div class="col-sm-5 description-z" v-if="!house_info.house_number"></div>
								<div class="col-sm-4 description-r" v-if="!upload_housenumber_employee"></div>
								
								<div class="col-sm-1 text-center description-x" @click="show_dlg_upload_house_number=true">修改</div>
							</div>
						
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="ID_house_comment">
					<div class="panel-heading panel-title">
						<p class="panel-p">
							房评
						</p>
						<i :class="{fa:true,'fa-angle-double-down':!show_house_comment,'fa-angle-double-up':show_house_comment}" @click="show_house_comment=!show_house_comment" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
						<div class="panel-r" @click="edit_f()" v-show="!edit_comment"  v-if="employee.employee_id==house_info.maintain_employee_id">
							<i class="fa fa-pencil-square-o"></i>编辑
						</div>
						<div class="panel-r"  v-show="edit_comment" @click="edit_f()">取消</div>
					</div>
					<div class="panel-body" id="show_house_comment">
						<form class="form-horizontal" v-show="!edit_comment">
							<div class="form-group">
								<div class="col-sm-12">
									<label class="col-sm-2 comment-label">【房源标题】：</label>
									<div class="col-sm-10" v-html="house_info.comment_title"></div>
								</div>
								<template v-for="comment in house_info.comments">
									<div class="col-sm-12">
										<label class="col-sm-2 comment-label">【{{getCommentName(comment.type)}}】：</label>
										<div class="col-sm-10" v-html="comment.info"></div>
									</div>
								</template>
							</div>
						</form>
						<form class="form-horizontal" v-show="edit_comment">
							<div class="form-group">
								<label class="col-sm-5">1、房源标题<span style="color:#d9d6d3">(15-25个汉字)</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="15~25个汉字" v-model="comment_title_edit">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5">2、请选择你要点评的纬度<span style="color:#d9d6d3">(至少选择3项，最多选择6项)</span></label>
								<div class="col-sm-9">
									<template v-for="comment in comments">
										<span :class="{'dim-item':true,sel:if_sel('selling_point')}" @click="addComment('selling_point')">核心卖点</span>
										<span :class="{'dim-item':true,sel:if_sel('house_type')}" @click="addComment('house_type')">户型介绍</span>
										<span :class="{'dim-item':true,sel:if_sel('decoration')}" @click="addComment('decoration')">装修描述</span>
										<span :class="{'dim-item':true,sel:if_sel('tax')}" @click="addComment('tax')">税费解析</span>
										<span :class="{'dim-item':true,sel:if_sel('ownership')}" @click="addComment('ownership')">权属抵押</span>
										<span :class="{'dim-item':true,sel:if_sel('traffic')}" @click="addComment('traffic')">交通出行</span>
										<span :class="{'dim-item':true,sel:if_sel('education')}" @click="addComment('education')">教育配套</span>
										<span :class="{'dim-item':true,sel:if_sel('peripheral')}" @click="addComment('peripheral')">周边配套</span>
										<span :class="{'dim-item':true,sel:if_sel('community')}" @click="addComment('community')">小区介绍</span>
										<span :class="{'dim-item':true,sel:if_sel('target_users')}" @click="addComment('target_users')">适宜人群</span>
										<span :class="{'dim-item':true,sel:if_sel('house_sale')}" @click="addComment('house_sale')">房售详情</span>
									</template>
								</div>
							</div>
							<template v-for="(c,i) in comments_edit">
								<div class="form-group" v-if="c.type=='selling_point'">
									<label class="col-sm-9">核心卖点<span style="color:#d9d6d3">(必填项)</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='house_type'">
									<label class="col-sm-9">户型介绍<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='decoration'">
									<label class="col-sm-9">装修描述<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='tax'">
									<label class="col-sm-9">税费解析<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='ownership'">
									<label class="col-sm-9">权属抵押<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='traffic'">
									<label class="col-sm-9">交通出行<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								<div class="form-group" v-if="c.type=='education'">
									<label class="col-sm-9">教育配套<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								
								<div class="form-group" v-if="c.type=='peripheral'">
									<label class="col-sm-9">周边配套<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								
								<div class="form-group" v-if="c.type=='community'">
									<label class="col-sm-9">小区介绍<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								
								<div class="form-group" v-if="c.type=='target_users'">
									<label class="col-sm-9">适宜人群<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
								
								<div class="form-group" v-if="c.type=='house_sale'">
									<label class="col-sm-9">房售详情<span class="del-btn" @click="delComment(i)">删除</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
									</div>
								</div>
							</template>
							<div class="form-group">
								<div class="btn btn-primary" style="display:block;width:100px;margin-left:35%;" @click="saveComment()">保存</div>
							</div>
						</form>
					
					</div>
					
				</div>
				
			</div>
			
			<!----实勘信息---->
			<div role="tabpanel" class="tab-pane active" id="information">
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
					<p class="panel-p">实勘信息</p>
					<i :class="{fa:true,'fa-angle-double-down':!show_realcheck_info,'fa-angle-double-up':show_realcheck_info}" @click="show_realcheck_info=!show_realcheck_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
					</div>
					<div class="panel-body" id="show_realcheck_info">
						<div class="form-group">
							<div class="col-sm-12 survey-div">
								<div class="col-sm-5 information-h"></div>
								<label class="col-sm-2 information-label">当前格局</label>
								<div class="col-sm-5 information-h"></div>
							</div>
							
							<div class="" style="text-align:center">
								<img :src="house_info.follow_imgs.structure?house_info.follow_imgs.structure:'../../../static/img/upload_img.png'" class="follow-up-img" @click="uploadHouseImg('structure',0)" style="width:50%"/>
								<!--<img src="../../../static/img/fang.png" class="infor-img"/>-->
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 survey-div">
								<div class="col-sm-5 information-h"></div>
								<label class="col-sm-2 information-label">实勘照片</label>
								<div class="col-sm-5 information-h"></div>
							</div>
							
							<ul class="col-sm-12">
								<li class="col-sm-4" v-for="(room,index) in house_info.room_count">
									<img :src="house_info.follow_imgs.rooms&&house_info.follow_imgs.rooms[index]?house_info.follow_imgs.rooms[index]:'../../../static/img/upload_img.png'" class="follow-up-img follow-up-img1" @click="uploadHouseImg('rooms',index)"/>
									<p class="follow-up-p">室{{index+1}}</p>
								</li>
								<li class="col-sm-4" v-for="(hall,index) in house_info.hall_count">
									<img :src="house_info.follow_imgs.halls&&house_info.follow_imgs.halls[index]?house_info.follow_imgs.halls[index]:'../../../static/img/upload_img.png'" class="follow-up-img follow-up-img1" @click="uploadHouseImg('halls',index)"/>
									<p class="follow-up-p">厅{{index+1}}</p>
								</li>
								<li class="col-sm-4" v-for="(toilet,index) in house_info.toilet_count">
									<img :src="house_info.follow_imgs.toilets&&house_info.follow_imgs.toilets[index]?house_info.follow_imgs.toilets[index]:'../../../static/img/upload_img.png'" class="follow-up-img follow-up-img1" @click="uploadHouseImg('toilets',index)"/>
									<p class="follow-up-p">卫生间{{index+1}}</p>
								</li>
								<li class="col-sm-4" v-for="(kitchen,index) in house_info.kitchen_count">
									<img :src="house_info.follow_imgs.kitchens&&house_info.follow_imgs.kitchens[index]?house_info.follow_imgs.kitchens[index]:'../../../static/img/upload_img.png'" class="follow-up-img follow-up-img1" @click="uploadHouseImg('kitchens',index)"/>
									<p class="follow-up-p">厨房{{index+1}}</p>
								</li>
							</ul>
							<div id="upload_followup_img" style="display:none"></div>
						</div>
						<div class="btn btn-success" v-show="is_upload_flollow_img" style="display:block;margin-left:auto;margin-right:auto;width:100px;clear:both" @click="uploadFollowImg()">上传审核</div>
					</div>
				</div>
			
			</div>
			
			<!----房屋照片信息---->
			<div role="tabpanel" class="tab-pane active" id="follow-up">
				<div class="panel panel-default" id="add_follow_panel">
					<div class="panel-heading panel-title"  v-show="show_add_follow_panel">
						<p class="panel-p">录入跟进</p>
					</div>
					
					<div class="panel-body" id="show_add_follow_panel" v-show="show_add_follow_panel">
						<div class="form-group">
							<form class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-5" style="text-align:left;">跟进信息：<span style="color:#d9d6d3">(信息提示)</span></label>
									<div class="col-sm-9">
										<textarea type="text" class="form-control" placeholder="" v-model="info_add.info"></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="btn btn-primary" style="display:inline-block;width:100px;margin-left:25%;" @click="addFollowInfo()">添加</div>
									<div class="btn btn-warning" style="display:inline-block;width:100px;" @click="show_add_follow_panel=false">取消</div>
								</div>
							</form>
						</div>
					</div>
					<div class="panel-heading panel-title">
						<p class="panel-p">跟进信息</p>
						<i :class="{fa:true,'fa-angle-double-down':!show_followup_info,'fa-angle-double-up':show_followup_info}" @click="show_followup_info=!show_followup_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i>
						<div class="panel-r" @click="show_add_follow_panel=true;">
							<i class="fa fa-plus-square-o"></i>添加
						</div>
					</div>
					<div class="panel-body" id="show_followup_info">
						<ul class="col-sm-12">
							<li class="col-sm-12 follow-up-li" v-for="(followup_info,index) in house_info.followup_infoes">
								<div class="follow-up-div">
									<div class="follow-up-div-p">
										<i class="fa fa-pencil-square-o"></i>
										<p class="follow-up-s" v-html="followup_info.info"></p>
									</div>
									<p class="follow-up-r">{{followup_info.time|formatTime}}<span><span v-html="followup_info.employee.name"></span><span v-if="house_info.maintain_employee_id==followup_info.employee.employee_id">（维护人）</span><span v-html="'-'+followup_info.employee.team_name" v-if="followup_info.employee.team_name"></span>-<span v-html="followup_info.employee.mobile"></span></span></p>
								</div>
								<p class="follow-up-z" style="cursor:pointer" v-html="followup_info.top&&followup_info.top=='true'?'取消置顶':'置顶'" @click="setTop(followup_info,index)"></p>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
					<p class="panel-p">角色人信息</p>
					<i :class="{fa:true,'fa-angle-double-down':!show_role_info,'fa-angle-double-up':show_role_info}" @click="show_role_info=!show_role_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i></div>
					<div class="panel-body" id="show_role_info">
						<ul class="col-sm-12">
							<li class="character" v-if="house_add_employee">
								<dl class="character-dl">
									<dt>
										<img :src="house_add_employee.headimg"/>
										<div class="character-div">录入人</div>
									</dt>
									<dd>
										<h4 v-html="house_add_employee.name"></h4>
										<p v-html="house_add_employee.team_name">星海名城一组</p>
										<p v-html="house_add_employee.mobile">15333389765</p>
									</dd>
								</dl>
							</li>
							<li class="character" v-if="house_maintain_employee">
								<dl class="character-dl">
									<dt>
										<img :src="house_maintain_employee.headimg"/>
										<div class="character-div">维护人</div>
									</dt>
									<dd>
										<h4 v-html="house_maintain_employee.name">李翔</h4>
										<p v-html="house_maintain_employee.team_name">星海名城一组</p>
										<p v-html="house_maintain_employee.mobile">15333389765</p>
									</dd>
								</dl>
							</li>
							
							<li class="character character1" style="cursor:pointer" v-if="!house_maintain_employee" @click="show_dlg_apply_maintainer=true">
								<i class="fa fa-diamond"></i>
								<p>申请维护人</p>
							</li>
							
							<li class="character" v-if="house_prospect_employee">
								<dl class="character-dl">
									<dt>
										<img :src="house_prospect_employee.headimg"/>
										<div class="character-div">实勘人</div>
									</dt>
									<dd>
										<h4 v-html="house_prospect_employee.name">李翔</h4>
										<p v-html="house_prospect_employee.team_name">星海名城一组</p>
										<p v-html="house_prospect_employee.mobile">15333389765</p>
									</dd>
								</dl>
							</li>
							<li class="character" v-if="house_key_employee">
								<dl class="character-dl">
									<dt>
										<img :src="house_key_employee.headimg"/>
										<div class="character-div">钥匙人</div>
									</dt>
									<dd>
										<h4 v-html="house_key_employee.name">李翔</h4>
										<p v-html="house_key_employee.team_name">星海名城一组</p>
										<p v-html="house_key_employee.mobile">15333389765</p>
									</dd>
								</dl>
							</li>
							<li class="character character1" @click="show_dlg_upload_key=true" style="cursor:pointer" v-if="!house_key_employee">
								<i class="fa fa-key"></i>
								<p>上传钥匙</p>
							</li>
							
							<li class="character" v-if="upload_agent_cert_employee">
								<dl class="character-dl">
									<dt>
										<img :src="upload_agent_cert_employee.headimg"/>
										<div class="character-div">委托人</div>
									</dt>
									<dd>
										<h4 v-html="upload_agent_cert_employee.name">李翔</h4>
										<p v-html="upload_agent_cert_employee.team_name">星海名城一组</p>
										<p v-html="upload_agent_cert_employee.mobile">15333389765</p>
									</dd>
								</dl>
							</li>
							
							<li class="character character1" style="cursor:pointer" v-if="!upload_agent_cert_employee">
								<i class="fa fa-diamond"></i>
								<p>委托人</p>
							</li>
						</ul>
					</div>
				</div>
				
			</div>
			
			<!----带看---->
			<div role="tabpanel" class="tab-pane active" id="look-with">
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
					<p class="panel-p">带看信息</p>
					<i :class="{fa:true,'fa-angle-double-down':!show_takesee_info,'fa-angle-double-up':show_takesee_info}" @click="show_takesee_info=!show_takesee_info" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i></div>
					<div class="panel-body" id="show_takesee_info">
						<ul class="col-sm-12">
							<see-item v-for="see in house_info.takesees" :employees="employees" :see="see">
						</ul>
					</div>
				</div>
			</div>
			
			<!----相似房源---->
			<div role="tabpanel" class="tab-pane active" id="similar">
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
					<p class="panel-p">相似房源</p>
					<i :class="{fa:true,'fa-angle-double-down':!show_similar_house,'fa-angle-double-up':show_similar_house}" @click="show_similar_house=!show_similar_house" style="font-size:2.5rem;font-weight:bolder;margin-left:10px;cursor:pointer;"></i></div>
					<div class="panel-body" id="show_similar_house">
						<ul class="col-sm-12">
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
							
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
							
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
							
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
							
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
							
							<li class="col-sm-3">
								<dl>
									<dt>
										<img src="../../../static/img/fang1.png" class="similar-dt-img"/>
									</dt>
									<dd class="similar-dd">
										<h4>前海花园</h4>
										<div>90平米,3居,<span>580万</span></div>
									</dd>
								</dl>
							</li>
						</ul>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dlg_edit_house_level" :class="{hide:!show_dlg_edit_house_level}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div">
			<div class="webbox-header">
				<div class="webbox-title">修改等级</div>
				<span style="" @click="hideEditLevel()">×</span>
			</div>
			<div class="webbox-body">
				<div class="webbox-body-div">
					<label class="col-sm-4">选择等级</label>
					 <div class="col-sm-7">
						<select type="text" class="form-control" placeholder="选择等级" v-model="curr_level">
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
				</div>
			</div>
			<div class="webbox-btn">
				<button class="determine-btn" @click="changeLevel()">确  定</button>
				<button class="cancel-btn" @click="hideEditLevel()">取  消</button>
			</div>
		</div>
	</div>
	
	<!--上传房产证--->
	<div id="dlg_upload_house_cert" :class="{hide:!show_dlg_upload_house_cert}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">上传房产证</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_cert_img" :src="msg_upload_cert.cert_img==''?'../../../static/img/upload.png':msg_upload_cert.cert_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div class="" style="margin-top:10px;">
				<label>产证面积：</label>
				<input type="tel" class="form-control" placeholder="请填写产证面积" style="width:auto;display:inline" v-model="msg_upload_cert.area"></input>
				<label>㎡</label>
			</div>
			<div class="" style="margin-top:10px;">
				<label>套内面积：</label>
				<input type="tel" class="form-control" placeholder="请填写套内面积" style="width:auto;display:inline" v-model="msg_upload_cert.inner_area"></input>
				<label>㎡</label>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyHouseCert()">申请</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_house_cert=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--查看房产证--->
	<div id="dlg_house_cert" :class="{hide:!show_dlg_house_cert}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">房产证信息</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.house_cert.cert_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div class="" style="margin-top:10px;">
				<label>产证面积：</label>
				<span v-html="house_info.house_cert.area"></span>
				<label>㎡</label>
				<label style="margin-left:20px">套内面积：</label>
				<span v-html="house_info.house_cert.inner_area"></span>
				<label>㎡</label>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_house_cert=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--上传委托书--->
	<div id="dlg_upload_agent_cert" :class="{hide:!show_dlg_upload_agent_cert}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">上传委托书</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_agent_cert_img" :src="msg_upload_agent_cert.cert_img==''?'../../../static/img/upload.png':msg_upload_agent_cert.cert_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div class="" style="margin-top:10px;">
				<label>委托类型：</label>
				<select v-model="msg_upload_agent_cert.type" class="form-control" style="display:inline;width:auto;">
					<option value="0">无委托书</option>
					<option value="1">一般委托书</option>
					<option value="2">信任委托书</option>
					<option value="3">全权委托书</option>
				</select>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyHouseAgentCert()">申请上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_agent_cert=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--推荐房源--->
	<div id="dlg_recomment_house" :class="{hide:!show_dlg_recomment_house,'is_dlg':true}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">推荐房源</label>
			</div>
			<div class="form-inline" style="margin-top:10px;">
				<label>选择被推荐人：</label>
				<select class="form-control" v-model="recommend_em_id">
					<option v-for="e in com_maintainers" :value="e.employee_id" v-html="e.name" v-if="e.employee_id!=employee.employee_id"></option>
				</select>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="recommendHouse()">确认推荐</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_recomment_house=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--修改房源售价--->
	<div id="dlg_edit_price" :class="{hide:!show_dlg_edit_price,'is_dlg':true}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">修改房源售价</label>
			</div>
			<div class="" style="margin-top:10px;">
				<label>房源售价：</label>
				<input type="tel" class="form-control" style="display:inline;width:auto" v-model="price_new"></input>
				<label style="margin-left:5px">万</label>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info hour-sf" style="flex:2" >确认修改</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_edit_price=false">取消</div>
				</div>
			</div>
			
			<div class="hour-j">
				<div class="hour-j-s" @click="editHousePrice()">是</div>
				<div class="hour-j-f" @click="show_dlg_edit_price=false">否</div>
			</div>
		</div>
		
	</div>
	
	<!--查看委托书--->
	<div id="dlg_house_agent_cert" :class="{hide:!show_dlg_house_agent_cert}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">委托书信息</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.agent_cert.cert_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_house_agent_cert=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--原始购房合同--->
	<div id="dlg_upload_contract" :class="{hide:!show_dlg_upload_contract}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">上传原始购房合同</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_contract_img" :src="msg_upload_contract.contract_img==''?'../../../static/img/upload.png':msg_upload_contract.contract_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyHouseContract()">申请上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_contract=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--查看原始购房合同--->
	<div id="dlg_contract" :class="{hide:!show_dlg_contract}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">原始购房合同</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.contract.contract_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_contract=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--业主身份证明上传--->
	<div id="dlg_upload_idpaper" :class="{hide:!show_dlg_upload_idpaper}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">上传业主身份证明</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_id_img" :src="msg_upload_idpaper.id_img==''?'../../../static/img/upload.png':msg_upload_idpaper.id_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyIdPaper()">申请上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_idpaper=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--查看业主身份证明--->
	<div id="dlg_idpaper" :class="{hide:!show_dlg_idpaper}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">业主身份证明</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.idpaper.id_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_idpaper=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--契税票上传--->
	<div id="dlg_upload_taxticket" :class="{hide:!show_dlg_upload_taxticket}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">契税票上传</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_ticket_img" :src="msg_upload_taxticket.ticket_img==''?'../../../static/img/upload.png':msg_upload_taxticket.ticket_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyTaxTicket()">申请上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_taxticket=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--查看契税票上传--->
	<div id="dlg_tax_ticket" :class="{hide:!show_dlg_tax_ticket}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">契税票</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.idpaper.id_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_tax_ticket=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--上传房屋核验报告--->
	<div id="dlg_upload_veri_report" :class="{hide:!show_dlg_upload_veri_report}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">房屋核验报告上传</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img id="upload_report_img" :src="msg_upload_verireport.report_img==''?'../../../static/img/upload.png':msg_upload_verireport.report_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyVeriReport()">申请上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_veri_report=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--查看房屋核验报告--->
	<div id="dlg_veri_report" :class="{hide:!show_dlg_veri_report}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">房屋核验报告</label>
			</div>
			<div class="" style="margin-top:10px;text-align:center;">
				<img :src="house_info.veri_report.report_img" style="width:120px;cursor:pointer;"></img>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_veri_report=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	<!--认证房源编号--->
	<div id="dlg_upload_house_number" :class="{hide:!show_dlg_upload_house_number}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">认证房源编号</label>
			</div>
			<div class="" style="margin-top:10px;text-align:left;">
				<label>房源编号：</label>
				<input class="form-control" style="width:auto;display:inline" v-model="msg_upload_housenumber.number"></input>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyHouseNumber()">申请修改</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_house_number=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--认证房源编号--->
	<div id="dlg_house_number" :class="{hide:!show_dlg_house_number}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">认证房源编号</label>
			</div>
			<div class="" style="margin-top:10px;text-align:left;">
				<label>房源编号：</label>
				<span class="form-control" style="width:auto;display:inline" editable=false v-html="house_info.house_number.number"></span>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-success" style="flex:2" @click="show_dlg_house_number=false">关闭</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--上传钥匙--->
	<div id="dlg_upload_key" :class="{hide:!show_dlg_upload_key}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">上传钥匙</label>
			</div>
			<div class="" style="margin-top:10px;text-align:left;">
				<label>钥匙编号：</label>
				<input class="form-control" style="width:auto;display:inline" v-model="key_number"></input>
			</div>
			<div class="" style="margin-top:10px;text-align:left;">
				<label>备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
				<textarea class="form-control" style="width:auto;display:inline" v-model="key_mark"></textarea>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="uploadHouseKey()">上传</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_upload_key=false">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--申请维护人-->
	<div id="dlg_apply_maintainer" :class="{hide:!show_dlg_apply_maintainer,is_dlg:true}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">是否确实房源在售？</label>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyMaintainer()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_apply_maintainer=false">取消</div>
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

	function showMsg(msg) {
		new $.zui.Messager(msg, {
		icon: 'bell' // 定义消息图标
	  }).show();
	}
	Vue.filter("formatDate", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
	  function add0(m) {
		return m<10?'0'+m:m;
	  }
	  
	  var time = new Date(parseInt(value)*1000);
	  var y = time.getFullYear();
	  var m = time.getMonth() +1;
	  var d = time.getDate();
	  
	  //var h = time.getHours();
	  //var minute = time.getMinutes();
	  return add0(y)+"/"+add0(m)+"/"+add0(d);
	});
	
	Vue.filter("formatTime", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
	  function add0(m) {
		return m<10?'0'+m:m;
	  }
	  
	  var time = new Date(parseInt(value)*1000);
	  var y = time.getFullYear();
	  var m = time.getMonth() +1;
	  var d = time.getDate();
	  
	  var h = time.getHours();
	  var minute = time.getMinutes();
	  return add0(y)+"/"+add0(m)+"/"+add0(d)+" "+add0(h)+":"+add0(minute);
	});
		
	function sortFollowInfoes(a,b){
		if(a.top && a.top == 'true') {
			return -1;
		} else if(b.top && b.top == 'true') {
			return 1;
		} else if(parseInt(a.time) < parseInt(b.time)) {
			return 1;
		}
		return -1;
	}
	
	var seeItem = Vue.component('see-item', {
		props:['see','employees'],
		template:	'<li class="col-sm-12 follow-up-li">'+
						'<div class="look-with-div">'+
							'<i class="fa fa-eye"></i>'+
							'<div class="look-with-s">{{see.start_time}}<p>带看反馈：<span v-html="see.summary"></span></p></div>'+
							'<p class="look-with-x" v-html="employee_info"></p>'+
						'</div>'+
					'</li>',
		created:function() {
			
		},
		mounted:function() {
		},
		computed:{
			employee_info:function() {
				for(var i = 0; i < this.employees.length; i++) {
					if(this.employees[i].employee_id == this.see.employee_id) {
						return this.employees[i].name+"("+this.employees[i].team_name+")"+"-"+this.employees[i].mobile;
					}
				}
				return '';
			}
		},
		methods:{
		}
	});
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				employee:<?=json_encode($_SESSION['employee'])?>,
				edit_comment:false,
				is_upload_flollow_img:false,
				show_more:false,
	    	edit_maintaininfo: false,
				follow:<?=json_encode($follow)?>,
	    	edit_two: false,
				show_dlg_edit_house_level:false,
				rooms:[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
				halls:[0,1,2,3,4,5,6,7,8,9,10],
				kitchens:[0,1,2,3,4,5],
				toilets:[0,1,2,3,4,5,6,7,8,9,10],
				house_info_edit:<?=json_encode($house_info)?>,
				curr_level:'A',
				openhome_times:["下班后","提前预约随时可看","只能周末看","有租户需要预约"],
				entrust_srcs:[
					{
						name:'实体开发',
						sub_srcs:[
						]
					},
					{
						name:'人际开发',
						sub_srcs:[
						]
					},
					{
						name:'二次开发',
						sub_srcs:[
						]
					},
					{
						name:'其他网络',
						sub_srcs:[
						]
					}
				],
				comments:[
					{
						type:'selling_point',
						info:'核心卖点'
					}
				],
				comment_title_edit:'',
				comments_edit:[],
				sold_reasons:[
					{
						name:'换房',
						subreasons:[]
					},
					{
						name:'离深',
						subreasons:['出国','回老家']
					},
					{
						name:'套现',
						subreasons:['投资','生意']
					},
					{
						name:'应急',
						subreasons:[]
					},
					{
						name:'其他',
						subreasons:[]
					},
				],
				recommend_em_id:0,
				curr_tab:'description',
				curr_step:1,
				curr_city_time:0,
				curr_community_name:'',
				curr_bb_id:-1,//$.cookie("curr_bb_id"),
				curr_bu_id:-1,//$.cookie("curr_bu_id"),
				curr_floor:-10,//$.cookie("curr_floor"),
				curr_house_id:-1,
				curr_min_floor:0,
				curr_max_floor:0,
				curr_building_block:{
					names:'',
					community_id:0,
					max_floor:0,
					min_floor:0,
				},
				
				com_maintainers:[],
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				communities:[],
				building_blocks:[],
				building_units:[],
				houses:[],
				
				loaded_trade_areas:[],
				loaded_communities:[],
				loaded_build_blocks:[],
				loaded_build_units:[],
				house_info:<?=json_encode($house_info)?>,
				house_infoes:<?=json_encode($house_infoes)?>,
				house:<?=json_encode($house)?>,
				community:<?=json_encode($community)?>,
				building_block:<?=json_encode($bb)?>,
				building_unit:<?=json_encode($bu)?>,
				trade_area:<?=json_encode($trade_area)?>,
				area:<?=json_encode($area)?>,
				now:<?=$now?>,
				employees:<?=json_encode($employees)?>,
				upload_cert_employee:<?=json_encode($upload_cert_employee)?>,
				upload_agent_cert_employee:<?=json_encode($upload_agent_cert_employee)?>,
				upload_idpaper_employee:<?=json_encode($upload_idpaper_employee)?>,
				upload_taxticket_employee:<?=json_encode($upload_taxticket_employee)?>,
				upload_verireport_employee:<?=json_encode($upload_verireport_employee)?>,
				upload_housenumber_employee:<?=json_encode($upload_housenumber_employee)?>,
				
				house_add_employee:<?=json_encode($house_add_employee)?>,
				house_maintain_employee:<?=json_encode($house_maintain_employee)?>,
				house_prospect_employee:<?=json_encode($house_prospect_employee)?>,
				house_key_employee:<?=json_encode($house_key_employee)?>,
				house_authorize_employee:<?=json_encode($house_authorize_employee)?>,
				
				upload_img_name:'',
				upload_index:[],
				msg_upload_cert:{
					house_info_id:<?=$house_info['house_info_id']?>,
					cert_img:'',
					area:0,
					inner_area:0
				},
				msg_upload_agent_cert:{
					house_info_id:<?=$house_info['house_info_id']?>,
					cert_img:'',
					type:0,
				},
				msg_upload_contract:{
					house_info_id:<?=$house_info['house_info_id']?>,
					contract_img:'',
				},
				msg_upload_idpaper:{
					house_info_id:<?=$house_info['house_info_id']?>,
					id_img:'',
				},
				msg_upload_taxticket:{
					house_info_id:<?=$house_info['house_info_id']?>,
					ticket_img:'',
				},
				msg_upload_verireport:{
					house_info_id:<?=$house_info['house_info_id']?>,
					report_img:'',
				},
				msg_upload_housenumber:{
					house_info_id:<?=$house_info['house_info_id']?>,
					number:'',
				},
				key_number:'',
				key_mark:'',
				house_info_add:{
					house_id:0,
					room_count:1,
					hall_count:1,
					kitchen_count:1,
					toilet_count:1,
					area:-1,
					price:1,
					openhouse_time:1,
					entrust_src1:1,
					entrust_src2:1,
					owner:{
						name:'',
						wechat_num:'',
						mobile:'',
						telephone:'',
						more_contact:[],
					},
					contacts:[//每个contacts和owner结构一样
					]
				},
				info_add:{
					info:'',
					employee:<?=json_encode($employee)?>
				},
				
				show_base_info:true,
				show_maintain_info:true,
				show_cert_info:true,
				show_house_comment:true,
				show_realcheck_info:true,
				show_house_img:true,
				show_followup_info:true,
				show_role_info:true,
				show_takesee_info:true,
				show_similar_house:true,
				employee:<?=json_encode($employee)?>,
				
				
				price_new:<?=$house_info['price']?>,
				show_add_follow_panel:false,
				show_dlg_upload_house_cert:false,
				show_dlg_house_cert:false,
				show_dlg_upload_agent_cert:false,
				show_dlg_house_agent_cert:false,
				show_dlg_upload_contract:false,
				show_dlg_contract:false,
				show_dlg_upload_idpaper:false,
				show_dlg_idpaper:false,
				show_dlg_upload_taxticket:false,
				show_dlg_tax_ticket:false,
				show_dlg_upload_veri_report:false,
				show_dlg_veri_report:false,
				show_dlg_upload_house_number:false,
				show_dlg_house_number:false,
				show_dlg_upload_key:false,
				show_dlg_edit_price:false,
				show_dlg_recomment_house:false,
				show_dlg_apply_maintainer:false,
			},
			computed:{
				build_time:function() {
				  function add0(m) {
					return m<10?'0'+m:m;
				  }
				  
				  var time = new Date(parseInt(this.house_info.build_time)*1000);
				  var y = time.getFullYear();
				  var m = time.getMonth() +1;
				  var d = time.getDate();
				  return add0(y)+"-"+add0(m)+"-"+add0(d);
				},
				decoration_state:function() {
					var s = ['毛胚','清水简装','精装','豪装','需重装'];
					return s[this.house_info.decoration_state];
				},
				openhome_time:function() {
					var s = ['下班后','提前预约随时可看','只能周末看','有租户需要预约'];
					return s[this.house_info.openhome_time-1];
				},
				sold_reason:function() {
					var r = this.sold_reasons[this.house_info.sold_reason].name;
					if(this.sold_reasons[this.house_info.sold_reason].subreasons.length > 0) {
						r += "-"+this.sold_reasons[this.house_info.sold_reason].subreasons[this.house_info.sold_reason1];
					}
					
					if(this.house_info.sold_reason == 3) {
						r += "-"+this.house_info.sold_reason2;
					}
					return r;
				},
				selling_cycle:function() {
					var s = ['一周内','一个月','三个月'];
					return s[this.house_info.selling_cycle];
				},
				marry_state:function() {
					var s = ['未婚','已婚'];
					return s[this.house_info.marry_state]+"-"+this.house_info.child_info;
				},
				orientation:function() {
					var o = [];
					if(!this.house_info.orientation) {
						return "";
					}
					var s = this.house_info.orientation.split("|");
					for(var i = 0; i < s.length; i++) {
						if(s[i] == '_e') {
							o.push('东');
						} else if(s[i] == 'es') {
							o.push('东南');
						} else if(s[i] == '_n') {
							o.push('北');
						} else if(s[i] == 'en') {
							o.push('东北');
						} else if(s[i] == '_s') {
							o.push('南');
						} else if(s[i] == '_w') {
							o.push('西');
						} else if(s[i] == 'wn') {
							o.push('西北');
						} else if(s[i] == 'ws') {
							o.push('西南');
						}
					}
					return o.join(",");
				},
				listing_date:function() {
					return this.formatDate(this.house_info.create_time);
				},
				listing_dur:function() {
					return Math.floor((this.now - this.house_info.create_time)/(3600*24));
				},
				entrust_src:function() {
					return this.entrust_srcs[this.house_info.entrust_src1].name;
				},
				contact_info:function() {
					if(this.employee.role == 0) {
						return '';
					}
					var msg = [];
					if(this.house_info.owner) {
						msg.push('业主：'+this.house_info.owner.name+"-"+this.house_info.owner.mobile);
					}
					
					if(this.house_info.contacts && this.house_info.contacts.length > 0) {
						for(var i = 0; i < this.house_info.contacts.length; i++) {
							msg.push('联系人：'+this.house_info.contacts[i].name+"-"+this.house_info.contacts[i].mobile);
						}
					}
					console.log(msg);
					return msg.join("<br>");
				},
				house_address:function() {
					if(this.employee.role == 0) {
						return '';
					}
					return this.community.name + this.building_block.name+(this.building_unit.name=='0单元'?'':this.building_unit.name)+this.house.floor+this.house.name;
				}
			},
			created:function() {
				this.house_info.room_count = parseInt(this.house_info.room_count);
				this.house_info.hall_count = parseInt(this.house_info.hall_count);
				this.house_info.kitchen_count = parseInt(this.house_info.kitchen_count);
				this.house_info.toilet_count = parseInt(this.house_info.toilet_count);
				
				if(this.employee.role != 0) {
					this.house_info.owner = JSON.parse(this.house_info.owner);
				}
				
				if(this.house_info.contacts) {
					this.house_info.contacts = JSON.parse(this.house_info.contacts);
				} else {
					this.house_info.contacts = [];
				}
				
				if(this.house_info.house_cert) {
					this.house_info.house_cert = JSON.parse(this.house_info.house_cert);
				} else {
					this.house_info.house_cert = [];
				}
				
				if(this.house_info.agent_cert) {
					this.house_info.agent_cert = JSON.parse(this.house_info.agent_cert);
				} else {
					this.house_info.agent_cert = [];
				}
				
				if(this.house_info.contract) {
					this.house_info.contract = JSON.parse(this.house_info.contract);
				} else {
					this.house_info.contract = {};
				}
				
				if(this.house_info.idpaper) {
					this.house_info.idpaper = JSON.parse(this.house_info.idpaper);
				} else {
					this.house_info.idpaper = {};
				}
				
				if(this.house_info.deed_tax_ticket) {
					this.house_info.deed_tax_ticket = JSON.parse(this.house_info.deed_tax_ticket);
				} else {
					this.house_info.deed_tax_ticket = {};
				}
				
				if(this.house_info.veri_report) {
					this.house_info.veri_report = JSON.parse(this.house_info.veri_report);
				} else {
					this.house_info.veri_report = {};
				}
				
				if(this.house_info.house_number) {
					this.house_info.house_number = JSON.parse(this.house_info.house_number);
				} else {
					this.house_info.house_number = {};
				}
				
				if(this.house_info.comments) {
					this.house_info.comments = JSON.parse(this.house_info.comments);
				} else {
					this.house_info.comments = [];
				}

				if(!this.house_info.followup_infoes) {
					this.house_info.followup_infoes = [];
				} else {
					this.house_info.followup_infoes = JSON.parse(this.house_info.followup_infoes);
				}
				this.house_info.followup_infoes.sort(sortFollowInfoes);
				
				if(!this.house_info.follow_imgs) {
					this.house_info.follow_imgs = {
						rooms:[],
						halls:[],
						kitchens:[],
						toilets:[]
					};
				} else {
					this.house_info.follow_imgs = JSON.parse(this.house_info.follow_imgs);
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_edit_house_level").css("display",'');
				$(this.$el).find("#dlg_upload_house_cert").css("display",'');
				$(this.$el).find("#dlg_house_cert").css("display",'');
				$(this.$el).find("#dlg_upload_agent_cert").css("display",'');
				$(this.$el).find("#dlg_house_agent_cert").css("display",'');
				$(this.$el).find("#dlg_upload_contract").css("display",'');
				$(this.$el).find("#dlg_contract").css("display",'');
				$(this.$el).find("#dlg_upload_idpaper").css("display",'');
				$(this.$el).find("#dlg_idpaper").css("display",'');
				$(this.$el).find("#dlg_upload_taxticket").css("display",'');
				$(this.$el).find("#dlg_tax_ticket").css("display",'');
				$(this.$el).find("#dlg_upload_veri_report").css("display",'');
				$(this.$el).find("#dlg_veri_report").css("display",'');
				$(this.$el).find("#dlg_upload_house_number").css("display",'');
				$(this.$el).find("#dlg_house_number").css("display",'');
				$(this.$el).find("#dlg_upload_key").css("display",'');
				$(this.$el).find(".is_dlg").css("display", '');
				
				var that = this;
				var poster_uploader = new QiniuJsSDK();
				var poster_uploader_opt = {
					browse_button: 'ID_houseImg',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   
						   that.house_info.house_img = sourceLink;
						   API.invokeModuleCall(g_host_url,'houseinfo','editHouseInfo',that.house_info,function(json) {
							  if(json.code == 0) {
								  
							  } 
						   });
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader.uploader(poster_uploader_opt);
				
				var poster_uploader1 = new QiniuJsSDK();
				var poster_uploader_opt1 = {
					browse_button: 'upload_followup_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   if(that.upload_img_name == 'structure') {
							   that.house_info.follow_imgs.structure = sourceLink;
							   that.is_upload_flollow_img = true;
							   return;
						   }
						   if(!that.house_info.follow_imgs[that.upload_img_name]) {
							   that.house_info.follow_imgs[that.upload_img_name] = [];
						   }
						   that.house_info.follow_imgs[that.upload_img_name][that.upload_index] = sourceLink;
						   that.is_upload_flollow_img = true;
						   that.$forceUpdate();
						   /*
						   API.invokeModuleCall(g_host_url,'houseinfo','editHouseInfo',that.house_info, function(json) {
							   that.$forceUpdate();
						   });
						   */
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader1.uploader(poster_uploader_opt1);
				
				
				var poster_uploader2 = new QiniuJsSDK();
				var poster_uploader_opt2 = {
					browse_button: 'upload_cert_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_cert.cert_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader2.uploader(poster_uploader_opt2);
				
				var poster_uploader3 = new QiniuJsSDK();
				var poster_uploader_opt3 = {
					browse_button: 'upload_agent_cert_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_agent_cert.cert_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader3.uploader(poster_uploader_opt3);
				
				var poster_uploader4 = new QiniuJsSDK();
				var poster_uploader_opt4 = {
					browse_button: 'upload_contract_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_contract.contract_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader4.uploader(poster_uploader_opt4);
				
				var poster_uploader5 = new QiniuJsSDK();
				var poster_uploader_opt5 = {
					browse_button: 'upload_id_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_idpaper.id_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader5.uploader(poster_uploader_opt5);
				
				var poster_uploader6 = new QiniuJsSDK();
				var poster_uploader_opt6 = {
					browse_button: 'upload_ticket_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_taxticket.ticket_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader6.uploader(poster_uploader_opt6);
				
				var poster_uploader7 = new QiniuJsSDK();
				var poster_uploader_opt7 = {
					browse_button: 'upload_report_img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					flash_swf_url: 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.msg_upload_verireport.report_img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader7.uploader(poster_uploader_opt7);
				
				
				$(this.$el).find("#ID_launchTime").datetimepicker(
												{
													language:  "zh-CN",
													weekStart: 1,
													todayBtn:  1,
													autoclose: 1,
													todayHighlight: 1,
													startView: 2,
													minView: 2,
													forceParse: 0,
													format: "yyyy-mm-dd"
												}); 
												
				$(this.$el).find("#ID_school_quota_time").datetimepicker(
												{
													language:  "zh-CN",
													weekStart: 1,
													todayBtn:  1,
													autoclose: 1,
													todayHighlight: 1,
													startView: 2,
													minView: 2,
													forceParse: 0,
													format: "yyyy-mm-dd"
												}); 
												
				$(this.$el).find("#ID_decoration_time").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					format: "yyyy-mm-dd"
				}); 
															
			},
			watch:{
				show_dlg_edit_price:function(show) {
					if(show) {
						$(".hour-j").hide();
					}
				},
				show_add_follow_panel:function() {
					$("#show_add_follow_panel").slideToggle();
				},
				show_followup_info:function() {
					$("#show_followup_info").slideToggle();
				},
				show_role_info:function() {
					$("#show_role_info").slideToggle();
				},
				show_similar_house:function() {
					$("#show_similar_house").slideToggle();
				},
				show_takesee_info:function() {
					$("#show_takesee_info").slideToggle();
				},
				show_realcheck_info:function() {
					$("#show_realcheck_info").slideToggle();
				},
				show_house_comment:function() {
					$("#show_house_comment").slideToggle();
				},
				show_cert_info:function() {
					$("#show_cert_info").slideToggle();
				},
				show_base_info:function() {
					$("#show_base_info").slideToggle();
				},
				show_maintain_info:function() {
					if(!this.edit_maintaininfo && this.show_maintain_info) {
						$("#maintain_info").slideDown();
					} else {
						$("#maintain_info").slideUp();
					}
				},
				edit_maintaininfo:function() {
					if(!this.edit_maintaininfo && this.show_maintain_info) {
						$("#maintain_info").slideDown();
					} else {
						$("#maintain_info").slideUp();
					}
				},
				show_dlg_recomment_house:function(val) {
					var that = this;
					if(val) {
						API.invokeModuleCall(g_host_url, 'house', 'queryCommunityMainters', this.house_info, function(json) {
							if(json.code == 0) {
								that.com_maintainers = json.employees;
							}
						});
					}
				},
				curr_community_name:function(val) {
					this.communities = [];
					if(!window['g_communities_'+this.curr_city_id]) {
						$LAB.script("<?=QINIU_DOMAIN?>/com_js/city_"+this.curr_city_id+".js?v=3").wait(function() {
							var communities = window['g_communities_'+this.curr_city_id];
							var str = /^[A-Za-z]*$/;
							val = val.toUpperCase();
							if (str.test(val)) {//是字母，则判断
								for(var i = 0; i < communities.length; i++) {
									if(communities[i].retriving_info) {
										if(communities[i].retriving_info.indexOf(val) >= 0) {
											that.communities.push(communities[i]);
										}
									}
								}
							}
						});
					} else {
						if(val == "") {
							this.communities = [];
							return;
						}
						var communities = window['g_communities_'+this.curr_city_id];
						console.log('communities=',communities);
						var str = /^[A-Za-z]*$/;
						val = val.toUpperCase();
						if (str.test(val)) {//是字母，则判断
							for(var i = 0; i < communities.length; i++) {
								if(communities[i].retriving_info) {
									if(communities[i].retriving_info.indexOf(val) >= 0) {
										this.communities.push(communities[i]);
									}
								}
							}
						}
					}
				},
				curr_bb_id:function(val) {
					$.cookie("curr_bb_id", this.curr_bb_id, { expires: 7,path: '/'});
					this.curr_building_block.name = '';
					this.curr_building_block.community_id = 0;
					this.curr_building_block.min_floor = 0;
					this.curr_building_block.max_floor = 0;
					for(var i = 0; i < this.building_blocks.length; i++) {
						if(this.building_blocks[i].bb_id == this.curr_bb_id) {
							this.curr_building_block.name = this.building_blocks[i].name;
							this.curr_building_block.community_id = this.building_blocks[i].community_id;
							this.curr_building_block.min_floor = this.building_blocks[i].min_floor;
							this.curr_building_block.max_floor = this.building_blocks[i].max_floor;
							break;
						}
					}
					var that = this;
					that.curr_bu_id = -1;
					this.curr_house_id = -1;
				},
				curr_bu_id:function(val) {
					var that = this;
					this.curr_floor = -10;
					API.invokeModuleCall(g_host_url,'house','queryHouses', {bu_id:val}, function(json) {
						if(json.code == 0) {
							that.houses = json.houses;
						}
					});
				},
				curr_area_id:function(val) {
					$.cookie("curr_area_id", this.curr_area_id,{ expires: 7,path: '/'});
					this.curr_trade_area_id = 0;
					for(var i = 0; i < this.trade_areas.length; i++) {
						if(this.trade_areas[i].ta_id == this.curr_trade_area_id) {
							this.curr_trade_area_id = this.trade_areas[i].ta_id;
							break;
						}
					}
				},
				curr_ta_id:function(val) {
					var that = this;
					that.curr_community_id = -1;
					if($.inArray(val, this.loaded_trade_areas) < 0) {//不存在，则加载这个片区的小区及栋座信息
						API.invokeModuleCall(g_host_url,'house','queryAreaCommunities', {ta_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_trade_areas.push(val);
								that.communities = that.communities.concat(json.communities);
								
								for(var i = 0; i < that.communities.length; i++) {
									if(that.communities[i].ta_id == val) {
										that.curr_community_id = that.communities[i].community_id;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < this.communities.length; i++) {
							if(this.communities[i].ta_id == val) {
								this.curr_community_id = this.communities[i].community_id;
							}
						}
					}
				},
				curr_community_id:function(val) {
					var that = this;
					that.curr_bb_id = -1;
					if($.inArray(val, this.loaded_communities) < 0) {
						API.invokeModuleCall(g_host_url,'house','queryBuildingBlocks', {community_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_communities.push(val);
								that.building_blocks = that.building_blocks.concat(json.building_blocks);
								console.log(val, that.building_blocks);
								for(var i = 0; i < that.building_blocks.length; i++) {
									if(that.building_blocks[i].community_id == val) {
										that.curr_bb_id = that.building_blocks[i].bb_id;
										break;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < that.building_blocks.length; i++) {
							if(that.building_blocks[i].community_id == val) {
								that.curr_bb_id = that.building_blocks[i].bb_id;
								break;
							}
						}
					}
				},
				"community_add.name":function(val) {
					this.community_add.retriving_info = makePy(val);
				}
			},
			methods:{
				uploadFollowImg:function() {
					if(!this.house_info.follow_imgs.structure) {
						showMsg('请上传格局图片');
						return false;
					}
					
					if(this.house_info.room_count > 0) {
						for(var i = 0; i < this.house_info.room_count; i++) {
							if(!this.house_info.follow_imgs.rooms[i]) {
								showMsg('请上传居室图片');
								return false;
							}
						}
					}
					
					if(this.house_info.hall_count > 0) {
						if(!this.house_info.follow_imgs.halls) {
							showMsg('请上传客厅图片');
							return false;
						}
						for(var i = 0; i < this.house_info.hall_count; i++) {
							if(!this.house_info.follow_imgs.halls[i]) {
								showMsg('请上传客厅图片');
								return false;
							}
						}
					}
					
					if(this.house_info.kitchen_count > 0) {
						if(!this.house_info.follow_imgs.kitchens) {
							showMsg('请上传厨房图片');
							return false;
						}
						for(var i = 0; i < this.house_info.kitchen_count; i++) {
							if(!this.house_info.follow_imgs.kitchens[i]) {
								showMsg('请上传厨房图片');
								return false;
							}
						}
					}
					
					if(this.house_info.toilet_count > 0) {
						if(!this.house_info.follow_imgs.toilets) {
							showMsg('请上传卫生间图片');
							return false;
						}
						for(var i = 0; i < this.house_info.toilet_count; i++) {
							if(!this.house_info.follow_imgs.toilets[i]) {
								showMsg('请上传卫生间图片');
								return false;
							}
						}
					}
					
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseFollowImg', {house_info_id:this.house_info.house_info_id, follow_imgs:this.house_info.follow_imgs}, function(json) {
						if(json.code == 0) {
							showMsg('申请已提交');
						}
					});
					return true;
				},
				recommendHouse:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'recommendHouse', {employee_id:this.recommend_em_id,house_info_id:this.house_info.house_info_id}, function(json) {
						if(json.code == 0) {
							that.show_dlg_recomment_house = false;
							showMsg('已发消息通知对方，请等待对方接收！');
						}
					});
				},
				applyHouseFocus:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseFocus', {house_info_id:this.house_info.house_info_id}, function(json) {
						if(json.code == 0) {
							showMsg('申请已提交');
							that.is_upload_flollow_img = false;
						}
					});
				},
				addFollowInfo:function() {//录入跟进
					if(this.info_add.info == '') {
						showMsg('跟进信息不能为空');
						return;
					}
					var that = this;
					that.house_info.followup_infoes.push(that.info_add);
					API.invokeModuleCall(g_host_url,'houseinfo','addFollowInfo', this.house_info, function(json) {
						if(json.code == 0) {
							showMsg('录入成功');
							that.info_add.time = json.time;
							that.house_info.followup_infoes = json.followup_infoes.reverse();
						}
						that.show_add_follow_panel = false;
					});
				},
				setFollow:function() {
					var that = this;
					var s = 1;
					if(this.follow) {
						s = 0;
					}
					API.invokeModuleCall(g_host_url, 'user', 'setFollow', {house_info_id:this.house_info.house_info_id, s:s, follow:this.follow}, function(json) {
						if(json.code == 0) {
							if(s == 1) {
								that.follow = json.follow;
								showMsg('关注成功');
							} else {
								that.follow = null;
							}
						}
					});
				},
				applyMaintainer:function() {
					<?php if($employee['type'] != ADMIN_TYPE_NONE) { ?>
					showMsg('您是管理员，无法申请');
					return;
					<?php }?>
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyMaintainer', {house_info_id:this.house_info.house_info_id}, function(json) {
						if(json.code == 0) {
							showMsg('申请成功');
						} else if(json.code == 1) {
							showMsg('该房源在您维护范围内，直接成功');
						} else if(json.code == -1) {
							showMsg('申请失败,您不是该小区维护人！');
						}
						that.show_dlg_apply_maintainer = false;
					});
					
				},
				uploadHouseKey:function() {
					if(this.key_number == '') {
						showMsg("钥匙编号为空");
						return;
					}
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'uploadHouseKey', {house_info_id:this.house_info.house_info_id,key_number:this.key_number, key_mark:this.key_mark}, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_key = false;
						}
					});
				},
				getHouseState:function(s) {
					var v = ['自住','出租','空置','经营中'];
					return v[s];
				},
				uploadHouseImg:function(type,index) {
					$("#upload_followup_img").trigger("click");
					this.upload_img_name = type;
					this.upload_index = index;
				},
				editHousePrice:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, "houseinfo", 'editHousePrice',{house_info_id:this.house_info.house_info_id,price_new:this.price_new}, function(json) {
						if(json.code == 0) {
							showMsg('修改成功');
							if(that.house_info.price < that.price_new) {
								that.house_info.price_state = 1;
							} else {
								that.house_info.price_state = 2;
							}
							that.house_info.price = that.price_new;
			
							that.show_dlg_edit_price = false;
						}
					});
				},
				jumpMaintain:function() {
					location.hash = "#ID_maintain_info";
				},
				jumpComment:function() {
					location.hash = "#ID_house_comment";
				},
				saveMaintainInfo:function() {
					this.house_info_edit.launch_time =  $("#ID_launchTime").val();//Date.parse(new Date($("#ID_launchTime").val()))/1000;
					this.house_info_edit.school_quota_time =  $("#ID_school_quota_time").val();//Date.parse(new Date($("#ID_school_quota_time").val()))/1000;
					this.house_info_edit.decoration_time =  $("#ID_decoration_time").val();//Date.parse(new Date($("#ID_decoration_time").val()))/1000;
					var that = this;
					API.invokeModuleCall(g_host_url, "houseinfo", 'editHouseInfo',this.house_info_edit, function(json) {
						if(json.code == 0) {
							that.house_info = myDeepCopy(that.house_info_edit);
						}
					});
					this.edit_maintaininfo = false;
					
				},
				closeMaintain:function() {
					this.edit_maintaininfo = false;
				},
				delComment:function(i) {
					this.comments_edit.splice(i,1);
				},
				addComment:function(type) {
					if(this.comments_edit.length >= 6) {
						return;
					}
					
					var has = false;
					for(var i = 0; i < this.comments_edit.length; i++) {
						if(this.comments_edit[i].type == type) {
							has = true;
							break;
						}
					}
					
					console.log(has);
					if(!has) {
						this.comments_edit.push({
							type:type,
							info:''
						});
					}
				},
				getBuildingType:function(val) {
					var m = ['板楼','塔楼','板塔结合','别墅','洋房'];
					return m[val];
				},
				getUsage:function(val) {
					var m = ['住宅','商用'];
					return m[val];
				},
				setTop:function(followup_info,index) {
					for(var i = 0; i < this.house_info.followup_infoes.length; i++) {
						if(i == index) {
							if(this.house_info.followup_infoes[i].top && this.house_info.followup_infoes[i].top == 'true') {
								this.house_info.followup_infoes[i].top = 'false';
							} else {
								this.house_info.followup_infoes[i].top = 'true';
							}
						} else {
							this.house_info.followup_infoes[i].top = 'false';
						}
					}
					var that = this;
					this.house_info.followup_infoes.sort(sortFollowInfoes);
					API.invokeModuleCall(g_host_url,'houseinfo','addFollowInfo', this.house_info, function(json) {
						if(json.code == 0) {
							showMsg('设置成功');
							that.$forceUpdate();
						}
					});
				},
				showEditLevel:function() {
					this.curr_level = this.house_info.level;
					this.show_dlg_edit_house_level = true;
				},
				hideEditLevel:function() {
					this.show_dlg_edit_house_level = false;
				},
				changeLevel:function() {
					var that = this;
					this.house_info.level = this.curr_level;
					API.invokeModuleCall(g_host_url,'houseinfo','editHouseInfo',that.house_info,function(json) {
					  if(json.code == 0) {
						  that.show_dlg_edit_house_level = false;
						  new $.zui.Messager('修改成功', {
							icon: 'bell' // 定义消息图标
						  }).show();
					  } 
				   });
				},
				if_sel:function(val) {
					for(var i = 0; i < this.comments_edit.length; i++) {
						if(this.comments_edit[i].type == val) {
							return true;
						}
					}
					return false;
				},
				getCommentName:function(type) {
					var m = {
						'selling_point':'核心卖点',
						'house_type':'户型介绍',
						'decoration':'装修描述',
						'tax':'税费解析',
						'ownership':'权属抵押',
						'traffic':'交通出行',
						'education':'教育配套',
						'peripheral':'周边配套',
						'community':'小区介绍',
						'target_users':'适宜人群',
						'house_sale':'房售详情'
					};
					return m[type];
				},
				onShowMore:function() {
					this.show_more = !this.show_more;
				},
				applyHouseCert:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseCert', this.msg_upload_cert, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_house_cert = false;
							showMsg('申请已提交');
						}
					});
				},
				applyHouseNumber:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseNumber', this.msg_upload_housenumber, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_house_number = false;
							showMsg('申请已提交');
						}
					});
				},
				applyVeriReport:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyVeriReport', this.msg_upload_verireport, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_veri_report = false;
							showMsg('申请已提交');
						}
					});
				},
				applyTaxTicket:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyTaxTicket', this.msg_upload_taxticket, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_taxticket = false;
							showMsg('申请已提交');
						}
					});
				},
				applyIdPaper:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyIdPaper', this.msg_upload_idpaper, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_idpaper = false;
							showMsg('申请已提交');
						}
					});
				},
				applyHouseAgentCert:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseAgentCert', this.msg_upload_agent_cert, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_agent_cert = false;
							showMsg('申请已提交');
						}
					});
				},
				applyHouseContract:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'applyHouseContract', this.msg_upload_contract, function(json) {
						if(json.code == 0) {
							that.show_dlg_upload_contract = false;
							showMsg('申请已提交');
						} else if(json.code == -10003) {
							that.show_dlg_upload_contract = false;
							showMsg("房屋所在商圈没有指定管理员");
						}
					});
				},
				edit_t:function(){
					$("#ID_launchTime").val(this.house_info_edit.launch_time);
					$("#ID_school_quota_time").val(this.house_info_edit.school_quota_time);
					$("#ID_decoration_time").val(this.house_info_edit.decoration_time);
					
					this.edit_maintaininfo = !this.edit_maintaininfo;
					if(this.edit_maintaininfo) {
						this.house_info_edit = myDeepCopy(this.house_info);
					}
				},
				edit_f:function(){
					this.comments_edit = myDeepCopy(this.house_info.comments);
					this.comment_title_edit = this.house_info.comment_title;
					
					//location.href = "houseinfo/house_comment_edit_page?house_info_id="+this.house_info.house_info_id;
					this.edit_comment = !this.edit_comment;
				},
				saveComment:function() {
					if(this.comments_edit.length < 3) {
						alert('最少填写3个纬度');
						return;
					}
					
					if(this.comment_title_edit == '') {
						alert('请填写标题');
						return;
					}
					var that = this;
					that.house_info.comments = myDeepCopy(that.comments_edit);
					that.house_info.comment_title = that.comment_title_edit;
					API.invokeModuleCall(g_host_url,'houseinfo','editHouseComment', this.house_info, function(json) {
						if(json.code == 0) {
							showMsg('修改成功');
							that.edit_comment = false;
						}
					});
				},
				applyInvalidHouse:function() {
					var that = this;
					if(this.employee.type == 3) {
						if(confirm("确认房源无效？")) {
							API.invokeModuleCall(g_host_url,'houseinfo','applyInvalidHouse', this.house_info, function(json) {
								if(json.code == 0) {
									showMsg('已经无效');
								}
							});
						}
					} else {
						if(confirm("确认申请房源无效？")) {
							API.invokeModuleCall(g_host_url,'houseinfo','applyInvalidHouse', this.house_info, function(json) {
								if(json.code == 0) {
									showMsg('申请已提交');
								}
							});
						}
					}
					
				},
				formatDate:function(value) {
				  function add0(m) {
					return m<10?'0'+m:m;
				  }
				  
				  var time = new Date(parseInt(value)*1000);
				  var y = time.getFullYear();
				  var m = time.getMonth() +1;
				  var d = time.getDate();
				  
				  //var h = time.getHours();
				  //var minute = time.getMinutes();
				  return add0(y)+"/"+add0(m)+"/"+add0(d);
				},
				selCommunity:function(community) {
					this.curr_community_id = community.community_id;
					var that = this;
					this.curr_community_name = community.name;
					API.invokeModuleCall(g_host_url,'house','queryCommunityInfo', community, function(json) {
						that.building_blocks = json.building_blocks;
						that.building_units = json.building_units;
					});
				},
				addHouseInfo:function() {
					var that = this;
					this.house_info_add.house_id = this.curr_house_id;
					API.invokeModuleCall(g_host_url,'houseinfo','addHouseInfo', this.house_info_add, function(json) {
						if(json.code == 0) {
							that.goStep(3);
						}
					});
				},
				addContacts:function() {
					if(this.house_info_add.contacts.length >= 2) {
						return;
					}
					this.house_info_add.contacts.push({
						name:'',
						wechat_num:'',
						mobile:'',
						telephone:'',
						more_contact:[]
					});
				},
				addOwnerContact:function() {
					if(this.house_info_add.owner.more_contact.length >= 3) {
						return;
					}
					this.house_info_add.owner.more_contact.push("");
				},
				goStep:function(step) {
					if(step == 2) {//判断第一步参数是否正确
						if(this.curr_house_id == -1) {
							alert('请选择房源');
							return;
						}
					}
					this.curr_step = step;
				},
				resolvePos:function() {
					var that = this;
					this.myGeo.getPoint(this.community_add.name, function(point){
						console.log(point);
						if (point) {
							that.community_add.lng = point.lng;
							that.community_add.lat = point.lat;
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							alert("您选择地址没有解析到结果!");
						}
					}, "北京市");
				},
				showPanel:function(val) {
					if(val == "add_community") {
						if(!this.curr_ta_id || this.curr_ta_id == 0) {
							alert('请选择商圈');
							return;
						}
					} else if(val == 'add_building_block') {
						if(!this.curr_community_id || this.curr_community_id == 0) {
							alert('请选择小区');
							return;
						}
					}
					this.show_panel = val;
				},
				showCreateAreaDlg:function() {
					this.show_create_area_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_area_dlg = false;
				},
				delArea:function(area) {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delArea", {area_id:area.area_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.areas.length; i++) {
								if(that.areas[i].area_id == area.area_id) {
									that.areas.splice(i,1);
								}
							}
							that.show_create_area_dlg = false;
						}
					});
				},
				addBulidingBlock:function() {
					var that = this;
					if(!this.curr_community_id || this.curr_community_id == 0) {
						alert('请选择小区');
						return;
					}
					
					this.building_block_add.community_id = this.curr_community_id;
					API.invokeModuleCall(g_host_url, "house", "addBuildingBlock", this.building_block_add, function(json) {
						if(json.code == 0) {
							that.building_blocks.push(json.building_block);
							that.show_panel = 'none';
						}
					});
				},
				addBulidingUnit:function() {
					var that = this;
					if(!this.curr_bb_id || this.curr_bb_id == 0) {
						alert('请选择栋座');
						return;
					}
					
					this.building_unit_add.bb_id = this.curr_bb_id;
					API.invokeModuleCall(g_host_url, "house", "addBuildingUnit", this.building_unit_add, function(json) {
						if(json.code == 0) {
							that.building_units = that.building_units.concat(json.building_units);
							that.show_panel = 'none';
						}
					});
				},
				addHouses:function() {
					var that = this;
					if(this.curr_bb_id <= 0) {
						alert('请选择栋座');
						return;
					}
					if(!this.curr_bu_id || this.curr_bu_id <= 0) {
						alert('请选择单元');
						return;
					}
					
					if(this.curr_floor <= -10) {
						alert('请输入楼层');
						return;
					}
					this.house_add.floor = this.curr_floor;
					this.house_add.bu_id = this.curr_bu_id;
					API.invokeModuleCall(g_host_url, "house", "addHouses", this.house_add, function(json) {
						if(json.code == 0) {
							that.houses = that.houses.concat(json.houses);
							that.show_panel = 'none';
						}
					});
				},
				addCommunity:function() {
					var that = this;
					if(this.curr_ta_id == 0) {
						alert('请选择商圈');
						return;
					}
					
					this.community_add.ta_id = this.curr_ta_id;
					API.invokeModuleCall(g_host_url, "house", "addCommmunity", this.community_add, function(json) {
						if(json.code == 0) {
							that.communities.push(json.community);
							that.show_panel = 'none';
						}
					});
				},
				onClickAdd:function() {
					
				}
			}
		})
	});
</script>
<script>
	$(function(){
		<?php if($employee['type'] > 0 || $employee['role'] > 1 || ($employee['role'] == 1 && $employee['team_creator'] == 1)) { ?>
		$('.availability-span-t').popover({html: true, trigger: 'click'});
		$('.availability-span-d').popover({html: true, trigger: 'click'});
		<?php } ?>
		$('.panel-right-er').mouseover(function(){
			$('.panel-right-d-er').show();
		});
		$('.panel-right-er').mouseout(function(){
			$('.panel-right-d-er').hide();
		});
		
		$(".hour-sf").click(function(){
			$(".hour-j").show();
		})		
	})
	
</script>
</html>