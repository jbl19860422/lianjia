<div class="company-info fl-l">
	<img src="../../../../static/img/logo.jpg"></img>
</div>
<ul class="menu">
	<?php 
		session_start();
		if(!isset($_SESSION['employee'])) {
			header("location: ".HOST_URL."/user/login_page");
		}
	?>
	<li <?php if($menu=='房源') echo 'class="active"';?>><a href="houseinfo/house_info_list_page">房源</a></li>
	<li <?php if($menu=='客源') echo 'class="active"';?>><a href="guest/guest_list_page">客源</a></li>
	<li <?php if($menu=='团队列表') echo 'class="active"';?>><a href="team/team_list_page">团队列表</a></li>
	<?php if($_SESSION['employee']['type'] != ADMIN_TYPE_NONE) {?>
	<li <?php if($menu=='城市信息管理') echo 'class="active"';?>><a href="cityinfo/area_page">城市信息管理</a></li>
	<?php } ?>
	<?php if($_SESSION['employee']['type'] != ADMIN_TYPE_NONE) {?>
	<li <?php if($menu=='房源库管理') echo 'class="active"';?>><a href="house/house_list_page?pi=1&pc=12&area_id=0">房源库管理</a></li>
	<?php } ?>
	<?php if($_SESSION['employee']['type'] != ADMIN_TYPE_NONE) {?>
	<li <?php if($menu=='团队管理') echo 'class="active"';?>><a href="team/team_manager_page">团队管理</a></li>
	<?php } ?>
	<li class="nav-right nav-right-login" style="float:right">
		<div class="dropdown" style="line-height:50px">
		  	<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    	<?=$_SESSION['employee']['nickname']?>-
		    	<?php 
					if($_SESSION['employee']['type'] == ADMIN_TYPE_NONE) {
						if($_SESSION['employee']['role'] == 0) {
							echo '游客';
						} else if($_SESSION['employee']['role'] == 1) {
							echo '独立经纪人';
						} else if($_SESSION['employee']['role'] == 2) {
							echo '职业经纪人';
						}
					} else if($_SESSION['employee']['type'] == ADMIN_TYPE_A){
						echo '超管';
					} else if($_SESSION['employee']['type'] == ADMIN_TYPE_B){
						echo '片区管理员';
					} else if($_SESSION['employee']['type'] == ADMIN_TYPE_C){
						echo '商圈管理员';
					} 
		    	?>
		    	<?php if($_SESSION['employee']['team_name']!='') echo '-'.$_SESSION['employee']['team_name']; else echo ''?>
		    	<span class="caret"></span>
		  	</a>
		  	<ul class="dropdown-menu" aria-labelledby="dLabel">
		  		<li><a href="user/user_center_page">个人中心</a></li>
				<li><a href="user/modify_password_page">修改密码</a></li>
		    	<li><a href="user/logout_page">退出</a></li>
		  	</ul>
		</div>
	</li>
	<li class="nav-right" style="float:right;padding:0px;"><a href="user/user_message_page">消息</a><span class="badge"><?=count($messages)?></span></li>
</ul>
