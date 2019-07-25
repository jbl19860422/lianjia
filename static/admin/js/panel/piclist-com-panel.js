$(function() {
/****************图片列表组件--编辑************/
	var picListComPanel = Vue.component('piclist-com-panel', {
		props:['prop','pages','page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>图片列表组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<piclist-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts"></piclist-com-panel1>'+
				'<piclist-com-panel2 :prop="prop"></piclist-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************图片列表组件--编辑1******************/
	var picListComPanel1 = Vue.component('piclist-com-panel1',{
		props:['prop','pages','page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-piclist-item">添加图片</div>'+
      		'<div style="display:none" id="ID_uploadPicListImg"></div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;" class="slide-item" >'+
      			'<div>'+
	      			'<div style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;" @click="onClickCollapseBtn($event,index)">'+
	      				'<div :class="{\'collapse-btn\':true,\'close-btn\':curr_index!=index,\'open-btn\':curr_index==index}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="\'图片\'+index" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($event,index)"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true,hide:curr_index!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<div style="margin-bottom:10px"><span>文字</span>'+
	      				'<input v-model="item.desc" style="margin-left:20px" type="text" :value="item.desc"></input></div>'+
	      				'<span>图片</span>'+
	      				'<img :src="item.image" style="width:100px;height:auto;margin-left:10px;"></img>'+
	      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" :id="\'ID_changeImg\'+index" binded="false" @click="onChangeImg(item)">更换图片</span>'+
	      				
	      				'<click-setting-com :action="item.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
				      	
	      			'</div>'+
	      		'</div>'+
      		'</li>'+
      	'</ul>'+
      '</div>',
    data:function() {
    	return {
    		curr_index:-1
    	};
    },
    mounted:function() {
    	var that = this;
    	that.curr_index = 0;
	    //添加轮播图
	    $(this.$el).find(".add-piclist-item").click(function() {
	    	that.prop.items.push(
	    		{
			      "clickUrl": "#",
			      "desc": "hxrj",
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
    	$(this.$el).find(".upload-btn").each(function(index, item) {
    		$(item).unbind("click");
	    	$(item).click(function() {
	    		that.curr_index = index;
	    		$("#ID_uploadPicListImg").trigger('click');
	    	});
	    });
    },
    methods:{
    	onChangeImg:function(item) {
    		g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'image';
				g_piclistDlg.obj = item;
    	},
			onClickCollapseBtn:function(e,index) {
				if(this.curr_index == index) {
					this.curr_index = -1;
				} else {
					this.curr_index = index;
				}
//				if($(e.target).find(".collapse-btn").hasClass('close-btn')) {
//					$(e.target).find(".collapse-btn").removeClass('close-btn').addClass('open-btn');
//					$(e.target).find(".collapse-btn").parent().siblings(".btn-content").removeClass('hide');
//				} else {
//					$(e.target).find(".collapse-btn").removeClass('open-btn').addClass('close-btn');
//					$(e.target).find(".collapse-btn").parent().siblings(".btn-content").addClass('hide');
//				}
			},
			onClickDel:function(e,index) {
				this.prop.items.splice(index, 1);
				e.stopPropagation();
				e.preventDefault();
			}
		}
	});
	/****************图片列表组件--编辑2*******************/
	var picListComPanel2 = Vue.component('piclist-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div>'+
      		'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
		      '<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
	      		'<div>'+
		      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
		      			'<div>'+
		      				'<div style="float:left">样式</div>'+
		      				'<div style="float:left;margin-left:20px;">'+
			      				'<div :style="[{cursor:\'pointer\',width:\'100px\',position:\'relative\',\'border-style\':\'solid\',\'border-color\':\'#2cb9fe\'},{\'border-width\':prop.styles.mode==\'1\'?\'1px\':\'0px\'}]" @click="onSelMode(1)">'+
			      						'<img src="https://1251027630.cdn.myqcloud.com/1251027630/zhichi_frontend/static/webapp/images/default.png"></img>'+
			      						'<div style="background-color:#000000;opacity:0.4;position:absolute;left:0;right:0;bottom:0;text-align:center;">'+
			      							'<span style="font-size:14px;color:white">描述文字</span>'+
			      						'</div>'+
			      				'</div>'+
		      				'</div>'+
		      				'<div style="float:left;margin-left:40px;">'+
		      					'<div :style="[{cursor:\'pointer\',width:\'100px\',position:\'relative\',\'border-style\':\'solid\',\'border-color\':\'#2cb9fe\'},{\'border-width\':prop.styles.mode==\'2\'?\'1px\':\'0px\'}]" @click="onSelMode(2)">'+
		      						'<img src="https://1251027630.cdn.myqcloud.com/1251027630/zhichi_frontend/static/webapp/images/default.png"></img>'+
		      						'<div style="text-align:center;">'+
		      							'<span style="font-size:14px;">描述文字</span>'+
		      						'</div>'+
		      					'</div>'+
		      				'</div>'+
		      			'</div>'+
		      			'<div style="clear:both"></div>'+
		      			'<div style="float:left;margin-right:10px;" >列数</div>'+
	      				'<div class="my-spinner input-col-spinner" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input class="input-col" input-style="font-size:20px" :value="prop.col" v-model="prop.col"></input>'+
										'<span style="font-size:16px">列</span>'+
									'</div>'+
									'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both"></div>'+
								'<div>'+
									'<div style="padding-top: 10px; font-size: 20px;">'+
										'<div style="float:left">间距</div>'+
										'<div style="float:left;margin-left:10px;">上</div>'+
										'<div class="my-spinner input-margin-top" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" ></input>'+
												'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
										'<div style="float:left;margin-left:20px;">下</div>'+
										'<div class="my-spinner input-margin-bottom" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" ></input>'+
												'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
										'<div style="clear:both;margin-top:20px;"></div>'+
										'<div style="float:left;margin-left:50px;">左</div>'+
										'<div class="my-spinner input-margin-left" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" ></input>'+
													'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
										'<div style="float:left;margin-left:20px;">右</div>'+
										'<div class="my-spinner input-margin-right" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" ></input>'+
													'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;"></div>'+
						'<div style="clear:both;font-size:20px;margin-left:10px;margin-top:10px;height:42px;" class="alpha-setting">'+
								'<div style="margin-right:20px;float:left;">透明度</div>'+
								'<div class="alpha-slider" style="margin-top:10px;width:200px;float:left;"></div>'+
						'</div>'+
						'<div style="clear:both;margin-left:10px;">'+
							'<div style="padding-top: 10px; margin-left: 0px; font-size: 20px;">'+
								'<div style="float:left">背景</div>'+
								'<div style="float:left;margin-left:20px;">'+
									'<input type="text" class="bkcolor-input color-input"/>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;margin-bottom:10px"></div>'+
	    		'</div>'+
      	'</div>'+
      	'<div>'+
      		'<div class="click-setting-title">图片设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_img_setting"></span>'+
		      '</div>'+
		      '<div id="ID_img_setting" class="hide" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;">'+
      			'<div style="clear:both;height:10px;margin-bottom:20p"></div>'+
	      			'<div style="margin-top:10px;margin-left:10px;">'+
	      				'<span style="font-size:20px;float:left;">高度：</span>'+
	      				'<select @change="onChangeHeightStyle($event)" style="height:40px;border-radius:5px;float:left;">'+
	      					'<option value="fixed_width" :selected="prop.styles.itemHeightStyle.height!=\'auto\'">固定高度</option>'+
	      					'<option value="auto" :selected="prop.styles.itemHeightStyle.height==\'auto\'">适应宽度</option>'+
	      				'</select>'+
	      				'<div style="float:left" v-show="prop.styles.itemHeightStyle.height!=\'auto\'">'+
		      				'<div style="float:left;margin-left:20px" >高度值：</div>'+
		      				'<div class="my-spinner input-item-height" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" ></input>'+
											'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
		      		'</div>'+
		      		'<div style="clear:both;margin-top:20px;height:20px;"></div>'+
		      		'<div>'+
		      			'<div style="float:left;margin-left:10px;">间距</div>'+
								'<div style="float:left;margin-left:10px;">纵向间距</div>'+
								'<div class="my-spinner item-margin-top" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.itemMarginStyle[\'margin-top\'].substr(0, prop.styles.itemMarginStyle[\'margin-top\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="float:left;margin-left:10px;">横向间距</div>'+
								'<div class="my-spinner item-margin-left" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.itemMarginStyle[\'margin-left\'].substr(0, prop.styles.itemMarginStyle[\'margin-left\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;height:10px"></div>'+
								'<div style="float:left;margin-left:10px;">圆角</div>'+
								'<div class="my-spinner item-border-radius" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.itemBorderStyle[\'border-radius\'].substr(0, prop.styles.itemBorderStyle[\'border-radius\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;margin-bottom:20px;"></div>'+
							'</div>'+
	      		'</div>'+
	      	'<div style="clear:both;margin-bottom:10px;"></div>'+
      	'</div>'+
      	'<div>'+
      		'<div class="click-setting-title">文字设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_text_setting"></span>'+
		      '</div>'+
		      '<div id="ID_text_setting" class="hide"style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;padding-top:10px;padding-left:10px;">'+
			    	'<font-setting-pane :prop="prop" :fontStyle="prop.styles.itemFontStyle" :alignStyle="prop.styles.innerAlignStyle"></font-setting-pane>'+
			    	'<div style="clear:both;margin-bottom:20px;"></div>'+
					'</div>'+
      	'</div>'+
    	'</div>'+
   	'</div>'+
   '</div>',
    methods:{
    	onSelMode:function(mode) {
    		this.prop.styles.mode = mode;
    	},
    	onClickCollapseBtn:function(e) {
    		if($(e.target).hasClass('close-btn')) {
    			$(e.target).removeClass('close-btn').addClass('open-btn');
    			$($(e.target).attr("href")).removeClass("hide");
    		} else {
    			$(e.target).removeClass('open-btn').addClass('close-btn');
    			$($(e.target).attr("href")).addClass("hide");
    		}
    	},
    	onChangeHeightStyle:function(e) {
    		if($(e.target).val() == "auto") {
    			this.prop.styles.itemHeightStyle.height = "auto";
    		} else {
    			this.prop.styles.itemHeightStyle.height = $(this.$el).find('.input-item-height').val()+"px";
    		}
    	}
    },
    mounted:function() {
    	var that = this;
    	$('.input-col-spinner').my_spinner({change:function(val) {
    		that.prop.col = val;
			},defaultValue:that.prop.col});
			
			$('.item-border-radius').my_spinner({change:function(val) {
    		that.prop.styles.itemBorderStyle['border-radius'] = val + "px";
			},maxValue:1000,defaultValue:that.prop.styles.itemBorderStyle['border-radius'].substr(0,that.prop.styles.itemBorderStyle['border-radius'].length-2)});
			
			$('.input-item-height').my_spinner({change:function(val) {
    		that.prop.styles.itemHeightStyle.height = val + "px";
			},maxValue:1000,defaultValue:that.prop.styles.itemHeightStyle.height=="auto"?30:that.prop.styles.itemHeightStyle.height.substr(0,that.prop.styles.itemHeightStyle.height.length-2)});
			

			$('.input-margin-top').my_spinner({change:function(val) {
    		that.prop.styles.marginStyle['margin-top'] = val + "px";
			},defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)});
			
			$('.input-margin-left').my_spinner({change:function(val) {
    		that.prop.styles.marginStyle['margin-left'] = val + "px";
			},defaultValue:that.prop.styles.marginStyle['margin-left'].substr(0,that.prop.styles.marginStyle['margin-left'].length-2)});
			
			$('.input-margin-right').my_spinner({change:function(val) {
    		that.prop.styles.marginStyle['margin-right'] = val + "px";
			},defaultValue:that.prop.styles.marginStyle['margin-right'].substr(0,that.prop.styles.marginStyle['margin-right'].length-2)});
			
			$('.input-margin-bottom').my_spinner({change:function(val) {
    		that.prop.styles.marginStyle['margin-bottom'] = val + "px";
			},defaultValue:that.prop.styles.marginStyle['margin-bottom'].substr(0,that.prop.styles.marginStyle['margin-bottom'].length-2)});
			
			$('.item-margin-left').my_spinner({change:function(val) {
    		that.prop.styles.itemMarginStyle['margin-left'] = val + "px";
			},defaultValue:that.prop.styles.itemMarginStyle['margin-left'].substr(0,that.prop.styles.itemMarginStyle['margin-left'].length-2)});
			
			$('.item-margin-top').my_spinner({change:function(val) {
    		that.prop.styles.itemMarginStyle['margin-top'] = val + "px";
			},defaultValue:that.prop.styles.itemMarginStyle['margin-top'].substr(0,that.prop.styles.itemMarginStyle['margin-top'].length-2)});
			
			//透明图控制
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
    	//背景色
    	$(this.$el).find(".bkcolor-input").spectrum({
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
		        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
		        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
		    ],
		    chooseText: "确定",
  			cancelText: "取消",
  			change:function(val) {
  				that.prop.styles.bkcolorStyle['background-color'] = "rgba("+val._r+","+val._g+","+val._b+","+val._a+")";;
  			},
  			hide:function(val) {
  				that.prop.styles.bkcolorStyle['background-color'] = "rgba("+val._r+","+val._g+","+val._b+","+val._a+")";;
  			}
			});
    }
  });
});