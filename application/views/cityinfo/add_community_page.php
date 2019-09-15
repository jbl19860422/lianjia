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
	<link href="../../../static/css/base.css?v=1" rel="stylesheet">
	<link href="../../../static/css/cityinfo.css" rel="stylesheet">
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
	</style>
</head>
<body>
<div class="mask">
</div>
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
			<li class="active"><a href="cityinfo/community_page">小区</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				城市信息管理-添加小区
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">小区录入</p>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<fieldset>
						<legend>小区信息</legend>
						<div class="form-group">
							<label class="col-sm-2 text-right">区域选择：</label>
							<div class="col-sm-2">
								<select v-model="curr_area_id" class="form-control" style="width:auto;display:inline;min-width:200px;">
									<option v-for="area in areas" v-html="area.name" :value="area.area_id"></option>
								</select>
							</div>
							<label class="col-sm-2 text-right">商圈选择：</label>
							<div class="col-sm-2">
								<select v-model="curr_ta_id" class="form-control" style="width:auto;display:inline;min-width:200px;">
									<option v-for="trade_area in trade_areas" v-html="trade_area.name" :value="trade_area.ta_id" v-if="trade_area.area_id==curr_area_id"></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 text-right">小区名称：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.name"></input>
							</div>
							<div class="col-sm-2">
								<span class="cityinfo-btn" @click="resolvePos()"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;地图定位</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-md-offset-2">
								<div id="map-community"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 text-right">经度：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.lat">
							</div>
							<label class="col-sm-2 text-right">纬度：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.lng">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 text-right">检索信息：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control"  v-model="community_add.retriving_info">
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>地铁信息<span style="float:right;margin-top:-5px;" class="btn btn-small btn-success" @click="addStation()">添加临近站</span></legend>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-10">
								<div class="form-group">
									<label style="display:inline">临近站点：</label>
									<ul class="subway-station-list area-list">
										<li :class="{btn:true, 'btn-warning':true, 'fl-l':true}" v-for="(subway_station,index) in stations" style="margin-right:20px;margin-left:0px">
											{{subway_station.name+'('+subway_station.distance+'米)'}}
											<div class="del-btn" @click="delSubwayStation(index)">x</div>
										</li>
										<div style="clear:both"></div>
									</ul>
								</div>
								<div class="form-group" v-show="show_add_station" style="border-top:1px solid #e5e5e5;padding-top:20px;">
									<label style="display:inline">地铁线路选择：</label>
									<ul class="subway-list area-list">
										<li :class="{btn:true,'fl-l':true,'btn-primary':true,active:curr_subway_id==subway.subway_id}"  style="margin-right:20px;margin-left:0px" v-for="subway in subways" @click="onSelSubway(subway)">
											{{subway.name}}
										</li>
										<div style="clear:both"></div>
									</ul>
									<label style="display:inline" v-show="curr_subway_id!=0">地铁站选择：</label>
									<ul class="subway-station-list area-list">
										<li :class="{btn:true, 'btn-info':true, 'fl-l':true,active:curr_station_id==subway_station.ss_id}" v-for="subway_station in subway_stations" v-if="subway_station.subway_id==curr_subway_id"  style="margin-right:20px;margin-left:0px" @click="selStation(subway_station)">
											{{subway_station.name}}
										</li>
										<div style="clear:both"></div>
									</ul>
									<label style="display:inline">距离：</label>
									<div style="position:relative">
										<input class="form-control col-sm-8" style="width:30%" v-model="distance"></input>
										<div style="position:absolute;left:calc(30% - 22px);top:10px;color:#e5e5e5">米</div>
									</div>
									<div style="clear:both"></div>
									<div style="width:50%;margin-left:auto;margin-right:auto;margin-top:20px">
										<div class="btn btn-success" style="width:30%;margin-left:auto;margin-right:auto;margin-top:20px" @click="addNearbyStation()">添加</div>
										<div class="btn btn-warning" style="width:30%;margin-left:auto;margin-right:auto;margin-top:20px" @click="cancelAddStation()">取消</div>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>学区信息</legend>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-10">
								<div class="col-sm-12 input-group form-group" style="font-size: 1.5rem; font-weight: bolder;position:relative;">
									<input placeholder="请输入学校名称搜索" class="form-control" v-model="curr_school_name"> 
									<span class="input-group-addon" style="cursor: pointer;" @click="addSchool()">确认添加</span>
									<div style="background-color:#fff;left:100px;position:absolute;top:35px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;width:100%;z-index:100;" class="search-communities">
										<ul style="margin-bottom:0px">
											<li v-for="school in filter_schools" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="school.name" @click="selSchool(school)"></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<ul class="school-list col-sm-10">
								<school-item v-for="school in community_add.school_adds" :school="school" @del_school="delSchool"></school-item>
							</ul>
						</div>
					</fieldset>
					<fieldset>
						<legend>建筑信息</legend>
						<div class="form-group">
							<label class="col-sm-2 text-right">物业费：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control cityinfo-input" v-model="community_add.pm_fee"><div class="cityinfo-div-j">元/㎡</div></input>
							</div>
							<label class="col-sm-2 text-right">交易权属：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.transaction_ownership"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">产权年限：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.property_year"></input>
							</div>
							<label class="col-sm-2 text-right">房屋用途：</label>
							<div class="col-sm-3">
								<select class="form-control" v-model="community_add.usage">
									<option value="0">住宅</option>
									<option value="1">商业</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 text-right">建筑类型：</label>
							<div class="col-sm-3">
								<!--<input type="text" class="form-control" v-model="community_add.building_type"></input>-->
								<select class="form-control" v-model="community_add.building_type">
									<option value="0">板楼</option>
									<option value="1">塔楼</option>
									<option value="2">板塔结合</option>
									<option value="3">别墅</option>
									<option value="4">洋房</option>
								</select>
							</div>
							<label class="col-sm-2 text-right">嫌恶设施：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.bad_thing"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">梯户比例：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.lift_user_rate"></input>
							</div>
							
							<label class="col-sm-2 text-right">建成时间：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control build-time" placeholder="请选择建筑时间"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">开发商：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.developer"></input>
							</div>
							
							<label class="col-sm-2 text-right">物业公司：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.prop_company"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">容积率：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.plot_ratio"></input>
							</div>
							
							<label class="col-sm-2 text-right">绿化率：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.green_rate"></input>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<legend>生活信息</legend>
						<div class="form-group">
							<label class="col-sm-2 text-right">供暖类型：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.heat_type"></input>
							</div>
							<label class="col-sm-2 text-right">用电类型：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.electro_type"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">车位配比：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.car_rate"></input>
							</div>
							<label class="col-sm-2 text-right">停车服务费：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.car_manager_fee"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">供暖费用：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.heat_fee"></input>
							</div>
							<label class="col-sm-2 text-right">用水类型：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.water_use_type"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">地上停车位数：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.ground_car_park_count"></input>
							</div>
							<label class="col-sm-2 text-right">燃气费：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.gas_fee"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">是否有电梯：</label>
							<div class="col-sm-3">
								<select v-model="community_add.has_lift" class="form-control" style="display:inline;width:auto;min-width:200px">
									<option value="0">无</option>
									<option value="1">有</option>
								</select>
							</div>
							<label class="col-sm-2 text-right">是否有燃气：</label>
							<div class="col-sm-3">
								<select v-model="community_add.has_gas" class="form-control" style="display:inline;width:auto;min-width:200px">
									<option value="0">无</option>
									<option value="1">有</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">地下停车位数：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.underground_car_park_count"></input>
							</div>
							<label class="col-sm-2 text-right">是否有热水：</label>
							<div class="col-sm-3">
								<select v-model="community_add.has_hot_water" class="form-control" style="display:inline;width:auto;min-width:200px">
									<option value="0">无</option>
									<option value="1">有</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">热水费：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.hot_water_fee"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">是否有中水：</label>
							<div class="col-sm-3">
								<select v-model="community_add.has_warm_water" class="form-control" style="display:inline;width:auto;min-width:200px">
									<option value="0">无</option>
									<option value="1">有</option>
								</select>
							</div>
							<label class="col-sm-2 text-right">中水费：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.warm_water_fee"></input>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 text-right">小区幼儿园：</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" v-model="community_add.child_school_info"></input>
							</div>
						</div>
					</fieldset>
				</form>
				<div class="col-sm-6 col-md-offset-3">
					<span class="btn btn-success btn-rounded btn-big cityinfo-btn-t" @click="addCommunity()">添加</span>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dlg_add_label" :class="{hide:!show_add_label_dlg}" style="display:none;z-index:100001;position:fixed;top:0px;bottom:0px;left:0px;right:0px;">
		<div class="webbox-dlg-bg" style="width:100%;height:100%;z-index:100001;background-color:rgba(0,0,0,0.5)"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_add_label_dlg,'animate-hide':!show_add_label_dlg}" style="position:fixed;z-index:999999 !important;width:500px;height:400px;border-radius:15px !important;border:1px solid #ddd;left:50%;top:50%;margin-left:-400px;margin-top:-300px;background:#fff;padding:0px;">
			<div class="webbox-header" style="height:45px;border-bottom:1px solid #ddd;padding-bottom:5px;">
				<div class="webbox-title" style="margin-left:auto;margin-right:auto;padding-top:15px;padding-bottom:10px;text-align:center;font-size:2rem;">添加标签</div>
				<span style="position:absolute;top:10px;right:20px;cursor:pointer;font-size:3rem;font-weight:bold;line-height:1;color:#000;text-shadow:0 1px #fff;opacity:2;display:block" @click="onClickCancel()">×</span>
			</div>
			<div class="webbox-body" style="text-align:center;height:200px;width:100%;padding:20px;overflow-y:auto;">
				<div style="text-align:left;font-size:2rem;margin-top:1rem;">
					<span >标签名</span><input v-model="add_label_name"></input>
				</div>
			</div>
			<div class="webbox-btn" style="margin-top:20px;text-align:center;height:50px;width:100%;">
				<span style="background-color:#03d8a2;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer;" @click="onClickAddLabel()">确  定</span>
				
				<span style="background-color:#ccc;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer" @click="onClickCancel()">取  消</span>
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
		
		var schoolCom = Vue.component('school-item', {
			props:['school'],
			template:
			'<li>'+
				'<dl>'+
					'<dt>'+
						'<img :src="school.img"></img>'+
					'</dt>'+
					'<dd>'+
						'<h2 v-html="school.name"></h2>'+
						'<h3 v-html="school.position"></h3>'+
						'<p><span v-html="nature_str"></span>/<span v-html="num_limit_str"></span>/<span v-html="upgrade_method_str"></span></p>'+
					'</dd>'+
					'<div class="btn-area">'+
							'<div class="btn-area-s" @click="onDel()">删&nbsp;&nbsp;除</div>'+
						'</div>'+
				'</dl>'+
			'</li>',
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
				}
			},
			methods:{
				onDel:function() {
					this.$emit('del_school', this.school);
				}
			}
		});     
		
		g_page = new Vue({
			el:'#content_warp',
			data:{
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				
				curr_area_id:0,
				curr_ta_id:0,
				show_add_label_dlg:false,
				add_label_name:'',
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
				school_changed_by_user:false,
				curr_school_name:'',
				filter_schools:[],
				schools:<?=json_encode($schools)?>,
				show_add_station:false,
				curr_subway_id:0,
				curr_station_id:0,
				distance:0,
				subways:<?=json_encode($subways)?>,
				subway_stations:<?=json_encode($subway_stations)?>,
				community_add:{
					area_id:0,
					ta_id:0,
					pm_fee:0,
					lng:0,
					lat:0,
					name:'',
					transaction_ownership:'',
					property_year:0,
					usage:0,
					building_type:0,
					build_time:0,
					bad_thing:'',
					lift_user_rate:'',
					heat_type:'',
					heat_fee:'',
					electro_type:'',
					car_rate:'',
					car_manager_fee:'',
					water_use_type:'',
					ground_car_park_count:0,
					has_lift:0,
					has_gas:0,
					gas_fee:'',
					underground_car_park_count:0,
					hot_water_fee:'',
					school_info:'',
					has_warm_water:0,
					has_hot_water:0,
					warm_water_fee:'',
					child_school_info:'',
					retriving_info:'',
					school_adds:[],
					developer:'',
					plot_ratio:0,
					prop_company:'',
					green_rate:0
				},
				school_add:{},
				
				curr_station:{},
				station_ids:[],
				stations:[]
			},
			created:function() {
				for(var i = 0; i < this.schools.length; i++) {
					this.schools[i].retriving_info = makePy(this.schools[i].name).join("");
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_label").css("display",'');
	
				var that = this;
				this.map = new BMap.Map("map-community");  
				this.map.centerAndZoom('深圳',11); 
				this.map.enableScrollWheelZoom(true);
				this.map.disable3DBuilding();
				console.log(this.map);
				// 创建地址解析器实例
				this.myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				this.myGeo.getPoint(this.community_add.name, function(point){
					if (point) {
						console.log(point);
						that.map.centerAndZoom(point, 11);
						that.map.addOverlay(new BMap.Marker(point));
					}else{
						alert("您选择地址没有解析到结果!");
					}
				}, "深圳市");
				
				$(this.$el).find(".build-time").datetimepicker(
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
				"community_add.name":function(val) {
					var tmp = val.split(",");
					this.community_add.retriving_info = makePy(val);
				},
				curr_area_id:function(val) {
					this.curr_ta_id = 0;
				},
				curr_school_name:function(val) {
					this.filter_schools = [];
					if(this.school_changed_by_user) {
						this.school_changed_by_user = false;
						return;
					}
					
					if(val == "") {
						this.filter_schools = [];
						return;
					}
					
					console.log('aaa3');
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (true/*str.test(val)*/) {//是字母，则判断
						for(var i = 0; i < this.schools.length; i++) {
							if(this.schools[i].retriving_info) {
								if(this.schools[i].retriving_info.indexOf(val) >= 0 || this.schools[i].name.indexOf(val) >= 0) {
									this.filter_schools.push(this.schools[i]);
								}
							}
						}
					}
				}
			},
			methods:{
				addSchool:function() {
					if(!this.school_add.sc_id) {
						showMsg('请添加小学');
						return;
					}
					
					if(this.community_add.school_adds.length >= 3) {
						showMsg("最多3个学校");
						return;
					}
					this.community_add.school_adds.push(this.school_add);
				},
				selSchool:function(s) {
					this.school_add = s;
					this.curr_school_name = s.name;
					this.filter_schools = [];
					this.school_changed_by_user = true;
				},
				delSchool:function(school) {
					var that = this;
					for(var i = 0; i < this.community_add.school_adds.length; i++) {
						if(this.community_add.school_adds[i].sc_id == school.sc_id) {
							this.community_add.school_adds.splice(i,1);
							break;
						}
					}
				},
				cancelAddStation:function() {
					this.show_add_station = false;
				},
				addNearbyStation:function() {
					var s = this.curr_station;
					s.distance = this.distance;
					this.stations.push(s);
				},
				addStation:function() {
					this.show_add_station = true;
				},
				onSelSubway:function(subway) {
					this.curr_subway_id = subway.subway_id;
				},
				selStation:function(station) {
					this.curr_station_id = station.ss_id;
					this.curr_station = station;
				},
				delSubwayStation:function(index) {
					this.stations.splice(index,1);
				},
				resolvePos:function() {
					var that = this;
					var tmp = this.community_add.name.split(",");
					this.myGeo.getPoint(tmp, function(point){
						console.log(point);
						if (point) {
							that.community_add.lng = point.lng;
							that.community_add.lat = point.lat;
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							new BMap.LocalSearch(that.map, {
								renderOptions:{map: that.map},
								onSearchComplete:function(data) {
									var point = data.getPoi(0);
									if (point){//取第1个查询结果
										that.map.centerAndZoom(point, 11);
										that.community_add.lng = point.point.lng;
										that.community_add.lat = point.point.lat;
										
									} else {
										showMsg("您选择地址没有解析到结果!");
										//map.centerAndZoom(data.city);
										//_.showMaskDiv({htm:'在地图上解析地址时失败.'}); 
									}
								}
							}).search(tmp);
							
						}
					}, "深圳市");
				},
				addCommunity:function() {
					var that = this;
					if(this.curr_ta_id == 0) {
						showMsg('请选择商圈');
						return;
					}
					
					if($(".build-time").val() == '') {
						showMsg('请选择建筑时间');
						return;
					}
					
					var timestamp2 = Date.parse(new Date($(".build-time").val()));
					this.community_add.build_time = timestamp2 / 1000;
					
					this.community_add.area_id = this.curr_area_id;
					this.community_add.ta_id = this.curr_ta_id;
					
					if(this.community_add.name == '') {
						showMsg('小区名称为空');
						return;
					}
					
					API.invokeModuleCall(g_host_url,'cityinfo','addCommunity', {community:this.community_add,stations:this.stations}, function(json) {
						if(json.code == 0) {
							showMsg('添加成功！');
							history.back(-1);
						} else if(json.code == -10005) {
							showMsg('添加失败，已经存在小区！');
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