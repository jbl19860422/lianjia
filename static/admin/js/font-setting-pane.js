$(function() {
	var fontSettingCom = Vue.component('font-setting-pane',{
		props:['prop','fontStyle','alignStyle','hide_align'],
		template:
		'<div class="edit-text">'+
  		'<div class="my-spinner input-font-size" style="float:left">'+
				'<div class="input-area">'+
					'<input style="font-size:20px" :value="fontStyle[\'font-size\'].substr(0,fontStyle[\'font-size\'].length-2)"></input>'+
						'<span style="font-size:16px">px</span>'+
				'</div>'+
				'<div class="btn-area">'+
					'<div class="plus-btn"></div>'+
					'<div class="minus-btn"></div>'+
				'</div>'+
			'</div>'+
			'<div class="divide-line"></div>'+
  		'<div :class="{\'my-btn\':true, \'btn-bold\':true,\'active-btn\':fontStyle[\'font-weight\']==\'bold\'}" @click="onClickBoldBtn()" style="float:left">'+
				'<span class="icon icon-bold" style="font-size:25px"></span>'+
			'</div>'+
			'<div :class="{\'my-btn\':true, \'btn-italic\':true,\'active-btn\':fontStyle[\'font-style\']==\'italic\'}" @click="onClickItalicBtn()" style="float:left">'+
				'<span class="icon icon-italic" style="font-size:25px"></span>'+
			'</div>'+
			'<div :class="{\'my-btn\':true, \'btn-decoration\':true,\'active-btn\':fontStyle[\'text-decoration\']==\'underline\'}" @click="onClickUnderlineBtn()" style="float:left;margin-right:5px;">'+
				'<span class="icon icon-underline" style="font-size:25px"></span>'+
			'</div>'+
			'<div class="divide-line"></div>'+
			'<div style="float:left">'+
				'<input type="text" class="color-input"/>'+
			'</div>'+
			'<div style="float:left;margin-left:15px;position:relative;margin-top:5px;" v-if="!hide_align">'+
				'<div class="align-select">'+
					'<span :class="{icon:true, \'icon-paragraph-left\':alignStyle[\'text-align\']==\'left\',\'icon-paragraph-right\':alignStyle[\'text-align\']==\'right\',\'icon-paragraph-center\':alignStyle[\'text-align\']==\'center\',\'select-type\':true}" ></span>'+
					'<div class="drop-btn" @click="onClickAlignBtn()"></div>'+
				'</div>'+
				'<ul class="align-list hide">'+
					'<li @click="selAlign(\'left\')"><span class="icon icon-paragraph-left"></span></li>'+
					'<li @click="selAlign(\'right\')"><span class="icon icon-paragraph-right"></span></li>'+
					'<li @click="selAlign(\'center\')"><span class="icon icon-paragraph-center"></span></li>'+
				'</ul>'+
			'</div>'+
			'<div style="float:left;margin-left:10px;position:relative;margin-top:5px;display:none">'+
				'<span style="font-size:20px">字体</span>'+
				'<select @change="onChangeFontFamily($event)" class="font-family-select">'+
					'<option value="sans-serif">sans-serif</option>'+
					'<option value="SimSun">宋体</option>'+
					'<option value="SimHei">黑体</option>'+
					'<option value="Microsoft YaHei">微软雅黑</option>'+
					'<option value="NSimSun">新宋体</option>'+
					'<option value="FangSong">仿宋</option>'+
					'<option value="KaiTi">楷体</option>'+
					'<option value="STHeiti">华文黑体</option>'+
				'</select>'+
			'</div>'+
  	'</div>',
  	mounted:function() {
  		var that = this;
  		$(this.$el).find(".color-input").spectrum({
			    color: that.fontStyle.color,
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
    					that.fontStyle.color = val.toHexString();
    				}
    			},
    			hide:function(val) {
    				if(val) {
    					that.fontStyle.color = val.toHexString();
    				}
    			}
			});
			
			$(this.$el).find('.input-font-size').my_spinner({change:function(val) {
				that.fontStyle['font-size'] = val+'px';
			},defaultValue:that.fontStyle['font-size'].substr(0,that.fontStyle['font-size'].length-2)});
			
			if(this.fontStyle['font-family']) {
				$(this.$el).find(".font-family-select").val(this.fontStyle['font-family']);
			}
  	},
		methods:{
			onChangeFontFamily:function(e) {
				var val = $(e.target).val();
				this.fontStyle['font-family'] = val;
			},
			selAlign:function(align) {
				var that = this;
				that.alignStyle['text-align'] = align;
				var alignList = $(this.$el).find(".align-list");
				alignList.addClass("hide");
			},
			onClickBoldBtn:function() {
				var that = this;
				if(that.fontStyle['font-weight'] == 'bold') {
					that.fontStyle['font-weight'] = 'normal';
				} else {
					that.fontStyle['font-weight'] = 'bold';
				}
			},
			onClickItalicBtn:function() {
				var that = this;
				if(that.fontStyle['font-style'] == 'italic') {
					that.fontStyle['font-style'] = 'normal';
				} else {
					that.fontStyle['font-style'] = 'italic';
				}
			},
			onClickUnderlineBtn:function() {
				var that = this;
				if(that.fontStyle['text-decoration'] == 'underline') {
					that.fontStyle['text-decoration'] = 'none';
				} else {
					that.fontStyle['text-decoration'] = 'underline';
				}
			},
			onClickAlignBtn:function() {
				var that = this;
				var alignList = $(this.$el).find(".align-list");
				if(alignList.hasClass("hide")) {
					alignList.removeClass("hide");
				} else {
					alignList.addClass("hide");
				}
			}
		}
	});
});