<ul class="cityinfo-menus">
	<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_A || $_SESSION['employee']['type'] == ADMIN_TYPE_B) {?>
	<li class="<?php if($city_menu=='area_page') echo 'active';?>"><a href="cityinfo/area_page">片区</a></li>
	<?php } ?>
	<li class="<?php if($city_menu=='school_page') echo 'active';?>"><a href="cityinfo/school_page">学区</a></li>
	<li class="<?php if($city_menu=='subway_page') echo 'active';?>"><a href="cityinfo/subway_page">地铁线路</a></li>
	<li class="<?php if($city_menu=='trade_area_page') echo 'active';?>"><a href="cityinfo/trade_area_page">商圈</a></li>
	<li class="<?php if($city_menu=='community_page') echo 'active';?>"><a href="cityinfo/community_page">小区</a></li>
</ul>