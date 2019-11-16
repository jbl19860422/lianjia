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
	<!--
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li class="active"><a href="team/approval_user_page">用户审核</a></li>
			<li><a href="team/employee_list_page">员工列表</a></li>
			<li><a href="team/admin_manager_page">管理员</a></li>
			<li><a href="javascript:">团队</a></li>
		</ul>
	</div>
	-->
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				个人中心-消息中心 
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div style="margin-top:10px;font-weight:bold;font-size:1.8rem;">
			消息中心
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<div class="col-sm-12">
					<div class="col-sm-1 all-col all-col-z"><label>序号</label></div>
					<div class="col-sm-1 all-col all-col-z"><label>类型</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>发送人</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>头像</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>发送时间</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>消息内容</label></div>
					<div class="col-sm-2 all-col all-col-z"><label>操作</label></div>
				</div>
			</div>
			<div class="panel-body">
				<template v-for="msg in messages">
					<component :is="'msg'+msg.type" :msg="msg" @del_msg="del_msg" :employee="employee"></component>
				</template>
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
		Vue.component('msg1', {//创建团队消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">创建团队消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2">{{content}}</div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowCreateTeam()">同意创建</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" style="border-radius:5px" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					 '</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return '团队名称：'+this.msg.content.name;
				}
			},
			methods:{
				allowCreateTeam:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'user', 'allowCreateTeam', this.msg, function(json) {
						if(json.code == 0) {
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg2', {//实名申请消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">实名申请消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"></div>'+
						'<div class="col-sm-2"><a class="btn btn-primary" :href="\'msg/verify_detail_page?msg_id=\'+msg.msg_id">查看详情</a></div>'+
					'</div>',
			created:function() {
			},
			mounted:function() {
			},
			computed:{
			},
			methods:{
			}
		});

		Vue.component('msg3', {//独立经纪人申请消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">独立经纪人申请消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2">{{content}}</div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="checkAgentOK()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return this.msg.content.msg+'('+this.msg.content.area_name+'-'+this.msg.content.trade_area_name+')';
				}
			},
			methods:{
				checkAgentOK:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'user','checkAgentOK', this.msg, function(json) {
						if(json.code == 0) {
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg4', {//团队申请加入消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">申请加入团队<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2">{{content}}</div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowJoinTeam()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
				}
			},
			methods:{
				allowJoinTeam:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'team', 'allowJoinTeam', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg5', {//团队申请加入消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">修改房产证消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowHouseCert()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.cert_img+"' style='width:80%'></img><br><span>产证面积："+this.msg.content.area+"㎡<br></span><span>套内面积："+this.msg.content.inner_area+"㎡<br></span>";
				}
			},
			methods:{
				allowHouseCert:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowHouseCert', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg6', {//团队申请加入消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">上传房产委托证件<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowHouseAgentCert()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.cert_img+"' style='width:80%'></img>";
				}
			},
			methods:{
				allowHouseAgentCert:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowHouseAgentCert', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg7', {//申请房产合同上传
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">上传原始房产合同<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowHouseContract()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.contract_img+"' style='width:80%'></img>";
				}
			},
			methods:{
				allowHouseContract:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowHouseContract', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg8', {//业主身份证明
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">上传业主身份证明<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowIdPaper()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.id_img+"' style='width:80%'></img>";
				}
			},
			methods:{
				allowIdPaper:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowIdPaper', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg9', {//业主身份证明
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">上传契税票<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowTaxTicket()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.ticket_img+"' style='width:80%'></img>";
				}
			},
			methods:{
				allowTaxTicket:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowTaxTicket', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg10', {//房屋核验报告
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">上传房屋核验报告<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowVeriReport()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<img src='"+this.msg.content.report_img+"' style='width:80%'></img>";
				}
			},
			methods:{
				allowVeriReport:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowVeriReport', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg11', {//房屋核验报告
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">修改房源认证编号<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="content"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowHouseNumber()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<span>房源认证编号："+this.msg.content.number+"</span>";
				}
			},
			methods:{
				allowHouseNumber:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowHouseNumber', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg12', {//申请无效房源
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">申请无效房源<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="msg.content.address"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowInvalidHouse()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<span>房源地址："+this.msg.content.ta_name+this.msg.content.community_name+"</span>";
				}
			},
			methods:{
				allowInvalidHouse:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowInvalidHouse', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						} else if(json.code == -10002) {
							showMsg('已经加入了');
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg13', {//申请聚焦房源
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">申请聚焦房源<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="msg.content.address"></div>'+
						'<div class="col-sm-2">'+
							'<div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="allowFocusHouse()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a>'+
						'</div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
				this.msg.content.address = '';
				var that = this;
				API.invokeModuleCall(g_host_url, 'houseinfo', 'queryHouseAddress', this.msg.content, function(json) {
					if(!json.area) {
						return;
					}
					that.msg.content.address = (json.area.name?json.area.name:'')+(json.trade_area.name?json.trade_area.name:'')+json.community.name+json.bb.name+json.bu.name+that.msg.content.floor+'楼'+json.house.name;
					that.$forceUpdate();
				});
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					//return "<span>房源地址："+this.msg.content.ta_name+this.msg.content.community_name+"</span>";
				}
			},
			methods:{
				allowFocusHouse:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowFocusHouse', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("操作成功");
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg14', {//独立经纪人申请消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">职业经纪人申请消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="checkProfessionalAgentOK()">审核通过</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝通过</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return this.msg.content.msg+'('+this.msg.content.area_name+'-'+this.msg.content.trade_area_name+')';
				}
			},
			methods:{
				checkProfessionalAgentOK:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'user','checkProfessionalAgentOK', this.msg, function(json) {
						if(json.code == 0) {
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});

		Vue.component('msg15', {//推荐房源消息
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">推荐房源<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2" v-html="msg.content.address"></div>'+
						'<div class="col-sm-2"><div v-if="msg.from_employee_id!=employee.employee_id" class="btn-group"><a class="btn btn-primary" href="javascript:" @click="receiveHouse()">接收房源</a><a class="btn btn-danger" href="javascript:" @click="rejectApply()">拒绝接收</a></div><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
				this.msg.content.address = '';
				var that = this;
				API.invokeModuleCall(g_host_url, 'houseinfo', 'queryHouseAddress', this.msg.content, function(json) {
					if(!json.area) {
						return;
					}
					that.msg.content.address = (json.area.name?json.area.name:'')+(json.trade_area.name?json.trade_area.name:'')+json.community.name+json.bb.name+json.bu.name+that.msg.content.floor+'楼'+json.house.name;
					that.$forceUpdate();
				});
			},
			mounted:function() {
			},
			computed:{
				content:function() {
					return "<span>房源地址："+this.msg.content.ta_name+this.msg.content.community_name+"</span>";
				}
			},
			methods:{
				receiveHouse:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'receiveHouse', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg16', {//约看消息
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">约看房源消息<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"><a :href="\'user/appsee_detail_page?see_id=\'+msg.content.appsee.see_id+\'&h_id=\'+msg.content.house_info.house_info_id">查看详情</a></div>'+
						'<div class="col-sm-2"><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			methods:{
				deleteMsg:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
						if(json.code == 0) {
							showMsg("已经删除");
							that.$emit('del_msg', that.msg);
						}
					});
				}
			}
		});
		
		Vue.component('msg17', {//审核实勘图片消息
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">请审核实勘图片<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"><a :href="\'msg/apply_follow_img_page?msg_id=\'+msg.msg_id">查看详情</a></div>'+
						'<div class="col-sm-2"><a class="btn btn-danger" v-if="msg.status==1" href="javascript:" @click="deleteMsg()">删除消息</a></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			methods:{
				allowFollowImg:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowFollowImg', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});
		
		Vue.component('msg18', {//团队邀请加入消息
			props:['msg', 'employee'],
			template:
					'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">邀请加入团队<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"><a :href="\'team/team_detail_page?team_id=\'+msg.content.team_id" target="_blank">查看团队详情</a></div>'+
						'<div class="col-sm-2"><div class="btn-group"><a class="btn btn-success">加入团队</div><a class="btn btn-danger" v-if="msg.status==0" href="javascript:" @click="deleteMsg()">拒绝加入</a></div></div>'+
					'</div>',
			created:function() {
				this.msg.content = JSON.parse(this.msg.content);
			},
			mounted:function() {
			},
			methods:{
				allowFollowImg:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'houseinfo', 'allowFollowImg', this.msg, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.$emit('del_msg', that.msg);
						}
					});
				},
				rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.msg.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
								that.$emit('del_msg', that.msg);
							}
						});
				},
				deleteMsg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'deleteMsg', {msg_id:this.msg.msg_id}, function(json) {
							if(json.code == 0) {
								showMsg("已经删除");
								that.$emit('del_msg', that.msg);
							}
						});
				}
			}
		});

		Vue.component('msg19', {//实名修改消息
			props:['msg','employee'],
			template:'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
						'<div class="col-sm-1" v-html="msg.msg_id"></div>'+
						'<div class="col-sm-1">实名信息修改<span v-if="msg.status==1">(被拒绝)</span></div>'+
						'<div class="col-sm-2" v-html="msg.from_employee_name"></div>'+
						'<div class="col-sm-2"><img :src="msg.from_employee_headimg" style="width:50px;height:50px;border-radius:100%;"></img></div>'+
						'<div class="col-sm-2">{{msg.create_time|formatTime}}</div>'+
						'<div class="col-sm-2"></div>'+
						'<div class="col-sm-2"><a class="btn btn-primary" :href="\'msg/verify_detail_page?msg_id=\'+msg.msg_id">查看详情</a></div>'+
					'</div>',
			created:function() {
			},
			mounted:function() {
			},
			computed:{
			},
			methods:{
			}
		});

		g_page = new Vue({
			el:'#content_warp',
			data:{
				messages:<?=json_encode($messages)?>,
				employee:<?=json_encode($employee)?>
			},
			created:function() {
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			methods:{
				del_msg:function(msg) {
					for(var i = 0; i < this.messages.length; i++) {
						if(this.messages[i].msg_id == msg.msg_id) {
							this.messages.splice(i,1);
							break;
						}
					}
				},
				getMsgType:function(type) {
					var t = ['','团队创建申请','实名认证申请','独立经纪人申请消息'];
					return t[type];
				}
			}
		})
	});
</script>
</html>