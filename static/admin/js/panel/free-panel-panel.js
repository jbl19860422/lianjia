$(function() {
/*****************自由面板组件--编辑********************/
	var freeComPanel = Vue.component('freepanel-com-panel', {
		props:['prop','pages','page_groups','acts','map_name', 'items'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<div v-if="prop.curr_sel_id==\'\'">'+
				'<div v-html="prop.curr_sel_id"></div>'+
				'<ul class="nav nav-tabs">'+
					'<li class="active" style="width:50%;">'+
						'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>自由面板组件</a>'+
					'</li>'+
					'<li style="width:50%">'+
						'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
					'</li>'+
				'</ul>'+
				'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
					'<freepanel-com-panel1 :prop="prop" @delSubCom="delSubCom" :pages="pages" :page_groups="page_groups" :acts="acts" :map_name="map_name"></freepanel-com-panel1>'+
					'<freepanel-com-panel2 :prop="prop"></freepanel-com-panel2>'+
				'</div>'+
				'<div style="clear:both;"></div>'+
			'</div>'+
			'<template v-if="prop.curr_sel_id!=\'\'" v-for="subcom in prop.subcoms">'+
				'<component :is="subcom.c_type+\'-panel\'" v-if="prop.curr_sel_id==subcom.prop.id" :prop="subcom.prop" :pages="pages" :page_groups="page_groups" :acts="acts" :items="items"></component>'+
			'</template>'+
		'</div>',
		methods:{
			delSubCom:function(index) {
				this.prop.subcoms.splice(index, 1);
			}
		}
	});
	/*****************自由面板组件--编辑1*****************/
	var freeComPanel1 = Vue.component('freepanel-com-panel1',{
		props:['prop','pages','page_groups','acts','map_name'],
		template:
		 '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-carousel-item" @click="addSubCom()">添加子组件</div>'+
      	'</div>'+
      	'<div style="margin-top:10px">'+
      		'<span>显示网格？</span><input type="checkbox" :checked="prop.showGrid" @click="onClickShowGrid()" style="width:20px;height:20px;margin-left:10px;"></input>'+
      		'<span style="margin-left:10px">对齐到网格？</span><input type="checkbox" style="width:20px;height:20px;margin-left:10px;" :checked="prop.alignToGrid" @click="onClickAlignGrid()"></input>'+
      	'</div>'+
      	'<div style="margin-top:10px" v-show="prop.showGrid">'+
    			'<div style="float:left;margin-right:10px;">网格大小：</div>'+
    			'<div>'+
      			'<div class="my-spinner input-grid-size" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.gridSize"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both"></div>'+
      		'<div>'+
      			'<span>网格颜色：</span><input class="grid-color" type="text"></input>'+
      		'</div>'+
      	'</div>'+
      	'<div class="click-setting-title">子组件</div>'+
    		'<ul id="subcom_list" style="width:100%;margin-left:auto;padding-bottom:10px;margin-right:auto;margin-bottom:10px;padding-top:10px;border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;border-top:none;">'+
    		'<template v-for="(subcom,$index) in prop.subcoms">'+
	    		'<li style="cursor:pointer;width:80%;margin-left:auto;margin-right:auto;margin-top:10px;" class="slide-item" :id="subcom.id" :t="subcom.rand" @click="onClickSubcom($index)">'+
	    			'<div>'+
	      			'<div style="width:80%;line-height:40px;height:40px;border:1px solid #ddd;border-radius:8px;">'+
	      				'<div @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" style="display:inline-block;width:20px;"></div>'+
	      				'<span class="index_info" v-html="$index+\'.\'+map_name[subcom.c_type]" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($index)"></span>'+
	      				'<span class="icon icon-arrow-up" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickSubUp(prop,subcom)" title="上移"></span>'+
	      				'<span class="icon icon-arrow-down" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickSubDown(prop,subcom)" title="下移"></span>'+
	      			'</div>'+
	      		'</div>'+
	      	'</li>'+
	      '</template>'+
	      '</ul>'+
	      '<click-setting-com :action="prop.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
     '</div>',
    methods:{
    	onClickDel:function(index) {
    		this.$emit("delSubCom", index);
    	},
    	addSubCom:function() {
    		g_dlgAddFreeSubcom.com_id = this.prop.id;
    		g_dlgAddFreeSubcom.show = true;
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
    	},
    	onClickSubcom:function(index) {
    		var that = this;
    		for(var i = 0; i < that.prop.subcoms.length; i++) {
    			if(i != index) {
    				that.prop.subcoms[i].showControl = false;
    			} else {
    				that.prop.subcoms[i].showControl = true;
    			}
    		}
    		
    	},
    	onClickShowGrid:function() {
    		this.prop.showGrid = !this.prop.showGrid;
    	},
    	onClickAlignGrid:function() {
    		var that = this;
    		this.prop.alignToGrid = !this.prop.alignToGrid;
    		if(this.prop.alignToGrid) {//如果要对齐到网格，则调整所有子控件的位置
    			for(var i = 0;i < this.prop.subcoms.length; i++) {
    				if(that.prop.alignToGrid) {
        			that.prop.subcoms[i].prop.intTop = parseInt((that.prop.subcoms[i].prop.intTop/that.prop.gridSize))*that.prop.gridSize;
        			
        			that.prop.subcoms[i].prop.intLeft = parseInt((that.prop.subcoms[i].prop.intLeft/that.prop.gridSize))*that.prop.gridSize;
        			
        			that.prop.subcoms[i].prop.styles.posStyle.top = that.prop.subcoms[i].prop.intTop+"px";
        			that.prop.subcoms[i].prop.styles.posStyle.left = that.prop.subcoms[i].prop.intLeft+"px";
        		}
    			}
    		}
    	}
    },
    mounted:function() {
    	var that = this;
    	
    	var items = $("#subcom_list").children("li");
    	for(var i = 0; i < items.length; i++) {
    		if(that.prop.subcoms[i].c_type == "text") {
    			items.eq(i).find(".index_info").html(i+"文字");
    		} else if(that.prop.subcoms[i].c_type == "img") {
    			items.eq(i).find(".index_info").html(i+"图片");
    		} else if(that.prop.subcoms[i].c_type == "btn") {
    			items.eq(i).find(".index_info").html(i+"按钮");
    		}
    	}
    	if(this.prop.subcoms.length >= 2) {
      	var options = {
    			connectWith: "#subcom_list",
    			placeholder:"portlet-placeholder",
			    update: function(event, ui) {
			    	var items = $("#subcom_list").children("li");
						var newSubComs = [];
						for(var i = 0;i < items.length; i++) {
							var id = items.eq(i).attr("id");
							for(var j = 0; j < that.prop.subcoms.length; j++) {
								if(that.prop.subcoms[j].id == id) {
									newSubComs.push(that.prop.subcoms[j]);
									newSubComs[newSubComs.length-1].index = i;
									if(newSubComs[newSubComs.length-1].c_type=="text") {
										items.eq(i).find(".index_info").html(i+"文字");
									} else if(newSubComs[newSubComs.length-1].c_type=="img") {
										items.eq(i).find(".index_info").html(i+"图片");
									} else if(newSubComs[newSubComs.length-1].c_type=="btn") {
										items.eq(i).find(".index_info").html(i+"按钮");
									}
									break;
								}
							}
						}
						that.prop.subcoms = newSubComs;
			    },
			    start:function(e, ui) {
			    }
				};
				$('#subcom_list').sortable(options);
    	}
    	
    	$(this.$el).find(".input-grid-size").my_spinner({change:function(val) {
				that.prop.gridSize = val;
				
				that.prop.styles.gridStyle['background-size'] = val+"px "+val+"px !important";
				that.prop.styles.gridStyle['background-image'] = '-webkit-linear-gradient(top, transparent '+(val-2)+'px, '+that.prop.gridColor+' '+(val-1)+'px,transparent '+val+'px), -webkit-linear-gradient(left, transparent '+(that.prop.gridSize-2)+'px, '+that.prop.gridColor+' '+(val-1)+'px,transparent '+val+'px)';
				that.prop.styles.gridStyle['background-repeat'] = 'repeat repeat';
				console.log(that.prop.styles.gridStyle);
			},minValue:10,maxValue:1000,defaultValue:that.prop.gridSize});

			//背景
			$(this.$el).find(".grid-color").spectrum({
		    color: that.prop.gridColor,
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
  				that.prop.gridColor = val;
  				var gridSize = that.prop.gridSize;
  				that.prop.styles.gridStyle['background-repeat'] = 'repeat repeat';
  				that.prop.styles.gridStyle['background-size'] = gridSize+"px "+gridSize+"px !important";
  				that.prop.styles.gridStyle['background-image'] = '-webkit-linear-gradient(top, transparent '+(gridSize-2)+'px, '+that.prop.gridColor+' '+(gridSize-1)+'px,transparent '+gridSize+'px), -webkit-linear-gradient(left, transparent '+(that.prop.gridSize-2)+'px, '+that.prop.gridColor+' '+(gridSize-1)+'px,transparent '+gridSize+'px)';
  				
  				console.log(that.prop.styles.gridStyle);
  			},
  			hide:function(val) {
  				that.prop.gridColor = val;
  				var gridSize = that.prop.gridSize;
  				that.prop.styles.gridStyle['background-repeat'] = 'repeat repeat';
  				that.prop.styles.gridStyle['background-size'] = gridSize+"px "+gridSize+"px !important";
  				that.prop.styles.gridStyle['background-image'] = '-webkit-linear-gradient(top, transparent '+(gridSize-2)+'px, '+that.prop.gridColor+' '+(gridSize-1)+'px,transparent '+gridSize+'px), -webkit-linear-gradient(left, transparent '+(that.prop.gridSize-2)+'px, '+that.prop.gridColor+' '+(gridSize-1)+'px,transparent '+gridSize+'px)';
  			}
			});
    },
    updated:function() {
    	var that = this;
    	
    	var items = $("#subcom_list").children("li");
    	for(var i = 0; i < items.length; i++) {
    		if(that.prop.subcoms[i].c_type == "text") {
    			items.eq(i).find(".index_info").html(i+"文字");
    		} else if(that.prop.subcoms[i].c_type == "img") {
    			items.eq(i).find(".index_info").html(i+"图片");
    		} else if(that.prop.subcoms[i].c_type == "btn") {
    			items.eq(i).find(".index_info").html(i+"按钮");
    		}
    	}
    	
    	if(this.prop.subcoms.length >= 2) {
      	var options = {
      			connectWith: "#subcom_list",
      			placeholder:"portlet-placeholder",
				    update: function(event, ui) {
				    	var items = $("#subcom_list").children("li");
							var newSubComs = [];
							for(var i = 0;i < items.length; i++) {
								var id = items.eq(i).attr("id");
								for(var j = 0; j < that.prop.subcoms.length; j++) {
									if(that.prop.subcoms[j].id == id) {
										newSubComs.push(that.prop.subcoms[j]);
										newSubComs[newSubComs.length-1].index = i;
										if(newSubComs[newSubComs.length-1].c_type=="text") {
											items.eq(i).find(".index_info").html(i+"文字");
										} else if(newSubComs[newSubComs.length-1].c_type=="img") {
											items.eq(i).find(".index_info").html(i+"图片");
										} else if(newSubComs[newSubComs.length-1].c_type=="btn") {
											items.eq(i).find(".index_info").html(i+"按钮");
										}
										break;
									}
								}
							}
							that.prop.subcoms = newSubComs;
				    },
				    start:function(e, ui) {
				    }
				};
				$('#subcom_list').sortable(options);
    	}
    }
	});
	/****************自由面板组件--编辑2*******************/
	var freeComPanel2 = Vue.component('freepanel-com-panel2',{
		props:['prop'],
		template:
		 '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div>'+
      		'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
		      	'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div>'+
		      			'<div style="margin-left:10px;">尺寸</div>'+
		      		'</div>'+
		      		'<div>'+
			      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
		      				'<div style="float:left">可视高度</div>'+
		      				'<div class="my-spinner input-height" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.viewheight"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div @click="onClickFillLeftHeight()" style="float:left;margin-left:20px;background-color:#efbf1f;text-align:center;line-height:40px;margin-right:auto;padding-left:5px;padding-right:5px;cursor:pointer;border-radius:8px;color:white;">填充剩余高度</div>'+
								'</div>'+
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
							
							'<div style="clear:both;height:20px;"></div>'+
							'<div>'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;"><div style="float:left">间距&nbsp;&nbsp;&nbsp;&nbsp;左</div>'+
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
							'<div style="clear:both;margin-top:10px;margin-bottom:20px;height:10px;"></div>'+
							'<div style="clear:both;margin-bottom:20px;">'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">背景</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="bkcolor-input color-input"/>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-bottom:20px;height:10px;"></div>'+
							'<div style="font-size:20px;margin-left:10px;margin-bottom:10px;height:42px;" class="alpha-setting">'+
									'<div style="margin-right:20px;float:left;">透明度</div>'+
									'<div class="alpha-slider" style="margin-top:10px;width:200px;float:left;"></div>'+
							'</div>'+
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
			},maxValue:1000,defaultValue:that.prop.styles.viewheight});
			
			$(this.$el).find(".input-real-height").my_spinner({change:function(val) {
				that.prop.styles.realheight = val;
				if(that.prop.styles.isrealheight) {
					that.prop.styles.sizeStyle.height = that.prop.styles.realheight+"px";
				}
			},maxValue:1000,defaultValue:that.prop.styles.realheight});
			
			$(this.$el).find(".input-margin-left").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['margin-left'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.outterStyle['margin-left'].substr(0,that.prop.styles.outterStyle['margin-left'].length-2)});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['margin-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.outterStyle['margin-top'].substr(0,that.prop.styles.outterStyle['margin-top'].length-2)});

			//背景
			$(this.$el).find(".bkcolor-input").spectrum({
		    color: that.prop.styles.bkcolorStyle['background-color'],
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
		        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
		        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
		    ],
		    chooseText: "确定",
  			cancelText: "取消",
  			change:function(val) {
  				if(val)  {
  					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val)  {
  					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
  				}
  			}
			});
			//透明度
			$(this.$el).find(".alpha-slider").slider({
	  		range:"min",
	  		orientation: "horizontal",
	  		min:0,
	  		max:100,
	  		value:that.prop.styles.alphaStyle.opacity*100,
	  		change:function(e) {
	  			that.prop.styles.alphaStyle.opacity = parseFloat($(e.target).slider("value"))/100;
	  		},
	  		slide:function(e) {
	  			that.prop.styles.alphaStyle.opacity = parseFloat($(e.target).slider("value"))/100;
	  		}
  		});
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
			onClickFillLeftHeight:function() {
				var that = this;
				if(g_page.coms[g_page.coms.length-1].prop.id != that.prop.id) {
					alert('改组件必须在最后面才能设置该属性');
					return;
				}
				
				var otherComsHeight = 0;
				for(var i = 0; i < g_page.coms.length-1; i++) {
					otherComsHeight += $('#'+g_page.coms[i].prop.id).outerHeight();
				}
				
				console.log(otherComsHeight,g_page.phone_size.height);
				if(otherComsHeight >= g_page.phone_size.height) {
					alert('手机已经被填满'+otherComsHeight+","+g_page.phone_size.height);
					return;
				}
				
				that.prop.styles.viewheight = g_page.phone_size.height - otherComsHeight;
				that.prop.styles.sizeStyle.height = that.prop.styles.outterStyle.viewheight+"px";
				if(that.prop.styles.realheight <= that.prop.styles.viewheight) {
					that.prop.styles.realheight = that.prop.styles.viewheight;
				}
				that.prop.styles.isfillleft = true;
			}
		}
	});
});