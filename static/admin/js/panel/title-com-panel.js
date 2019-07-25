$(function() {
/**************标题组件--编辑************/
	var titleComPanel = Vue.component('title-com-panel', {
		props:['prop','pages','page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>标题组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<title-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts"></title-com-panel1>'+
				'<title-com-panel2 :prop="prop"></title-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/**************标题组件--编辑1*****************/
	 var titleComPanel1 = Vue.component('title-com-panel1',{
		props:['prop', 'pages','page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
				'<font-setting-pane :prop="prop" :fontStyle="prop.styles.fontStyle" :alignStyle="prop.styles.alignStyle"></font-setting-pane>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'按钮文字：<input type="text" style="height:30px;border-radius:5px;font-size:20px" v-model="prop.text"></input>'+
      	'</div>'+
      	'<click-setting-com :action="prop.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    }
	});
	/**************标题组件--编辑2*****************/
	var titleComPanel2 = Vue.component('title-com-panel2',{
		props:['prop'],
		template:
		'<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
			'<div>'+
				'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		  	'</div>'+
			  '<div id="ID_com_setting" style="font-size:20px;color:#666;padding-top:20px;padding-left:10px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;border:1px solid #aaaaaa">'+
			    '<div>'+
						'<div style="float:left;margin-left:0px;margin-right:20px;">行高</div>'+
						'<div class="my-spinner input-btn-height" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.sizeStyle[\'line-height\'].substr(0,prop.styles.sizeStyle[\'line-height\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;height:20px;margin-top:10px;"></div>'+
					'</div>'+
					
					'<div>'+
		    		'<div style="float:left">间距</div>'+
						'<div style="float:left;margin-left:20px;margin-right:10px;">上</div>'+
						'<div class="my-spinner input-margin-top" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-top\'].substr(0,prop.styles.marginStyle[\'margin-top\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;height:20px"></div>'+
					'</div>'+
					
					'<div style="margin-top:10px">'+
						'<div style="float:left">位置</div>'+
						'<div style="float:left;margin-left:20px" class="position-btns">'+
							'<span align="left" :class="{\'active\':prop.styles.posStyle[\'text-align\']==\'left\'}">置左</span>'+
							'<span align="center" :class="{\'active\':prop.styles.posStyle[\'text-align\']==\'center\'}">居中</span>'+
							'<span align="right" :class="{\'active\':prop.styles.posStyle[\'text-align\']==\'right\'}">置右</span>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;margin-top:30px;margin-bottom:20px;height:40px;">'+
						'<div style="padding-top: 20px;; font-size: 20px;">'+
							'<div style="float:left;font-size:20px;">背景</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="bkcolor-input color-input"/>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;margin-top:10px;margin-bottom:20px;height:40px;">'+
						'<div style="padding-top: 10px;; font-size: 20px;">'+
							'<div style="float:left;font-size:20px;">标记颜色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="mark-color-input color-input"/>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
			  '</div>'+
			  '<div class="click-setting-title">边框设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_border_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_border_setting" class="hide" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div>'+
			      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
			      			'<div style="float:left">样式</div>'+
			      			'<select @change="onChangeBorderStyle($event)" style="height:40px;margin-left:10px;border-radius:6px;float:left;">'+
			      				'<option value="none" :selected="prop.styles.borderStyle[\'border-style\']==\'none\'?\'selected\':\'\'">无边框</option>'+
			      				'<option value="solid" :selected="prop.styles.borderStyle[\'border-style\']==\'solid\'?\'selected\':\'\'">实线</option>'+
			      				'<option value="dotted" :selected="prop.styles.borderStyle[\'border-style\']==\'dotted\'?\'selected\':\'\'">点线</option>'+
			      				'<option value="dashed" :selected="prop.styles.borderStyle[\'border-style\']==\'dashed\'?\'selected\':\'\'">虚线</option>'+
			      			'</select>'+
			      			'<div style="float:left;margin-left:20px;">粗细</div>'+
			      			'<div class="my-spinner input-border-width" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.borderStyle[\'border-width\'].substr(0,prop.styles.borderStyle[\'border-width\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both;margin-top: 10px; margin-left: 10px; font-size: 20px;"></div>'+
								'<div style="clear:both;margin-top: 10px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">边框颜色</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="border-color-input color-input"/>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both;margin-top: 10px; margin-left: 10px; font-size: 20px;"></div>'+
							'</div>'+
		      	'</div>'+
	    '</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			console.log($(this.$el).find(".input-btn-width"));
			$(this.$el).find(".input-btn-width").my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['width'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.sizeStyle['width'].substr(0,that.prop.styles.sizeStyle['width'].length-2)});
				
			$(this.$el).find(".input-btn-height").my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['line-height'] = val+'px';
				that.prop.styles.sizeStyle['height'] = val+'px';
			},defaultValue:that.prop.styles.sizeStyle['line-height'].substr(0,that.prop.styles.sizeStyle['line-height'].length-2)});
			
			$(this.$el).find(".input-margin-left").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-left'] = val+'px';
			},defaultValue:that.prop.styles.marginStyle['margin-left'].substr(0,that.prop.styles.marginStyle['margin-left'].length-2)});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-top'] = val+'px';
			},defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)});
			
			$(this.$el).find(".position-btns").children("span").click(function() {
				$(this).addClass("active").siblings("span").removeClass("active");
				that.prop.styles.posStyle['text-align'] = $(this).attr("align");
			});
			
			
			//修改背景色
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
			
			//标记颜色
			$(this.$el).find(".mark-color-input").spectrum({
		    color: that.prop.styles.markColorStyle['color'],
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
  				if(val) {
  					that.prop.styles.markColorStyle['color'] = val.toHexString();
  					that.prop.styles.markColorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.markColorStyle['color'] = 'transparent';
  					that.prop.styles.markColorStyle['background-color'] = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.markColorStyle['color'] = val.toHexString();
  					that.prop.styles.markColorStyle['background-color'] = val.toHexString();
  				} else {
  					that.prop.styles.markColorStyle['color'] = 'transparent';
  					that.prop.styles.markColorStyle['background-color'] = 'transparent';
  				}
  			}
			});
			//修改圆角
			$(this.$el).find(".input-border-radius").my_spinner({change:function(val) {
					that.prop.styles.borderStyle['border-radius'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.borderStyle['border-radius'].substr(0,that.prop.styles.borderStyle['border-radius'].length-2)
			});
			//边框宽度
			$(this.$el).find(".input-border-width").my_spinner({change:function(val) {
				that.prop.styles.borderStyle['border-width'] = val+'px';
			},defaultValue:that.prop.styles.borderStyle['border-width'].substr(0,that.prop.styles.borderStyle['border-width'].length-2)});
			//边框颜色
			$(this.$el).find(".border-color-input").spectrum({
			    color: that.prop.styles.borderStyle['border-color'],
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
    				that.prop.styles.borderStyle['border-color'] = val.toHexString();
    			},
    			hide:function(val) {
    				that.prop.styles.borderStyle['border-color'] = val.toHexString();
    			}
				});
		},
		methods:{
			onClickCollapseBtn:function(e) {
				if($(e.target).hasClass('close-btn')) {
    			$(e.target).removeClass('close-btn').addClass('open-btn');
    			$($(e.target).attr("href")).removeClass("hide");
    		} else {
    			$(e.target).removeClass('open-btn').addClass('close-btn');
    			$($(e.target).attr("href")).addClass("hide");
    		}
			},
			onChangeBorderStyle:function(e) {
    		this.prop.styles.borderStyle['border-style'] = $(e.target).val();
    	}
		}
	});
});