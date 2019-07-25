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
			<?php $menu='团队管理';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<!--<li><a href="team/approval_user_page">用户审核</a></li>-->
			<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_A) { ?>
			<li class="active"><a href="team/approval_user_page">用户审核</a></li>
			<li><a href="team/employee_list_page">员工列表</a></li>
			<li><a href="team/admin_manager_page">管理员</a></li>
			<?php } ?>
			<li><a href="javascript:">团队</a></li>
			<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_A) { ?>
			<li><a href="team/batch_typing_manager_page">批量录入人员</a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				团队管理-员工列表 
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
			员工列表
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<div class="col-sm-12">
					<div class="col-sm-1 all-col all-col-z"><label>序号</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>手机号</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>姓名</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>昵称</label></div>
					<div class="col-sm-1 all-col all-col-z"><label>头像</label></div>
					<div class="col-sm-1 all-col all-col-z"><label>性别</label></div>
					<div class="col-sm-1 all-col all-col-z"><label>注册时间</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>操作</label></div>
				</div>
			</div>
			<div class="panel-body">
				<div v-for="(employee,index) in employees" class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">
					<div class="col-sm-1" v-html="index+1"></div>
					<div class="col-sm-2" v-html="employee.mobile"></div>
					<div class="col-sm-2" v-html="employee.name"></div>
					<div class="col-sm-2" v-html="employee.nickname"></div>
					<div class="col-sm-1"><img :src="employee.headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>
					<div class="col-sm-1" v-html="employee.sex=='m'?'男':'女'"></div>
					<div class="col-sm-1">{{employee.reg_time|formatTime}}</div>
					<div class="col-sm-2"><span class="btn btn-primary" @click="approvalOk(employee)">审核通过</span></div>
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
				employees:<?=json_encode($employees)?>
			},
			created:function() {
				// for(var i = 0;i < this.employees.length; i++) {
				// 	var province = '';
				// 	for(var j = 0; j < this.provinces.length; j++) {
				// 		if(this.provinces[j].province_id == this.employees[i].province_id) {
				// 			province = this.provinces[j].name;
				// 		}
				// 	}
					
				// 	var city = '';
				// 	for(var j = 0; j < this.cities.length; j++) {
				// 		if(this.cities[j].city_id == this.employees[i].city_id) {
				// 			city = this.cities[j].name;
				// 		}
				// 	}
				// 	this.employees[i].position = province+"-"+city;
				// }
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			methods:{
				approvalOk:function(employee) {
					var that = this;
					API.invokeModuleCall(g_host_url,'team','approvalUser', employee, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.employees.length; i++) {
								if(that.employees[i].employee_id == employee.employee_id) {
									that.employees.splice(i,1);
								}
							}
						}
					});
				}
			}
		})
	});
</script>
</html>