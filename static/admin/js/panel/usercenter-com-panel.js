$(function() {
/**************图片组件--编辑******************/
  var	usercenterComPanel = Vue.component('usercenter-com-panel', {
		props:['prop','page_groups', 'pages', 'acts','items'],
		template:
		'<div class="col-md-12 col-lg-12 col-sm-12">'+
			'<ul class="nav nav-tabs">'+
				'<li class="active" style="width:50%;">'+
					'<a data-tab :href="\'#ID_editPanel1_\'+prop.id" ><i class="icon  icon-book"></i>个人中心</a>'+
				'</li>'+
				'<li style="width:50%">'+
					'<a data-tab :href="\'#ID_editPanel2_\'+prop.id"><i class="icon icon-coffee"></i>组件样式</a>'+
				'</li>'+
			'</ul>'+
			'<div class="tab-content" style="background-color:#f6f6f6;border-bottom-left-radius:10px;border-bottom-right-radius:10px;">'+
				'<usercenter-com-panel1 :prop="prop" :pages="pages" :page_groups="page_groups" :acts="acts" :items="items"></usercenter-com-panel1>'+
				'<usercenter-com-panel2 :prop="prop"></usercenter-com-panel2>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</div>',
		mounted:function() {
			console.log("mounted pic panel");
		}
	});
	/**************个人中心--编辑1******************/
	var usercenterComPanel1 = Vue.component('usercenter-com-panel1',{
		props:['prop','pages', 'page_groups', 'acts','items'],
		template:
      '<div class="tab-pane active" :id="\'ID_editPanel1_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
      	'<div style="width:80%;height:100%;font-size:20px;color:white;background-color:#efbf1f;text-align:center;line-height:40px;margin-left:auto;margin-right:auto;cursor:pointer;border-radius:8px;" class="add-pictxt-set-item">添加一行</div>'+
      	'<div style="display:none" id="ID_uploadPicTxtSetImg"></div>'+
	      	'<ul style="width:80%;margin-left:auto;margin-right:auto;margin-top:20px;">'+
	      		'<li v-for="(item,index) in prop.items" style="margin-left:auto;margin-right:auto;margin-top:20px;cursor:pointer;"   class="slide-item">'+
	      			'<div>'+
		      			'<div @click="onClickCollapseBtn($event,index)" style="width:100%;line-height:40px;height:40px;border:1px solid #ddd;border-top-left-radius:8px;border-top-right-radius:8px;">'+
		      				'<div :class="{\'collapse-btn\':true,\'close-btn\':curr_index!=index,\'open-btn\':curr_index==index}" style="display:inline-block;width:20px;"></div>'+
		      				'<span v-html="\'第\'+index+\'行\'" style="margin-left:5px"></span>'+
		      				'<span class="icon icon-bin" style="float:right;margin-right:10px;font-size:20px;margin-top:10px;cursor:pointer" @click="onClickDel(index)"></span>'+
		      			'</div>'+
		      			'<div :class="{\'btn-content\':true, hide:curr_index!=index}" style="border:1px solid #ddd;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:20px;padding-left:20px;padding-bottom:20px;border-top:none">'+
			      			'<div v-if="item.type!=\'sys\'" style="margin-bottom:10px">'+
				      			'<span style="margin-right:10px">类型</span>'+
				      			'<select v-model="item.type">'+
				      				'<option value="item">显示虚拟物品数量</option>'+
				      				'<option value="page">链接到页面</option>'+
				      			'</select>'+
				      		'</div>'+
		      				'<div style="margin-bottom:10px"><span>标题</span>'+
		      				'<input v-model="item.title" style="margin-left:20px" type="text" :value="item.title"></input></div>'+
		      				'<span>图标</span>'+
		      				'<img :src="item.icon" style="width:100px;height:auto;margin-left:10px;"></img>'+
		      				'<span style="font-size:20px;color:rgb(239, 191, 31);margin-left:10px;cursor:pointer;" class="upload-btn" @click="onChangeImg(item)">更换图标</span>'+
		      				'<click-setting-com v-if="item.type==\'page\'" :action="item.action" :pages="pages" :page_groups="page_groups" :acts="acts"></click-setting-com>'+
		      				'<div v-if="item.type==\'item\'" style="margin-bottom:10px;margin-top:10px;">'+
				      			'<span style="margin-right:10px">物品选择</span>'+
				      			'<select v-model="item.item_id" style="min-width:100px">'+
				      				'<option v-for="it in items" :value="it.item_id" v-html="it.item_name"></option>'+
				      			'</select>'+
				      		'</div>'+
		      			'</div>'+
		      		'</div>'+
	      		'</li>'+
	      	'</ul>'+
      '</div>',
    data:function(){
    	return {
    		curr_index:0
    	};
    },
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onChangeImg:function(item) {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'icon';
				g_piclistDlg.obj = item;
			},
			onClickCollapseBtn:function(e,index) {
				if(this.curr_index == index) {
					this.curr_index = -1;
				} else {
					this.curr_index = index;
				}
			},
			onClickDel:function(index) {
				if(this.prop.items[index].type=='sys') {
					alert('系统生成，请勿删除');
					return;
				}
				this.prop.items.splice(index, 1);
			}
		}
	});
	/**************图片组件--编辑2******************/
	var usercenterComPanel2 = Vue.component('usercenter-com-panel2',{
		props:['prop'],
		template:
       '<div class="tab-pane" :id="\'ID_editPanel2_\'+prop.id" style="background-color:#f6f6f6;text-align:left;">'+
	      	'<div>'+
		      	'<img :src="prop.bkimg" style="border:1px solid #aaaaaa;height:100px;width:auto"></img>'+
	      		'<span style="color:#efbf1f;margin-left:20px;font-size:20px;cursor:pointer" class="change-img" @click="onChangeImg()">更换背景图片</span>'+
		      '</div>'+
		      '<div style="clear:both"></div>'+
     	 '</div>',
      
    mounted:function() {
    	var that = this;
    },
    methods:{
    	onChangeImg:function() {
				g_piclistDlg.show = true;
				g_piclistDlg.imgPro = 'bkimg';
				g_piclistDlg.obj = this.prop;
			}
		}
	});
});