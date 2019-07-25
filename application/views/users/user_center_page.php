<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="renderer" content="webkit">
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
	<!--七牛云上传-->
	<script src="https://cdn.bootcss.com/plupload/3.1.2/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="../../../static/js/iconfont.js" type="text/javascript"></script>
	<style>
		td {
			height:50px;
			line-height:50px;
		}
		
		.form-control {
			display:inline;
			width:auto;
		}
		
		.left-menu {
			background:#5C636E;
		}
		
		.left-menu li {
			color:#F2F2F2;font-size:1.5rem;font-weight:bold;text-align:center;padding-top:10px;padding-bottom:10px;cursor:pointer;
		}
		
		.left-menu li:hover {
			background:#F96D00;
		}
		
		.left-menu li.active {
			background:#F96D00;
		}
		
		label {
			font-size:inherit;
			color:inherit;
		}
		
		span {
			font-size:inherit;
			color:inherit;
		}
		.t-img{
			margin-top: 30px;
		}
		.t-img img{
			width:150px;
			height:150px;
			border-radius:150px;
			overflow:hidden;
		}
		.x-right{
			font-size:1.5rem;
		}
		.icon {
		   width: 1em; height: 1em;
		   vertical-align: -0.15em;
		   fill: currentColor;
		   overflow: hidden;
		}
		.t-img-t svg{
			font-size: 52px;
			color: #36a765;
		}
		.t-img-t>span{
			font-size: 16px;
			margin-left: 10px;
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
			<li class="active"><a href="javascript:">基本信息</a></li>
			<li><a href="user/my_team_page">我的团队</a></li>
			<li><a href="javascript:">我的业绩</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				个人中心-基本信息 
			</li>
		</ul>
	</div>

	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="form-group">
					<div class="t-img-t col-sm-2">
						<svg class="icon" aria-hidden="true" style="font-size:45px;">
						  <use xlink:href="#icon-iconcopy"></use>
						</svg>
						<span>个人信息</span>
					</div>
					<div class="t-img col-sm-4 text-right">
						<img :src="employee.headimg" id="ID_headImg" style="cursor:pointer"></img>
					</div>
					<div class="t-img col-sm-5 col-md-offset-1">
						<div class="form-group">
							<div class="x-right">
								<label>姓名：</label><span>{{employee.real_info?employee.real_info.realname:''}}</span>
								<a href="user/user_realinfo_page" class="btn btn-success" style="margin-left:20px" v-if="employee.real_checked==0"><i class="fa fa-id-card" aria-hidden="true"></i>&nbsp;&nbsp;实名认证</a>
								<a href="user/user_verified_page" class="" style="margin-left:20px;color:#5cb85c;font-size:1.5rem;" v-if="employee.real_checked==1"><i class="fa fa-check-square-o" aria-hidden="true"></i></i>&nbsp;&nbsp;已实名</a>
							</div>
						</div>
						<div class="form-group">
							<div class="x-right">
								<label>昵称：</label><span>{{employee.nickname}}</span>
							</div>
						</div>
						<div class="form-group">
							<div class="x-right">
								<label>工号：</label><span v-html="getWorkno(employee)"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="x-right">
								<label>电话：</label><span>{{employee.mobile}}</span>
							</div>
						</div>
						<div class="form-group">
							<div class="x-right">
								<label>角色：</label><span>{{getRole(employee)}}</span>
								<span class="btn btn-success" style="margin-left:20px" v-if="employee.role==0&&employee.real_checked==1" @click="show_dlg_indenpdent_broker=true"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;&nbsp;申请独立经纪人</span>
								<span class="btn btn-success" style="margin-left:20px" v-if="employee.role==1&&employee.real_checked==1" @click="applyProfessionalAgent()"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;&nbsp;申请独职业经纪人</span>
							</div>
						</div>
						<div class="form-group">
							<div class="x-right">
								<label>所属团队：</label><span v-html="team?team.team_name:'无'"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-4">
								<a type="submit" class="btn btn-primary" href="user/user_modify_page">修改个人信息</a>
							</div>
						</div>
					</div>
				</div>
				<!--<div class="form-group">
					<div style="width:150px;height:150px;border-radius:150px;overflow:hidden;text-align:center;margin:auto;">
						<img :src="employee.headimg" style="width:150px"></img>
					</div>
					
				</div>
				<div class="form-group">
					<div style="border-radius:150px;overflow:hidden;text-align:center;margin:auto;font-size:1.5rem;">
						<label>姓名：</label><span>{{employee.name}}</span>
					</div>
				</div>
				<div class="form-group">
					<div style="border-radius:150px;overflow:hidden;text-align:center;margin:auto;font-size:1.5rem;">
						<label>工号：</label><span>{{employee.work_no}}</span>
					</div>
				</div>
				<div class="form-group">
					<div style="border-radius:150px;overflow:hidden;text-align:center;margin:auto;font-size:1.5rem;">
						<label>电话：</label><span>{{employee.mobile}}</span>
					</div>
				</div>
				<div class="form-group">
					<div style="border-radius:150px;overflow:hidden;text-align:center;margin:auto;font-size:1.5rem;">
						<label>角色：</label><span>{{getRole(employee)}}</span>
					</div>
				</div>-->
			</div>
		</div>
	</div>

	<div id="dlg_indenpdent_broker" :class="{hide:!show_dlg_indenpdent_broker}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">申请独立经纪人</label>
			</div>
			<div class="form-group">
				<label>片区：</label>
				<select class="form-control" v-model="agent_info.area_id">
					<option v-for="area in areas" v-html="area.name" :value="area.area_id"></option>
				</select>
				<label style="margin-left:20px;">商圈：</label>
				<select class="form-control" v-model="agent_info.ta_id">
					<option v-for="trade_area in trade_areas" v-html="trade_area.name" :value="trade_area.ta_id" v-if="trade_area.area_id==agent_info.area_id"></option>
				</select>
			</div>
			<div class="" style="margin-top:10px">
				<textarea class="form-control" placeholder="请输入申请消息" v-model="agent_info.msg" style="width:100%"></textarea>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="applyForAgent()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="show_dlg_indenpdent_broker=false">取消</div>
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
		var tradeCom = Vue.component('trade-item', {
			props:['ta','employees'],
			template:
			'<div class="col-sm-12" style="margin-bottom:10px;border-bottom:1px solid #ddd;clear:both;padding-bottom:10px;">'+
				'<div class="col-sm-4" v-html="ta.name"></div>'+
				'<div class="col-sm-4" v-html="employee_name"></div>'+
				'<div class="col-sm-4"><span class="btn btn-success" v-if="employee_name==\'\'" @click="showAdd()">添加</span><span class="btn btn-danger" v-if="employee_name" @click="delTaEmployee()">删除</span></div>'+
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
				employee:<?=json_encode($employee)?>,
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				employees:<?=json_encode($employees)?>,
				team:<?=json_encode($team)?>,
				filter_employees:[],
				ta_employee_name:'',
				filter_ta_employees:[],
				show_dlg_add_admin:false,
				show_dlg_indenpdent_broker:false,
				agent_info:{
					msg:'',
					area_id:0,
					area_name:'',
					ta_id:0,
					trade_area_name:''
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_indenpdent_broker").css("display","");
				var that = this;
				var poster_uploader = new QiniuJsSDK();
				var poster_uploader_opt = {
					browse_button: 'ID_headImg',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url

						   API.invokeModuleCall(g_host_url,'user','updateUserHeadImg', {headimg:sourceLink},function(json) {
							  if(json.code == 0) {
								  that.employee.headimg = sourceLink;
							  } 
						   });
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader.uploader(poster_uploader_opt);
				
			},
			created:function() {
				if(this.employee.real_info) {
					this.employee.real_info = JSON.parse(this.employee.real_info);
				} else {
					this.employee.real_info = {};
				}
			},
			watch:{
				'agent_info.area_id':function(val) {
					for(var i = 0; i < this.areas.length;  i++) {
						if(this.areas[i].area_id == val) {
							this.agent_info.area_name = this.areas[i].name;
							break;
						}
					}
				},
				'agent_info.ta_id':function(val) {
					for(var i = 0; i < this.trade_areas.length;  i++) {
						if(this.trade_areas[i].ta_id == val) {
							this.agent_info.trade_area_name = this.trade_areas[i].name;
							break;
						}
					}
				}
			},
			methods:{
				applyForAgent:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'user', 'applyForAgent', this.agent_info, function(json) {
						if(json.code == 0) {
							that.show_dlg_indenpdent_broker = false;
						}
					});
				},
				applyProfessionalAgent:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'user', 'applyProfessionalAgent', {}, function(json) {
						if(json.code == 0) {
							showMsg('申请提交成功，请等待处理');
						}
					});
				},
				getRole:function(employee) {
					var s = ['游客','独立经纪人','职业经纪人'];
					return s[employee.role];
				},
				getWorkno:function(employee) {
					return pad(employee.employee_id,6);
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