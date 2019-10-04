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
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/api.js?v=1"></script>
</head>
<body>
	<div class="login">
		<h3> </h3>
		<form class="form-horizontal">
			<div class="row" id="row">
				<div class="title">忘记密码</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">手机号</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入正确手机号" v-model = "user.mobile">
				    </div>
				</div>
				<div class="form-group">
				   	<label class="col-sm-5 col-sm-offset-1 login_label">短信验证码</label>
				    <div class="col-sm-6 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入短信验证码" v-model="user.checkcode">
				    </div>
				    <div class="col-sm-4">
				    	<a class="btn btn-default" role="button" @click="sendForgetPwdCheckCode()">获取验证码</a>
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-3 col-sm-offset-1 login_label">新密码</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" class="form-control" placeholder="请输入正确密码" v-model="user.password1">
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-3 col-sm-offset-1 login_label" style="width:auto">确认新密码</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" class="form-control" placeholder="请输入正确密码" v-model="user.password2">
				    </div>
				</div>
				<p class="col-sm-10 col-sm-offset-1">{{msg}}</p>
				<div class="form-group">
				    <div class="col-sm-offset-1 col-sm-10">
				      <div class="login_btn" @click="resetPassword()">确认修改</div>
				    </div>
			  	</div>
			</div>
		</form>
	</div>
</body>
<script type="text/javascript">
	var g_host_url = "<?=HOST_URL?>";
	var row = new Vue({
		el: '#row',
		data:function() {
	    	return {
	    		msg:'',/*提示信息*/
				user:{
					mobile:'',
					checkcode:'',
					password1:'',
					password2:'',
					sessionId:$.cookie('sessionId')
				}
	    	}
	  	},
		methods: {
			sendForgetPwdCheckCode:function() {
				var that = this;
				API.invokeModuleCall(g_host_url, 'user', 'sendForgetPwdCheckCode',this.user, function(json) {
					if(json.code == 0) {
						that.user.sessionId = json.sessionId;
						$.cookie('sessionId',json.sessionId);
					}
				});
			},
		    resetPassword: function () {
				if(!this.user.password1){
					this.msg = "密码不能为空";
					return;
				};
				
				if(this.user.password1 != this.user.password2) {
					this.msg = "两次密码不一致";
					return;
				}
				
				var that = this;
				API.invokeModuleCall(g_host_url,'user','resetPassword', this.user,function(json) {
					if(json.code == 0) {
						alert('修改成功');
						history.back(-1);
					} else if(json.code == -5003) {
						this.msg = "验证码错误";
					}
				});
		    }
		}
	})
</script>
</html> 