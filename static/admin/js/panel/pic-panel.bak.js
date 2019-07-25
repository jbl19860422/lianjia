$(function() {
/**************图片组件--编辑******************/
  var picComPanel = Vue.component('pic-com-panel', {
		props:['prop','page_groups', 'pages'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>图片组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<pic-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups"></pic-com-panel1>'+
				'<pic-com-panel2 :prop="prop"></pic-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted pic panel");
		}
	});
	/**************图片组件--编辑1******************/
	var picComPanel1 = Vue.component('pic-com-panel1',{
		props:['prop','pages', 'page_groups'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<img :src="prop.src" style="border:1px solid #aaaaaa;height:100px;width:auto"></img>'+
      		'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" :id="\'ID_editPanel1_\'+prop.id+\'_changeimg\'">更换图片</span>'+
      	'</div>'+
      	'<div class="click-setting-title">点击设置'+
      	'</div>'+
      	'<div class="click-setting-wrap" style="height:200px;border:1px solid #dadada;border-top:none;border-bottom-left-radius:10px;border-bottom-right-radius:10px;width:100%;position:relative;padding-top:20px;">'+
      		'<div>'+
	      		'<ul class="setting-list" style="width:90%;margin-left:auto;margin-right:auto;height:40px;">'+
	      			'<li href=".none-setting" @click="onClickActBtn(\'none\')" v-bind:class="[\'none\', prop.action.type==\'none\'?\'active\':\'\']">无</li>'+
	      			'<li href=".page_act-setting" @click="onClickActBtn(\'page\')" v-bind:class="[\'page\', prop.action.type==\'page\'?\'active\':\'\']">打开页面</li>'+
	      			'<li href=".func-setting" @click="onClickActBtn(\'fun\')" v-bind:class="[\'fun\', prop.action.type==\'fun\'?\'active\':\'\']">其他功能</li>'+
	      		'</ul>'+
	      		'<div class="setting-pane">'+
	      			'<div class="none-setting" ></div>'+
		      		'<div v-show="prop.action.type==\'page\'" class="act-setting">'+
		      			'<div class="mg-h-10 mg-v-10 ft-20">链接至：'+
		      				'<select class="setting-opt">'+
		      					'<option value ="prePage">后退</option>'+
		      					'<option value ="custom-link">自定义链接</option>'+
		      					'<optgroup :label="page_group.group_name" v-for="page_group in page_groups">'+
		      						'<option v-for="page in pages" v-if="page.group_id==page_group.group_id" :value="page.page_id" v-html="page.page_name"></option>'+
		      					'</optgroup>'+
									'</select>'+
								'</div>'+
		      		'</div>'+
		      		'<div v-show="prop.action.type==\'fun\'" class="act-setting">'+
		      			'<div class="mg-h-10 mg-v-10 ft-20">调用功能：'+
		      				'<select class="setting-opt">'+
		      					'<option value ="dial">拨打电话</option>'+
		      					'<option value ="refresh">刷新页面</option>'+
		      				'</select>'+
		      				'<div v-if="prop.action.subtype==\'dial\'" class="dial-phone-num" style="margin-top:10px">电话号码：<input class="phone-num" type="text" style="border-radius:4px !important;height:40px;" v-model="prop.action.param" ></input></div>'+
		      			'</div>'+
		      		'</div>'+
		      	'</div>'+
	      	'</div>'+
      	'</div>'+
      '</div>',
      
    mounted:function() {
    	console.log('page_groups=',this.page_groups);
    	var that = this;
    	var img_uploader = new QiniuJsSDK();
	    var img_uploader_opt = {
	        browse_button: 'ID_editPanel1_'+that.prop.id+'_changeimg',
	        uptoken_url:g_host_url+"/admin/get_qiniu_upload_token",
	        auto_start: true,
	        domain: g_app.server_domain,
	        unique_names: true,
	        max_file_size:'4mb',
	        init: {
	            'BeforeUpload': function (up, file) {
	            },
	            'FileUploaded': function (up, file, info) {
	               var domain = up.getOption('domain');
	               var res = JSON.parse(info);
	               var sourceLink = domain + res.key; //获取上传成功后的文件的Url
	               that.prop.src = sourceLink;
	            },
	            'Error': function(up, err, errTip) {
	            }
	        }
	    };
	    img_uploader.uploader(img_uploader_opt);
    },
    methods:{
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClickActBtn:function(act) {
				var that = this;
				if(act == 'none' && that.prop.action.type != act) {
					that.prop.action.type = 'none';
					that.prop.action.detail = {};
					$("#ID_editPanel1_"+that.prop.id+" .setting-list .none").addClass('active').siblings().remove('active');
					
					$("#ID_editPanel1_"+that.prop.id+" .none-setting").removeClass('hide').siblings().addClass('hide');
				} else if(act == 'page' && that.prop.action.type != act) {
					that.prop.action.type = 'page';
					that.prop.action.detail = {};
					$("#ID_editPanel1_"+that.prop.id+" .setting-list .page_act").addClass('active').siblings().remove('active');
					
					$("#ID_editPanel1_"+that.prop.id+" .page_act-setting").removeClass('hide').siblings().addClass('hide');
				} else if(act == 'fun' && that.prop.action.type != act) {
					that.prop.action.type = 'fun';
					that.prop.action.subtype = 'dial';
					that.prop.action.detail = {};
					$("#ID_editPanel1_"+that.prop.id+" .setting-list .fun").addClass('active').siblings().remove('active');
					
					$("#ID_editPanel1_"+that.prop.id+" .fun_act-setting").removeClass('hide').siblings().addClass('hide');
				}
			},
			onPhoneChange:function(e) {
				var input = $(e.target);
			}
		}
	});
	/**************图片组件--编辑2******************/
	var picComPanel2 = Vue.component('pic-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div>'+
			      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;"><div>尺寸：</div>'+
			      			'<div>'+
			      				'<span style="font-size:20px;float:left;">宽：</span>'+
			      				'<select @change="onSelWidthMode($event)" style="height:40px;border-radius:5px;float:left;">'+
			      					'<option value="100">手机宽度</option>'+
			      					'<option value="fixed_width">固定宽度</option>'+
			      					'<option value="auto">适应高度</option>'+
			      				'</select>'+
			      				'<div style="float:left;margin-left:20px" v-show="prop.styles.sizeStyle.width!=\'100%\'&&prop.styles.sizeStyle.width!=\'auto\'">宽度值：</div>'+
			      				'<div v-show="prop.styles.sizeStyle.width!=\'100%\'&&prop.styles.sizeStyle.width!=\'auto\'" class="my-spinner input-width-spinner" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input class="input-width" input-style="font-size:20px" value="80"></input>'+
													'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
			      			'</div>'+
			      			'<div style="clear:both;height:10px;"></div>'+
			      			'<div style="margin-top:10px">'+
			      				'<span style="font-size:20px;float:left;">高度：</span>'+
			      				'<select @change="onSelHeightMode($event)" style="height:40px;border-radius:5px;float:left;">'+
			      					'<option value="fixed_height" :selected="prop.styles.sizeStyle.height!=\'auto\'">固定高度</option>'+
			      					'<option value="auto" :selected="prop.styles.sizeStyle.height==\'auto\'">适应宽度</option>'+
			      				'</select>'+
			      				'<div v-show="prop.styles.sizeStyle.height!=\'auto\'" style="float:left;margin-left:20px">高度值：</div>'+
			      				'<div v-show="prop.styles.sizeStyle.height!=\'auto\'" class="my-spinner input-height-val" style="float:left;margin-left:10px;">'+
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
							'</div>'+
							'<div style="clear:both;height:10px;"></div>'+
							'<div>'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;"><div style="float:left">间距</div>'+
								'<div style="float:left;margin-left:10px">左</div>'+
									'<div class="my-spinner input-padding-left" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.paddingStyle[\'padding-left\'].substr(0,prop.styles.paddingStyle[\'padding-left\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div style="float:left;margin-left:20px;">右</div>'+
									'<div class="my-spinner input-padding-right" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.paddingStyle[\'padding-right\'].substr(0,prop.styles.paddingStyle[\'padding-right\'].length-2)"></input>'+
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
							'<div>'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;"><div style="float:left"></div>'+
								'<div style="float:left;margin-left:50px">上</div>'+
									'<div class="my-spinner input-padding-top" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.paddingStyle[\'padding-top\'].substr(0,prop.styles.paddingStyle[\'padding-top\'].length-2)"></input>'+
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
											'<input style="font-size:20px" :value="prop.styles.paddingStyle[\'padding-bottom\'].substr(0,prop.styles.paddingStyle[\'padding-bottom\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;height:20px;"></div>'+
							'<div style="font-size:20px;margin-left:10px;">'+
								'<div style="float:left">位置</div>'+
								'<div style="float:left;margin-left:20px" class="position-btns">'+
									'<span align="left" :class="{\'active\':prop.styles.marginStyle[\'margin-left\']==\'0px\'&&prop.styles.marginStyle[\'margin-right\']==\'auto\'}">置左</span>'+
									'<span align="center" :class="{\'active\':prop.styles.marginStyle[\'margin-left\']==\'auto\'&&prop.styles.marginStyle[\'margin-right\']==\'auto\'}">居中</span>'+
									'<span align="right" :class="{\'active\':prop.styles.marginStyle[\'margin-left\']==\'auto\'&&prop.styles.marginStyle[\'margin-right\']==\'0px\'}">置右</span>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;height:20px;"></div>'+
							'<div style="font-size:20px;margin-left:10px;">'+
								'<div style="margin-right:20px;float:left;">左</div>'+
								'<div class="my-spinner input-margin-left" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-left\']==\'auto\'?0:prop.styles.marginStyle[\'margin-left\'].substr(0,prop.styles.marginStyle[\'margin-left\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="margin-right:20px;float:left;">右</div>'+
								'<div class="my-spinner input-margin-right" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-right\']==\'auto\'?0:prop.styles.marginStyle[\'margin-right\'].substr(0,prop.styles.marginStyle[\'margin-right\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;height:10px;"></div>'+
							'<div style="font-size:20px;margin-left:10px;">'+
								'<div style="margin-right:20px;float:left;">上</div>'+
								'<div class="my-spinner input-margin-top" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-top\']==\'auto\'?0:prop.styles.marginStyle[\'margin-top\'].substr(0,prop.styles.marginStyle[\'margin-top\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="margin-right:20px;float:left;">下</div>'+
								'<div class="my-spinner input-margin-bottom" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-bottom\']==\'auto\'?0:prop.styles.marginStyle[\'margin-bottom\'].substr(0,prop.styles.marginStyle[\'margin-bottom\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-top:10px;margin-bottom:10px;height:10px;">'+
							'</div>'+
							'<div style="font-size:20px;margin-left:10px;margin-bottom:10px;height:42px;" class="alpha-setting">'+
									'<div style="margin-right:20px;float:left;">透明度</div>'+
									'<div class="alpha-slider" style="margin-top:10px;width:200px;float:left;"></div>'+
							'</div>'+
							'<div style="clear:both;margin-bottom:10px;"></div>'+
							'<div style="font-size:20px;margin-left:10px;margin-bottom:10px;height:42px;" class="rotate-setting">'+
									'<div style="margin-right:20px;float:left;">旋转角度</div>'+
									'<div class="my-spinner input-rotate-deg" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.transformDeg"></input>'+
												'<span style="font-size:16px">°</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
							'</div>'+
							'<div style="clear:both;margin-top:10px;margin-bottom:20px;height:20px;">'+
							'<div style="font-size:20px;margin-left:10px;clear:both" class="border-radius-setting">'+
									'<div style="margin-right:10px;float:left;">圆角：</div>'+
									'<div class="my-spinner input-border-radius" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.borderStyle[\'border-radius\'].substr(0,prop.styles.borderStyle[\'border-radius\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
							'</div>'+
							'<div style="height:10px;clear:both;margin-top:20px;margin-bottom:10px;"></div>'+
	      		'</div>'+
	      		'<div class="click-setting-title">边框设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_border_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_border_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div style="font-size:20px">'+
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
								'<div style="height:10px;clear:both; margin-left: 10px; font-size: 20px;"></div>'+
								'<div style="clear:both;margin-top: 0px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">边框颜色</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="border-color-input color-input"/>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both; margin-left: 10px; font-size: 20px;"></div>'+
								'<div style="clear:both; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">添加边框阴影效果？</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input @click="onChangeShadow($event)" type="checkbox" style="width:20px;height:20px;cursor:pointer;" class="check_shadow"/>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both; margin-left: 10px; font-size: 20px;"></div>'+
								'<div style="clear:both; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">模糊半径</div>'+
									'<div class="my-spinner input-shadow-blur" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.shadow_blur"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div style="float:left;margin-left:10px;">颜色</div>'+
									'<div style="float:left;margin-left:20px;">'+
										'<input type="text" class="shadow-color-input color-input"/>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both; margin-left: 10px; font-size: 20px;"></div>'+
								'<div style="float:left;margin-left:10px;">水平偏移</div>'+
								'<div class="my-spinner input-shadow-x" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.shadow_x"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="float:left;margin-left:10px">垂直偏移</div>'+
								'<div class="my-spinner input-shadow-y" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.styles.shadow_y"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
								'<div style="height:10px;clear:both;margin-top: 10px; margin-left: 10px; font-size: 20px;"></div>'+
							'</div>'+
		      	'</div>'+
	      	'</div>'+
     	 '</div>'+
     	'</div>',
      
    mounted:function() {
    	var that = this;
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
    	
    	$(this.$el).find(".input-rotate-deg").my_spinner({change:function(val) {
					that.prop.styles.transformDeg = val;
					that.prop.styles.transformStyle.transform = "rotateZ("+that.prop.styles.transformDeg+"deg)";
    			that.prop.styles.transformStyle['-webkit-transform'] = "rotateZ("+that.prop.styles.transformDeg+"deg)";
    			console.log('transform change');
				},maxValue:360,minValue:-360,
				defaultValue:that.prop.styles.transformDeg
			});

    	$(this.$el).find(".input-width-spinner").my_spinner({change:function(val) {
					that.prop.styles.sizeStyle.width = val+'px';
				},maxValue:1000,
				defaultValue:that.prop.widthMode=="fixed_width"?that.prop.styles.sizeStyle['width'].substr(0,that.prop.styles.sizeStyle['width'].length-2):"80"
			});
			
			$(this.$el).find(".input-padding-left").my_spinner({change:function(val) {
					that.prop.styles.paddingStyle['padding-left'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.paddingStyle['padding-left'].substr(0,that.prop.styles.paddingStyle['padding-left'].length-2)
			});
			
			$(this.$el).find(".input-padding-right").my_spinner({change:function(val) {
					that.prop.styles.paddingStyle['padding-right'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.paddingStyle['padding-right'].substr(0,that.prop.styles.paddingStyle['padding-right'].length-2)
			});
			
			$(this.$el).find(".input-padding-top").my_spinner({change:function(val) {
					that.prop.styles.paddingStyle['padding-top'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.paddingStyle['padding-top'].substr(0,that.prop.styles.paddingStyle['padding-top'].length-2)
			});
			
			$(this.$el).find(".input-padding-bottom").my_spinner({change:function(val) {
					that.prop.styles.paddingStyle['padding-bottom'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.paddingStyle['padding-bottom'].substr(0,that.prop.styles.paddingStyle['padding-bottom'].length-2)
			});
			
			$(this.$el).find(".input-border-radius").my_spinner({change:function(val) {
					that.prop.styles.borderStyle['border-radius'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.borderStyle['border-radius'].substr(0,that.prop.styles.borderStyle['border-radius'].length-2)
			});
			
			$(this.$el).find(".position-btns").children("span").click(function() {
				$(this).addClass("active").siblings("span").removeClass("active");
				var align = $(this).attr('align');
				if(align == 'left') {
					that.prop.styles.marginStyle['margin-left'] = '0px';
					that.prop.styles.marginStyle['margin-right'] = 'auto';
				} else if(align == 'right') {
					that.prop.styles.marginStyle['margin-left'] = 'auto';
					that.prop.styles.marginStyle['margin-right'] = '0px';
				} else if(align == 'center') {
					that.prop.styles.marginStyle['margin-left'] = 'auto';
					that.prop.styles.marginStyle['margin-right'] = 'auto';
				}
			});
			
			$(this.$el).find(".input-margin-left").my_spinner({change:function(val) {
					that.prop.styles.marginStyle['margin-left'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.marginStyle['margin-left']=="auto"?0:that.prop.styles.marginStyle['margin-left'].substr(0,that.prop.styles.marginStyle['margin-left'].length-2)
			});
			
			$(this.$el).find(".input-margin-right").my_spinner({change:function(val) {
					that.prop.styles.marginStyle['margin-right'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.marginStyle['margin-right']=="auto"?0:that.prop.styles.marginStyle['margin-right'].substr(0,that.prop.styles.marginStyle['margin-right'].length-2)
			});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
					that.prop.styles.marginStyle['margin-top'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.marginStyle['margin-top']=="auto"?0:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)
			});
			
			$(this.$el).find(".input-margin-bottom").my_spinner({change:function(val) {
					that.prop.styles.marginStyle['margin-bottom'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.marginStyle['margin-bottom']=="auto"?0:that.prop.styles.marginStyle['margin-bottom'].substr(0,that.prop.styles.marginStyle['margin-bottom'].length-2)
			});
			
			$(this.$el).find(".input-border-width").my_spinner({change:function(val) {
					that.prop.styles.borderStyle['border-width'] = val+'px';
				},defaultValue:that.prop.styles.borderStyle['border-width'].substr(0,that.prop.styles.borderStyle['border-width'].length-2)});
				
			$(this.$el).find(".input-height-val").my_spinner({change:function(val) {
					that.prop.styles.sizeStyle['height'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.sizeStyle['height']=="auto"?"80":that.prop.styles.sizeStyle['height'].substr(0,that.prop.styles.sizeStyle['height'].length-2)
			});
			
			$(this.$el).find(".border-color-input").spectrum({
		    color: that.prop.styles.borderStyle['border-color'],
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
  				console.log(val);
  				that.prop.styles.borderStyle['border-color'] = "rgba("+val._r+","+val._g+","+val._b+","+val._a+")";
  			},
  			hide:function(val) {
  				that.prop.styles.borderStyle['border-color'] = "rgba("+val._r+","+val._g+","+val._b+","+val._a+")";;
  			}
			});
			
			$(this.$el).find(".input-shadow-blur").my_spinner({change:function(val) {
					that.prop.styles.shadow_blur = val;
					that.prop.styles.shadowStyle['box-shadow'] = that.prop.styles.shadow_x+"px " + that.prop.styles.shadow_y+"px " + that.prop.styles.shadow_blur+"px "+that.prop.styles.shadow_color;
				},maxValue:500,
				defaultValue:that.prop.styles.shadow_blur
			});
			
			$(this.$el).find(".shadow-color-input").spectrum({
		    color: that.prop.styles.shadowStyle.shadow_color,
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
  				that.prop.styles.shadow_color = val;
  				that.prop.styles.shadowStyle['box-shadow'] = that.prop.styles.shadow_x+"px " + that.prop.styles.shadow_y+"px " + that.prop.styles.shadow_blur+"px "+that.prop.styles.shadow_color;
  			},
  			hide:function(val) {
  				that.prop.styles.shadow_color = val;
  				that.prop.styles.shadowStyle['box-shadow'] = that.prop.styles.shadow_x+"px " + that.prop.styles.shadow_y+"px " + that.prop.styles.shadow_blur+"px "+that.prop.styles.shadow_color;
  			}
			});
			
			$(this.$el).find(".input-shadow-x").my_spinner({change:function(val) {
					that.prop.styles.shadow_x = val;
					that.prop.styles.shadowStyle['box-shadow'] = that.prop.styles.shadow_x+"px " + that.prop.styles.shadow_y+"px " + that.prop.styles.shadow_blur+"px "+that.prop.styles.shadow_color;
				},maxValue:500,
				defaultValue:that.prop.styles.shadow_x
			});
			
			$(this.$el).find(".input-shadow-y").my_spinner({change:function(val) {
					that.prop.styles.shadow_y = val;
					that.prop.styles.shadowStyle['box-shadow'] = that.prop.styles.shadow_x+"px " + that.prop.styles.shadow_y+"px " + that.prop.styles.shadow_blur+"px "+that.prop.styles.shadow_color;
				},maxValue:500,
				defaultValue:that.prop.styles.shadow_y
			});
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
    	onSelHeightMode:function(e) {
    		var val = $(e.target).val();
    		if(val == "fixed_height") {
    			this.prop.styles.sizeStyle.height = $(this.$el).find(".input-height-val input").val()+"px";
    		} else {
    			this.prop.styles.sizeStyle.height = "auto";
    		}
    	},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onSelWidthMode:function(e) {
				this.prop.widthMode = $(e.target).val();
				if(this.prop.widthMode == "100") {
					this.prop.styles.sizeStyle.width="auto";
				} else if(this.prop.widthMode == "fixed_width") {
					this.prop.styles.sizeStyle.width = $(this.$el).find(".input-width").val()+"px";
				} else if(this.prop.widthMode == "auto") {
					this.prop.styles.sizeStyle.width = "auto";
				}
			},
			onChangeBorderStyle:function(e) {
				this.prop.styles.borderStyle['border-style'] = $(e.target).val();
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