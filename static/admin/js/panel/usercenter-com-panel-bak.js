$(function() {
/**************图片组件--编辑******************/
  var	usercenterComPanel = Vue.component('usercenter-com-panel', {
		props:['prop','page_groups', 'pages'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>个人中心</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<usercenter-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups"></usercenter-com-panel1>'+
				'<usercenter-com-panel2 :prop="prop"></usercenter-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted pic panel");
		}
	});
	/**************个人中心--编辑1******************/
	var usercenterComPanel1 = Vue.component('usercenter-com-panel1',{
		props:['prop','pages', 'page_groups'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<input type="checkbox" style="width:20px;height:20px" @click="clickAddr()" :checked="prop.addr?\'checked\':\'\'"></input><span style="margin-left:10px">显示收货地址</span>'+
      	'</div>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<input type="checkbox" style="width:20px;height:20px" @click="clickOrder()" :checked="prop.order?\'checked\':\'\'"></input><span style="margin-left:10px">显示我的订单</span>'+
      	'</div>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<input type="checkbox" style="width:20px;height:20px" @click="clickCart()" :checked="prop.cart?\'checked\':\'\'"></input><span style="margin-left:10px">显示购物车</span>'+
      	'</div>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<input type="checkbox" style="width:20px;height:20px" @click="clickItem()" :checked="prop.item?\'checked\':\'\'"></input><span style="margin-left:10px">显示我的物品</span>'+
      	'</div>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	clickAddr:function() {
    		this.prop.addr = !this.prop.addr;
    	},
    	clickOrder:function() {
    		this.prop.order = !this.prop.order;
    	},
    	clickCart:function() {
    		this.prop.cart = !this.prop.cart;
    	},
    	clickItem:function() {
    		this.prop.item = !this.prop.item;
    	}
		}
	});
	/**************图片组件--编辑2******************/
	var usercenterComPanel2 = Vue.component('usercenter-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<img :src="prop.bkimg" style="border:1px solid #aaaaaa;height:100px;width:auto"></img>'+
	      		'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" @click="onChangeImg()">更换背景图片</span>'+
		      '</div>'+
		      '<div style="clear:both"></div>'+
     	 '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onChangeImg:function() {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'bkimg';
				g_piclistDlg.obj = this.prop;
			}
		}
	});
});