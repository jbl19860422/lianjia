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
		
		.btn {
			padding:10px 20px;
			background:blue;
			border-radius:4px;
			color:#fff;
			cursor:pointer;
		}
		
		.btn:hover {
			
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
				房源-修改房源信息
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">修改房源信息</p>
			</div>
			<div class="panel-body" style="padding-right:150px">				
				<form class="form-horizontal" role="form" style="margin-top:20px;margin-left:3%;">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</label>
						</div>
						<div class="col-sm-10" style="display:flex">
							<div class="form-group" style="padding-left: 0px; margin-left: -43px; margin-top: -8px; position: relative; padding-right: 0px;">
								<select v-model="house_info_edit.room_count" class="form-control" style="display:inline;width:auto">
									<option v-for="c in rooms" :value="c" v-html="c"></option>
								</select>
								<span>室</span>
								<select v-model="house_info_edit.hall_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
									<option v-for="c in halls" :value="c" v-html="c"></option>
								</select>
								<span>厅</span>
								<select v-model="house_info_edit.kitchen_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
									<option v-for="c in kitchens" :value="c" v-html="c"></option>
								</select>
								<span>厨</span>
								<select v-model="house_info_edit.toilet_count" class="form-control" style="display:inline;width:auto;margin-left:10px;">
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
							<input type="text" class="form-control" v-model="house_info_edit.area" style="display:inline;width:auto"></input><span>㎡</span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：</label>
						</div>
						<div class="col-sm-8 checkbox" style="display: flex; padding-left: 0px; margin-left: -30px; margin-top: -8px; position: relative; padding-right: 0px;" class="orientation">
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="e" @click="onClickOrientation('e')">东</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="es" @click="onClickOrientation('es')">东南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="s" @click="onClickOrientation('s')">南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="ws" @click="onClickOrientation('ws')">西南</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="w" @click="onClickOrientation('w')">西</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="wn" @click="onClickOrientation('wn')">西北</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="n" @click="onClickOrientation('n')">北</input>
							</label>
							
							<label style="margin-left:10px;pointer:cursor;">
							  <input type="checkbox" value="en" @click="onClickOrientation('en')">东北</input>
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">售&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</label>
						</div>
						<div class="col-sm-8" style="display: flex; padding-left: 0px; margin-left: -30px; margin-top: -8px; position: relative; padding-right: 0px;">
							<input type="tel" class="form-control" v-model="house_info_edit.price" style="display:inline;width:auto"></input><label style="margin-left:5px;margin-top:8px">万</label>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">看房时间：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="house_info_edit.openhome_time" class="form-control">
								<option v-for="(openhome_time,index) in openhome_times" v-html="openhome_time" :value="index+1"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name">委托来源：</label>
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<select v-model="house_info_edit.entrust_src1"  class="form-control">
								<option v-for="(entrust_src1,index) in entrust_srcs" v-html="entrust_src1.name" :value="index+1"></option>
							</select>
						</div>
					</div>
					<!--
					<div class="form-group" style="margin-bottom:0px">
						<div class="col-sm-2">
							<label for="name">选择出租维护人：</label>
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
					-->
					<div class="form-group step1">
						<div class="col-sm-2">
							<label for="name">业主姓名：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_edit.owner.name"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">业主微信：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_edit.owner.wechat_num"></input>
						</div>
						<div style="clear:left"></div>
						
						<div class="col-sm-2">
							<label for="name">业主手机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_edit.owner.mobile"></input>
						</div>
						<div class="col-sm-2"></div>
						
						<div class="col-sm-2">
							<label for="name">业主座机：</label>
						</div>
						<div class="col-sm-2 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;;margin-right:10px;">
							<input type="text" class="form-control" v-model="house_info_edit.owner.telephone"></input>
						</div>
						<div class="col-sm-2">
							<a href="javascript:" @click="addOwnerContact()">添加联系方式</a>
						</div>
						<div style="clear:both"></div>
					</div>
					<div class="form-group" v-for="(c,index) in house_info_edit.owner.more_contact" style="margin-bottom:0px">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<input type="text" class="form-control" style="width:auto;display:inline;margin-right:10px;" v-model="house_info_edit.owner.more_contact[index]" placeholder="请输入联系方式"></input><label style="margin-right:30px;line-height:32px;cursor:pointer;color:#FF6863" @click="delMoreContact(index)">删除</label>
						</div>
					</div>
					<div class="form-group" style="margin-bottom:0px">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;margin-left:-30px;margin-top:-8px;position:relative;padding-right:0px;">
							<a href="javascript:" @click="addContacts()">添加联系人</a>
						</div>
					</div>
					
					<div class="form-group step1" v-for="(contact,index) in house_info_edit.contacts">
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
						<div class="btn" style="width:100px;margin:auto;display:block;" @click="editHouseInfo()">保存</div>
					</div>
				</form>
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
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
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
				house_info_edit:<?=json_encode($house_info)?>
			},
			computed:{
				floors:function() {
					var f = [];
					for(var i = this.curr_building_block.min_floor; i < this.curr_building_block.max_floor; i++) {
						f.push(i);
					}
					return f;
				}
			},
			created:function() {
				/*
				for(var i = 0; i < this.employees.length; i++) {
					this.employees[i].retriving_info = makePy(this.employees[i].name).join("");
				}
				*/
				this.house_info_edit.owner = JSON.parse(this.house_info_edit.owner);
				if(!this.house_info_edit.owner.more_contact) {
					this.house_info_edit.owner.more_contact = [];
				}
				this.house_info_edit.orientation = this.house_info_edit.orientation.split("|");
				this.house_info_edit.contacts = JSON.parse(this.house_info_edit.contacts);
				if(!this.house_info_edit.contacts) {
					this.house_info_edit.contacts = [];
				}
			},
			mounted:function() {
				$(this.$el).find("dlg_edit_level").css("display",'');
				console.log(this.house_info_edit.orientation);
				for(var i = 0; i < this.house_info_edit.orientation.length; i++) {
					console.log(this.house_info_edit.orientation[i],$(this.$el).find("input[value='"+this.house_info_edit.orientation[i]+"']"));
					$(this.$el).find("input[value='"+this.house_info_edit.orientation[i]+"']").prop("checked",true);
				}
			},
			watch:{
				'house_info_edit.price':function(val) {
					if('' != (this.house_info_edit.price+'').replace(/\d{1,}\.{0,1}\d{0,}/,'')) {
						this.house_info_edit.price = this.house_info_edit.price.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :this.house_info_edit.price.match(/\d{1,}\.{0,1}\d{0,}/);
					}
				},
				curr_community_name:function(val) {
					this.filter_communities = [];
					if(val == "") {
						this.filter_communities = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (str.test(val)) {//是字母，则判断
						for(var i = 0; i < this.communities.length; i++) {
							if(this.communities[i].retriving_info) {
								if(this.communities[i].retriving_info.indexOf(val) >= 0) {
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
					if (str.test(val)) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(val) >= 0) {
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
					this.house_info_edit.bb_id = val;
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
					this.house_info_edit.bu_id = val;
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
				selMaintainer:function(employee) {
					this.change_by_user = true;
					this.house_info_edit.maintain_employee_id = employee.employee_id;
					this.curr_maintainer_name = employee.name+'('+employee.work_no+')';
					this.filter_employees = [];
				},
				delMoreContact:function(index) {
					this.house_info_edit.owner.more_contact.splice(index,1);
					this.$forceUpdate();
				},
				delContact:function(index) {
					this.house_info_edit.contacts.splice(index,1);
				},
				setEntrustTye:function(t) {
					this.house_info_edit.entrust_type = t;
				},
				onClickOrientation:function(o) {
					var find = false;
					for(var i = 0; i < this.house_info_edit.orientation.length; i++) {
						if(this.house_info_edit.orientation[i] == o) {
							find = true;
							this.house_info_edit.orientation.splice(i,1);
							$(this.$el).attr('checked',false);
							return;
						}
					}
					
					if(!find) {
						$(this.$el).attr('checked',true);
						this.house_info_edit.orientation.push(o);
					}
				},
				selCommunity:function(community) {
					this.curr_community_id = community.community_id;
					this.house_info_edit.community_id = this.curr_community_id;
					var that = this;
					this.curr_community_name = community.name;
					API.invokeModuleCall(g_host_url,'house','queryCommunityInfo', community, function(json) {
						that.building_blocks = json.building_blocks;
						that.building_units = json.building_units;
					});
				},
				editHouseInfo:function() {
					var that = this;
					this.house_info_edit.orientation = this.house_info_edit.orientation.join("|");
					this.house_info_edit.floor = this.curr_floor;
					this.house_info_edit.house_id = this.curr_house_id;
					API.invokeModuleCall(g_host_url,'houseinfo','editHouseInfo', this.house_info_edit, function(json) {
						if(json.code == 0) {
							location.href = "houseinfo/house_info_detail_page?house_info_id="+that.house_info_edit.house_info_id;
						}
					});
				},
				addContacts:function() {
					if(this.house_info_edit.contacts.length >= 2) {
						return;
					}
					this.house_info_edit.contacts.push({
						name:'',
						wechat_num:'',
						mobile:'',
						telephone:'',
						more_contact:[]
					});
				},
				addOwnerContact:function() {
					if(this.house_info_edit.owner.more_contact.length >= 2) {
						return;
					}
					this.house_info_edit.owner.more_contact.push("");
					this.$forceUpdate();
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
					if(this.curr_city_id == 0) {
						alert('请选择城市');
						return;
					}
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
</html>