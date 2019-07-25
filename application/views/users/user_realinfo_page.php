<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="renderer" content="webkit">
		<meta charset="UTF-8">
		<base href="<?=HOST_URL?>/"/>
		<title></title>
		<link href="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.css" rel="stylesheet">
		<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
		<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
		<link href="../../../static/css/base.css" rel="stylesheet">
		<link href="../../../static/css/city_page.css" rel="stylesheet">
		
		<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
		<script src="../../../static/js/iconfont.js" type="text/javascript"></script>
		<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
		<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
		<script src="static/js/common.js?v=2"></script>
		<script src="static/js/api.js?v=1"></script>

		<script src="https://cdn.bootcss.com/plupload/3.1.2/moxie.min.js"></script>
		<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
		<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>

		<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	</head>
	<body>
		<div class="header">
			<div class="bar mg-c">
				<?php include dirname(__file__)."/../inc/menu.php"?>
				<div class="user-info">
				</div>
			</div>
		</div>
		<div class="mg-c" id="content_warp">
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<p class="panel-p">实名信息</p>
				</div>
				<div class="panel-body">
					<div class="center" style="width:600px">
						<div class="center-top">
							<!--
							<div class="center-top-d">
								<div :class="{'center-num':true,'active-v':curr_step==1}" style="cursor:pointer" @click="curr_step=1">1</div>
								<h4 :class="{'active-h':curr_step==1}">基本信息</h4>
								<div class="center-line"></div>
							</div>
							-->
							<div class="center-top-d">
								<div :class="{'center-num':true,'active-v':curr_step==2}" style="cursor:pointer" @click="goStep(2)">1</div>
								<h4 :class="{'active-h':curr_step==2}">银行卡信息</h4>
								<div class="center-line"></div>
							</div>
							<div class="center-top-d">
								<div :class="{'center-num':true,'active-v':curr_step==3}" style="cursor:pointer" @click="goStep(3)">2</div>
								<h4 :class="{'active-h':curr_step==3}">身份证信息</h4>
							</div>
						</div>
						<div class="form-v">
							<!--
							<form class="form-horizontal" v-show="curr_step==1">
								<div class="form-group form-v-title">
									<svg class="icon" aria-hidden="true">
									  <use xlink:href="#icon-jibenxinxi"></use>
									</svg>
									<p class="form-v-p">基本信息</p>
								</div>
							  	<div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">用户名</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入您的用户名" class="form-control" v-model="vinfo.name">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">工 号</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入您的工号" class="form-control" v-model="vinfo.workno">
                                    </div>
                                </div>
								
                                <div class="form-group">
                                	<div class="col-sm-3 col-sm-offset-4">
                                		<a type="submit" class="btn btn-primary" @click="goStep(2)">下一步</a>
                                	</div>
                                </div>
                            </form>
							-->
                            <form class="form-horizontal"  v-show="curr_step==2">
								<div class="form-group form-v-title">
									<svg class="icon" aria-hidden="true">
									  <use xlink:href="#icon-dujiayuniconzhenggao-20"></use>
									</svg>
									<p class="form-v-p">银行卡信息</p>
								</div>
							  	<div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入您的真实姓名" class="form-control" v-model="vinfo.realname">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">银行卡号</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入您的卡号" class="form-control" v-model="vinfo.bank_cardno">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">开户银行</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入相应的银行" class="form-control" v-model="vinfo.bank_name">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input type="" name="name" placeholder="请输入开户所留手机号" class="form-control" v-model="vinfo.mobile">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                	<div class="col-sm-3 col-sm-offset-4">
                                		<a type="submit" class="btn btn-primary" @click="goStep(3)">下一步</a>
                                	</div>
                                </div>
                            </form>
                            
                            <form class="form-horizontal" v-show="curr_step==3">
								<div class="form-group form-v-title">
									<svg class="icon" aria-hidden="true">
									  <use xlink:href="#icon-credentials_icon"></use>
									</svg>
									<p class="form-v-p">身份证信息</p>
								</div>
							  	<div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">身份证号</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="请输入您的身份证号" class="form-control" v-model="vinfo.idcard">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                	<div class="col-sm-offset-4 col-sm-6">
                                		<label class="radio-inline">
										  <input type="radio" checked name="inlineRadioOptions" id="inlineRadio1" value="option1">
										  <p>二代身份证</p>
										  <img :src="vinfo.idcard_front==''?'../../../static/img/s1.jpg':vinfo.idcard_front" / class="s-img">
										  <img :src="vinfo.idcard_back==''?'../../../static/img/s2.gif':vinfo.idcard_back" / class="s-img">
										</label>
										<!--
										<label class="radio-inline">
										  <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
										  <p>临时身份证</p>
										  <img src="../../../static/img/l.jpg" / class="s-img">
										</label>
										-->
                                	</div>
                                    
                                </div>
                                
                                <div class="form-group">
                                	<label class="col-sm-4 text-right form-v-label">身份证正面上传</label>
                                    <div class="col-sm-6">
                                    	<div class="s-cimg" id="idcard_front">
                                    		<svg class="icon" aria-hidden="true" v-show="!vinfo.idcard_front">
											  <use xlink:href="#icon-tianjiajiahaowubiankuang-copy"></use>
											</svg>
											
											<img :src="vinfo.idcard_front" v-show="vinfo.idcard_front" style="height:148px">
											</img>
                                    	</div>
                                    	<p>证件必须是清晰彩色原件电子版。</p>
                                    </div>
                                </div>
								
								<div class="form-group">
                                	<label class="col-sm-4 text-right form-v-label">身份证反面上传</label>
                                    <div class="col-sm-6">
                                    	<div class="s-cimg" id="idcard_back">
                                    		<svg class="icon" aria-hidden="true" v-show="!vinfo.idcard_back">
											  <use xlink:href="#icon-tianjiajiahaowubiankuang-copy"></use>
											</svg>
											
											<img :src="vinfo.idcard_back" v-show="vinfo.idcard_back" style="height:148px">
											</img>
                                    	</div>
                                    	<p>证件必须是清晰彩色原件电子版。</p>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">身份证到期时间</label>
                                    <div class="col-sm-8">
                                    	<input type="text" autocomplete="off" name="name" class="form-control time-end" placeholder="身份证到期时间">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 text-right form-v-label">常用地址</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="" class="form-control" v-model="vinfo.address">
                                    </div>
                                </div>
                                <div class="form-group">
                                	<div class="col-sm-3 col-sm-offset-4">
                                		<a type="submit" class="btn btn-primary" @click="commit()">提交修改</a>
                                	</div>
                                </div>
                            </form>
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
				curr_step:2,
				vinfo:{
					name:'',
					workno:'',
					realname:'',
					bank_cardno:'',
					bank_name:'',
					mobile:'',
					idcard:'',
					idcard_front:'',
					idcard_back:'',
					card_time:'',
					address:''
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_admin").css("display","");
				$(this.$el).find(".time-end").val(this.vinfo.card_time);
				var that = this;
				var poster_uploader = new QiniuJsSDK();
				var poster_uploader_opt = {
					browse_button: 'idcard_front',
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
						   that.vinfo.idcard_front = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader.uploader(poster_uploader_opt);
				
				var poster_uploader_back = new QiniuJsSDK();
				var poster_uploader_opt_back = {
					browse_button: 'idcard_back',
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
						   that.vinfo.idcard_back = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader_back.uploader(poster_uploader_opt_back);
				
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
					format: "yyyy-mm-dd"
				}); 
			},
			created:function() {
			},
			methods:{
				commit:function() {
					this.vinfo.card_time = $(this.$el).find(".time-end").val();
					API.invokeModuleCall(g_host_url, 'user','applyModifyUserRealInfo', this.vinfo, function(json) {
						if(json.code == 0) {
							showMsg('提交成功');
							history.back();
						}
					});
				},
				goStep:function(s) {
					if(!this.verifyStep(s)) {
						return;
					}
					this.curr_step = s;
				},
				verifyStep:function(s) {
					if(s == 2) {
						if(this.vinfo.name == '' || this.vinfo.workno == '') {
							showMsg('请填写姓名和工号');
							return false;
						}
						return true;
					} else if(s == 3) {
						if(this.vinfo.realname == '' || this.vinfo.bank_cardno == '' || this.vinfo.bank_name == '' || this.vinfo.mobile == '') {
							showMsg('请详细填写银行卡信息');
							return false;
						}
						return true;
					}
				}
			}
		});
	});
</script>
</html>
