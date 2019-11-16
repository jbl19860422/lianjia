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
	<script src="static/js/common.js?v=2"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
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
		<?php $city_menu = 'community_page'?>
		<?php include dirname(__file__)."/city_menu.php"?>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				城市信息管理-小区管理 
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">片区选择列表</p>
			</div>
			<div class="panel-body">
				<ul class="area-list">
					<li :class="{btn:true,'btn-success':true,'fl-l':true,active:curr_area_id==0}" v-html="'全部'" @click="selArea(0)"></li>
					<li :class="{btn:true,'btn-success':true,'fl-l':true,active:area.area_id==curr_area_id}" v-for="area in areas" v-html="area.name" @click="selArea(area.area_id)"></li>
					<li style="clear:both"></li>
				</ul>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">小区列表</p>
				<div class="panel-r" @click="goAddCommunity()">
					<i class="fa fa-plus-square-o"></i>添加小区
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>序号</th>
							<th>小区名称</a></th>
							<th>所在商圈</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(community,index) in curr_communities">
							<td v-html="index+1"></td>
							<td><a :href="'house/community_info_page?community_id='+community.community_id" v-html="community.name" class="house-list-a"></td>
							<td v-html="community.trade_area?community.trade_area.name:''"></td>
							<td>
								<div class="btn-group">
									<a class="btn btn-success" v-if="community.locked==0" :href="'cityinfo/edit_community_page?community_id='+community.community_id">编辑</a>
									<a class="btn btn-danger" v-if="community.locked==0" href="javascript:" @click="delCommunity(community)">删除</a>
									<a class="btn btn-warning" href="javascript:" @click="lockCommunity(community,index)" v-if="community.locked==0"><i class="fa fa-unlock" ></i></a>
									<a class="btn btn-success" href="javascript:" @click="unlockCommunity(community,index)" v-if="community.locked==1"><i class="fa fa-lock"></i></a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
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
				curr_step:1,
				curr_city_time:0,
				curr_area_id:$.cookie("curr_area_id"),
				curr_ta_id:$.cookie("curr_ta_id"),
				curr_community_name:'',
				curr_community_id:$.cookie("curr_community_id"),
				curr_area:{},
			
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				communities:<?=json_encode($communities)?>,			
				loaded_cities:[],
			},
			computed:{
				curr_communities:function() {
					if(this.curr_area_id == 0) {
						var area_ids = [];
						for(var i = 0; i < this.areas.length; i++) {
							if(this.areas[i].city_id == this.curr_city_id) {
								area_ids.push(this.areas[i].area_id);
							}
						}
						
						console.log(area_ids);
						var trade_area_ids = [];
						for(var i = 0; i < this.trade_areas.length; i++) {
							for(var j = 0; j < area_ids.length; j++) {
								if(this.trade_areas[i].area_id == area_ids[j]) {
									trade_area_ids.push(this.trade_areas[i].ta_id);
									break;
								}
							}
						}
						
						var communities = [];
						for(var i = 0; i < this.communities.length; i++) {
							for(var j = 0; j < trade_area_ids.length; j++) {
								if(this.communities[i].ta_id == trade_area_ids[j]) {
									communities.push(this.communities[i]);
									break;
								}
							}
						}
						
						for(var i = 0; i < communities.length; i++) {
							for(var j = 0; j < this.trade_areas.length; j++) {
								if(communities[i].ta_id == this.trade_areas[j].ta_id) {
									communities[i].trade_area = this.trade_areas[j];
									for(var k = 0; k < this.areas.length; k++) {
										if(communities[i].trade_area.area_id == this.areas[k].area_id) {
											communities[i].area = this.areas[k];
											break;
										}
									}
									break;
								}
							}
						}
						console.log('communities=',communities);
						return communities;
					} else {
						var trade_area_ids = [];
						for(var i = 0; i < this.trade_areas.length; i++) {
							if(this.trade_areas[i].area_id == this.curr_area_id) {
								trade_area_ids.push(this.trade_areas[i].ta_id);
							}
						}
						
						console.log(trade_area_ids);
						var communities = [];
						for(var i = 0; i < this.communities.length; i++) {
							for(var j = 0; j < trade_area_ids.length; j++) {
								if(this.communities[i].ta_id == trade_area_ids[j]) {
									communities.push(this.communities[i]);
									break;
								}
							}
						}
						
						for(var i = 0; i < communities.length; i++) {
							for(var j = 0; j < this.trade_areas.length; j++) {
								if(communities[i].ta_id == this.trade_areas[j].ta_id) {
									communities[i].trade_area = this.trade_areas[j];
									for(var k = 0; k < this.areas.length; k++) {
										if(communities[i].trade_area.area_id == this.areas[k].area_id) {
											communities[i].area = this.areas[k];
											break;
										}
									}
									break;
								}
							}
						}
						return communities;
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
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
				curr_city_id:function(val) {
					$.cookie("curr_city_id", this.curr_city_id,{ expires: 7,path: '/'});
					this.curr_area_id = 0;
					var that = this;
					if($.inArray(val, this.loaded_cities) < 0) {//不存在，则加载这个城市的信息
						API.invokeModuleCall(g_host_url,'house','queryCityInfo', {city_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_cities.push(val);
								that.areas = that.areas.concat(json.areas);
								that.trade_areas = that.trade_areas.concat(json.trade_areas);
								that.communities = that.communities.concat(json.communities);
							}
						});
					}
				},
				curr_area_id:function(val) {
					var that = this;
				}
			},
			methods:{
				delCommunity:function(c) {
					if(!confirm('确认删除吗?')) {
						return;
					}
					var that = this;
					API.invokeModuleCall(g_host_url, 'cityinfo', 'delCommunity', {community_id:c.community_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.communities.length; i++) {
								if(that.communities[i].community_id == c.community_id) {
									that.communities.splice(i,1);
									break;
								}
							}
							that.$forceUpdate();
						}
					});
				},
				lockCommunity:function(c,index) {
					var that = this;
					API.invokeModuleCall(g_host_url, 'cityinfo', 'lockCommunity', {community_id:c.community_id}, function(json) {
						if(json.code == 0) {
							that.curr_communities[index].locked = 1;
							that.$forceUpdate();
						}
					});
				},
				unlockCommunity:function(c,index) {
					var that = this;
					API.invokeModuleCall(g_host_url, 'cityinfo', 'unlockCommunity', {community_id:c.community_id}, function(json) {
						if(json.code == 0) {
							that.curr_communities[index].locked = 0;
							that.$forceUpdate();
						}
					});
				},
				goAddCommunity:function() {
					window.open("cityinfo/add_community_page");
				},
				selArea:function(area_id) {
					this.curr_area_id = area_id;
				},
				onClickCancel:function() {
					this.show_create_area_dlg = false;
				}
			}
		})
	});
</script>
</html>