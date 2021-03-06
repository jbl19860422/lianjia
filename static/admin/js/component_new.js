//浮动按钮组件--实现
$(function() {
	var goodsItem = Vue.component('goods-item', {
		props:['prop','goods'],
		template:
		'<li>'+
			'<a href="javascript:" class="g-pic">'+
				'<img :src="goods?goods.goods_img:\'http://oeu8cw34d.bkt.clouddn.com/default.png\'" width="136px" height="136px">'+
			'</a>'+
			'<p class="g-name">{{goods?goods.goods_name:"商品名称"}}（{{goods?goods.goods_desc:"商品描述"}}）</p>'+
			'<p class="gray9" style="text-align:left;margin:0px;padding:0px;">单价:￥{{goods?goods.goods_price:"商品价格"}}</p>'+
			'<div class="btn-wrap"　style="text-align:center;">'+
				'<a href="" class="buy-btn" :style="[{\'margin-left\':\'auto\',\'margin-right\':\'auto\',color:prop.styles.btnColor,\'border-color\':prop.styles.btnColor}]">{{prop.buy_btn_name}}</a>'+
				'<div goods_id="" v-if="prop.showCart" class="put-cart" style="background:url(http://o95rd8icu.bkt.clouddn.com/cart_w.png) no-repeat center;background-size:25px;background-color:#f60;position:absolute;top:-4px;left:105px;border:1px solid #f60;width:35px;height:35px;border-radius:100%;"></div>'+
			'</div>'+ 
		'</li>'
	});
	
	var goodsListCom = Vue.component('goodslist-com', {
		props:['prop','curr_com_id', 'curr_sel_id'],
		template:
		'<ul class="goods-list clearfix phone-component" @click="onClick($event)" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :style="[ prop.styles.alphaStyle,prop.styles.positionStyle,!prop.inNormalPanel?prop.styles.posStyle:{}]">'+
			'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" @click="clickDel($event)" style="z-index:1001">×</span></div>'+
			'<goods-item v-for="goods in prop.goodsList" :goods="goods" :prop="prop"></goods-item>'+
			'<goods-item v-if="prop.goodsList.length<=0" :goods="null" :prop="prop"></goods-item>'+
			'<goods-item v-if="prop.goodsList.length<=1" :goods="null" :prop="prop"></goods-item>'+
		'</ul>',
		methods:{
			clickDel:function(e) {
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
			},
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
		}
	});
	
	Vue.filter("formatStatus", function(value) {   //全局方法 Vue.filter()
    if(value == 0) {
    	return '预约';
    } else if(value == 1) {
    	return '直播中';
    } else if(value == 2) {
    	return '直播结束';
    } else if(value == 3) {
    	return '录播';
    } else if(value == 4) {
    }
  });
  
  Vue.filter("formatDuration", function(val) {
  	function add0(v) {
  		if(v < 10) {
  			return '0'+v;
  		} else {
  			return v;
  		}
  	}
  	var h = Math.round(val/3600);
  	var min = Math.round((val%3600)/60);
  	var sec = val%60;
  	return add0(h)+":"+add0(min)+":"+add0(sec);
  });
	    
	var videoItem = Vue.component('video-item', {
		props:['prop','video'],
		template:
			'<li style="margin:10px;text-align:left;border-bottom:1px solid #ccc;padding-bottom:10px;" class="video-item">'+
				'<div class="video-cover" style="display:inline-block;width:40%;position:relative">'+
					'<img :src="video?video.cover_img:\'http://o95rd8icu.bkt.clouddn.com/o_1bipsgde51rtf2k41one10nl1bqb7.jpg\'" style="width:100%;height:auto;border-radius:5px;">'+
					'<div style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;background:rgba(0,0,0,0.4);border-radius:5px;"></div>'+
					'<div class="icon icon-play2" style="position:absolute;left:50%;top:50%;margin-left:-20px;margin-top:-20px;font-size:40px;color:#fff"></div>'+
					'<div v-if="video" class="video-status" :status="video.live_status"><span class="icon icon-clock" v-if="video.live_status==3">{{video.duration|formatDuration}}</span><span v-else="video.live_status!=3">{{video.live_status|formatStatus}}</span></div>'+
				'</div>'+
				'<div style="display:inline-block;width:50%;vertical-align:top;margin-top:0.5rem;margin-left:1rem;">'+
					'<div style="font-size:1.8rem;word-break: break-word; word-wrap: break-word;">{{video?video.title:"视频名称"}}<p style="font-size:0.8rem;color:#666;margin:0px;">观看需：一张《观看我的直播》门票</p></div>'+
					'<div style="font-size:1.5rem;margin:0px;"><span class="icon icon-eye"></span><span style="margin-left:0.5rem">999</span></div>'+
				'</div>'+
			'</li>',
	});
	
	var videoListCom = Vue.component('videolist-com', {
		props:['prop','curr_com_id','curr_sel_id'],
		template:
		'<div class="videolist clearfix phone-component" :style="[prop.styles.alphaStyle,prop.styles.positionStyle,!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.bkColor]" @click="onClick($event)" @mouseover="onMouseOver($event)" @mouseout="onMouseOut($event)" :id="prop.id">'+
			'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" @click="clickDel($event)" style="z-index:1001">×</span></div>'+
			'<video-item v-for="video in prop.videoList" :video="video" :prop="prop"></video-item>'+
			'<video-item v-if="prop.videoList.length<=0" :video="null" :prop="prop"></video-item>'+
			'<video-item v-if="prop.videoList.length<=1" :video="null" :prop="prop"></video-item>'+
		'</div>',
		methods:{
			clickDel:function(e) {
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
			},
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				alert(this.prop.pid);
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		}
	});
	var floatBtnCom = Vue.component('floatbtn-com', {
		props:['prop', 'phone_pos', "curr_com_id"],
		template: '<div :id="prop.id" :class="{\'floatbtn-com\':true,\'phone-component\':true}" c-type="floatbtn" @mouseover="onMouseOver()" @mousedown="onMouseDown($event)" @click="onClick($event)" @mouseout="onMouseOut()" :index="prop.index" :style="[{left:prop.styles.orgPos.left+phone_pos.left+\'px\'},{top:prop.styles.orgPos.top+phone_pos.top+\'px\'},{position:\'fixed\',\'z-index\':1000},prop.styles.sizeStyle,prop.styles.alphaStyle, prop.styles.cursorStyle,prop.styles.animateStyle]">'+
			'<div :style="[{position:\'relative\'}, prop.styles.bkcolorStyle,prop.styles.paddingStyle]">'+
				'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" @click="clickDel($event)" style="z-index:1001">×</span></div>'+
				'<img :src="prop.imgSrc" :style="[prop.styles.borderStyle]"></img>'+	
			'</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					
					this.$forceUpdate();
				}
			}
		},
		methods:{
			onMouseDown:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.floatbtn = true;
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.alphaStyle.opacity = 0.5;
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			},
			onClick:function(e){
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		}
	});
	
	/******************文本组件--实现**************/
	var textCom = Vue.component('text-com', {
		props:['prop','curr_com_id', 'curr_sel_id'],
		template: '<div :id="prop.id" :class="{\'sortable-item\':!prop.inFreePanel, \'phone-component\':true}" :style="[{width:\'100%\'},!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.transformStyle, prop.styles.animateStyle,prop.inFreePanel?prop.styles.sizeStyle:{},prop.styles.lhStyle,prop.styles.marginStyle, prop.styles.alphaStyle,prop.styles.positionStyle,prop.styles.bkcolorStyle,prop.styles.borderStyle, prop.styles.cursorStyle,prop.styles.useShadow?prop.styles.shadowStyle:{}]" c-type="text" v-on:click="onClick($event)" v-on:mouseover="onMouseOver()" v-on:mouseout="onMouseOut()" v-bind:index="prop.index">'+
		'<div class="control-wrap" v-show="((prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id))"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div><div class="text" v-html="prop.text" :style="[prop.styles.fontStyle, prop.styles.alignStyle,prop.styles.paddingStyle]"></div>'+
		'</div>',
		mounted:function() {
			var that = this;
			
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
				
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					
					this.$forceUpdate();
				}
			}
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				
				e.preventDefault();
	      e.stopPropagation();
			},
		}
	});
	
	/******************地图组件--实现**************/
	var mapCom = Vue.component('map-com', {
		props:['prop','curr_com_id','curr_sel_id'],
		template: '<div :id="prop.id" :class="{\'sortable-item\':!prop.inFreePanel, \'phone-component\':true}" :style="[{width:\'100%\'},!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.sizeStyle,prop.styles.marginStyle, prop.styles.alphaStyle,prop.styles.positionStyle,prop.styles.cursorStyle]" c-type="map-com" v-on:click="onClick($event)" v-on:mouseover="onMouseOver()" v-on:mouseout="onMouseOut()" v-bind:index="prop.index"><div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div><div style="width:100%;height:100%" :id="\'map-\'+prop.id"></div>'+
			'<div class="text" v-html="prop.text" :style="[prop.styles.fontStyle, prop.styles.alignStyle,prop.styles.paddingStyle]"></div>'+
		'</div>',
		mounted:function() {
			var that = this;
			this.map = new BMap.Map("map-"+this.prop.id);  
			this.map.centerAndZoom(new BMap.Point(116.4035,39.915),15); 
			this.map.enableScrollWheelZoom(true);
			this.map.disable3DBuilding();
			console.log(this.map);
			// 创建地址解析器实例
			this.myGeo = new BMap.Geocoder();
			// 将地址解析结果显示在地图上,并调整地图视野
			this.myGeo.getPoint(this.prop.bindPlace, function(point){
				if (point) {
					that.map.centerAndZoom(point, 18);
					that.map.addOverlay(new BMap.Marker(point));
				}else{
					alert("您选择地址没有解析到结果!");
				}
			}, "北京市");
		},
		beforeDestroy:function() {
			
		},
		watch:{
			'prop.resolved':function(newVal, oldVal) {
				var that = this;
				if(newVal == false) {
					this.prop.resolved = true;
					this.myGeo.getPoint(this.prop.bindPlace, function(point){
						if (point) {
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							alert("您选择地址没有解析到结果!");
						}
					}, "北京市");
				}
			},
			'prop.styles.sizeStyle.width':function(newVal, oldVal) {
				var that = this;
				if(oldVal != newVal) {
					this.map = null;
					this.map = new BMap.Map("map-"+this.prop.id);  
					this.map.centerAndZoom(new BMap.Point(116.4035,39.915),15); 
					this.map.enableScrollWheelZoom(true);
					this.map.disable3DBuilding();
					console.log(this.map);
					// 创建地址解析器实例
					this.myGeo = new BMap.Geocoder();
					// 将地址解析结果显示在地图上,并调整地图视野
					this.myGeo.getPoint(this.prop.bindPlace, function(point){
						if (point) {
							that.map.centerAndZoom(point, 18);
							that.map.addOverlay(new BMap.Marker(point));
						}else{
							alert("您选择地址没有解析到结果!");
						}
					}, "北京市");
				}
			}
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				
				e.preventDefault();
	      e.stopPropagation();
			},
		}
	});
	
	/******************图片组件--实现**************/
	var imgCom = Vue.component('img-com', {
		props:['prop', 'curr_com_id', 'curr_sel_id'],
		template: '<div v-bind:id="prop.id" :class="{\'sortable-item\':!prop.inFreePanel,\'img-com\':true,\'phone-component\':true}" :style="[{width:\'100%\'},!prop.inNormalPanel?prop.styles.posStyle:{}, prop.inFreePanel?prop.styles.sizeStyle:{},prop.styles.alphaStyle, prop.styles.cursorStyle, prop.styles.transformStyle,prop.styles.positionStyle, prop.styles.animateStyle]" c-type="img" @click="onClick($event)" @mouseover="onMouseOver()" @mouseout="onMouseOut()" @mouseup="onMouseUp($event)" :index="prop.index">'+
		'<div :style="[{position:\'relative\'},prop.styles.alignStyle,prop.styles.marginStyle,prop.styles.borderStyle,prop.styles.sizeStyle,prop.styles.paddingStyle,prop.styles.useShadow?prop.styles.shadowStyle:{}]">'+
			'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) ||(prop.pid && curr_sel_id==prop.id)" style="z-index:100"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div><img :src="prop.src" :style="[ {\'border-radius\':\'inherit\',width:\'100%\'},{fliter:\'alpha(opacity=\'+prop.styles.alphaStyle.opacity*100+\')\'}]"></img></div>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false; 
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					this.$forceUpdate();
				}
			}
		},
		methods:{
			onMouseUp:function(e) {
			},
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				console.log('scrollTop=',scrollTop);
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		}
	});
	
	var usercenterCom = Vue.component('usercenter-com', {
		props:['prop','curr_com_id'],
		template:
		'<div :id="prop.id" @click="onClick($event)" :class="{\'phone-component\':true,}" :style="[{\'background-image\':\'url(\'+prop.bkimg+\')\',position:\'relative\',width:\'100%\',\'background-size\':\'100%\',\'background-repeat\':\'no-repeat\'}]">'+
				'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)" style="z-index:100"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
				'<div :style="[{position:\'relative\',\'line-height\':\'100px\',height:\'100px\',\'text-align\':\'left\'}]">'+
					'<img src="u" style="margin-left:10%;width:50px;height:50px;border-radius:50px;vertical-align:middle"></img>'+
					'<span style="margin-left:10%;font-size:2rem;color:#fff;vertical-align: middle;">昵称</span>'+
				'</div>'+
				'<div class="user-info-item" v-if="prop.addr">'+
					'<span class="icon icon-location2"></span><span style="margin-left:10px;">收货地址</span>'+
					'<img src="http://oeu8cw34d.bkt.clouddn.com/arrow-right.png?v=4"></img>'+
				'</div>'+
				'<div class="user-info-item" v-if="prop.order">'+
					'<span class="icon icon-file-text"></span><span style="margin-left:10px;">我的订单</span>'+
					'<img src="http://oeu8cw34d.bkt.clouddn.com/arrow-right.png?v=4"></img>'+
				'</div>'+
				'<div class="user-info-item" v-if="prop.cart">'+
					'<span class="icon icon-cart"></span><span style="margin-left:10px;">购物车</span>'+
					'<img src="http://oeu8cw34d.bkt.clouddn.com/arrow-right.png?v=4"></img>'+
				'</div>'+
				'<div class="user-info-item" v-if="prop.item">'+
					'<span class="icon icon-mug"></span><span style="margin-left:10px;">我的物品</span>'+
					'<img src="http://oeu8cw34d.bkt.clouddn.com/arrow-right.png?v=4"></img>'+
				'</div>'+
			'</div>',
			methods:{
				onClick:function(e) {
					if(this.prop.pid) {
						this.$emit('onClickSubCom', this.prop.id);
						e.preventDefault();
		        e.stopPropagation();
					} else {
						g_edit_panel.curr_com_id = this.prop.id;
						g_page.curr_com_id = this.prop.id;
					}
				},
				clickDel:function(e) {
					if(this.prop.pid) {
						this.$emit('delInnerCom', this.prop.id);
					} else {
						for(var i = 0; i < g_page.coms.length; i++) {
							if(g_page.coms[i].prop.id == this.prop.id) {
								g_page.coms.splice(i, 1);
								break;
							}
						}
						g_page.curr_com_id = "";
						g_edit_panel.curr_com_id = "";
					}
					e.preventDefault();
		      e.stopPropagation();
				}
			}
	});
	var lineCom = Vue.component('line-com', {
		props:['prop', 'curr_com_id', 'curr_sel_id'],
		template: '<div :id="prop.id" :class="{\'line-com\':true,\'phone-component\':true}" @click="onClick($event)" >'+
		'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
			'<div :style="[prop.styles.sizeStyle,prop.styles.marginStyle,prop.styles.bkcolorStyle]">'+
			'</div>'+
		'</div>',
		mounted:function() {
			var that = this;
		},
		methods:{
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		}
	});
	
	var btnCom = Vue.component('btn-com', {
		props:['prop', "curr_com_id", "curr_sel_id"],
		template: '<div :id="prop.id" :class="{\'sortable-item\':!prop.inFreePanel,\'img-com\':true, \'phone-component\':true}" c-type="btn" @mouseover="onMouseOver()" @click="onClick($event)" @mouseout="onMouseOut()" :index="prop.index" :style="[{width:\'100%\'},prop.inFreePanel?prop.styles.sizeStyle:{},!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.positionStyle,prop.styles.alphaStyle, , prop.styles.cursorStyle,prop.styles.animateStyle]">'+
		'<div :style="[{position:\'relative\'},prop.styles.alignStyle,prop.styles.marginStyle,{\'line-height\':prop.styles.sizeStyle[\'line-height\']},prop.styles.useShadow?prop.styles.shadowStyle:{}]">'+
		'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
					'<div :style="[{width:prop.styles.sizeStyle.width,\'line-height\':prop.styles.sizeStyle[\'line-height\']},prop.styles.bkcolorStyle, {display:\'inline-block\'}, prop.styles.borderStyle]">'+
						'<div style="border-radius:inherit">'+
							'<span class="inner-content js-text" :style="[{display:\'inline-block\',\'text-align\':\'center\',\'border-radius\':\'inherit\'},prop.styles.fontStyle, prop.styles.innerAlignStyle]" v-html="prop.text"></span>'+
						'</div>'+
					'</div>'+
				'</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'') + " !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
				this.$forceUpdate();
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
				}
			}
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				console.log('scrollTop=',scrollTop);
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			},
			onClick:function(e){
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		}
	});
	
	var titleCom = Vue.component('title-com', {
		props:['prop', 'curr_com_id', 'curr_sel_id'],
		template: '<div class="sortable-item phone-component ele-content inner-content element title-ele" mode="1" :style="[!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.animateStyle, prop.styles.sizeStyle, prop.styles.marginStyle, prop.styles.bkcolorStyle, prop.styles.borderStyle, prop.styles.alignStyle, prop.styles.positionStyle, prop.styles.transformStyle, prop.styles.alphaStyle]" @mouseover="onMouseOver()" @mouseout="onMouseOut()" @click="onClick()" :id="prop.id" c-type="title" :index="prop.index"><div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id)||(prop.pid&&curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
	      '<span class="title-text">'+
	      	'<span class="mark" :style="[prop.styles.markColorStyle]"></span>'+
	      	'<span class="js-text" v-html="prop.text" :style="[prop.styles.fontStyle]"></span>'+
	      '</span>'+
	  '</div>',
	  mounted:function() {
	  	var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
	  },
		methods:{
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				console.log('scrollTop=',scrollTop);
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			},
			onClick:function(){
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					this.$forceUpdate();
				}
			}
		},
	});
	
	/**************自由面板组件--实现************/
	var freePanel = Vue.component('free-panel', {
		props:['prop', 'curr_com_id','coms'],
	template:'<div :id="prop.id" @dblclick="onDblClick()" @click="onClick()" :class="{\'sortable-item\':prop.sortable,\'droppable-target\':true, \'phone-component\':true, \'free-panel\':true}" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index" :style="[prop.styles.transformStyle,prop.styles.alphaStyle, !prop.inNormalPanel?prop.styles.posStyle:{}, prop.styles.positionStyle,{\'background-repeat\':\'repeat repeat\'},prop.showGrid?prop.styles.gridStyle:prop.styles.bkcolorStyle,prop.styles.sizeStyle,prop.styles.showStyle,prop.styles.cursorStyle]" c-type="free-panel"><div class="control-wrap" v-show="prop.showControl||curr_com_id==prop.id"><span  v-if="prop.sortable" class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
		'<template v-for="subcom in prop.subcoms">'+
			'<text-com v-if="subcom.c_type==\'text\'" :prop="subcom.prop" :curr_sel_id="prop.curr_sel_id" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom(subcom.prop.id)"></text-com>'+
			'<img-com v-if="subcom.c_type==\'img\'" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom(subcom.prop.id)" :prop="subcom.prop" :curr_sel_id="prop.curr_sel_id"></img-com>'+
			'<btn-com v-if="subcom.c_type==\'btn\'" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom(subcom.prop.id)" :prop="subcom.prop" :curr_sel_id="prop.curr_sel_id"></btn-com>'+
		'</template>'+
		'</div>',
		mounted:function() {
			console.log("mounted free panel");
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.com_id = that.prop.id;
				g_menu.type = "free_panel";
				g_menu.subcom_id = "";
				g_menu.savecom_menu = true;
		    return false;
			});
			
			
			for(var i = 0;i < this.coms.length; i++) {
				if(this.coms[i].c_type == "free-panel") {
					var freePanelEl = $('#'+this.coms[i].prop.id);
					var free_com = this.coms[i];
					if(free_com.prop.mouse_mounted) {
						continue;
					}
					free_com.prop.mouse_mounted = true;
					free_com.prop.zooming = false;
					free_com.prop.zooming = false;
					free_com.prop.prepareZoom = false;
					free_com.prop.zoomArea = "";
					free_com.prop.prepareDrag = false;
					free_com.prop.dragging = false;
					free_com.prop.styles.cursorStyle.cursor = 'pointer';
						
					free_com.mouseMoveEvent = 'mousemove.'+free_com.prop.id;
					free_com.mouseDownEvent = 'mousedown.'+free_com.prop.id;
					free_com.mouseUpEvent = 'mouseup.'+free_com.prop.id;
					(function(com){
						var mouseMove = function(e) {
							//console.log('mouseMove'+com.prop.id);
							var mousePos = {
								x:e.pageX,
								y:e.pageY
							};
			
							if(com.prop.zooming) {
								var movedSize = {
			        		x:mousePos.x - com.startPos.x,
			        		y:mousePos.y - com.startPos.y
			        	};
			
			        	com.startPos = mousePos;
			        	var subcom_id = com.subcom_id_mouse;
			        	if(com.prop.zoomArea == "l") {
			        		com.prop.subcoms[subcom_id].prop.intLeft += movedSize.x;
									com.prop.subcoms[subcom_id].prop.intWidth -= movedSize.x;
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.left = com.prop.subcoms[subcom_id].prop.intLeft+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle.width = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        	} else if(com.prop.zoomArea == "r") {
			        		com.prop.subcoms[subcom_id].prop.intWidth += movedSize.x;
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle.width = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        	} else if(com.prop.zoomArea == "t") {
			        		com.prop.subcoms[subcom_id].prop.intHeight -= movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intTop += movedSize.y;
			
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.top = com.prop.subcoms[subcom_id].prop.intTop+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		if(com.prop.subcoms[subcom_id].c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        	} else if(com.prop.zoomArea == "b") {
			        		com.prop.subcoms[subcom_id].prop.intHeight += movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		if(com.prop.subcoms[subcom_id].prop.c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        	} else if(com.prop.zoomArea == "tl") {
			        		com.prop.subcoms[subcom_id].prop.intHeight -= movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intWidth -= movedSize.x;
			        		com.prop.subcoms[subcom_id].prop.intTop += movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intLeft += movedSize.x;
			
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['width'] = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.top = com.prop.subcoms[subcom_id].prop.intTop+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.left = com.prop.subcoms[subcom_id].prop.intLeft+"px";
			        		if(com.prop.subcoms[subcom_id].c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        		
			        	} else if(com.prop.zoomArea == "bl") {
			        		com.prop.subcoms[subcom_id].prop.intHeight += movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intWidth -= movedSize.x;
			        		com.prop.subcoms[subcom_id].prop.intLeft += movedSize.x;
			        		
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['width'] = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.left = com.prop.subcoms[subcom_id].prop.intLeft+"px";
			        		if(com.prop.subcoms[subcom_id].c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        	} else if(com.prop.zoomArea == "br") {
			        		com.prop.subcoms[subcom_id].prop.intHeight += movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intWidth += movedSize.x;
			        		
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['width'] = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        		
			        		if(com.prop.subcoms[subcom_id].c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        	} else if(com.prop.zoomArea == "tr") {
			        		com.prop.subcoms[subcom_id].prop.intHeight -= movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.intWidth += movedSize.x;
			        		com.prop.subcoms[subcom_id].prop.intTop += movedSize.y;
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.sizeStyle['width'] = com.prop.subcoms[subcom_id].prop.intWidth+"px";
			        		com.prop.subcoms[subcom_id].prop.styles.posStyle.top = com.prop.subcoms[subcom_id].prop.intTop+"px";
			        		if(com.prop.subcoms[subcom_id].c_type == 'btn') {
			        			com.prop.subcoms[subcom_id].prop.styles.sizeStyle['line-height'] = com.prop.subcoms[subcom_id].prop.intHeight+"px";
			        		}
			        	}
			        	
			        	event.preventDefault();
			          event.stopPropagation();
			          return;
							} else if(com.prop.dragging) {
								var movedPos = {
									left:mousePos.x - com.startPos.x,
									top:mousePos.y - com.startPos.y
								};
								
								var subcom_id = com.subcom_id_mouse;
								console.log('subcom_id=',subcom_id);
								com.prop.subcoms[subcom_id].prop.intLeft = com.startOffset.x + movedPos.left;
								com.prop.subcoms[subcom_id].prop.intTop = com.startOffset.y + movedPos.top;
								if(that.prop.alignToGrid) {
			      			com.prop.subcoms[subcom_id].prop.intLeft = parseInt((com.prop.subcoms[subcom_id].prop.intLeft/com.prop.gridSize))*com.prop.gridSize;
			      			com.prop.subcoms[subcom_id].prop.intTop = parseInt((com.prop.subcoms[subcom_id].prop.intTop/com.prop.gridSize))*com.prop.gridSize;
			      		}
								
								com.prop.subcoms[subcom_id].prop.styles.posStyle.left = com.prop.subcoms[subcom_id].prop.intLeft+'px';
			          com.prop.subcoms[subcom_id].prop.styles.posStyle.top = com.prop.subcoms[subcom_id].prop.intTop+'px';
								
			          event.preventDefault();
			          event.stopPropagation();
			          return false;
							} else {
								for(var i = com.prop.subcoms.length-1; i >=0 ; i--) {
									var el = $('#'+com.prop.subcoms[i].prop.id);
									var judgeSpace = 10;
									var area = {
										left:el.offset().left,
										top:el.offset().top,
										right:el.offset().left+el.width(),
										bottom:el.offset().top+el.height()
									};
									
									var dragArea = {
										left:el.offset().left+judgeSpace,
										top:el.offset().top+judgeSpace,
										right:el.offset().left+el.width()-judgeSpace,
										bottom:el.offset().top+el.height()-judgeSpace
									};
									
									var areaTopLeft = {
										left:area.left-judgeSpace,
										top:area.top-judgeSpace,
										right:area.left+judgeSpace,
										bottom:area.top+judgeSpace
									};
									
									var areaBottomLeft = {
										left:area.left-judgeSpace,
										right:area.left+judgeSpace,
										top:area.bottom-judgeSpace,
										bottom:area.bottom+judgeSpace
									};
									
									var areaTopRight = {
										left:area.right-judgeSpace,
										right:area.right+judgeSpace,
										top:area.top-judgeSpace,
										bottom:area.top+judgeSpace
									};
									
									var areaBottomRight = {
										left:area.right-judgeSpace,
										right:area.right+judgeSpace,
										top:area.bottom-judgeSpace,
										bottom:area.bottom+judgeSpace
									};
									
									var areaLeft = {
										left:area.left-judgeSpace,
										right:area.left+judgeSpace,
										top:area.top+judgeSpace,
										bottom:area.bottom-judgeSpace
									};
									
									var areaBottom = {
										left:area.left+judgeSpace,
										right:area.right-judgeSpace,
										top:area.bottom-judgeSpace,
										bottom:area.bottom+judgeSpace
									};
									
									var areaRight = {
										left:area.right-judgeSpace,
										right:area.right+judgeSpace,
										top:area.top+judgeSpace,
										bottom:area.bottom-judgeSpace
									};
									
									var areaTop = {
										left:area.left+judgeSpace,
										right:area.right-judgeSpace,
										top:area.top-judgeSpace,
										bottom:area.top+judgeSpace
									};
									//console.log(com.c_type);
									if(com.prop.subcoms[i].c_type != "img") {
										if(inArea(mousePos, areaTopLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "tl";
											com.prop.styles.cursorStyle.cursor = 'nw-resize';
										} else if(inArea(mousePos, areaBottomLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "bl";
											com.prop.styles.cursorStyle.cursor = 'sw-resize';
										} else if(inArea(mousePos, areaLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "l";
											com.prop.styles.cursorStyle.cursor = 'w-resize';
										} else if(inArea(mousePos, areaTopRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "tr";
											com.prop.styles.cursorStyle.cursor = 'ne-resize';
										} else if(inArea(mousePos, areaBottomRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "br";
											com.prop.styles.cursorStyle.cursor = 'se-resize';
										} else if(inArea(mousePos, areaRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "r";
											com.prop.styles.cursorStyle.cursor = 'e-resize';
										} else if(inArea(mousePos, areaBottom)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "b";
											com.prop.styles.cursorStyle.cursor = 's-resize';
										} else if(inArea(mousePos, areaTop)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "t";
											com.prop.styles.cursorStyle.cursor = 'n-resize';
										} else {
											com.prop.prepareZoom = false;
											if(inArea(mousePos, dragArea)) {
												com.prop.prepareDrag = true;
												com.prop.styles.cursorStyle.cursor = 'pointer';
											} else {
												com.prop.prepareDrag = false;
											}
										}
									} else {
										if(inArea(mousePos, areaTopLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "l";
											com.prop.styles.cursorStyle.cursor = 'w-resize';
										} else if(inArea(mousePos, areaBottomLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "l";
											com.prop.styles.cursorStyle.cursor = 'w-resize';
										} else if(inArea(mousePos, areaLeft)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "l";
											com.prop.styles.cursorStyle.cursor = 'w-resize';
										} else if(inArea(mousePos, areaTopRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "r";
											com.prop.styles.cursorStyle.cursor = 'e-resize';
										} else if(inArea(mousePos, areaBottomRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "r";
											com.prop.styles.cursorStyle.cursor = 'e-resize';
										} else if(inArea(mousePos, areaRight)) {
											com.prop.prepareZoom = true;
											com.prop.zoomArea = "r";
											com.prop.styles.cursorStyle.cursor = 'e-resize';
										} else {
											com.prop.prepareZoom = false;
											if(inArea(mousePos, dragArea)) {
												com.prop.prepareDrag = true;
												com.prop.styles.cursorStyle.cursor = 'pointer';
											} else {
												com.prop.prepareDrag = false;
											}
										}
									}
									
									if(com.prop.prepareDrag || com.prop.prepareZoom) {
										com.subcom_id_mouse = i;
										com.prop.subcoms[i].prop.showControl = true;
										break;
									} else {
										com.prop.subcoms[i].prop.showControl = false;
									}
								}
								if(!com.prop.prepareDrag && !com.prop.prepareZoom) {
									com.prop.styles.cursorStyle.cursor = 'pointer';
								}
							}
					};
					
					var mouseDown = function(e) {
						if(g_myanimate.show) {
							return;
						}
						if(com.prop.prepareZoom) {
							com.prop.zooming = true;
							com.startPos.x = e.pageX; 
							com.startPos.y = e.pageY; 
			        
			        e.preventDefault();
		    			e.stopPropagation();
						} else if(com.prop.prepareDrag) {
							var el = $("#"+com.prop.subcoms[com.subcom_id_mouse].prop.id);
							var pos       = el.offset();
		    			var cPos      = $('#'+com.prop.id).offset();//这个是容器距离左上角的绝对位绿
	
							com.prop.dragging = true;
							com.prop.styles.cursorStyle.cursor = 'move';
							com.startPos.x = e.pageX;
							com.startPos.y = e.pageY;
			        
			        com.eleSize.width = el.width();
			        com.eleSize.height = el.height();
			
			        com.startOffset.x = pos.left - cPos.left;
			        com.startOffset.y = pos.top - cPos.top;
			        console.log(pos,cPos,com.startOffset);
			        com.containerSize.width = $('#'+com.prop.id).width();
			        com.containerSize.height = $('#'+com.prop.id).height();
	
				      e.preventDefault();
		    			e.stopPropagation();  
						}
					};
					
					var mouseUp = function(e) {
						com.prop.zooming = false;
						com.prop.prepareZoom = false;
						com.prop.zoomArea = "";
						com.prop.prepareDrag = false;
						com.prop.dragging = false;
						com.prop.styles.cursorStyle.cursor = 'pointer';
					};
					
					//console.log('mounted', com.prop.id);
					$(document).off(com.mouseMoveEvent).off(com.mouseDownEvent).off(com.mouseUpEvent);
					$(document).on(com.mouseMoveEvent, mouseMove).on(com.mouseDownEvent, mouseDown).on(com.mouseUpEvent,mouseUp);
					com.prop.mounted_mouse = true;
						
					})(free_com);
				}
			}
			return;
	
		},
		updated:function() {
			
		},
		beforeDestroy:function() {
			console.log('beforedestroy', this.prop.id);
			if(this.prop.mouse_mounted) {
				var mouseMoveEvent = 'mousemove.'+this.prop.id;
				var mouseDownEvent = 'mousedown.'+this.prop.id;
				var mouseUpEvent = 'mouseup.'+this.prop.id;
				$(document).off(mouseMoveEvent).off(mouseDownEvent).off(mouseUpEvent);
				this.prop.mouse_mounted = false;
			}
			g_page.curr_com_id = "";
			g_edit_panel.curr_com_id = "";
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onDblClick:function() {
//				if(this.prop.styles.outterStyle.isrealheight) {
//					this.prop.styles.outterStyle.height = this.prop.styles.outterStyle.viewheight+"px";
//					this.prop.styles.outterStyle.isrealheight = false;
//					new $.zui.Messager('显示可视高度', {
//			        icon: 'bell' // 定义消息图标
//			    }).show();
//				} else {
//					this.prop.styles.outterStyle.height = this.prop.styles.outterStyle.realheight+"px";
//					this.prop.styles.outterStyle.isrealheight = true;
//					new $.zui.Messager('显示实际高度', {
//			        icon: 'bell' // 定义消息图标
//			    }).show();
//				}
				console.log(this.prop);
				if(this.prop.styles.isrealheight) {
					this.prop.styles.sizeStyle.height = this.prop.styles.viewheight+"px";
					this.prop.styles.isrealheight = false;
					new $.zui.Messager('显示可视高度', {
			        icon: 'bell' // 定义消息图标
			    }).show();
				} else {
					this.prop.styles.sizeStyle.height = this.prop.styles.realheight+"px";
					this.prop.styles.isrealheight = true;
					new $.zui.Messager('显示实际高度', {
			        icon: 'bell' // 定义消息图标
			    }).show();
				}
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function() {
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
				this.prop.curr_sel_id = "";
			},
			onClickSubCom:function(subcom_id) {
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
				this.prop.curr_sel_id = subcom_id;
			},
			clickDel:function(e) {
				var mouseMoveEvent = 'mousemove.'+this.prop.id;
				var mouseDownEvent = 'mousedown.'+this.prop.id;
				var mouseUpEvent = 'mouseup.'+this.prop.id;
				$(document).off(mouseMoveEvent).off(mouseDownEvent).off(mouseUpEvent);
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
				markComIndex();
				g_page.curr_com_id = "";
				g_edit_panel.curr_com_id = "";
				e.preventDefault();
	      e.stopPropagation();
			},
			delInnerCom:function(id) {
				for(var i = 0; i < this.prop.subcoms.length; i++) {
					if(this.prop.subcoms[i].prop.id == id) {
						this.prop.subcoms.splice(i,1);
						break;
					}
				}
			}
		}
	});
	
	/**************普通面板组件--实现************/
	var normalPanel = Vue.component('normal-panel', {
		props:['prop', 'curr_com_id','curr_sel_id'],
		template:'<div :id="prop.id" @dblclick="onDblClick()" @click="onClick()" :class="{\'sortable-item\':prop.sortable,\'droppable-target\':true,\'phone-component\':true,\'normal-panel\':true}" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index" :style="[!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.positionStyle, prop.styles.alphaStyle,prop.styles.transformStyle, prop.styles.sizeStyle,prop.styles.outterStyle, prop.styles.showStyle,prop.styles.animateStyle]" c-type="normal-panel"><div class="control-wrap" v-show="prop.showControl||curr_com_id==prop.id"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event, prop.index)">×</span></div>'+
		'<template v-for="subcom in prop.subcoms">'+
			'<text-com v-if="subcom.c_type==\'text\'" :prop="subcom.prop" :curr_sel_id="curr_sel_id" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom"></text-com>'+
			'<line-com v-if="subcom.c_type==\'line-com\'" :prop="subcom.prop" :curr_sel_id="curr_sel_id" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom"></line-com>'+
			'<img-com v-if="subcom.c_type==\'img\'" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></img-com>'+
			'<btn-com v-if="subcom.c_type==\'btn\'" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></btn-com>'+
			'<carousel-com v-if="subcom.c_type==\'carousel\'" v-on:delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></carousel-com>'+
			'<piclist-com v-if="subcom.c_type==\'pic-list\'" @delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></piclist-com>'+
			'<pictxt-set-com v-if="subcom.c_type==\'pic-txt-set\'" @delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></pictxt-set-com>'+
			'<goodslist-com v-if="subcom.c_type==\'goodslist-com\'" @delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></goodslist-com>'+
			'<videolist-com v-if="subcom.c_type==\'videolist-com\'" @delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></videolist-com>'+
			'<map-com v-if="subcom.c_type==\'map-com\'" @delInnerCom="delInnerCom" @onClickSubCom="onClickSubCom" :prop="subcom.prop" :curr_sel_id="curr_sel_id"></map-com>'+
		'</template>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
					g_menu.style.left = e.pageX+"px";
					g_menu.style.top = e.pageY+"px";
					g_menu.style.display = "block";
					g_menu.type = 'normal_panel';
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
			    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					this.$forceUpdate();
				}
			}
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onDblClick:function() {
				if(this.prop.styles.isrealheight) {
					this.prop.styles.sizeStyle.height = this.prop.styles.viewheight+"px";
					this.prop.styles.isrealheight = false;
					new $.zui.Messager('显示可视高度', {
			        icon: 'bell' // 定义消息图标
			    }).show();
				} else {
					this.prop.styles.sizeStyle.height = this.prop.styles.realheight+"px";
					this.prop.styles.isrealheight = true;
					new $.zui.Messager('显示实际高度', {
			        icon: 'bell' // 定义消息图标
			    }).show();
				}
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function() {
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
				this.prop.curr_sel_id = "";
			},
			onClickSubCom:function(subcom_id) {
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
				this.prop.curr_sel_id = subcom_id;
			},
			clickDel:function(e,index) {
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
				markComIndex();
				g_page.curr_com_id = "";
				g_edit_panel.curr_com_id = "";
				e.preventDefault();
	      e.stopPropagation();
			},
			delInnerCom:function(id) {
				for(var i = 0; i < this.prop.subcoms.length; i++) {
					if(this.prop.subcoms[i].id == id) {
						this.prop.subcoms.splice(i,1);
						break;
					}
				}
			}
		}
	});
	/*****************轮播图组件--实现****************/
	var carouselCom = Vue.component('carousel-com', {
		props:['prop', 'curr_com_id', 'curr_sel_id'],
		template:'<div class="sortable-item carousel phone-component" :style="[{\'margin-left\': \'0px\', \'margin-top\':\'0px\',height:\'150px\', \'overflow-x\':\'hidden\',width:\'100%\'},prop.styles.transformStyle,prop.styles.alphaStyle, !prop.inNormalPanel?prop.styles.posStyle:{}, prop.styles.animateStyle,prop.styles.positionStyle]" @mouseover="onMouseOver()" @mouseout="onMouseOut()" @click="onClick($event)" :index="prop.index" :id="prop.id"><div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id)||(prop.pid&&curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event, prop.index)">×</span></div>'+
									'<transition-group name="list" tag="ul" class="slide-ul">'+
											'<li v-for="(slide,$index) in prop.slideList" :key="$index" :index="$index" style="position:absolute;width:100%;" v-show="$index===prop.currentIndex"><a href="javascript:" :alt="slide.desc" style="display:block;width:100%;height:100%"><img :src="slide.image" style="width:100%;height:auto"></img></a></li>' +
									'</transition-group>'+
						'<div class="carousel-items" :type="prop.figureType" :align="prop.figureAlign">'+
						   '<span v-for="(item,$index) in prop.slideList.length" :style="[$index===prop.currentIndex?prop.figureColor:{}]""></span>'+
						 '</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
		    return false;
			});
			
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
			
			that.prop.max_height = 0;
			var imgs = $(this.$el).find('img');
			imgs.each(function(index, item) {
				$(this).load(function() {
					var actual_height = $(this).actual('height');
					if(actual_height > that.prop.max_height) {
						that.prop.max_height = actual_height;
					}
					$(that.$el).css('height', that.prop.max_height);
				});
			});
			
			if(!this.prop.timer) {
				this.prop.timer = setInterval(function() {
					that.prop.currentIndex++;
					that.prop.currentIndex %= that.prop.slideList.length;
				}, that.prop.interval*1000);
			}
		},
		updated:function() {
			var that = this;
			if(that.prop.changeInterval) {
				that.prop.changeInterval = false;
				clearInterval(this.prop.timer);
				this.prop.timer = null;
				if(!this.prop.timer) {
					this.prop.timer = setInterval(function() {
						that.prop.currentIndex++;
						that.prop.currentIndex %= that.prop.slideList.length;
					}, that.prop.interval*1000);
				}
			}
			
			var imgs = $(this.$el).find('img');
			imgs.each(function(index, item) {
				$(this).load(function() {
					var actual_height = $(this).actual('height');
					if(actual_height > that.prop.max_height) {
						that.prop.max_height = actual_height;
					}
					$(that.$el).css('height', that.prop.max_height);
				});
			});
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
	
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				console.log('scrollTop=',scrollTop);
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			clickDel:function(e,index) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			}
		},
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
					this.$forceUpdate();
				}
			}
		}
	});
	
	var picTxtSetItem = Vue.component('pictxt-set-item', {
		props:['item', 'styles', 'index', 'mode'],
		template:'<li :style="[styles.itemBkColorStyle, mode==1?styles.itemHeightStyle:{}, index==0?{\'margin-top\':\'0px\'}:styles.itemMarginStyle, {\'text-align\':\'left\'}]">'+
		          '<div class="" style="width:100%;height:100%;position:relative">'+
		            '<img :style="[styles.itemImageSizeStyle,styles.itemImageMarginStyle]" :src="item.image"></img>'+
		            '<div :style="[{\'display\':\'inline-block\',\'vertical-align\':\'middle\'},{width:mode==1?\'calc(100% - \'+styles.itemImageSizeStyle.width +\' - \'+styles.itemImageMarginStyle[\'margin-left\']+\' - 20px)\':\'100%\'}]">'+
		            	'<p class="title" :style="[styles.itemTitleStyle]" v-html="item.title"></p>'+
		            	'<p class="desc" :style="[styles.itemDescStyle]" v-html="item.desc"></p>'+
		            '</div>'+
		          '</div>'+
		        '</li>'
	});
	
	/*****************图文集组件--实现**************/
	var picTxtSetCom = Vue.component('pictxt-set-com', {
		props:['prop', 'curr_com_id','curr_sel_id'],
		template:'<div @click="onClick($event)" :mode="prop.mode" class="sortable-item pictxt-set-com phone-component" :style="[!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.marginStyle, prop.styles.alphaStyle, prop.styles.sizeStyle,prop.styles.positionStyle,prop.styles.transformStyle]" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index" :id="prop.id"><div class="control-wrap" v-show="(prop.showControl||curr_com_id==prop.id)||(prop.pid&&curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event)">×</span></div>'+
			'<ul class="js-container inner-content list-container" :style="[prop.styles.bkcolorStyle,{\'font-size\':\'0px\'}]">'+
				'<pictxt-set-item v-for="(item,$index) in prop.items" :mode="prop.styles.mode" :item="item" :styles="prop.styles" :index="$index"></pictxt-set-item>'+
			'</ul>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
				
		    return false;
			});
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			}
		}
	});
	
	/*****************图片列表组件--实现**************/
	var picListCom = Vue.component('piclist-com', {
		props:['prop','curr_com_id', 'curr_sel_id'],
		template:'<div class="sortable-item piclist-com phone-component" :style="[!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.positionStyle,prop.styles.transformStyle,prop.styles.marginStyle, prop.styles.alphaStyle, prop.styles.bkcolorStyle]" :mode="prop.styles.mode" v-on:mouseover="onMouseOver()" v-on:mouseout="onMouseOut()" @click="onClick($event)" :index="prop.index" :id="prop.id"><div class="control-wrap" v-show="(prop.showControl||curr_com_id==prop.id)||(prop.pid&&curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" v-on:click="clickDel($event)">×</span></div>'+
		'<ul class="js-container inner-content list-container"><li v-for="(item,$index) in prop.items" :style="[{width:\'calc((100% - \'+(prop.col-1)*prop.styles.itemMarginStyle[\'margin-left\'].substr(0,prop.styles.itemMarginStyle[\'margin-left\'].length-2)+\'px)/\'+prop.col+\')\'},{\'margin-left\':$index%prop.col==0?\'0px\':prop.styles.itemMarginStyle[\'margin-left\']},{\'margin-top\':Math.floor($index/prop.col)==0?\'0px\':prop.styles.itemMarginStyle[\'margin-top\']}]" :col="prop.col">'+
			'<div :style="[{position:\'relative\'},prop.styles.itemBorderStyle]">'+
				'<img :src="item.image" :style="[prop.styles.itemHeightStyle,{width:\'100%\'},prop.styles.itemBorderStyle]"></img>'+
				'<div class="pic-list-txt" :style="[prop.styles.innerAlignStyle,{\'border-bottom-left-radius\':prop.styles.itemBorderStyle[\'border-radius\'],\'border-bottom-right-radius\':prop.styles.itemBorderStyle[\'border-radius\']}]">'+
					'<span v-html="item.desc" :style="[prop.styles.itemFontStyle,{\'line-height\':\'1.6em\'}]"></span>'+
				'</div>'+
			'</div>'+
		'</li></ul>'+
		'</div>',
		mounted:function() {
			var that = this;
			$(this.$el).bind("contextmenu", function(e){
				g_menu.style.left = e.pageX+"px";
				g_menu.style.top = e.pageY+"px";
				g_menu.style.display = "block";
				g_menu.type = '';
				if(that.prop.pid) {
					g_menu.com_id = that.prop.pid;
					g_menu.subcom_id = that.prop.id;
					g_menu.savecom_menu = false;
				} else {
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
				}
				
		    return false;
			});
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				console.log('scrollTop=',scrollTop);
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			}
		}
	});
	/*****************分栏组件--实现*************/
	var categoryCom = Vue.component('category-com', {
		props:['prop', "curr_com_id", "curr_sel_id"],
		template:'<div :style="[!prop.inNormalPanel?prop.styles.posStyle:{},prop.styles.transformStyle, prop.styles.positionStyle, prop.styles.sizeStyle, prop.styles.alphaStyle,prop.styles.outterStyle,prop.styles.bkcolorStyle]" @click="onClick($event)" class="sortable-item phone-component category-com" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index" :id="prop.id"><div class="control-wrap" v-show="(prop.showControl||curr_com_id==prop.id)||(prop.pid&&curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" @click="clickDel($event, prop.index)">×</span></div>'+
			'<ul class="js-container inner-content list-container">'+
				'<li v-for="(item,index) in prop.items" :style="[prop.styles.fontStyle, prop.styles.itemStyle, {width:\'calc(100%/\'+prop.items.length+\')\'}, ,{color:index==prop.currentIndex?prop.styles.active_color:prop.styles.fontStyle[\'color\'],\'border-bottom-color\':index==prop.currentIndex?prop.styles.active_color:\'transparent\'}]" :col="prop.col" @click="onClickItem($event, index)">'+
					'<p style="margin-bottom:0px;margin-top:0px;" v-html="item.title"></p>'+
					'<p :style="[{transform:\'scale(1,0.5)\',color:prop.styles.active_color,margin:\'0px\',\'line-height\':\'16px\',\'margin-bottom\':\'-4px\'}]" v-show="index==prop.currentIndex">▲</p>'+
				'</li>'+
			'</ul>'+
		'</div>',
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				for(var i = 0; i < this.prop.items.length; i++) {
					for(var j = 0; j < g_page.coms.length; j++) {
						if(g_page.coms[j].prop.id == this.prop.items[i].attach_com_id) {
							g_page.coms[j].prop.styles.showStyle.display = 'none';
						}
					}
				}
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			onClickItem:function(e, index) {
				this.prop.currentIndex = index;
				for(var i = 0; i < this.prop.items.length; i++) {
					if(this.prop.items[i].attach_com_id != "") {
						for(var j = 0; j < g_page.coms.length; j++) {
							if(g_page.coms[j].prop.id == this.prop.items[i].attach_com_id) {
								if(i == index) {
									g_page.coms[j].prop.styles.showStyle['display'] = 'block';
									if(g_page.coms[j].c_type == "chat-com") {//聊天组件，要看看是否有底部导航，有的话就隐藏
										if(g_page.coms[g_page.coms.length-1].c_type == "bottomnav-com") {
											g_page.coms[g_page.coms.length-1].prop.styles.showStyle.display="none";
										}
									} else {
										if(g_page.coms[g_page.coms.length-1].c_type == "bottomnav-com") {
											g_page.coms[g_page.coms.length-1].prop.styles.showStyle.display="block";
										}
									}
								} else {
									g_page.coms[j].prop.styles.showStyle['display'] = 'none';
								}
							}
						}
					} else {
						if(i == index) {
							if(g_page.coms[g_page.coms.length-1].c_type == "bottomnav-com") {
								g_page.coms[g_page.coms.length-1].prop.styles.showStyle.display="block";
							}
						}
					}
				}
				
				g_edit_panel.curr_com_id = this.prop.id;
				g_page.curr_com_id = this.prop.id;
				e.preventDefault();
	      e.stopPropagation();
			},
			clickDel:function(e, index) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					var com;
					for(var m = 0; m < g_page.coms.length; m++) {
						if(g_page.coms[m].prop.id == this.prop.id) {
							com = g_page.coms[m];
							break;
						}
					}
					for(var i = 0;i < com.prop.items.length; i++) {
						if(com.prop.items[i].attach_com_id != "") {
							for(var j = 0; j < g_page.coms.length; j++) {
								if(g_page.coms[j].prop.id == com.prop.items[i].attach_com_id) {
									g_page.coms.splice(j,1);
									break;
								}
							}
						}
					}
					
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				e.preventDefault();
	      e.stopPropagation();
			}
		}
	});
	
	/**********************顶部导航组件--实现*****************/
	var topNavCom = Vue.component('topnav-com', {
		props:['prop','curr_com_id', 'curr_sel_id','phone_size','phone_pos'],
		template: '<div :id="prop.id" :class="{\'phone-component\':true}" :style="[{width:\'100%\', position:\'relative\'},prop.styles.sizeStyle,prop.styles.bkcolorStyle, prop.styles.fontStyle, prop.styles.marginStyle, prop.styles.useShadow?prop.styles.shadowStyle:{}]" c-type="topnav-com" @click="onClick($event)" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index">'+
		'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" title="删除" style="z-index:1001" v-on:click="clickDel($event)">×</span></div>'+
		'<div :style="[{position:\'fixed\',left:phone_pos.left+\'px\',top:phone_pos.top+\'px\',width:phone_size.width+\'px\',\'z-index\':100001},prop.styles.sizeStyle,prop.styles.bkcolorStyle]">'+
			'<a v-if="prop.leftBtn.use==\'true\'" :style="[prop.leftBtn.defaultStyle, prop.leftBtn.sizeStyle, prop.leftBtn.fontStyle, prop.leftBtn.paddingStyle]"><img v-show="prop.leftBtn.imgSrc!=\'\'" :src="prop.leftBtn.imgSrc" style="display:block;width:100%;height:100%;"></img><span :style="[{display: \'block\',width: \'100%\',height: \'100%\',position:\'absolute\',top:\'0px\',left:\'0px\'},prop.leftBtn.fontPosStyle]" v-html="prop.leftBtn.text"></span>'+
			'</a><span class="center-title" :style="prop.styles.fontStyle" v-html="prop.title">首页</span>'+
			'<a v-if="prop.rightBtn.use==\'true\'" :style="[prop.rightBtn.defaultStyle, prop.rightBtn.sizeStyle, prop.rightBtn.fontStyle, prop.rightBtn.paddingStyle]">'+
				'<span :style="[{display: \'block\',width: \'100%\',height: \'100%\',position:\'absolute\',top:\'0px\',left:\'0px\'},prop.rightBtn.fontPosStyle]" v-html="prop.rightBtn.text"></span>'+
				'<img v-show="prop.rightBtn.imgSrc!=\'\'" :src="prop.rightBtn.imgSrc" style="display:block;width:100%;height:100%;"></img>'+
			'</a>'+
		'</div>'+
		'</div>',
		mounted:function() {
			var that = this;
			console.log(this.prop.leftBtn);
		},
		methods:{
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
				markComIndex();
				g_page.curr_com_id = "";
				g_edit_panel.curr_com_id = "";
				
				e.preventDefault();
	      e.stopPropagation();
			},
		}
	});
	
	/**********************底部导航组件--实现*****************/
	var bottomNavCom = Vue.component('bottomnav-com', {
		props:['prop','curr_com_id', 'curr_sel_id','phone_size','phone_pos', 'coms'],
		template: '<div :id="prop.id" :class="{\'phone-component\':true}" :style="[{width:prop.phone_size.width+\'px\', position:\'fixed\',left:phone_pos.left+\'px\',\'z-index\':10001,bottom:(phone_size.docHeight-phone_pos.top-phone_size.height-phone_pos.scrollTop)+\'px\'},prop.styles.bkcolorStyle, prop.styles.showStyle,prop.styles.fontStyle,prop.styles.paddingStyle]" c-type="bottomnav-com" @click="onClick($event)" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index">'+
		'<div class="control-wrap" style="z-index:-1" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" style="z-index:1001" title="删除" v-on:click="clickDel($event)">×</span></div>'+
			'<ul style="z-index:10">'+
				'<li  v-for="(item,index) in prop.items" :style="[{width:\'calc(100%/\'+prop.items.length+\')\',display:\'inline-block\',\'z-index\':100}]" @click="onClickItem($event,index)">'+
					'<a :style="[prop.styles.imgSizeStyle,{display:\'block\',margin:\'0 auto\'}]">'+
						'<img style="width:100%;height:100%" :src="index==prop.currentIndex?item.hotImgSrc:item.imgSrc"></img>'+
					'</a>'+
					'<div class="bottom-text" :style="[{\'text-align\':\'center\',width:\'100%\'},prop.styles.fontStyle,index==prop.currentIndex?prop.styles.hotTextColor:{}]" v-html="item.text"></div>'+
				'</li>'+
			'</ul>'+
		'</div>',
		created:function() {
		},
		mounted:function() {
			var that = this;
			var innerHeight = $(this.$el).innerHeight();
			for(var i = 0;i < this.coms.length; i++) {
				if(this.coms[i].c_type == "margin-com") {
					this.coms[i].prop.styles.marginStyle['margin-bottom'] = innerHeight+'px';
				}
			}
			
			$(this.$el).bind("contextmenu", function(e){
					g_menu.style.left = e.pageX+"px";
					g_menu.style.top = e.pageY+"px";
					g_menu.style.display = "block";
					g_menu.type = '';
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
			    return false;
			});
		},
		methods:{
			onClickItem:function(e, index) {
				this.prop.currentIndex = index;
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
				}
			},
			clickDel:function(e) {
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].prop.id == this.prop.id) {
						g_page.coms.splice(i, 1);
						break;
					}
				}
			
				for(var i = 0; i < g_page.coms.length; i++) {
					if(g_page.coms[i].c_type == "margin-com") {
						g_page.coms.splice(i,1);
						break;
					}
				}
				markComIndex();
				g_page.curr_com_id = "";
				g_edit_panel.curr_com_id = "";
				
				e.preventDefault();
	      e.stopPropagation();
			},
		}
	});
	/******************直播视频组件--实现*************/
	var liveVideoCom = Vue.component('livevideo-com', {
		props:['prop', 'curr_com_id'],
		template:'<div :id="prop.id"  c-type="livevideo-com" @click="onClick($event)" :style="[prop.styles.posStyle,prop.styles.positionStyle,prop.styles.transformStyle,prop.styles.alphaStyle,prop.styles.animateStyle]" class="phone-component" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index">'+
		'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" style="z-index:1001" title="删除" v-on:click="clickDel($event)">×</span></div>'+
			'<div style="position:relative">'+
				'<div class="logo-area">'+
					'<img style="display:block" :src="prop.video.cover_img==\'\'?\'http://o95rd8icu.bkt.clouddn.com/o_1beessbhs1o5nhaa1hl91krdgnkc.jpg\':prop.video.cover_img">'+
					'<div class="video-time"><span :style="[{\'font-size\':\'1.5rem\',\'margin-top\':\'0.3rem\',\'margin-right\':\'0.5rem\',color:prop.styles.videoColor}]" class="icon icon-clock"></span><span style="font-size:1.5rem">1:37:18</span></div>'+
					'<div class="view-count"><span :style="[{\'font-size\':\'1.5rem\',\'margin-top\':\'0.3rem\',\'margin-right\':\'0.5rem\',color:prop.styles.videoColor}]" class="icon icon-eye"></span><span style="font-size:1.5rem">128</span></div>'+
				'</div>'+
				'<img :src="prop.video.cover_img"></img>'+
			'<span class="icon icon-play2" :style="[{display:\'none\',\'font-size\':\'6rem\',\'position\':\'absolute\',top:\'50%\',\'left\':\'50%\',display:\'block\',\'margin-left\':\'-3rem\',\'margin-top\':\'-3rem\',color:prop.styles.videoColor}]"></span>'+
				'<div class="stopWatch" style="">'+
					'<div class="stopwatch-box">'+
						'<h5>距离直播开始还有</h5>'+
						'<ul class="jtime-list" style="display:flex">'+
							'<li class="jtime" style="flex:1">'+
								'<h3>天</h3>'+
								'<span style="font-size:2.5rem">32</span>'+
							'</li>'+
							'<li class="jtime" style="flex:1">'+
								'<h3>时</h3>'+
								'<span style="font-size:2.5rem">01</span>'+
							'</li>'+
							'<li class="jtime" style="flex:1">'+
								'<h3>分</h3>'+
								'<span style="font-size:2.5rem">02</span>'+
							'</li>'+
							'<li class="jtime" style="flex:1">'+
								'<h3>秒</h3>'+
								'<span style="font-size:2.5rem">32</span>'+
							'</li>'+
						'</ul>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>',
		watch:{
			'prop.animates':function(newVal, oldVal) {
				var that = this;
				that.prop.currAnimateIndex = 0;
				$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
				
				if(that.prop.animates.length > 0) {
					var ani = that.prop.animates[0];
					this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['animation-play-state'] = 'running';
					
					this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
					this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
					this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
					this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
					this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					
					
					$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
						that.prop.currAnimateIndex++;
						if(that.prop.currAnimateIndex < that.prop.animates.length) {
							var ani = that.prop.animates[that.prop.currAnimateIndex];
							that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['animation-play-state'] = 'running';
							
							that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
							that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
							that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
							that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
							that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
						} else {
							$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
						}
					});
				}
			}
		},
		computed:{
			'prop.styles.animateStyle':function() {
				var obj = {};
				if(this.prop.currAnimateIndex < this.prop.animates.length) {
					var className = this.prop.animates[this.prop.currAnimateIndex].className;
					var subclassName = "";
					if(this.prop.animates[this.prop.currAnimateIndex].subclassName) {
						subclassName = this.prop.animates[this.prop.currAnimateIndex].subclassName;
					}
					obj['animation-name'] = className+subclassName+" !important";
					obj['-webkit-animation-name'] = className+subclassName+" !important";
					obj['animation-duration'] = this.prop.animates[this.prop.currAnimateIndex].duration+'s';
					obj['-webkit-animation-duration'] = this.prop.animates[this.prop.currAnimateIndex].duration+'s';
					obj['animation-delay'] = this.prop.animates[this.prop.currAnimateIndex].delay+'s';
					obj['-webkit-animation-delay'] = this.prop.animates[this.prop.currAnimateIndex].delay+'s';
					if(this.prop.animates[this.prop.currAnimateIndex].count!='infinite') {
						obj['animation-iteration-count'] = this.prop.animates[this.prop.currAnimateIndex].count+'s';
						obj['-webkit-animation-iteration-count'] = this.prop.animates[this.prop.currAnimateIndex].count+'s';
					} else {
						obj['animation-iteration-count'] = 'infinite';
						obj['-webkit-animation-iteration-count'] = 'infinite';
					}
					obj['animation-play-state'] = 'running';
					obj['-webkit-animation-play-state'] = 'running';
				}
				return obj;
			}
		},
		mounted:function() {
			var that = this;
			that.prop.currAnimateIndex = 0;
			if(that.prop.animates.length > 0) {
				var ani = that.prop.animates[0];
				this.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['animation-play-state'] = 'running';
				
				this.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
				this.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
				this.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
				this.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
				this.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
				
				
				$(this.$el).on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
					that.prop.currAnimateIndex++;
					if(that.prop.currAnimateIndex < that.prop.animates.length) {
						var ani = that.prop.animates[that.prop.currAnimateIndex];
						that.prop.styles.animateStyle['animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['animation-play-state'] = 'running';
						
						that.prop.styles.animateStyle['-webkit-animation-name'] = ani.className+(ani.subclassName?ani.subclassName:'')+" !important";
						that.prop.styles.animateStyle['-webkit-animation-duration'] = ani.duration+"s";
						that.prop.styles.animateStyle['-webkit-animation-delay'] = ani.delay+"s";
						that.prop.styles.animateStyle['-webkit-animation-iteration-count'] = ani.count;
						that.prop.styles.animateStyle['-webkit-animation-play-state'] = 'running';
					} else {
						$(that.$el).off('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd');
					}
				});
			}
			$(this.$el).bind("contextmenu", function(e){
					g_menu.style.left = e.pageX+"px";
					g_menu.style.top = e.pageY+"px";
					g_menu.style.display = "block";
					g_menu.type = '';
					g_menu.com_id = that.prop.id;
					g_menu.subcom_id = "";
					g_menu.savecom_menu = true;
			    return false;
			});
		},
		methods:{
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
					e.preventDefault();
	      	e.stopPropagation();
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				
				e.preventDefault();
	      e.stopPropagation();
			}
		}
	});
	/******************聊天互动组件--实现*************/
	var chatCom = Vue.component('chat-com', {
		props:['prop', 'curr_com_id', 'msgs', 'coms', 'phone_size', 'phone_pos'],
		template:'<div :id="prop.id" :class="{\'phone-component\':true}"  c-type="chat-com" @click="onClick($event)" :style="[prop.styles.showStyle,prop.styles.posStyle,prop.styles.positionStyle,prop.styles.alphaStyle,prop.styles.bkcolorStyle]" @mouseover="onMouseOver()" @mouseout="onMouseOut()" :index="prop.index">'+
		'<div class="control-wrap" v-show="(prop.showControl || curr_com_id==prop.id) || (prop.pid && curr_sel_id==prop.id)"><span  class="ele-delete-icon" style="z-index:1001" title="删除" v-on:click="clickDel($event)">×</span></div>'+
			'<div :style="[{position:\'relative\',\'overflow-y\':\'auto\'},prop.styles.sizeStyle]">'+
				'<ul class="chat-list">'+
					'<li class="other">'+
						'<div class="user-head">'+
							'<img src="http://wx.qlogo.cn/mmopen/NGA89eK6LL4T8f79altDxEPxfNzRcbjGRlj3rf8g3ibh6ibteZNbEic3Q7ic2meYNL6ZbHpJ85zm1QCcEa56zJsqdg/0"></img>'+
						'</div>'+
						'<div class="msg-body">'+
							'<span class="msg-content" :style="[{\'background-color\':prop.styles.otherColor}]">'+
								'<p class="msg-sender">hijiang</p>'+
								'你好你好'+
							'</span>'+
						'</div>'+
					'</li>'+
					'<li class="self">'+
						'<div class="user-head">'+
							'<img src="http://wx.qlogo.cn/mmopen/NGA89eK6LL4T8f79altDxEPxfNzRcbjGRlj3rf8g3ibh6ibteZNbEic3Q7ic2meYNL6ZbHpJ85zm1QCcEa56zJsqdg/0" ></img>'+
						'</div>'+
						'<div class="msg-body">'+
							'<span class="msg-content" :style="[{\'background-color\':prop.styles.myColor}]">'+
								'<p class="msg-sender">hijiang</p>'+
								'你好你好！'+
							'</span>'+
						'</div>'+
					'</li>'+
				'</ul>'+
				'<div class="chat-control" :style="[{width:prop.phone_size.width+\'px\', position:\'fixed\',left:phone_pos.left+\'px\',\'z-index\':10001,bottom:(phone_size.docHeight-phone_pos.top-phone_size.height-phone_pos.scrollTop)+\'px\',\'background-color\':\'#fff\'}]">'+
					'<div class="chat-control-input">'+
						'<div class="attach-btn" v-show="prop.showAttachBtn" @click="onClickAttachBtn()">'+
							'<span style="">+</span>'+
						'</div>'+
						'<div class="send-btn" @click="onClickSendBtn()" v-show="!prop.showAttachBtn">发送</div>'+
						'<div class="emoji-btn" @click="onClickEmojiBtn()"></div>'+
						'<div class="input-control">'+
							'<div class="input-area" style="word-break: break-word; word-wrap: break-word;" contenteditable=true @input="onChangeInput($event)">'+
							'</div>'+
						'</div>'+
						'<div class="emoji-imgs" style="display:none">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/0.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/1.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/2.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/3.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/4.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/5.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/6.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/7.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/8.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/9.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/10.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/11.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/12.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/13.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/14.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/15.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/16.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/17.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/18.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/19.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/20.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/21.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/22.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/23.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/24.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/25.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/26.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/27.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/28.png">'+
							'<img src="http://o95rd8icu.bkt.clouddn.com/29.png">'+
						'</div>'+
					'</div>'+
					'<div class="chat-control-attach" :class="{hide:!showAttach}" style="display:none">'+
	          '<div class="attach-wrapper">'+
	            '<a href="javascript:;">'+
	              '<img src="img/upload.png" height="37" width="37">'+
	              '<p>图片</p>'+
	            '</a>'+
	            '<a href="javascript:;">'+
	              '<img src="./img/input-voice.png" height="37" width="37">'+
	              '<p>语音</p>'+
	            '</a>'+
	            '<a href="javascript:;">'+
	              '<img src="img/reward.png" height="37" width="35">'+
	              '<p>打赏</p>'+
	            '</a>'+
	          '</div>'+
	        '</div>'+
				'</div>'+
				'<div style="clear:both;height:5rem;"></div>'+
			'</div>'+
		'</div>',
		created:function() {
			this.showAttach = false;
		},
		mounted:function(){
			var that = this;
			$(that.$el).find(".chat-control-attach").css('display','');
			$(this.$el).find(".emoji-imgs img").click(function() {
				var clone_html = $(this).clone();
				$(that.$el).find(".input-area").append(clone_html);
			});
			
			var mouseClickEvent = "click."+this.prop.id;
			$(document).on(mouseClickEvent, function(e) {
				$(that.$el).find(".emoji-imgs").hide();
				that.showAttach = false;
				$(that.$el).find(".input-area").blur();
			});
			var that = this;
			var innerHeight = $(this.$el).innerHeight();
			for(var i = 0;i < this.coms.length; i++) {
				if(this.coms[i].c_type == "margin-com") {
					this.coms[i].prop.styles.marginStyle['margin-bottom'] = innerHeight+'px';
				}
			}
			
			var otherComsHeight = 0;
			console.log(this.coms);
			for(var i = 0; i < this.coms.length; i++) {
				if(this.coms[i].prop.id != this.prop.id) {
					if(this.coms[i].c_type != "bottomnav-com") {
						if(this.prop.mounted_com_id) {
							if(this.coms[i].prop.mounted_com_id != this.prop.mounted_com_id) {
								otherComsHeight += $('#'+this.coms[i].prop.id).outerHeight();
							}
						} else {
							otherComsHeight += $('#'+this.coms[i].prop.id).outerHeight();
						}
					}
				}
			}
			
			if(otherComsHeight >= this.phone_size.height) {
				alert('手机已经被填满'+otherComsHeight+","+this.phone_size.height);
				return;
			}
			
			var viewheight = this.phone_size.height - otherComsHeight;
			that.prop.styles.sizeStyle.height = viewheight+"px";
		},
		methods:{
			onClickSendBtn:function() {
				$(this.$el).find(".input-area").html("");
				$(this.$el).find(".emoji-imgs").hide();
				this.prop.showAttachBtn = true;
			},
			onClickAttachBtn:function(e) {
				this.showAttach = !this.showAttach;
			},
			onChangeInput:function(e) {
				var val = $(e.target).html();
				if(val == "") {
					this.prop.showAttachBtn = true;
				} else {
					this.prop.showAttachBtn = false;
				}
			},
			onClickEmojiBtn:function() {
				$(this.$el).find(".emoji-imgs").toggle();	
			},
			onMouseDownMoveHandle:function(e) {
				this.$emit('onMouseDownMoveHandle', e, this.prop);
				this.prop.sorting = true;
				this.prop.styles.positionStyle.position = "absolute";
				var scrollTop = $(".phone-content").scrollTop();
				this.prop.styles.posStyle.left = $(this.$el).position().left+"px";
				this.prop.styles.posStyle.top = ($(this.$el).position().top+scrollTop)+"px";
				this.prop.styles.indexStyle['z-index'] = 11;
				this.prop.styles.alphaStyle.opacity = 0.5;
				this.prop.styles.orgPos.left = $(this.$el).position().left;
				this.prop.styles.orgPos.top = $(this.$el).position().top;
				this.prop.styles.orgPos.height = $(this.$el).height();
				
				g_page.coms.insert(this.prop.index+1, {
					c_type:'alert',
					prop:{
						styles:{
							heightStyle:{
								height:this.prop.styles.orgPos.height+'px'
							}
						}
					}
				});
				
				markComIndex();
				e.preventDefault();
	      e.stopPropagation();
			},
			onMouseOver:function() {
				this.prop.showControl = true;
			},
			onMouseOut:function() {
				this.prop.showControl = false;
			},
			onClick:function(e) {
				if(this.prop.pid) {
					this.$emit('onClickSubCom', this.prop.id);
					e.preventDefault();
	        e.stopPropagation();
				} else {
					g_edit_panel.curr_com_id = this.prop.id;
					g_page.curr_com_id = this.prop.id;
					e.preventDefault();
	      	e.stopPropagation();
				}
			},
			clickDel:function(e) {
				if(this.prop.pid) {
					this.$emit('delInnerCom', this.prop.id);
				} else {
					for(var i = 0; i < g_page.coms.length; i++) {
						if(g_page.coms[i].prop.id == this.prop.id) {
							g_page.coms.splice(i, 1);
							break;
						}
					}
					markComIndex();
					g_page.curr_com_id = "";
					g_edit_panel.curr_com_id = "";
				}
				
				e.preventDefault();
	      e.stopPropagation();
			}
		}
	});
	
	var marginCom = Vue.component('margin-com', {
		props:['prop'],
		template:'<div :style="prop.styles.marginStyle" class="margin-com"></div>'
	});
	
	var alertCom = Vue.component('alert-com', {
		props:['prop'],
		template:'<div :style="[{border:\'1px dashed red\'},prop.styles.heightStyle]" c-type="alert">放到这里</div>'
	});
	
	g_phoneRoot = Vue.component('phone-root', {
		props:['coms', 'curr_com_id', 'phone_size', 'phone_pos','curr_page'],
		template:
		'<div class="phone-root" style="margin-left:3rem;padding-left:28px;padding-right:28px;padding-top:115px;padding-bottom:125px;" id="componentList" @click="onClickRoot()" @mousemove="onMouseMove($event)" @mouseup="onMouseUp($event)">'+
				'<div class="phone-content droppable-target" :style="[{width:\'100%\',height:\'100%\',\'overflow-y\':\'auto\',background:curr_page.background}]">'+
					'<div id="phone-component-list" class="list-group" style="margin:0px">'+
					  '<template v-for="com in coms" :curr_com_id="curr_com_id" @click="onClickRoot()">'+
					  	'<text-com  v-if="com.c_type==\'text\'" :prop="com.prop" :curr_com_id="curr_com_id"></text-com>'+
					  	'<map-com  v-if="com.c_type==\'map-com\'" :prop="com.prop" :curr_com_id="curr_com_id"></map-com>'+
					  	'<topnav-com  v-if="com.c_type==\'topnav-com\'" :phone_size="phone_size" :phone_pos="phone_pos" :prop="com.prop" :curr_com_id="curr_com_id"></topnav-com>'+
					  	'<bottomnav-com v-if="com.c_type==\'bottomnav-com\'" :phone_pos="phone_pos" :phone_size="phone_size" :coms="coms" :prop="com.prop" :curr_com_id="curr_com_id"></bottomnav-com>'+
					  	'<alert-com v-if="com.c_type==\'alert\'" :prop="com.prop"></alert-com>'+
					  	'<free-panel v-if="com.c_type==\'free-panel\'" :coms="coms" :prop="com.prop" :curr_com_id="curr_com_id"></free-panel>'+
					  	'<img-com v-if="com.c_type==\'img\'" :prop="com.prop" :curr_com_id="curr_com_id"></img-com>'+
					  	'<btn-com v-if="com.c_type==\'btn\'" :prop="com.prop" :curr_com_id="curr_com_id"></btn-com>'+
					  	'<floatbtn-com @onMouseDownMoveHandle="onRootMouseDownMoveHandle"  v-if="com.c_type==\'floatbtn-com\'" :phone_pos="phone_pos" :prop="com.prop" :curr_com_id="curr_com_id"></floatbtn-com>'+
					  	'<title-com v-if="com.c_type==\'title\'" :prop="com.prop" :curr_com_id="curr_com_id"></title-com>'+
					  	'<carousel-com v-if="com.c_type==\'carousel\'" :prop="com.prop" :curr_com_id="curr_com_id"></carousel-com>'+
					  	'<pictxt-set-com v-if="com.c_type==\'pic-txt-set\'" :prop="com.prop" :curr_com_id="curr_com_id"></pictxt-set-com>'+
					  	'<piclist-com v-if="com.c_type==\'pic-list\'" :prop="com.prop" :curr_com_id="curr_com_id"></piclist-com>'+
					  	'<category-com v-if="com.c_type==\'category\'" :prop="com.prop" :curr_com_id="curr_com_id"></category-com>'+
					  	'<livevideo-com v-if="com.c_type==\'livevideo-com\'" :prop="com.prop" :curr_com_id="curr_com_id"></livevideo-com>'+
					  	'<normal-panel v-if="com.c_type==\'normal-panel\'" :prop="com.prop" :curr_com_id="curr_com_id"></normal-panel>'+
					  	'<margin-com v-if="com.c_type==\'margin-com\'" :prop="com.prop" :curr_com_id="curr_com_id"></margin-com>'+
					  	'<chat-com v-if="com.c_type==\'chat-com\'" :phone_size="phone_size" :phone_pos="phone_pos" :coms="coms" :prop="com.prop" :curr_com_id="curr_com_id" :msgs="com.msgs"></chat-com>'+
					  	'<goodslist-com v-if="com.c_type==\'goodslist-com\'" :phone_size="phone_size" :phone_pos="phone_pos" :coms="coms" :prop="com.prop" :curr_com_id="curr_com_id" ></goodslist-com>'+
					  	'<videolist-com v-if="com.c_type==\'videolist-com\'" :phone_size="phone_size" :phone_pos="phone_pos" :coms="coms" :prop="com.prop" :curr_com_id="curr_com_id" ></videolist-com>'+
					  	'<line-com v-if="com.c_type==\'line-com\'" :prop="com.prop" :curr_com_id="curr_com_id" ></line-com>'+
					  	'<usercenter-com v-if="com.c_type==\'usercenter-com\'" :prop="com.prop" :curr_com_id="curr_com_id" ></usercenter-com>'+
					  	'<component v-if="com.c_type==\'custom-com\'" :is="com.subtype" :prop="com.prop" :com="com" :curr_com_id="curr_com_id"></component>'+
					  '</template>'+
					'</div>'+
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
			  }
		  }
	});
});