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
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<style>
		td {
			height:50px;
			line-height:50px;
		}
		
		.form-control {
			display:inline;
			width:auto;
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
			<li class="active"><a href="team/admin_manager_page">管理员</a></li>
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
				团队管理-管理员 
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="form-group">
					<label>片区：</label>
					<select class="form-control" v-model="curr_area_id">
						<option v-for="area in areas" :value="area.area_id" v-html="area.name"></option>
					</select>
					
					<label style="margin-left:60px">管理员：</label>
					<span class="btn btn-primary" v-if="curr_area.employee" v-html="curr_area.employee.name+'('+curr_area.employee.work_no+')'">姜宝林</span>
					<div class="btn-group" style="margin-left:20px;" v-if="curr_area.employee">
						<span class="btn btn-danger" @click="delAreaEmployee()">删除</span>
					</div>
					<div class="btn-group" style="margin-left:20px;display:inline;max-width:300px;" v-if="!curr_area.employee">
						<div style="font-size:1.5rem;font-weight:bolder;position:relative;display:inline-block;">
							<input type="text" class="form-control" style="width:auto;display:inline;" placeholder="请输入姓名或系统号" v-model="area_employee_name"></input>
							<div style="background-color:#fff;left:0px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;width:100%;z-index:100;" class="search-communities">
								<ul style="margin-bottom:0px">
									<li v-for="f in filter_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selAreaEmployee(f)"></li>
								</ul>
							</div>
							<span class="btn btn-success" @click="setAreaEmployee()" style="margin-left:10px">添加</span>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
			商圈管理员
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<div class="col-sm-12">
					<div class="col-sm-4 all-col all-col-z"><label>商圈</label></div>
					<div class="col-sm-4 all-col all-col-z"><label>管理员</label></div>
					<div class="col-sm-4 all-col all-col-z"><label>操作</label></div>
				</div>
			</div>
			<div class="panel-body">
				
					<table class="table table-hover">
						<tbody>
						<template>
							<trade-item v-for="ta in trade_areas" v-if="ta.area_id==curr_area_id" :ta="ta" :employees="employees" @add_admin="addAdmin"></trade-item>
						</template>
						</tbody>
					</table>
				
			</div>
		</div>
	</div>
	
	<div id="dlg_add_admin" :class="{hide:!show_dlg_add_admin}" style="display:none">
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
								<li v-for="f in filter_ta_employees" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;" v-html="f.name+'('+f.work_no+')'" @click="selTaEmployee(f)"></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="onAddTaAdmin()">添加</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="onHide()">取消</div>
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
		var tradeCom = Vue.component('trade-item', {
			props:['ta','employees'],
			template:
			'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
				'<div class="col-sm-4" v-html="ta.name"></div>'+
				'<div class="col-sm-4" v-html="employee_name"></div>'+
				'<div class="col-sm-4"><span class="btn btn-success" v-if="employee_name==\'\'" @click="showAdd()">设置</span><span class="btn btn-danger" v-if="employee_name" @click="delTaEmployee()">删除</span></div>'+
			'</div>',
			computed:{
				employee_name:function() {
					for(var i = 0; i < this.employees.length; i++) {
						if(this.employees[i].employee_id == this.ta.employee_id) {
							return this.employees[i].name+'('+this.employees[i].work_no+')';
						}
					}
					return '';
				}
			},
			methods:{
				showAdd:function() {
					this.$root.curr_trade_employee = {};
					this.$emit("add_admin", this.ta);
				},
				delTaEmployee:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'team', 'delTaEmployee', this.ta, function(json) {
						if(json.code == 0) {
							showMsg('删除成功');
							that.ta.employee_id = 0;
						}
					});
				}
			}
		});     
		
		g_page = new Vue({
			el:'#content_warp',
			data:{
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				employees:<?=json_encode($employees)?>,
				curr_area_id:0,
				curr_area:{},
				curr_trade_employee:{},
				area_employee_name:'',
				curr_ta_id:0,
				curr_employee_id:0,
				filter_employees:[],
				ta_employee_name:'',
				filter_ta_employees:[],
				show_dlg_add_admin:false
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_admin").css("display","");
			},
			watch:{
				curr_area_id:function() {
					for(var i = 0; i < this.areas.length; i++){
						if(this.areas[i].area_id == this.curr_area_id) {
							this.curr_area  = this.areas[i];break;
						}
					}
				},
				area_employee_name:function(val) {
					this.filter_employees = [];
					if(val == "") {
						this.filter_employees = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					// if (str.test(val)) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(val) >= 0) {
									this.filter_employees.push(this.employees[i]);
									continue;
								}
							}

							if(this.employees[i].name) {
								if(this.employees[i].name.indexOf(val) >= 0) {
									this.filter_employees.push(this.employees[i]);
								}
							}
						}
					// }
				},
				ta_employee_name:function(val) {
					this.filter_ta_employees = [];
					if(val == "") {
						this.filter_ta_employees = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					// if (str.test(val)) {//是字母，则判断
						for(var i = 0; i < this.employees.length; i++) {
							if(this.employees[i].retriving_info) {
								if(this.employees[i].retriving_info.indexOf(val) >= 0) {
									this.filter_ta_employees.push(this.employees[i]);
								}
							}

							if(this.employees[i].name) {
								if(this.employees[i].name.indexOf(val) >= 0) {
									this.filter_ta_employees.push(this.employees[i]);
								}
							}
						}
					// }
				}
			},
			created:function() {
				for(var i = 0; i < this.areas.length; i++) {
					for(var j = 0; j < this.employees.length; j++) {
						if(this.areas[i].employee_id == this.employees[j].employee_id) {
							this.areas[i].employee = this.employees[j];
							break;
						}
					}
				}
				
				for(var i = 0; i < this.trade_areas.length; i++) {
					for(var j = 0; j < this.employees.length; j++) {
						if(this.trade_areas[i].employee_id == this.employees[j].employee_id) {
							this.trade_areas[i].employee = this.employees[j];
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
			methods:{
				selTaEmployee:function(f) {
					this.curr_trade_employee = f;
					this.ta_employee_name = f.name;
				},
				onAddTaAdmin:function() {
					var that = this;
					alert(this.curr_trade_employee.employee_id);
					API.invokeModuleCall(g_host_url, 'team', 'setTaEmployee', {employee_id:this.curr_trade_employee.employee_id,ta_id:this.curr_ta_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.trade_areas.length; i++) {
								if(that.trade_areas[i].ta_id == that.curr_ta_id) {
									that.trade_areas[i].employee_id = that.curr_trade_employee.employee_id;
								}
							}
						}
						that.show_dlg_add_admin = false;
					});
				},
				onHide:function() {
					this.show_dlg_add_admin = false;
				},
				addAdmin:function(ta) {
					this.curr_ta_id = ta.ta_id;
					this.show_dlg_add_admin = true;
				},
				setAreaEmployee:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'team', 'setAreaEmployee', {employee_id:this.curr_employee_id,area_id:this.curr_area_id}, function(json) {
						for(var i = 0; i < that.areas.length; i++) {
							if(that.areas[i].area_id == that.curr_area_id) {
								for(var j = 0; j < that.employees.length; j++) {
									if(that.employees[j].employee_id == that.curr_employee_id) {
										that.areas[i].employee = that.employees[j];
										console.log(that.areas[i]);
										showMsg('添加成功');
										that.$forceUpdate();
										break;
									}
								}
							}
						}
					});
				},
				delAreaEmployee:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'team', 'delAreaEmployee', {area_id:this.curr_area_id}, function(json) {
						for(var i = 0; i < that.areas.length; i++) {
							if(that.areas[i].area_id == that.curr_area_id) {
								that.areas[i].employee = null;
								that.$forceUpdate();
								break;
							}
						}
					});
				},
				selAreaEmployee:function(employee) {
					this.curr_employee_id = employee.employee_id;
					var that = this;
					this.area_employee_name = employee.name;
				}
			}
		})
	});
</script>
<script>
$(function(){
	$('.dropdown').click(function(){
		$(this).toggleClass('open');
	});
});
</script>
</html>