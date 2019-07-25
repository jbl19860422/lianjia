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
	<link href="../../../static/css/availability.css?v=1" rel="stylesheet">
	<link href="../../../static/css/guest.css" rel="stylesheet">
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
			<li class="active"><a href="#">合同</a></li>
			<!--<li><a href="#">财务</a></li>-->
			<li><a href="#">业绩</a></li>
		</ul>
	</div>
	<div class="breadcrumb-div mg-c">
		<ul class="breadcrumb-ul">
			<li>
				当前位置：
			</li>
			<li>
				签约-创建订单
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		
		<div class="panel panel-default">
			<div class="panel-heading panel-title">
				<div class="contract-list">
					<div class="he">
						合同列表
						<span class="pull-right add-pull-right">
							本协议要打印后双方签字后生效
						</span>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="form-group">
                        <label class="col-sm-3 text-right form-v-label">业务类型</label>
                        <div class="col-sm-3">
                            <select class="form-control"> 
								<option>二手买卖</option> 
								<option>1</option> 
								<option>2</option>  
							</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 text-right form-v-label">协议类型</label>
                        <div class="col-sm-3">
                            <select class="form-control"> 
								<option>合同</option> 
								<option>1</option> 
								<option>2</option>  
							</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 text-right form-v-label">房源编号</label>
                        <div class="col-sm-3">
                            <input type="text" name="name" placeholder="123456787654" class="form-control">
                        </div>
                        <div class="col-sm-2">
                        	<div class="add-contract-btn"@click = "addContract()">
                        		<i class="fa fa-search"></i>
                        		获取房源编号信息
                        	</div>
                        </div>
                        <div class="col-sm-2">
                        	<p class="add-contract-p">房源编号不能为空</p>
                        </div>
                    </div>
                    <div class="add-contract-div" v-if = "add_contract">
                    	<div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">标题图</label>
	                        <div class="col-sm-4">
	                            <img src="../../../static/img/l.jpg" class="add-contract-img"/>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">房屋用途</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>普通住宅</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-1 add-contract-i">
	                        	<i class="fa fa-check-circle-o"></i>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">楼层</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>物理31层，标号31层</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-1 add-contract-i">
	                        	<i class="fa fa-check-circle-o"></i>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">楼栋名称</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>2栋</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-1 add-contract-i">
	                        	<i class="fa fa-check-circle-o"></i>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">居室</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>3室</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-1 add-contract-i">
	                        	<i class="fa fa-check-circle-o"></i>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">用电类型</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>民电</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-1 add-contract-i">
	                        	<i class="fa fa-check-circle-o"></i>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">用水类型</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>民电</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-3 add-contract-i">
	                        	<p class="add-contract-i-p">选择和系统不一致</p>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">用水类型</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>民电</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                        <div class="col-sm-3 add-contract-i">
	                        	<p class="add-contract-i-p">选择和系统不一致</p>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-sm-3"></div>
	                    	<div class="col-sm-3">
	                    		<div class="add-contract-btn">
	                        		<i class="fa fa-search"></i>
	                        		校验房源信息
	                        	</div>
	                    	</div>
                        </div>
                        <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">客源编号</label>
	                        <div class="col-sm-3">
	                            <input type="text" name="name" placeholder="123456787654" class="form-control">
	                        </div>
	                        <div class="col-sm-2">
	                        	<div class="add-contract-btn" @click = "keContract()">
	                        		<i class="fa fa-search"></i>
	                        		获取客户姓名
	                        	</div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">客户姓名</label>
	                        <div class="col-sm-3">
	                        	<p class="add-contract-k" v-if = "ke_contract">姜先生</p>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-3 text-right form-v-label">签约同事</label>
	                        <div class="col-sm-3">
	                            <select class="form-control"> 
									<option>小马</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-sm-3"></div>
	                    	<div class="col-sm-3">
	                    		<div class="btn-div">保存</div>
	                    	</div>
	                    </div>
                    </div>
				</form>
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
				add_contract:false,
				ke_contract:false,
				show_my_search:true,
				my_labels:<?=json_encode($labels)?>,
				my_search:{
					guest:{
						like_name:'',//名词搜索
						intention:'',
						curr_progress:'',
						min_price:'',
						max_price:'',
						min_area:'',
						max_area:'',
						room_count:'',
						label:''
					},

					house_info_id:'',//房源编号
					maintain_name:'',//维护人姓名
					pi:1,
					pc:12
				},
				my_page_changed:false,
				my_total_count:0,
				my_page_count:0,
				my_page_guests:{},
				my_guest_count:{
					intention:[0,0,0,0],
					curr_progress:[0,0,0,0],
				},
				my_price_min:'',
				my_price_max:'',
				my_area_min:'',
				my_area_max:'',
				my_like_name:'',
				
				employee:<?=json_encode($employee)?>,
				areas:<?=json_encode($areas)?>,
				trade_areas:<?=json_encode($trade_areas)?>,
				house_infoes:<?=json_encode($house_infoes)?>,
			},
			created:function() {
				var that = this;
				API.invokeModuleCall(g_host_url,'guest','initQueryMyBuyGuest', {}, function(json) {
					for(var i = 0; i < json.intention.length; i++) {
						that.my_guest_count.intention[i] = json.intention[i];
					}
					
					for(var i = 0; i < json.curr_progress.length; i++) {
						that.my_guest_count.curr_progress[i] = json.curr_progress[i];
					}
					that.$forceUpdate();
				});
				
				this.my_page_guests = [];
				this.my_search.pi = 1;
				
				var that = this;
				console.log("load:"+that.my_search.pi);
				API.invokeModuleCall(g_host_url, 'guest', 'queryMyBuyGuest', this.my_search, function(json) {
					that.my_total_count = json.total_count;
					that.my_page_count = json.page_count;
					that.my_page_guests[that.my_search.pi+''] = json.guests;
				});
				
			},
			computed:{
				
			},
			mounted:function() {
				$(this.$el).find("#dlg_create_city").css("display",'');
			},
			watch:{
				my_search:{
					handler(newval,oldval) {
						var that = this;
						if(this.my_page_changed) {//如果是页面位置变动，则判断是否加载了该页面
							if(typeof(this.my_page_guests[that.my_search.pi]) == "undefined") {
								console.log("load1:"+that.my_search.pi);
								API.invokeModuleCall(g_host_url, 'guest', 'queryMyBuyGuest', this.my_search, function(json) {
									that.my_total_count = json.total_count;
									that.my_page_count = json.page_count;
									that.my_page_guests[that.my_search.pi+''] = json.guests;
									that.$forceUpdate();
								});
							}
							this.my_page_changed = false;
						} else {
							this.my_page_guests = {};
							console.log("load2:"+that.my_search.pi);
							API.invokeModuleCall(g_host_url, 'guest', 'queryMyBuyGuest', this.my_search, function(json) {
								that.my_total_count = json.total_count;
								that.my_page_count = json.page_count;
								that.my_page_guests[that.my_search.pi+''] = json.guests;
								that.$forceUpdate();
							});
						}
					},
					deep:true
				}
			},
			methods:{
				addContract:function(){
					this.add_contract = true;
				},
				keContract:function(){
					this.ke_contract = true;
				}
			}
		})
	});
</script>
</html>