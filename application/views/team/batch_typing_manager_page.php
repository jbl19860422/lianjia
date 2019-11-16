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
			<li><a href="team/approval_user_page">用户审核</a></li>
			<li><a href="team/employee_list_page">员工列表</a></li>
			<li><a href="team/admin_manager_page">管理员</a></li>
			<?php } ?>
			<li><a href="javascript:">团队</a></li>
			<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_A) { ?>
			<li class="active"><a href="team/batch_typing_manager_page">批量录入人员</a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				团队管理-批量录入人员 
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">批量录入人员列表</p>
				<div class="panel-r" @click="$('#b_list').slideToggle();$('#b_add').slideToggle();">
					<i class="fa fa-plus-square-o"></i>添加批量录入人员
				</div>
			</div>
			<div class="panel-body" id="b_list">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>序号</th>
							<th>手机号</th>
							<th>姓名</th>
							<th>头像</th>
							<th>性别</th>
							<th>注册时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(employee,index) in b_employees" v-if="index>=(curr_page_index-1)*10&&index<=curr_page_index*10">
							<td v-html="index+1"></td>
							<td v-html="employee.mobile"></td>
							<td v-html="employee.name"></td>
							<td><img :src="employee.headimg" style="width:50px;height:50px"></img></td>
							<td v-html="employee.sex=='m'?'男':'女'"></td>
							<td>{{employee.reg_time|formatTime}}</td>
							<td><span class="btn btn-danger" @click="delBEmployee(employee)">删除</span></td>
						</tr>
					</tbody>
				</table>
				<div style="text-align:center">
					<ul class="pagination" >
					  <li><a href="#">&laquo;</a></li>
					  <li><a href="#">1</a></li>
					  <li><a href="#">&raquo;</a></li>
					</ul>
				</div>
			</div>
			
			<div class="panel-body" id="b_add" style="display:none">
				<form>
					<div class="col-sm-10 form-group" style="display:flex;padding-left:0px;position:relative;padding-right:0px;">
						<input type="text" class="form-control" v-model="curr_maintainer_name" placeholder="请输入名称搜索"></input>
						<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;width:100%;z-index:100;" class="search-communities" v-show="!change_by_user">
							<ul style="margin-bottom:0px">
								<li v-for="f in filter_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selBEmployee(f)"></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2 form-group">
						<div class="btn btn-success" @click="addBEmployee()">添加</div>
					</div>
				</form>
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
				b_employees:<?=json_encode($b_employees)?>,
				employees:<?=json_encode($employees)?>,
				curr_page_index:1,
				page_count:0,
				curr_employee_id:0,
				city_communities:[],
				sel_community_id:0,
				change_by_user:false,
				filter_employees:[],
				curr_maintainer_name:''
			},
			watch:{
				curr_maintainer_name:function(val) {
					this.filter_employees = [];
					if(this.change_by_user) {
						this.change_by_user = false;
						this.$forceUpdate();
						return;
					}
					
					if(val == "") {
						this.filter_employees = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					valBig = val.toUpperCase();
					if (true/*str.test(val)*/) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(valBig) >= 0 || this.employees[i].name.indexOf(valBig) >= 0 || this.employees[i].name.indexOf(val) >= 0) {
									this.filter_employees.push(this.employees[i]);
								}
							}
						}
					}
				},
			},
			created:function() {
				this.page_count = this.b_employees.length/10+1;
				for(var i = 0; i < this.employees.length; i++) {
					if(this.employees[i].name) {
						this.employees[i].retriving_info = makePy(this.employees[i].name).join("");
					}
				}
			},
			mounted:function() {
				$(this.$el).find("dlg_add_maitain_area").css("display",'');
			},
			methods:{
				delBEmployee:function(employee) {
					var that = this;
					API.invokeModuleCall(g_host_url,'team','delBEmployee',{employee_id:employee.employee_id},function(json) {
						if(json.code == 0) {
							location.reload();
						}
					});
				},
				addBEmployee:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'team','addBEmployee',{employee_id:this.curr_employee_id},function(json) {
						if(json.code == 0) {
							location.reload();
						}
					});
				},
				selBEmployee:function(employee) {
					this.change_by_user = true;
					this.curr_employee_id = employee.employee_id;
					this.curr_maintainer_name = employee.name+'('+employee.work_no+')';
					this.filter_employees = [];
				},
				addMaintainArea:function(employee) {
					var that = this;
					API.invokeModuleCall(g_host_url,'cityinfo','queryCityAreaAndTradeArea',{city_id:employee.city_id},function(json) {
						if(json.code == 0) {
							that.city_areas = [];
							that.curr_employee_id = employee.employee_id;
							that.city_communities = json.communities;
						}
					});
				},
				onClickAdd:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'team','addMaintainArea', {employee_id:this.curr_employee_id,community_id:this.sel_community_id}, function(json) {
						if(json.code == 0) {
							alert('添加成功');
							location.reload();
						}
					}); 
				}
			}
		})
	});
</script>
</html>