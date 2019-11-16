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
	
	
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
	<script src="static/js/api.js?v=1"></script>
	<script src="http://api.map.baidu.com/api?v=2.0&ak=zjc67Z4sk9azp0cEBBTGBSknA1x7OPyR" type="text/javascript"></script>
	<script src="//cdn.bootcss.com/plupload/2.3.1/moxie.min.js"></script>
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
	<script src="static/js/common.js?v=2"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	<script src="https://cdn.bootcss.com/zui/1.7.0/lib/datetimepicker/datetimepicker.js"></script>
	<style>
		.school-d {
			margin-top:50px;
		}
	</style>
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
		<?php $city_menu = 'school_page'?>
		<?php include dirname(__file__)."/city_menu.php"?>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				城市信息管理-学区管理
			</li>
		</ul>
	</div>
	<div class="mg-c">
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<p class="panel-p" v-html="show_add_school?'添加学区':'学区列表'"></p>
				<div class="panel-r" @click="showCreateAreaDlg()">
					<i class="fa fa-plus-square-o"></i>添加学区
				</div>
			</div>
			<div class="panel-body" v-show="!show_add_school">
				<ul class="school-list">
					<school-item v-for="school in schools" :school="school" @del_school="delSchool"></school-item>
					<div style="clear:both"></div>
				</ul>
			</div>
			<div class="panel-body" v-show="show_add_school">
				<div class="school-img col-sm-5">
					<img :src="school_add.img?school_add.img:'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3568368610,1126867669&fm=27&gp=0.jpg'" style="width:100%"></img>
					<div class="btn-area">
						<div id="btn-change-img">修改图片</div>
					</div>
				</div>
				<div class="school-w col-sm-6">
					<form class="form-horizontal">
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">学校名称：</label>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" v-model="school_add.name">
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">办学性质：</label>
						    <div class="col-sm-6">
						    	<select class="form-control" v-model="school_add.nature">
									<option value="1">公立</option>
									<option value="2">私立</option>
									<option value="3">国际</option>
								</select>
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">学校类别：</label>
						    <div class="col-sm-6">
						    	<select class="form-control" v-model="school_add.type">
									<option value="0">小学</option>
									<option value="1">中学</option>
								</select>
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">名额限制：</label>
						    <div class="col-sm-6">
						    	<select class="form-control" v-model="school_add.num_limit">
									<option value="1">三年一名额</option>
									<option value="2">二年一名额</option>
									<option value="3">九年一名额</option>
									<option value="4">十二年一名额</option>
									<option value="5">五年一名额</option>
									<option value="6">六年一名额</option>
									<option value="7">无限制</option>
								</select>
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">升学方式：</label>
						    <div class="col-sm-6">
						    	<select class="form-control" v-model="school_add.upgrade_method">
									<option value="1">特长生</option>
									<option value="2">推优</option>
									<option value="3">九年一贯制</option>
									<option value="4">对口直升</option>
									<option value="5">子弟学校</option>
									<option value="6">自主招生</option>
									<option value="7">大学区</option>
									<option value="8">十二年一贯</option>
								</select>
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">所属片区：</label>
						    <div class="col-sm-6">
						    	<select class="form-control" v-model="school_add.area_id" <?php if($_SESSION['employee']['type'] == ADMIN_TYPE_C) echo 'disabled="disabled"'?>>
									<option v-for="area in areas" v-html="area.name" :value="area.area_id"></option>
								</select>
						    </div>
						</div>
						
						<div class="form-group">
						    <label class="col-sm-4 text-right school-label">地理位置：</label>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" v-model="school_add.position">
						    </div>
						    <div class="col-sm-2">
						    	<div class="btn btn-success" @click="resolvePos()"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;定位</div>
						    </div>
						</div>
					</form>
				</div>
				<div id="map-schoolpos" class="col-sm-11 school-d" ></div>
				
				<div style="clear:both"></div>
				<div class="school-btn">
					<span @click="onClickAdd()">确认添加</span>
					<span @click="onClickCancel()">取消</span>
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
		
		var schoolCom = Vue.component('school-item', {
			props:['school'],
			template:
			'<li>'+
				'<dl>'+
					'<dt>'+
						'<img :src="school.img"></img>'+
					'</dt>'+
					'<dd>'+
						'<h2 v-html="school.name"></h2>'+
						'<h3 v-html="school.position"></h3>'+
						'<p><span v-html="nature_str"></span>/<span v-html="num_limit_str"></span>/<span v-html="upgrade_method_str"></span></p>'+
					'</dd>'+
					'<div class="btn-area">'+
						'<div class="btn-area-s" style="width:50%" @click="onDel()">删&nbsp;&nbsp;除</div>'+
						'<div class="btn-area-s" style="width:50%;margin-left:50%;background:#36a765" @click="editSchool(school)">编&nbsp;&nbsp;辑</div>'+
					'</div>'+
				'</dl>'+
			'</li>',
			computed:{
				nature_str:function(){
					if(this.school.nature <= 0) {
						return '';
					}
					var natures = ['公立','私立','国际'];
					return natures[this.school.nature-1];
				},
				num_limit_str:function() {
					if(this.school.num_limit <= 0) {
						return '';
					}
					var num_limits = ['三年一名额','二年一名额','九年一名额','十二年一名额','五年一名额','六年一名额','无限制'];
					return num_limits[this.school.num_limit-1];
				},
				upgrade_method_str:function() {
					if(this.upgrade_method <= 0) {
						return '';
					}
					
					var upgrade_methods = ['特长生','推优','九年一贯制','对口直升','子弟学校','自主招生','大学区','十二年一贯'];
					return upgrade_methods[this.school.upgrade_method-1];
				}
			},
			methods:{
				onDel:function() {
					this.$emit('del_school', this.school);
				},
				editSchool:function(s) {
					location.href = "cityinfo/edit_school_page?sc_id="+s.sc_id;
				}
			}
		});     
		
		g_page = new Vue({
			el:'#content_warp',
			data:{
				show_add_school:false,
				school_add:{
					name:'',
					nature:0,
					type:0,
					img:'',
					num_limit:0,
					upgrade_method:0,
					area_id:<?php if($_SESSION['employee']['type'] == ADMIN_TYPE_C) echo $_SESSION['employee']['area_id']; else echo 0?>,
					lat:0.0,
					lng:0.0,
					position:''
				},
				areas:<?=json_encode($areas)?>,
				schools:<?=json_encode($schools)?>,
				add_area_names:"",
			},
			created:function() {
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
				
				var that = this;
				this.map = new BMap.Map("map-schoolpos");  
				this.map.centerAndZoom('深圳市',15); 
				this.map.enableScrollWheelZoom(true);
				this.map.disable3DBuilding();
				// 创建地址解析器实例
				this.myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				this.myGeo.getPoint(this.school_add.position, function(point){
					if (point) {
						that.map.centerAndZoom(point, 18);
						that.map.addOverlay(new BMap.Marker(point));
					}else{
						alert("您选择地址没有解析到结果!");
					}
				}, "深圳市");
				
				var that = this;
				var poster_uploader = new QiniuJsSDK();
				var poster_uploader_opt = {
					browse_button: 'btn-change-img',
					uptoken_url:g_host_url+"/common/get_qiniu_upload_token",
					auto_start: true,
					domain: '<?=QINIU_DOMAIN?>',
					unique_names: true,
					max_file_size:'4mb',
					init: {
						'BeforeUpload': function (up, file) {
						},
						'FileUploaded': function (up, file, info) {
						   var domain = up.getOption('domain');
						   var res = JSON.parse(info);
						   var sourceLink = domain + res.key; //获取上传成功后的文件的Url
						   that.school_add.img = sourceLink;
						},
						'Error': function(up, err, errTip) {
						}
					}
				};
				poster_uploader.uploader(poster_uploader_opt);
			},
			methods:{
				delSchool:function(school) {
					if(!confirm("确认删除，要小心哦！")) {
						return;
					}
					
					var that = this;
					for(var i = 0; i < this.schools.length; i++) {
						if(this.schools[i].sc_id == school.sc_id) {
							API.invokeModuleCall(g_host_url,'cityinfo','delSchool', school, function(json) {
								if(json.code == 0) {
									that.schools.splice(i,1);
									showMsg('删除成功');
								}
							});
							break;
						}
					}
				},
				resolvePos:function() {
					var that = this;
					this.myGeo.getPoint(this.school_add.position, function(point){
						console.log(point);
						if (point) {
							that.school_add.lng = point.lng;
							that.school_add.lat = point.lat;
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							new BMap.LocalSearch(that.map, {
								renderOptions:{map: that.map},
								onSearchComplete:function(data) {
									if(!data) {
										showMsg("您选择地址没有解析到结果!");
										return;
									}
									
									console.log(data);
									if(data) {
										var point = data.getPoi(0);
										if (point){//取第1个查询结果
											that.map.centerAndZoom(point, 11);
											that.school_add.lng = point.point.lng;
											that.school_add.lat = point.point.lat;
										} else {
											showMsg("您选择地址没有解析到结果!");
										}
									}
								}
							}).search(that.school_add.position);
						}
					}, "北京市");
				},
				showCreateAreaDlg:function() {
					this.show_add_school = true;
				},
				onClickCancel:function() {
					this.show_add_school = false;
				},
				delArea:function(area) {
					var that = this;
					API.invokeModuleCall(g_host_url, "cityinfo", "delSchool", {area_id:area.area_id}, function(json) {
						if(json.code == 0) {
							for(var i = 0;i < that.areas.length; i++) {
								if(that.areas[i].area_id == area.area_id) {
									that.areas.splice(i,1);
								}
							}
							that.show_add_school = false;
						}
					});
				},
				onClickAdd:function() {
					var that = this;
					if(this.school_add.name == "") {
						alert('请填写学校名称');
						return;
					}
					
					if(this.school_add.position == "") {
						alert("请填写学校地址");
						return;
					}
					
					API.invokeModuleCall(g_host_url, "cityinfo", "addSchool", this.school_add, function(json) {
						if(json.code == 0) {
							that.show_add_school = false;
							that.schools.push(json.school);
						}
					});
				}
			}
		})
	});
</script>
</html>