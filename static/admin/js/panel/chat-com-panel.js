$(function() {
/****************聊天组件--编辑******************/
  var chatComPanel = Vue.component('chat-com-panel', {
		props:['prop'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>聊天组件</a>'+
				'</li><li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<chat-com-panel1 :prop="prop"></chat-com-panel1>'+
				'<chat-com-panel2 :prop="prop"></chat-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
		}
	});
	
	/****************聊天组件--编辑1******************/
	var chatComPanel1 = Vue.component('chat-com-panel1',{
		props:['prop'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div class="click-setting-title">聊天室绑定'+
      	'</div>'+
      	'<div  class="" style="font-size:20px;padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
      		'<div style="float:left">绑定方式</div>'+
					'<select style="height:40px;margin-left:10px;" @change="onChangeBind($event)">'+
						'<option value="none" :selected="prop.bindType==\'none\'">无</option>'+
						'<option value="livevideo" :selected="prop.bindType==\'livevideo\'">当前直播</option>'+
						'<option value="curr_page" :selected="prop.bindType==\'curr_page\'">当前页面</option>'+
						'<option value="custom" :selected="prop.bindType==\'custom\'">输入聊天室id</option>'+
					'</select>'+
					'<div style="clear:both;height:10px"></div>'+
					'<div v-show="prop.bindType==\'custom\'">'+
						'<span>请输入聊天室id：</span><input @input="onInputChatRoomID($event)" type="text" style="height:40px"></input>'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
					'<div style="float:left">绑定的聊天室id：</div>'+
					'<div style="float:left;margin-left:20px;">{{prop.chatRoomID}}'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
    		'</div>'+
    		'<div style="clear:both;height:10px"></div>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
	 
    methods:{
    	onInputChatRoomID:function(e) {
    		this.prop.chatRoomID = $(e.target).val();
    	},
    	onChangeBind:function(e) {
    		var val = $(e.target).val();
    		console.log(val);
    		if(val == "livevideo") {
    			var bFind = false;
    			for(var i = 0;i < g_page.coms.length;i++) {
    				if(g_page.coms[i].c_type == "livevideo-com") {
    					if(g_page.coms[i].prop.video.video_id) {
    						this.prop.chatRoomID = "vc-"+g_page.coms[i].prop.video.video_id;
    						bFind = true;
    					} else {
    						alert("直播视频组件尚未设置,请先设置");
    						this.prop.bindType = "none";
    						this.$forceUpdate();
    						return;
    					}
    				}
    			}
    			
    			if(!bFind) {
    				alert("没有添加直播视频组件，请先添加一个直播视频组件");
    				this.prop.bindType = "none";
    				this.$forceUpdate();
    				return;
    			}
    		} else if(val == "curr_page") {
    			this.prop.chatRoomID = "pc-"+g_curr_page;
    		} else if(val == "none") {
    			this.prop.chatRoomID = "";
    		}
    		this.prop.bindType = val;
    	},
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
	/****************聊天组件--编辑2******************/
	var chatComPanel2 = Vue.component('chat-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div style="float:left;font-size:20px;">背景颜色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="bk-color-input color-input"/>'+
							'</div>'+
							'<div style="clear:both;height:10px"></div>'+
							'<div style="float:left;font-size:20px;">我的消息背景色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="my-color-input color-input"/>'+
							'</div>'+
							'<div style="clear:both;height:10px"></div>'+
							'<div style="float:left;font-size:20px;">他人消息背景色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="other-color-input color-input"/>'+
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
			
			$(this.$el).find(".my-color-input").spectrum({
		    color: that.prop.styles.myColor,
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
  					that.prop.styles.myColor = val.toHexString();
  				} else {
  					that.prop.styles.myColor = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.myColor = val.toHexString();
  				} else {
  					that.prop.styles.myColor = 'transparent';
  				}
  			}
			});
			
			$(this.$el).find(".other-color-input").spectrum({
		    color: that.prop.styles.otherColor,
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
  					that.prop.styles.otherColor = val.toHexString();
  				} else {
  					that.prop.styles.otherColor = 'transparent';
  				}
  			},
  			hide:function(val) {
  				if(val) {
  					that.prop.styles.otherColor = val.toHexString();
  				} else {
  					that.prop.styles.otherColor = 'transparent';
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