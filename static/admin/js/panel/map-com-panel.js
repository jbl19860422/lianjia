$(function(){
	/**************地图组件--编辑******************/
  var mapComPanel = Vue.component('map-com-panel', {
		props:['prop','com'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>地图组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<map-com-panel1 :prop="prop" :com="com"></map-com-panel1>'+
				'<map-com-panel2 :prop="prop" :com="com"></map-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted map panel");
		}
	});
	/**************地图组件--编辑1******************/
	var mapComPanel1 = Vue.component('map-com-panel1',{
		props:['prop', 'com'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      	'<span style="font-size:20px">定位地址：</span><input type="text" style="font-size:20px;height:40px" :value="prop.bindPlace" v-model="prop.bindPlace"></input>'+
      		'<span @click="onClickLoc()" style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" :id="\'ID_editPanel1_\'+prop.id+\'_changeimg\'">定位</span>'+
      	'</div>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<span style="font-size:20px">文字：</span><input type="text" :value="prop.text" v-model="prop.text" style="height:40px;font-size:20px"></input>'+
      	'</div>'+
      	'</div>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onClickLoc:function() {
    		this.prop.resolved = false;
    	}
		}
	});
	/**************地图组件--编辑2******************/
	var mapComPanel2 = Vue.component('map-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div>'+
			      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
			      			'<div>'+
			      				'<span style="font-size:20px;float:left;">宽：</span>'+
			      				'<select @change="onSelWidthMode($event)" style="height:40px;border-radius:5px;float:left;">'+
			      					'<option value="100">手机宽度</option>'+
			      					'<option value="fixed_width">固定宽度</option>'+
			      				'</select>'+
			      				'<div style="float:left;margin-left:20px" v-show="prop.styles.sizeStyle.width!=\'100%\'&&prop.styles.sizeStyle.width!=\'auto\'">宽度值：</div>'+
			      				'<div v-show="prop.styles.sizeStyle.width!=\'100%\'&&prop.styles.sizeStyle.width!=\'auto\'" class="my-spinner input-width-spinner" style="float:left;margin-left:10px;">'+
											'<div class="input-area">'+
												'<input class="input-width" input-style="font-size:20px"></input>'+
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
			      				'<span style="font-size:20px;float:left;">高：</span>'+
			      				'<div class="my-spinner input-height-val" style="float:left;margin-left:10px;">'+
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
									'<div class="my-spinner input-margin-left" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-left\'].substr(0,prop.styles.marginStyle[\'margin-left\'].length-2)"></input>'+
												'<span style="font-size:16px">px</span>'+
										'</div>'+
										'<div class="btn-area">'+
												'<div class="plus-btn"></div>'+
												'<div class="minus-btn"></div>'+
										'</div>'+
									'</div>'+
									'<div style="float:left;margin-left:20px;">上</div>'+
									'<div class="my-spinner input-margin-top" style="float:left;margin-left:10px;">'+
										'<div class="input-area">'+
											'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-top\'].substr(0,prop.styles.marginStyle[\'margin-top\'].length-2)"></input>'+
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
							'</div>'+
	      		'</div>'+
	      		'<div class="click-setting-title">文字设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_text_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_text_setting" style="padding-top:10px;padding-left:10px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
						'<font-setting-pane :prop="prop" :fontStyle="prop.styles.fontStyle" :alignStyle="prop.styles.alignStyle"></font-setting-pane>'+
						'<div style="clear:both;margin-bottom:10px;"></div>'+
					'</div>'+
	      	'</div>'+
     	 '</div>'+
     	'</div>',
      
    mounted:function() {
    	var that = this;
    	
    	$('.input-width-spinner').my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['width'] = val+'px';
			},maxValue:424,defaultValue:that.prop.styles.sizeStyle['width']=='100%'?'424':that.prop.styles.sizeStyle.width.substr(0,that.prop.styles.sizeStyle['width'].length-2)});
			
			$('.input-height-val').my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['height'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.sizeStyle.height.substr(0,that.prop.styles.sizeStyle['height'].length-2)});
			
			$('.input-margin-left').my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-left'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.marginStyle['margin-left'].substr(0,that.prop.styles.marginStyle['margin-left'].length-2)});
			
			$('.input-margin-top').my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-top'] = val+'px';
			},maxValue:1000,defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)});
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