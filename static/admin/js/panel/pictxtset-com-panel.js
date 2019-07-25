$(function() {
/****************图文集组件--编辑************/
	var pictxtSetComPanel = Vue.component('pictxtset-com-panel', {
		props:['prop','pages','page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>图文集组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<pictxtset-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts"></pictxtset-com-panel1>'+
				'<pictxtset-com-panel2 :prop="prop"></pictxtset-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************图文集组件--编辑1******************/
	var pictxtsetComPanel1 = Vue.component('pictxtset-com-panel1',{
		props:['prop','pages','page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-pictxt-set-item">添加一行</div>'+
      		'<div style="display:none" id="ID_uploadPicTxtSetImg"></div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;"   class="slide-item">'+
      			'<div>'+
	      			'<div @click="onClickCollapseBtn($event,index)" style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;">'+
	      				'<div :class="{\'collapse-btn\':true,\'close-btn\':curr_index!=index,\'open-btn\':curr_index==index}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="\'第\'+index+\'行\'" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel(index)"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true, hide:curr_index!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<div style="margin-bottom:10px"><span>标题</span>'+
	      				'<input v-model="item.title" style="margin-left:20px" type="text" :value="item.title"></input></div>'+
	      				'<div style="margin-bottom:10px"><span>描述</span>'+
	      				'<input v-model="item.desc" style="margin-left:20px" type="text" :value="item.desc"></input></div>'+
	      				'<span>图片</span>'+
	      				'<img :src="item.image" style="width:100px;height:auto;margin-left:10px;"></img>'+
	      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" @click="onChangeImg(item)">更换图片</span>'+
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
	    //添加一行
	    $(this.$el).find(".add-pictxt-set-item").click(function() {
	    	that.prop.items.push(
	    		{
	    			'title':'标题',
			      "desc": "图文简介",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png",
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
	    		$("#ID_uploadPicTxtSetImg").trigger('click');
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
			},
			onClickDel:function(index) {
				this.prop.items.splice(index, 1);
			}
		}
	});
	/****************图文集组件--编辑2*******************/
	var pictxtsetComPanel2 = Vue.component('pictxtset-com-panel2',{
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
			      				'<div :style="[{cursor:\'pointer\',width:\'100px\',\'height\':\'60px\',position:\'relative\',\'border-style\':\'solid\',\'border-color\':\'#2cb9fe\'},{\'border-width\':prop.styles.mode==\'1\'?\'1px\':\'0px\'}]" @click="onSelMode(1)">'+
			      						'<ul>'+
			      							'<li style="border:1px solid #666;width:100%;height:30px;line-height:30px;">'+
			      								'<div style="width:26px;height:26px;display:inline-block;background-color:#aaa"></div>'+
			      							'</li>'+
			      							'<li style="border:1px solid #666;width:100%;height:30px;">'+
			      								'<div style="width:26px;height:26px;display:inline-block;background-color:#aaa"></div>'+
			      							'</li>'+
			      						'</ul>'+
			      				'</div>'+
		      				'</div>'+
		      				'<div style="float:left;margin-left:40px;">'+
		      					'<div :style="[{cursor:\'pointer\',width:\'100px\',\'height\':\'60px\',position:\'relative\',\'border-style\':\'solid\',\'border-color\':\'#2cb9fe\'},{\'border-width\':prop.styles.mode==\'2\'?\'1px\':\'0px\'}]" @click="onSelMode(2)">'+
		      						'<div style="width:100%;height:100%;border:1px solid #666;padding:3px;">'+
		      							'<div style="width:90px;height:50px;background-color:#aaa"></div>'+
		      						'</div>'+
		      					'</div>'+
		      				'</div>'+
		      			'</div>'+
		      			'<div style="clear:both;margin-top:20px;"></div>'+
		      			'<div style="float:left;margin-right:10px;" >上间距</div>'+
	      				'<div class="my-spinner input-margin-top-spinner" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input class="input-margin-top" input-style="font-size:20px"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both"></div>'+
								'<div style="clear:both;">'+
									'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
										'<div style="float:left">背景</div>'+
										'<div style="float:left;margin-left:20px;">'+
											'<input type="text" class="bkcolor-input color-input"/>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both"></div>'+
								'<div style="clear:both;">'+
									'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
										'<div style="float:left">行背景</div>'+
										'<div style="float:left;margin-left:20px;">'+
											'<input type="text" class="item-bkcolor-input color-input"/>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;"></div>'+
								'<div style="clear:both;font-size:20px;margin-top:10px;height:42px;" class="alpha-setting">'+
									'<div style="margin-right:20px;float:left;">透明度</div>'+
									'<div class="alpha-slider" style="margin-top:10px;width:200px;float:left;"></div>'+
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
      			'<div>'+
							'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
								'<div style="float:left">每行</div>'+
								'<div style="float:left;margin-left:10px;">高度</div>'+
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
								'<div style="float:left;margin-left:20px;">间距</div>'+
								'<div class="my-spinner input-item-margin-bottom" style="float:left;margin-left:10px;">'+
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
								'<div style="float:left;">图片尺寸</div>'+
								'<div style="float:left;margin-left:20px;">宽度</div>'+
								'<div class="my-spinner input-image-width" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" ></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;height:10px;"></div>'+
								'<span style="font-size:20px;float:left;">高度：</span>'+
	      				'<select @change="onChangeHeightStyle($event)" style="height:40px;border-radius:5px;float:left;">'+
	      					'<option value="fixed_width" :selected="prop.styles.itemImageSizeStyle.height!=\'auto\'">固定高度</option>'+
	      					'<option value="auto" :selected="prop.styles.itemImageSizeStyle.height==\'auto\'">适应宽度</option>'+
	      				'</select>'+
	      				'<div v-show="prop.styles.itemImageSizeStyle.height!=\'auto\'" style="float:left;margin-left:20px">高度值：</div>'+
	      				'<div  v-show="prop.styles.itemImageSizeStyle.height!=\'auto\'" class="my-spinner input-image-height" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;height:10px;"></div>'+
								'<span style="font-size:20px;float:left;">距离左边</span>'+
								'<div class="my-spinner img-margin-left" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
	      	'<div style="clear:both;margin-bottom:10px;"></div>'+
      	'</div>'+
      	'<div>'+
      		'<div class="click-setting-title">文字设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_text_setting"></span>'+
		      '</div>'+
		      '<div id="ID_text_setting" class="hide" style="padding-top:10px;padding-left:10px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;">'+
		      	'<div>标题文字</div>'+
						'<font-setting-pane :prop="prop" :fontStyle="prop.styles.itemTitleStyle" :alignStyle="prop.styles.itemTitleStyle"></font-setting-pane>'+
						'<div>描述文字</div>'+
						'<font-setting-pane :prop="prop" :fontStyle="prop.styles.itemDescStyle" :alignStyle="prop.styles.itemDescStyle"></font-setting-pane>'+
						'<div style="clear:both;margin-bottom:10px;"></div>'+
					'</div>'+
      	'</div>'+
    	'</div>'+
   	'</div>'+
   '</div>',
    methods:{
    	onSelMode:function(mode) {
    		this.prop.styles.mode = mode;
    		if(mode==2) {
    			this.prop.styles.itemImageSizeStyle.width="100%";
    		} else {
    			this.prop.styles.itemImageSizeStyle.width="60px";
    		}
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
    			this.prop.styles.itemImageSizeStyle.height = "auto";
    		} else {
    			this.prop.styles.itemImageSizeStyle.height = $(this.$el).find('.input-image-height').val()+"px";
    		}
    	},
    	onClickBoldBtn:function() {
				var that = this;
				if(that.prop.styles.itemTitleStyle['font-weight'] == 'bold') {
					that.prop.styles.itemTitleStyle['font-weight'] = 'normal';
				} else {
					that.prop.styles.itemTitleStyle['font-weight'] = 'bold';
				}
			},
			onClickItalicBtn:function() {
				var that = this;
				if(that.prop.styles.itemTitleStyle['font-style'] == 'italic') {
					that.prop.styles.itemTitleStyle['font-style'] = 'normal';
				} else {
					that.prop.styles.itemTitleStyle['font-style'] = 'italic';
				}
			},
			onClickUnderlineBtn:function() {
				var that = this;
				if(that.prop.styles.itemTitleStyle['text-decoration'] == 'underline') {
					that.prop.styles.itemTitleStyle['text-decoration'] = 'none';
				} else {
					that.prop.styles.itemTitleStyle['text-decoration'] = 'underline';
				}
			},
			onClickDescBoldBtn:function() {
				var that = this;
				if(that.prop.styles.itemDescStyle['font-weight'] == 'bold') {
					that.prop.styles.itemDescStyle['font-weight'] = 'normal';
				} else {
					that.prop.styles.itemDescStyle['font-weight'] = 'bold';
				}
			},
			onClickDescItalicBtn:function() {
				var that = this;
				if(that.prop.styles.itemDescStyle['font-style'] == 'italic') {
					that.prop.styles.itemDescStyle['font-style'] = 'normal';
				} else {
					that.prop.styles.itemDescStyle['font-style'] = 'italic';
				}
			},
			onClickDescUnderlineBtn:function() {
				var that = this;
				if(that.prop.styles.itemDescStyle['text-decoration'] == 'underline') {
					that.prop.styles.itemDescStyle['text-decoration'] = 'none';
				} else {
					that.prop.styles.itemDescStyle['text-decoration'] = 'underline';
				}
			},
			onClickTitleAlignBtn:function() {
				var that = this;
				var alignList = $(".edit-title-text .align-list");
				if(alignList.hasClass("hide")) {
					alignList.removeClass("hide");
				} else {
					alignList.addClass("hide");
				}
			},
			onClickDescAlignBtn:function() {
				var that = this;
				var alignList = $(".edit-desc-text .align-list");
				if(alignList.hasClass("hide")) {
					alignList.removeClass("hide");
				} else {
					alignList.addClass("hide");
				}
			}
    },
    mounted:function() {
    	var that = this;
    	console.log(that.prop);
    	$('.input-col-spinner').my_spinner({change:function(val) {
    		that.prop.col = val;
			},defaultValue:that.prop.col});
			
			$(this.$el).find('.input-margin-top-spinner').my_spinner({change:function(val) {
    		that.prop.styles.marginStyle['margin-top'] = val + "px";
			},defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)});
			
			$(this.$el).find('.input-item-height').my_spinner({change:function(val) {
    		that.prop.styles.itemHeightStyle['line-height'] = val + "px";
			},maxValue:1000,defaultValue:that.prop.styles.itemHeightStyle['line-height'].substr(0,that.prop.styles.itemHeightStyle['line-height'].length-2)});
			
			$(this.$el).find('.input-item-margin-bottom').my_spinner({change:function(val) {
    		that.prop.styles.itemMarginStyle['margin-top'] = val + "px";
			},defaultValue:that.prop.styles.itemMarginStyle['margin-top'].substr(0,that.prop.styles.itemMarginStyle['margin-top'].length-2)});
			
			$(this.$el).find('.input-image-width').my_spinner({change:function(val) {
    		that.prop.styles.itemImageSizeStyle['width'] = val + "px";
			},maxValue:1000, defaultValue:that.prop.styles.itemImageSizeStyle['width'].substr(0,that.prop.styles.itemImageSizeStyle['width'].length-2)});
			
			$('.input-image-height').my_spinner({change:function(val) {
    		that.prop.styles.itemImageSizeStyle.height = val + "px";
			},defaultValue:that.prop.styles.itemImageSizeStyle.height=="auto"?30:that.prop.styles.itemImageSizeStyle.height.substr(0,that.prop.styles.itemImageSizeStyle.height.length-2)});
			
			$(this.$el).find('.img-margin-left').my_spinner({change:function(val) {
    		that.prop.styles.itemImageMarginStyle['margin-left'] = val + "px";
			},maxValue:1000, defaultValue:that.prop.styles.itemImageMarginStyle['margin-left'].substr(0,that.prop.styles.itemImageMarginStyle['margin-left'].length-2)});
			
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
  				if(val) {
  					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.bkcolorStyle['background-color'] = 'transparent';
  				}
  			}
			});
				
			$(this.$el).find(".item-bkcolor-input").spectrum({
		    color: that.prop.styles.itemBkColorStyle['background-color'],
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
  				if(val) {
  					that.prop.styles.itemBkColorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.itemBkColorStyle['background-color'] = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.itemBkColorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.itemBkColorStyle['background-color'] = 'transparent';
  				}
  			}
			});
				
			//标题文字编辑
			//文字颜色
			$(this.$el).find(".edit-title-text .font-color-input").spectrum({
		    color: that.prop.styles.itemTitleStyle['color'],
		    float:true,
		    showInput:true,
		    allowEmpty:true,
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
  				that.prop.styles.itemTitleStyle['color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.itemTitleStyle['color'] = val.toHexString();
  			}
			});
			//文字大小
			$(this.$el).find('.edit-title-text .input-font-size').my_spinner({change:function(val) {
				that.prop.styles.itemTitleStyle['font-size'] = val+'px';
			},defaultValue:that.prop.styles.itemTitleStyle['font-size'].substr(0,that.prop.styles.itemTitleStyle['font-size'].length-2)});
			
			//文字颜色
			$(this.$el).find(".edit-desc-text .font-color-input").spectrum({
		    color: that.prop.styles.itemDescStyle['color'],
		    float:true,
		    showInput:true,
		    allowEmpty:true,
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
  				that.prop.styles.itemDescStyle['color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.itemDescStyle['color'] = val.toHexString();
  			}
			});
			//文字大小
			$(this.$el).find('.edit-desc-text .input-font-size').my_spinner({change:function(val) {
				that.prop.styles.itemDescStyle['font-size'] = val+'px';
			},defaultValue:that.prop.styles.itemDescStyle['font-size'].substr(0,that.prop.styles.itemDescStyle['font-size'].length-2)});
		
			//对齐方式
			$(this.$el).find(".edit-title-text .align-select span").attr('class', '');
			if(that.prop.styles.itemTitleStyle['text-align'] == 'left') {
				$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-left select-type');
			} else if(that.prop.styles.itemTitleStyle['text-align'] == 'right') {
				$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-right select-type');
			} else if(that.prop.styles.itemTitleStyle['text-align'] == 'center') {
				$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-center select-type');
			} 
							
			$(this.$el).find(".edit-title-text .align-list li").click(function() {
				if($(this).children('span').hasClass('icon-paragraph-left')) {
					that.prop.styles.itemTitleStyle['text-align'] = 'left';
					$(this.$el).find(".edit-title-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-left select-type');
				} else if($(this).children('span').hasClass('icon-paragraph-right')) {
					that.prop.styles.itemTitleStyle['text-align'] = 'right';
					$(this.$el).find(".edit-title-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-right select-type');
				} else if($(this).children('span').hasClass('icon-paragraph-center')) {
					that.prop.styles.itemTitleStyle['text-align'] = 'center';
					$(this.$el).find(".edit-title-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-title-text .align-select span").addClass('icon icon-paragraph-center select-type');
				} 
				$(".edit-title-text .align-list").addClass("hide");
			});
			
			$(this.$el).find(".edit-desc-text .align-select span").attr('class', '');
			if(that.prop.styles.itemDescStyle['text-align'] == 'left') {
				$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-left select-type');
			} else if(that.prop.styles.itemDescStyle['text-align'] == 'right') {
				$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-right select-type');
			} else if(that.prop.styles.itemDescStyle['text-align'] == 'center') {
				$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-center select-type');
			} 
//					
			$(this.$el).find(".edit-desc-text .align-list li").click(function() {
				if($(this).children('span').hasClass('icon-paragraph-left')) {
					that.prop.styles.itemDescStyle['text-align'] = 'left';
					$(this.$el).find(".edit-desc-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-left select-type');
				} else if($(this).children('span').hasClass('icon-paragraph-right')) {
					that.prop.styles.itemDescStyle['text-align'] = 'right';
					$(this.$el).find(".edit-desc-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-right select-type');
				} else if($(this).children('span').hasClass('icon-paragraph-center')) {
					that.prop.styles.itemDescStyle['text-align'] = 'center';
					$(this.$el).find(".edit-desc-text .align-select span").attr('class', '');
					$(this.$el).find(".edit-desc-text .align-select span").addClass('icon icon-paragraph-center select-type');
				} 
				$(".edit-desc-text .align-list").addClass("hide");
			});
	
    }
  });
});