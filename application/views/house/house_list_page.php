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
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='房源库管理';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li  class="active"><a href="javascript:">房源列表</a></li>
			<li><a href="house/house_add_page">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-房源列表 
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
					<li :class="{btn:true,'fl-l':true,'btn-primary':true,active:curr_area_id==0}" v-html="'全部'" @click="curr_area_id=0"></li>
					<li :class="{btn:true,'fl-l':true,'btn-primary':true,active:area.area_id==curr_area_id}" v-for="area in areas" v-html="area.name" @click="curr_area_id= area.area_id"></li>
					<li style="clear:both"></li>
				</ul>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">小区列表</p>
			</div>
			<div class="panel-body"style="overflow: hidden;">
				<table class="content-table">
					<ul class="ul-top clearfix">
						<li class="li_x">序号</li>
						<li class="li_n">小区名称</li>
						<li class="li_q">所在区</li>
					</ul>
					<tbody id='content-t' style="padding-bottom:20px">
						<tr v-for="(community,index) in communities">
							<td class="td_x" v-html="index+1"></td>
							<td class="td_n"><a :href="'house/community_info_page?community_id='+community.community_id" v-html="community.name" class="house-list-a"></td>
							<td class="td_q" v-html="community.area?community.area.name:''"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-12" style="text-align:center">
				<ul class="pagination">
					<li :class="{disabled:pi<=1}"><a href="javascript:" @click="if(pi>1) {pi--;}">&laquo;</a></li>

					<li v-for="p in page_count"  :class='{active:p==pi}'><a href='javascript:' v-html='p' @click="pi=p"></a></li>

					<li :class="{disabled:pi>=page_count}"><a href="javascript:" @click="if(pi<page_count) {pi++;}">&raquo;</a></li>								
				</ul>
			</div>
			<!--
			<input type='hidden' id='current_page' />
			<input type='hidden' id='show_per_page' />
			<div id='page_navigation'></div>
			-->
		</div>

</div>
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	if($.cookie("hl_community_id")) {
		<?php
			if($_REQUEST['clearcache']){
				$clearcache=1;
			} else {
				$clearcache=0;
			}
		?>
		if(1) {
			$.cookie("hl_community_id",'');
		} else {
			location.href = "house/community_info_page?community_id=" + $.cookie("hl_community_id");
		}
	}
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
				curr_area_id:<?=$area_id?>,
				curr_ta_id:$.cookie("curr_ta_id"),
				curr_community_name:'',
				curr_community_id:$.cookie("curr_community_id"),
				curr_area:{},
				
				pi:<?=$pi?>,
				pc:<?=$pc?>,
				page_count:<?=$page_count?>,
				
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				communities:<?=json_encode($communities)?>,	
				loaded_cities:[],
			},
			watch:{
				curr_area_id:function() {
					location.href = "house/house_list_page?pi="+this.pi+"&pc="+this.pc+"&area_id="+this.curr_area_id;
				},
				pi:function() {
					location.href = "house/house_list_page?pi="+this.pi+"&pc="+this.pc+"&area_id="+this.curr_area_id;
				}
			},
			created:function() {
				for(var i = 0;i < this.communities.length; i++) {
					for(var j = 0; j < this.areas.length; j++) {
						if(parseInt(this.areas[j].area_id) == parseInt(this.communities[i].area_id)) {
							this.communities[i].area = this.areas[j];
							break;
						}
					}
				}
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
			methods:{
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