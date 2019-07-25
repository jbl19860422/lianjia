$(function() {
	var clickSettingCom = Vue.component('click-setting-com',{
		props:['action','pages','page_groups','acts'],
		template:
		'<div>'+
			'<div class="click-setting-title">点击设置</div>'+
			'<div class="click-setting-wrap" style="height:200px;border:1px solid #dadada;border-top:none;border-bottom-left-radius:10px;border-bottom-right-radius:10px;width:100%;position:relative;padding-top:20px;">'+
				'<div>'+
		  		'<ul class="setting-list" style="width:90%;margin-left:auto;margin-right:auto;height:40px;">'+
		  			'<li href=".none-setting" @click="onClickActBtn(\'none\')" v-bind:class="[\'none\', action.type==\'none\'?\'active\':\'\']">无</li>'+
		  			'<li href=".page_act-setting" @click="onClickActBtn(\'page\')" v-bind:class="[\'page\', action.type==\'page\'?\'active\':\'\']">打开页面</li>'+
		  			'<li href=".func-setting" @click="onClickActBtn(\'fun\')" v-bind:class="[\'fun\', action.type==\'fun\'?\'active\':\'\']">其他功能</li>'+
		  		'</ul>'+
		  		'<div class="setting-pane">'+
		  			'<div class="none-setting" ></div>'+
		    		'<div v-show="action.type==\'page\'" class="act-setting">'+
		    			'<div class="mg-h-10 mg-v-10 ft-20">链接至：'+
		    				'<select class="setting-opt" @change="onPageSettingChange($event)">'+
		    					'<option value="pre-page" :selected="action.subtype==\'pre-page\'?\'selected\':\'\'">后退</option>'+
		    					'<option value="custom-link" :selected="action.subtype==\'custom-link\'?\'selected\':\'\'">自定义链接</option>'+
		    					'<optgroup :label="page_group.group_name" v-for="page_group in page_groups">'+
		    						'<option v-for="page in pages" v-if="page.group_id==page_group.group_id" :value="page.page_id" v-html="page.page_name" :selected="action.subtype==\'my-page\'&&action.param==page.page_id?\'selected\':\'\'"></option>'+
		    					'</optgroup>'+
								'</select>'+
								'<div v-if="action.type==\'page\'&&action.subtype==\'custom-link\'" style="margin-top:10px">链接地址：<input type="text" style="border-radius:4px !important;height:40px;" v-model="action.param" ></input></div>'+
							'</div>'+
		    		'</div>'+
		    		'<div v-if="action.type==\'fun\'" class="act-setting">'+
		    			'<div class="mg-h-10 mg-v-10 ft-20">调用功能：'+
		    				'<select class="setting-opt" v-model="action.subtype">'+
		    					'<option value ="dial">拨打电话</option>'+
		    					'<option value ="refresh">刷新页面</option>'+
		    					'<option value ="act">参与活动</option>'+
		    				'</select>'+
		    				'<div v-if="action.subtype==\'dial\'" class="dial-phone-num" style="margin-top:10px">电话号码：<input class="phone-num" type="text" style="border-radius:4px !important;height:40px;" v-model="action.param" ></input></div>'+
		    				'<div v-if="action.subtype==\'act\'" class="dial-phone-num" style="margin-top:10px">选取活动：'+
		    					'<select v-model="action.param">'+
		    						'<option v-for="act in acts" v-html="act.act_name+(act.act_type==0?\'(赠送活动)\':\'(抽奖活动)\')" :value="act.act_id"></option>'+
		    					'</select>'+
		    				'</div>'+
		    			'</div>'+
		    		'</div>'+
		    	'</div>'+
		  	'</div>'+
			'</div>'+
		'</div>',
		methods:{
			onPageSettingChange:function(e) {
				val = $(e.target).val();
				console.log(val);
				if(val == "pre-page") {
					this.action.subtype = "pre-page";
					this.action.param = "";
				} else if(val == "custom-link") {
					this.action.subtype = "custom-link";
					this.action.param = "";
					console.log(this.action);
				} else {
					this.action.subtype = "my-page";
					this.action.param = val;
				}
				
				this.$forceUpdate();
			},
			onClickActBtn:function(act) {
				var that = this;
				if(act == 'none' && that.action.type != act) {
					that.action.type = 'none';
					that.action.param = '';
				} else if(act == 'page' && that.action.type != act) {
					that.action.type = 'page';
					that.action.param = "";
				} else if(act == 'fun' && that.action.type != act) {
					that.action.type = 'fun';
					that.action.subtype = 'dial';
					that.action.param = "";
				}
			}
		}
	});
});