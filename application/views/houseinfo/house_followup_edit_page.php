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
	<link href="../../../static/css/city_page.css?v=1" rel="stylesheet">
	<link href="../../../static/css/availability.css" rel="stylesheet">
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
		.more-item {
			color:#fff;padding-top:5px;padding-bottom:5px;;padding-left:5px;padding-bottom:5px;display:block;
			text-decoration:none;
		}
		
		.dim-item {
			margin-bottom:10px;
			border:1px solid #4cae4c;
			color:#4cae4c;
			border-radius: 4px;
			cursor:pointer;
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 10px;
			font-size: 14px;
			font-weight: normal;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			background-image: none;
			border-radius: 4px;
		}
		
		.dim-item.sel {
			color: #fff;
			background-color: #5cb85c;
			border-color: #4cae4c;
		}
		
		.del-btn {
			color: #4cae4c;
			float:right;
			cursor:pointer;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='房源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="houseinfo/house_info_list_page">房源列表</a></li>
			<li class="active"><a href="javascript:">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源-录入跟进
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">录入跟进</p>
			</div>
			
			<div class="panel-body">
				<div class="form-group">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5" style="text-align:left;">跟进信息：<span style="color:#d9d6d3">(信息提示)</span></label>
							<div class="col-sm-9">
								<textarea type="text" class="form-control" placeholder="" v-model="info_add.info"></textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="btn btn-primary" style="display:block;width:100px;margin-left:35%;" @click="addFollowInfo()">添加</div>
						</div>
					</form>
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

	Vue.filter("formatDate", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
	  function add0(m) {
		return m<10?'0'+m:m;
	  }
	  
	  var time = new Date(parseInt(value)*1000);
	  var y = time.getFullYear();
	  var m = time.getMonth() +1;
	  var d = time.getDate();
	  return add0(y)+"/"+add0(m)+"/"+add0(d);
	});
		
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				house_info:<?=json_encode($house_info)?>,
				info_add:{
					info:'',
					employee:<?=json_encode($employee)?>
				}
			},
			computed:{
			},
			created:function() {
				if(!this.house_info.followup_infoes) {
					this.house_info.followup_infoes = [
					];
				} else {
					this.house_info.followup_infoes = JSON.parse(this.house_info.followup_infoes);
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				
			},
			methods:{
				addFollowInfo:function() {
					if(this.info_add.info == '') {
						new $.zui.Messager('跟进信息不能为空', {
							icon: 'bell' // 定义消息图标
						  }).show();
						  return;
					}
					
					this.house_info.followup_infoes.push(this.info_add);
					API.invokeModuleCall(g_host_url,'houseinfo','addFollowInfo', this.house_info, function(json) {
						history.back();
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