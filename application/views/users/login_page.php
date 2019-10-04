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
		<h3>logo</h3>
		<form class="form-horizontal">
			<div class="row" id="row">
				<div class="title">用户登入<h5>还没有账号？<a href="user/register_page">马上注册</a></h5></div>
				<div class="form-group">
				    <label class="col-sm-3 col-sm-offset-1 login_label">账号</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" class="form-control" placeholder="请输入正确账号" v-model="user.mobile">
				    </div>
				</div>
			  	<div class="form-group">
				    <label class="col-sm-3 col-sm-offset-1 login_label">密码</label>
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" class="form-control" placeholder="请输入正确密码" v-model="user.password" @keyup.enter="login">
				    </div>
				</div>
				<p class="col-sm-10 col-sm-offset-1">{{msg}}</p>
				<div class="form-group">
				    <div class="col-sm-offset-1 col-sm-10">
				      <div class="login_btn" @click="login">登入</div>
				    </div>
			  	</div>
			  	<div class="col-sm-10 col-sm-offset-1">
			  		<a href="#" class="forget">忘记密码？</a>
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
					password:''
				}
	    	}
	  	},
		methods: {
		    login: function () {
		      	if(!this.user.mobile){
					this.msg = "手机号不能为空";
					return;
				};
				if(!this.user.password){
					this.msg = "密码不能为空";
					return;
				};
				
				var that = this;
				API.invokeModuleCall(g_host_url,'user','loginUser', this.user,function(json) {
					if(json.code == 0) {
						$.cookie('curr_province_id',json.province_id);
						$.cookie('curr_city_id',json.city_id);
						location.href = "<?=HOST_URL?>/houseinfo/house_info_list_page";
					} else if(json.code == -1009) {
						that.msg = '手机或密码不正确';
					} else if(json.code == -1012) {
						that.msg = '请等待审核通过';
					}
				});
		    }
		}
	})
</script>
</html> 