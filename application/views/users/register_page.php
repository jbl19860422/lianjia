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
	<!--七牛云上传-->
	<script src="https://cdn.bootcss.com/plupload/3.1.2/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
</head>
<body>
	<div class="login">
		<h3>logo</h3>
		<form class="form-horizontal">
			<div class="row" id="row" v-show = "!information">
				<div class="title title-r">注册</div>
			  	<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">手机号</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入正确手机号" v-model = "user.mobile">
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">昵称</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入昵称" v-model = "user.nickname">
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">短信验证码</label>
				    <div class="col-sm-6 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入短信验证码" v-model="user.checkcode">
				    </div>
				    <div class="col-sm-4">
				    	<a class="btn btn-default" role="button" @click="sendRegisterCheckCode()">获取验证码</a>
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">密码：</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" class="form-control" placeholder="请输入密码" v-model = "user.password1">
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">确认密码：</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" class="form-control" placeholder="请确认密码" v-model = "user.password2">
				    </div>
				</div>
				<p class="col-sm-10 col-sm-offset-1">{{msg1}}</p>
				<div class="form-group">
				  	<div class="col-sm-10 col-sm-offset-1">
				  		<div class="next_step" @click = "next_step()">下一步</div>
				  	</div>
			  	</div>
			</div>
			
			<div class="row" id="row" v-show = "information">
				<div class="title title-r">填写信息</div>
				<div class="form-group">
					<label class="col-sm-5 col-sm-offset-1 login_label">头像</label>
				    <div class="col-sm-4 col-sm-offset-4">
				    	<img src="../../../static/img/fang1.png" class="submit-img" id="btn-change-img" :src="user.headimg"/>
				    </div>
				</div>
			  	<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">真实姓名</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入真实姓名" v-model = "user.name" >
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">工号</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入你的工号" v-model = "user.work_no">
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
					isMale:true,
					msg:'',/*提示信息*/
					msg1:'',
					user:{
						employee_id:0,
						mobile:'',
						work_no:'',
						name:'',
						nickname:'',
						sex:'',
						headimg:'',
						checkcode:'',
						password1:'',
						password2:'',
						sessionId:$.cookie('sessionId')
					},
					information: false,
					cell_phone:'',
					z_name:'' ,//姓名
					job_number:''   //工号
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
				next_step: function () {
					if(this.user.mobile == '') {
						this.msg1 = '请输入手机';
						return;
					}
					
					if(this.user.checkcode == '') {
						this.msg1 = '请输入验证码';
						return;
					}
					
					if(this.user.password1 != this.user.password2) {
						this.msg1 = '两次密码不一致';
						return;
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url, 'user', 'registerUser', this.user, function(json) {
						if(json.code == 0) {
							that.user.employee_id = json.employee.employee_id;
							location.href="/user/login_page";
							//that.information = !that.information;
						} else if(json.code == -1007) {
							that.msg1 = '用户已存在';
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
				},
				submit_t: function () {
					let re_name = /^\s*\S((.){0,14}\S)?\s*$/;  //1到16个字符
					let regEn = /[`~!@#$%^&*()_+<>?:"{},.\/;'[\]]/im,
						regCn = /[·！#￥（——）：；“”‘、，|《。》？、【】[\]]/im;//特殊字符
					let regn =  /^[0-9]+.?[0-9]*$/,
						regnb =	/(.+)?\d(.+)?/;//数字
					let con_number = this.user.work_no;
					if(!this.user.name){
						this.msg = "姓名不能为空";
						return;
					};
					if(!re_name.test(this.user.name)){
						this.msg = "姓名不能超过16个字符";
						return;
					};
					if(regEn.test(this.user.name) || regCn.test(this.user.name)){
						this.msg = "姓名不能含有特殊字符";
						return;
					};
					if(regn.test(this.user.name) || regnb.test(this.user.name)){
						this.msg = "姓名不能含有数字";
						return;
					};
					/*
					if(!con_number){
						this.msg = "工号不能为空";
						return;
					};
					*/
					API.invokeModuleCall(g_host_url,'user','updateUser',this.user, function(json) {
						if(json.code == 0) {
							location.href="/user/login_page";
						}
					});
				}
			   
			}
		})
	});
</script>
</html> 