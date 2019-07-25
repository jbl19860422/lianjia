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
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/api.js?v=1"></script>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='城市信息管理';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="cityinfo/area_page">片区</a></li>
			<li><a href="cityinfo/school_page">学区</a></li>
			<li><a href="cityinfo/subway_page">地铁线路</a></li>
			<li><a href="cityinfo/trade_area_page">商圈</a></li>
			<li><a href="cityinfo/community_page">小区</a></li>
		</ul>
	</div>
	
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				城市信息管理-城市录入 
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">城市选择</p>
				<div class="panel-r" @click="showCreateCityDlg()">
					<i class="fa fa-plus-square-o"></i>添加城市
				</div>
			</div>
			<div class="panel-body">
				<dl class="city-dl">
					<dt>省份选择：</dt>
					<dd>
						<select class="city_select" v-model="curr_province_id">
							<option v-for="province in provinces" v-html="province.name" :value="province.province_id"></option>
						</select>
					</dd>
				</dl>
								
				<!--<div style="float:right">
					<div class="btn" @click="showCreateCityDlg()">添加城市</div>
				</div>-->
				<div style="clear:both"></div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">城市列表</p>
			</div>
			<div class="panel-body">
				<ul class="area-list">
					<li class="btn fl-l" v-for="city in cities" v-if="city.province_id==curr_province_id">
					{{city.name}}
					<div class="del-btn" @click="delCity(city)">x</div>
				</li>
				</ul>
			</div>
		</div>
		
		<div id="dlg_create_city" :class="{hide:!show_create_city_dlg}">
			<div class="webbox-dlg-bg"></div>
			<div :class="{'webbox-dlg':true,'animate-show':show_create_city_dlg,'animate-hide':!show_create_city_dlg}" id="webbox-dlg-div">
				<div class="webbox-header">
					<div class="webbox-title">添加城市</div>
					<span style="" @click="onClickCancel()">×</span>
				</div>
				<div class="webbox-body">
					<div class="webbox-body-div">
						<label class="col-sm-4">输入片区名:</label>
						 <div class="col-sm-7">
							<input type="text" class="form-control" v-model="add_city_names" placeholder="多个城市名用|分割"></input>
						</div>
					</div>
				</div>
				<div class="webbox-btn">
					<button class="determine-btn" @click="onClickAdd()">确  定</button>
					<button class="cancel-btn" @click="onClickCancel()">取  消</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_province_id:$.cookie().curr_province_id,
				provinces:<?=json_encode($provinces)?>,
				cities:<?=json_encode($cities)?>,
				show_create_city_dlg:false,
				add_city_names:"",
			},
			created:function() {
				if($.cookie().curr_province_id) {
					this.curr_province_id = $.cookie().curr_province_id;
				} else {
					this.curr_province_id = this.provinces[0].province_id;
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				curr_province_id:function(val) {
					$.cookie("curr_province_id", this.curr_province_id,{ expires: 7,path: '/'});
				}
			},
			methods:{
				showCreateCityDlg:function() {
					this.show_create_city_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_city_dlg = false;
				},
				delCity:function(city) {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delCity", {city_id:city.city_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.cities.length; i++) {
								if(that.cities[i].city_id == city.city_id) {
									that.cities.splice(i,1);
								}
							}
							that.show_create_city_dlg = false;
						}
					});
				},
				onClickAdd:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "addCities", {names:this.add_city_names,province_id:this.curr_province_id}, function(json) {
						if(json.code == 0) {
							that.cities = that.cities.concat(json.cities);
						}
					});
				}
			}
		})
	});
</script>
</html>