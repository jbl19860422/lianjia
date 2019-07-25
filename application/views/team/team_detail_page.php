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
				团队列表-团队详情
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
			创建人：{{team_creator.name}}
		</div>
		<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
			团队成员
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<div class="col-sm-12">
					<div class="col-sm-2 all-col all-col-z tc"><label>序号</label></div>
					<div class="col-sm-2 all-col all-col-z tc"><label>成员名称</label></div>
					<div class="col-sm-4 all-col all-col-z tc"><label>加入时间</label></div>
					<div class="col-sm-4 all-col all-col-z tc"><label>操作</label></div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<tr v-for="(e,index) in team_employees">
						<td v-html="index+1" class="col-sm-2"></td>
						<td class="col-sm-2" v-html="e.employee.name"></td>
						<td class="col-sm-4">{{e.create_time|formatTime}}</td>
						<td class="col-sm-4">
							<div class="btn-group">
								<a class="btn btn-info" v-if="team_creator.employee_id==<?php echo $_SESSION['employee']['employee_id']?>">授予房源信息查看权限</a>
								<div class="btn btn-success">查看成员信息</div>
							</div>
						</td>
					</tr>
				</table>
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
				team_employees:<?=json_encode($team_employees)?>,
				team_creator:<?=json_encode($team_creator)?>,
			},
			created:function() {
				
			},
			mounted:function() {
				
			},
			methods:{
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