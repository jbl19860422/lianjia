$(function() {
/*****************普通面板组件--编辑********************/
	var normalComPanel = Vue.component('normalpanel-com-panel', {
		props:['prop','pages','page_groups','acts','child_cates','goods','goodsshow_cate','channels','topics','videocates','map_name'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<div v-if="prop.curr_sel_id==\'\'">'+
				'<div v-html="prop.curr_sel_id"></div>'+
				'<ul class="nav nav-tabs">'+
					'<li class="active" style="width:50%;">'+
						'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>顺序面板组件</a>'+
					'</li>'+
					'<li style="width:50%">'+
						'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
					'</li>'+
				'</ul>'+
				'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
					'<normalpanel-com-panel1 :prop="prop" @delSubCom="delSubCom" :map_name="map_name"></normalpanel-com-panel1>'+
					'<normalpanel-com-panel2 :prop="prop"></normalpanel-com-panel2>'+
				'</div>'+
				'<div style="clear:both;"></div>'+
			'</div>'+
			'<template v-if="prop.curr_sel_id!=\'\'" v-for="subcom in prop.subcoms">'+
				'<component :is="subcom.c_type+\'-panel\'" :prop="subcom.prop" :pages="pages" :page_groups="page_groups" :acts="acts" :child_cates="child_cates" :goods="goods" :goodsshow_cate="goodsshow_cate" :channels="channels" :topics="topics" :videocates="videocates" v-if="prop.curr_sel_id==subcom.prop.id"></component>'+
			'</template>'+
		'</div>',
		methods:{
			delSubCom:function(index) {
				this.prop.subcoms.splice(index, 1);
			},
			onClickSubUp:function(prop,subcom) {
				this.$emit('onclicksubup',prop,subcom);
			}
		}
	});
	/*****************普通面板组件--编辑1*****************/
	var normalComPanel1 = Vue.component('normalpanel-com-panel1',{
		props:['prop','map_name'],
		template:
		 '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-carousel-item" @click="addSubCom()">添加子组件</div>'+
      	'</div>'+
      	'<div class="click-setting-title">子组件</div>'+
    		'<ul style="width:100%;margin-left:auto;padding-bottom:10px;margin-right:auto;margin-bottom:10px;padding-top:10px;border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;border-top:none;">'+
	    		'<li v-for="(subcom,index) in prop.subcoms" style="cursor:pointer;width:80%;margin-left:auto;margin-right:auto;margin-top:10px;" class="slide-item">'+
	    			'<div>'+
	      			'<div style="width:80%;line-height:40px;height:40px;border:1px solid #ddd;border-radius:8px;">'+
	      				'<div @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="index+map_name[subcom.c_type]" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel(index)"></span>'+
	      				'<span class="icon icon-arrow-up" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickSubUp(prop,subcom)" title="上移"></span>'+
	      				'<span class="icon icon-arrow-down" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickSubDown(prop,subcom)" title="下移"></span>'+
	      			'</div>'+
	      		'</div>'+
	      	'</li>'+
	      '</ul>'+
     '</div>',
    methods:{
    	onClickDel:function(index) {
    		this.$emit('delSubCom', index);
    	},
    	addSubCom:function() {
    		g_dlgAddNormalSubcom.com_id = this.prop.id;
    		g_dlgAddNormalSubcom.show = true;
    	},
    	onClickSubUp:function(prop,subcom) {
    		var subcoms = myDeepCopy(prop.subcoms);
    		for(var i = 0; i < subcoms.length; i++) {
    			if(subcoms[i].prop.id == subcom.prop.id) {
    				if(i == 0) {
    					break;
    				} else {
    					var tmp = subcoms[i];
    					subcoms[i] = subcoms[i-1];
    					subcoms[i-1] = tmp;
    				}
    			}
    		}
    		prop.subcoms = subcoms;
    	},
    	onClickSubDown:function(prop,subcom) {
    		var subcoms = myDeepCopy(prop.subcoms);
    		for(var i = 0; i < subcoms.length; i++) {
    			if(subcoms[i].prop.id == subcom.prop.id) {
    				if(i == subcoms.length-1) {
    					break;
    				} else {
    					var tmp = subcoms[i];
    					subcoms[i] = subcoms[i+1];
    					subcoms[i+1] = tmp;
    				}
    			}
    		}
    		prop.subcoms = subcoms;
    	}
    }
	});
	/*****************普通面板组件--编辑2*******************/
	var normalComPanel2 = Vue.component('normalpanel-com-panel2',{
		props:['prop'],
		template:
		 '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div>'+
      		'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
		      	'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;padding-top:10px;padding-left:10px;">'+
		      		'<div>'+
		      			'<div style="margin-left:10px;">高度模式'+
		      				'<select @change="onChangeHeightMode($event)" style="margin-left:10px;height:40px;">'+
		      					'<option value="auto" :selected="prop.styles.sizeStyle.height==\'auto\'">随内容高度</option>'+
		      					'<option value="fixed" :selected="prop.styles.sizeStyle.height!=\'auto\'">固定高度</option>'+
		      				'</select>'+
		      			'</div>'+
		      			'<div v-if="prop.styles.sizeStyle.height!=\'auto\'">'+
				      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
			      				'<div style="float:left">可视高度</div>'+
			      				'<div class="my-spinner input-height" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" :value="prop.styles.outterStyle.viewheight"></input>'+
												'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
										'<div @click="onClickFillLeftHeight()" style="float:left;margin-left:20px;background-color:#efbf1f;text-align:center;line-height:40px;margin-right:auto;padding-left:5px;padding-right:5px;cursor:pointer;border-radius:8px;color:white;">填充手机剩余空间</div>'+
									'</div>'+
									'<div style="clear:both;height:10px;"></div>'+
									'<div>'+
					      		'<div style="margin-left: 10px; font-size: 20px;">'+
				      				'<div style="float:left">实际高度</div>'+
				      				'<div class="my-spinner input-real-height" style="float:left;margin-left:10px;">'+
												'<div class="input-area">'+
												'<input style="font-size:20px" :value="prop.styles.realheight"></input>'+
												'<span style="font-size:16px">px</span>'+
												'</div>'+
												'<div class="btn-area">'+
														'<div class="plus-btn"></div>'+
														'<div class="minus-btn"></div>'+
												'</div>'+
											'</div>'+
											'<div @click="onClickRealHeight()" style="float:left;margin-left:20px;background-color:#efbf1f;text-align:center;line-height:40px;margin-right:auto;padding-left:5px;padding-right:5px;cursor:pointer;border-radius:8px;color:white;" v-html="prop.styles.isrealheight?\'收缩为可视高度\':\'展开为实际高度\'"></div>'+
									'</div>'+
								'</div>'+
								'</div>'+
		      		'</div>'+
							'<div style="clear:both;height:10px;"></div>'+
							'<div>'+
								'<div style="margin-left: 10px; font-size: 20px;"><div style="float:left">间距&nbsp;&nbsp;&nbsp;&nbsp;左</div>'+
									'<div class="my-spinner input-margin-left" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.outterStyle[\'margin-left\'].substr(0,prop.styles.outterStyle[\'margin-left\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div style="float:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上</div>'+
									'<div class="my-spinner input-margin-top" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.outterStyle[\'margin-top\'].substr(0,prop.styles.outterStyle[\'margin-top\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-top:10px;margin-bottom:10px;"></div>'+
							'<div style="clear:both;margin-top:10px;margin-bottom:20px;">'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">背景</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="bkcolor-input color-input"/>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-top:10px;margin-bottom:20px;height:10px;"></div>'+
							'<div style="height:10px;clear:both;margin-top:20px;margin-bottom:10px;"></div>'+
	      		'</div>'+
	      	'</div>'+
      	'</div>'+
     '</div>',
		mounted:function() {
			var that = this;
			$(this.$el).find(".input-height").my_spinner({change:function(val) {
				that.prop.styles.viewheight = val;
				that.prop.styles.sizeStyle.height = val+'px';
				that.prop.styles.isfillheight = false;
				if(that.prop.styles.realheight <= that.prop.styles.viewheight) {
					that.prop.styles.realheight = that.prop.styles.viewheight;
				}
			},maxValue:100000,defaultValue:that.prop.styles.viewheight});
			
		  $(this.$el).find(".input-real-height").my_spinner({change:function(val) {
				that.prop.styles.realheight = val;
				
				if(that.prop.styles.isrealheight) {
					that.prop.styles.sizeStyle.height = that.prop.styles.realheight+"px";
				}
			},maxValue:100000,defaultValue:that.prop.styles.realheight});
			
			
			$(this.$el).find(".input-margin-left").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['margin-left'] = val+'px';
			},maxValue:100000,defaultValue:that.prop.styles.outterStyle['margin-left'].substr(0,that.prop.styles.outterStyle['margin-left'].length-2)});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['margin-top'] = val+'px';
			},maxValue:100000,defaultValue:that.prop.styles.outterStyle['margin-top'].substr(0,that.prop.styles.outterStyle['margin-top'].length-2)});

			//背景
			$(this.$el).find(".bkcolor-input").spectrum({
		    color: that.prop.styles.outterStyle['background-color'],
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
		        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
		        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
		    ],
		    chooseText: "确定",
  			cancelText: "取消",
  			change:function(val) {
  				that.prop.styles.outterStyle['background-color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.outterStyle['background-color'] = val.toHexString();
  			}
			});
//			//透明度
//			$(this.$el).find(".alpha-slider").slider({
//	  		range:"min",
//	  		orientation: "horizontal",
//	  		min:0,
//	  		max:100,
//	  		value:that.prop.styles.outterStyle.opacity*100,
//	  		change:function(e) {
//	  			that.prop.styles.outterStyle.opacity = parseFloat($(e.target).slider("value"))/100;
//	  		},
//	  		slide:function(e) {
//	  			that.prop.styles.outterStyle.opacity = parseFloat($(e.target).slider("value"))/100;
//	  		}
//  		});
		},
		updated:function() {
			var that = this;
			$(this.$el).find(".input-height").my_spinner({change:function(val) {
				that.prop.styles.viewheight = val;
				that.prop.styles.sizeStyle.height = val+'px';
				that.prop.styles.isfillheight = false;
				if(that.prop.styles.realheight <= that.prop.styles.viewheight) {
					that.prop.styles.realheight = that.prop.styles.viewheight;
				}
			},maxValue:100000,defaultValue:that.prop.styles.viewheight});
			
		  $(this.$el).find(".input-real-height").my_spinner({change:function(val) {
				that.prop.styles.realheight = val;
				
				if(that.prop.styles.isrealheight) {
					that.prop.styles.sizeStyle.height = that.prop.styles.realheight+"px";
				}
			},maxValue:100000,defaultValue:that.prop.styles.realheight});
		},
		methods:{
			onClickRealHeight:function() {
				var that = this;
				if(this.prop.styles.isrealheight) {
					this.prop.styles.sizeStyle.height = this.prop.styles.viewheight+"px";
					this.prop.styles.isrealheight = false;
				} else {
					this.prop.styles.sizeStyle.height = this.prop.styles.realheight+"px";
					this.prop.styles.isrealheight = true;
				}
			},
			onChangeHeightMode:function(e) {
				var that = this;
				var val = $(e.target).val();
				if(val == "auto") {
					this.prop.styles.sizeStyle.height = 'auto';
				} else if(val == "fixed") {
					this.prop.styles.isrealheight = false;
					if(this.prop.styles.isrealheight) {
						this.prop.styles.sizeStyle.height = this.prop.styles.realheight+"px";
					} else {
						this.prop.styles.sizeStyle.height = this.prop.styles.viewheight+"px";
					}
				}
			},
			onClickFillLeftHeight:function() {
				var that = this;
				if(g_page.coms[g_page.coms.length-1].prop.id != that.prop.id) {
					alert('该组件必须在最后面才能设置该属性');
					return;
				}
				
				var otherComsHeight = 0;
				for(var i = 0; i < g_page.coms.length-1; i++) {
					console.log(g_page.coms[i].prop.id);
					otherComsHeight += $('#'+g_page.coms[i].prop.id).outerHeight();
				}
				
				console.log(otherComsHeight,g_page.phone_size.height);
				if(otherComsHeight >= g_page.phone_size.height) {
					alert('手机已经被填满');
					return;
				}
				
				that.prop.styles.viewheight = g_page.phone_size.height - otherComsHeight;
				that.prop.styles.sizeStyle.height = that.prop.styles.viewheight+"px";
				if(that.prop.styles.realheight <= that.prop.styles.viewheight) {
					that.prop.styles.realheight = that.prop.styles.viewheight;
				}
				that.prop.styles.isfillleft = true;
			}
		}
	});
});