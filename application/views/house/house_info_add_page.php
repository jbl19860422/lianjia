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
	</style>
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=2"></script>
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
			<?php $menu='房源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="cityinfo/city_page">房源列表</a></li>
			<li class="active"><a href="javascript:">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="mg-c" style="height:45px;line-height:45px;">
		<ul class="breadcrumb">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-添加房源
			</li>
		</ul>
	</div>
	<div class="mg-c">
	<div class="content1">
		<div class="row">
			<div class="fl-l">省份选择：</div>
			<div class="fl-l" style="margin-left:10px">
				<select v-model="curr_province_id">
					<option v-for="province in provinces" v-html="province.name" :value="province.province_id"></option>
				</select>
			</div>
			<div class="fl-l">城市选择：</div>
			<div class="fl-l" style="margin-left:10px">
				<select v-model="curr_city_id">
					<option v-for="city in cities" v-html="city.name" :value="city.city_id" v-if="city.province_id==curr_province_id"></option>
				</select>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	<div style="height:45px;line-height:45px;font-size:1.5rem;color:#999">
		添加房源
	</div>
	<div class="content2">
		<div class="row mg-top-20">
			<div class="fl-l" style="width:49%;height:100%;position:relative;">
				<div style="margin-top:20px">
					<span>小区:</span>
					<select v-model="curr_community_id">
						<option v-for="community in communities" v-if="community.ta_id == curr_ta_id" :value="community.community_id" v-html="community.name"></option>
					</select>
					<span class="btn" @click="showPanel('add_community')">创建小区</span>
				</div>
				<div style="margin-top:20px">
					<span>栋座:</span>
					<select v-model="curr_bb_id">
						<option v-for="building_block in building_blocks" v-if="building_block.community_id == curr_community_id" :value="building_block.bb_id" v-html="building_block.name"></option>
					</select>
					<span class="btn" @click="showPanel('add_building_block')">创建栋座</span>
				</div>
				<div style="margin-top:20px">
					<span>单元:</span>
					<select v-model="curr_bu_id">
						<option v-for="building_unit in building_units" v-if="building_unit.bb_id == curr_bb_id" :value="building_unit.bu_id" v-html="building_unit.name"></option>
					</select>
					<span class="btn" @click="showPanel('add_building_unit')">创建单元</span>
				</div>
				<div style="margin-top:20px">
					<span>楼层:</span>
					<select v-model="curr_floor">
						<option v-for="floor in floors" :value="floor" v-html="floor"></option>
					</select>
				</div>
				<div style="margin-top:20px">
					<span>门牌:</span>
					<input type="text" placeholder="请输入门牌，多个门牌用|分隔" v-model="house_add.names"></input>
					<span class="btn" @click="addHouses()">创建门牌</span>
				</div>
				<div style="margin-top:20px" class="house-list">
					<div v-for="house in houses" v-if="house.floor==curr_floor&&house.bu_id==curr_bu_id" class="btn fl-l" style="position:relative;margin-left:30px;margin-bottom:10px;">
						{{house.name}}
						<div class="del-btn" @click="delHouse(house)">x</div>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="fl-l" style="width:49%;height:100%;position:relative;">
				<div class="create_community" v-show="show_panel=='add_community'">
					<p><span>小区名称：</span><input type="text" v-model="community_add.name"></input><span class="btn" @click="resolvePos()">地图定位</span></p>
					<div id="map-community" style="width:200px;height:150px"></div>
					<p>
						<span>手动输入：</span>
						<span>经度：</span><input type="text" v-model="community_add.lat"></input>
						<span>纬度：</span><input type="text" v-model="community_add.lng"></input>
					</p>
					<p>
						<span>检索信息：</span><input type="text" v-model="community_add.retriving_info">
					</p>
					<p style="margin-top:50px">
						<span class="btn" style="margin-top:50px" @click="addCommunity()">确认添加</span>
					</p>
				</div>
				
				<div class="create_bb" v-show="show_panel=='add_building_block'">
					<p><span>栋座名称：</span><input type="text" v-model="building_block_add.name"></input></p>
					<p><span>最高楼层：</span><input type="text" v-model="building_block_add.max_floor"></input>
					<p><span>最低楼层：</span><input type="text" v-model="building_block_add.min_floor"></input>
					<p style="margin-top:50px">
						<span class="btn" style="margin-top:50px" @click="addBulidingBlock()">确认添加</span>
					</p>
				</div>
				
				<div class="create_bu" v-show="show_panel=='add_building_unit'">
					<p><span>单元名称：</span><input type="text" v-model="building_unit_add.names"></input></p>
					<p><span>是否电梯：</span><input type="check" v-model="building_unit_add.lift"></input></p>
					<p style="margin-top:50px">
						<span class="btn" style="margin-top:50px" @click="addBulidingUnit()">确认添加</span>
					</p>
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
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_province_id:$.cookie().curr_province_id,
				curr_city_id:$.cookie().curr_city_id,
				curr_area_id:$.cookie("curr_area_id"),
				curr_ta_id:$.cookie("curr_ta_id"),
				curr_community_id:$.cookie("curr_community_id"),
				curr_bb_id:-1,//$.cookie("curr_bb_id"),
				curr_bu_id:-1,//$.cookie("curr_bu_id"),
				curr_floor:-10,//$.cookie("curr_floor"),
				curr_house_id:$.cookie("curr_house_id"),
				curr_building_block:{
					names:'',
					community_id:0,
					max_floor:0,
					min_floor:0,
				},
				
				provinces:<?=json_encode($provinces)?>,
				cities:<?=json_encode($cities)?>,
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
				
				show_panel:'none',
				community_add:{
					name:'',
					imgs:[],
					lng:0.0,
					lat:0.0,
					ta_id:0,
					retriving_info:''
				},
				
				building_block_add:{
					community_id:0,
					min_floor:1,
					max_floor:1,
					name:''
				},
				building_unit_add:{
					names:'',
					lift:0,
					bb_id:0,
				},
				house_add:{
					names:'',
					floor:0,
					bu_id:0
				}
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
				if($.cookie().curr_province_id) {
					this.curr_province_id = $.cookie().curr_province_id;
				} else {
					this.curr_province_id = this.provinces[0].province_id;
				}
				
				if($.cookie().curr_city_id) {
					this.curr_city_id = $.cookie().curr_city_id
				} else {
					for(var i = 0; i < this.cities.length; i++) {
						if(this.cities[i].province_id == this.curr_province_id) {
							this.curr_city_id = this.cities[i].city_id;
							break;
						}
					}
				}
				
				if($.cookie().curr_area_id) {
					this.curr_area_id = $.cookie().curr_area_id;
				} else {
					for(var i = 0; i < this.areas.length; i++) {
						if(this.areas[i].city_id == this.curr_city_id) {
							this.curr_area_id = this.areas[i].area_id;
							break;
						}
					}
				}
				
				if($.cookie().curr_trade_area_id) {
					this.curr_trade_area_id = $.cookie().curr_trade_area_id;
				} else {
					for(var i = 0; i < this.trade_areas.length; i++) {
						if(this.trade_areas[i].ta_id == this.curr_trade_area_id) {
							this.curr_trade_area_id = this.trade_areas[i].ta_id;
							break;
						}
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
				
				var that = this;
				this.map = new BMap.Map("map-community");  
				this.map.centerAndZoom(new BMap.Point(116.4035,39.915),15); 
				this.map.enableScrollWheelZoom(true);
				this.map.disable3DBuilding();
				console.log(this.map);
				// 创建地址解析器实例
				this.myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				this.myGeo.getPoint(this.community_add.name, function(point){
					if (point) {
						console.log(point);
						that.map.centerAndZoom(point, 18);
						that.map.addOverlay(new BMap.Marker(point));
					}else{
						alert("您选择地址没有解析到结果!");
					}
				}, "北京市");
			},
			watch:{
				curr_province_id:function(val,old_val) {
					$.cookie("curr_province_id", this.curr_province_id,{ expires: 7,path: '/' });
					this.curr_city_id = 0;
					for(var i = 0; i < this.cities.length; i++) {
						if(this.cities[i].province_id == this.curr_province_id) {
							this.curr_city_id = this.cities[i].city_id;
							break;
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
					if($.inArray(val, this.loaded_build_blocks) < 0) {//不存在，则加载这个片区的小区及栋座信息
						API.invokeModuleCall(g_host_url,'house','queryBuildingUnits', {bb_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_build_blocks.push(val);
								that.building_units = that.building_units.concat(json.building_units);
								
								for(var i = 0; i < that.building_units.length; i++) {
									if(that.building_units[i].bb_id == val) {
										that.curr_bu_id = that.building_units[i].curr_bu_id;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < that.building_units.length; i++) {
							if(that.building_units[i].bb_id == val) {
								that.curr_bu_id = that.building_units[i].curr_bu_id;
							}
						}
					}
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
				curr_city_id:function(val) {
					$.cookie("curr_city_id", this.curr_city_id,{ expires: 7,path: '/'});
					this.curr_area_id = 0;
					for(var i = 0; i < this.areas.length; i++) {
						if(this.areas[i].area_id == this.curr_city_id) {
							this.curr_area_id = this.areas[i].area_id;
							break;
						}
					}
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