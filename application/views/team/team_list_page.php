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
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
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
			text-align:center;
		}
		
		.tc {
			text-align:center;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='团队列表';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu" style="display:none">
	<ul class="cityinfo-menus">
			<!--<li><a href="team/approval_user_page">用户审核</a></li>-->
			<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_A) { ?>
			<li><a href="team/approval_user_page">用户审核</a></li>
			<li><a href="team/employee_list_page">员工列表</a></li>
			<li><a href="team/admin_manager_page">管理员</a></li>
			<?php } ?>
			<li class="active"><a href="javascript:">团队</a></li>
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
				团队列表-团队列表 
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<div v-if="my_team">
			<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
				我带领的团队
				<div class="panel-r" @click="show_dlg_invite=true"><i class="fa fa-plus-square-o"></i>邀请加入</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<div class="col-sm-12">
						<div class="col-sm-2 all-col all-col-z tc"><label>团队名称</label></div>
						<div class="col-sm-4 all-col all-col-z tc"><label>创建时间</label></div>
						<div class="col-sm-3 all-col all-col-z tc"><label>商圈</label></div>
						<div class="col-sm-3 all-col all-col-z tc"><label>操作</label></div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
						<tr>
							<td class="col-sm-2" v-html="my_team.team_name"></td>
							<td class="col-sm-4">{{my_team.create_time|formatTime}}</td>
							<td class="col-sm-3" v-html="my_team.ta_name"></td>
							<td class="col-sm-3">
								<div class="btn-group">
									<a class="btn btn-success" :href="'team/team_detail_page?team_id='+my_team.team_id">查看详情</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div v-if="my_join_team">
			<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
				我加入的团队
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<div class="col-sm-12">
						<div class="col-sm-2 all-col all-col-z tc"><label>团队名称</label></div>
						<div class="col-sm-4 all-col all-col-z tc"><label>创建时间</label></div>
						<div class="col-sm-3 all-col all-col-z tc"><label>商圈</label></div>
						<div class="col-sm-3 all-col all-col-z tc"><label>操作</label></div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
						<tr>
							<td class="col-sm-2" v-html="my_join_team.team_name"></td>
							<td class="col-sm-4">{{my_join_team.create_time|formatTime}}</td>
							<td class="col-sm-3" v-html="my_join_team.ta_name"></td>
							<td class="col-sm-3"><div class="btn-group"><a class="btn btn-success" :href="'team/team_detail_page?team_id='+my_join_team.team_id">查看详情</a></div></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
			团队列表
		</div>
	
		<div class="panel panel-default">
			<!--
			<div class="panel-heading panel-title">
				<p class="panel-p">团队列表</p>
			</div>
			-->
			<div class="panel-heading panel-title">
				<div class="col-sm-12">
					<div class="col-sm-1 all-col all-col-z tc"><label>序号</label></div>
					<div class="col-sm-2 all-col all-col-z tc"><label>团队名称</label></div>
					<div class="col-sm-4 all-col all-col-z tc"><label>创建时间</label></div>
					<div class="col-sm-2 all-col all-col-z tc"><label>商圈</label></div>
					<div class="col-sm-3 all-col all-col-z tc"><label>操作</label></div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<!--
					<thead>
						<tr>
							<th>序号</th>
							<th>团队名称</th>
							<th>创建时间</th>
							<th>商圈</th>
							<th>操作</th>
						</tr>
					</thead>
					-->
					<tr v-for="(team,index) in teams" v-if="index>=(curr_page_index-1)*10&&index<=curr_page_index*10">
						<td v-html="index+1" class="col-sm-1"></td>
						<td v-html="team.team_name" class="col-sm-2"></td>
						<td class="col-sm-4">{{team.create_time|formatTime}}</td>
						<td v-html="team.ta_name" class="col-sm-2"></td>
						<td class="col-sm-3">
							<div class="btn-group">
								<a class="btn btn-primary" @click="applyJoinTeam(team)" v-if="<?php if($employee['role']!=ROLE_GUEST&&$employee['joined_team']==0&&$employee['team_creator']==0) echo 'true';else echo 'false';?>">申请加入</a>
								<a class="btn btn-success" :href="'team/team_detail_page?team_id='+team.team_id">查看详情</a>
							</div>
						</td>
					</tr>
				</table>
				<div style="text-align:center">
					<ul class="pagination" >
					  <li><a href="#">&laquo;</a></li>
					  <li><a href="#">1</a></li>
					  <li><a href="#">&raquo;</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="dlg_invite" :class="{hide:!show_dlg_invite}" style="display:none">
			<div class="webbox-dlg-bg"></div>
			<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
				<div class="" style="height:auto;text-align:center;">
					<label style="font-size:2rem">添加管理员</label>
				</div>
				<div class="" style="margin-top:10px">
					<div class="btn-group" style="margin-left:20px;display:inline;max-width:300px;">
						<div style="font-size:1.5rem;font-weight:bolder;margin-top:0px;position:relative;display:inline-block;">
							<input type="text" class="form-control" style="width:auto;display:inline;" placeholder="请输入姓名或系统号" v-model="ta_employee_name"></input>
							<div style="background-color:#fff;left:0px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;width:100%;z-index:100;" class="search-communities">
								<ul style="margin-bottom:0px">
									<li v-for="f in filter_ta_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selInviteEmployee(f)"></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top:20px">
					<div style="display:flex">
						<div class="btn btn-info" style="flex:2" @click="onSendInviteJoin()">发送邀请</div>
						<div style="flex:1"></div>
						<div class="btn btn-success" style="flex:2" @click="show_dlg_invite=false">取消</div>
					</div>
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
				teams:<?=json_encode($teams)?>,
				my_team:<?=json_encode($my_team)?>,
				my_join_team:<?=json_encode($my_join_team)?>,
				employees:<?=json_encode($employees)?>,
				
				trade_areas:<?=json_encode($trade_areas)?>,
				curr_page_index:1,
				page_count:0,
				curr_employee_id:0,
				show_dlg_add_maitain_area:false,
				show_dlg_invite:false,
				ta_employee_name:'',
				filter_ta_employees:[],
				curr_invite_employee:{},
			},
			created:function() {
				for(var i = 0; i < this.teams.length; i++) {
					for(var j = 0;j < this.trade_areas.length; j++) {
						if(this.teams[i].ta_id == this.trade_areas[j].ta_id) {
							this.teams[i].ta_name = this.trade_areas[j].name;
							break;
						}
					}
				}
				
				if(this.my_team) {
					for(var j = 0;j < this.trade_areas.length; j++) {
						if(this.my_team.ta_id == this.trade_areas[j].ta_id) {
							this.my_team.ta_name = this.trade_areas[j].name;
							break;
						}
					}
				}
				
				if(this.my_join_team) {
					for(var j = 0;j < this.trade_areas.length; j++) {
						if(this.my_join_team.ta_id == this.trade_areas[j].ta_id) {
							this.my_join_team.ta_name = this.trade_areas[j].name;
							break;
						}
					}
				}
				
				for(var i = 0; i < this.employees.length; i++) {
					if(this.employees[i].name) {
						this.employees[i].retriving_info = makePy(this.employees[i].name).join("");
					} else {
						this.employees[i].retriving_info = '';
					}
				}
			},
			watch:{
				ta_employee_name:function(val) {
					this.filter_ta_employees = [];
					if(val == "") {
						this.filter_ta_employees = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (str.test(val)) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(val) >= 0) {
									this.filter_ta_employees.push(this.employees[i]);
								}
							}
						}
					}
				}
			},
			mounted:function() {
				$(this.$el).find("dlg_add_maitain_area").css("display",'');
				$(this.$el).find("#dlg_invite").css("display","");
			},
			methods:{
				onSendInviteJoin:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'team','sendInviteJoin',{employee_id:this.curr_invite_employee.employee_id,team_id:this.my_team.team_id},function(json) {
						if(json.code == 0) {
							showMsg('邀请消息发送成功');
							that.show_dlg_invite = false;
						} else if(json.code == -1) {
							showMsg('该用户已经加入团队或创建团队，无法邀请！');
							that.show_dlg_invite = false;
						}
					});
				},
				selInviteEmployee:function(f) {
					this.curr_invite_employee = f;
					this.ta_employee_name = f.name;
				},
				addMaintainArea:function(employee) {
					var that = this;
					API.invokeModuleCall(g_host_url,'cityinfo','queryCityAreaAndTradeArea',{city_id:employee.city_id},function(json) {
						if(json.code == 0) {
							that.city_areas = [];
							that.curr_employee_id = employee.employee_id;
							that.city_communities = json.communities;
							that.show_dlg_add_maitain_area = true;
						}
					});
				},
				applyJoinTeam:function(team) {
					var that = this;
					API.invokeModuleCall(g_host_url, 'team', 'applyJoinTeam', team, function(json) {
						if(json.code == 0) {
							showMsg("申请消息已发送");
						} else if(json.code == -10001) {
							showMsg('自己创建的团队，无需加入');
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
<script>
	$(function(){
		$('.availability-span-t').popover({html: true, trigger: 'hover'});
		$('.availability-span-d').popover({html: true, trigger: 'hover'});
	})
</script>
</html>