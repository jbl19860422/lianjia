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
	<link href="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.css" rel="stylesheet">
	
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/guest.css?v=3" rel="stylesheet">
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<!--<link href="../../../static/css/availability.css" rel="stylesheet">-->
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=4"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	<style>
		.int-com .del-btn {
			display: none;
			position: absolute;
			right: -10px;
			top: -10px;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			text-align: center;
			line-height: 17px;
			background-color: red;
			font-size: 16px;
		}
		.int-com:hover .del-btn {
			display:block;
		}
		
		span {
			font-size:1.5rem;font-weight:bolder;
		}
		
		.col-sm-12 {
			margin-top:10px;
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
		<ul class="cityinfo-menus">
			<!--<li :class="{'active':guest.entrust_type==1}"><a href="">买卖</a></li>
			<li :class="{'active':guest.entrust_type==2}"><a href="">租赁</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				消息-预约消息详情
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p" style="color: rgb(0, 0, 0); font-size: 1.8rem; font-weight: bolder;">约看消息</p> 
			</div>
			<div class="panel-body">
				<div class="guest_detail_details"  style="position:relative;margin-bottom:0px;">
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">日期：</span>
							<input type="text" class="form-control" style="width:auto;display:inline;margin-right:20px;" id="ID_Datesel"></input>
							<span style="font-size:inherit;font-weight:inherit;margin-right:20px;">开始时间：</span>
							<input type="text" class="form-control" style="width:auto;display:inline;" id="ID_startTime"></input>
							<span style="font-size:inherit;font-weight:inherit;margin-right:20px;margin-left:10px;">结束时间：</span>
							<input type="text" class="form-control" style="width:auto;display:inline;" id="ID_endTime"></input>
						</div>
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<span>约看人：</span>
							<span v-html="appsee.employee_name"></span>
						</div>
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<span>其他要求：</span>
							<span v-html="appsee.other_require"></span>
						</div>
						<!--
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<span>带看人：</span>
							<span ></span>
						</div>
						-->
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<span>约看房源：</span>
							<div class="appsee-li-div">
								<a class="card col-md-4 col-sm-6 col-lg-3" :href="'houseinfo/house_info_detail_page?house_info_id='+h.house_info_id" v-for="h in appsee.appsee_houses" v-if="h.house_info_id==curr_house_info_id">
								  <img :src="h.house.house_img" alt="">
								  <div class="card-heading"><strong v-html="h.house.community_name"></strong></div>
								  <div class="card-content text-muted" v-html="h.house.price+'万 | '+(h.house.price/h.house.area)+'万/平米'"></div>
								  <div class="card-content text-muted" v-html="h.house.area+'平米 | '+ h.house.room_count+'-'+h.house.hall_count+'-'+h.house.kitchen_count+'-'+h.house.toilet_count"></div>
								</a>
								<!--
								<dl class="appsee-li-dl">
									<dt class="appsee-li-dt">
										<img src="../../../static/admin/img/upload.png" />
									</dt>
									<dd class="appsee-li-dd">
										<p class="appsee-li-dd-p1">万科城</p>
										<p class="appsee-li-dd-p2">100万 | 10/平米</p>
										<p class="appsee-li-dd-p3">100平米 | 1-1-1-1</p>
									</dd>
								</dl>
								-->
							</div>
						</div>
						<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
							<div style="text-align:center;">
								<div class="btn btn-success btn-lg" @click="agreeSee()">同意约看</div>
								<div class="btn btn-danger btn-lg">拒绝约看</div>
							</div>
						</div>

					<div style="clear:both"></div>
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
	
	function deepCopy(obj) {
		if(typeof obj != 'object') {
			return obj;
		}
		
		if(obj instanceof Array) {
			var newArray = new Array();
			for(var i = 0; i < obj.length; i++) {
				newArray.push(deepCopy(obj[i]));
			}
			return newArray;
		} else if(obj instanceof Object) {
			var newobj = {};
	    for ( var attr in obj) {
	        newobj[attr] = deepCopy(obj[attr]);
	    }
	    return newobj;
		}
	}
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				appsee:<?=json_encode($appsee)?>,
				curr_house_info_id:<?=$_REQUEST['h_id']?>,
				start_time:'',
				end_time:'',
			},
			
			computed:{
				
			},
			created:function() {
				
			},
			watch:{
				
			},
			mounted:function() {
				var d = this.appsee.start_time.split(" ")[0];
				var s = this.appsee.start_time.split(" ")[1];
				var e = this.appsee.end_time.split(" ")[1];
				
				$(this.$el).find("#ID_Datesel").val(d);
				$(this.$el).find("#ID_Datesel").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					format: "yyyy-mm-dd"
				});
				
				$(this.$el).find("#ID_startTime").val(s);
				$(this.$el).find("#ID_startTime").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 1,
					minView: 0,
					maxView: 1,
					forceParse: 0,
					format: 'hh:ii'
				});
				
				$(this.$el).find("#ID_endTime").val(e);
				$(this.$el).find("#ID_endTime").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 1,
					minView: 0,
					maxView: 1,
					forceParse: 0,
					format: 'hh:ii'
				});
			},
			methods:{
				agreeSee:function() {
					this.start_time =  $("#ID_Datesel").val()+' '+$("#ID_startTime").val();
					this.end_time =  $("#ID_Datesel").val()+' '+$("#ID_endTime").val();
					
					API.invokeModuleCall(g_host_url, 'guest','agreeSee', {see_id:this.appsee.see_id, house_info_id:this.curr_house_info_id, start_time:this.start_time,end_time:this.end_time}, function(json) {
						if(json.code == 0) {
							history.back(-1);
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