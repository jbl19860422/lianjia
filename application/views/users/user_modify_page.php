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
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/css/login.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
</head>
<body>
	<div class="login">
		<h3>logo</h3>
		<form class="form-horizontal">
			<div class="row" id="row">
				<div class="title title-r">修改信息</div>
			  	<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">手机号</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入正确手机号" v-model = "user.mobile">
				    </div>
				</div>
				<div class="form-group" v-show="user.mobile!=user.mod_mobile">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">短信验证码</label>
				    <div class="col-sm-6 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入短信验证码" v-model="user.checkcode">
				    </div>
				    <div class="col-sm-4">
				    	<a class="btn btn-default" role="button" @click="sendRegisterCheckCode()">获取验证码</a>
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">昵称</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入昵称" v-model = "user.nickname">
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">性别</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<label class="radio-inline">
						  	<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="m" checked @click="setSex('m')"> 男
						</label>
						<label class="radio-inline">
						  	<input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="f" @click="setSex('f')"> 女
						</label>
				    </div>
				</div>
				<p class="col-sm-10 col-sm-offset-1">{{msg}}</p>
				<div class="form-group">
				  	<div class="col-sm-10 col-sm-offset-1">
				  		<div class="submit_t" @click = "submit_t()">提交</div>
				  	</div>
			  	</div>
			</div>
		</form>
	</div>
</body>
<script type="text/javascript">
	var g_host_url = "<?=HOST_URL?>";
	$(function() {
		var row = new Vue({
			el: '.login',
			data () {
				return {
					msg:'',/*提示信息*/
					user:{
						'mobile':"<?=$_SESSION['employee']['mobile']?>",
						'mod_mobile':"<?=$_SESSION['employee']['mobile']?>",
						'sex':"<?=$_SESSION['employee']['sex']?>",
						'nickname':"<?=$_SESSION['employee']['nickname']?>",
						'checkcode':''
					},
				}
			},
			mounted:function() {
				var that = this;
				var poster_uploader = new QiniuJsSDK();
				var poster_uploader_opt = {
					browse_button: 'btn-change-img',
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
						   that.user.headimg = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader.uploader(poster_uploader_opt);
			},
			methods: {
				setSex:function(s) {
					this.user.sex = s;
				},
				/*点击下一步填写信息*/
				submit_t: function () {
					if(this.user.mobile != this.user.mod_mobile) {
						if(this.user.checkcode == '') {
							this.msg = '请输入验证码';
							return;
						}
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url, 'user', 'modifyUser', this.user, function(json) {
						if(json.code == 0) {
							history.back();
							//that.information = !that.information;
						} else {
							this.msg = "服务器错误:"+json.code;
						}
					});
				},
				sendRegisterCheckCode:function() {
					var that = this;
					API.invokeModuleCall(g_host_url,'user','sendRegisterCheckCode',this.user, function(json) {
						if(json.code == 0) {
							that.user.sessionId = json.sessionId;
							$.cookie('sessionId',json.sessionId);
						}
					});
				}
			}
		})
	});
</script>
</html> 