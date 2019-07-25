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
	<link href="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/css/availability.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=3"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
	<div class="breadcrumb-div mg-c xiu-div">
		<p class="xiu">修改日志</p>
	</div>	
	<div class="mg-c">
		<div class="form-group form-option form-option-x">
			<span style="padding-left:0px">筛选：</span>
			<span style="" class="active">不限</span>
			<span>角色变更</span>
			<span>信息变更</span>
		</div>
		<table class="xiu-table" border="1">
          	<tbody>
          		<tr>
	          		<th>业务名称</th>
	          		<th>字段名称</th>
	          		<th>修改前值</th>
	          		<th>修改后值</th>
	          		<th>操作人系统号</th>
	          		<th>操作人</th>
	          		<th>操作IP</th>
	          		<th>操作时间</th>
            	</tr>
                <tr>
                	<td rowspan="3">信息随证件更改</td>
                   	<td>建筑面积</td>
                   	<td>无</td>
                   	<td>95.6</td>
                   	<td rowspan="3">20124588</td>
                   	<td rowspan="3">李翔</td>
                   	<td rowspan="3"></td>
                   	<td rowspan="3">2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td>是否共有</td>
                   	<td>无</td>
                   	<td>否</td>
                </tr>
                <tr>
                	<td>套内面积</td>
                   	<td>-1.0</td>
                   	<td>84.32</td>
                </tr>
                <tr>
                	<td>修改价格</td>
                   	<td>价格</td>
                   	<td>650万元</td>
                   	<td>650万元</td>
                   	<td>20123333</td>
                   	<td>李翔</td>
                   	<td>10.66.43.73</td>
                   	<td>2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td rowspan="3">上传证件</td>
                   	<td>证件日期</td>
                   	<td>无</td>
                   	<td>2017-07-26</td>
                   	<td rowspan="3">20123333</td>
                   	<td rowspan="3">李翔</td>
                   	<td rowspan="3">10.66.43.73</td>
                   	<td rowspan="3">2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td>图片数量</td>
                   	<td>无</td>
                   	<td>1</td>
                </tr>
                <tr>
                	<td>证件类型</td>
                   	<td>无</td>
                   	<td>认证房源编号</td>
                </tr>
                <tr>
                	<td rowspan="4">商圈经理证件审核</td>
                   	<td>审批状态</td>
                   	<td>无</td>
                   	<td>通过</td>
                   	<td rowspan="4">20123333</td>
                   	<td rowspan="4">张春雷</td>
                   	<td rowspan="4"></td>
                   	<td rowspan="4">2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td>图片数量</td>
                   	<td>无</td>
                   	<td>1</td>
                </tr>
                <tr>
                	<td>证件日期</td>
                   	<td>无</td>
                   	<td>2017-07-26</td>
                </tr>
                <tr>
                	<td>证件类型</td>
                   	<td>无</td>
                   	<td>认证房源编号</td>
                </tr>
                <tr>
                	<td rowspan="12">修改房源维护信息</td>
                   	<td>看房时间</td>
                   	<td>无</td>
                   	<td>主卧卫生间改衣帽间，生活阳台改卫生间</td>
                   	<td rowspan="12">20123333</td>
                   	<td rowspan="12">李翔</td>
                   	<td rowspan="12">10.22.33.22</td>
                   	<td rowspan="12">2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td>看到时间</td>
                   	<td>无</td>
                   	<td>是</td>
                </tr>
                <tr>
                	<td>是否随时可签</td>
                   	<td>无</td>
                   	<td>是</td>
                </tr>
                <tr>
                	<td>是否限购</td>
                   	<td>无</td>
                   	<td>是</td>
                </tr>
                <tr>
                	<td>是否有抵押</td>
                   	<td>无</td>
                   	<td>无抵押</td>
                </tr>
                <tr>
                	<td>婚姻状况</td>
                   	<td>无</td>
                   	<td>已婚</td>
                </tr>
                <tr>
                	<td>是否共有产权</td>
                   	<td>无</td>
                   	<td>否</td>
                </tr>
                <tr>
                	<td>是否唯一</td>
                   	<td>无</td>
                   	<td>否</td>
                </tr>
                <tr>
                	<td>是否有学区名额</td>
                   	<td>无</td>
                   	<td>是</td>
                </tr>
                <tr>
                	<td>装修状况</td>
                   	<td>无</td>
                   	<td>精装</td>
                </tr>
                <tr>
                	<td>房屋状态</td>
                   	<td>无</td>
                   	<td>自住</td>
                </tr>
                <tr>
                	<td>婚姻状况描述</td>
                   	<td>无</td>
                   	<td>有小孩</td>
                </tr>
                <tr>
                	<td rowspan="13">录入房源委托</td>
                   	<td>交易权属</td>
                   	<td>无</td>
                   	<td>商品房</td>
                   	<td rowspan="13">20123333</td>
                   	<td rowspan="13">李翔</td>
                   	<td rowspan="13">10.22.33.22</td>
                   	<td rowspan="13">2017-07-26 16:22:11</td>
                </tr>
                <tr>
                	<td>朝向</td>
                   	<td>无</td>
                   	<td>东</td>
                </tr>
                <tr>
                	<td>厨房数</td>
                   	<td>无</td>
                   	<td>1</td>
                </tr>
                <tr>
                	<td>面积</td>
                   	<td>无</td>
                   	<td>95.6</td>
                </tr>
                <tr>
                	<td>室数</td>
                   	<td>无</td>
                   	<td>3</td>
                </tr>
                <tr>
                	<td>卫生间数</td>
                   	<td>无</td>
                   	<td>2</td>
                </tr>
                <tr>
                	<td>厅数</td>
                   	<td>无</td>
                   	<td>1</td>
                </tr>
                <tr>
                	<td>业主</td>
                   	<td>无</td>
                   	<td>严先生</td>
                </tr>
                <tr>
                	<td>价格</td>
                   	<td>无</td>
                   	<td>650万</td>
                </tr>
                <tr>
                	<td>手机</td>
                   	<td>无</td>
                   	<td>18578667541</td>
                </tr>
                <tr>
                	<td>房屋等级</td>
                   	<td>无</td>
                   	<td>B</td>
                </tr>
                <tr>
                	<td>房屋委托状态</td>
                   	<td>无</td>
                   	<td>有效</td>
                </tr>
	 		</tbody>
	 	</table>
	 	
	 	<nav aria-label="Page navigation">
			<ul class="pagination pagination-lg xiu-div-next">
			    <li class="disabled">
			      <a href="#" aria-label="Previous">
			        <span aria-hidden="true"><<</span>
			      </a>
			    </li>
			    <li class="active"><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li>
			      <a href="#" aria-label="Next">
			        <span aria-hidden="true">>></span>
			      </a>
			    </li>
			</ul>
		</nav>
	</div>	
			
</div>
</body>
</html>