$(function() {
/****************分栏组件--编辑************/
	var categoryComPanel = Vue.component('category-menu-com-panel', {
		props:['prop', 'curr_com_id','coms','pages', 'page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>分栏组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<category-menu-com-panel1 :prop="prop" :coms="coms" :pages="pages" :page_groups="page_groups" :acts="acts"></category-menu-com-panel1>'+
				'<category-menu-com-panel2 :prop="prop" :coms="coms"></category-menu-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************分栏组件--编辑1******************/
	var categoryComPanel1 = Vue.component('category-menu-com-panel1',{
		props:['prop','coms','pages', 'page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-category-item">添加一栏</div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;" class="slide-item">'+
      			'<div>'+
	      			'<div @click="onClickCollapseBtn($event,index)" style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;cursor:pointer;">'+
	      				'<div :class="{\'collapse-btn\':true,\'close-btn\':index!=prop.currIndex,\'open-btn\':index==prop.currIndex}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="item.title" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($event,index)"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true,hide:index!=prop.currIndex}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<span>标题</span>'+
	      				'<input v-model="item.title" style="margin-left:10px"></input>'+
	      				'<click-setting-com :action="item.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
	      			'</div>'+
	      		'</div>'+
      		'</li>'+
      	'</ul>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    	that.curr_index = 0;
	    //添加一项
	    $(this.$el).find(".add-category-item").click(function() {
	    	that.prop.items.push(
	    		{
			      "title": "标题",
			      action:{//点击动作
  						type:'none',
  						//none:无动作，page_act：打开页面，fun_act：其他功能（领取优惠券或者其他的）
  						subtype:'none',
  						detail:{
  						}
  					}
			    }
	    	);
	    });
    },
    updated:function() {
    	var that = this;
    },
    methods:{
    	onChangeAttachCom:function(e, index) {

    	},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClickCollapseBtn:function(e,index) {
				this.prop.currIndex = index;
			},
			onClickDel:function(e,index) {
				if(this.prop.items[index].attach_com_id) {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.items[index].attach_com_id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
				}
				this.prop.items.splice(index, 1);
				e.stopPropagation();
			}
		}
	});
	/****************分栏组件--编辑2******************/
	var categoryComPanel2 = Vue.component('category-menu-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="clear:both;height:10px"></div>'+
      	'<div>'+
					'<div style="float:left">'+
						'菜单宽度模式：'+
						'<select v-model="prop.mode">'+
							'<option value="1">固定宽度</option>'+
							'<option value="2">平均分配</option>'+
						'</select>'+
					'</div>'+
				'</div>'+
				'<div style="clear:both;height:10px"></div>'+
      	'<div v-if="prop.mode==1">'+
					'<div style="padding-top: 10px; font-size: 20px;">'+
						'<div style="float:left">宽度值：</div>'+
						'<div class="my-spinner input-item-width" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.itemWidth"></input>'+
								'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
								'<div class="plus-btn"></div>'+
								'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:20px"></div>'+
				'</div>'+
      	'<div style="clear:both;height:10px"></div>'+
      	'<div>'+
					'<div style="float:left">'+
						'背景颜色：<input type="text" class="bk-color-input"/>'+
					'</div>'+
				'</div>'+
      	'<div style="clear:both;height:10px"></div>'+
      	'<div>'+
					'<div style="padding-top: 10px; font-size: 20px;"><div style="float:left">间距</div>'+
					'<div style="float:left;margin-left:10px">上</div>'+
						'<div class="my-spinner input-margin-top" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-top\'].substr(0,prop.styles.marginStyle[\'margin-top\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
								'<div class="plus-btn"></div>'+
								'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:20px"></div>'+
				'</div>'+
				'<div style="float:left;margin-right:10px;">'+
					'文字设置'+
				'</div>'+
				'<font-setting-pane :fontStyle="prop.styles.fontStyle" :prop="prop" :hide_align="true"></font-setting-pane>'+
				'<div style="clear:both;height:10px"></div>'+
      	'<div>'+
					'<div style="float:left">'+
						'选择颜色：<input type="text" class="active-color-input"/>'+
					'</div>'+
				'</div>'+
				
				'<div style="clear:both;height:10px"></div>'+
				'<div>'+
					'<div style="padding-top: 10px; font-size: 20px;">'+
						'<div style="float:left">选择底块高度</div>'+
						'<div class="my-spinner input-ud-height" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.udHeight.substr(0,prop.udHeight.length-2)"></input>'+
								'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
				'</div>'+
				'<div>'+
					'<div style="padding-top: 10px; font-size: 20px;">'+
						'<div style="float:left">选择地块宽度比</div>'+
						'<div class="my-spinner input-ud-width" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.udWidth.substr(0,prop.udHeight.length-1)"></input>'+
								'<span style="font-size:16px">%</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:20px"></div>'+
				'</div>'+
      '</div>',
    mounted:function() {
    	var that = this;

			$(this.$el).find(".bk-color-input").spectrum({
			    color: that.prop.styles.bkcolorStyle['background-color'],
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
    				if(val == null) {
    					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
    				} else {
    					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
    				}
    			},
    			hide:function(val) {
    				if(val == null) {
    					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
    				} else {
    					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
    				}
    			}
			});

			$(this.$el).find(".active-color-input").spectrum({
			    color: that.prop.styles.selectedFontColor,
			    float:true,
			    showInput:true,
			    allowEmpty:true,
			    showAlpha:false,
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
    				that.prop.styles.selectedFontColor = val.toHexString();
    			},
    			hide:function(val) {
    				that.prop.styles.selectedFontColor = val.toHexString();
    			}
			});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0, that.prop.styles.marginStyle['margin-top'].length-2)});
			
			$(this.$el).find(".input-ud-height").my_spinner({change:function(val) {
				that.prop.udHeight = val+'px';
			},maxValue:1000,defaultValue:that.prop.udHeight.substr(0, that.prop.udHeight.length-2)});
			
			$(this.$el).find(".input-ud-width").my_spinner({change:function(val) {
				that.prop.udWidth = val+'%';
			},maxValue:100,defaultValue:that.prop.udWidth.substr(0, that.prop.udWidth.length-1)});
    },
    methods:{
    	
    }
  });
});