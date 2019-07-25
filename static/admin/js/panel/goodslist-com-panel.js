$(function() {
	function getArray(cate_id, d) {
		if(d) {
				for (var i = 0; i < d.length; i++) {
		      if (d[i].cate_id == cate_id) {
		      	return d[i];
		      } else {
		      	if(d[i].child_cates) {
		        	var c = getArray(cate_id,d[i].child_cates);
		        	if(c) {
		        		return c;
		        	}
		        }
		      }
	    	}
		}

    return null;
  }
  
	function getChildIds(d) {
  	var addIds = [];
  	addIds.push(d.cate_id);
  	if(d.child_cates && d.child_cates.length > 0) {
  		for(var i = 0;i < d.child_cates.length; i++) {
  			addIds = addIds.concat(getChildIds(d.child_cates[i]));
  		}
  	}
  	return addIds;
  }
  
	var categoryItem = Vue.component('category-item', {
			props:['cate','prop'],
			template: 
			'<li class="tree-node">'+
				'<label>'+
					'<div class="node-content" :style="[prop.cate_id==cate.cate_id?{color:\'#438eb9\'}:{}]">'+
						'<i v-if="!cate.img" :class="{icon:true,\'icon-file-empty\':!cate.child_cates||cate.child_cates.length<=0,\'icon-folder\':cate.child_cates&&cate.child_cates.length>0&&!cate.unfolder,\'icon-folder-open\':cate.child_cates&&cate.child_cates.length>0&&cate.unfolder}" @click="onUnfolder($event)"></i>'+
						'<img :src="cate.img" style="width:22px;height:22px" v-if="cate.img"></img>'+
						'<span class="node-input-text" v-show="!cate.edit" @click="onClick($event)">{{cate.name}}</span>'+
						'<span class="icon icon-checkmark" style="font-size:1.5rem;color:green;margin-left:5px;" v-if="prop.cate_id==cate.cate_id"></span>'+
					'</div>'+
				'</label>'+
				'<ul v-if="cate.child_cates&&cate.child_cates.length>0" v-show="cate.unfolder" class="my-tree">'+
					'<category-item @change_cate_id="change_cate_id" v-for="cate in cate.child_cates" :cate="cate" :prop="prop"></category-item>'+
				'</ul>'+
			'</li>',
			mounted:function() {
				console.log("**************************");
				console.log(this.cate);
			},
			methods:{
				onUnfolder:function(e) {
					this.cate.unfolder = !this.cate.unfolder;
					this.$forceUpdate();
				},
				onClick:function(e) {
					this.$emit('change_cate_id', this.cate.cate_id);
				},
				change_cate_id:function(id) {
					this.$emit('change_cate_id', id);
				}
			}
		});
	
/****************商品列表组件--编辑************/
	var goodslistPanel = Vue.component('goodslist-com-panel', {
		props:['prop','pages','page_groups','child_cates', 'goods','goodsshow_cate'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>商品列表组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<goodslist-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :child_cates="child_cates" :goods="goods" :goodsshow_cate="goodsshow_cate"></goodslist-com-panel1>'+
				'<goodslist-com-panel2 :prop="prop" :goods="goods"></goodslist-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
		}
	});
	/****************商品列表组件--编辑1******************/
	var goodslistComPanel1 = Vue.component('goodslist-com-panel1',{
		props:['prop','pages','page_groups','child_cates','goods','goodsshow_cate'],
		template:
		  '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
		  	'<div style="margin-top:3px;text-align:left;">'+
		  		'类别选择方式:'+
		  		'<select v-model="prop.cate_mode" style="margin-left:10px;height:40px;border-radius:4px">'+
		  			'<option value="fun">基本类别</option>'+
		  			'<option value="show">展示类别</option>'+
		  		'</select>'+
		  	'</div>'+
		  	'<div style="height:10px;clear:both"></div>'+
				'<div style="margin-top:3px;text-align:left;" v-show="prop.cate_mode==\'fun\'">'+
					'<div>展示商品类别选择：</div>'+
					'<ul class="my-tree">'+
						'<label style="cursor:pointer">'+
						'<div class="node-content">'+
							'<i @click="onClickFolder()" :class="{icon:true,\'icon-folder-open\':show_root,\'icon-folder\':!show_root}" ></i>'+
							'<span @click="onSetId()" class="node-input-text">全部商品</span>'+
							'<span class="icon icon-checkmark" style="font-size:1.5rem;color:green;margin-left:5px;" v-if="prop.cate_id==0"></span>'+
						'</div>'+
						'</label>'+
						'<ul class="my-tree" v-show="show_root">'+
							'<category-item @change_cate_id="change_cate_id" v-for="cate in child_cates" :prop="prop" :cate="cate"></category-item>'+
						'</ul>'+
				  '</ul>'+
				'</div>'+
				'<div style="margin-top:3px;text-align:left;" v-if="prop.cate_mode==\'show\'">'+
					'<div>展示商品类别选择：'+
						'<select v-model="prop.cate_id" style="margin-left:10px;height:40px;border-radius:4px">'+
							'<option :value="gsc.cate_id" v-for="gsc in goodsshow_cate" v-html="gsc.cate_name"></option>'+
						'</select>'+
					'</div>'+
					'</div>'+
				'</div>'+
		  '</div>',
		data:function() {
			return {
				show_root:false,
			};
		},
		created:function() {
		},
		mounted:function() {
			
		},
		updated:function() {
		},
		methods:{
			change_cate_id:function(id) {
				this.prop.cate_id = id;
			},
			onClickFolder:function() {
				this.show_root = !this.show_root;
			},
			onSetId:function() {
				this.prop.cate_id = '0';
			}
		},
		watch:{
			'prop.cate_id':function(new_id) {
				console.log(this.prop);
				var that = this;
				if(this.prop.cate_mode == 'fun') {
					if(this.prop.cate_id) {
						var root = getArray(this.prop.cate_id,this.child_cates);
						var ids= [];
						if(this.prop.cate_id == "0") {
							for(var i = 0; i < this.child_cates.length; i++) {
								ids = ids.concat(getChildIds(this.child_cates[i]));
							}
						} else {
							ids = getChildIds(root);
						}
						
						console.log(ids);
						this.prop.goodsList = [];
						for(var i = 0; i < this.goods.length; i++) {
							for(var j = 0; j < ids.length; j++) {
								if(this.goods[i].cate_id == ids[j]) {
									this.prop.goodsList.push(this.goods[i]);
								}
							}
						}
					}
				} else if(this.prop.cate_mode == "show") {
					that.prop.goodsList = [];
					API.invokeCall("queryGoodsshow",{cate_id:this.prop.cate_id},function(json) {
						if(json.code == 0) {
							console.log(json.goodsshow);
							for(var i = 0; i < json.goodsshow.length; i++) {
								for(var j = 0;j < that.goods.length; j++) {
									if(json.goodsshow[i].goods_id == that.goods[j].goods_id) {
										that.prop.goodsList.push(that.goods[j]);
									}
								}
							}
						}
					});
				}
			}
		}
	});
	/****************商品列表组件--编辑2******************/
	var goodslistComPanel2 = Vue.component('goodslist-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-left:20px">'+'<div style="clear:both"></div>'+
      		'<div style="margin-top:20px">'+
      			'<div style="float:left">购买按钮颜色：</div>'+
      			'<div style="float:left;margin-left:20px;">'+
					'<input type="text" class="btn-color-input color-input"/>'+
				'</div>'+
      			'<div style="clear:both"></div>'+
      		'</div>'+
      		
      		'<div style="margin-top:20px">'+
      			'<div style="float:left">购买按钮文字：</div>'+
      			'<div style="float:left;margin-left:20px;">'+
						'<input type="text" style="height:40px;font-size:20px;" v-model="prop.buy_btn_name"/>'+
				'</div>'+
      			'<div style="clear:both"></div>'+
      		'</div>'+
      	'</div>'+
      '</div>',
    mounted:function() {
    	var that = this;
		$(this.$el).find(".btn-color-input").spectrum({
			color: that.prop.styles.btnColor,
			float:true,
			showInput:true,
			allowEmpty:true,
			showAlpha:true,
			showPalette:true,
			preferredFormat:"rgb",
			palette: [
				["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
				["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
				["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
				["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
				["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
				["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
				["#900","#b45f06","#fbf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
				["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
			],
			chooseText: "确定",
			cancelText: "取消",
			change:function(val) {
				that.prop.styles.btnColor = val.toHexString();
			},
			hide:function(val) {
				that.prop.styles.btnColor = val.toHexString();
			}
		});
    },
    methods:{
    }
  });
});