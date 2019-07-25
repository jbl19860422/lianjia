$(function() {
/****************9宫格抽奖--编辑************/
	var lottery9ComPanel = Vue.component('lottery9-com-panel', {
		props:['prop','pages','page_groups','acts','items'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>9宫格抽奖</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<lottery9-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts" :items="items"></lottery9-com-panel1>'+
				'<lottery9-com-panel2 :prop="prop"></lottery9-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
		}
	});
	/****************9宫格抽奖--编辑1******************/
	var lottery9ComPanel1 = Vue.component('lottery9-com-panel1',{
		props:['prop','pages','page_groups','acts','items'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:16px;">'+
      	'<div style="font-size:16px;margin-left:10px">'+
      		'<span>活动选择</span>'+
      		'<select v-model="prop.act_id" style="max-width:90%;margin-left:10px;">'+
						'<option v-for="act in acts" v-if="act.act_type==\'1\'" v-html="act.act_name+(act.act_type==0?\'(赠送活动)\':\'(抽奖活动)\')" :value="act.act_id"></option>'+
					'</select>'+
      	'</div>'+
      	'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
      		'<span>末等奖图片</span>'+
      		'<img :src="prop.last_prize" style="border:1px solid #aaaaaa;height:100px;width:100px"></img>'+
      		'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" @click="onChangeLastPrizeImg()">更换图片</span>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:20px;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(prize,index) in prop.prizes" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;" class="slide-item" >'+
      			'<div>'+
	      			'<div style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;" @click="onClickCollapseBtn($event,index)">'+
	      				'<div :class="{\'collapse-btn\':true,\'close-btn\':curr_index!=index,\'open-btn\':curr_index==index}" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="\'奖品\'+(index+1)" style="margin-left:5px"></span>'+
	      			'</div>'+
	      			'<div :class="{\'btn-content\':true,hide:curr_index!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<span>选择</span>'+
	      				'<select v-model="prize.item_id" style="max-width:90%;margin-left:10px;" @change="onChangeItem(prize)">'+
	      					'<option value="">末等奖</option>'+
									'<option v-for="gift in gift_items" :value="gift.id" v-html="gift.name"></option>'+
								'</select>'+
	      			'</div>'+
	      		'</div>'+
      		'</li>'+
      	'</ul>'+
      '</div>',
    data:function() {
    	return {
    		curr_index:-1,
    		gift_items:[],
    	};
    },
    mounted:function() {
    	var that = this;
    	that.curr_index = 0;
    	console.log(that.items);
    },
    created:function() {
    	var that = this;		
    	if(!this.prop.act_id) {
    		return;
    	}
  		API.invokeCall('queryLotteryAct', {act_id:this.prop.act_id}, function(json) {
  			var gift_conf = JSON.parse(json.act.gift_conf);
  			for(var i = 0; i < gift_conf.length;  i++) {
  				var gift = gift_conf[i];
  				if(gift.type == 'item') {
  					for(var j = 0; j < that.items.length; j++) {
	  					if(that.items[j].item_id == gift.id) {
	  						gift.img = that.items[j].item_img;
	  						gift.name = that.items[j].item_name;
	  						gift.id = that.items[j].item_id;
	  						break;
	  					}
	  				}
  				}
  				that.gift_items.push(gift);
  			}
  		});
    },
    watch:{
    	'prop.act_id':function() {
    		var that = this;
    		that.gift_items = [];
    		for(var i = 0; i < that.prop.prizes.length; i++) {
    			that.prop.prizes[i].item_id = '';
    			that.prop.prizes[i].img = that.prop.last_prize;
    		}
    		
    		API.invokeCall('queryLotteryAct', {act_id:this.prop.act_id}, function(json) {
	  			var gift_conf = JSON.parse(json.act.gift_conf);
	  			for(var i = 0; i < gift_conf.length;  i++) {
	  				var gift = gift_conf[i];
	  				if(gift.type == 'item') {
	  					for(var j = 0; j < that.items.length; j++) {
		  					if(that.items[j].item_id == gift.id) {
		  						gift.img = that.items[j].item_img;
		  						gift.name = that.items[j].item_name;
		  						gift.id = that.items[j].item_id;
		  						break;
		  					}
		  				}
	  				}
	  				that.gift_items.push(gift);
	  			}
	  		});
    	}
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
    	onChangeItem:function(prize) {
    		if(prize.item_id == '') {
    			prize.img = this.prop.last_prize;
    			return;
    		}
    		for(var i = 0; i < this.gift_items.length; i++) {
    			if(prize.item_id == this.gift_items[i].id) {
    				prize.img = this.gift_items[i].img;
    				break;
    			}
    		}
    	},
    	
    	onChangeLastPrizeImg:function() {
    		g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'last_prize';
				g_piclistDlg.obj = this.prop;
    	},
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
			onClickDel:function(e,index) {
				this.prop.items.splice(index, 1);
				e.stopPropagation();
				e.preventDefault();
			}
		}
	});
	/****************9宫格抽奖--编辑2*******************/
	var lottery9ComPanel2 = Vue.component('lottery9-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div>'+
      		'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span></div>'+
		      '<div id="ID_com_setting" class="" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
	      		'<div>'+
	      			'<div style="margin-top:10px;margin-bottom:20px;margin-left:10px;">'+
			      		'<span>抽奖按钮图片</span>'+
			      		'<img :src="prop.lotBtn" style="border:1px solid #aaaaaa;height:100px;width:100px"></img>'+
			      		'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" @click="onChangeBtnImg()">更换图片</span>'+
			      	'</div>'+
		      		'<div style="padding-top: 10px; margin-left: 10px; font-size: 20px;">'+
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
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;"></div>'+
						'<div style="clear:both;margin-left:10px;">'+
							'<div style="padding-top: 10px; margin-left: 0px; font-size: 20px;">'+
								'<div style="float:left">背景色</div>'+
								'<div style="float:left;margin-left:20px;">'+
									'<input type="text" class="bkcolor-input color-input"/>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both;margin-bottom:10px"></div>'+
	    		'</div>'+
      	'</div>'+
      	
      	
      	
      	'<div class="click-setting-title">边框设置<span @click="onClickCollapseBtn($event)" class="collapse-btn close-btn" href="#ID_border_setting"></span></div>'+
    	'<div id="ID_border_setting" class="hide" style="border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
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
    	onChangeBtnImg:function() {
    		g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'lotBtn';
				g_piclistDlg.obj = this.prop;
    	},
    	onChangeBorderStyle:function(e) {
				this.prop.styles.borderStyle['border-style'] = $(e.target).val();
			},
			onChangeShadow:function(e) {
    		this.prop.styles.useShadow = !this.prop.styles.useShadow;
    		if(this.prop.styles.useShadow) {
    			$(e.target).attr("checked", "checked");
    		} else {
    			$(e.target).attr("checked", "");
    		}
    	}
    },
    mounted:function() {
    	var that = this;
    	
    	$(this.$el).find(".input-border-radius").my_spinner({change:function(val) {
					that.prop.styles.borderStyle['border-radius'] = val+'px';
				},maxValue:500,
				defaultValue:that.prop.styles.borderStyle['border-radius'].substr(0,that.prop.styles.borderStyle['border-radius'].length-2)
			});
			
			$(this.$el).find(".input-border-width").my_spinner({change:function(val) {
				that.prop.styles.borderStyle['border-width'] = val+'px';
			},defaultValue:that.prop.styles.borderStyle['border-width'].substr(0,that.prop.styles.borderStyle['border-width'].length-2)});
			
			$(this.$el).find(".border-color-input").spectrum({
		    color: that.prop.styles.borderStyle['border-color'],
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
  				that.prop.styles.borderStyle['border-color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.borderStyle['border-color'] = val.toHexString();
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
    }
  });
});