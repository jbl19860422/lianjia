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
	<script src="static/js/common.js?v=2"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<style>
		td {
			height:50px;
			line-height:50px;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus" style="padding-left:0px;">
			<li><a href="user/user_center_page">基本信息</a></li>
			<li class="active"><a href="javascript:">我的团队</a></li>
			<li><a href="javascript:">我的业绩</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				个人中心-我的团队 
			</li>
		</ul>
		<div class="btn btn-primary pull-right" style="margin-top:10px" @click="show_dlg_add_team=true"><i class="icon icon-plus"></i>申请创建团队</div>
	</div>
	<div class="mg-c" v-if="my_team" style="margin-top:20px">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">我创建的团队({{my_team.team_name}})-团员列表</p>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>序号</th>
							<th>手机号</th>
							<th>姓名</th>
							<th>头像</th>
							<th>性别</th>
							<th>注册时间</th>
							<th>维护小区</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(employee,index) in my_team.employees">
							<td v-html="index+1"></td>
							<td v-html="employee.mobile"></td>
							<td v-html="employee.name"></td>
							<td><img :src="employee.headimg" style="width:50px;height:50px"></img></td>
							<td v-html="employee.sex=='m'?'男':'女'"></td>
							<td>{{employee.reg_time|formatTime}}</td>
							<td>{{employee.maintain_communities}}</td>
							<td><span class="btn btn-danger" @click="addMaintainArea(employee)">删除</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!--创建团队--->
	<div id="dlg_add_team" :class="{hide:!show_dlg_add_team}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">申请创建团队</label>
			</div>
			<div class="" style="margin-top:10px">
				<input class="form-control" placeholder="请输入团队名称" v-model="team_add.name"></input>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="addTeam()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_add_team=false">取消</div>
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
	
	Vue.filter("formatTime", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
      function add0(m) {
      	return m<10?'0'+m:m;
      }
      
      var time = new Date(parseInt(value)*1000);
      var y = time.getFullYear();
      var m = time.getMonth() +1;
      var d = time.getDate();
      
      var h = time.getHours();
      var minute = time.getMinutes();
      return y+"/"+m+"/"+d+" "+h+":"+minute;
    });
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				show_dlg_add_team:false,
				team_add:{
					name:''
				},
				my_team:<?=json_encode($my_team)?>,
				trade_employee:<?=json_encode($trade_employee)?>
			},
			created:function() {

			},
			mounted:function() {
				$(this.$el).find("#dlg_add_team").css("display",'');
			},
			methods:{
				addTeam:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'user','addTeam', this.team_add,function(json) {
						that.show_dlg_add_team = false;
					});
				}
			}
		})
	});
</script>
</html>