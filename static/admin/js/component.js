
$(function() {
	var marginCom = Vue.component('margin-com', {
		props:['prop'],
		template:'<div :style="prop.styles.marginStyle" class="margin-com"></div>'
	});
	
	g_phoneRoot = Vue.component('phone-root', {
		props:['coms', 'curr_com_id', 'phone_size', 'phone_pos','curr_page','items','host_url'],
		template:
		'<div class="phone-root" style="margin-left:3rem;" id="componentList" @click="onClickRoot()" @mousemove="onMouseMove($event)" @mouseup="onMouseUp($event)">'+
				'<img src="http://o95rd8icu.bkt.clouddn.com/phonetop.png" style="width:100%;height:auto"></img>'+
				'<div class="phone-content droppable-target" :style="[{width:\'100%\',height:\'100%\',padding:\'1px solid #666\',\'overflow-y\':\'auto\',\'border-left\':\'1px solid #666\',\'border-right\':\'1px solid #666\',background:curr_page.background}]">'+
					'<div id="phone-component-list" class="list-group" style="margin:0px" v-if="coms.length>0">'+
					  '<template v-for="com in coms" :curr_com_id="curr_com_id" @click="onClickRoot()">'+
					  	'<component :is="com.c_type" :items="items" :prop="com.prop" :curr_com_id="curr_com_id" :phone_size="phone_size" :phone_pos="phone_pos" :coms="coms" :com="com" @delCom="delCom" @onMouseDownMoveHandle="onRootMouseDownMoveHandle" :host_url="host_url"></component>'+
					  '</template>'+
					'</div>'+
					 '<div style="display:table;height:100%;width:100%;" v-if="coms.length==0">'+
				  	'<div style="display:table-cell;vertical-align:middle;font-size:25px;text-align:center;">'+
				  		'请拖动组件到这里或点击添加组件'+
				  	'</div>'+
				  '</div>'+
	    	'</div>'+
	    	'<img src="http://o95rd8icu.bkt.clouddn.com/phonebottom.png" style="width:100%;height:auto;border-top:1px solid #666"></img>'+
	    	'<div class="history-btns" style="height:40px;width:100%;display:none;">'+
					'<div style="font-size:1.5rem;color:#ce0000;position:absolute;left:30%;cursor:pointer;" title="回退一步" @click="goBack()"><span class="icon icon-previous2" style="font-size:inherit"></span>回退</div>'+
					'<div style="font-size:1.5rem;color:#ce0000;position:absolute;right:30%;cursor:pointer;" title="前进一步" @click="goForward()">前进<span class="icon icon-next2"  style="font-size:inherit"></span></div>'+
				'</div>'+
		  '</div>',
		  components:{
		  },
		  mounted:function() {
		  },
		  methods:{
		  	onRootMouseDownMoveHandle:function(e, prop) {
		  		this.startDragPos = {
		  			top:e.pageY,
		  			left:e.pageX
		  		};
		  		this.dragging = true;
		  		this.draggingProp = prop;
		  	},
		  	onClickRoot:function() {
		  	},
		  	delCom:function(id) {
		  		for(var i = 0;i < this.coms.length; i++) {
		  			if(this.coms[i].prop.id == id) {
		  				this.coms.splice(i,1);
		  				break;
		  			}
		  		}
		  	},
		  	onMouseMove:function(e) {
		  		var mousePos = {
		  			left:e.pageX,
		  			top:e.pageY
		  		};
					
		  		if(this.dragging) {
		  			if(this.draggingProp.floatbtn) {
		  				var movedSize = {
		  					x:e.pageX - this.startDragPos.left,
		  					y:e.pageY - this.startDragPos.top
		  				};
		  				this.startDragPos.left = e.pageX;
		  				this.startDragPos.top = e.pageY;
		  				this.draggingProp.styles.orgPos.left += movedSize.x;
		  				this.draggingProp.styles.orgPos.top += movedSize.y;
		  				return;
		  			}
		  		}	
		  	},
		  	onMouseUp:function(e) {
		  		console.log("mouseup***********", this.dragging);
		  		if(this.dragging) {
		  			if(this.draggingProp.floatbtn) {
		  				this.dragging=false;
		  				this.draggingProp.styles.alphaStyle.opacity = this.draggingProp.styles.opacity;
		  				return;
		  			}
		  		}
			  },
			  goBack:function() {
//			  	if(g_iCurrStep > 0) {
//						g_iCurrStep--;
//						g_page.coms = g_steps[g_iCurrStep];
//					}
			  },
			  goForward:function() {
//			  	if(g_iCurrStep <= g_steps.length-2) {
//						g_iCurrStep++;
//						g_page.coms = g_steps[g_iCurrStep];
//					}
			  }
		  }
	});
});