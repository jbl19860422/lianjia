/**************浮动按钮组件--编辑******************/
$(function() {
  var floatbtnComPanel = Vue.component('floatbtn-com-panel', {
		props:['prop','com','pages','page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>浮动按钮组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<floatbtn-com-panel1 :prop="prop" :com="com" :pages="pages" :page_groups="page_groups" :acts="acts"></floatbtn-com-panel1>'+
				'<floatbtn-com-panel2 :prop="prop" :com="com"></floatbtn-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted floatbtn panel");
		}
	});
	/**************浮动按钮组件--编辑1******************/
	var floatbtnComPanel1 = Vue.component('floatbtn-com-panel1',{
		props:['prop', 'com','pages','page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      	'<span style="font-size:20px">按钮图片：</span>'+
      	'<img :src="prop.imgSrc" style="width:100px;height:auto"></img>'+
      	'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" @click="onChangeImg()">替换图片</span>'+
      	'</div>'+
      	'<click-setting-com :action="prop.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onChangeImg:function() {
    		g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'imgSrc';
				g_piclistDlg.obj = this.prop;
    	}
		}
	});
	/**************浮动按钮组件--编辑2******************/
	var floatbtnComPanel2 = Vue.component('floatbtn-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none;padding-top:10px;">'+
		      		'<div>'+
			      		'<div style="float:left;margin-left:10px;font-size:20px;">大小：</div>'+
			      		'<div class="my-spinner input-size-spinner" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input class="input-size" input-style="font-size:20px"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;height:10px;"></div>'+
							'<div>'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;"><div style="float:left">内距</div>'+
									'<div class="my-spinner input-padding" style="float:left;margin-left:10px;">'+
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
							'<div style="clear:both;height:10px;"></div>'+
							'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
								'<div style="float:left">背景</div>'+
								'<div style="float:left;margin-left:20px;">'+
									'<input type="text" class="bkcolor-input color-input"/>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;height:20px;"></div>'+
							'<div style="float:left;margin-left:10px;font-size:20px;">圆角</div>'+
	      			'<div class="my-spinner input-border-radius" style="float:left;margin-left:10px;">'+
								'<div class="input-area">'+
									'<input style="font-size:20px"></input>'+
										'<span style="font-size:16px">px</span>'+
								'</div>'+
								'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-bottom:10px;"></div>'+
							'</div>'+
							'<div style="clear:both;margin-bottom:10px;"></div>'+
	      		'</div>'+
						'<div style="clear:both;margin-bottom:10px;"></div>'+
					'</div>'+
	      	'</div>'+
     	 '</div>'+
     	'</div>',
      
    mounted:function() {
    	var that = this;
    	
    	$('.input-size-spinner').my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['width'] = val+'px';
				that.prop.styles.sizeStyle['height'] = val+'px';
			},maxValue:424,defaultValue:that.prop.styles.sizeStyle['width']=='100%'?'424':that.prop.styles.sizeStyle.width.substr(0,that.prop.styles.sizeStyle['width'].length-2)});

    	$('.input-padding').my_spinner({change:function(val) {
				that.prop.styles.paddingStyle['padding'] = val+'px';
			},maxValue:424,defaultValue:that.prop.styles.paddingStyle.padding.substr(0,that.prop.styles.paddingStyle.padding.length-2)});
			
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
			
			$(this.$el).find(".input-border-radius").my_spinner({change:function(val) {
					that.prop.styles.borderStyle['border-radius'] = val+'px';
				},defaultValue:that.prop.styles.borderStyle['border-radius'].substr(0,that.prop.styles.borderStyle['border-radius'].length-2)});
    },
    methods:{
    	onChangeShadow:function(e) {
    		this.prop.styles.useShadow = !this.prop.styles.useShadow;
    		if(this.prop.styles.useShadow) {
    			$(e.target).attr("checked", "checked");
    		} else {
    			$(e.target).attr("checked", "");
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
		}
	});
});