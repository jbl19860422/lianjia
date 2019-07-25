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
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	
	<link href="../../../static/css/availability.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/common.js?v=2"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="http://otf974inp.bkt.clouddn.com/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="https://cdn.bootcss.com/labjs/2.0.3/LAB.min.js"></script>
	<style>
		.label {
			padding-left:8px;padding-top:3px;padding-right:8px;padding-bottom:3px;border:1px solid #999;color:#d1d1d1;border-radius:4px;
		}
		
		
		.label .close-btn {
			position:absolute;right:-10px;top:-10px;border-radius:100%;background:red;width:20px;height:20px;line-height:20px;color:#fff;cursor:pointer;
			display:none;
		}
		
		.label:hover .close-btn {
			display:block;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='客源';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li class="active"><a href="guest/buy_guest_add_page">买卖</a></li>
			<li><a href="javascript:">租赁</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				客源-录入租房需求
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">租房需求(<?=$guest['name']?>)</p>
			</div>
			<div class="panel-body">
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					<div style="float:left;font-size: 1.5rem;font-weight: bolder;height:34px;line-height:34px;">
						<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>心理价位：
					</div>
					<div style="position:relative;float:left;">
						<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="require_add.rent_price_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">元/月</div></input>
					</div>
					<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>
					<div style="position:relative;float:left;">
						<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="require_add.rent_price_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">元/月</div></input>
					</div>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;;margin-top:20px;">
					<div style="float:left;font-size: 1.5rem;font-weight: bolder;height:34px;line-height:34px;">
						<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积：
					</div>
					<div style="position:relative;float:left;">
						<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="require_add.rent_area_min"><div style="position:absolute;right:10px;top:8px;color:#aaa">㎡</div></input>
					</div>
					<div style="float:left;font-size: 1.5rem;font-weight: bolder;margin-left:10px;margin-right:10px;">-</div>
					<div style="position:relative;float:left;">
						<input type="text" class="form-control" style="width:auto;display:inline;position:relative;" v-model="require_add.rent_area_max"><div style="position:absolute;right:10px;top:8px;color:#aaa">㎡</div></input>
					</div>
				</div>
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_room_count">
						<option v-for="room in rooms" :value="room" v-html="room+'室'"></option>
					</select>
					<span>-</span>
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_hall_count">
						<option v-for="hall in halls" :value="hall" v-html="hall+'厅'"></option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>付款方式：
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_pay_method">
						<option value="0">不限</option>
						<option value="1">月付</option>
						<option value="2">季付</option>
						<option value="3">年付</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>区&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;域：
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_area_id">
						<option v-for="area in areas" :value="area.area_id" v-html="area.name"></option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>商&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;圈：
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_trade_area_ids[0]">
						<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==require_add.rent_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>
					</select>
					<span class="btn btn-primary btn-rounded btn-small" style="margin-left:20px" @click="addTradeArea()">添加商圈</span>
					<div v-for="(trade_area_id,index) in require_add.rent_trade_area_ids" v-if="index>=1">
						<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select class="form-control" style="width:auto;display:inline;"  v-model="require_add.rent_trade_area_ids[index]" >
							<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==require_add.rent_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>
						</select>
						<span class="btn btn-danger btn-rounded btn-small" style="margin-left:20px" @click="delTradeId(index)">删除</span>
					</div>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">*</span>租&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期：
					<select class="form-control" style="width:auto;display:inline;" v-model="require_add.rent_duration">
						<option value="0">不限</option>
						<option value="1">1年</option>
						<option value="2">2~3年</option>
						<option value="3">3~5年</option>
						<option value="3">长期</option>
					</select>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>装&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;修：
					<input type="checkbox" class="checkbox-inline" @click="setDecoration($event,0)" checked></input>
					<label style="font-size:1.2rem;color:#999">不限</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,1)"></input>
					<label style="font-size:1.2rem;color:#999">毛坯</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,2)"></input>
					<label style="font-size:1.2rem;color:#999">简装</label>	
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setDecoration($event,3)"></input>
					<label style="font-size:1.2rem;color:#999">精装</label>	
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：
					<input type="checkbox" class="checkbox-inline" @click="setOrientation($event,'a')" checked></input>
					<label style="font-size:1.2rem;color:#999">不限</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'e')"></input>
					<label style="font-size:1.2rem;color:#999">东</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'es')"></input>
					<label style="font-size:1.2rem;color:#999">东南</label>	
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'s')"></input>
					<label style="font-size:1.2rem;color:#999">南</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'ws')"></input>
					<label style="font-size:1.2rem;color:#999">西南</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'w')"></input>
					<label style="font-size:1.2rem;color:#999">西</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'wn')"></input>
					<label style="font-size:1.2rem;color:#999">西北</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'n')"></input>
					<label style="font-size:1.2rem;color:#999">北</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setOrientation($event,'en')"></input>
					<label style="font-size:1.2rem;color:#999">东北</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;层：
					<input type="checkbox" class="checkbox-inline" @click="setFloor($event,0)" checked></input>
					<label style="font-size:1.2rem;color:#999">不限</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,1)"></input>
					<label style="font-size:1.2rem;color:#999">低楼层</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,2)"></input>
					<label style="font-size:1.2rem;color:#999">中楼层</label>	
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,3)"></input>
					<label style="font-size:1.2rem;color:#999">高楼层</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,4)"></input>
					<label style="font-size:1.2rem;color:#999">不要一层</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setFloor($event,5)"></input>
					<label style="font-size:1.2rem;color:#999">不要顶层</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄：
					<input type="checkbox" class="checkbox-inline" @click="setAge($event,0)" checked></input>
					<label style="font-size:1.2rem;color:#999">不限</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,1)"></input>
					<label style="font-size:1.2rem;color:#999">5年内</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,2)"></input>
					<label style="font-size:1.2rem;color:#999">5-10年</label>	
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,3)"></input>
					<label style="font-size:1.2rem;color:#999">10-15年</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,4)"></input>
					<label style="font-size:1.2rem;color:#999">15-20年</label>
					<input type="checkbox" class="checkbox-inline" style="margin-left:20px" @click="setAge($event,5)"></input>
					<label style="font-size:1.2rem;color:#999">20年以上</label>
				</div>
				
				<div class="col-sm-12" style="font-size:1.5rem;font-weight:bolder;margin-top:20px;">
					<span style="color:red;font-size:1.5rem;font-weight:bolder;">&nbsp;</span>备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：
					<textarea v-model="require_add.remark" class="form-control">
					</textarea>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12" style="font-size:2.5rem;font-weight:bolder;text-align:center;">
			<span class="btn btn-success btn-rounded btn-big" style="width:50%;font-size:2rem;" @click="addBuyRequire()">保存</span>
		</div>
	</div>
	
	<div id="dlg_add_label" :class="{hide:!show_add_label_dlg}" style="display:none;z-index:100001;position:fixed;top:0px;bottom:0px;left:0px;right:0px;">
		<div class="webbox-dlg-bg" style="width:100%;height:100%;z-index:100001;background-color:rgba(0,0,0,0.5)"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_add_label_dlg,'animate-hide':!show_add_label_dlg}" style="position:fixed;z-index:999999 !important;width:500px;height:400px;border-radius:15px !important;border:1px solid #ddd;left:50%;top:50%;margin-left:-400px;margin-top:-300px;background:#fff;padding:0px;">
			<div class="webbox-header" style="height:45px;border-bottom:1px solid #ddd;padding-bottom:5px;">
				<div class="webbox-title" style="margin-left:auto;margin-right:auto;padding-top:15px;padding-bottom:10px;text-align:center;font-size:2rem;">添加标签</div>
				<span style="position:absolute;top:10px;right:20px;cursor:pointer;font-size:3rem;font-weight:bold;line-height:1;color:#000;text-shadow:0 1px #fff;opacity:2;display:block" @click="onClickCancel()">×</span>
			</div>
			<div class="webbox-body" style="text-align:center;height:200px;width:100%;padding:20px;overflow-y:auto;">
				<div style="text-align:left;font-size:2rem;margin-top:1rem;">
					<span >标签名</span><input v-model="add_label_name"></input>
				</div>
			</div>
			<div class="webbox-btn" style="margin-top:20px;text-align:center;height:50px;width:100%;">
				<span style="background-color:#03d8a2;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer;" @click="onClickAddLabel()">确  定</span>
				
				<span style="background-color:#ccc;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;border-radius:5px;cursor:pointer" @click="onClickCancel()">取  消</span>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	var g_page;
	g_city_id = 4;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				areas:[],
				trade_areas:[],
				rooms:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
				halls:[0,1,2,3,4,5,6,7,8,9,10],
				show_add_label_dlg:false,
				add_label_name:'',
				entrust_srcs:[
					{
						name:'实体开发',
						sub_srcs:[
						]
					},
					{
						name:'人际开发',
						sub_srcs:[
						]
					},
					{
						name:'二次开发',
						sub_srcs:[
						]
					},
					{
						name:'其他网络',
						sub_srcs:[
						]
					}
				],
				
				require_add:{
					guest_id:<?=$guest['guest_id']?>,
					rent_area_min:0,
					rent_area_max:0,
					rent_room_count:1,
					rent_hall_count:0,
					rent_pay_method:0,
					rent_area_id:0,
					rent_time:0,
					rent_duration:0,
					rent_trade_area_ids:[
						0
					],
					rent_decoration:[//装修
						0,
					],
					rent_floor:[//楼层要求
						0,
					],
					rent_orientation:[
						'a'
					],
					rent_age:[//楼龄要求
						0
					],
					remark:''
				}
			},
			computed:{
			},
			created:function() {
				var that = this;
				API.invokeModuleCall(g_host_url,'cityinfo','queryCityAreaAndTradeArea', {city_id:g_city_id},function(json) {
					that.areas = json.areas;
					that.trade_areas = json.trade_areas;
				});
			},
			mounted:function() {
				$(this.$el).find("#dlg_add_label").css("display",'');
			},
			methods:{
				setDecoration:function(e,d) {
					if(d == 0) {
						if(this.require_add.rent_decoration.indexOf(d) < 0){
							this.require_add.rent_decoration = [0];
							$(e.target).prop("checked",true);
							$(e.target).siblings("input").prop('checked',false);
						} else {
							var pos = this.require_add.rent_decoration.indexOf(d);
							this.require_add.rent_decoration.splice(pos,1);
							$(e.target).attr("checked",false);
						}
						return;
					}
					
					if(this.require_add.rent_decoration.indexOf(d) < 0){
						this.require_add.rent_decoration.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.rent_decoration.indexOf(0);
						if(pos >= 0) {
							this.require_add.rent_decoration.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.rent_decoration.indexOf(d);
						this.require_add.rent_decoration.splice(pos,1);
					}
				},
				setAge:function(e,d) {
					if(d == 0) {
						if(this.require_add.rent_age.indexOf(d) < 0){
							this.require_add.rent_age = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.rent_age.indexOf(d);
							this.require_add.rent_age.splice(pos,1);
							$(e.target).prop("checked",false);
							return;
						}
					}
					
					if(this.require_add.rent_age.indexOf(d) < 0){
						this.require_add.rent_age.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.rent_age.indexOf(0);
						if(pos >= 0) {
							this.require_add.rent_age.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.rent_age.indexOf(d);
						this.require_add.rent_age.splice(pos,1);
					}
				},
				setOrientation:function(e,o) {
					if(o == 'a') {
						if(this.require_add.rent_orientation.indexOf(o) < 0){
							this.require_add.rent_orientation = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.rent_orientation.indexOf(o);
							this.require_add.rent_orientation.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.rent_orientation.indexOf(o) < 0){
						this.require_add.rent_orientation.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.rent_orientation.indexOf('a');
						if(pos >= 0) {
							this.require_add.rent_orientation.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.rent_orientation.indexOf(o);
						this.require_add.rent_orientation.splice(pos,1);
					}
				},
				setFloor:function(e,o) {
					if(o == 0) {
						if(this.require_add.rent_floor.indexOf(o) < 0){
							this.require_add.rent_floor = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.rent_floor.indexOf(o);
							this.require_add.rent_floor.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.rent_floor.indexOf(o) < 0){
						this.require_add.rent_floor.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.rent_floor.indexOf(0);
						if(pos >= 0) {
							this.require_add.rent_floor.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.rent_floor.indexOf(o);
						this.require_add.rent_floor.splice(pos,1);
					}
				},
				addTradeArea:function() {
					if(this.require_add.rent_trade_area_ids.length <= 2) {
						this.require_add.rent_trade_area_ids.push(0);
					}
				},
				delTradeId:function(ind) {
					this.require_add.rent_trade_area_ids.splice(ind,1);
				},
				addBuyRequire:function() {
					var that = this;
					if(parseInt(this.require_add.buy_price_min) == 0) {
						alert('最低心理价位不能为0');
						return;
					}
					
					if(parseInt(this.require_add.buy_price_max) == 0) {
						alert('最高心理价位不能为0');
						return;
					}
					
					if(parseInt(this.require_add.buy_firstpay_min) == 0) {
						alert('最低首付不能为0');
						return;
					}
					
					if(parseInt(this.require_add.buy_firstpay_max) == 0) {
						alert('最高首付不能为0');
						return;
					}
					
					if(parseInt(this.require_add.buy_area_min) == 0) {
						alert('最低面积不能为0');
						return;
					}
					
					if(parseInt(this.require_add.buy_area_max) == 0) {
						alert('最高面积不能为0');
						return;
					}
					
					if(this.require_add.rent_area_id == 0) {
						alert('请选择区域');
						return;
					}
										
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','addRentRequire', this.require_add, function(json) {
					});
				}
			}
		})
	});
</script>
<script>
	$(function(){
		$('.availability-span-t').popover({html: true, trigger: 'hover'});
		$('.availability-span-d').popover({html: true, trigger: 'hover'});
	})
	
</script>
</html>