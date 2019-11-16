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
	<script src="https://cdn.bootcss.com/plupload/2.1.0/plupload.full.min.js"></script>
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
				合同-买卖合同列表
			</li>
		</ul>
	</div>
	
	<div class="mg-c">
		<ul class="sel-menu-ul"role="tablist">
			<li role="presentation" class="active sel-menu"><a href="#contract" role="tab" data-toggle="tab" aria-expanded="true">买卖合同列表</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu"><a href="#intention" role="tab" data-toggle="tab" aria-expanded="false">意向定金列表</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu"><a href="#deposit" role="tab" data-toggle="tab" aria-expanded="false">定金列表</a><div class="wh-line"></div></li>
			<li role="presentation" class="sel-menu sel-menu-r"><a style="color:#fff;" target="_blank" href="#"><i class="fa fa-file-text-o">&nbsp;</i>创建订单</a></li>
			<li style="clear:both"></li>
		</ul>
		<div class="tab-content" id="tab_content_b">
			<div role="tabpanel" class="tab-pane active" id="contract">
				<div class="list-page-div contract-div">
					<form class="form-horizontal">
						<div class="form-group">
                            <label class="col-sm-1 contract_label">合同编号：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                            
                            <label class="col-sm-1 contract_label">房源编号：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                            
                            <label class="col-sm-1 contract_label">客源编号：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                            
                            <label class="col-sm-1 contract_label">签前审核：</label>
                            <div class="col-sm-2 contract-input">
                               <select class="form-control"> 
									<option>全部</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 contract_label">交易类型：</label>
                            <div class="col-sm-2 contract-input">
                               <select class="form-control"> 
									<option>全部</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
                            </div>
                            
                            <label class="col-sm-1 contract_label">物业地址：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                            
                            <label class="col-sm-1 contract_label">客户姓名：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-1 contract_label">合同状态：</label>
                            <div class="col-sm-2 contract-input">
                               <select class="form-control"> 
									<option>全部</option> 
									<option>1</option> 
									<option>2</option>  
								</select>
                            </div>
                            
                            <label class="col-sm-1 contract_label">业主电话：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                            
                            <label class="col-sm-1 contract_label">客户电话：</label>
                            <div class="col-sm-2 contract-input">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="col-sm-1">
                        		<button class="contract_btn">查询</button>
                        	</div>	
                        	<div class="col-sm-1">
                        		<button class="contract_btn">重置</button>
                        	</div>
                        </div>
					</form>
				</div>
				<div style="margin-top:20px;font-weight:bold;font-size:1.8rem;">
					合同列表
				</div>
				<div class="panel panel-default margin2">
					<div class="panel-heading panel-title">
						<div class="contract-list">
							<div class="col-sm-1 all-col all-col-z">合同编号</div>
							<div class="col-sm-2 all-col all-col-z">房源编号/物业地址</div>
							<div class="col-sm-1 all-col all-col-z">客源编号/姓名</div>
							<div class="col-sm-1 all-col all-col-z">交易类型</div>
							<div class="col-sm-1 all-col all-col-z">创建时间</div>
							<div class="col-sm-1 all-col all-col-z">合同状态</div>
							<div class="col-sm-1 all-col all-col-z">签约审核</div>
							<div class="col-sm-1 all-col all-col-z">变更/解约</div>
							<div class="col-sm-1 all-col all-col-z">代理需带收款</div>
							<div class="col-sm-1 all-col all-col-z">业绩状态</div>
							<div class="col-sm-1 all-col all-col-z">操作</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-sm-12">
							
						</div>
						<div class="col-sm-12 school-district-div">
						
						</div>	
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="intention">
				<div class="list-page-div">222</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="deposit">
				<div class="list-page-div">333</div>
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
				onConfirmMyPrice:function() {
					this.my_search.guest.min_price = this.my_price_min;
					this.my_search.guest.max_price = this.my_price_max;
				},
				onConfirmMyArea:function() {
					this.my_search.guest.min_area = this.my_area_min;
					this.my_search.guest.max_area = this.my_area_max;
				},
				setMySearchIntention:function(i) {
					this.my_search.guest.intention = i;
				}
			}
		})
	});
</script>
</html>