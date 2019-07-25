$(function() {
/****************分栏组件--编辑************/
	var categoryComPanel = Vue.component('category-com-panel', {
		props:['prop', 'curr_com_id'],
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
				'<category-com-panel1 :prop="prop"></category-com-panel1>'+
				'<category-com-panel2 :prop="prop"></category-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************分栏组件--编辑1******************/
	var categoryComPanel1 = Vue.component('category-com-panel1',{
		props:['prop'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-category-item">添加一栏</div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;" @click="onClickCollapseBtn($event, index)" class="slide-item">'+
      			'<div>'+
	      			'<div style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;">'+
	      				'<div  :class="{\'collapse-btn\':true,\'close-btn\':prop.currentIndex!=index,\'open-btn\':prop.currentIndex==index}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="item.title" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($event,index)"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true,\'hide\':prop.currentIndex!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<span>标题</span>'+
	      				'<input style="height:30px;border-radius:5px;margin-left:10px;font-size:20px;" type="text" :value="item.title" v-model="item.title"></input>'+
								'<div style="height:10px"></div>'+
								'<span>挂载</span>'+
	      				'<select style="margin-left:10px" @change="onChangeAttachCom($event, index)">'+
	      					'<option value="none" :selected="item.attach_com_type==\'\'">无</option>'+
	      					'<option value="freepanel-com" :selected="item.attach_com_type==\'freepanel-com\'">自由面板</option>'+
	      					'<option value="normalpanel-com" :selected="item.attach_com_type==\'normalpanel-com\'">面板</option>'+
	      					'<option value="chat-com" :selected="item.attach_com_type==\'chat-com\'">聊天窗口</option>'+
	      				'</select>'+
	      				
	      				'<div class="click-setting-wrap" style="width:100%;position:relative;padding-top:20px;">'+
				      		'<div>'+
					      		'<ul class="setting-list" style="width:90%;margin-left:auto;margin-right:auto;height:40px;">'+
					      			'<li href=".none-setting" @click="onClickActBtn(\'none\')" :class="[\'none\', item.action.type==\'none\'?\'active\':\'\']">无</li>'+
					      			'<li href=".page_act-setting" @click="onClickActBtn(\'page_act\')" :class="[\'page_act\', item.action.type==\'page_act\'?\'active\':\'\']">打开页面</li>'+
					      			'<li href=".func_act-setting" @click="onClickActBtn(\'fun_act\')" :class="[\'fun_act\', item.action.type==\'fun_act\'?\'active\':\'\']">其他功能</li>'+
					      		'</ul>'+
					      		'<div class="setting-pane">'+
					      			'<div class="none-setting" ></div>'+
						      		'<div v-show="item.action.type==\'page_act\'" class="page_act-setting" style="width:90%;margin-left:auto;margin-right:auto;height:120px;">'+
						      			'<div style="margin-top:10px;margin-left:10px;font-size:20px">链接至：'+
						      				'<select class="page-setting-opt" style="border: 1px solid #cccline-height: 14px;padding: 2px 4px 2px 6px;outline: 0;width: 200px;margin: 0;background: #f6f6f6;border-radius: 5px;">'+
						      					'<option value ="prePage">后退</option>'+
						      					'<option value ="custom-link">自定义链接</option>'+
													'</select>'+
												'</div>'+
						      		'</div>'+
						      		'<div v-show="item.action.type==\'fun_act\'" class="fun_act-setting" style="width:90%;margin-left:auto;margin-right:auto;height:120px;">'+
						      			'<div style="margin-top:10px;margin-left:10px;font-size:20px">调用功能：'+
						      				'<select class="fun-setting-opt" style="border: 1px solid #cccline-height: 14px;padding: 2px 4px 2px 6px;outline: 0;width: 200px;margin: 0;background: #f6f6f6;border-radius: 5px;">'+
						      					'<option value ="dial">拨打电话</option>'+
						      					'<option value ="refresh">刷新页面</option>'+
						      					'<option value ="buy-goods">购买商品</option>'+
						      					'<option value ="get-coupon">领取优惠券</option>'+
						      					'<option value ="upvote">点赞</option>'+
						      				'</select>'+
						      				'<div v-if="item.action.subtype==\'dial\'" class="dial-phone-num" style="margin-top:10px">电话号码：<input class="phone-num" type="text" style="border-radius:4px !important;height:40px;" @input="onPhoneChange($event)" @propertychange="onPhoneChange($event)"></input></div>'+
						      			'</div>'+
						      		'</div>'+
						      	'</div>'+
					      	'</div>'+
				      	'</div>'+
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
			      "image": "http://dummyimage.com/1745x492/40b7ea",
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
    		var val = $(e.target).val();
    		var categoryIndex = -1;
    		for(var i = 0; i < g_page.coms.length; i++) {
    			if(g_page.coms[i].prop.id == this.prop.id) {
    				categoryIndex = i;
    				break;
    			}
    		}
    		
    		if(categoryIndex < 0) {
    			return;
    		}
    		console.log("val=",val);
    		if(val == "freepanel-com") {
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_type == "freepanel-com") {
    				return;
    			}
    			
    			console.log("attach=",g_page.coms[categoryIndex].prop.items[index].attach_com_id);
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_id != "") {//已经存在，则删除该挂载组件
    				var attach_com_id = g_page.coms[categoryIndex].prop.items[index].attach_com_id;
    				for(var i = 0; i < g_page.coms.length; i++) {
    					if(g_page.coms[i].prop.id == attach_com_id) {
    						g_page.coms.splice(i, 1);
    						break;
    					}
    				}
    			}
    			
    			var com_id = guid();
    			console.log("com_id=",com_id);
    			g_page.coms.insert(categoryIndex+1, {
						c_type:'freepanel-com',
						sorting:false,
						startPos:{
							x:0,
							y:0
						},
						eleSize: {
							width:0,
							height:0
						},
						startOffset:{
							left:0,
							right:0
						},
						containerSize:{
							width:0,
							height:0
						},
						prop:{
							sortable:true,
							gridSize:20,
							alignToGrid:false,
							gridColor:"rgba(255,0,0,0.2)",
							showGrid:true,
							
							styles:{
								showStyle:{
									'display':'block'
								},
								
								isrealheight:false,
								isfillleft:false,
								viewheight:200,//可视高度
								realheight:200,//实际高度
									
								useShadow:false,
								shadow_blur:0,
								shadow_x:0,
								shadow_y:0,
								shadow_color:'#000000',
								
								shadowStyle:{
									'box-shadow':'0px 0px 0px #000000'
								},
								indexStyle:{
									'z-index':10
								},
								transformDeg:0,
								transformStyle:{
									transform:"rotateZ(0deg)",
									'-webkit-transform':"rotateZ(0deg)"
								},
								orgPos:{
									left:0,
									top:0,
									height:0
								},
								posStyle:{
									left:'0px',
									top:'0px'
								},
								positionStyle:{
									position:'relative'
								},
								sizeStyle:{
									height:'200px',
									width:'100%'
								},
								opacity:1,
								alphaStyle:{
									opacity:1,
									filter:"alpha(opacity=100)"
								},
								bkcolorStyle:{
									'background-color':"#ffffff"
								},
								gridStyle:{
									'background-image':'-webkit-linear-gradient(top, transparent 18px, rgba(255,0,0,0.2) 19px, transparent 20px), -webkit-linear-gradient(left, transparent 18px, rgba(255,0,0,0.2) 19px,transparent 20px)',
									'background-size':'20px 20px',
									'background-repeat':'repeat repeat'
								},
								outterStyle:{
									'overflow-y':'auto',
									'overflow-x':'hidden',
									
									'border-width':'1px !important',
									'border-style':'dashed', 
									'border-color':'gray',
									'margin-left':'0px',
									'margin-top':'0px'
								},
								cursorStyle:{
									cursor:'pointer'
								}
							},
							action:{
								type:'none',
								subtype:'none',
								param:""
							},
							curr_sel_id:"a",
							subcoms:[],
							index:0,
							id:com_id,
							mounted_com_id:g_page.coms[categoryIndex].prop.id,
							showControl:false
						}
					});
    			//g_edit_panel.coms.insert(categoryIndex+1, g_page.coms[categoryIndex+1]);
    			g_page.coms[categoryIndex].prop.items[index].attach_com_id = com_id;
    			g_page.coms[categoryIndex].prop.items[index].attach_com_type = val;
    		} else if(val == 'normalpanel-com') {
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_type == "normalpanel-com") {
    				return;
    			}
    			
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_id != "") {//已经存在，则删除该挂载组件
    				var attach_com_id = g_page.coms[categoryIndex].prop.items[index].attach_com_id;
    				for(var i = 0; i < g_page.coms.length; i++) {
    					if(g_page.coms[i].prop.id == attach_com_id) {
    						g_page.coms.splice(i, 1);
    						g_page.curr_com_id = "";
    						g_edit_panel.curr_com_id = "";
    						break;
    					}
    				}
    			}
    			
    			var com_id = guid();
    			g_page.coms.insert(categoryIndex+1, {
    				c_type:val,
    				prop:{
    					currAnimateIndex:0,
    					animates:[],
    					styles:{
    						useShadow:false,
    						shadow_blur:0,
    						shadow_x:0,
    						shadow_y:0,
    						isrealheight:false,
  							isfillleft:false,
  							viewheight:200,//可视高度
  							realheight:200,//实际高度
    						shadow_color:'#000000',
    						animateStyle:{},
    						shadowStyle:{
    							'box-shadow':'0px 0px 0px #000000'
    						},
      					indexStyle:{
      						'z-index':10
      					},
      					transformDeg:0,
    						transformStyle:{
    							transform:"rotateZ(0deg)",
    							'-webkit-transform':"rotateZ(0deg)"
    						},
    						orgPos:{
    							left:0,
    							top:0,
    							height:0
    						},
    						posStyle:{
    							left:'0px',
    							top:'0px'
    						},
    						positionStyle:{
    							position:'relative'
    						},
    						sizeStyle:{
    							width:'100%',
    							'min-height':'60px',
    							height:'200px',
    						},
    						opacity:1,
    						alphaStyle:{
    							opacity:1,
									filter:"alpha(opacity=100)"
    						},
    						outterStyle:{
    							'overflow-y':'auto',
    							'overflow-x':'hidden',
    							'border-width':'1px !important',
    							'border-style':'dashed', 
    							'border-color':'gray',
    							'margin-left':'0px',
    							'margin-top':'0px',
    							'background-color':'#ffffff'
    						},
    						showStyle:{
    							display:'block'
    						}
    					},
    					curr_sel_id:"a",
    					subcoms:[],
    					index:0,
    					id:com_id,
    					mounted_com_id:g_page.coms[categoryIndex].prop.id,
    					showControl:false
    						}
    					});
    			g_page.coms[categoryIndex].prop.items[index].attach_com_id = com_id;
    			g_page.coms[categoryIndex].prop.items[index].attach_com_type = val;
    		} else if(val == "chat-com") {
	    		if(g_page.coms[categoryIndex].prop.items[index].attach_com_type == "chat-com") {
	    			return;
	    		}
    			
    			console.log("attach=",g_page.coms[categoryIndex].prop.items[index].attach_com_id);
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_id != "") {//已经存在，则删除该挂载组件
    				var attach_com_id = g_page.coms[categoryIndex].prop.items[index].attach_com_id;
    				for(var i = 0; i < g_page.coms.length; i++) {
    					if(g_page.coms[i].prop.id == attach_com_id) {
    						g_page.coms.splice(i, 1);
    						//g_edit_panel.coms.splice(i,1);
    						break;
    					}
    				}
    			}
    			var com_id = guid();
    			g_page.coms.insert(categoryIndex+1, {
    				c_type:val,
    				prop:{
    					msgs:[],
    					refresh:false,
    					bindType:"none",
    					chatRoomID:"",
    					showAttachBtn:true,
    					phone_pos:g_page.phone_pos,
    					phone_size:g_page.phone_size,
    					mounted_com_id:g_page.coms[categoryIndex].prop.id,
    					styles:{
    						useShadow:false,
    						shadow_blur:0,
    						shadow_x:0,
    						shadow_y:0,
    						shadow_color:'#000000',
    						showStyle:{
    							'display':'block'
    						},
    						videoColor:"rgb(255, 153, 0)",
    						shadowStyle:{
    							'box-shadow':'0px 0px 0px #000000'
    						},
      					indexStyle:{
      						'z-index':10
      					},
      					myColor:"#fff",
      					otherColor:"#fff",
      					transformDeg:0,
    						transformStyle:{
    							transform:"rotateZ(0deg)",
    							'-webkit-transform':"rotateZ(0deg)"
    						},
    						orgPos:{
    							left:0,
    							top:0,
    							height:0
    						},
    						posStyle:{
    							left:'0px',
    							top:'0px'
    						},
    						positionStyle:{
    							position:'relative'
    						},
    						paddingStyle:{
    							'padding-left':'0px',
    							'padding-right':'0px',
    							'padding-top':'0px',
    							'padding-bottom':'0px'
    						},
    						sizeStyle:{
    							height:'auto',
    							width:'100%'
    						},
    						opacity:1,
    						alphaStyle:{
    							opacity:1,
									filter:"alpha(opacity=100)"
    						},
    						
    						fontStyle:{
    							'font-size':'20px',
    							'font-weight':'bold',
    							'font-style':'normal',//italic
    							'text-decoration':'none',
    							'color':'#ffffff'
    						},
    						marginStyle:{
    							'margin-top':'0px'
    						},
    						bkcolorStyle:{
    							'background-color':'#fff'
    						}
    					},
    					
    					showControl:false,
    					mounted_com_id:g_page.coms[categoryIndex].prop.id,
    					index:0,
    					id:com_id
    				}
    			});
    			//g_edit_panel.coms.insert(categoryIndex+1, g_page.coms[categoryIndex+1]);
    			g_page.coms[categoryIndex].prop.items[index].attach_com_id = com_id;
    			g_page.coms[categoryIndex].prop.items[index].attach_com_type = val;
    		} else if(val == "none") {
    			if(g_page.coms[categoryIndex].prop.items[index].attach_com_id != "") {//已经存在，则删除该挂载组件
    				var attach_com_id = g_page.coms[categoryIndex].prop.items[index].attach_com_id;
    				g_page.coms[categoryIndex].prop.items[index].attach_com_type ="";
    				g_page.coms[categoryIndex].prop.items[index].attach_com_id ="";
    				for(var i = 0; i < g_page.coms.length; i++) {
    					if(g_page.coms[i].prop.id == attach_com_id) {
    						g_page.coms.splice(i, 1);
    						//g_edit_panel.coms.splice(i,1);
    						break;
    					}
    				}
    			}
    		}
    	},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClickCollapseBtn:function(e, index) {
				this.prop.currentIndex = index;
				for(var i = 0;i < this.prop.items.length; i++) {
					if(this.prop.items[i].attach_com_id != "") {
						for(var j = 0; j < g_page.coms.length; j++) {
							if(g_page.coms[j].prop.id == this.prop.items[i].attach_com_id) {
								if(i == index) {
									g_page.coms[j].prop.styles.showStyle['display'] = 'block';
								} else {
									g_page.coms[j].prop.styles.showStyle['display'] = 'none';
								}
							}
						}
					}
				}
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
	var categoryComPanel2 = Vue.component('category-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
				'<font-setting-pane :fontStyle="prop.styles.fontStyle" :prop="prop" :hide_align="true"></font-setting-pane>'+
      	'<div style="clear:both;height:10px"></div>'+
      	'<div>'+
					'<div style="float:left">'+
						'选中颜色：<input type="text" class="active-color-input"/>'+
					'</div>'+
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
						'<div class="my-spinner input-padding-top" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.outterStyle[\'padding-top\'].substr(0,prop.styles.outterStyle[\'padding-top\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
						'<div style="float:left;margin-left:20px;">下</div>'+
						'<div class="my-spinner input-padding-bottom" style="float:left;margin-left:10px;">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.outterStyle[\'padding-bottom\'].substr(0,prop.styles.outterStyle[\'padding-bottom\'].length-2)"></input>'+
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
      '</div>',
    mounted:function() {
    	var that = this;

			$(this.$el).find(".font-color-input").spectrum({
			    color: that.prop.styles.fontStyle['color'],
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
    				that.prop.styles.fontStyle['color'] = val.toHexString();
    			},
    			hide:function(val) {
    				that.prop.styles.fontStyle['color'] = val.toHexString();
    			}
			});
			
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
			    color: that.prop.styles.active_color,
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
    				that.prop.styles.active_color = val.toHexString();
    			},
    			hide:function(val) {
    				that.prop.styles.active_color = val.toHexString();
    			}
			});
			
			$(this.$el).find(".input-font-size").my_spinner({change:function(val) {
				that.prop.styles.fontStyle['font-size'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.fontStyle['font-size'].substr(0, that.prop.styles.fontStyle['font-size'].length-2)});
			
			$(this.$el).find(".input-padding-top").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['padding-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.outterStyle['padding-top'].substr(0, that.prop.styles.outterStyle['padding-top'].length-2)});
			
			$(this.$el).find(".input-padding-bottom").my_spinner({change:function(val) {
				that.prop.styles.outterStyle['padding-bottom'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.outterStyle['padding-bottom'].substr(0, that.prop.styles.outterStyle['padding-bottom'].length-2)});
			
    },
    methods:{
    	onClickBoldBtn:function() {
				var that = this;
				if(that.prop.styles.fontStyle['font-weight'] == 'bold') {
					that.prop.styles.fontStyle['font-weight'] = 'normal';
					$("#ID_editPanel2_"+that.prop.id+" .btn-bold").removeClass('active-btn');
				} else {
					that.prop.styles.fontStyle['font-weight'] = 'bold';
					$("#ID_editPanel2_"+that.prop.id+" .btn-bold").addClass('active-btn');
				}
			},
			onClickItalicBtn:function() {
				var that = this;
				if(that.prop.styles.fontStyle['font-style'] == 'italic') {
					that.prop.styles.fontStyle['font-style'] = 'normal';
					$("#ID_editPanel2_"+that.prop.id+" .btn-italic").removeClass('active-btn');
				} else {
					that.prop.styles.fontStyle['font-style'] = 'italic';
					$("#ID_editPanel2_"+that.prop.id+" .btn-italic").addClass('active-btn');
				}
			},
			onClickUnderlineBtn:function() {
				var that = this;
				if(that.prop.styles.fontStyle['text-decoration'] == 'underline') {
					that.prop.styles.fontStyle['text-decoration'] = 'none';
					$("#ID_editPanel2_"+that.prop.id+" .btn-decoration").removeClass('active-btn');
				} else {
					that.prop.styles.fontStyle['text-decoration'] = 'underline';
					$("#ID_editPanel2_"+that.prop.id+" .btn-decoration").addClass('active-btn');
				}
			}
    }
  });
});