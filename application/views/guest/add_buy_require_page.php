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
	<link href="../../../static/css/city_page.css?v=1" rel="stylesheet">
	<link href="../../../static/public/font-awesome/css/font-awesome.css" rel="stylesheet"/>
	<link href="../../../static/css/base.css" rel="stylesheet">
	<link href="../../../static/css/guest.css" rel="stylesheet">
	<!--<link href="../../../static/css/availability.css" rel="stylesheet">-->
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
				客源-录入购房需求
			</li>
		</ul>
	</div>
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">购房需求(<?=$guest['name']?>)</p>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>购房目的：</label>
						<div class="col-sm-2">
							<select class="form-control" v-model="require_add.buy_intention">
								<option value="0">投资</option>
								<option value="1">改善</option>
								<option value="2">刚需</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>用&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;途：</label>
						<div class="col-sm-2">
							<select class="form-control" v-model="require_add.buy_usage">
								<option value="0">住宅</option>
								<option value="1">写字楼</option>
								<option value="2">商铺</option>
								<option value="3">商务公寓</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>心理价位：</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" class="form-control" v-model="require_add.buy_price_min"></input>
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control" v-model="require_add.buy_price_max"></input>
								<span class="input-group-addon">万元</span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付：</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" class="form-control" v-model="require_add.buy_firstpay_min"></input>
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control" v-model="require_add.buy_firstpay_max"></input>
								<span class="input-group-addon">万元</span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;供：</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" class="form-control" v-model="require_add.buy_monthpay_min"></input>
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control" v-model="require_add.buy_monthpay_max"></input>
								<span class="input-group-addon">元</span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积：</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" class="form-control" v-model="require_add.buy_area_min"></input>
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control" v-model="require_add.buy_area_max"></input>
								<span class="input-group-addon">㎡</span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：</label>
						<div class="col-sm-5">
							<div class="input-group">
								 <select class="form-control" v-model="require_add.buy_room_min">
									<option v-for="room in rooms" :value="room" v-html="room+'居'"></option>
								</select>
								<span class="input-group-addon">To</span>
								<select class="form-control" v-model="require_add.buy_room_max">
									<option v-for="room in rooms" :value="room" v-html="room+'居'"></option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>付款方式：</label>
						<div class="col-sm-2">
							<select class="form-control" v-model="require_add.buy_pay_method">
								<option value="0">不限</option>
								<option value="1">一次性付款</option>
								<option value="2">按揭</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>区&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;域：</label>
						<div class="col-sm-2">
							<select class="form-control" v-model="require_add.buy_area_id">
								<option value="0" style="display:none" checked>请选择</option>
								<option v-for="area in areas" :value="area.area_id" v-html="area.name"></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"><span>*</span>商&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;圈：</label>
						<div class="col-sm-4">
							<div class="col-sm-6" style="padding:0px">
								<select class="form-control" @input="selectTradeArea(0,$event)">
									<option value="0" style="display:none" checked>请选择</option>
									<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==require_add.buy_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>
								</select>
							</div>
							<div class="col-sm-6">
								<span class="btn btn-primary btn-rounded btn-small" @click="addTradeArea()">添加商圈</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require"></label>
						<div class="col-sm-4" v-for="(trade_area_id,index) in require_add.buy_trade_areas" v-if="index>=1">
							<div class="col-sm-6" style="padding:0px">
								<select class="form-control"  @input="selectTradeArea(index,$event)">
									<option value="0" style="display:none" checked>请选择</option>
									<option v-for="trade_area in trade_areas" v-if="trade_area.area_id==require_add.buy_area_id" :value="trade_area.ta_id" v-html="trade_area.name"></option>
								</select>
							</div>
							<div class="col-sm-6">
								<span class="btn btn-danger btn-rounded btn-small" @click="delTradeId(index)">删除</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">装&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;修：</label>
						<div class="col-sm-10">
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setDecoration($event,0)" checked></input>
							<label>不限</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setDecoration($event,1)"></input>
							<label>毛坯</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setDecoration($event,2)"></input>
							<label>简装</label>	
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setDecoration($event,3)"></input>
							<label>精装</label>	
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：</label>
						<div class="col-sm-10">
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,0)" checked></input>
							<label>不限</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,1)"></input>
							<label>东</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,2)"></input>
							<label>东南</label>	
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,3)"></input>
							<label>南</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,4)"></input>
							<label>西南</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,5)"></input>
							<label>西</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,6)"></input>
							<label>西北</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,7)"></input>
							<label>北</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setOrientation($event,8)"></input>
							<label>东北</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;层：</label>
						<div class="col-sm-10">
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setFloor($event,0)" checked></input>
							<label >不限</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setFloor($event,1)"></input>
							<label >低楼层</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setFloor($event,2)"></input>
							<label >中楼层</label>	
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setFloor($event,3)"></input>
							<label >高楼层</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setFloor($event,4)"></input>
							<label >不要一层</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setFloor($event,5)"></input>
							<label >不要顶层</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄：</label>
						<div class="col-sm-10">
							<input type="checkbox" class="checkbox-inline buy_require_checkbox" @click="setAge($event,0)" checked></input>
							<label >不限</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setAge($event,1)"></input>
							<label >5年内</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setAge($event,2)"></input>
							<label >5-10年</label>	
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setAge($event,3)"></input>
							<label >10-15年</label>
							<input type="checkbox" class="checkbox-inline buy_require_checkbox"  @click="setAge($event,4)"></input>
							<label >15-20年</label>
							<input type="checkbox" class="checkbox-inline"  @click="setAge($event,5)"></input>
							<label >20年以上</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 text-right buy_require">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
						<div class="col-sm-10">
							<textarea v-model="require_add.remark" class="form-control">
							</textarea>
						</div>
					</div>
					<div class="form-group" style="margin-top: 40px">
						<span class="btn btn-rounded btn-big col-sm-6 col-md-offset-3 btn-success" @click="addBuyRequire()">保存</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="dlg_add_label" :class="{hide:!show_add_label_dlg}">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true,'animate-show':show_add_label_dlg,'animate-hide':!show_add_label_dlg}" id="dlg_add_label_div">
			<div class="webbox-header">
				<div class="webbox-title">添加标签</div>
				<span @click="onClickCancel()">×</span>
			</div>
			<div class="webbox-body">
				<div class="webbox-body-div">
					<label class="col-sm-4">标签名:</label>
					 <div class="col-sm-7">
						<input type="text" class="form-control" v-model="add_label_name" placeholder=""></input>
					</div>
				</div>
			</div>
			<div class="webbox-btn">
				<button class="determine-btn" @click="onClickAddLabel()">确  定</button>
				<button class="cancel-btn" @click="onClickCancel()">取  消</button>
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
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
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
					buy_intention:0,
					buy_usage:0,
					buy_price_min:0,
					buy_price_max:0,
					buy_firstpay_min:0,
					buy_firstpay_max:0,
					buy_monthpay_min:0,
					buy_monthpay_max:0,
					buy_area_min:1,
					buy_area_max:1,
					buy_room_min:1,
					buy_room_max:1,
					buy_pay_method:0,
					buy_area_id:0,
					buy_trade_areas:[
						{
							ta_id:0,
							name:''
						}
					],
					buy_decoration:[//装修
						0,
					],
					buy_floor:[//楼层要求
						0,
					],
					buy_orientation:[
						'a'
					],
					buy_age:[//楼龄要求
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
				selectTradeArea:function(index,e) {
					console.log(e);
					var val = $(e.target).val();
					for(var i = 0; i < this.trade_areas.length; i++) {
						if(this.trade_areas[i].ta_id == val) {
							this.require_add.buy_trade_areas[index].ta_id = val;
							this.require_add.buy_trade_areas[index].name = this.trade_areas[i].name;
							break;
						}
					}
				},
				setDecoration:function(e,d) {
					if(d == 0) {
						if(this.require_add.buy_decoration.indexOf(d) < 0){
							this.require_add.buy_decoration = [0];
							$(e.target).prop("checked",true);
							$(e.target).siblings("input").prop('checked',false);
						} else {
							var pos = this.require_add.buy_decoration.indexOf(d);
							this.require_add.buy_decoration.splice(pos,1);
							$(e.target).attr("checked",false);
						}
						return;
					}
					
					if(this.require_add.buy_decoration.indexOf(d) < 0){
						this.require_add.buy_decoration.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_decoration.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_decoration.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_decoration.indexOf(d);
						this.require_add.buy_decoration.splice(pos,1);
					}
				},
				setAge:function(e,d) {
					if(d == 0) {
						if(this.require_add.buy_age.indexOf(d) < 0){
							this.require_add.buy_age = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_age.indexOf(d);
							this.require_add.buy_age.splice(pos,1);
							$(e.target).prop("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_age.indexOf(d) < 0){
						this.require_add.buy_age.push(d);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_age.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_age.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_age.indexOf(d);
						this.require_add.buy_age.splice(pos,1);
					}
				},
				setOrientation:function(e,o) {
					if(o == 'a') {
						if(this.require_add.buy_orientation.indexOf(o) < 0){
							this.require_add.buy_orientation = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_orientation.indexOf(o);
							this.require_add.buy_orientation.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_orientation.indexOf(o) < 0){
						this.require_add.buy_orientation.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_orientation.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_orientation.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_orientation.indexOf(o);
						this.require_add.buy_orientation.splice(pos,1);
					}
				},
				setFloor:function(e,o) {
					if(o == 0) {
						if(this.require_add.buy_floor.indexOf(o) < 0){
							this.require_add.buy_floor = [0];
							$(e.target).prop("checked",true).siblings("input").prop('checked',false);
							return;
						} else {
							var pos = this.require_add.buy_floor.indexOf(o);
							this.require_add.buy_floor.splice(pos,1);
							$(e.target).attr("checked",false);
							return;
						}
					}
					
					if(this.require_add.buy_floor.indexOf(o) < 0){
						this.require_add.buy_floor.push(o);
						$(e.target).attr("checked",true);
						$(e.target).siblings("input:eq(0)").prop("checked",false);
						var pos = this.require_add.buy_floor.indexOf(0);
						if(pos >= 0) {
							this.require_add.buy_floor.splice(pos,1);
						}
					} else {
						$(e.target).attr("checked",false);
						var pos = this.require_add.buy_floor.indexOf(o);
						this.require_add.buy_floor.splice(pos,1);
					}
				},
				addTradeArea:function() {
					if(this.require_add.buy_trade_areas.length <= 2) {
						this.require_add.buy_trade_areas.push({ta_id:0,name:''});
					}
				},
				delTradeId:function(ind) {
					this.require_add.buy_trade_areas.splice(ind,1);
				},
				addBuyRequire:function() {
					var that = this;
					for(var i = 0; i < this.require_add.buy_trade_areas.length; i++) {
						if(this.require_add.buy_trade_areas[i].ta_id == 0) {
							alert('请选择商圈');
							return;
						}
					}
					
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
					
					if(this.require_add.buy_area_id == 0) {
						alert('请选择区域');
						return;
					}
										
					var that = this;
					API.invokeModuleCall(g_host_url,'guest','addBuyRequire', this.require_add, function(json) {
						if(json.code == 0) {
							location.href = "guest/guest_detail_page?guest_id="+that.require_add.guest_id;
						}
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