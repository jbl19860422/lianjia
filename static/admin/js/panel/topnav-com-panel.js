$(function() {
/**************顶部导航组件--编辑******************/
  var topnavComPanel = Vue.component('topnav-com-panel', {
		props:['prop'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>顶部导航组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<topnav-com-panel1 :prop="prop"></topnav-com-panel1>'+
				'<topnav-com-panel2 :prop="prop"></topnav-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted pic panel");
		}
	});
	/**************顶部导航组件--编辑1******************/
	var topnavComPanel1 = Vue.component('topnav-com-panel1',{
		props:['prop'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<span>导航标题</span>'+
      		'<input style="margin-left:10px;font-size:20px;" type="text" :value="prop.title" v-model="prop.title"></input>'+
      	'</div>'+
      	'<div class="click-setting-title">左侧按钮'+
      		'<div @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" style="display:inline-block;width:20px;" href=".leftbtn-setting"></div>'+
      	'</div>'+
      	'<div class="leftbtn-setting hide">'+
	      	'<div class="click-setting-wrap" style="border:1px solid #dadada;border-top:none;border-bottom-left-radius:10px;border-bottom-right-radius:10px;width:100%;position:relative;padding-top:20px;">'+
	      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
	      			'<span>是否使用左侧按钮：</span>'+
	      			'<select style="margin-left:10px" v-model="prop.leftBtn.use">'+
	      				'<option value=true>使用</option>'+
	      				'<option value=false>不使用</option>'+
	      			'</select>'+
	      		'</div>'+
	      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
	      			'<span>文字：</span><input style="margin-left:10px;font-size:20px;" type="text" :value="prop.leftBtn.text" v-model="prop.leftBtn.text"></input>'+
	      		'</div>'+
	      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
	      			'<div style="float:left;margin-right:10px;">字号：</div>'+
	      			'<div class="my-spinner input-font-size" style="float:left">'+
								'<div class="input-area">'+
									'<input style="font-size:20px" :value="prop.leftBtn.fontStyle[\'font-size\'].substr(0,prop.leftBtn.fontStyle[\'font-size\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
								'</div>'+
								'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
								'</div>'+
							'</div>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
	      		'<div style="margin-left:10px">'+
	      			'<div style="float:left;margin-right:10px;">按钮宽度</div>'+
	      			'<div class="my-spinner input-btn-width" style="float:left">'+
								'<div class="input-area">'+
									'<input style="font-size:20px" :value="prop.leftBtn.sizeStyle[\'width\'].substr(0,prop.leftBtn.sizeStyle[\'width\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
								'</div>'+
								'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
								'</div>'+
							'</div>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
	      		'<div style="margin-left:10px">'+
	      			'<div style="float:left;margin-right:10px;">文字距左边距离</div>'+
	      			'<div class="my-spinner input-pos-left" style="float:left">'+
								'<div class="input-area">'+
									'<input style="font-size:20px" :value="prop.leftBtn.fontPosStyle[\'left\'].substr(0,prop.leftBtn.fontPosStyle[\'left\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
								'</div>'+
								'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
								'</div>'+
							'</div>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
	      		'<div style="margin-left:10px">'+
	      			'<span>图片：</span><img style="width:100px;height:100px" :src="prop.leftBtn.imgSrc"></img>'+
	      			'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" id="ID_changeLeftImg">替换图片</span><span></span>'+
	      			'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" @click="delLeftImg()" id="ID_delLeftImg">删除图片</span><span></span>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
	      		'<div>'+
							'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
								'<div style="float:left">图片间距</div>'+
								'<div style="float:left;margin-left:10px">左</div>'+
								'<div class="my-spinner input-padding-left" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.leftBtn.paddingStyle[\'padding-left\'].substr(0,prop.leftBtn.paddingStyle[\'padding-left\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
									'<div style="float:left;margin-left:10px;">右</div>'+
									'<div class="my-spinner input-padding-right" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.leftBtn.paddingStyle[\'padding-right\'].substr(0,prop.leftBtn.paddingStyle[\'padding-right\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div style="clear:both;margin-top:20px">'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
								'<div style="float:left;margin-left:90px">上</div>'+
								'<div class="my-spinner input-padding-top" style="float:left;margin-left:10px;">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.leftBtn.paddingStyle[\'padding-top\'].substr(0,prop.leftBtn.paddingStyle[\'padding-top\'].length-2)"></input>'+
											'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
									'<div style="float:left;margin-left:10px;">下</div>'+
									'<div class="my-spinner input-padding-bottom" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.leftBtn.paddingStyle[\'padding-bottom\'].substr(0,prop.leftBtn.paddingStyle[\'padding-bottom\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div style="clear:both;height:10px;width:100%;"></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
	      	'</div>'+
	      	'<div class="click-setting-title">右侧按钮'+
	      		'<div @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" style="display:inline-block;width:20px;" href=".rightbtn-setting"></div>'+
	      	'</div>'+
	      	'<div class="rightbtn-setting hide">'+
		      	'<div class="click-setting-wrap" style="border:1px solid #dadada;border-top:none;border-bottom-left-radius:10px;border-bottom-right-radius:10px;width:100%;position:relative;padding-top:20px;">'+
		      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
		      			'<span>是否使用右侧按钮：</span>'+
		      			'<select style="margin-left:10px" v-model="prop.rightBtn.use">'+
		      				'<option value=true>使用</option>'+
		      				'<option value=false>不使用</option>'+
		      			'</select>'+
		      		'</div>'+
		      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
		      			'<span>文字：</span><input style="margin-left:10px;font-size:20px;" type="text" :value="prop.rightBtn.text" v-model="prop.rightBtn.text"></input>'+
		      		'</div>'+
		      		'<div style="margin-left:10px;font-size:20px;margin-bottom:10px;">'+
		      			'<div style="float:left;margin-right:10px;">字号：</div>'+
		      			'<div class="my-spinner input-font-size" style="float:left">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.rightBtn.fontStyle[\'font-size\'].substr(0,prop.rightBtn.fontStyle[\'font-size\'].length-2)"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
		      		'</div>'+
		      		'<div style="clear:both;height:10px"></div>'+
		      		'<div style="margin-left:10px">'+
		      			'<div style="float:left;margin-right:10px;">按钮宽度</div>'+
		      			'<div class="my-spinner input-btn-width" style="float:left">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.rightBtn.sizeStyle[\'width\'].substr(0,prop.rightBtn.sizeStyle[\'width\'].length-2)"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
		      		'</div>'+
		      		'<div style="clear:both;height:10px"></div>'+
		      		'<div style="margin-left:10px">'+
		      			'<div style="float:left;margin-right:10px;">文字距右边距离</div>'+
		      			'<div class="my-spinner input-pos-right" style="float:left">'+
									'<div class="input-area">'+
										'<input style="font-size:20px" :value="prop.rightBtn.fontPosStyle[\'right\'].substr(0,prop.rightBtn.fontPosStyle[\'right\'].length-2)"></input>'+
										'<span style="font-size:16px">px</span>'+
									'</div>'+
									'<div class="btn-area">'+
											'<div class="plus-btn"></div>'+
											'<div class="minus-btn"></div>'+
									'</div>'+
								'</div>'+
		      		'</div>'+
		      		'<div style="clear:both;height:10px"></div>'+
		      		'<div style="margin-left:10px">'+
		      			'<span>图片：</span><img style="width:100px;height:100px" :src="prop.rightBtn.imgSrc"></img>'+
		      			'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" id="ID_changeRightImg">替换图片</span>'+
		      			'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" @click="delRightImg()">删除图片</span>'+
		      		'</div>'+
		      		'<div style="clear:both;height:10px"></div>'+
		      		'<div>'+
								'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left">图片间距</div>'+
									'<div style="float:left;margin-left:10px">左</div>'+
									'<div class="my-spinner input-padding-left" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.rightBtn.paddingStyle[\'padding-left\'].substr(0,prop.rightBtn.paddingStyle[\'padding-left\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
										'<div style="float:left;margin-left:10px;">右</div>'+
										'<div class="my-spinner input-padding-right" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" :value="prop.rightBtn.paddingStyle[\'padding-right\'].substr(0,prop.rightBtn.paddingStyle[\'padding-right\'].length-2)"></input>'+
													'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div style="clear:both;margin-top:20px">'+
									'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
									'<div style="float:left;margin-left:90px">上</div>'+
									'<div class="my-spinner input-padding-top" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.rightBtn.paddingStyle[\'padding-top\'].substr(0,prop.rightBtn.paddingStyle[\'padding-top\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
										'<div style="float:left;margin-left:10px;">下</div>'+
										'<div class="my-spinner input-padding-bottom" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input style="font-size:20px" :value="prop.rightBtn.paddingStyle[\'padding-bottom\'].substr(0,prop.rightBtn.paddingStyle[\'padding-bottom\'].length-2)"></input>'+
													'<span style="font-size:16px">px</span>'+
											'</div>'+
											'<div class="btn-area">'+
													'<div class="plus-btn"></div>'+
													'<div class="minus-btn"></div>'+
											'</div>'+
										'</div>'+
										'<div style="clear:both;height:10px;width:100%;"></div>'+
									'</div>'+
								'</div>'+
							'</div>'+
		      	'</div>'+
		      '</div>'+
	      '</div>'+
      '</div>',
    mounted:function() {
    	var that = this;
    	
    	$(this.$el).find(".leftbtn-setting .input-font-size").my_spinner({change:function(val) {
				that.prop.leftBtn.fontStyle['font-size'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.fontStyle['font-size'].substr(0, that.prop.leftBtn.fontStyle['font-size'].length-2)});
			
			$(this.$el).find(".leftbtn-setting .input-padding-left").my_spinner({change:function(val) {
				that.prop.leftBtn.paddingStyle['padding-left'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.paddingStyle['padding-left'].substr(0, that.prop.leftBtn.paddingStyle['padding-left'].length-2)});
			
			$(this.$el).find(".leftbtn-setting .input-padding-right").my_spinner({change:function(val) {
				that.prop.leftBtn.paddingStyle['padding-right'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.paddingStyle['padding-right'].substr(0, that.prop.leftBtn.paddingStyle['padding-right'].length-2)});
			
			$(this.$el).find(".leftbtn-setting .input-padding-bottom").my_spinner({change:function(val) {
				that.prop.leftBtn.paddingStyle['padding-bottom'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.paddingStyle['padding-bottom'].substr(0, that.prop.leftBtn.paddingStyle['padding-bottom'].length-2)});
			
			$(this.$el).find(".leftbtn-setting .input-padding-top").my_spinner({change:function(val) {
				that.prop.leftBtn.paddingStyle['padding-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.paddingStyle['padding-top'].substr(0, that.prop.leftBtn.paddingStyle['padding-top'].length-2)});
			
			$(this.$el).find(".leftbtn-setting .input-btn-width").my_spinner({change:function(val) {
				that.prop.leftBtn.sizeStyle['width'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.sizeStyle['width'].substr(0, that.prop.leftBtn.sizeStyle['width'].length-2)});
			
			
			$(this.$el).find(".leftbtn-setting .input-pos-left").my_spinner({change:function(val) {
				that.prop.leftBtn.fontPosStyle['left'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.leftBtn.fontPosStyle['left'].substr(0, that.prop.leftBtn.fontPosStyle['left'].length-2)});
			
    	var left_img_uploader = new QiniuJsSDK();
	    var left_img_uploader_opt = {
	        browse_button: 'ID_changeLeftImg',
	        uptoken_url:g_host_url+"/admin/get_qiniu_upload_token",
	        auto_start: true,
	        domain: 'http://o95rd8icu.bkt.clouddn.com/',
	        unique_names: true,
	        max_file_size:'4mb',
	        init: {
	            'BeforeUpload': function (up, file) {
	            },
	            'FileUploaded': function (up, file, info) {
	               var domain = up.getOption('domain');
	               var res = JSON.parse(info);
	               var sourceLink = domain + res.key; //获取上传成功后的文件的Url
	               that.prop.leftBtn.imgSrc = sourceLink;
	            },
	            'Error': function(up, err, errTip) {
	            }
	        }
	    };
	    left_img_uploader.uploader(left_img_uploader_opt);
	    
	    $(this.$el).find(".rightbtn-setting .input-font-size").my_spinner({change:function(val) {
				that.prop.rightBtn.fontStyle['font-size'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.fontStyle['font-size'].substr(0, that.prop.rightBtn.fontStyle['font-size'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-padding-right").my_spinner({change:function(val) {
				that.prop.rightBtn.paddingStyle['padding-right'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.paddingStyle['padding-right'].substr(0, that.prop.rightBtn.paddingStyle['padding-right'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-padding-right").my_spinner({change:function(val) {
				that.prop.rightBtn.paddingStyle['padding-right'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.paddingStyle['padding-right'].substr(0, that.prop.rightBtn.paddingStyle['padding-right'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-padding-bottom").my_spinner({change:function(val) {
				that.prop.rightBtn.paddingStyle['padding-bottom'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.paddingStyle['padding-bottom'].substr(0, that.prop.rightBtn.paddingStyle['padding-bottom'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-padding-top").my_spinner({change:function(val) {
				that.prop.rightBtn.paddingStyle['padding-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.paddingStyle['padding-top'].substr(0, that.prop.rightBtn.paddingStyle['padding-top'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-btn-width").my_spinner({change:function(val) {
				that.prop.rightBtn.sizeStyle['width'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.sizeStyle['width'].substr(0, that.prop.rightBtn.sizeStyle['width'].length-2)});
			
			$(this.$el).find(".rightbtn-setting .input-pos-right").my_spinner({change:function(val) {
				that.prop.rightBtn.fontPosStyle['right'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.rightBtn.fontPosStyle['right'].substr(0, that.prop.rightBtn.fontPosStyle['right'].length-2)});
			
    	var right_img_uploader = new QiniuJsSDK();
	    var right_img_uploader_opt = {
	        browse_button: 'ID_changerightImg',
	        uptoken_url:g_host_url+"/admin/get_qiniu_upload_token",
	        auto_start: true,
	        domain: 'http://o95rd8icu.bkt.clouddn.com/',
	        unique_names: true,
	        max_file_size:'4mb',
	        init: {
	            'BeforeUpload': function (up, file) {
	            },
	            'FileUploaded': function (up, file, info) {
	               var domain = up.getOption('domain');
	               var res = JSON.parse(info);
	               var sourceLink = domain + res.key; //获取上传成功后的文件的Url
	               that.prop.rightBtn.imgSrc = sourceLink;
	            },
	            'Error': function(up, err, errTip) {
	            }
	        }
	    };
	    right_img_uploader.uploader(right_img_uploader_opt);
    },
    methods:{
    	delLeftImg:function() {
    		this.prop.leftBtn.imgSrc = "";
    	},
    	delRightImg:function() {
    		this.prop.rightBtn.imgSrc = "";
    	},
    	onClickCollapseBtn:function(e) {
    		if($(e.target).hasClass('close-btn')) {
    			$(e.target).removeClass('close-btn').addClass('open-btn');
    			$($(e.target).attr("href")).removeClass("hide");
    		} else {
    			$(e.target).removeClass('open-btn').addClass('close-btn');
    			$($(e.target).attr("href")).addClass("hide");
    		}
    	}
		}
	});
	/**************顶部导航组件--编辑2*****************/
	var topnavComPanel2 = Vue.component('topnav-com-panel2',{
		props:['prop'],
		template:
		'<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
			'<div>'+
      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
				'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
					'<div style="margin-left:10px;padding-top:10px;">'+
						'<div style="float:left;margin-right:20px">尺寸</div>'+
						'<div style="float:left;margin-right:10px">高</div>'+
						'<div class="my-spinner input-height" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.sizeStyle[\'height\'].substr(0,prop.styles.sizeStyle[\'height\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;height:10px;width:100%"></div>'+
					'</div>'+
					'<div style="margin-left:10px">'+
						'<div style="float:left">'+
							'背景颜色：<input type="text" class="bkcolor-input"/>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;height:10px;width:100%"></div>'+
					'<div class="shadow-set">'+
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
					'</div><!----shadow-set---->'+
					'<div style="clear:both;height:10px;width:100%"></div>'+
				'</div>'+
			'</div>'+
			'<div style="margin-top:10px">'+
				'<div class="click-setting-title">文字设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_text_setting"></span></div>'+
				'<div id="ID_text_setting" class="hide" style="padding-top:10px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;padding-left:10px;padding-bottom:10px;border-bottom-right-radius: 10px;border-top:none">'+
					'<font-setting-pane :prop="prop" :fontStyle="prop.styles.fontStyle" :hide_align="true"></font-setting-pane>'+
					'<div style="clear:both"></div>'+
				'</div>'+
			'</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).find(".input-height").my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['height'] = val+'px';
				that.prop.styles.sizeStyle['line-height'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.sizeStyle['height'].substr(0, that.prop.styles.sizeStyle['height'].length-2)});

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
			        ["#900","#b45f06","#fbf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
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
			
			/****************阴影设置**************/
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
    	onClickCollapseBtn:function(e) {
    		if($(e.target).hasClass('close-btn')) {
    			$(e.target).removeClass('close-btn').addClass('open-btn');
    			$($(e.target).attr("href")).removeClass("hide");
    		} else {
    			$(e.target).removeClass('open-btn').addClass('close-btn');
    			$($(e.target).attr("href")).addClass("hide");
    		}
    	}
		}
	});
});