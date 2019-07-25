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
			<?php $menu='房源库管理';?>
			<?php include dirname(__file__)."/../inc/menu.php"?>
			<div class="user-info">
			</div>
		</div>
	</div>
	<div class="submenu">
		<ul class="cityinfo-menus">
			<li class="active"><a href="house/house_list_page?pi=1&pc=12&area_id=0&clearcache=1">房源列表</a></li>
			<li><a href="house/house_add_page">添加房源</a></li>
			<!--<li><a href="cityinfo/school_page">待审核房源</a></li>-->
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-<?=$community['name']?>小区房源 
			</li>
		</ul>
	</div>
	<!--<div class="mg-c" style="height:45px;line-height:45px;">
		<ul class="breadcrumb">
			<li>
				当前位置：
			</li>
			<li>
				房源库管理-小区房源
			</li>
		</ul>
	</div>-->
	<div class="mg-c">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">维护人列表</p>
				<div class="panel-r" @click="addMaintainer()"><i class="fa fa-plus-square-o"></i>添加维护人
				</div>
			</div>
			<div class="panel-body">
				<ul class="area-list">
					<li class="btn btn-info fl-l" v-for="maintainer in maintainers">
					{{maintainer.maintainer_name}}
					<div class="del-btn" @click="delMaintainer(maintainer)">x</div>
					<li style="clear:both"></li>
				</ul>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">栋座-单元选择</p>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>栋座：</label>
					<div v-for="building_block in building_blocks" :class="{btn:true,'btn-default':curr_building_block.bb_id!=building_block.bb_id,'btn-success':curr_building_block.bb_id==building_block.bb_id}"  style="margin-right:10px" v-html="building_block.name" @click="selBuildingBlock(building_block);curr_bu_id=0;"></div>
				</div>

				<div class="form-group">
					<label>单元：</label>
					<div :class="{btn:true,'btn-default':curr_bu_id!=building_unit.bu_id,'btn-success':curr_bu_id==building_unit.bu_id}" v-html="building_unit.name" v-for="building_unit in building_units" style="margin-right:10px;" v-if="building_unit.bb_id==curr_building_block.bb_id" @click="curr_bu_id=building_unit.bu_id;"></div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p">楼层信息</p>
			</div>
			<div class="panel-body community">
				<table class="table table-hover">
					<tbody>
						<tr v-for="floor in floors" class="floor" style="position:relative">
							<td v-html="floor+'层'"></td>
							<td>
								<div style="width:100%;height:100%;margin:0px;position:relative;min-width:20px;">
									<div v-for="house in houses" v-if="house.floor==floor&&house.bu_id==curr_bu_id" class="house-label" style="position:relative">{{'房号：'+house.name}}</div>
									<p style="clear:both;margin:0px;"></p>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div id="dlg_add_maintainer" :class="{hide:!show_add_maintainer_dlg}">
			<div class="webbox-dlg-bg"></div>
			<div :class="{'webbox-dlg':true,'animate-show':show_add_maintainer_dlg,'animate-hide':!show_add_maintainer_dlg}" id="webbox-dlg-div">
				<div class="webbox-header">
					<div class="webbox-title">添加维护人</div>
					<span style="" @click="onClickCancel()">×</span>
				</div>
				<div class="webbox-body">
					<div class="webbox-body-div">
						<label class="col-sm-4">选择维护人:</label>
						 <div class="col-sm-7" style="position:relative">
							<select type="text" class="form-control" placeholder="" v-model="sel_employee_id">
								<option v-for="employee in employees" v-html="employee.name+'('+employee.work_no+')'" :value="employee.employee_id"></option>
							</select>
						</div>
						
					</div>
				</div>
				<div class="webbox-btn">
					<button class="determine-btn" @click="onClickAdd()">确  定</button>
					<button class="cancel-btn" @click="onClickCancel()">取  消</button>
				</div>
			</div>
		</div>
	</div>
	
	
	
</body>
<script type="text/javascript">
	var g_page;
	var g_host_url = "<?=HOST_URL?>";
	String.prototype.trim = function() {    
		return this.replace(/(^\s*)|(\s*$)/g,""); 
	};
	
	
	$(function() {
		g_page = new Vue({
			el:'#content_warp',
			data:{
				curr_area:<?=json_encode($area)?>,
				curr_bb_id:0,
				curr_bu_id:0,
				show_add_maintainer_dlg:false,
				sel_employee_id:0,
				community_id:<?=$community_id?>,
				areas:[],
				trade_areas:[],
				communities:[],
				employees:<?=json_encode($employees)?>,
				maintainers:<?=json_encode($maintainers)?>,
				building_blocks:<?=json_encode($building_blocks)?>,
				building_units:<?=json_encode($building_units)?>,
				houses:<?=json_encode($houses)?>,
				curr_building_block:{
					bb_id:0
				}
			},
			computed:{
				floors:function() {
					if(this.curr_building_block.bb_id == 0) {
						return [];
					}
					var f = [];
					for(var i = parseInt(this.curr_building_block.max_floor); i >= parseInt(this.curr_building_block.min_floor);i--) {
						f.push(i);
					}
					return f;
				}
			},
			created:function() {
				$.cookie("hl_community_id", this.community_id);
				for(var i = 0; i < this.houses.length; i++) {
					for(var j = 0; j < this.building_units.length; j++) {
						if(this.houses[i].bu_id == this.building_units[j].bu_id) {
							this.houses[i].bb_id = this.building_units[j].bb_id;
						}
					}
				}
			},
			mounted:function() {
				$(this.$el).find("dlg_add_maintainer").css("display",'');
			},
			watch:{
			},
			methods:{
				delMaintainer:function(maintain) {
					var that = this;
					API.invokeModuleCall(g_host_url,'house','delMaintainer',{id:maintain.id},function(json) {
						if(json.code == 0) {
							for(var i = 0; i < that.maintainers.length; i++) {
								if(that.maintainers[i].id == maintain.id) {
									that.maintainers.splice(i,1);
									break;
								}
							}
						}
					});
				},
				selBuildingBlock:function(building_block) {
					this.curr_building_block = building_block;
				},
				selArea:function(area_id) {
					this.curr_area_id = area_id;
				},
				addMaintainer:function() {
					this.show_add_maintainer_dlg = true;
				},
				onClickCancel:function() {
					this.show_add_maintainer_dlg = false;
				},
				onClickAdd:function() {
					var that = this;
					var name = '';
					for(var i = 0; i < this.employees.length; i++) {
						if(this.employees[i].employee_id == this.sel_employee_id) {
							name = this.employees[i].name+"("+this.employees[i].work_no+")";
						}
					}
					API.invokeModuleCall(g_host_url,'house','addMaintainer',{maintainer_name:name,community_id:this.community_id,employee_id:this.sel_employee_id},function(json) {
						if(json.code == 0) {
							that.maintainers.push(json.maintain);
							that.show_add_maintainer_dlg = false;
						}
					});
				}
			}
		})
	});
</script>
</html>