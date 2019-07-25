$(function() {
/****************直播视频组件--编辑******************/
  var videolistComPanel = Vue.component('videolist-com-panel', {
		props:['prop','channels','topics','videocates','pages', 'page_groups'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>视频列表组件</a>'+
				'</li><li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<videolist-com-panel1 :prop="prop" :channels="channels" :topics="topics" :videocates="videocates" :pages="pages" :page_groups="page_groups"></videolist-com-panel1>'+
				'<videolist-com-panel2 :prop="prop"></videolist-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
		}
	});
	/****************直播视频组件--编辑1******************/
	var videolistComPanel1 = Vue.component('videolist-com-panel1',{
		props:['prop','channels','topics','videocates','pages', 'page_groups'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div class="click-setting-title">列表绑定'+
      	'</div>'+
      	'<div  class="" style="font-size:20px;padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
      		'<div style="float:left">绑定数据选择</div>'+
					'<div style="float:left;margin-left:20px;">'+
						'<select v-model="prop.bind" style="height:40px;border-radius:10px">'+
							'<option value="">无</option>'+
							'<option value="channel">频道</option>'+
							'<option value="topic">专题</option>'+
							'<option value="custom">自定义视频类别</option>'+
						'</select>'+
					'</div>'+
					'<div style="clear:both;height:10px"></div>'+
					'<div v-if="prop.bind==\'channel\'">'+
						'<div style="float:left">频道选择</div>'+
						'<div style="float:left;margin-left:20px;">'+
							'<select v-model="prop.bind_param" style="min-width:150px;height:40px;border-radius:10px;">'+
								'<option value="">无</option>'+
								'<option v-for="channel in channels" v-html="channel.ch_name" :value="channel.ch_id"></option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div v-if="prop.bind==\'topic\'">'+
						'<div style="float:left">专题</div>'+
						'<div style="float:left;margin-left:20px;">'+
							'<select v-model="prop.bind_param" style="min-width:150px;height:40px;border-radius:10px;">'+
								'<option value="">无</option>'+
								'<option v-for="topic in topics" v-html="topic.topic_title" :value="topic.topic_id"></option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div v-if="prop.bind==\'custom\'">'+
						'<div style="float:left">自定义视频分类选择：</div>'+
						'<div style="float:left;margin-left:20px;">'+
							'<select v-model="prop.bind_param" style="min-width:150px;height:40px;border-radius:10px;">'+
								'<option value="">无</option>'+
								'<option v-for="cate in videocates" v-html="cate.cate_name" :value="cate.cate_id"></option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;"></div>'+
					'<div class="click-setting-wrap" style="width:100%;position:relative;padding-top:10px;">'+
						'<div style="font-size:20px">点击打开直播模板页：'+
      				'<select class="setting-opt" v-model="prop.link">'+
	    					'<optgroup :label="page_group.group_name" v-for="page_group in page_groups">'+
	    						'<option v-for="page in pages" v-if="page.group_id==page_group.group_id" :value="page.page_id" v-html="page.page_name"></option>'+
	    					'</optgroup>'+
							'</select>'+
						'</div>'+
	      	'</div>'+
	      	'<div style="clear:both;height:10px"></div>'+
    		'</div>'+
    		'<div style="clear:both;height:10px"></div>'+
      '</div>',
      
    mounted:function() {
    	var that = this;
    },
    watch:{
    	'prop.bind':function(val) {
    		this.prop.bind_param = '';
    	},
    	'prop.bind_param':function(val) {
    		var that = this;
    		if(this.prop.bind == 'channel') {
    			if(this.prop.bind_param == '') {
    				this.prop.videoList = [];
    			} else {
    				API.invokeCall('queryChannelVideo', {ch_id:this.prop.bind_param},function(json) {
    					that.prop.videoList = json.videoes;
    				});
    			}
    		} else if(this.prop.bind == "topic") {
    			if(this.prop.bind_param == '') {
    				this.prop.videoList = [];
    			} else {
    				API.invokeCall('queryTopicVideo', {topic_id:this.prop.bind_param},function(json) {
    					that.prop.videoList = json.videoes;
    				});
    			}
    		} else if(this.prop.bind == "custom") {
    			if(this.prop.bind_param == '') {
    				this.prop.videoList = [];
    			} else {
    				API.invokeCall('queryCateVideo', {cate_id:this.prop.bind_param},function(json) {
    					that.prop.videoList = json.videoes;
    				});
    			}
    		}
    	}
  	},
    methods:{
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
		}
	});
	/****************直播视频组件--编辑2******************/
	var videolistComPanel2 = Vue.component('videolist-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<div class="click-setting-title">组件设置<span @click="onClickCollapseBtn($event)" class="collapse-btn open-btn" href="#ID_com_setting"></span>'+
		      	'</div>'+
		      	'<div id="ID_com_setting" class="" style="padding-top:20px;padding-left:20px;border:1px solid rgb(218, 218, 218);border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-top:none">'+
		      		'<div style="float:left;font-size:20px;">背景颜色</div>'+
							'<div style="float:left;margin-left:20px;">'+
								'<input type="text" class="bkcolor-input color-input"/>'+
							'</div>'+
							'<div style="clear:both;height:10px"></div>'+
	      		'</div>'+
	      		'<div style="clear:both;height:10px"></div>'+
     	 		'</div>'+
     	'</div>',
      
    mounted:function() {
    	var that = this;
			$(this.$el).find(".bkcolor-input").spectrum({
		    color: that.prop.styles.bkColor['background-color'],
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
  				that.prop.styles.bkColor['background-color'] = val.toHexString();
  			},
  			hide:function(val) {
  				that.prop.styles.bkColor['background-color'] = val.toHexString();
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
    	},
		}
	});
});