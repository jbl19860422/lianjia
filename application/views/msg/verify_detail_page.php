<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<base href="<?=HOST_URL?>/"/>
		<title></title>
		<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
		<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
		<link href="../../../static/css/base.css" rel="stylesheet">
		<link href="../../../static/css/city_page.css" rel="stylesheet">
		<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
		<script src="../../../static/js/iconfont.js" type="text/javascript"></script>
		<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
		<script src="static/js/common.js?v=2"></script>
		<script src="static/js/api.js?v=1"></script>
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
			<div class="mg-c" >
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
						<p class="panel-p">认证信息详情</p>
					</div>
					<div class="panel-body">
						<div class="detailsVfd">
							<div class="form-group">
								<div class="col-sm-2 details-title">
									<svg class="icon" aria-hidden="true">
									  <use xlink:href="#icon-xiangqing"></use>
									</svg>
									<p class="form-v-p">详情</p>
								</div>
								<div class="col-sm-8 details-center">
									<form class="form-horizontal">
										<div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">用户名:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.name"></div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">工 号:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.workno">07979337822</div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">真实姓名:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.realname">高志康</div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">银行卡号:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.bank_cardno"></div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">开户银行:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.bank_name">中国银行</div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">手机号:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.mobile">18579876589</div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">身份证号:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.idcard">360124198601028298</div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">身份证照:</label>
		                                    <div class="col-sm-6 details-center-div">
		                                    	<img :src="message.content.idcard_front" / class="s-img">
											  	<img :src="message.content.idcard_back" / class="s-img">
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">身份证到期时间:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.card_time"></div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-sm-5 text-right details-center-label">常用地址:</label>
		                                    <div class="col-sm-6 details-center-div" v-html="message.content.address"></div>
		                                </div>
		                                <div class="form-group">
		                                	<div class="col-sm-5"></div>
		                                	<div class="col-sm-7">
		                                   	 	<div class="btn btn-success" @click="verifyUserOk()">审核通过</div>
		                                    	<div class="btn btn-danger" style="margin-left:20px" @click="notVerify()">不通过审核</div>
		                                    </div>
		                                </div>
	                                </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</body>
	<script>
		var g_page;
		var g_host_url = "<?=HOST_URL?>";
		$(function() {
			g_page = new Vue({
				el:'#content_warp',
				data:{
					message:<?=json_encode($message)?>,
					agent_info:''
				},
				created:function() {
					this.message.content = JSON.parse(this.message.content);
				},
				mounted:function() {
					$(this.$el).find("#dlg_indenpdent_broker").css("display",'');
				},
				methods:{
					verifyUserOk:function(employee) {
						var that = this;
						API.invokeModuleCall(g_host_url,'user','verifyUserOk', {employee_id:this.message.from_employee_id,real_info:this.message.content, msg_id:this.message.msg_id}, function(json) {
							if(json.code == 0) {
								history.back(-1);
							}
						});
					}
				}
			})
		});
	</script>
</html>
