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
	<link href="../../../static/css/base.css?v=2" rel="stylesheet">
	<link href="../../../static/css/city_page.css" rel="stylesheet">
	
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
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	<style>
		.form-control {
			display:inline;
			width:auto;
		}
		
		.floor .add-btn {
			display:none;
		}
		
		.floor:hover .add-btn {
			display:block;
		}
		
		.house-label .del-btn {
			position: absolute;
			right: -8px;
			top: -10px;
			width: 20px;
			height: 20px;
			line-height: 20px;
			text-align: center;
			border-radius: 10px;
			background: #3E3E3E;
			display:none;
		}
		
		.house-label:hover .del-btn {
			display:block;
		}
	</style>
</head>
<body>
<div id="content_warp">
	<div class="header">
		<div class="bar mg-c">
			<?php $menu='房源库管理';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li><a href="house/house_list_page">房源列表</a></li>
			<li class="active"><a href="javascript:">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-添加房源
			</li>
		</ul>
	</div>
	<!--<div class="mg-c" style="height:45px;line-height:45px;">
		<ul class="breadcrumb">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-添加房源
			</li>
		</ul>
	</div>-->
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">城市选择</p>
			</div>
			<div class="panel-body">
				<?php
					if($employee['type'] != ADMIN_TYPE_A) {
						if($employee['role'] == ROLE_IND_AGENT || $employee['type'] == ADMIN_TYPE_C) {
							$disabled_area_sel = 'disabled="disabled"';
						}
					}
				?>
				<div class="form-group fl-l">
					<label>片区选择：</label>
					<select v-model="curr_area_id" class="form-control" style="display:inline;width:auto" <?=$disabled_area_sel?>>
						<option v-for="area in areas" v-html="area.name" :value="area.area_id"></option>
					</select>
				</div>
				<div class="form-group fl-l" style="margin-left:20px">
					<label>商圈选择：</label>
						<select v-model="curr_ta_id" class="form-control"  style="display:inline;width:auto" <?=$disabled_area_sel?>>
							<option v-for="trade_area in trade_areas" v-html="trade_area.name" :value="trade_area.ta_id" v-if="trade_area.area_id==curr_area_id"></option>
						</select>
					</label>
				</div>
				<div style="clear:both"></div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">添加房源</p>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>小区：</label>
					<select v-model="curr_community_id" class="form-control" style="min-width:200px;margin-left:20px;">
						<option v-for="community in communities" v-if="community.ta_id == curr_ta_id" :value="community.community_id" v-html="community.name"></option>
					</select>
					<label style="margin-left:10px" v-show="is_locked"><i class="fa fa-lock" style="font-size:2rem;margin-top:5px;"></i></label>
				</div>
				<div class="form-group">
					<label>栋座：</label>
					<div class="btn-group" v-for="building_block in building_blocks" v-if="building_block.community_id == curr_community_id" style="margin-left:20px">
						<div :class="{btn:true,'btn-default':curr_bb_id!=building_block.bb_id,'btn-success':curr_bb_id==building_block.bb_id}"  :value="building_block.bb_id" v-html="building_block.name" @click="setCurrBB(building_block)"></div>
						<div class="btn btn-warning" v-if="curr_bb_id==building_block.bb_id&&building_block.locked==1" title="解锁栋座" @click="unlockBB(building_block)"><i class="fa fa-lock" aria-hidden="true"></i></div>
						<div class="btn btn-danger" v-if="curr_bb_id==building_block.bb_id&&!is_locked&&building_block.locked==0" title="删除栋座" @click="delBB(building_block)"><i class="fa fa-trash" aria-hidden="true"></i></div>
						<div class="btn btn-gray" v-if="curr_bb_id==building_block.bb_id&&!is_locked&&building_block.locked==0" title="锁定栋座" @click="lockBB(building_block)"><i class="fa fa-unlock" aria-hidden="true"></i></div>
						<div class="btn btn-info" v-if="curr_bb_id==building_block.bb_id&&!is_locked&&building_block.locked==0" title="复制栋座" @click="copyBB(building_block)"><i class="fa fa-files-o" aria-hidden="true"></i></div>
						<div class="btn btn-warning" v-if="curr_bb_id==building_block.bb_id&&!is_locked&&building_block.locked==0" @click="pasteBB(building_block)" title="粘贴栋座"><i class="fa fa-clipboard" aria-hidden="true"></i></div>
					</div>
					
					<div class="btn btn-primary pull-right" v-if="!is_locked" @click="showDlgCreateBB()" style="margin-left:40px;"><i class="icon icon-plus"></i>&nbsp;&nbsp;创建栋座</div>
				</div>

				<div class="form-group">
					<label>单元：</label>
					<div class="btn-group" style="margin-left:20px" v-for="building_unit in building_units" v-if="building_unit.bb_id == curr_bb_id" >
						<div :class="{btn:true,'btn-default':curr_bu_id!=building_unit.bu_id,'btn-success':curr_bu_id==building_unit.bu_id}":value="building_unit.bu_id" v-html="building_unit.name?building_unit.name:'0单元'" @click="setCurrBu(building_unit)"></div>
						<div class="btn btn-danger" v-if="curr_bu_id==building_unit.bu_id&&!is_locked&&!is_bb_locked" title="删除单元" @click="delBuildUnit(building_unit)"><i class="fa fa-trash" aria-hidden="true"></i></div>
						<div class="btn btn-info" v-if="curr_bu_id==building_unit.bu_id&&!is_locked&&!is_bb_locked" title="复制单元" @click="copyBuildUnit(building_unit)"><i class="fa fa-files-o" aria-hidden="true"></i></div>
						<div class="btn btn-warning" v-if="curr_bu_id==building_unit.bu_id&&!is_locked&&!is_bb_locked" @click="pasteBuildUnit(building_unit)" title="粘贴单元"><i class="fa fa-clipboard" aria-hidden="true"></i></div>
					</div>
					<div class="btn btn-primary pull-right" v-if="!is_locked" @click="showDlgCreateBU()" style="margin-left:40px"><i class="icon icon-plus"></i>&nbsp;&nbsp;创建单元</div>
				</div>
			</div>
		</div>
		<!--楼层信息-->
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">楼层信息</p>
				<div class="form-group btn-group pull-right">
					<div class="btn btn-info" @click="addUpFloor()" style="margin-top:-5px" v-show="!is_locked&&!is_bb_locked">往上加一层</div>
					<div class="btn btn-success" @click="addDownFloor()" style="margin-top:-5px" v-show="!is_locked&&!is_bb_locked">往下加一层</div>
					<div class="btn btn-primary" @click="addFloorToHouse()" style="margin-top:-5px" v-show="!is_locked&&!is_bb_locked">所有门牌添加楼层号</div>
				</div>
			</div>
			<div class="panel-body community">
				<table class="table table-hover">
					<tbody>
						<tr v-for="floor in floors" class="floor" style="position:relative">
							<td v-html="floor+'层'"></td>
							<td>
								<div style="width:100%;height:100%;margin:0px;position:relative;min-width:20px;">
									<div v-for="house in houses" v-if="house.floor==floor&&house.bu_id==curr_bu_id" class="house-label" style="position:relative">{{'房号：'+house.name}}<div class="del-btn" @click="delHouse(house)" v-show="!is_locked&&!is_bb_locked">x</div></div>
									<p style="clear:both;margin:0px;"></p>
									
									<div class="btn-group" style="position:absolute;right:0px;top:5px" v-show="!is_locked&&!is_bb_locked">
										<span class="btn btn-primary add-btn" @click="showDlgCreateHouse(floor)" title="添加"><i class="icon icon-plus" aria-hidden="true"></i></span>
										<span class="btn btn-info add-btn" title="复制" @click="copyHouses(houses,floor)"><i class="fa fa-files-o" aria-hidden="true"></i></span>
										<span class="btn btn-warning add-btn" @click="pasteHouses(floor)" title="粘贴"><i class="fa fa-clipboard" aria-hidden="true"></i></span>
										<span class="btn btn-danger add-btn" v-if="curr_building_block.max_floor==floor||curr_building_block.min_floor==floor" @click="delFloor(floor)" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></span>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!--创建栋座--->
	<div id="dlg_create_bb" :class="{hide:!show_dlg_create_bb}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">创建栋座</label>
			</div>
			<div class="" style="margin-top:10px">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3">栋座名称：</label>
						<div class="col-sm-8">
							<input type="text" v-model="building_block_add.name" class="form-control" placeholder="请输入一个栋座名称">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3">最低楼层：</label>
						<div class="col-sm-8">
							<input type="text" v-model="building_block_add.min_floor" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3">最高楼层：</label>
						<div class="col-sm-8">
							<input type="text" v-model="building_block_add.max_floor" class="form-control">
						</div>
					</div>
				</form>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="addBulidingBlock()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="hideDlgCreateBB()">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!--创建单元--->
	<div id="dlg_create_bu" :class="{hide:!show_dlg_create_bu}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">创建单元</label>
			</div>
			<div class="" style="margin-top:10px">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3">单元名称：</label>
						<div class="col-sm-8">
							<input type="text" v-model="building_unit_add.name" class="form-control" placeholder="请输入单元名称"></input>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3">是否有电梯：</label>
						<div class="col-sm-8">
							<input type="checkbox" v-model="building_unit_add.lift" class="form-control" style="width:15px;height:15px" placeholder="同时创建多个单元用|分割"></input>
						</div>
					</div>
				</form>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="addBulidingUnit()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="hideDlgCreateBU()">取消</div>
				</div>
			</div>
		</div>
	</div>
	<!--创建门牌--->
	<div id="dlg_create_house" :class="{hide:!show_dlg_create_house}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:30%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">创建门牌</label>
			</div>
			<div class="" style="margin-top:10px">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2">门牌：</label>
						<div class="col-sm-10">
							<input type="text" style="width:100%;display:block;" v-model="house_add.names" placeholder="请输入门牌，多个门牌用|分隔" class="form-control"></input>
						</div>
					</div>
				</form>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="addHouses()">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="hideDlgCreateHouse()">取消</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--删除确认--->
	<div id="dlg_confirm_del" :class="{hide:!show_dlg_confirm_del}" style="display:none">
		<div class="webbox-dlg-bg"></div>
		<div :class="{'webbox-dlg':true}" id="webbox-dlg-div" style="border-radius:0px !important;width:20%;left:50%;padding:20px;height:auto;position:fixed;">
			<div class="" style="height:auto;text-align:center;">
				<label style="font-size:2rem">温馨提示</label>
			</div>
			<div class="" style="margin-top:10px">
				<form class="form">
					<div class="form-group">
						<label>确认删除门牌吗？</label>
					</div>
					<div class="form-group">
						<label class="checkbox-inline">
							<input type="checkbox" v-model="del_house_no_confirm"></input>下次不再显示？
						</label>
					</div>
				</form>
			</div>
			<div style="margin-top:20px">
				<div style="display:flex">
					<div class="btn btn-info" style="flex:2" @click="realDelHouse(house_del)">确定</div>
					<div style="flex:1"></div>
					<div class="btn btn-success" style="flex:2" @click="hideDlgDelHouse()">取消</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mask hide-mask">
	<div></div>
</div>
</body>
<script type="text/javascript">
	function showMask() {
		$(".mask").show();
	}

	function hideMask() {
		$(".mask").hide();
	}

	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_area_id:<?php echo $employee['area_id']?>,//$.cookie("hd_curr_area_id"),
				curr_ta_id:<?php echo $employee['ta_id']?>,//$.cookie("hd_curr_ta_id"),
				curr_community_id:-1,
				curr_bb_id:-1,//$.cookie("curr_bb_id"),
				curr_bu_id:0,//$.cookie("curr_bu_id"),
				curr_floor:-10,//$.cookie("curr_floor"),
				curr_house_id:0,
				del_house_no_confirm:$.cookie("del_house_no_confirm"),
				curr_building_block:{
					bb_id:0,
					names:'',
					community_id:0,
					max_floor:0,
					min_floor:0,
				},
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				communities:[],
				building_blocks:[],
				building_units:[],
				houses:[],
				
				loaded_trade_areas:[],
				loaded_communities:[],
				loaded_build_blocks:[],
				loaded_build_units:[],
				
				show_panel:'none',
				show_dlg_create_bb:false,
				show_dlg_create_bu:false,
				show_dlg_create_house:false,
				show_dlg_confirm_del:false,
				
				community_add:{
					name:'',
					imgs:[],
					lng:0.0,
					lat:0.0,
					ta_id:0,
					retriving_info:''
				},
				
				building_block_add:{
					area_id:0,
					ta_id:0,
					community_id:0,
					min_floor:1,
					max_floor:1,
					locked:0,
					name:''
				},
				building_unit_add:{
					name:'',
					lift:0,
					area_id:0,
					ta_id:0,
					community_id:0,
					bb_id:0,
					
				},
				house_add:{
					names:'',
					floor:0,
					bu_id:0
				},
				copy_houses:[],
				copy_bu:{},
				copy_bb:{},
				house_del:{},
				max_floor:0,
				min_floor:0,
			},
			created:function() {
				var that = this;
				var val = this.curr_ta_id;
				if(!val) {
					return;
				}
				
				if($.inArray(val, this.loaded_trade_areas) < 0) {//不存在，则加载这个片区的小区及栋座信息
					API.invokeModuleCall(g_host_url,'house','queryTradeAreaCommunities', {ta_id:val}, function(json) {
						if(json.code == 0) {
							that.loaded_trade_areas.push(val);
							that.communities = that.communities.concat(json.communities);
						}
					});
				}
			},
			computed:{
				floors:function() {
					var f = [];
					for(var i = parseInt(this.curr_building_block.max_floor); i >= parseInt(this.curr_building_block.min_floor); i--) {
						if(i != 0) {
							f.push(i);
							
							if(i > this.max_floor||this.max_floor==0) {
								this.max_floor = i;
							}
							
							if(i < this.min_floor || this.min_floor==0) {
								this.min_floor = i;
							}
						}
					}
					return f;
				},
				is_locked:function() {
					var that = this;
					for(var i = 0; i < that.communities.length; i++) {
						if(that.communities[i].community_id == that.curr_community_id) {
							if(that.communities[i].locked == 0) {
								return false;
							} else {
								return true;
							}
						}
					}
				},
				is_bb_locked:function() {
					var that = this;
					for(var i = 0; i < that.building_blocks.length; i++) {
						if(that.building_blocks[i].bb_id == that.curr_bb_id) {
							if(that.building_blocks[i].locked == 0) {
								return false;
							} else {
								return true;
							}
						}
					}
				}
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_bb").css("display",'');
				$(this.$el).find("#dlg_create_bu").css("display",'');
				$(this.$el).find("#dlg_create_house").css("display",'');
				$(this.$el).find("#dlg_confirm_del").css("display",'');
			},
			watch:{
				del_house_no_confirm:function(val) {
					$.cookie('del_house_no_confirm',val,{expires: 10000});
				},
				curr_bb_id:function(val) {
					$.cookie("curr_bb_id", this.curr_bb_id, { expires: 7,path: '/'});
					this.curr_building_block.bb_id = 0;
					this.curr_building_block.name = '';
					this.curr_building_block.community_id = 0;
					this.curr_building_block.min_floor = 0;
					this.curr_building_block.max_floor = 0;
					for(var i = 0; i < this.building_blocks.length; i++) {
						if(this.building_blocks[i].bb_id == this.curr_bb_id) {
							this.curr_building_block.bb_id = this.building_blocks[i].bb_id;
							this.curr_building_block.name = this.building_blocks[i].name;
							this.curr_building_block.community_id = this.building_blocks[i].community_id;
							this.curr_building_block.min_floor = this.building_blocks[i].min_floor;
							this.curr_building_block.max_floor = this.building_blocks[i].max_floor;
							break;
						}
					}
					var that = this;
					
					that.curr_bu_id = -1;
					if($.inArray(parseInt(val), this.loaded_build_blocks) < 0) {//不存在，则加载这个片区的小区及栋座信息
						API.invokeModuleCall(g_host_url,'house','queryBuildingUnits', {bb_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_build_blocks.push(parseInt(val));
								that.building_units = that.building_units.concat(json.building_units);
								
								for(var i = 0; i < that.building_units.length; i++) {
									if(that.building_units[i].bb_id == val) {
										that.curr_bu_id = that.building_units[i].curr_bu_id;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < that.building_units.length; i++) {
							if(that.building_units[i].bb_id == val) {
								that.curr_bu_id = that.building_units[i].curr_bu_id;
							}
						}
					}
				},
				curr_bu_id:function(val) {
					var that = this;
					this.curr_floor = -10;
					API.invokeModuleCall(g_host_url,'house','queryHouses', {bu_id:val}, function(json) {
						if(json.code == 0) {
							that.houses = json.houses;
						}
					});
				},
				curr_area_id:function(val) {
					$.cookie("hd_curr_area_id", this.curr_area_id,{ expires: 7,path: '/'});
					this.curr_trade_area_id = 0;
					for(var i = 0; i < this.trade_areas.length; i++) {
						if(this.trade_areas[i].ta_id == this.curr_trade_area_id) {
							this.curr_trade_area_id = this.trade_areas[i].ta_id;
							break;
						}
					}
				},
				curr_ta_id:function(val) {
					var that = this;
					$.cookie("hd_curr_ta_id", this.curr_ta_id,{ expires: 7,path: '/'});
					that.curr_community_id = -1;
					if($.inArray(val, this.loaded_trade_areas) < 0) {//不存在，则加载这个片区的小区及栋座信息
						API.invokeModuleCall(g_host_url,'house','queryTradeAreaCommunities', {ta_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_trade_areas.push(val);
								that.communities = that.communities.concat(json.communities);
								
								for(var i = 0; i < that.communities.length; i++) {
									if(that.communities[i].ta_id == val) {
										that.curr_community_id = that.communities[i].community_id;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < this.communities.length; i++) {
							if(this.communities[i].ta_id == val) {
								this.curr_community_id = this.communities[i].community_id;
							}
						}
					}
				},
				curr_community_id:function(val) {
					this.copy_bb = {};
					var that = this;
					$.cookie("hd_curr_community_id", this.curr_community_id,{ expires: 7,path: '/'});
					that.curr_bb_id = -1;
					if($.inArray(val, this.loaded_communities) < 0) {
						API.invokeModuleCall(g_host_url,'house','queryBuildingBlocks', {community_id:val}, function(json) {
							if(json.code == 0) {
								that.loaded_communities.push(val);
								that.building_blocks = that.building_blocks.concat(json.building_blocks);
								console.log(val, that.building_blocks);
								for(var i = 0; i < that.building_blocks.length; i++) {
									if(that.building_blocks[i].community_id == val) {
										that.curr_bb_id = that.building_blocks[i].bb_id;
										break;
									}
								}
							}
						});
					} else {
						for(var i = 0; i < that.building_blocks.length; i++) {
							if(that.building_blocks[i].community_id == val) {
								that.curr_bb_id = that.building_blocks[i].bb_id;
								break;
							}
						}
					}
				},
				"community_add.name":function(val) {
					this.community_add.retriving_info = makePy(val);
				}
			},
			methods:{
				delFloor:function(floor) {
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house', 'delFloor', {floor:floor,bb_id:this.curr_bb_id}, function(json) {
						if(json.code == 0) {
							that.curr_building_block.max_floor = json.bb.max_floor;
							that.curr_building_block.min_floor = json.bb.min_floor;
						}
						hideMask();
					});
				},
				addUpFloor:function() {
					if(this.curr_bb_id  <= 0) {
						showMsg("请选择楼栋");
						return;
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url,'house','addUpFloor', this.curr_building_block, function(json) {
						if(json.code == 0) {
							that.curr_building_block.max_floor++;
							for(var i = 0; i < that.building_blocks.length; i++) {
								if(that.building_blocks[i].bb_id == that.curr_bb_id) {
									that.building_blocks[i].max_floor++;
									that.max_floor = that.building_blocks[i].max_floor;
									break;
								}
							}
						}
					});
				},
				addDownFloor:function() {
					if(this.curr_bb_id  <= 0) {
						showMsg("请选择楼栋");
						return;
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url,'house','addDownFloor', this.curr_building_block, function(json) {
						if(json.code == 0) {
							that.curr_building_block.min_floor--;
							for(var i = 0; i < that.building_blocks.length; i++) {
								if(that.building_blocks[i].bb_id == that.curr_bb_id) {
									that.building_blocks[i].max_floor--;
									that.min_floor = that.building_blocks[i].min_floor;
									break;
								}
							}
						}
					});
				},
				hideDlgDelHouse:function() {
					this.show_dlg_confirm_del = false;
				},
				addFloorToHouse:function() {
					if(this.curr_bu_id <= 0) {
						showMsg("请选择单元");
						return;
					}
					
					var that = this;
					API.invokeModuleCall(g_host_url,'house','addFloorToHouse',{bu_id:this.curr_bu_id},function(json) {
						if(json.code == 0) {
							for(var i = 0; i < json.houses.length; i++) {
								for(var j = 0;  j < that.houses.length; j++) {
									if(json.houses[i].house_id == that.houses[j].house_id) {
										that.houses[j].name = json.houses[i].name;
									}
								}
							}
							that.$forceUpdate();
						}
					});
				},
				copyHouses:function(houses,floor) {
					this.copy_houses = [];
					for(var i = 0; i < houses.length; i++){
						if(houses[i].floor == floor) {
							this.copy_houses.push(myDeepCopy(houses[i]));
						}
					}
					
					showMsg('已从'+floor+'楼拷贝'+this.copy_houses.length+'门牌');
				},
				copyBuildUnit:function(building_unit) {
					this.copy_bu = myDeepCopy(building_unit);
					showMsg('已拷贝单元');
				},
				copyBB:function(bb) {
					this.copy_bb = myDeepCopy(bb);
					showMsg('已拷贝栋座');
				},
				delBB:function(bb) {
					if(!confirm('确定删除？')) {
						return;
					}
					var that = this;
					API.invokeModuleCall(g_host_url, 'house','delBB',bb, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.building_blocks.length; i++) {
								if(that.building_blocks[i].bb_id == bb.bb_id) {
									that.building_blocks.splice(i,1);
									break;
								}
							}
							
							showMsg('删除成功');
						}
					});
				},
				delBuildUnit:function(build_unit) {
					if(!confirm('确定删除？')) {
						return;
					}
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house','delBuildUnit',build_unit, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.building_units.length; i++) {
								if(that.building_units[i].bu_id == build_unit.bu_id) {
									that.building_units.splice(i,1);
									break;
								}
							}
							
							for(var i = that.houses.length-1; i >= 0; i--) {
								if(that.houses[i].bu_id == build_unit.bu_id) {
									that.houses.splice(i,1);
								}
							}
							
							showMsg('删除成功');
						}
						hideMask();
					});
				},
				pasteBuildUnit:function(to_unit) {
					if(!this.copy_bu) {
						showMsg('无单元拷贝数据');
						return;
					}
					
					if(to_unit.bb_id != this.copy_bu.bb_id) {
						showMsg('单元拷贝需要在同一楼栋');
						return;
					}
					
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house','pasteBuildUnit', {src_bu:this.copy_bu,dst_bu:to_unit}, function(json) {
						if(json.code == 0) {
							for(var i = that.houses.length-1;i >= 0; i--) {
								if(that.houses[i].bu_id == to_unit.bu_id) {
									that.houses.splice(i,1);
								}
							}
							that.houses = that.houses.concat(json.houses);
							that.$forceUpdate();
						}
						hideMask();
					});
				},
				pasteBB:function(to_bb) {
					if(!this.copy_bb) {
						showMsg('无拷贝栋座数据');
						return;
					}
					
					if(to_bb.community_id != this.copy_bb.community_id) {
						showMsg('栋座需要在一个小区');
						return;
					}
					
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house', 'pasteBB', {src_bb:this.copy_bb,dst_bb:to_bb},function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.building_blocks.length; i++) {
								if(that.building_blocks[i].bb_id == json.building_block.bb_id) {
									that.$set(that.building_blocks, i, json.building_block);
									break;
								}
							}
							
							for(var i = that.building_units.length-1; i >= 0; i--) {
								if(parseInt(that.building_units[i].bb_id) == parseInt(to_bb.bb_id)) {
									that.building_units.splice(i,1);
								}
							}
							
							if($.inArray(parseInt(to_bb.bb_id), that.loaded_build_blocks) < 0) {
								that.loaded_build_blocks.push(parseInt(to_bb.bb_id));
							}
							
							that.building_units = that.building_units.concat(json.building_units);
							
							that.houses = that.houses.concat(json.houses);
							that.$forceUpdate();
						}
						hideMask();
					});
				},
				pasteHouses:function(floor) {
					this.curr_floor = floor;
					if(this.copy_houses.length <= 0) {
						showMsg('剪切板无数据');
						return;
					}
					
					var that = this;
					if(this.curr_bb_id <= 0) {
						showMsg('请选择栋座');
						return;
					}
					if(!this.curr_bu_id || this.curr_bu_id <= 0) {
						showMsg('请选择单元');
						return;
					}
					
					if(this.curr_floor <= -10) {
						showMsg('请输入楼层');
						return;
					}
					this.house_add.floor = this.curr_floor;
					this.house_add.bu_id = this.curr_bu_id;
					var names = [];
					for(var i = 0; i < this.copy_houses.length; i++) {
						names.push(this.copy_houses[i].name);
					}
					
					
					for(var i = 0; i < this.houses.length; i++) {
						if(this.houses[i].floor == floor) {
							showMsg('该层已经有门牌，请先删除再粘贴');
							return;
						}
					}
					showMask();
					this.house_add.names = names.join("|");
					API.invokeModuleCall(g_host_url, "house", "addHouses", {house_add:this.house_add,area_id:this.curr_area_id,ta_id:this.curr_ta_id,community_id:this.curr_community_id,bb_id:this.curr_bb_id,bu_id:this.curr_bu_id}, function(json) {
						if(json.code == 0) {
							that.houses = that.houses.concat(json.houses);
							that.show_dlg_create_house = false;
							showMsg("复制成功");
						}
						hideMask();
					});
				},
				lockBB:function(bb) {
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house', 'lockBB', bb, function(json) {
						if(json.code == 0) {
							bb.locked = 1;
						}
						hideMask();
					});
				},
				unlockBB:function(bb) {
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, 'house', 'unlockBB', bb, function(json) {
						if(json.code == 0) {
							bb.locked = 0;
						}
						hideMask();
					});
				},
				realDelHouse:function(house) {
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, "house", "delHouse", house, function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.houses.length; i++) {
								if(that.houses[i].house_id == house.house_id) {
									that.houses.splice(i,1);
									break;
								}
							}
						}
						hideMask();
						that.show_dlg_confirm_del = false;
					});
				},
				delHouse:function(house) {
					if(!this.del_house_no_confirm) {
						this.house_del = house;
						this.show_dlg_confirm_del = true;
						return;
					}
					this.realDelHouse(house);
				},
				showDlgCreateHouse:function(floor) {
					if(!this.curr_bu_id || this.curr_bu_id <= 0) {
						showMsg('请选择单元');
						return;
					}
					this.curr_floor = floor;
					this.show_dlg_create_house = true;
				},
				hideDlgCreateHouse:function() {
					this.show_dlg_create_house = false;
				},
				hideDlgCreateBB:function() {
					this.show_dlg_create_bb = false;
				},
				showDlgCreateBB:function() {
					if(this.is_locked) {
						showMsg('请先解锁小区');
						return;
					}
					if(this.curr_community_id == 0) {
						showMsg('请选择小区');
						return;
					}
					this.show_dlg_create_bb = true;
				},
				hideDlgCreateBU:function() {
					this.show_dlg_create_bu = false;
				},
				showDlgCreateBU:function() {
					if(this.is_locked) {
						showMsg('请先解锁小区');
						return;
					}
					if(this.curr_bb_id <= 0) {
						showMsg('请选择栋座');
						return;
					}
					this.show_dlg_create_bu = true;
				},
				setCurrBB:function(bb) {
					this.curr_bb_id = bb.bb_id;
				},
				setCurrBu:function(bu) {
					this.curr_bu_id = bu.bu_id;
				},
				resolvePos:function() {
					var that = this;
					this.myGeo.getPoint(this.community_add.name, function(point){
						console.log(point);
						if (point) {
							that.community_add.lng = point.lng;
							that.community_add.lat = point.lat;
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							alert("您选择地址没有解析到结果!");
						}
					}, "北京市");
				},
				showPanel:function(val) {
					if(val == "add_community") {
						if(!this.curr_ta_id || this.curr_ta_id == 0) {
							alert('请选择商圈');
							return;
						}
					} else if(val == 'add_building_block') {
						if(!this.curr_community_id || this.curr_community_id == 0) {
							alert('请选择小区');
							return;
						}
					}
					this.show_panel = val;
				},
				showCreateAreaDlg:function() {
					if(this.curr_city_id == 0) {
						alert('请选择城市');
						return;
					}
					this.show_create_area_dlg = true;
				},
				onClickCancel:function() {
					this.show_create_area_dlg = false;
				},
				delArea:function(area) {
					var that = this;
					showMask();
					API.invokeModuleCall(g_host_url, "cityinfo", "delArea", {area_id:area.area_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.areas.length; i++) {
								if(that.areas[i].area_id == area.area_id) {
									that.areas.splice(i,1);
								}
							}
							that.show_create_area_dlg = false;
						}
						hideMask();
					});
				},
				addBulidingBlock:function() {
					var that = this;
					if(!this.curr_community_id || this.curr_community_id == 0) {
						showMsg('请选择小区');
						return;
					}
					
					this.building_block_add.community_id = this.curr_community_id;
					this.building_block_add.area_id = this.curr_area_id;
					this.building_block_add.ta_id  = this.curr_ta_id;
					showMask();
					API.invokeModuleCall(g_host_url, "house", "addBuildingBlock", this.building_block_add, function(json) {
						if(json.code == 0) {
							that.building_blocks.push(json.building_block);
							that.show_panel = 'none';
							that.show_dlg_create_bb = false;
						}
						hideMask();
					});
				},
				addBulidingUnit:function() {
					var that = this;
					if(!this.curr_bb_id || this.curr_bb_id == 0) {
						showMsg('请选择栋座');
						return;
					}
					
					if(this.building_unit_add.name == '') {
						showMsg('请填写单元名称');
						return;
					}
					this.building_unit_add.area_id = this.curr_area_id;
					this.building_unit_add.ta_id = this.curr_ta_id;
					this.building_unit_add.community_id = this.curr_community_id;
					this.building_unit_add.bb_id = this.curr_bb_id;
					showMask();
					API.invokeModuleCall(g_host_url, "house", "addBuildingUnit", this.building_unit_add/*{area_id:this.curr_area_id,ta_id:this.curr_ta_id,community_id:this.curr_community_id, bb_id:this.curr_bb_id,bu:this.building_unit_add}*/, function(json) {
						if(json.code == 0) {
							that.building_units.push(json.building_unit);
							that.show_panel = 'none';
							that.show_dlg_create_bu = false;
							that.$forceUpdate();
						}
						hideMask();
					});
				},
				addHouses:function() {
					var that = this;
					if(this.curr_bb_id <= 0) {
						showMsg('请选择栋座');
						return;
					}
					if(!this.curr_bu_id || this.curr_bu_id <= 0) {
						showMsg('请选择单元');
						return;
					}
					
					if(this.curr_floor <= -10) {
						showMsg('请输入楼层');
						return;
					}
					this.house_add.floor = this.curr_floor;
					this.house_add.bu_id = this.curr_bu_id;
					showMask();
					API.invokeModuleCall(g_host_url, "house", "addHouses", {house_add:this.house_add,area_id:this.curr_area_id,ta_id:this.curr_ta_id,community_id:this.curr_community_id,bb_id:this.curr_bb_id,bu_id:this.curr_bu_id}, function(json) {
						if(json.code == 0) {
							that.houses = that.houses.concat(json.houses);
							that.show_panel = 'none';
							that.show_dlg_create_house = false;
						}
						hideMask();
					});
				},
				addCommunity:function() {
					var that = this;
					if(this.curr_ta_id == 0) {
						showMsg('请选择商圈');
						return;
					}
					
					this.community_add.ta_id = this.curr_ta_id;
					showMask();
					API.invokeModuleCall(g_host_url, "house", "addCommmunity", this.community_add, function(json) {
						if(json.code == 0) {
							that.communities.push(json.community);
							that.show_panel = 'none';
						}
						hideMask();
					});
				},
				onClickAdd:function() {
					
				}
			}
		})
	});
</script>
<script>
$(function(){
	$('.dropdown').click(function(){
		$(this).toggleClass('open');
	});
});
</script>
</html>