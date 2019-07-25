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
	<style>
		* {
			margin:0px;
			padding:0px;
		}
		
		a {
			text-decoration:none;
		}
		
		ul {
			list-style:none;
		}
		
		html {
			font-size:62.5%;
		}
		
		body {
			background-color:#f2f2f2;
		}
		
		.fl-l {
			float:left;
		}
		
		.fl-r {
			float:right;
		}
		
		.mg-c {
			margin-left:12.5%;
			margin-right:12.5%;
		}
		
		.header {
			height:50px;
			background:#2E313B;
		}
		
		.company-info {
			height:50px;
			line-height:50px;
			width:100px;
		}
		
		.company-info img {
			height:40px;
			width:auto;
			vertical-align: middle;
		}
		
		.header .menu {
			height:50px;
			line-height:50px;
			font-size:1.5rem;
		}
		
		.header  .menu li {
			float:left;
			cursor:pointer;
			padding-left:2rem;
			padding-right:2rem;
		}
		
		.header  .menu li.active {
			background-color:#f9f9f9;
		}
		.header .menu li a {
			color:#A5A5A5;
		}
		
		.header  .menu li:hover {
			background-color:#f9f9f9;
		}
		
		.user-info {
			
		}
		
		.submenu {
			height:40px;
			line-height:40px;
			background-color:#f9f9f9;
			font-size:1.4rem;
			padding-left:calc(12.5% + 100px);
			border-bottom:1px solid #dfdfdf;
		}
		
		.cityinfo-menus li {
			float:left;
			padding-left:2rem;
			padding-right:2rem;
		}
		
		.cityinfo-menus li.active a {
			color:blue;
		}
		
		.cityinfo-menus a {
			color:#A5A5A5;
		}
		
		.breadcrumb li {
			float:left;
			color:#A5A5A5;
			font-size:1.2rem;
		}
		
		.content1 {
			background-color:#fff;
			border:1px solid #d1d1d1;
			height:60px;
			border-radius:3px;
			padding-left:20px;
			padding-right:20px;
			padding-top:20px;
			font-size:1.3rem;
		}
		
		.content2 {
			background-color:#fff;
			border:1px solid #d1d1d1;
			min-height:300px;
			border-radius:3px;
			padding-left:20px;
			padding-right:20px;
			padding-top:20px;
			font-size:1.3rem;
		}
		
		.row {
			
		}
		
		.mg-top-20 {
			margin-top:20px;
		}
		.row:after {
			clear:both;
		}
		
		
		.area-list li{
			margin-left:20px;
			position:relative;
		}
		
		.area-list li .del-btn {
			display:none;
			position:absolute;
			right:-10px;
			top:-10px;
			width:20px;
			height:20px;
			border-radius:20px;
			text-align:center;
			line-height:20px;
			background-color:red;
		}
		
		.area-list li:hover .del-btn{
			display:block;
		}
		
		.house-list div .del-btn {
			display:none;
			position:absolute;
			right:-10px;
			top:-10px;
			width:20px;
			height:20px;
			border-radius:20px;
			text-align:center;
			line-height:20px;
			background-color:red;
		}
		
		.house-list div:hover .del-btn{
			display:block;
		}
		.hide {
			display:none;
		}
		
		.step {
			text-align:center;
			font-size:30px;
			color:#fff;
			width:70px;
			height:70px;
			font-weight:bold;
			border-radius:100%;
			line-height:70px;
			background:#F0F1F2;
			cursor:pointer;
			position:absolute;
		}
		
		.step div{
			font-size:30px;
			font-weight:bold;
			border-radius:100%;
			position:absolute;
			left:10px;
			top:10px;
			width:50px;
			color:#a0a1a2;
			height:50px;
			line-height:50px;
		}
		
		.step1 {
			left:0px;
		}
		
		.step2 {
			left:270px;
		}
		
		.step3 {
			left:540px;
		}
		
		.step.active div {
			background:#50ba7d;
			color:#fff;
		}
		
		.step-info {
			position: absolute;top: 80px;font-size: 1rem;color: #a0a1a2;width: 100%;text-align: center;
		}
		
		.active .step-info {
			color:#50ba7d
		}
		
		.search-communities li {
			cursor:pointer;
			margin-left:50px;
		}
		
		.search-communities li:hover {
			color:red;
		}
		
		.pro-bar .line {
			width:220px;
			background-color:#F0F1F2;
			position:absolute;
			height:15px;
		}
		
		.pro-bar .line1 {
			left:60px;
			top:28px;
		}
		
		.pro-bar .line2 {
			left:330px;
			top:28px;
		}
		
		.c-name:hover {
			background:#f9f9f9;
		}
	</style>
	<link href="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css?v=13" rel="stylesheet">
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
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
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
			<li><a href="houseinfo/house_info_list_page">房源列表</a></li>
			<li class="active"><a href="javascript:">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源-添加房源
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">添加房源</p>
			</div>
			<div class="panel-body" style="padding-right:150px">
				<div class="pro-bar">
					<div style="width:610px;height:80px;margin:auto;position:relative;">
						<div :class="{step:true,step1:true,active:curr_step==1}" @click="goStep(1)">
							<div>
							1
							</div>
							<p class="step-info">
							地址信息
							</p>
						</div>
						<div class="line line1"></div>
						<div :class="{step:true,step2:true,active:curr_step==2}" @click="goStep(2)">
							<div>
							2
							</div>
							<p class="step-info">
							房源信息
							</p>
						</div>
						<div class="line line2"></div>
						<div :class="{step:true,step3:true,active:curr_step==3}">
							<div>
							3
							</div>
							<p class="step-info">
							保存成功
							</p>
						</div>
					</div>
				</div>
				
				<form class="form-horizontal" role="form" style="margin-top:50px;margin-left:8%;" v-show="curr_step==1">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">委托类型：</label>
						</div>
						<div class="col-sm-6 form-group" style="display:flex">
							<label class="radio-inline" style="padding:0px;flex:1;font-weight:bold;">
								<input type="radio" name="entrust_type" id="optionsRadios3" value="1" checked @click="setEntrustTye(1)">出售</input>
							</label>
							<label class="radio-inline" style="padding:0px;flex:1;font-weight:bold;">
								<input type="radio" name="entrust_type" id="optionsRadios3" value="2" @click="setEntrustTye(2)">出租</input>
							</label>
							<!--
							<label class="radio-inline" style="padding:0px;flex:1;font-weight:bold;">
								<input type="radio" name="entrust_type" id="optionsRadios3" value="3" @click="setEntrustTye(3)">租售</input>
							</label>
							-->
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">楼盘名称：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<input type="text" class="form-control" v-model="curr_community_name"></input>
							<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;width:100%;z-index:100;" class="search-communities">
								<ul style="margin-bottom:0px">
									<li v-for="community in filter_communities" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="community.name" @click="selCommunity(community)"></li>
								</ul>
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">栋&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="curr_bb_id" class="form-control">
								<option v-for="building_block in building_blocks" v-html="building_block.name" :value="building_block.bb_id"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;元：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="curr_bu_id" class="form-control">
								<option v-for="building_unit in building_units" v-if="building_unit.bb_id==curr_bb_id" v-html="building_unit.name" :value="building_unit.bu_id"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;层：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="curr_floor" class="form-control">
								<option v-for="floor in floors" v-html="floor" :value="floor"></option>
							</select>
						</div>
					</div>
				
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">门&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;牌：</label>
						</div>
						<div class="col-sm-8 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="curr_house_id" class="form-control">
								<option v-for="house in houses" v-html="house.name" :value="house.house_id" v-if="house.floor==curr_floor"></option>
							</select>
						</div>
						<div class="col-sm-2 form-group" style="text-align:center">
							<label style="color:red" v-html="house_exist"></label>
						</div>
					</div>
					<div class="form-group">
						<div class="btn btn-success" style="margin-left:auto;margin-right:auto;width:60%;display:block;" @click="goStep(2)">下一步</div>
					</div>
				</form>
				
				<form class="form-horizontal" role="form" style="margin-top:50px;margin-left:8%;" v-show="curr_step==2">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</label>
						</div>
						<div class="col-sm-10" style="display:flex">
							<div class="form-group" style="padding-left: 0px; margin-left: -43px; margin-top: -8px; position: relative; padding-right: 0px;">
								<select v-model="house_info_add.room_count" class="form-control" style="display:inline;width:auto">
									<option v-for="c in rooms" :value="c" v-html="c"></option>
								</select>
								<span>室</span>
								<select v-model="house_info_add.hall_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
									<option v-for="c in halls" :value="c" v-html="c"></option>
								</select>
								<span>厅</span>
								<select v-model="house_info_add.kitchen_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
									<option v-for="c in kitchens" :value="c" v-html="c"></option>
								</select>
								<span>厨</span>
								<select v-model="house_info_add.toilet_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
									<option v-for="c in toilets" :value="c" v-html="c"></option>
								</select>
								<span>卫</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积：</label>
						</div>
						<div class="col-sm-8" style="display: flex; padding-left: 0px; margin-left: -30px; margin-top: -8px; position: relative; padding-right: 0px;">
							<input type="text" class="form-control" v-model="house_info_add.area" style="display:inline;width:auto"></input><span>㎡</span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：</label>
						</div>
						<div class="col-sm-8 checkbox" style="display: flex; padding-left: 0px; margin-left: -30px; margin-top: -8px; position: relative; padding-right: 0px;">
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="e" @click="onClickOrientation('_e')">东</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="es" @click="onClickOrientation('es')">东南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="s" @click="onClickOrientation('_s')">南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="ws" @click="onClickOrientation('ws')">西南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="w" @click="onClickOrientation('_w')">西</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="wn" @click="onClickOrientation('wn')">西北</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="n" @click="onClickOrientation('_n')">北</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="en" @click="onClickOrientation('en')">东北</input>
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name" v-show="house_info_add.entrust_type==1">售&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</label>
							<label for="name" v-show="house_info_add.entrust_type==2">租&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</label>
						</div>
						<div class="col-sm-8" style="display: flex; padding-left: 0px; margin-left: -30px; margin-top: -8px; position: relative; padding-right: 0px;">
							<input type="tel" class="form-control" v-model="house_info_add.price" style="display:inline;width:auto"></input><label style="margin-left:5px;margin-top:8px" v-html="house_info_add.entrust_type==1?'万':'元/月'">万</label>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">看房时间：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="house_info_add.openhome_time" class="form-control">
								<option v-for="(openhome_time,index) in openhome_times" v-html="openhome_time" :value="index+1"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">委托来源：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="house_info_add.entrust_src1"  class="form-control">
								<option v-for="(entrust_src1,index) in entrust_srcs" v-html="entrust_src1.name" :value="index+1"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group" style="margin-bottom:0px">
						<div class="col-sm-2">
							<label for="name">选择维护人：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<input type="text" class="form-control" v-model="curr_maintainer_name"></input>
							<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;width:100%;z-index:100;" class="search-communities" v-show="!change_by_user">
								<ul style="margin-bottom:0px">
									<li v-for="f in filter_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selMaintainer(f)"></li>
								</ul>
							</div>
						</div>
					</div>
					
					<div class="form-group step1">
						<div class="col-sm-2">
							<label for="name">业主姓名：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_add.owner.name"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">业主微信：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_add.owner.wechat_num"></input>
						</div>
						<div style="clear:left"></div>
						
						<div class="col-sm-2">
							<label for="name">业主手机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_add.owner.mobile"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">业主座机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_add.owner.telephone"></input>
						</div>
						<div class="col-sm-2">
							<a href="javascript:" @click="addOwnerContact()">添加联系方式</a>
						</div>
						<div style="clear:both"></div>
					</div>
					<div class="form-group" v-for="(c,index) in house_info_add.owner.more_contact" style="margin-bottom:0px">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<input type="text" class="form-control" style="width:auto;display:inline;margin-right:10px;" v-model="house_info_add.owner.more_contact[index]" placeholder="请输入联系方式"></input><label style="margin-right:30px;line-height:32px;cursor:pointer;color:#FF6863" @click="delMoreContact(index)">删除</label>
						</div>
					</div>
					<div class="form-group" style="margin-bottom:0px">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<a href="javascript:" @click="addContacts()">添加联系人</a>
						</div>
					</div>
					
					<div class="form-group step1" v-for="(contact,index) in house_info_add.contacts">
						<div class="col-sm-2">
							<label for="name">联系人姓名：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;margin-right:10px;">
							<input type="text" class="form-control" v-model="contact.name"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">联系人微信：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="contact.wechat_num"></input>
						</div>
						<div style="clear:left"></div>
						
						<div class="col-sm-2">
							<label for="name">联系人手机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="contact.mobile"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">联系人座机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="contact.telephone"></input>
						</div>
						<div class="col-sm-2">
							<a href="javascript:" @click="delContact(index)">删除</a>
						</div>
						<div style="clear:both"></div>
					</div>
					<div class="form-group">
						<div class="btn btn-success" style="margin-left:auto;margin-right:auto;width:60%;display:block;" @click="addHouseInfo()">保存</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="mask" v-show="show_mask"></div>
</div>
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				show_mask:false,
				rooms:[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
				halls:[0,1,2,3,4,5,6,7,8,9,10],
				kitchens:[0,1,2,3,4,5],
				toilets:[0,1,2,3,4,5,6,7,8,9,10],
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
				house_exist:'',
				curr_step:1,
				curr_city_time:0,
				curr_area_id:$.cookie("curr_area_id"),
				curr_ta_id:$.cookie("curr_ta_id"),
				curr_community_name:'',
				curr_community_id:$.cookie("curr_community_id"),
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
				
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				communities:<?=json_encode($communities)?>,
				filter_communities:[],
				building_blocks:[],
				building_units:[],
				houses:[],
				employees:<?=json_encode($employees)?>,
				
				loaded_trade_areas:[],
				loaded_communities:[],
				loaded_build_blocks:[],
				loaded_build_units:[],
				
				curr_maintainer_name:'',
				change_by_user:false,
				filter_employees:[],
				house_info_add:{
					area_id:0,
					house_id:0,
					room_count:1,
					hall_count:1,
					top_floor:0,
					kitchen_count:1,
					community_id:0,
					community_name:'',
					toilet_count:1,
					bb_id:0,
					build_block:'',
					bu_id:0,
					floor:0,
					entrust_type:1,
					area:-1,
					price:1,
					orientation:'',
					openhome_time:1,
					entrust_src1:1,
					entrust_src2:1,
					owner:{
						name:'',
						wechat_num:'',
						mobile:'',
						telephone:'',
						more_contact:[],
					},
					maintain_employee_id:0,
					contacts:[//每个contacts和owner结构一样
					]
				}
			},
			computed:{
				floors:function() {
					var f = [];
					for(var i = parseInt(this.curr_building_block.min_floor); i <= parseInt(this.curr_building_block.max_floor); i++) {
						if(i != 0) {
							f.push(i);
						}
					}
					return f;
				}
			},
			created:function() {
				for(var i = 0; i < this.employees.length; i++) {
					if(this.employees[i].name) {
						this.employees[i].retriving_info = makePy(this.employees[i].name).join("");
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				'house_info_add.price':function(val) {
					if('' != (this.house_info_add.price+'').replace(/\d{1,}\.{0,1}\d{0,}/,'')) {
						this.house_info_add.price = this.house_info_add.price.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :this.house_info_add.price.match(/\d{1,}\.{0,1}\d{0,}/);
					}
				},
				curr_house_id:function(val) {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'houseDealing', {house_id:this.curr_house_id}, function(json) {
						if(json.code == 0) {
							if(json.house_info) {
								if(parseInt(json.house_info.info_complete) == 0) {
									that.house_exist = '此房源信息不全';
								} else {
									that.house_exist = '此房源已存在';
								}
							} else {
								that.house_exist = '';
							}
						} else {
							that.house_exist = '';
						}
					});
				},
				curr_community_name:function(val) {
					this.filter_communities = [];
					if(val == "") {
						this.filter_communities = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (/*str.test(val)*/true) {//是字母，则判断
						for(var i = 0; i < this.communities.length; i++) {
							if(this.communities[i].retriving_info) {
								if(this.communities[i].retriving_info.indexOf(val) >= 0 || this.communities[i].name.indexOf(val) >= 0) {
									this.filter_communities.push(this.communities[i]);
								}
							}
						}
					}
				},
				curr_maintainer_name:function(val) {
					console.log('change_by_user='+this.change_by_user);
					this.filter_employees = [];
					if(this.change_by_user) {
						this.change_by_user = false;
						console.log('true return');
						this.$forceUpdate();
						return;
					}
					
					if(val == "") {
						this.filter_employees = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (true/*str.test(val)*/) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(val) >= 0 || this.employees[i].name.indexOf(val) >= 0) {
									this.filter_employees.push(this.employees[i]);
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
					this.house_info_add.bb_id = val;
					for(var i = 0; i < this.building_blocks.length; i++) {
						if(this.building_blocks[i].bb_id == this.curr_bb_id) {
							this.curr_building_block.name = this.building_blocks[i].name;
							this.curr_building_block.community_id = this.building_blocks[i].community_id;
							this.curr_building_block.min_floor = this.building_blocks[i].min_floor;
							this.curr_building_block.max_floor = this.building_blocks[i].max_floor;
							this.house_info_add.build_block = this.building_blocks[i].name;
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
					this.house_info_add.bu_id = val;
					API.invokeModuleCall(g_host_url,'house','queryHouses', {bu_id:val}, function(json) {
						if(json.code == 0) {
							that.houses = json.houses;
						}
					});
				},
				"community_add.name":function(val) {
					this.community_add.retriving_info = makePy(val);
				}
			},
			methods:{
				selMaintainer:function(employee) {
					this.change_by_user = true;
					this.house_info_add.maintain_employee_id = employee.employee_id;
					this.curr_maintainer_name = employee.name+'('+employee.work_no+')';
					this.filter_employees = [];
				},
				delMoreContact:function(index) {
					this.house_info_add.owner.more_contact.splice(index,1);
				},
				delContact:function(index) {
					this.house_info_add.contacts.splice(index,1);
				},
				setEntrustTye:function(t) {
					this.house_info_add.entrust_type = t;
				},
				onClickOrientation:function(o) {
					var s = this.house_info_add.orientation.split("|");
					var find = false;
					for(var i = 0; i < s.length; i++) {
						if(s[i] == o) {
							find = true;
							s.splice(i,1);
							this.house_info_add.orientation = s.join("|");
							$(this.$el).attr('checked',false);
							return;
						}
					}
					
					if(!find) {
						$(this.$el).attr('checked',true);
						s.push(o);
						this.house_info_add.orientation = s.join("|");
					}
				},
				selCommunity:function(community) {
					this.curr_community_id = community.community_id;
					this.house_info_add.community_id = this.curr_community_id;
					var that = this;
					this.curr_community_name = community.name;
					API.invokeModuleCall(g_host_url,'house','queryCommunityInfo', community, function(json) {
						that.building_blocks = json.building_blocks;
						that.building_units = json.building_units;
						that.filter_communities = [];
					});
				},
				addHouseInfo:function() {
					var that = this;
					this.house_info_add.floor = this.curr_floor;
					this.house_info_add.house_id = this.curr_house_id;
					if(parseInt(this.curr_building_block.max_floor) == this.house_info_add.floor) {
						this.house_info_add.top_floor = 1;
					} else {
						this.house_info_add.top_floor = 0;
					}
					
					for(var i = 0; i < this.communities.length; i++) {
						if(this.communities[i].community_id == this.curr_community_id) {
							this.house_info_add.area_id = this.communities[i].area_id;
							break;
						}
					}
					
					this.house_info_add.max_floor = this.curr_building_block.max_floor;
					this.show_mask = true;
					API.invokeModuleCall(g_host_url,'houseinfo','addHouseInfo', this.house_info_add, function(json) {
						if(json.code == 0) {
							that.goStep(3);
							location.href = "houseinfo/house_info_detail_page?house_info_id="+json.house_info.house_info_id;
						}
						that.show_mask = false;
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
					if(this.house_info_add.owner.more_contact.length >= 2) {
						return;
					}
					this.house_info_add.owner.more_contact.push("");
				},
				goStep:function(step) {
					if(this.curr_step == 3) {
						return;
					}
					if(step == 2) {//判断第一步参数是否正确
						if(this.curr_house_id == -1) {
							showMsg('请选择房源');
							return;
						}
						
						var that = this;
						API.invokeModuleCall(g_host_url, 'houseinfo', 'houseDealing', {house_id:this.curr_house_id}, function(json) {
							if(json.code == 0) {
								if(json.house_info) {
									if(json.house_info.info_complete == 1) {
										if(json.house_info.entrust_type == 1) {
											showMsg('房源已经在售');
										} else if(json.house_info.entrust_type == 2) {
											showMsg('房源已经在租');
										} else {
											that.curr_step = step;
										}
									} else {
										showMsg('已经添加该房源');
										if(confirm('该房源已存在，信息不全，前往修改？')) {
											location.href = "houseinfo/house_info_edit_page?house_info_id="+json.house_info.house_info_id;
										}
									}
								} else {
									that.curr_step = step;
								}
							} else {
								that.curr_step = step;
							}
						});
					}
					
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
					if(this.curr_city_id == 0) {
						alert('请选择城市');
						return;
					}
					this.show_create_area_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_area_dlg = false;
				}
			}
		})
	});
</script>
</html>