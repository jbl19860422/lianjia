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
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
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
		<?php $city_menu = 'subway_page'?>
		<?php include dirname(__file__)."/city_menu.php"?>
	</div>
	
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				城市信息管理-地铁/地铁站管理 
			</li>
		</ul>
	</div>
	
	<div class="mg-c">		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">线路列表</p>
				<?php if($_SESSION['employee']['type'] != ADMIN_TYPE_NONE) { ?>
				<div class="panel-r" @click="showCreateSubwayDlg()">
					<i class="fa fa-plus-square-o"></i>添加线路
				</div>
				<?php } ?>
			</div>
			<div class="panel-body">
				<ul class="subway-list area-list">
					<li :class="{btn:true,'fl-l':true,'btn-primary':true,active:curr_subway_id==subway.subway_id}" v-for="subway in subways" @click="onSelSubway(subway)">
						{{subway.name}}
						<div class="del-btn" @click="delSubway(subway)">x</div>
					</li>
					<div style="clear:both"></div>
				</ul>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">站点列表</p>
				<div class="panel-r" @click="showAddSubwayStationDlg()">
					<i class="fa fa-plus-square-o"></i>添加地铁站点
				</div>
			</div>
			
			<div class="panel-body" v-show="!show_add_subway_station">
				<ul class="subway-station-list area-list">
					<li :class="{btn:true, 'btn-info':true, 'fl-l':true}" v-for="subway_station in subway_stations" v-if="subway_station.subway_id==curr_subway_id">
						{{subway_station.name}}
						<div class="del-btn" @click="delSubwayStation(subway_station)">x</div>
					</li>
					<div style="clear:both"></div>
				</ul>
			</div>
			
			<div class="panel-body" v-show="show_add_subway_station">
				<div class="col-sm-5 subway-map" id="map-subwaystation-pos"></div>
				<div class="school-w col-sm-6">
					<form class="form-horizontal">
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">地铁站名称：</label>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" v-model="subway_station_add.name">
						    </div>
						    <div class="col-sm-2">
						    	<div class="btn btn-success" @click="resolvePos()"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;定位</div>
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">经度：</label>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" v-model="subway_station_add.lat">
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">纬度：</label>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" v-model="subway_station_add.lng">
						    </div>
						</div>
					</form>
				</div>
				
				<div style="clear:both"></div>
				<div class="school-btn">
					<span @click="onClickAddSubwayStation()">确认添加</span>
					<span @click="onClickCancel()">取消</span>
				</div>
				
			</div>
		</div>
		
		<div id="dlg_create_subway" :class="{hide:!show_create_subway_dlg}">
			<div class="webbox-dlg-bg"></div>
			<div :class="{'webbox-dlg':true}" id="webbox-dlg-div">
				<div class="webbox-header">
					<div class="webbox-title">添加地铁线路</div>
					<span style="" @click="onClickCancel()">×</span>
				</div>
				<div class="webbox-body">
					<div class="webbox-body-div">
						<label class="col-sm-4">输入片区名:</label>
						 <div class="col-sm-7">
							<input type="text" class="form-control" v-model="add_subway_names" placeholder="多个地铁线路用|分隔"></input>
						</div>
					</div>
				</div>
				<div class="webbox-btn">
					<button class="determine-btn" @click="onClickAddSubway()">确  定</button>
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
		
		var schoolCom = Vue.component('school-item', {
			props:['school'],
			template:
			'<li style="float:left;position:relative;width:380px;height:150px;border:1px solid #ddd;border-radius:4px;">'+
				'<div style="padding:10px">'+
					'<div style="float:left;width:130px;height:130px;">'+
						'<img :src="school.img" style="width:100%;height:100%"></img>'+
					'</div>'+
					'<div style="float:left;margin-left:10px;width:200px;height:130px;">'+
						'<h2 v-html="school.name"></h2>'+
						'<p style="text-overflow:ellipsis;overflow: hidden;white-space: nowrap;" v-html="school.position"></p>'+
						'<p><span v-html="nature_str"></span>/<span v-html="num_limit_str"></span>/<span v-html="upgrade_method_str"></span></p>'+
						'<div class="btn-area">'+
							'<div class="btn-area-s" style="" @click="onDel()">删&nbsp;&nbsp;除</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
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
				show_create_subway_dlg:false,
				show_add_subway_station:false,
				subway_station_add:{
					name:'',
					subway_id:0,
					lat:0.0,
					lng:0.0,
					position:''
				},
				curr_subway_id:0,
				
				areas:<?=json_encode($areas)?>,
				schools:<?=json_encode($schools)?>,
				subways:<?=json_encode($subways)?>,
				subway_stations:<?=json_encode($subway_stations)?>,
				add_subway_names:"",
			},
			created:function() {
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_subway").css("display",'');
				
				var that = this;
				this.map = new BMap.Map("map-subwaystation-pos");  
				this.map.centerAndZoom('深圳市',15); 
				this.map.enableScrollWheelZoom(true);
				this.map.disable3DBuilding();
				console.log(this.map);
				// 创建地址解析器实例
				this.myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				this.myGeo.getPoint(this.subway_station_add.name, function(point){
					if (point) {
						console.log(point);
						that.map.centerAndZoom(point, 18);
						that.map.addOverlay(new BMap.Marker(point));
					}else{
						new BMap.LocalSearch(that.map, {
							renderOptions:{map: that.map},
							onSearchComplete:function(data) {
								var point = data.getPoi(0);
								if (point){//取第1个查询结果
									that.map.centerAndZoom(point, 11);
									
								} else {
									showMsg("您选择地址没有解析到结果!");
									//map.centerAndZoom(data.city);
									//_.showMaskDiv({htm:'在地图上解析地址时失败.'}); 
								}
							}
						}).search(that.community_add.name);
					}
				}, "深圳市");
			},
			methods:{
				delSchool:function(school) {
					var that = this;
					for(var i = 0; i < this.schools.length; i++) {
						if(this.schools[i].sc_id == school.sc_id) {
							API.invokeModuleCall(g_host_url,'cityinfo','delSchool', school, function(json) {
								if(json.code == 0) {
									that.schools.splice(i,1);
								}
							});
							break;
						}
					}
				},
				resolvePos:function() {
					var that = this;
					this.myGeo.getPoint(this.subway_station_add.name, function(point){
						console.log(point);
						if (point) {
							that.subway_station_add.lng = point.lng;
							that.subway_station_add.lat = point.lat;
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							new BMap.LocalSearch(that.map, {
								renderOptions:{map: that.map},
								onSearchComplete:function(data) {
									var point = data.getPoi(0);
									if (point){//取第1个查询结果
										that.map.centerAndZoom(point, 11);
										that.subway_station_add.lng = point.point.lng;
										that.subway_station_add.lat = point.point.lat;
									} else {
										showMsg("您选择地址没有解析到结果!");
										//map.centerAndZoom(data.city);
										//_.showMaskDiv({htm:'在地图上解析地址时失败.'}); 
									}
								}
							}).search(that.subway_station_add.name);
						}
					}, "深圳市");
				},
				showCreateSubwayDlg:function() {
					if(this.curr_city_id == 0) {
						alert('请选择城市');
						return;
					}
					this.show_create_subway_dlg = true;
				},
				showAddSubwayStationDlg:function() {
					if(this.curr_subway_id == 0) {
						alert('请先选择地铁线路');
						return;
					}
					this.show_add_subway_station = true;
				},
				onClickCancel:function() {
					this.show_create_subway_dlg = false;
				},
				onSelSubway:function(subway) {
					this.curr_subway_id = subway.subway_id;
				},
				delSubway:function(subway) {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delSubway", {subway_id:subway.subway_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.subways.length; i++) {
								if(that.subways[i].subway_id == subway.subway_id) {
									that.subways.splice(i,1);
								}
							}
							that.show_create_subway_dlg = false;
						}
					});
				},
				delSubwayStation:function(subway_station) {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delSubwayStation", subway_station, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.subway_stations.length; i++) {
								if(that.subway_stations[i].ss_id == subway_station.ss_id) {
									that.subway_stations.splice(i,1);
								}
							}
						}
					});
				},
				onClickAddSubwayStation:function() {
					var that = this;
					if(this.subway_station_add.name == '') {
						alert('请输入添加线路名称');
						return;
					}
					
					this.subway_station_add.subway_id = this.curr_subway_id;
					API.invokeModuleCall(g_host_url, "cityinfo", "addSubwayStation", this.subway_station_add, function(json) {
						if(json.code == 0) {
							that.show_add_subway_station = false;
							that.subway_stations.push(json.subway_station);
						}
					});
				},
				onClickAddSubway:function() {
					var that = this;
					if(this.add_subway_names == '') {
						alert('请输入添加线路名称');
						return;
					}
					API.invokeModuleCall(g_host_url, "cityinfo", "addSubway", {names:this.add_subway_names}, function(json) {
						if(json.code == 0) {
							that.show_create_subway_dlg = false;
							that.subways = that.subways.concat(json.subways);
						}
					});
				}
			}
		})
	});
</script>
</html>