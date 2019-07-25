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
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/api.js?v=1"></script>
</head>
<body>
	<div id="content_warp">
		<div class="header">
			<div class="bar mg-c">
				<?php $menu='城市信息管理';?>
				<?php include dirname(__file__)."/../inc/menu.php"?>
				<div class="user-info">
				</div>
			</div>
		</div>
		<div class="submenu">
			<?php $city_menu = 'trade_area_page'?>
			<?php include dirname(__file__)."/city_menu.php"?>
		</div>
		<div class="breadcrumb-div mg-c">
			<ul class="breadcrumb-ul">
				<li>
					当前位置：
				</li>
				<li>
					城市信息管理-小区管理
				</li>
			</ul>
		</div>
	
		<div class="mg-c">
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<p class="panel-p">片区选择</p>
				</div>
				<div class="panel-body">				
					<div class="form-group">
						<label>片区选择：</label>
						<select class="form-control" style="display:inline;width:auto;" v-model="curr_area_id">
							<option v-for="area in areas" :area="area" v-html="area.name" :value="area.area_id"></option>
						</select>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading panel-title">
					<p class="panel-p">商圈列表</p>
					<div class="panel-r" @click="showCreateTradeAreaDlg()">
						<i class="fa fa-plus-square-o"></i>添加商圈
					</div>
				</div>
				<div class="panel-body">
					<ul class="area-list">
						<li class="btn fl-l btn-primary popup-btn" v-for="trade_area in trade_areas" v-if="trade_area.area_id==curr_area_id" data-container="body" data-toggle="popover" data-placement="top" :data-content="trade_area.remark">
							{{trade_area.name}}
							<div class="del-btn" @click="delTradeArea(trade_area)">x</div>
						</li>
					</ul>
				</div>
			</div>
			
			<div id="dlg_create_city" :class="{hide:!show_create_trade_area_dlg}">
				<div class="webbox-dlg-bg"></div>
				<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
					<div class="" style="height:auto;text-align:center;">
						<label style="font-size:2rem">添加商圈</label>
					</div>
					<div class="form-group" style="margin-top:10px;text-align:left;clear:both">
						<label class="col-sm-4">输入商圈名：</label>
						<input class="form-control col-sm-8" v-model="add_trade_area_name" style="width:auto;display:inline"></input>
					</div>
					<div style="clear:both;height:10px"></div>
					<div class="form-group" style="margin-top:10px;text-align:left;clear:both">
						<label class="col-sm-4">范围备注：</label>
						<textarea class="form-control col-sm-8" style="width:auto;display:inline" v-model="remark"></textarea>
					</div>
					<div style="clear:both;height:10px"></div>
					<div style="margin-top:20px;clear:both;">
						<div style="display:flex">
							<div class="btn btn-info" style="flex:2" @click="onClickAdd()">添加</div>
							<div style="flex:1"></div>
							<div class="btn btn-success" style="flex:2" @click="show_create_trade_area_dlg=false">取消</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_area_id:0,
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				show_create_trade_area_dlg:false,
				add_trade_area_name:"",
				remark:''
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_trade_area").css("display",'');
				console.log($(".popup-btn"));
				//$(this.$el).find('.popup-btn').popover({html: true, trigger: 'click'});
			},
			watch:{
				curr_area_id:function() {
					setTimeout(function() {
						$('.popup-btn').popover({html: true, trigger: 'click'});
					},10);
				}
			},
			methods:{
				showCreateTradeAreaDlg:function() {
					if(this.curr_area_id == 0) {
						alert('请选择片区');
						return;
					}
					this.show_create_trade_area_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_trade_area_dlg = false;
				},
				delTradeArea:function(area) {
					if(!confirm('请谨慎操作,确认删除?')) {
						return;
					}
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delTradeArea", area, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.trade_areas.length; i++) {
								if(that.trade_areas[i].ta_id == area.ta_id) {
									that.trade_areas.splice(i,1);
								}
							}
						}
					});
				},
				onClickAdd:function() {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "addTradeArea", {name:this.add_trade_area_name,area_id:this.curr_area_id,remark:this.remark}, function(json) {
						if(json.code == 0) {
							that.trade_areas = that.trade_areas.concat(json.trade_area);
							that.show_create_trade_area_dlg = false;
						} else {
							alert("添加失败");
						}
					});
				}
			}
		});
	});
</script>
</html>