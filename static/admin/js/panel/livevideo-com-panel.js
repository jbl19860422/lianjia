$(function() {
/****************直播视频组件--编辑******************/
  var livevideoComPanel = Vue.component('livevideo-com-panel', {
		props:['prop'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>直播视频组件</a>'+
				'</li><li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<livevideo-com-panel1 :prop="prop"></livevideo-com-panel1>'+
				'<livevideo-com-panel2 :prop="prop"></livevideo-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
		}
	});
	/****************直播视频组件--编辑1******************/
	var liveviceoComPanel1 = Vue.component('livevideo-com-panel1',{
		props:['prop'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-carousel-item" @click="onChooseVideo()">选取我的直播</div>'+
      	'</div>'+
      	'<div class="click-setting-title">直播绑定信息'+
      	'</div>'+
      	'<div  class="" style="font-size:20px;padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
      		'<div style="float:left">直播标题</div>'+
					'<div style="float:left;margin-left:20px;" v-html="prop.video.title">'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
					'<div style="float:left">预约时间</div>'+
					'<div style="float:left;margin-left:20px;">{{prop.video.start_time | formatTime}}'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
    		'</div>'+
    		'<div style="clear:both;height:10px"></div>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onChooseVideo:function() {
    		g_myvideo.currSelIndex = -1;
    		g_myvideo.show = true;
    	},
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
				} else if(act == 'page_act' && that.prop.action.type != act) {
					that.prop.action.type = 'page_act';
					that.prop.action.detail = {};
					$("#ID_editPanel1_"+that.prop.id+" .setting-list .page_act").addClass('active').siblings().remove('active');
					
					$("#ID_editPanel1_"+that.prop.id+" .page_act-setting").removeClass('hide').siblings().addClass('hide');
				} else if(act == 'fun_act' && that.prop.action.type != act) {
					that.prop.action.type = 'fun_act';
					that.prop.action.subtype = 'dial';
					that.prop.action.detail = {};
					$("#ID_editPanel1_"+that.prop.id+" .setting-list .fun_act").addClass('active').siblings().remove('active');
					
					$("#ID_editPanel1_"+that.prop.id+" .fun_act-setting").removeClass('hide').siblings().addClass('hide');
				}
			},
			onPhoneChange:function(e) {
				var input = $(e.target);
			}
		}
	});
	/****************直播视频组件--编辑2******************/
	var livevideoComPanel2 = Vue.component('livevideo-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div style="float:left">主题颜色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="video-color-input color-input"/>'+
							'</div>'+
							'<div style="clear:both;height:10px"></div>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
     	 		'</div>'+
     	'</div>',
      
    mounted:function() {
    	var that = this;

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
			
			
			$(this.$el).find(".video-color-input").spectrum({
		    color: that.prop.styles.videoColor,
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
  					that.prop.styles.videoColor = val.toHexString();
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.videoColor = val.toHexString();
  				}
  			}
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
					this.prop.styles.sizeStyle.width="100%";
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