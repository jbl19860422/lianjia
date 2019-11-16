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
	<link href="../../../static/css/city_page.css?v=1" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	
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
		.label {
			padding-left:8px;padding-top:3px;padding-right:8px;padding-bottom:3px;border:1px solid #999;color:#d1d1d1;border-radius:4px;
		}
		
		
		.label .close-btn {
			position:absolute;right:-10px;top:-10px;border-radius:100%;background:red;width:20px;height:20px;line-height:20px;color:#fff;cursor:pointer;
			display:none;
		}
		
		.label:hover .close-btn {
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
			<li class="active"><a href="guest/buy_guest_add_page">买卖</a></li>
			<li><a href="javascript:">租赁</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				客源-录入客源
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">客户基本信息</p>
			</div>
			<div class="panel-body">
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：
					<input type="text" class="form-control" style="width:auto;display:inline;" v-model="guest_add.name"></input>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>客户性质：
					<input type="radio" class="checkbox-inline" name="type" @click="onSetType(1)" checked></input>
					<label style="font-size:1.2rem;color:#999">代理人</label>
					<input type="radio" class="checkbox-inline" name="type" style="margin-left:20px" @click="onSetType(2)"></input>
					<label style="font-size:1.2rem;color:#999">决策人</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：
					<input type="radio" class="checkbox-inline" name="sex" checked @click="changeSex('m')"></input>
					<label style="font-size:1.2rem;color:#999">男</label>
					<input type="radio" class="checkbox-inline" name="sex" style="margin-left:20px" @click="changeSex('f')"></input>
					<label style="font-size:1.2rem;color:#999">女</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>联系方式：
					<input type="text" class="form-control" style="width:auto;display:inline;" v-model="guest_add.mobiles[0]"></input>
					<span class="btn btn-primary btn-rounded btn-small" style="margin-left:20px" @click="addMobile()">添加其他电话</span>
					<span class="btn btn-primary btn-rounded btn-small" style="margin-left:20px" @click="addContacts()">添加联系人</span>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-for="(mobile,index) in guest_add.mobiles" v-if="index>=1">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>联系方式：
					<input type="text" class="form-control" style="width:auto;display:inline;" v-model="guest_add.mobiles[index]"></input>
					<span class="btn btn-danger btn-rounded btn-small" style="margin-left:20px" @click="removeMobile(index)">删除</span>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-for="(contact,index) in guest_add.contacts">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>联系人姓名：
					<input type="text" class="form-control" style="width:auto;display:inline;" v-model="contact.name"></input>
					
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>联系人电话：
					<input type="text" class="form-control" style="width:auto;display:inline;" v-model="contact.mobile"></input>
					<span class="btn btn-danger btn-rounded btn-small" style="margin-left:20px" @click="removeContact(index)">删除</span>
				</div>
				
				<div class="col-sm-12" style=";margin-top:10px;">
					<span style="color:#FFCAAC;margin-left:85px;">提示：第一个联系方式不可更改，且会做为考核真带看的重要依据，请认真填写</span>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>委托类型：
					<select class="form-control" style="width:auto;display:inline;" v-model="guest_add.entrust_type">
						<option value="1">求购</option>
						<option value="2">求租</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-if="guest_add.entrust_type==1">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>名下房产：
					<select class="form-control" style="width:auto;display:inline;" v-model="guest_add.has_house">
						<option value="0">无</option>
						<option value="1">一套</option>
						<option value="2">一套以上</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-if="guest_add.entrust_type==1">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>贷款记录：
					<select class="form-control" style="width:auto;display:inline;" v-model="guest_add.has_loan">
						<option value="0">无</option>
						<option value="1">一次</option>
						<option value="2">一次以上</option>
					</select>
					<select class="form-control" style="width:auto;display:inline;" v-if="guest_add.has_loan==1" v-model="guest_add.loan_type">
						<option value="0">已还清</option>
						<option value="1">未还清</option>
					</select>
					<select class="form-control" style="width:auto;display:inline;" v-if="guest_add.has_loan==2" v-model="guest_add.loan_type">
						<option value="2">全部结清</option>
						<option value="3">一次未结清</option>
						<option value="4">两次未结清</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;" v-if="guest_add.entrust_type==1">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>是否在链家或其他渠道有过待售房源：
					<input type="radio" class="checkbox-inline" name="has_sold" checked @click="setSold(0)"></input>
					<label style="font-size:1.2rem;color:#999">否</label>
					<input type="radio" class="checkbox-inline" name="has_sold" style="margin-left:20px" @click="setSold(1)"></input>
					<label style="font-size:1.2rem;color:#999">是</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-if="guest_add.entrust_type==1">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>购房意愿：
					<select class="form-control" style="width:auto;display:inline;" v-model="guest_add.buy_intention">
						<option value="2">弱</option>
						<option value="3">一般</option>
						<option value="4">强烈</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;" v-if="guest_add.entrust_type==2">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>租房意愿：
					<select class="form-control" style="width:auto;display:inline;" v-model="guest_add.intention">
						<option value="1">弱</option>
						<option value="2">一般</option>
						<option value="3">强烈</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>委托来源：
					<select v-model="guest_add.entrust_src1" class="form-control" style="width:auto;display:inline;">
						<option v-for="(entrust_src1,index) in entrust_srcs" v-html="entrust_src1.name" :value="index+1"></option>
					</select>
					-
					<select v-model="guest_add.entrust_src2" class="form-control" style="width:auto;display:inline;">
						<option v-for="(entrust_src2,index) in entrust_srcs[guest_add.entrust_src1-1].sub_srcs" v-html="entrust_src2" :value="index+1"></option>
					</select>
				</div>
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					&nbsp;&nbsp;标&nbsp;&nbsp;&nbsp;&nbsp;签：
					<div class="label" style="position:relative;margin-left:20px;cursor:pointer;" v-for="(lab,index) in guest_add.labels">{{lab}}<div class="close-btn" @click="onDelLab(index)">x</div></div>
					<span class="btn btn-primary btn-rounded btn-small" style="margin-left:20px" @click="onAddLab()">添加</span>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12" style="font-size:2.5rem;font-weight:bolder;text-align:center;">
			<span class="btn btn-success btn-rounded btn-big" style="width:50%;font-size:2rem;" @click="addGuest()">保存</span>
		</div>
	</div>
	<!--
	<div id="dlg_add_label" :class="{hide:!show_add_label_dlg}" style="display:none;z-index:100001;position:fixed;top:0px;bottom:0px;left:0px;right:0px;">
		<div class="webbox-dlg-bg" style="width:100%;height:100%;z-index:100001;background-color:rgba(0,0,0,0.5)"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_add_label_dlg,'animate-hide':!show_add_label_dlg}" style="position:fixed;z-index:999999 !important;width:500px;height:400px;border-radius:15px !important;border:1px solid #ddd;left:50%;top:50%;margin-left:-400px;margin-top:-300px;background:#fff;padding:0px;">
			<div class="webbox-header" style="height:45px;border-bottom:1px solid #ddd;padding-bottom:5px;">
				<div class="webbox-title" style="margin-left:auto;margin-right:auto;padding-top:15px;padding-bottom:10px;text-align:center;font-size:2rem;">添加标签</div>
				<span style="position:absolute;top:10px;right:20px;cursor:pointer;font-size:3rem;font-weight:bold;line-height:1;color:#000;text-shadow:0 1px #fff;opacity:2;display:block" @click="onClickCancel()">×</span>
			</div>
			<div class="webbox-body" style="text-align:center;height:200px;width:100%;padding:20px;overflow-y:auto;">
				<div style="text-align:left;font-size:2rem;margin-top:1rem;">
					<span >标签名</span><input v-model="add_label_name"></input>
				</div>
			</div>
			<div class="webbox-btn" style="margin-top:20px;text-align:center;height:50px;width:100%;">
				<span style="background-color:#03d8a2;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer;" @click="onClickAddLabel()">确  定</span>
				
				<span style="background-color:#ccc;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer" @click="onClickCancel()">取  消</span>
			</div>
		</div>
	</div>
	-->
	<!--添加标签--->
	<div id="dlg_add_label" :class="{hide:!show_add_label_dlg}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">添加标签</label>
			</div>
			<div class="" style="margin-top:10px;padding:10px;">
				<form class="form-horizontal">
					<div class="form-group">
						<label>标签名：</label>
						<input type="text" style="display:inline;width:auto;" v-model="add_label_name" placeholder="请输标签名" class="form-control"></input>
					</div>
					<div class="form-group">
						<div @click="directAddLabel(label)" class="btn btn-primary" style="margin-right:10px;margin-top:10px;" v-for="label in labels" v-html="label.name"></div>
					</div>
				</form>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="onClickAddLabel()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="onClickCancel()">取消</div>
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
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
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
				
				guest_add:{
					city_id:4,
					name:'',
					sex:'m',
					type:1,
					entrust_type:1,
					labels:[],
					mobiles:[
						''
					],
					contacts:[
					],
					entrust_src1:1,
					entrust_src2:1,
					has_house:0,
					has_loan:0,
					load_type:0,
					has_sold:0,
					buy_intention:0,
					intention:0
				},
				labels:<?=json_encode($labels)?>
			},
			computed:{
				isDecider:function() {
					return this.guest_add.type==2||this.guest_add.type==3;
				},
				isAgent:function() {
					return this.guest_add.type==1||this.guest_add.type==3;
				},
				userLabels:function() {
					return this.guest_add.labels.join("|");
				}
			},
			watch:{
				'guest_add.has_loan':function(val) {
					if(val == 1) {
						this.guest_add.loan_type = 0;
					} else if(val == 2) {
						this.guest_add.loan_type = 2;
					}
				}
			},
			created:function() {
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_label").css("display",'');
			},
			methods:{
				setSold:function(s) {
					this.guest_add.has_sold = s;
				},
				onAddLab:function() {
					this.show_add_label_dlg = true;
				},
				onClickCancel:function() {
					this.show_add_label_dlg = false;
				},
				addMobile:function() {
					if(this.guest_add.mobiles.length < 3) {
						this.guest_add.mobiles.push('');
					}
				},
				removeMobile:function(pos) {
					this.guest_add.mobiles.splice(pos,1);
				},
				removeContact:function(pos) {
					this.guest_add.contacts.splice(pos,1);
				},
				onDelLab:function(pos) {
					this.guest_add.labels.splice(pos,1);
				},
				onClickAddLabel:function() {
					this.guest_add.labels.push(this.add_label_name);
					this.show_add_label_dlg = false;
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','addLabel',{name:this.add_label_name},function(json) {
						if(json.code == 0) {
							that.labels.push(json.label);
						}
						that.add_label_name = '';
					});
				},
				directAddLabel:function(label) {
					this.guest_add.labels.push(label.name);
					this.show_add_label_dlg = false;
				},
				onSetType:function(v) {
					this.guest_add.type = v;
				},
				changeSex:function(s) {
					this.guest_add.sex = s;
				},
				addGuest:function() {
					var that = this;
					if(this.guest_add.name == '') {
						alert('请填写用户姓名');
						return;
					}
					
					if(this.guest_add.mobiles[0] == '') {
						alert('请填写联系电话');
						return;
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','addGuest', this.guest_add, function(json) {
						if(json.code == 0) {
							alert('添加成功！');
							if(that.guest_add.entrust_type == 1) {
								location.href="guest/add_buy_require_page?guest_id="+json.guest.guest_id;
							} else {
								location.href="guest/add_rent_require_page?guest_id="+json.guest.guest_id;
							}
						} else if(json.code == -10006) {
							alert('该客源已经添添加过');
							location.href = "guest/guest_detail_page?guest_id="+json.guest.guest_id;
						}
					});
				},
				addContacts:function() {
					if(this.guest_add.contacts.length >= 2) {
						return;
					}
					this.guest_add.contacts.push({
						name:'',
						mobile:'',
					});
				},
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