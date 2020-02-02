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
	<script src="https://cdn.bootcss.com/plupload/2.1.2/plupload.full.min.js"></script>
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
			<li class="active"><a href="team/employee_list_page">员工列表</a></li>
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
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">员工列表</p>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>工号</th>
							<!--<th>手机号</th>-->
							<!--<th>姓名</th>-->
							<th>昵称</th>
							<th>头像</th>
							<!--<th>性别</th>-->
							<th>级别</th>
							<th>城市</th>
							<th>注册时间</th>
							<th>维护小区</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(employee,index) in employees">
							<td v-html="getWorkno(employee)"></td>
							<!--<td v-html="employee.mobile"></td>
							<td v-html="employee.name"></td>-->
							<td v-html="employee.nickname"></td>
							<td><img :src="employee.headimg" style="width:50px;height:50px"></img></td>
							<td v-html="getLevel(employee)"></td>
							<!--<td v-html="employee.sex=='m'?'男':'女'"></td>-->
							<td v-html="getPos(employee)"></td>
							<td>{{employee.reg_time|formatTime}}</td>
							<td>{{employee.maintain_communities}}</td>
							<td><span class="btn btn-success" @click="addMaintainArea(employee)">添加维护小区</span></td>
						</tr>
					</tbody>
				</table>
				<div style="text-align:center">
					<ul class="pagination">
						<li :class="{disabled:pi<=1}"><a href="javascript:" @click="if(pi>=2) {pi--;}">&laquo;</a></li>
						<li v-for="p in page_count"  :class="{active:p==pi}"><a href="javascript:" v-html="p" @click="pi=p;"></a></li>
						<li :class="{disabled:pi>=page_count}"><a href="javascript:" @click="if(pi<page_count) {pi++;}">&raquo;</a></li>								
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dlg_add_maitain_area" :class="{hide:!show_dlg_add_maitain_area}">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_dlg_add_maitain_area,'animate-hide':!show_dlg_add_maitain_area}" id="webbox-dlg-div">
			<div class="webbox-header">
				<div class="webbox-title">添加维护小区</div>
				<span style="" @click="onClickCancel()">×</span>
			</div>
			<div class="webbox-body">
				<div class="webbox-body-div">
					<label class="col-sm-4">选择小区:</label>
					 <div class="col-sm-7" style="position:relative">
						<select type="text" class="form-control" placeholder="" v-model="sel_community_id">
							<option v-for="community in city_communities" v-html="community.name" :value="community.community_id"></option>
						</select>
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
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};

	function pad(num, n) {
    var len = num.toString().length;
    while(len < n) {
        num = "0" + num;
        len++;
    }
    return num;
	}
	
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
				pi:<?=$pi?>,
				pc:<?=$pc?>,
				total_count:<?=$total_count?>,
				page_count:<?=$page_count?>,
				provinces:<?=json_encode($provinces)?>,
				cities:<?=json_encode($cities)?>,
				communities:<?=json_encode($communities)?>,
				employees:<?=json_encode($employees)?>,
				curr_page_index:1,
				curr_employee_id:0,
				city_communities:[],
				sel_community_id:0,
				show_dlg_add_maitain_area:false,
			},
			watch:{
				pi:function() {
					location.href = "team/employee_list_page?pi="+this.pi;
				}
			},
			created:function() {
				for(var i = 0;i < this.employees.length; i++) {
					
					var maintain_communities = [];
					for(var j = 0; j < this.communities.length; j++) {
						if(this.communities[j].community_id == this.employees[i].maintain_community_id1) {
							maintain_communities.push(this.communities[j].name);
						}
						
						if(this.communities[j].community_id == this.employees[i].maintain_community_id2) {
							maintain_communities.push(this.communities[j].name);
						}
						
						if(this.communities[j].community_id == this.employees[i].maintain_community_id3) {
							maintain_communities.push(this.communities[j].name);
						}
					}
					
					this.employees[i].maintain_communities = maintain_communities.join(",");
				}
			},
			mounted:function() {
				$(this.$el).find("dlg_add_maitain_area").css("display",'');
			},
			methods:{
				getWorkno:function(employee) {
					return pad(employee.employee_id,6);
				},
				getPos:function(employee) {
					var s = '';
					if(employee.area) {
						s += employee.area.name;
					}
					
					if(employee.ta) {
						s += employee.ta.name;
					}
					
					if(employee.team)  {
						s += "-团队：" + employee.team.name;
					}
					
					return s;
				},
				getLevel:function(employee) {
					var s = '';
					if(employee.area && employee.area.employee_id == employee.employee_id) {//片区
						s += employee.area.name+'区总';
					}
					
					if(employee.ta && employee.ta.employee_id == employee.employee_id) {//片区
						s += employee.ta.name+'总监';
					}
					
					if(s != '') {
						s += '/';
					}
					
					if(employee.role == 0) {
						s += '游客';
					} else if(employee.role == 1) {
						s += '独立经纪人';
					} else if(employee.role == 2) {
						s += '职业经纪人';
					}
					return s;
				},
				addMaintainArea:function(employee) {
					var that = this;
					API.invokeModuleCall(g_host_url,'cityinfo','queryCommunities',{},function(json) {
						if(json.code == 0) {
							that.city_areas = [];
							that.curr_employee_id = employee.employee_id;
							that.city_communities = json.communities;
							that.show_dlg_add_maitain_area = true;
						}
					});
					
				},
				onClickCancel:function() {
					this.show_dlg_add_maitain_area = false;
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