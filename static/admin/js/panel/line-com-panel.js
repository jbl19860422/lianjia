$(function() {
/**************按钮组件--编辑***************/
	 var lineComPanel = Vue.component('line-com-panel', {
		props:['prop'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>分割线组件</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<line-com-panel1 :prop="prop"></line-com-panel1>'+
				'<line-com-panel2 :prop="prop"></line-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>'
	 });
	/**************按钮组件--编辑1*****************/
	 var lineComPanel1 = Vue.component('line-com-panel1',{
		props:['prop'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
      '</div>'
	});
	/**************按钮组件--编辑2*****************/
	var lineComPanel2 = Vue.component('line-com-panel2',{
		props:['prop'],
		template:
		'<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;font-size:20px;">'+
			'<div>'+
				'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		  	'</div>'+
			  '<div id="ID_com_setting" style="font-size:20px;color:#666;padding-top:20px;padding-left:10px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;border:1px solid #aaaaaa">'+
			    '<div>'+
						'<div style="float:left;margin-left:20px;margin-right:10px;">高</div>'+
						'<div class="my-spinner input-btn-height" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.sizeStyle[\'height\'].substr(0,prop.styles.sizeStyle[\'height\'].length-2)"></input>'+
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
		    		'<div style="float:left;margin-left:20px;">间距</div>'+
		    		'<div style="float:left;margin-left:30px;margin-right:10px;">左</div>'+
		    		'<div class="my-spinner input-margin-left" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-left\'].substr(0,prop.styles.marginStyle[\'margin-left\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
						'<div style="float:left;margin-left:20px;margin-right:10px;">右</div>'+
						'<div class="my-spinner input-margin-right" style="float:left">'+
							'<div class="input-area">'+
								'<input style="font-size:20px" :value="prop.styles.marginStyle[\'margin-right\'].substr(0,prop.styles.marginStyle[\'margin-right\'].length-2)"></input>'+
									'<span style="font-size:16px">px</span>'+
							'</div>'+
							'<div class="btn-area">'+
									'<div class="plus-btn"></div>'+
									'<div class="minus-btn"></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					
					'<div style="clear:both;margin-bottom:20px;height:40px;">'+
						'<div style="padding-top: 20px;; font-size: 20px;">'+
							'<div style="float:left;font-size:20px;margin-left:20px;">背景</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="bkcolor-input color-input"/>'+
							'</div>'+
						'</div>'+
					'</div>'+
			  '</div>'+
	    '</div>'+
		'</div>',
		mounted:function() {
			var that = this;
				
			$(this.$el).find(".input-btn-height").my_spinner({change:function(val) {
				that.prop.styles.sizeStyle['height'] = val+'px';
			},defaultValue:that.prop.styles.sizeStyle['height'].substr(0,that.prop.styles.sizeStyle['height'].length-2)});
			
			$(this.$el).find(".input-margin-left").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-left'] = val+'px';
			},defaultValue:that.prop.styles.marginStyle['margin-left'].substr(0,that.prop.styles.marginStyle['margin-left'].length-2)});
			
			$(this.$el).find(".input-margin-right").my_spinner({change:function(val) {
				that.prop.styles.marginStyle['margin-right'] = val+'px';
			},defaultValue:that.prop.styles.marginStyle['margin-right'].substr(0,that.prop.styles.marginStyle['margin-right'].length-2)});
			
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
    				that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
    			},
    			hide:function(val) {
    				that.prop.styles.bkcolorStyle['background-color'] = val.toHexString();
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
			}
		}
	});
});