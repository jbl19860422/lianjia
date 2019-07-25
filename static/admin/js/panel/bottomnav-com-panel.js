$(function() {
/****************底部导航组件--编辑************/
	var bottomnavComPanel = Vue.component('bottomnav-com-panel', {
		props:['prop','pages','page_groups'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>底部导航组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<bottomnav-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups"></bottomnav-com-panel1>'+
				'<bottomnav-com-panel2 :prop="prop"></bottomnav-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************底部导航组件--编辑1******************/
	var bottomnavComPanel1 = Vue.component('bottomnav-com-panel1',{
		props:['prop','pages','page_groups'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-item" @click="addItem()">添加</div>'+
      		'<div style="display:none" id="ID_uploadImg"></div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;" class="slide-item">'+
      			'<div>'+
	      			'<div style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;" @click="onClickCollapseBtn($event, index)">'+
	      				'<div :class="{\'collapse-btn\':true,\'close-btn\':prop.currentIndex!=index,\'open-btn\':prop.currentIndex==index}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="\'标签\'+index" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($event,index)"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true,\'hide\':prop.currentIndex!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<div style="margin-bottom:10px"><span>文字</span>'+
	      				'<input v-model="item.text" style="margin-left:20px" type="text" :value="item.text"></input></div>'+
	      				'<span>原始图片</span>'+
	      				'<img :src="item.imgSrc" style="width:100px;height:100px;margin-left:10px;"></img>'+
	      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" @click="onChangeImg(item)" binded="false">更换图片</span>'+
	      				'<div style="width:100%;height:10px"></div>'+
	      				'<span>按下图片</span>'+
	      				'<img :src="item.hotImgSrc" style="width:100px;height:100px;margin-left:10px;"></img>'+
	      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;"  class="upload-hotimg-btn" @click="onChangeHotImg(item)">更换图片</span>'+
	      				'<div class="click-setting-wrap" style="width:100%;position:relative;padding-top:20px;">'+
									'<div style="margin-top:10px;margin-left:10px;font-size:20px">链接至：'+
			      				'<select class="setting-opt" @change="onPageSettingChange(item, $event)">'+
				    					'<option value="pre-page" :selected="item.action.subtype==\'pre-page\'?\'selected\':\'\'">后退</option>'+
				    					'<option value="custom-link" :selected="item.action.subtype==\'custom-link\'?\'selected\':\'\'">自定义链接</option>'+
				    					'<optgroup :label="page_group.group_name" v-for="page_group in page_groups">'+
				    						'<option v-for="page in pages" v-if="page.group_id==page_group.group_id" :value="page.page_id" v-html="page.page_name" :selected="item.action.subtype==\'my-page\'&&item.action.param==page.page_id?\'selected\':\'\'"></option>'+
				    					'</optgroup>'+
										'</select>'+
										'<div v-if="item.action.type==\'page\'&&item.action.subtype==\'custom-link\'" style="margin-top:10px">链接地址：<input type="text" style="border-radius:4px !important;height:40px;" v-model="item.action.param" ></input></div>'+
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
    },
    updated:function() {
    	var that = this;
    	$(this.$el).find(".upload-img-btn").each(function(index, item) {
    		$(item).unbind("click");
	    	$(item).click(function() {
	    		that.curr_index = index;
	    		that.isHot = false;
	    		$("#ID_uploadImg").trigger('click');
	    	});
	    });
	    
	    $(this.$el).find(".upload-hotimg-btn").each(function(index, item) {
    		$(item).unbind("click");
	    	$(item).click(function() {
	    		that.curr_index = index;
	    		that.isHot = true;
	    		$("#ID_uploadImg").trigger('click');
	    	});
	    });
    },
    methods:{
    	onPageSettingChange:function(item,e) {
    		var action = item.action;
				val = $(e.target).val();
				if(val == "pre-page") {
					action.subtype = "pre-page";
					action.param = "";
				} else if(val == "custom-link") {
					action.subtype = "custom-link";
					action.param = "";
				} else {
					action.subtype = "my-page";
					action.param = val;
				}
			},
			addItem:function() {
				this.prop.items.push({
			      imgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      hotImgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      text:'标签',
			      link:'',
			      
			      action:{//点击动作
  						type:'page',
  						subtype:'none',
  						param:""
  					}
			    });
			},
			onChangeImg:function(item) {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'imgSrc';
				g_piclistDlg.obj = item;
			},
			onChangeHotImg:function(item) {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'hotImgSrc';
				g_piclistDlg.obj = item;
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClickCollapseBtn:function(e,index) {
				this.prop.currentIndex = index;
			},
			onClickDel:function(e,index) {
				this.prop.items.splice(index, 1);
				e.stopPropagation();
			}
		}
	});
	
	/****************底部导航组件--编辑2*******************/
	var bottomnavComPanel2 = Vue.component('bottomnav-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div>'+
      		'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
		      '<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
	      		'<div>'+
		      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
		      			'<div>'+
		      				'<div style="float:left">背景</div>'+
		      				'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="bkcolor-input color-input"/>'+
									'</div>'+
		      			'</div>'+
		      			'<div style="clear:both"></div>'+
							'</div>'+
						'</div>'+
	    		'</div>'+
      	'</div>'+
      	'<div>'+
      		'<div class="click-setting-title">图片设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_img_setting"></span>'+
		      '</div>'+
		      '<div id="ID_img_setting" class="hide" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;">'+
      			'<div style="clear:both;height:10px;margin-bottom:20p"></div>'+
	      			'<div style="margin-top:10px;margin-left:20px;">'+
	      				'<div style="float:left;" >尺寸</div>'+
	      				'<div class="my-spinner input-img-size" style="float:left;margin-left:10px;">'+
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
		      		'<div style="clear:both;margin-top:20px;height:20px;"></div>'+
		      		'<div>'+
		      			'<div style="float:left;margin-left:20px;">间距</div>'+
								'<div style="float:left;margin-left:10px;">上</div>'+
								'<div class="my-spinner input-padding-top" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.paddingStyle[\'padding-top\'].substr(0, prop.styles.paddingStyle[\'padding-top\'].length-2)"></input>'+
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
		      '<div id="ID_text_setting" class="hide"  style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;padding-top:10px;padding-left:10px;">'+
			    	'<font-setting-pane :prop="prop" :fontStyle="prop.styles.fontStyle" :hide_align="true"></font-setting-pane>'+
						'<div style="clear:both;margin-bottom:10px;"></div>'+
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
    	},
    	onClickBoldBtn:function() {
				var that = this;
				if(that.prop.styles.itemFontStyle['font-weight'] == 'bold') {
					that.prop.styles.itemFontStyle['font-weight'] = 'normal';
				} else {
					that.prop.styles.itemFontStyle['font-weight'] = 'bold';
				}
			},
			onClickItalicBtn:function() {
				var that = this;
				if(that.prop.styles.itemFontStyle['font-style'] == 'italic') {
					that.prop.styles.itemFontStyle['font-style'] = 'normal';
				} else {
					that.prop.styles.itemFontStyle['font-style'] = 'italic';
				}
			},
			onClickUnderlineBtn:function() {
				var that = this;
				if(that.prop.styles.itemFontStyle['text-decoration'] == 'underline') {
					that.prop.styles.itemFontStyle['text-decoration'] = 'none';
				} else {
					that.prop.styles.itemFontStyle['text-decoration'] = 'underline';
				}
			},
			onClickAlignBtn:function() {
				var that = this;
				var alignList = $("#ID_editPanel2_"+that.prop.id+" .align-list");
				if(alignList.hasClass("hide")) {
					alignList.removeClass("hide");
				} else {
					alignList.addClass("hide");
				}
			}
    },
    mounted:function() {
    	var that = this;
    	$('.input-col-spinner').my_spinner({change:function(val) {
    		that.prop.col = val;
			},defaultValue:that.prop.col});
			
			$('.input-img-size').my_spinner({change:function(val) {
    		that.prop.styles.imgSizeStyle.height = val + "px";
    		that.prop.styles.imgSizeStyle.width = val + "px";
			},defaultValue:that.prop.styles.imgSizeStyle.height.substr(0,that.prop.styles.imgSizeStyle.height.length-2)});
			

			$('.input-padding-top').my_spinner({change:function(val) {
    		that.prop.styles.paddingStyle['padding-top'] = val + "px";
			},defaultValue:that.prop.styles.paddingStyle['padding-top'].substr(0,that.prop.styles.paddingStyle['padding-top'].length-2)});
			
			$('.input-padding-bottom').my_spinner({change:function(val) {
    		that.prop.styles.paddingStyle['padding-bottom'] = val + "px";
			},defaultValue:that.prop.styles.paddingStyle['padding-bottom'].substr(0,that.prop.styles.paddingStyle['padding-bottom'].length-2)});
		
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
  				that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
  			}
			});
			//文字颜色
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
		        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
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
			
			$(this.$el).find(".selected-color-input").spectrum({
		    color: that.prop.styles.hotTextColor['color'],
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
  				that.prop.styles.hotTextColor['color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.hotTextColor['color'] = val.toHexString();
  			}
			});

			if(that.prop.styles.fontStyle['font-weight'] == 'bold') {
				$("#ID_editPanel2_"+that.prop.id+" .btn-bold").addClass('active-btn');
			}
			
			if(that.prop.styles.fontStyle['font-style'] == 'italic') {
				$("#ID_editPanel2_"+that.prop.id+" .btn-italic").addClass('active-btn');
			}
			
			if(that.prop.styles.fontStyle['text-decoration'] == 'underline') {
				$("#ID_editPanel2_"+that.prop.id+" .btn-decoration").addClass('active-btn');
			}
			
			$(this.$el).find('.input-font-size').my_spinner({change:function(val) {
				that.prop.styles.fontStyle['font-size'] = val+'px';
			},defaultValue:that.prop.styles.fontStyle['font-size'].substr(0,that.prop.styles.fontStyle['font-size'].length-2)});
    }
  });
});