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
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=4"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
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
			<li class="active"><a href="javascript:">片区</a></li>
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
				城市信息管理-片区录入 
			</li>
		</ul>
	</div>
	<div class="mg-c">		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">片区列表</p>
				<div class="panel-r" @click="showCreateAreaDlg()">
					<i class="fa fa-plus-square-o"></i>添加片区
				</div>
			</div>
			<div class="panel-body">
				<ul class="area-list">
					<li class="btn btn-primary fl-l" v-for="area in areas">
						{{area.name}}
						<div class="del-btn" @click="delArea(area)">x</div>
					</li>
				</ul>
			</div>
		</div>
	
		<div id="dlg_create_city" :class="{hide:!show_create_area_dlg}">
			<div class="webbox-dlg-bg"></div>
			<div :class="{'webbox-dlg':true,'animate-show':show_create_area_dlg,'animate-hide':!show_create_area_dlg}" id="webbox-dlg-div">
				<div class="webbox-header">
					<div class="webbox-title">添加片区</div>
					<span style="" @click="onClickCancel()">×</span>
				</div>
				<div class="webbox-body">
					<div class="webbox-body-div">
						<label class="col-sm-4">输入片区名:</label>
						 <div class="col-sm-7">
							<input type="text" class="form-control" v-model="add_area_names" placeholder="多个片区名用|分割"></input>
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
				areas:<?=json_encode($areas)?>,
				show_create_area_dlg:false,
				add_area_names:"",
			},
			created:function() {
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			methods:{
				showCreateAreaDlg:function() {
					this.show_create_area_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_area_dlg = false;
				},
				delArea:function(area) {
					if(!confirm("请谨慎操作，确认删除片区？")) {
						return;
					}
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delArea", {area_id:area.area_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.areas.length; i++) {
								if(that.areas[i].area_id == area.area_id) {
									that.areas.splice(i,1);
								}
							}
							that.show_create_area_dlg = false;
						} else if(json.code == -10004) {
							showMsg('不能删除有社区房源');
						}
					});
				},
				onClickAdd:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "addArea", {names:this.add_area_names}, function(json) {
						if(json.code == 0) {
							that.areas = that.areas.concat(json.areas);
							that.show_create_area_dlg = false;
						}
					});
				}
			}
		})
	});
</script>
</html>