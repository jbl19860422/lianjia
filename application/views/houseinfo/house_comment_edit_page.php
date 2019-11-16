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
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
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
				房源-房源点评
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">房源点评<span>(3)</span></p>
			</div>
			
			<div class="panel-body">
				<div class="form-group">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5">1、房源标题<span style="color:#d9d6d3">(15-25个汉字)</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="15~25个汉字" v-model="house_info.comment_title">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5">2、请选择你要点评的纬度<span style="color:#d9d6d3">(至少选择3项，最多选择6项)</span></label>
							<div class="col-sm-9">
								<template v-for="comment in comments">
									<span :class="{'dim-item':true,sel:if_sel('selling_point')}" @click="addComment('selling_point')">核心卖点</span>
									<span :class="{'dim-item':true,sel:if_sel('house_type')}" @click="addComment('house_type')">户型介绍</span>
									<span :class="{'dim-item':true,sel:if_sel('decoration')}" @click="addComment('decoration')">装修描述</span>
									<span :class="{'dim-item':true,sel:if_sel('tax')}" @click="addComment('tax')">税费解析</span>
									<span :class="{'dim-item':true,sel:if_sel('ownership')}" @click="addComment('ownership')">权属抵押</span>
									<span :class="{'dim-item':true,sel:if_sel('traffic')}" @click="addComment('traffic')">交通出行</span>
									<span :class="{'dim-item':true,sel:if_sel('education')}" @click="addComment('education')">教育配套</span>
									<span :class="{'dim-item':true,sel:if_sel('peripheral')}" @click="addComment('peripheral')">周边配套</span>
									<span :class="{'dim-item':true,sel:if_sel('community')}" @click="addComment('community')">小区介绍</span>
									<span :class="{'dim-item':true,sel:if_sel('target_users')}" @click="addComment('target_users')">适宜人群</span>
									<span :class="{'dim-item':true,sel:if_sel('house_sale')}" @click="addComment('house_sale')">房售详情</span>
								</template>
							</div>
						</div>
						<template v-for="(c,i) in house_info.comments">
							<div class="form-group" v-if="c.type=='selling_point'">
								<label class="col-sm-9">核心卖点<span style="color:#d9d6d3">(必填项)</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='house_type'">
								<label class="col-sm-9">户型介绍<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='decoration'">
								<label class="col-sm-9">装修描述<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='tax'">
								<label class="col-sm-9">税费解析<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='ownership'">
								<label class="col-sm-9">权属抵押<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='traffic'">
								<label class="col-sm-9">交通出行<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							<div class="form-group" v-if="c.type=='education'">
								<label class="col-sm-9">教育配套<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							
							<div class="form-group" v-if="c.type=='peripheral'">
								<label class="col-sm-9">周边配套<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							
							<div class="form-group" v-if="c.type=='community'">
								<label class="col-sm-9">小区介绍<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							
							<div class="form-group" v-if="c.type=='target_users'">
								<label class="col-sm-9">适宜人群<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
							
							<div class="form-group" v-if="c.type=='house_sale'">
								<label class="col-sm-9">房售详情<span class="del-btn" @click="delComment(i)">删除</span></label>
								<div class="col-sm-9">
									<textarea type="text" class="form-control" placeholder="" v-model="c.info"></textarea>
								</div>
							</div>
						</template>
						<div class="form-group">
							<div class="btn btn-primary" style="display:block;width:100px;margin-left:35%;" @click="saveComment()">保存</div>
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
				comments:[
					{
						type:'selling_point',
						info:'核心卖点'
					}
				]
			},
			computed:{
				if_selling_point:function() {
					for(var i = 0; i < this.house_info.comments.length; i++) {
						if(this.house_info.comments[i].type == 'selling_point') {
							
						}
					}
				}
			},
			created:function() {
				this.house_info.comments = JSON.parse(this.house_info.comments);
				if(!this.house_info.comments) {
					this.house_info.comments = [
						{type:'selling_point',info:''}
					];
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				
			},
			methods:{
				delComment:function(i) {
					this.house_info.comments.splice(i,1);
				},
				addComment:function(type) {
					
					if(this.house_info.comments.length >= 6) {
						return;
					}
					
					var has = false;
					for(var i = 0; i < this.house_info.comments.length; i++) {
						if(this.house_info.comments[i].type == type) {
							has = true;
							break;
						}
					}
					
					console.log(has);
					if(!has) {
						this.house_info.comments.push({
							type:type,
							info:''
						});
					}
				},
				saveComment:function() {
					if(this.house_info.comments.length < 3) {
						alert('最少填写3个纬度');
						return;
					}
					
					if(this.house_info.comment_title == '') {
						alert('请填写标题');
						return;
					}
					
					API.invokeModuleCall(g_host_url,'houseinfo','editHouseComment', this.house_info, function(json) {
						if(json.code == 0) {
							history.back();
						}
					});
				},
				if_sel:function(val) {
					for(var i = 0; i < this.house_info.comments.length; i++) {
						if(this.house_info.comments[i].type == val) {
							return true;
						}
					}
					return false;
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