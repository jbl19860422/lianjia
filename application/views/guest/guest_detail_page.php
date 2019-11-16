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
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/guest.css?v=3" rel="stylesheet">
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
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='客源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li :class="{'active':guest.entrust_type==1}"><a href="guest/guest_list_page">买卖</a></li>
			<li :class="{'active':guest.entrust_type==2}"><a href="guest/rent_guest_list_page">租赁</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				客源-买卖-客源详情
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-sm-12 guest_detail">
					<span v-html="guest.name"></span>
					<span>({{guest.sex=='m'?'男':'女'}})</span>
					<span class="span-x" v-html="compu_intention">★☆☆</span>
					<span>({{guest.type==1?'代理人':'决策人'}})</span>
				</div>
				
				<div class="col-sm-12 guest_detail-f">
					<span>客源编号：</span>
					<span v-html="guest.guest_id"></span>
				</div>
				
				<div class="col-sm-12 guest_detail-w">
					<span style="margin-left: 0">委托来源：</span>
					<span v-html="entrust_src"></span>
					
					<span>上次维护时间：</span>
					<span>{{guest.maintain_time|formatTime}}</span>
					
					<span>委托时间：</span>
					<span>{{guest.create_time|formatTime}}</span>
				</div>
				
				<div class="col-sm-12 guest_detail-w">
					<span style="margin-left: 0">名下房产：</span>
					<span v-html="has_house_info"></span>
					
					<span>贷款记录：{{loan_info}}</span>
					<span></span>
					
					<span>是否在链家有待售房源：</span>
					<span v-html="guest.has_sold==0?'无':'有'"></span>
				</div>
				
				<div class="col-sm-12 guest_detail-b">
					<span>标签</span>
					<div class="label" v-for="label in guest.labels" v-html="label"></div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-sm-7 guest_detail-j">
					<div>当前进度</div>
					<div>
						<div class="guest_detail-j-div">
							<div :class="{'guest_detail-div1':true,active:guest.curr_progress==0}" style="left:-1%">
								<div class="guest_detail_y">●</div>
								<div>未带看</div>
							</div>
							<div :class="{'guest_detail-div3':true,active:guest.curr_progress==1}" style="left:33.3%;">
								<div class="guest_detail_y">●</div>
								<div>已带看</div>
							</div>
							<div :class="{'guest_detail-div5':true,active:guest.curr_progress==2}" style="left:66.6%;">
								<div class="guest_detail_y">●</div>
								<div>已签约</div>
							</div>
							<div :class="{'guest_detail-div8':true,active:guest.curr_progress==3}" style="left:98%;min-width:100px;">
								<div class="guest_detail_y">●</div>
								<div>已结单</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-5 guest_detail-y">
					<div>意向小区({{intend_communities.length}})<span class="btn btn-success btn-rounded btn-small"@click="showIntentCommunityDlg()">修改</span></div>
					<div style="margin-top:10px">
						<div v-for="c in intend_communities" class="btn btn-primary int-com" style="margin-right:10px;position:relative;">
							{{c.community_name}}
							<div class="del-btn" @click="delIntCom(c)">x</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="panel panel-default guest_detail_left">
			<div class="panel-body">
				<div class="col-sm-12 guest_detail_left_div">
					<div class="guest_detail_title">
						<ul class="guest_detail_ul">
							<span style="cursor:pointer" :class="{active:tab_show==1}" @click="setShowTab(1)">需求</span>
							<span style="cursor:pointer" :class="{active:tab_show==2}" @click="setShowTab(2)">约看/带看</span>
							<span style="cursor:pointer" :class="{active:tab_show==3}" @click="setShowTab(3)">备注({{guest.remarks?guest.remarks.length:0}})</span>
						</ul>
					</div>
					<div class="panel1" v-show="tab_show==1">
						<span :class="{btn:true, 'btn-rounded':true,'btn-small':true,'btn-success':curr_require_index==index,'btn-info':curr_require_index!=index}" v-for="(require,index) in requires" @click="setRequireIndex(index)" style="margin-left:10px;margin-right:0px;">需求{{index+1}}（{{require.buy_intention | filterIntention}}）</span>
						<a class="btn btn-primary btn-rounded btn-small" style="margin-left:30px" :href="jump_add_require_page"/>新增需求</a>
						<require-com v-for="(require,index) in requires" :require="require" :areas="areas" :trade_areas="trade_areas" :index="index" v-if="curr_require_index==index" @delbuyrequire="delBuyRequire"></require-com>
					</div>
					<div class="panel1" v-show="tab_show==2">
						<div class="col-sm-12 guest_detail_title_div">	
							<div class="col-sm-2 guest_detail_col"><a href="javascript:" :class="{active:show_see_type==1}" @click="show_see_type=1">约看日程（{{guest.appsees.length}}）</a></div>
							<div class="col-sm-2 guest_detail_col"><a href="javascript:" :class="{active:show_see_type==2}" @click="show_see_type=2">带看记录（{{guest.filter_takesees.length}}）</a></div>
							<div class="col-sm-8 guest_detail_col" v-show="show_see_type==2">
								<div class="col-sm-2 guest_detail_col" style="text-align:right">时间：</div>
								<div class="col-sm-3 guest_detail_col">
									<input type="text" name="name" class="form-control time-start" placeholder="带看开始时间">
								</div>
								<div class="col-sm-1 guest_detail_col guest_detail_g">-</div>
								<div class="col-sm-3 guest_detail_col">
									<input type="text" name="name" class="form-control time-end"placeholder="带看结束时间">
								</div>
								<div class="col-sm-1 guest_detail_col guest_detail_btn" style="cursor:pointer" @click="filterTakesee()">确定</div>
							</div>
						</div>
						<div v-show="show_see_type==2">
							<p class="guest_detail_p">共计带看{{guest.filter_takesees.length}}次</p>
							
							<div class="guest_detail_details" v-for="takesee in guest.filter_takesees" style="position:relative;margin-bottom:0px;">
								<div class="dots" style="position:absolute;left:0.3rem;top:-1.2rem;font-size:2.2rem;color:#C4C4C4">●</div>
								<ul class="col-sm-12 guest_detail_details_right" style="height:auto;border-left:2px solid #C4C4C4;margin-left:10px;margin-bottom:0px;padding-bottom:2rem;">
									<li>
										<span class="details_right_span1">带看时间：</span>
										<span class="details_right_span2">{{takesee.start_time}}</span>
									</li>
									<li>
										<span class="details_right_span1">带看总结：</span>
										<span class="details_right_span2">{{takesee.summary}}</span>
									</li>
									<li>
										<span class="details_right_span1">带看房源：</span>
										<span class="details_right_span2">{{takesee.takesee_houses.length}}套</span>
									</li>
									<li>
										<span class="details_right_span1">带看人：</span>
										<span class="details_right_span2">{{takesee.takesee_employee.name}}（{{takesee.takesee_employee.work_no}}）</span>
									</li>
									<template v-for="t in takesee.takesee_houses">
										<li>
											<div class="details_right_f" style="margin-bottom:10px;">
												<a :href="'houseinfo/house_info_detail_page?house_info_id='+t.house_info_id">
													<div class="details_right_f_img">
														<img :src="t.house_img" />
													</div>
													<div class="details_right_f_right">
														<h3 v-html="t.community_name">星海名城六期</h3>
														<p class="details_right_f_right_p1">{{t.price}}万|{{t.price/t.area}}元/平米</p>
														<p class="details_right_f_right_p2">{{t.area}}平米|{{t.room_count}}-{{t.hall_count}}-{{t.kitchen_count}}-{{t.toilet_count}}</p>
														<div class="details_right_f_right_d">{{t.house_type|formatHouseType}}</div>
													</div>
												</a>
											</div>
										</li>
										<li>
											<span class="details_right_span1">带看反馈：</span>
											<span class="details_right_span2 details_right_span3" style="width:auto;padding-left:5px;padding-right:5px">{{t.customer_attitude|formatAttitude}}</span>
										</li>
									</template>
									
									<li>
										<span class="details_right_span2">陪看人等其他信息：</span>
										<span class="details_right_span4">点击展开<i class="fa fa-angle-double-down"></i></span>
									</li>
									<div style="clear:both"></div>
								</ul>
								<div style="clear:both"></div>
							</div>
						</div>
						
						<div v-show="show_see_type==1">
							<p class="guest_detail_p">共计约看{{guest.appsees.length}}次</p>
							
							<div class="guest_detail_details" v-for="appsee in guest.appsees" style="position:relative;margin-bottom:0px;">
								<div class="dots" style="position:absolute;left:0.3rem;top:-1.2rem;font-size:2.2rem;color:#C4C4C4">●</div>
								<ul class="col-sm-12 guest_detail_details_right" style="height:auto;border-left:2px solid #C4C4C4;margin-left:10px;margin-bottom:0px;padding-bottom:2rem;">
									<li>
										<span class="details_right_span1">其他要求：</span>
										<span class="details_right_span2">{{appsee.other_require}}</span>
									</li>
									<li>
										<span class="details_right_span1">约看房源：</span>
										<span class="details_right_span2">{{appsee.appsee_houses.length}}套</span>
									</li>
									<li>
										<span class="details_right_span1">带看人：</span>
										<span class="details_right_span2">{{appsee.appsee_employee.name}}（{{appsee.appsee_employee.work_no}}）</span>
									</li>
									<template v-for="house in appsee.appsee_houses">
										<li>
											<div class="details_right_f" style="margin-bottom:10px;">
												<a :href="'houseinfo/house_info_detail_page?house_info_id='+house.house_info_id">
													<div class="details_right_f_img">
														<img :src="house.house_img" />
													</div>
													<div class="details_right_f_right">
														<h3 v-html="house.community_name"></h3>
														<p class="details_right_f_right_p1">{{house.price}}万|{{house.price/house.area}}元/平米</p>
														<p class="details_right_f_right_p2">{{house.area}}平米|{{house.room_count}}-{{house.hall_count}}-{{house.kitchen_count}}-{{house.toilet_count}}</p>
														<!--<div class="details_right_f_right_d">{{t.house_type|formatHouseType}}</div>-->
													</div>
												</a>
											</div>
										</li>
										<li>
											<span class="details_right_span1">状态：</span>
											<span class="details_right_span2 details_right_span3" style="width:auto;padding-left:5px;padding-right:5px" v-html="getPlanSeeState(house.agreed)"></span>
											
										</li>
										<li>
											<span class="details_right_span1">约看时间：</span>
											<span class="details_right_span2">{{house.start_time}}--{{house.end_time}}</span>
										</li>
									</template>
									<!--
									<li>
										<span class="details_right_span2">陪看人等其他信息：</span>
										<span class="details_right_span4">点击展开<i class="fa fa-angle-double-down"></i></span>
									</li>
									-->
									<div style="clear:both"></div>
								</ul>
								<div style="clear:both"></div>
							</div>
						</div>
					
					</div>
					<div class="panel1" v-show="tab_show==3">
						<div v-for="r in guest.remarks" v-html="r" style="color:rgb(170, 170, 170);font-size:1.4rem;border-bottom:1px solid #e5e5e5;margin-bottom:10px;margin-left:40px;"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default guest_detail_right">
			<div class="panel-body">
				<div class="col-sm-12 menu guest_detail_right_div">
					<div class="guest_detail_x">联系</div>
					<div class="guest_detail_x detail-x1">
						<!--<span class="availability-span-t" style="font-size:1.5rem;font-weight:bold;color:#59a862;" data-container="body"  data-content="18579990707" data-toggle="popover" data-placement="top" :data-content="guest.mobile">查看电话</span>-->
						<span class="availability-span-t" data-container="body" data-toggle="popover" data-placement="top" data-content="">查看电话</span>
					</div>
					<div class="guest_detail_x detail-x2">维护</div>	
					<div class="guest_detail_x2" @click="addRemark()">写备注</div>
					<div class="guest_detail_x2" @click="addTakeSee(guest)">录带看</div>
					<div class="guest_detail_x2" @click="location.href='guest/add_app_see_page?guest_id='+guest.guest_id">录约看</div>
					<div class="guest_detail_x detail-x3">发起合作</div>
					
					<div class="guest_detail_x detail-x2">管理</div>	
					<a class="guest_detail_x2" style="cursor:pointer;display:block;" :href="'guest/edit_guest_page?guest_id='+guest.guest_id">基本信息修改</a>
					<div class="guest_detail_x2" @click="showCancelFollowDlg()">暂不关注</div>
					<div class="guest_detail_x2">转为已成交客户</div>
					<div class="guest_detail_x detail-x3" @click="showInvalidDlg()">无效客源</div>
					
					<div class="guest_detail_x detail-x2">其他</div>	
					<div class="guest_detail_x detail-x3">操作日志</div>
				</div>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
	<!--备注--->
	<div id="dlg_add_remark" :class="{hide:!show_dlg_add_remark}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_dlg_add_remark,'animate-hide':!show_dlg_add_remark}" id="webbox-dlg-div" style="border-radius:0px !important;width:40%;left:40%;padding:20px;height:auto;position:fixed;">
			<div class="webbox-header" style="height:auto">
				<label>写备注</label>
			</div>
			<div class="" style="margin-top:10px">
				<div class="" >
					<textarea class="form-control" placeholder="填写备注内容" v-model="remark_add"></textarea>
				</div>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="onCloseAddRemark()">关闭</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="onClickAddRemark()">保存</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--意向小区--->
	<div id="dlg_intend_community" :class="{hide:!show_dlg_intend_community}" style="display: none;">
		<div class="webbox-dlg-bg"></div>
		<div class="bu_require_n">
			<h3 class="bu_require_h3">修改意向小区：</h3>
			<form class="form-horizontal bu_require_form" style="padding:0px">
				<div style="position:relative;margin-left:0px;margin-bottom:20px;margin-right:0px;" class="form-group">
					<input class="form-control" v-model="curr_community_name"></input>
					<!--<span class="input-group-addon" style="cursor:pointer;" @click="startSearch()">确定选择</span>-->
					<div style="background-color:#fff;left:100px;position:absolute;top:34px;left:0px;text-align:left;border-left:1px solid #eee;border-right:1px solid #eee;width:100%;z-index:100;" class="search-communities">
						<ul style="margin-bottom:0px">
							<li v-for="community in filter_communities" class="c-name" style="height:35px;line-height:35px;color:#333;font-size:15px;padding-left:10px;margin-left:0px;cursor:pointer;" v-html="community.name" @click="selCommunity(community)"></li>
						</ul>
					</div>
					
				</div>
				<!--
				<div class="form-group">
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="请输入小区名称进行搜索">
					</div>
					<div class="col-sm-4">
						<button class="bu_require_btn">确定</button>
					</div>
				</div>
				-->
				<div class="form-group">
					<div class="col-sm-12">
						<p>已选择的意向小区：</p>
						<div class="bu_require_x clearfix">
							<div class="bu_require_yx clearfix" v-for="(int_com,index) in intend_comm_add">
								<p class="bu_require_yxm" v-html="int_com.name"></p>
								<div class="bu_require_s" @click="removeIntCom(index)">X</div>
							</div>							
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6 text-right">
						<a class="bu_require_q" @click="hideIntentCommunityDlg()" style="text-decoration:none;cursor:pointer">取 消</a>
					</div>
					<div class="col-sm-6">
						<a class="bu_require_b" style="text-decoration:none;cursor:pointer" @click="addIntendCommunity()">保 存</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!--暂不关注--->
	<div id="dlg_cancel_follow" :class="{hide:!show_dlg_cancel_follow}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">暂不关注</label>
			</div>
			<div class="" style="margin-top:10px">
				<input class="form-control" placeholder="请选择暂不关注时间" id="ID_dont_want_time"></input>
				<textarea class="form-control" placeholder="请填写暂不关注原因" style="margin-top:10px" v-model="guest.dont_want_reason"></textarea>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="onConfirmCancelFollow()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="onCancelShowFollow()">取消</div>
				</div>
			</div>
		</div>
	</div>
	<!--申请无效客源--->
	<div id="dlg_invalid_guest" :class="{hide:!show_dlg_invalid_guest}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">申请无效客源</label>
			</div>
			<div class="" style="margin-top:10px">
				<select class="form-control" placeholder="请选择" v-model="guest.invalid">
					<option value="1">链家成交</option>
					<option value="2">外公司成交</option>
					<option value="3">暂不考虑</option>
					<option value="4">同业经纪人</option>
				</select>
				<textarea class="form-control" placeholder="请填写无效原因" style="margin-top:10px" v-model="guest.invalid_reason"></textarea>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="onConfirmInvalid()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="onCancelInvalidDlg()">取消</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	var g_page;
	g_city_id = <?=$city_id?>;
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
		  return add0(y)+"/"+add0(m)+"/"+add0(d)+" "+add0(h)+":"+add0(minute);
		});
		
		Vue.filter("formatAttitude", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
		  var s = ['户型不满意','价钱不满意','可以考虑','满意'];
		  return s[value];
		});
		
		Vue.filter("formatHouseType", function(value) {   //全局方法 Vue.filter() 注册一个自定义过滤器,必须放在Vue实例化前面
		  var s = ['本房','同户型','反户型'];
		  return s[value];
		});
		
		Vue.component('require-com',{
			props:['require','areas','trade_areas','index'],
			filters:{
				filterIntention:function(val){
					var arr = ['投资','改善','刚需'];
					return arr[val];
				},
				filterTime:function(now) {
					var tt=new Date(parseInt(now) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ") 
					return tt; 
				},
				filterPayMethod:function(val) {
					var m = ['不限','一次性付款','按揭'];
					return m[val];
				}
			},
			data:function() {
				return {
					rooms:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
					halls:[0,1,2,3,4,5,6,7,8,9,10],
					editting:false,
					editting_require:{}
				}
			},
			methods:{
				delRequire:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','delBuyRequire', this.require, function(json) {
						if(json.code == 0) {
							that.$emit('delbuyrequire', that.require);
						}
					});
				},
				cancelUpdate:function() {
					this.editting = false;
				},
				updateRequire:function() {
					for(var i = 0; i < this.editting_require.buy_trade_areas.length; i++) {
						if(this.editting_require.buy_trade_areas[i].ta_id == 0) {
							alert('请选择商圈');
							return;
						}
					}
					console.log(this.editting_require);
					var that = this;
					API.invokeModuleCall(g_host_url, 'guest', 'updateBuyRequire', this.editting_require, function(json) {
						if(json.code == 0) {
							that.require = deepCopy(that.editting_require);
							that.editting = false;
						}
					});
				},
				startEdit:function() {
					this.editting = true;
					this.editting_require = deepCopy(this.require);
				},
				addTradeArea:function() {
					if(this.editting_require.buy_trade_areas.length <= 2) {
						this.editting_require.buy_trade_areas.push({ta_id:0,name:''});
					}
				},
				setDecoration:function(e,d) {
					if(d == 0) {
						if(this.editting_require.buy_decoration.indexOf(d) < 0){
							this.editting_require.buy_decoration = [0];
							$(e.target).prop("checked",true);
							$(e.target).siblings("input").prop('checked',false);
						} else {
							var pos = this.editting_require.buy_decoration.indexOf(d);
							this.editting_require.buy_decoration.splice(pos,1);
							$(e.target).attr("checked",false);
						}
						return;
					}
					
					if(this.editting_require.buy_decoration.indexOf(d) < 0){
						this.editting_require.buy_decoration.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.editting_require.buy_decoration.indexOf(0);
						if(pos >= 0) {
							this.editting_require.buy_decoration.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.editting_require.buy_decoration.indexOf(d);
						this.editting_require.buy_decoration.splice(pos,1);
					}
				},
				setAge:function(e,d) {
					if(d == 0) {
						if(this.editting_require.buy_age.indexOf(d) < 0){
							this.editting_require.buy_age = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.editting_require.buy_age.indexOf(d);
							this.editting_require.buy_age.splice(pos,1);
							$(e.target).prop("checked",false);
							return;
						}
					}
					
					if(this.editting_require.buy_age.indexOf(d) < 0){
						this.editting_require.buy_age.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.editting_require.buy_age.indexOf(0);
						if(pos >= 0) {
							this.editting_require.buy_age.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.editting_require.buy_age.indexOf(d);
						this.editting_require.buy_age.splice(pos,1);
					}
				},
				setOrientation:function(e,o) {
					if(o == 0) {
						if(this.editting_require.buy_orientation.indexOf(o) < 0){
							this.editting_require.buy_orientation = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.editting_require.buy_orientation.indexOf(o);
							this.editting_require.buy_orientation.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.editting_require.buy_orientation.indexOf(o) < 0){
						this.editting_require.buy_orientation.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.editting_require.buy_orientation.indexOf('a');
						if(pos >= 0) {
							this.editting_require.buy_orientation.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.editting_require.buy_orientation.indexOf(o);
						this.editting_require.buy_orientation.splice(pos,1);
					}
				},
				setFloor:function(e,o) {
					if(o == 0) {
						if(this.editting_require.buy_floor.indexOf(o) < 0){
							this.editting_require.buy_floor = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.editting_require.buy_floor.indexOf(o);
							this.editting_require.buy_floor.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.editting_require.buy_floor.indexOf(o) < 0){
						this.editting_require.buy_floor.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.editting_require.buy_floor.indexOf(0);
						if(pos >= 0) {
							this.editting_require.buy_floor.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.editting_require.buy_floor.indexOf(o);
						this.editting_require.buy_floor.splice(pos,1);
					}
				},
			},
			computed:{
				load_info:function() {
					var s = ['已还清','未还清','全部结清','一次未结清','两次未结清'];
					return s[this.guest.loan_type];
				},
				area_name:function() {
					for(var i = 0; i < this.areas.length; i++) {
						if(this.areas[i].area_id == this.require.buy_area_id) {
							return this.areas[i].name;
						}
					}
					return '';
				},
				trade_area_names:function() {
					var names = [];
					for(var i = 0; i < this.require.buy_trade_areas.length; i++) {
						names.push(this.require.buy_trade_areas[i].name);
					}
					console.log(names);
					return names.join(",");
				},
				decoration:function() {
					var arr = ['不限','毛坯','简装','精装'];
					var ds = [];
					for(var i = 0; i < this.require.buy_decoration.length; i++) {
						ds.push(arr[this.require.buy_decoration[i]]);
					}
					return ds.join(",");
				},
				floor:function() {
					var arr = ['不限','低楼层','中楼层','高楼层','不要一层','不要顶层'];
					var ds = [];
					for(var i = 0; i < this.require.buy_floor.length; i++) {
						ds.push(arr[this.require.buy_floor[i]]);
					}
					return ds.join(",");
				},
				orientation:function() {
					var arr = ['不限','东','东南','南','西南','西','西北','北','东北'];
					var ds = [];
					for(var i = 0; i < this.require.buy_orientation.length; i++) {
						ds.push(arr[this.require.buy_orientation[i]]);
					}
					return ds.join(",");
				},
				age:function() {
					var arr = ['不限','5年内','5-10年','10-15年','15-20年','20年以上'];
					var ds = [];
					for(var i = 0; i < this.require.buy_age.length; i++) {
						ds.push(arr[this.require.buy_age[i]]);
					}
					return ds.join(",");
				}
			},
			updated:function() {
				if(this.editting) {//编辑状态
					var decorations = $(this.$el).find(".edit-decoration input");
					for(var i = 0; i < 4; i++) {
						console.log(this.editting_require.buy_decoration);
						if(this.editting_require.buy_decoration.indexOf(i+"") >= 0) {
							decorations.eq(i).prop("checked", true);
						} else {
							decorations.eq(i).prop("checked", false);
						}
					}
					
					for(var i = 0; i < 9; i++){
						if(this.editting_require.buy_floor.indexOf(i+"")>=0) {
							$(this.$el).find(".edit-orientation input[value="+i+"]").prop("checked",true);
						} else {
							$(this.$el).find(".edit-orientation input[value="+i+"]").prop("checked",false);
						}
					}
					
					for(var i = 0; i < 6; i++){
						if(this.editting_require.buy_floor.indexOf(i+"")>=0) {
							$(this.$el).find(".edit-floor input[value="+i+"]").prop("checked",true);
						} else {
							$(this.$el).find(".edit-floor input[value="+i+"]").prop("checked",false);
						}
					}
					
					for(var i = 0; i < 5; i++){
						if(this.editting_require.buy_age.indexOf(i+"")>=0) {
							$(this.$el).find(".edit-age input[value="+i+"]").prop("checked",true);
						} else {
							$(this.$el).find(".edit-age input[value="+i+"]").prop("checked",false);
						}
					}
				}
			},
			created:function() {
				
			},
			template:
			'<div>'+
				'<div v-if="!editting">'+
					'<div class="qqq" style="margin-top:10px;font-size:1.5rem;margin-left:0px;">'+
						'<span style="font-weight:bold;font-size:inherit;">更新时间</span><span style="margin-left:10px;font-size:inherit;">{{require.update_time | formatTime}}</span><span class="btn btn-primary btn-rounded btn-small" style="font-size:1.2rem;font-weight:bold;margin-left:30px;" @click="startEdit()">修改</span>'+
						'<span class="btn btn-danger btn-rounded btn-small" style="font-size:1.2rem;font-weight:bold;margin-left:30px;" @click="delRequire()">删除</span>'+
					'</div>'+
					'<div style="margin-top:10px">'+
						'<div style="font-weight:bold;font-size:2rem;float:left;margin-left:0px;">需求类型</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
						'<div style="clear:both"></div>'+
						
						'<div style="font-size:1.5rem;margin-top:20px;">'+
							'<span style="font-weight:bold;font-size:inherit">购房目的：</span>'+
							'<span style="margin-left:10px;color:#aaa;font-size:inherit" >{{require.buy_intention | filterIntention}}<span>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;margin-top:10px;">'+
							'<span style="font-weight:bold;font-size:inherit">用途：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" >普通住宅<span>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;margin-top:10px;">'+
							'<span style="font-weight:bold;font-size:inherit">首付：</span>'+
							'<span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_firstpay_min}}-{{require.buy_firstpay_max}}万<span>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">月供：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_monthpay_min}}-{{require.buy_monthpay_max}}元<span></div>'+
					'</div>'+
					
					'<div style="margin-top:10px">'+
						'<div style="font-weight:bold;font-size:2rem;float:left;margin-left:0px;">基本需求</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
						'<div style="clear:both"></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">心理价位：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_price_min}}-{{require.buy_price_max}}万<span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">面积：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_area_min}}-{{require.buy_area_max}}㎡<span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">居室：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_room_min}}-{{require.buy_room_max}}居<span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">付款方式：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{require.buy_pay_method | filterPayMethod}}<span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">区域：</span><span style="margin-left:10px;color:#aaa;font-size:inherit">{{area_name}}<span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">商圈：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" v-html="trade_area_names"><span></div>'+
					'</div>'+
					
					'<div style="margin-top:10px">'+
						'<div style="font-weight:bold;font-size:2rem;float:left;;margin-left:0px;">其他需求</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
						'<div style="clear:both"></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">装修：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" v-html="decoration"><span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">朝向：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" v-html="orientation"><span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">楼层：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" v-html="floor"><span></div>'+
						'<div style="font-size:1.5rem;margin-top:10px;"><span style="font-weight:bold;font-size:inherit">楼龄：</span><span style="margin-left:10px;color:#aaa;font-size:inherit" v-html="age"><span></div>'+
					'</div>'+
				'</div>'+
				'<div v-if="editting">'+
					'<div style="margin-top:10px;font-size:1.5rem;">'+
						'<span style="font-weight:bold;font-size:inherit;">更新时间</span><span style="margin-left:10px;font-size:inherit;">{{editting_require.update_time | formatTime}}</span>'+
					'</div>'+
					'<div style="margin-top:10px">'+
						'<div style="font-weight:bold;font-size:2rem;float:left;">需求类型</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
						'<div style="clear:both"></div>'+
						
						'<div style="font-weight:bold;font-size:1.5rem;margin-top:20px;">'+
							'<span style="color:red;font-weight:bold;font-size:inherit">*</span>购房目的：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_intention">'+
								'<option value="0">投资</option>'+
								'<option value="1">改善</option>'+
								'<option value="2">刚需</option>'+
							'</select>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;font-weight:bold;margin-top:10px;">'+
							'<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>用&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;途：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_usage">'+
								'<option value="0">住宅</option>'+
								'<option value="1">写字楼</option>'+
								'<option value="2">商铺</option>'+
								'<option value="3">商务公寓</option>'+
							'</select>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;margin-top:10px;">'+
							'<div style="float: left;font-size: 1.5rem;font-weight: bolder;height: 34px;line-height: 34px;margin-top: 0px;margin-left: 0px;margin-right: 0px;">'+
								'<span style="color:red;font-size:1.5rem;font-weight:bolder;margin-right:20px;margin-left:0px;">&nbsp;</span>首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付：'+
							'</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_firstpay_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">万元</div></input>'+
							'</div>'+
							'<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_firstpay_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">万元</div></input>'+
							'</div>'+
							'<div style="clear:both"></div>'+
						'</div>'+
						
						'<div style="font-size:1.5rem;margin-top:10px;">'+
							'<div style="float: left;font-size: 1.5rem;font-weight: bolder;height: 34px;line-height: 34px;margin-top: 0px;margin-left: 0px;margin-right: 0px;">'+
								'<span style="color:red;font-size:1.5rem;font-weight:bolder;margin-right:20px;margin-left:0px;">&nbsp;</span>月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;供：'+
							'</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_monthpay_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">元</div></input>'+
							'</div>'+
							'<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_monthpay_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">元</div></input>'+
							'</div>'+
							'<div style="clear:both"></div>'+
						'</div>'+
					'</div>'+
					'<div style="margin-top:10px">'+
						'<div style="font-weight:bold;font-size:2rem;float:left;">基本需求</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
						'<div style="clear:both"></div>'+
						'<div style="margin-top:20px">'+
							'<div style="float: left;font-size: 1.5rem;font-weight: bolder;height: 34px;line-height: 34px;margin-top: 0px;margin-left: 0px;margin-right: 0px;">'+
								'<span style="color:red;font-size:1.5rem;font-weight:bolder;margin-right:20px;margin-left:0px;">*</span>心理价位：'+
							'</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_price_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">万元</div></input>'+
							'</div>'+
							'<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_price_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">万元</div></input>'+
							'</div>'+
							'<div style="clear:both"></div>'+
						'</div>'+
						'<div style="font-size:1.5rem;margin-top:10px;">'+
							'<div style="float: left;font-size: 1.5rem;font-weight: bolder;height: 34px;line-height: 34px;margin-top: 0px;margin-left: 0px;margin-right: 0px;">'+
								'<span style="color:red;font-size:1.5rem;font-weight:bolder;margin-right:20px;margin-left:0px;">*</span>面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积：'+
							'</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_area_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">㎡</div></input>'+
							'</div>'+
							'<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>'+
							'<div style="position:relative;float:left;">'+
								'<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="editting_require.buy_area_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">㎡</div></input>'+
							'</div>'+
							'<div style="clear:both"></div>'+
						'</div>'+
						'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;">'+
							'<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_room_min">'+
								'<option v-for="room in rooms" :value="room" v-html="room+\'居\'"></option>'+
							'</select>'+
							'<span>-</span>'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_room_max">'+
								'<option v-for="room in rooms" :value="room" v-html="room+\'居\'"></option>'+
							'</select>'+
						'</div>'+
						'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;">'+
							'<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>付款方式：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_pay_method">'+
								'<option value="0">不限</option>'+
								'<option value="1">一次性付款</option>'+
								'<option value="2">按揭</option>'+
							'</select>'+
						'</div>'+
						'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;">'+
							'<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>区&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;域：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_area_id">'+
								'<option v-for="area in areas" :value="area.area_id" v-html="area.name"></option>'+
							'</select>'+
						'</div>'+
						'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;">'+
							'<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>商&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;圈：'+
							'<select class="form-control" style="width:auto;display:inline;" v-model="editting_require.buy_trade_areas[0].ta_id" @change="selectTradeArea(0,$event)">'+
								'<option value="0" style="display:none">请选择</option>'+
								'<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==editting_require.buy_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>'+
							'</select>'+
							'<span class="btn btn-primary btn-rounded btn-small" style="margin-left:20px" @click="addTradeArea()">添加商圈</span>'+
							'<div v-for="(t,index) in editting_require.buy_trade_areas" v-if="index>=1" style="margin-top:10px">'+
								'<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
								'<select class="form-control" style="width:auto;display:inline;" v-model="t.ta_id" @change="selectTradeArea(index,$event)">'+
									'<option value="0" style="display:none">请选择</option>'+
									'<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==editting_require.buy_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>'+
								'</select>'+
								'<span class="btn btn-danger btn-rounded btn-small" style="margin-left:20px" @click="delTradeId(index)">删除</span>'+
							'</div>'+
						'</div>'+
						'<div style="margin-top:10px">'+
							'<div style="font-weight:bold;font-size:2rem;float:left;">其他需求</div><div style="width:90%;height:17px;float:left;border-bottom:2px solid #ccc"></div>'+
							'<div style="clear:both"></div>'+
							'<div style="font-size:1.5rem;margin-top:10px;" class="edit-decoration">'+
								'<span style="font-weight:bold;font-size:inherit;margin-right:0px;">装修：</span>'+
								'<input type="checkbox" class="checkbox-inline" @click="setDecoration($event,0)"></input>'+
								'<label style="font-size:1.2rem;color:#999">不限</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,1)"></input>'+
								'<label style="font-size:1.2rem;color:#999">毛坯</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,2)"></input>'+
								'<label style="font-size:1.2rem;color:#999">简装</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,3)"></input>'+
								'<label style="font-size:1.2rem;color:#999">精装</label>'+
							'</div>'+
							'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;" class="edit-orientation">'+
								'朝向：'+
								'<input type="checkbox" class="checkbox-inline" @click="setOrientation($event,0)" value="0"></input>'+
								'<label style="font-size:1.2rem;color:#999">不限</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,1)" value="1"></input>'+
								'<label style="font-size:1.2rem;color:#999">东</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,2)" value="2"></input>'+
								'<label style="font-size:1.2rem;color:#999">东南</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,3)" value="3"></input>'+
								'<label style="font-size:1.2rem;color:#999">南</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,4)" value="4"></input>'+
								'<label style="font-size:1.2rem;color:#999">西南</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,5)" value="5"></input>'+
								'<label style="font-size:1.2rem;color:#999">西</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,6)" value="6"></input>'+
								'<label style="font-size:1.2rem;color:#999">西北</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,7)" value="7"></input>'+
								'<label style="font-size:1.2rem;color:#999">北</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,8)" value="8"></input>'+
								'<label style="font-size:1.2rem;color:#999">东北</label>'+
							'</div>'+
							'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;" class="edit-floor">'+
								'楼层：'+
								'<input type="checkbox" class="checkbox-inline" @click="setFloor($event,0)" value="0"></input>'+
								'<label style="font-size:1.2rem;color:#999">不限</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,1)" value="1"></input>'+
								'<label style="font-size:1.2rem;color:#999">低楼层</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,2)" value="2"></input>'+
								'<label style="font-size:1.2rem;color:#999">中楼层</label>	'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,3)" value="3"></input>'+
								'<label style="font-size:1.2rem;color:#999">高楼层</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,4)" value="4"></input>'+
								'<label style="font-size:1.2rem;color:#999">不要一层</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,5)" value="5"></input>'+
								'<label style="font-size:1.2rem;color:#999">不要顶层</label>'+
							'</div>'+
							'<div style="font-size:1.5rem;margin-top:10px;font-weight:bold;" class="edit-age">'+
								'楼龄：'+
								'<input type="checkbox" class="checkbox-inline" @click="setAge($event,0)" value="0"></input>'+
								'<label style="font-size:1.2rem;color:#999">不限</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,1)" value="1"></input>'+
								'<label style="font-size:1.2rem;color:#999">5年内</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,2)" value="2"></input>'+
								'<label style="font-size:1.2rem;color:#999">5-10年</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,3)" value="3"></input>'+
								'<label style="font-size:1.2rem;color:#999">10-15年</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,4)" value="4"></input>'+
								'<label style="font-size:1.2rem;color:#999">15-20年</label>'+
								'<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,5)" value="5"></input>'+
								'<label style="font-size:1.2rem;color:#999">20年以上</label>'+
							'</div>'+
						'</div>'+
						'<div class="col-sm-12" style="font-size:2.5rem;font-weight:bolder;text-align:center;margin-bottom:20px;margin-top:20px;">'+
							'<span class="btn btn-success btn-rounded btn-big" style="width:20%;font-size:2rem;margin-right:20px;" @click="updateRequire()">修改</span>'+
							'<span class="btn btn-info btn-rounded btn-big" style="width:20%;font-size:2rem;" @click="cancelUpdate()">取消</span>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'
		});
		
		g_page = new Vue({
			el:'#content_warp',
			data:{
				show_see_type:1,//1约看，2：带看
				tab_show:1,
				show_dlg_add_remark:false,
				show_dlg_cancel_follow:false,
				show_dlg_invalid_guest:false,
				show_dlg_intend_community:false,
				remark_add:'',
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				rooms:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
				halls:[0,1,2,3,4,5,6,7,8,9,10],
				show_add_label_dlg:false,
				add_label_name:'',
				entrust_srcs:[
					{
						name:'实体开发',
						sub_srcs:[
						]
					},
					{
						name:'人际开发',
						sub_srcs:[
						]
					},
					{
						name:'二次开发',
						sub_srcs:[
						]
					},
					{
						name:'其他网络',
						sub_srcs:[
						]
					}
				],
				curr_community_name:'',
				filter_communities:[],
				curr_back_require:{},
				editting:false,
				requires:<?=json_encode($requires)?>,
				guest:<?=json_encode($guest)?>,
				communities:<?=json_encode($communities)?>,
				intend_communities:<?=json_encode($intend_communities)?>,
				intend_comm_add:[],
				takesee_start_time:'',
				takesee_end_time:'',
				curr_require_index:0
			},
			filters:{
				filterIntention:function(val){
					var arr = ['投资','改善','刚需'];
					return arr[val];
				},
				filterTime:function(now) {
					var tt=new Date(parseInt(now) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ") 
					return tt; 
				},
				filterPayMethod:function(val) {
					var m = ['不限','一次性付款','按揭'];
					return m[val];
				}
			},
			computed:{
				jump_add_require_page:function() {
					if(this.guest.entrust_type == 1) {
						return 'guest/add_buy_require_page?guest_id='+this.guest.guest_id;
					} else {
						return 'guest/add_rent_require_page?guest_id='+this.guest.guest_id;
					}
				},
				has_house_info:function() {
					console.log(this.guest.has_house);
					var arr = ['无','一套','一套以上'];
					return arr[this.guest.has_house];
				},
				compu_intention:function() {
					var inte = parseInt(this.guest.intention);
					console.log('inte=',inte);
					if(inte == 0) {
						return '☆☆☆';
					} else if(inte == 1) {
						return '★☆☆';
					} else if(inte == 2) {
						return '★★☆';
					} else if(inte == 3) {
						return '★★★';
					}
				},
				entrust_src:function() {
					return this.entrust_srcs[this.guest.entrust_src1].name;
				},
				loan_info:function() {
					console.log(this.guest.has_loan);
					var arr = ['无','一次','一次以上'];
					return arr[this.guest.has_loan];
				}
			},
			created:function() {
				if(!this.guest.appsees) {
					this.guest.appsees = [];
				}
				this.guest.filter_takesees = this.guest.takesees;
				if(this.guest.labels) {
					this.guest.labels = this.guest.labels.split("|");
				} else {
					this.guest.labels = [];
				}
				var that = this;
				API.invokeModuleCall(g_host_url,'cityinfo','queryCityAreaAndTradeArea', {city_id:g_city_id},function(json) {
					that.areas = json.areas;
					that.trade_areas = json.trade_areas;
				});
				
				for(var i = 0;i < this.requires.length; i++) {
					this.requires[i].buy_trade_areas = JSON.parse(this.requires[i].buy_trade_areas);
					this.requires[i].buy_decoration = this.requires[i].buy_decoration.split("|");
					this.requires[i].buy_orientation = this.requires[i].buy_orientation.split("|");
					this.requires[i].buy_floor = this.requires[i].buy_floor.split("|");
					this.requires[i].buy_age = this.requires[i].buy_age.split("|");
				}
				
				if(this.requires.length > 0) {
					this.curr_require = this.requires[0];
				}
				if(this.guest.mobiles && this.guest.mobiles != '') {
					this.guest.mobiles = this.guest.mobiles.split("|");
					for(var i = 0; i < this.guest.mobiles.length; i++) {
						if(this.guest.mobiles[i] == '') {
							this.guest.mobiles.splice(i,1);
							break;
						}
					}
				} else {
					this.guest.mobiles = [];
				}
				
				if(this.guest.remarks && this.guest.remarks != '') {
					this.guest.remarks = JSON.parse(this.guest.remarks);
				} else {
					this.guest.remarks = [];
				}
			},
			watch:{
				curr_community_name:function(val) {
					this.filter_communities = [];
					if(val == "") {
						this.filter_communities = [];
						return;
					}
					var str = /^[A-Za-z]*$/;
					val = val.toUpperCase();
					if (/*str.test(val)*/true) {//是字母，则判断
						for(var i = 0; i < this.communities.length; i++) {
							if(this.communities[i].retriving_info) {
								if(this.communities[i].retriving_info.indexOf(val) >= 0 || this.communities[i].name.indexOf(val) >= 0) {
									this.filter_communities.push(this.communities[i]);
								}
							}
						}
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_remark").css("display",'');
				$(this.$el).find("#dlg_cancel_follow").css("display","");
				$(this.$el).find("#dlg_invalid_guest").css("display","");
				$(this.$el).find("#dlg_intend_community").css("display","");
				
				$(this.$el).find('.availability-span-t').attr("data-content",this.guest.mobiles[0]);
				$(this.$el).find('.availability-span-t').popover({html: true, trigger: 'hover'});
				$(this.$el).find('.availability-span-d').popover({html: true, trigger: 'hover'});
				
				$(this.$el).find("#ID_dont_want_time").datetimepicker(
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
				
				var date = new Date();
				date.setTime(date.getTime()-24*60*60*1000);
				var month = date.getMonth() + 1;
				var strDate = date.getDate();
				if (month >= 1 && month <= 9) {
					month = "0" + month;
				}
				
				if (strDate >= 0 && strDate <= 9) {
					strDate = "0" + strDate;
				}
				
				var yesterdaydate = date.getFullYear() + "-" + month + "-" + strDate + " " + date.getHours() + ":" + date.getMinutes();
				
				date = new Date();
				month = date.getMonth() + 1;
				strDate = date.getDate();
				if (month >= 1 && month <= 9) {
					month = "0" + month;
				}
				
				if (strDate >= 0 && strDate <= 9) {
					strDate = "0" + strDate;
				}
				
				var terdaydate = date.getFullYear() + "-" + month + "-" + strDate + " " + date.getHours() + ":" + date.getMinutes();
				
				$(this.$el).find(".time-start").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
					showMeridian: 1,
					startDate:yesterdaydate,
					endDate:terdaydate,
					format: "yyyy-mm-dd hh:ii"
				}); 
												
				$(this.$el).find(".time-end").datetimepicker(
				{
					language:  "zh-CN",
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
					showMeridian: 1,
					startDate:yesterdaydate,
					endDate:terdaydate,
					format: "yyyy-mm-dd hh:ii"
				}); 
			},
			methods:{
				getPlanSeeState:function(val) {
					var s = ['未处理','可约','不可约'];
					return s[val];
				},
				filterTakesee:function() {
					this.takesee_start_time =  $(".time-start").val();
					this.takesee_end_time =  $(".time-end").val();
					this.guest.filter_takesees = [];
					for(var i = 0; i < this.guest.takesees.length; i++) {
						if(this.guest.takesees[i].start_time > this.takesee_start_time && this.guest.takesees[i].end_time <= this.takesee_end_time) {
							this.guest.filter_takesees.push(this.guest.takesees[i]);
						}
					}
					this.$forceUpdate();
				},
				delBuyRequire:function(r) {
					for(var i = 0;i < this.requires.length; i++) {
						if(this.requires[i].require_id == r.require_id) {
							this.requires.splice(i,1);
							showMsg('删除成功');
							break;
						}
					}
				},
				selectTradeArea:function(index,e) {
					console.log(e);
					var val = $(e.target).val();
					for(var i = 0; i < this.trade_areas.length; i++) {
						if(this.trade_areas[i].ta_id == val) {
							this.require_add.buy_trade_areas[index].ta_id = val;
							this.require_add.buy_trade_areas[index].name = this.trade_areas[i].name;
							break;
						}
					}
				},
				delIntCom:function(c) {
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','delIntendCommunity',c,function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.intend_communities.length; i++) {
								if(that.intend_communities[i].id == c.id) {
									that.intend_communities.splice(i,1);
									break;
								}
							}
						}
						that.show_dlg_intend_community = false;
					});
				},
				addIntendCommunity:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','addIntendCommunity',{guest_id:this.guest.guest_id,coms_add:this.intend_comm_add},function(json) {
						if(json.code == 0) {
							that.intend_communities = that.intend_communities.concat(json.intend_communities);
						}
						that.show_dlg_intend_community = false;
					});
				},
				removeIntCom:function(index) {
					this.intend_comm_add.splice(index,1);
				},
				selCommunity:function(community) {
					this.curr_community_name = "";
					this.intend_comm_add.push(community);
				},
				showIntentCommunityDlg:function() {
					this.show_dlg_intend_community = true;
				},
				hideIntentCommunityDlg:function() {
					this.show_dlg_intend_community = false;
				},
				onConfirmInvalid:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, 'guest','editGuest',this.guest, function(json) {
						if(json.code == 0) {
							that.show_dlg_invalid_guest = false;
						}
					});
				},
				onCancelInvalidDlg:function() {
					this.show_dlg_invalid_guest = false;
				},
				showInvalidDlg:function() {
					this.show_dlg_invalid_guest = true;
				},
				onCancelShowFollow:function() {
					this.show_dlg_cancel_follow = false;
				},
				onConfirmCancelFollow:function() {
					var timestamp2 = Date.parse(new Date($("#ID_dont_want_time").val()));
					timestamp2 = timestamp2 / 1000;
					this.guest.intention = 0;//暂不关注
					this.guest.dont_want = 1;
					this.guest.dont_want_time = timestamp2;
					var that = this;
					API.invokeModuleCall(g_host_url, 'guest','editGuest',this.guest, function(json) {
						if(json.code == 0) {
							that.show_dlg_cancel_follow = false;
						}
					});
				},
				showCancelFollowDlg:function() {
					this.show_dlg_cancel_follow = true;
				},
				setShowTab:function(tab) {
					this.tab_show = tab;
				},
				addRemark:function() {
					this.show_dlg_add_remark = true;
				},
				onCloseAddRemark:function() {
					this.show_dlg_add_remark = false;
				},
				onClickAddRemark:function() {
					console.log(typeof this.guest.remarks);
					this.guest.remarks.push(this.remark_add);
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','editGuest',this.guest, function(json) {
						if(json.code == 0) {
							showMsg("添加成功");
							that.show_dlg_add_remark = false;
						}
					});
				},
				addTakeSee:function(guest) {
					location.href = "guest/add_take_see_page?guest_id="+guest.guest_id;
				},
				setRequireIndex:function(index) {
					this.curr_require_index = index;
				},
				setDecoration:function(e,d) {
					if(d == 0) {
						if(this.require_add.buy_decoration.indexOf(d) < 0){
							this.require_add.buy_decoration = [0];
							$(e.target).prop("checked",true);
							$(e.target).siblings("input").prop('checked',false);
						} else {
							var pos = this.require_add.buy_decoration.indexOf(d);
							this.require_add.buy_decoration.splice(pos,1);
							$(e.target).attr("checked",false);
						}
						return;
					}
					
					if(this.require_add.buy_decoration.indexOf(d) < 0){
						this.require_add.buy_decoration.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_decoration.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_decoration.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_decoration.indexOf(d);
						this.require_add.buy_decoration.splice(pos,1);
					}
				},
				setAge:function(e,d) {
					if(d == 0) {
						if(this.require_add.buy_age.indexOf(d) < 0){
							this.require_add.buy_age = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_age.indexOf(d);
							this.require_add.buy_age.splice(pos,1);
							$(e.target).prop("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_age.indexOf(d) < 0){
						this.require_add.buy_age.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_age.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_age.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_age.indexOf(d);
						this.require_add.buy_age.splice(pos,1);
					}
				},
				setOrientation:function(e,o) {
					if(o == 0) {
						if(this.require_add.buy_orientation.indexOf(o) < 0){
							this.require_add.buy_orientation = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_orientation.indexOf(o);
							this.require_add.buy_orientation.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_orientation.indexOf(o) < 0){
						this.require_add.buy_orientation.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_orientation.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_orientation.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_orientation.indexOf(o);
						this.require_add.buy_orientation.splice(pos,1);
					}
				},
				setFloor:function(e,o) {
					if(o == 0) {
						if(this.require_add.buy_floor.indexOf(o) < 0){
							this.require_add.buy_floor = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_floor.indexOf(o);
							this.require_add.buy_floor.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_floor.indexOf(o) < 0){
						this.require_add.buy_floor.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_floor.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_floor.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_floor.indexOf(o);
						this.require_add.buy_floor.splice(pos,1);
					}
				},
				addTradeArea:function() {
					if(this.require_add.buy_trade_areas.length <= 2) {
						this.require_add.buy_trade_areas.push({ta_id:0,name:''});
					}
				},
				delTradeId:function(ind) {
					this.require_add.buy_trade_areas.splice(ind,1);
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