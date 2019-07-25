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
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	
	<link href="../../../static/css/availability.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=4"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	<style>
		.label {
			padding-left:8px;padding-top:3px;padding-right:8px;padding-bottom:3px;border:1px solid #999;color:#d1d1d1;border-radius:4px;
		}
		
		
		.label .close-btn {
			position:absolute;right:-10px;top:-10px;border-radius:100%;background:red;width:20px;height:20px;line-height:20px;color:#fff;cursor:pointer;
			display:none;
		}
		
		.label:hover .close-btn {
			display:block;
		}
		
		.search-communities li {
			cursor:pointer;
			margin-left:50px;
		}
		
		.search-communities li:hover {
			color:red;
		}
		
		.form-control {
			display:inline;
			width:auto;
		}

		span {
			font-size:inherit;
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
	</style>
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
			<li class="active"><a href="guest/buy_guest_add_page">买卖</a></li>
			<li><a href="javascript:">租赁</a></li>
		</ul>
	</div>
	
	<div class="pro-bar" style="margin-bottom:30px;margin-top:30px;">
		<div style="width:610px;height:80px;margin:auto;position:relative;">
			<div :class="{step:true,step1:true,active:curr_step==1}" @click="goStep(1)">
				<div>
				1
				</div>
				<p class="step-info">
				挑选房源
				</p>
			</div>
			<div class="line line1"></div>
			<div :class="{step:true,step2:true,active:curr_step==2}" @click="goStep(2)">
				<div>
				2
				</div>
				<p class="step-info">
				预约时间
				</p>
			</div>
			<div class="line line2"></div>
			<div :class="{step:true,step3:true,active:curr_step==3}">
				<div>
				3
				</div>
				<p class="step-info">
				提交成功
				</p>
			</div>
		</div>
	</div>
	
	<div v-show="curr_step==1">
		<div class="mg-c">
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<p class="panel-p">筛选条件</p>
				</div>
				<div class="panel-body" >
					<div class="col-sm-12 input-group form-group" style="font-size:1.5rem;font-weight:bolder;">
						<input class="form-control input-lg" placeholder="请输入楼盘名称或房源编号" v-model="search_cond.name"></input>
						<span class="input-group-addon" style="cursor:pointer;" @click="startSearch()">开始搜索</span>
					</div>
					
					<div class="col-sm-12 form-group" style="font-size:1.5rem;font-weight:bolder;padding:0px;">
						<label style="float:left;margin-top:5px;">筛选：</label>
						<span style="float:left;margin-top:5px;margin-left:10px;margin-right:10px;">价格</span>
						<div style="float:left;position:relative;width:80px">
							<input style="width:80px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.min_price"><span style="position:absolute;right:5px;z-index:100;top:5px;">元</span></input>
						</div>
						<span style="float:left;margin-top:5px;margin-left:10px;margin-right:10px;">-</span>
						<div style="float:left;position:relative;width:80px">
							<input style="width:80px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.max_price"><span style="position:absolute;right:5px;z-index:100;top:5px;">元</span></input>
						</div>

						<span style="float:left;margin-top:5px;margin-left:50px;margin-right:10px;">面积</span>
						<div style="float:left;position:relative;width:70px">
							<input style="width:70px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.min_area"><span style="position:absolute;right:5px;z-index:100;top:5px;">㎡</span></input>
						</div>
						<span style="float:left;margin-top:5px;margin-left:10px;margin-right:10px;">-</span>
						<div style="float:left;position:relative;width:70px">
							<input style="width:70px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.max_area"><span style="position:absolute;right:5px;z-index:100;top:5px;">㎡</span></input>
						</div>

						<span style="float:left;margin-top:5px;margin-left:50px;margin-right:10px;">居室</span>
						<div style="float:left;position:relative;width:90px">
							<select style="width:90px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.min_room">
								<option v-for="i in 20" :value="i" v-html="i"></option>
							</select>
						</div>
						<span style="float:left;margin-top:5px;margin-left:10px;margin-right:10px;">-</span>
						<div style="float:left;position:relative;width:90px">
							<select style="width:90px;position:relative;display:inline-block;padding-left:5px;border:1px solid #ddd;padding-top:5px;padding-bottom:5px;padding-right:20px;border-radius:3px;" v-model="search_cond.max_room">
								<option v-for="i in 20" :value="i" v-html="i"></option>
							</select>
						</div>
						<div style="float:left;margin-left:50px;">
							<span class="btn btn-success" @click="startSearch()">确定</span>
						</div>
					</div>
					<div class="col-sm-12 form-group" style="font-size:1.5rem;font-weight:bolder;padding:0px;">
						<label style="float:left;margin-top:5px;">已选条件：</label>
					</div>
				</div><!--panel-body-->
			</div><!--panel-default-->

			<div class="panel panel-default" style="float:left;width:70%;">
				<div class="panel-body" >
					<div class="form-group">
						<label style="margin-left:20px">您可能需要以下房源</label>
					</div>
					<ul>
						<li style="display:block;margin-bottom:30px;width:100%;" v-for="house in result_houses">
							<div style="float:left;">
								<img style="width:200px;height:150px" :src="house.house_img"></img>
							</div>
							<div style="float:left;margin-left:20px;display:flex;flex-direction:column;height:150px;">
								<label style="flex:1;font-size:2rem;font-weight:bolder;display:block;">{{house.community_name}}（{{house.house_info_id}}）</label>
								<div style="font-size:1.8rem;flex:1;">{{house.ta_name}}</div>
								<div style="font-size:1.8rem;flex:1;">
									<span>{{house.area}}㎡</span><span style="margin-left:20px;">{{house.room_count}}-{{house.hall_count}}-{{house.kitchen_count}}-{{house.toilet_count}}</span>
								</div>
								<div style="font-size:1.8rem;flex:1;width:100%;">
									<span>维护人：</span><span>{{house.maintain_employee_name}}</span>
								</div>
							</div>
							<div style="float:right;width:20px;display:flex;">
								<label class="checkbox-inline" style="cursor:pointer">
								  <input type="checkbox"  class="form-control" v-model="house.selected" style="width:20px;height:20px;cursor:pointer">
								</label>
							</div>
							<div style="clear:both"></div>
						</li>
					</ul>
				</div>
			</div>

			<div class="panel panel-default" style="float:left;width:27%;margin-left:3%">
				<div class="panel-body" >
					<div class="form-group">
						<label style="margin-left:10px">已选房源</label><span style="margin-left:10px" v-html="selected_house_num"></span><span>套</span>
					</div>

					<div class="form-group" style="display:flex;">
						<div class="btn btn-success" style="width:45%;" @click="goStep(2)">提交</div>
						<div class="btn btn-default" style="width:45%;margin-left:10%;" @click="history.back();">取消</div>
					</div>
				</div>
			</div>
		</div><!--mg-c-->
	</div><!--show-add-house-->

	<div v-show="curr_step==2">
		<div class="mg-c">
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<p class="panel-p">设置时间</p>
				</div>
				
				<div class="panel-body" >
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">约看日期：</span>
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">日期选择：</span>
						<input type="text" class="form-control" style="width:auto;display:inline;margin-right:20px;" id="ID_Datesel"></input>
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">开始时间：</span>
						<input type="text" class="form-control" style="width:auto;display:inline;" id="ID_startTime"></input>
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;margin-left:10px;">结束时间：</span>
						<input type="text" class="form-control" style="width:auto;display:inline;" id="ID_endTime"></input>
					</div>
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">约看房源：</span>
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">{{app_see.appsee_houses.length}}套</span>
						<!--<span class="btn btn-primary" @click="showAddHouse()">添加</span>-->
					</div>
					<div style="clear:both;"></div>
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;border-top:1px solid #eee;padding-top:10px;" v-show="false"> 
						<div style="position:relative">
							<label>小区名称：</label>
							<input class="form-control" v-model="curr_community_name"></input>
							<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:60px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;width:100%;z-index:100;" class="search-communities">
								<ul style="margin-bottom:0px">
									<li v-for="community in filter_communities" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="community.name" @click="selCommunity(community)"></li>
								</ul>
							</div>
							
						</div>
					</div>
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;border-bottom:1px solid #eee;padding-bottom:10px;" v-show="false">
						<label style="margin-left:10px">楼栋：</label>
						<select v-model="curr_bb_id" class="form-control" style="margin-right:10px">
							<option v-for="building_block in building_blocks" v-html="building_block.name" :value="building_block.bb_id"></option>
						</select>
						<label style="margin-left:10px">单元：</label>
						<select v-model="curr_bu_id" class="form-control">
							<option v-for="building_unit in building_units" v-html="building_unit.name" :value="building_unit.bu_id"></option>
						</select>
						<label style="margin-left:10px">楼层：</label>
						<select v-model="curr_floor" class="form-control" style="margin-right:10px">
							<option v-for="floor in floors" v-html="floor" :value="floor"></option>
						</select>
						<label style="margin-left:10px">房号：</label>
						<select v-model="curr_house_id" class="form-control">
							<option v-for="house in houses" v-html="house.name" :value="house.house_id"></option>
						</select>
					</div>
					<!--
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
						<div style="font-size:inherit;font-weight:inherit;margin-right:20px;"><label style="font-size: inherit; font-weight: inherit;vertical-align:top;margin-right:25px;">看房人称呼：</label><input class="form-control"  style="display:inline;width:auto" v-model="app_see.name"></input></div>
					</div>
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
						<div style="font-size:inherit;font-weight:inherit;margin-right:20px;"><label style="font-size: inherit; font-weight: inherit;vertical-align:top;margin-right:25px;">看房人电话：</label><input class="form-control" type="tel" style="display:inline;width:auto" v-model="app_see.mobile"></input></div>
					</div>
					-->
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
						<div style="font-size:inherit;font-weight:inherit;margin-right:20px;"><label style="font-size: inherit; font-weight: inherit;vertical-align:top;margin-right:20px;">其他要求：</label><textarea class="form-control" placeholder="请填其他要求" style="display:inline;width:80%;" v-model="app_see.other_require"></textarea></div>
					</div>
					<!--
					<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;position:relative;">
						<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">带看经纪人：</span>
						<input type="text" class="form-control" style="width:auto;display:inline;" placeholder="请输入姓名或系统号" v-model="take_employee_name"></input>
						<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:112px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;width:100%;z-index:100;" class="search-communities">
							<ul style="margin-bottom:0px">
								<li v-for="f in filter_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selTakeseeEmployee(f)"></li>
							</ul>
						</div>
					</div>
					-->
				</div>
			</div>
			
			<div class="col-sm-12" style="font-size:2.5rem;font-weight:bolder;text-align:center;">
				<span class="btn btn-success btn-rounded btn-big" style="width:50%;font-size:2rem;" @click="addAppSee()">确定预约</span>
			</div>
		</div><!--mg-c-->
	</div><!--show_add_house-->
	
	
</div><!--content-warp-->
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
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_step:1,
				filter_employees:[],
				employees:<?=json_encode($employees)?>,
				curr_community_name:'',
				curr_community_id:0,
				curr_bb_id:0,
				curr_bu_id:0,
				curr_house_id:0,
				show_add_house:true,
				houses:[],
				curr_floor:0,
				communities:<?=json_encode($communities)?>,
				filter_communities:[],
				building_blocks:[],
				building_units:[],
				take_employee_name:'',
				result_houses:[],
				app_see:{
					accompany_employee_id:0,
					start_time:'',
					end_time:'',
					guest_id:0,
					other_require:'',
					appsee_houses:[]
				},
				
				curr_building_block:{
					names:'',
					community_id:0,
					max_floor:0,
					min_floor:0,
				},
				guest:<?=json_encode($guest)?>,
				search_cond:{
					name:'',
					entrust_type:'<?=$guest['entrust_type']?>',
					min_price:'',
					max_price:'',
					min_area:'',
					max_area:'',
					min_room:'',
					max_room:''
				}
			},
			computed:{
				floors:function() {
					var f = [];
					for(var i = this.curr_building_block.min_floor; i < this.curr_building_block.max_floor; i++) {
						f.push(i);
					}
					return f;
				},
				selected_house_num:function() {
					var count = 0;
					for(var i = 0; i < this.result_houses.length; i++) {
						if(this.result_houses[i].selected) {
							count++;
						}
					}
					return count;
				}
			},
			watch:{
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
				take_employee_name:function(val) {
					this.filter_employees = [];
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
			},
			created:function() {
				for(var i = 0; i < this.employees.length; i++) {
					if(this.employees[i].name) {
						this.employees[i].retriving_info = makePy(this.employees[i].name).join("");
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_label").css("display",'');
				
				$(this.$el).find("#ID_startTime").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 1,
					minView: 0,
					maxView: 1,
					forceParse: 0,
					format: 'hh:ii'
				}); 
												
				$(this.$el).find("#ID_endTime").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 1,
					minView: 0,
					maxView: 1,
					forceParse: 0,
					format: 'hh:ii'
				});

				$(this.$el).find("#ID_Datesel").datetimepicker(
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
			methods:{
				goStep:function(val) {
					if(val == 1) {
						this.curr_step = 1;
					}
					
					if(val == 2) {
						if(this.selected_house_num <= 0) {
							showMsg('请选择约看房源');
							return;
						}
						
						this.app_see.appsee_houses = [];
						for(var i = 0;i < this.result_houses.length; i++) {
							if(this.result_houses[i].selected) {
								this.result_houses[i].agreed = 0;
								this.app_see.appsee_houses.push(this.result_houses[i]);
							}
						}
						
						this.curr_step = 2;
					}
				},
				startSearch:function() {
					var that = this;
					this.result_houses = [];
					API.invokeModuleCall(g_host_url, 'houseinfo','queryTakeSeeHouses', this.search_cond, function(json) {
						for(var i = 0; i < json.houses.length; i++) {
							json.houses[i].selected = false;
							json.houses[i].customer_attitude = 0;
							json.houses[i].house_type = 0;
						}
						that.result_houses = json.houses;
					});
				},
				hideAddHouse:function() {
					this.show_add_house = false;
				},
				showAddHouse:function() {
					this.show_add_house = true;
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
				selTakeseeEmployee:function(employee) {
					this.app_see.accompany_employee_id = employee.employee_id;
					this.take_employee_name = employee.name+'('+employee.work_no+')';
					this.filter_employees = [];
				},
				addTakeSeeHouse:function() {
					for(var i = 0;i < this.result_houses.length; i++) {
						if(this.result_houses[i].selected) {
							this.app_see.appsee_houses.push(this.result_houses[i]);
						}
					}
					this.show_add_house = false;
				},
				addAppSee:function() {
					var that = this;
					if($("#ID_Datesel").val() == '') {
						showMsg('请选择日期');
						return;
					}
					
					if($("#ID_startTime").val() == '') {
						showMsg('请选择开始日期');
						return;
					}
					
					if($("#ID_endTime").val() == '') {
						showMsg('请选择结束日期');
						return;
					}
					
					this.app_see.start_time =  $("#ID_Datesel").val()+' '+$("#ID_startTime").val();
					this.app_see.end_time =  $("#ID_Datesel").val()+' '+$("#ID_endTime").val();
					if(this.app_see.start_time == '') {
						showMsg("请填写开始时间");
						return;
					}
					
					if(this.app_see.end_time == '') {
						showMsg("请填写结束时间");
						return;
					}
					
					var that = this;
					this.app_see.guest_id = this.guest.guest_id;
					API.invokeModuleCall(g_host_url,'guest','addAppSee', this.app_see, function(json) {
						if(json.code == 0) {
							showMsg("添加成功！");
							history.back(-1);
						}
					});
				}
			}
		})
	});
</script>
<script>
	$(function(){
		$('.availability-span-t').popover({html: true, trigger: 'hover'});
		$('.availability-span-d').popover({html: true, trigger: 'hover'});
	})
	
</script>
</html>