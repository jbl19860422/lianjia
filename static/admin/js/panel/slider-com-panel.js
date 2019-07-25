$(function() {
/****************轮播图组件--编辑************/
	var sliderComPanel = Vue.component('slider-com-panel', {
		props:['prop','pages','page_groups','acts'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>轮播图组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<slider-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts"></slider-com-panel1>'+
				'<slider-com-panel2 :prop="prop"></slider-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	});
	/****************轮播图组件--编辑1******************/
	var sliderComPanel1 = Vue.component('slider-com-panel1',{
		props:['prop','pages','page_groups','acts'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-top:3px;text-align:center;">'+
      		'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-slider-item">添加轮播图</div>'+
      		'<div style="display:none" id="ID_uploadsliderImg"></div>'+
      	'</div>'+
      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;" class="slide-item">'+
      			'<div>'+
	      			'<div @click="onClickCollapseBtn($event)" style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;cursor:pointer;">'+
	      				'<div class="collapse-btn close-btn" style="display:inline-block;width:20px;"></div>'+
	      				'<span v-html="\'图片\'+index" style="margin-left:5px"></span>'+
	      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel($event,index)"></span>'+
	      			'</div>'+
	      			'<div class="btn-content hide" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
	      				'<span>图片</span>'+
	      				'<img :src="item.image" style="width:100px;height:auto;margin-left:10px;"></img>'+
	      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" @click="onChangeImg(item)" binded="false">更换图片</span>'+
	      				
	      				'<click-setting-com :action="item.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
				      	
	      			'</div>'+
	      		'</div>'+
      		'</li>'+
      	'</ul>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    	that.curr_index = 0;
	    //添加轮播图
	    $(this.$el).find(".add-slider-item").click(function() {
	    	that.prop.items.push(
	    		{
			      "clickUrl": "#",
			      "desc": "hxrj",
			      "image": "http://dummyimage.com/1745x492/40b7ea",
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
	    		$("#ID_uploadsliderImg").trigger('click');
	    	});
	    });
    },
    methods:{
    	onChangeImg:function(item) {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'image';
				g_piclistDlg.obj = item;
			},
			onClickCollapseBtn:function(e) {
				if($(e.target).find(".collapse-btn").hasClass('close-btn')) {
					$(e.target).find(".collapse-btn").removeClass('close-btn').addClass('open-btn');
					$(e.target).find(".collapse-btn").parent().siblings(".btn-content").removeClass('hide');
				} else {
					$(e.target).find(".collapse-btn").removeClass('open-btn').addClass('close-btn');
					$(e.target).find(".collapse-btn").parent().siblings(".btn-content").addClass('hide');
				}
			},
			onClickDel:function(e,index) {
				this.prop.items.splice(index, 1);
				e.stopPropagation();
			}
		}
	});
	/****************轮播图组件--编辑2******************/
	var sliderComPanel2 = Vue.component('slider-com-panel2',{
		props:['prop'],
		template:
      '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      	'<div style="margin-left:10px">'+
      		'<div>'+
      			'<div style="float:left">自动滚动</div>'+
      			'<div style="float:left;margin-left:10px;">'+
	      			'<select v-model="prop.auto_play">'+
	      				'<option value=true>是</option>'+
	      				'<option value=false>否</option>'+
	      			'</select>'+
	      		'</div>'+
      			'<div style="float:left;margin-left:10px;" v-show="prop.auto_play">播放间隔</div>'+
      			'<div style="float:left;margin-left:20px;" v-show="prop.auto_play">'+
	      			'<div class="my-spinner input-interval" style="display:inline-block">'+
								'<div class="input-area">'+
									'<input style="font-size:20px" :value="prop.interval"></input>'+
									'<span style="font-size:16px">秒</span>'+
								'</div>'+
								'<div class="btn-area">'+
										'<div class="plus-btn"></div>'+
										'<div class="minus-btn"></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both"></div>'+
      		'</div>'+
      		
      		'<div>'+
		    		'<div style="float:left">间距</div>'+
		    		'<div style="float:left;margin-left:30px;margin-right:10px;">上</div>'+
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
						'<div style="clear:both;"></div>'+
					'</div>'+
					
      		'<div style="margin-top:20px">'+
      			'<div style="float:left">显示标点</div>'+
      			'<div style="float:left;margin-left:10px;">'+
	      			'<select v-model="prop.showDot">'+
	      				'<option value="1">是</option>'+
	      				'<option value="0">否</option>'+
	      			'</select>'+
	      		'</div>'+
      			'<div style="clear:both"></div>'+
      		'</div>'+
      		'<div style="margin-top:20px" v-show="prop.showDot==1">'+
      			'<div style="float:left;">点颜色</div>'+
      			'<div style="float:left;margin-left:20px;">'+
							'<input type="text" class="figure-color-input color-input"/>'+
						'</div>'+
						'<div style="float:left;margin-left:20px;">标点形状</div>'+
      			'<div style="float:left;margin-left:20px;">'+
							'<select class="select-figure-type" @change="onChangeFigureType($event)" style="float:left;height:40px;border:1px sold #aaa;border-radius:5px">'+
								'<option value="dot">圆形</option>'+
								'<option value="rectangle">长条形</option>'+
							'</select>'+
						'</div>'+
      			'<div style="clear:both"></div>'+
      		'</div>'+
      		'<div style="margin-top:20px" v-if="prop.showDot==1">'+
      			'<!--<div style="float:left;margin-right:20px;">高度</div>'+
      			'<div style="float:left">'+
      				'<select style="height:40px;border-radius:5px;">'+
      					'<option value="auto">按图片比例</option>'+
      					'<option value="fixed_height">固定高度</option>'+
      				'</select>'+
      			'</div>-->'+
      			
      			'<div style="font-size:20px;margin-left:0px;">'+
							'<div style="float:left">位置</div>'+
							'<div style="float:left;margin-left:20px" class="position-btns">'+
								'<span :class="{\'active\':prop.figureAlign==\'left\'}" @click="setPos(\'left\')">置左</span>'+
								'<span :class="{\'active\':prop.figureAlign==\'center\'}" @click="setPos(\'center\')">居中</span>'+
								'<span :class="{\'active\':prop.figureAlign==\'right\'}" @click="setPos(\'right\')">置右</span>'+
							'</div>'+
						'</div>'+
      			'<div style="clear:both"></div>'+
      		'</div>'+
      	'</div>'+
      '</div>',
    mounted:function() {
    	var that = this;
    	$('.input-interval').my_spinner({change:function(val) {
					that.prop.interval= val;
				},defaultValue:that.prop.interval,minValue:1
			});
			
			$(this.$el).find(".input-margin-top").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-top'] = val+'px';
			},defaultValue:that.prop.styles.marginStyle['margin-top'].substr(0,that.prop.styles.marginStyle['margin-top'].length-2)});
			
			$(this.$el).find(".figure-color-input").spectrum({
			    color: that.prop.figureColor['background-color'],
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
    					that.prop.figureColor['background-color'] = val.toHexString();
    				}
    			},
    			hide:function(val) {
    				if(val) {
    					that.prop.figureColor['background-color'] = val.toHexString();
    				}
    			}
			});
    },
    methods:{
    	setPos:function(pos) {
    		this.prop.figureAlign = pos;
    	},
    	onChangeFigureType:function(e) {
    		this.prop.figureType = $(e.target).val();
    	}
    }
  });
});