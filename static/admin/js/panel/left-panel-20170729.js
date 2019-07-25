$(function() {
	
	var pageItem = Vue.component('page-item', {
		props:['page','curr_page_id'],
		template:'<div class="panel-body" style="padding:5px;padding-left:40px;position:relative;"><i class="icon icon-file-empty"></i><span  :style="page.page_id==curr_page_id?\'color:#efbf1f;margin-left:10px;font-weight:bold;text-decoration:none;cursor:default\':\'color:#2b2b2b;margin-left:10px;text-decoration:none;cursor:pointer\'" v-if="!edit" v-html="page.page_name" @click="onClickPage()"></span><input v-if="edit" :value="page.page_name" v-model="page.page_name" style="width:40%;margin-left:10px;"></input><span style="background-color:#efbf1f;padding-left:5px;padding-right:5px;padding-bottom:2px;color:#fff;padding-top:2px;border-radius:10%;cursor:pointer;" v-if="edit" @click="confirmEdit()">确定</span><span style="background-color:#ddd;padding-left:5px;padding-right:5px;padding-bottom:2px;color:#fff;padding-top:2px;border-radius:10%;cursor:pointer;margin-left:10px" v-if="edit" @click="onCancelEdit()">取消</span><div style="position:absolute;right:5px;top:8px;color:#6b6b6b;" class="page-tool" v-if="!edit">'+
					      	'<span title="复制" @click="copyPage()" class="icon icon-files-empty group-item-tool" ></span>'+
					      	'<span title="编辑名称" @click="editPageName()" class="icon icon-pencil group-item-tool"></span>'+
					      	'<span title="删除" @click="delPage()" class="icon icon-bin group-item-tool"></span>'+
					      '</div></div>',
		data:function() {
			return {
				edit:false
			};
		},
		methods:{
			onClickPage:function() {
				location.href=g_host_url+"/admin/page_manager_page?page_id="+this.page.page_id;
			},
			editPageName:function() {
				this.edit = true;
			},
			onCancelEdit:function() {
				this.edit = false;
			},
			confirmEdit:function() {
				var that = this;
				API.invokeCall('updatePageName', this.page, function(json) {
					if(json.code == 0) {
						that.edit = false;
					}
				});
			},
			copyPage:function() {
				var that = this;
				if(this.page.debug_page_conf_file != "") {
					$LAB.script(this.page.debug_page_conf_file+"?v="+this.page.debug_page_version).wait(function() {
						var page_conf;
						if(that.page.page_id != that.curr_page_id) {
							page_conf = JSON.stringify(window['g_coms'+that.page.page_id]);
						} else {
							page_conf = JSON.stringify(g_page.coms);
						}
						API.invokeCall('copyPage',{page:that.page, page_conf:page_conf}, function(json) {
								if(json.code == 0) {
									that.$emit('copypage',json.page); 
								}
						});
					});
				} else {
					alert("该页面还没有保存过哦！");
				}
			},
			delPage:function() {
				var that = this;
				if(this.page.page_id == this.curr_page_id) {
					alert('正在编辑该页面，无法删除，请删除其他页面');
					return;
				}
				if(confirm('确定删除?')) {
					API.invokeCall('delPage', this.page, function(json) {
						if(json.code == 0) {
							that.$emit('delpage', that.page.page_id);
						}
					});
				}
			}
		}
	});
	
	var pageGroupItem = Vue.component('page-group-item',{
			props:['page_group','pages','curr_page_id','curr_group_id'],
			template:'<div class="panel panel-default" style="position:relative">'+
							    '<div class="panel-heading">'+
							      '<h4 class="panel-title" style="cursor:pointer" @click="onSelGroup()">'+
							      	'<i class="icon icon-folder"></i>'+
							        '<span v-if="!edit" v-html="page_group.group_name" style="margin-left:10px"></span>'+
							        '<input v-if="edit" :value="page_group.group_name" v-model="page_group.group_name" style="width:40%;background-color:#f5f5f5;margin-left:10px;"></input>'+
							      '</h4>'+
							      '<div v-if="!edit" style="position:absolute;right:5px;top:8px;color:#6b6b6b;" class="page-group-tool">'+
							      	'<span title="添加页面" @click="onAddPage()" class="icon icon-plus group-item-tool" ></span>'+
							      	'<span title="编辑组名" @click="editName()" class="icon icon-pencil group-item-tool"></span>'+
							      	'<span title="删除" @click="delPageGroup()" class="icon icon-bin group-item-tool"></span>'+
							      '</div>'+
							      '<div style="position:absolute;right:5px;top:8px;color:#6b6b6b;" class="page-group-tool" v-if="edit">'+
								      '<span style="background-color:#efbf1f;padding-left:5px;padding-right:5px;padding-bottom:2px;color:#fff;padding-top:2px;border-radius:10%;cursor:pointer;" v-if="edit" @click="confirmEdit()">确定</span><span style="background-color:#ddd;padding-left:5px;padding-right:5px;padding-bottom:2px;color:#fff;padding-top:2px;border-radius:10%;cursor:pointer;margin-left:10px" v-if="edit" @click="onCancelEdit()">取消</span>'+
							      '</div>'+
							    '</div>'+
							    '<div :class="[\'panel-collapse\',page_group.group_id==curr_group_id?\'in\':\'collapse\']">'+
							    	'<template v-for="page in pages">'+
							      	'<page-item :page="page" :curr_page_id="curr_page_id" v-if="page.group_id==page_group.group_id" @delpage="delPage" @copypage="copyPage"></page-item>'+
							      '</template>'+
							    '</div>'+
							 '</div>',
			data:function() {
				return {
					edit:false
				};
			},
			methods:{
				onSelGroup:function() {
					this.$emit('onselgroup', this.page_group.group_id);
				},
				delPageGroup:function() {
					API.invokeCall('delPageGroup', this.page_group, function(json) {
						if(json.code == 0) {
							alert('删除成功');
							location.reload();
						}
					});
				},
				editName:function() {
					this.edit = true;
				},
				onCancelEdit:function() {
					this.edit = false;
				},
				delPage:function(page_id) {
					for(var i = 0;i < this.pages.length; i++) {
						if(this.pages[i].page_id == page_id) {
							this.pages.splice(i,1);
							break;
						}
					}
				},
				copyPage:function(page) {
					this.pages.push(page);
				},
				onAddPage:function() {
					g_dlgCreatePage.show = true;
					g_dlgCreatePage.page.group_id = this.page_group.group_id;
				},
				confirmEdit:function() {
					var that = this;
					API.invokeCall('updatePageGroupName', this.page_group, function(json) {
						if(json.code == 0) {
							that.edit = false;
						}
					});
				}
			}
	});
	
	var page_panel = new Vue({
		el:'#ID_leftPanel',
		data:{
			app_id:g_app_id,
			pages:g_pages,
			page_groups:g_page_groups,
			curr_page_id:g_curr_page,
			curr_group_id:g_curr_group,
			curr_com_type:'base',
			cls: {
				collapse:'collapse',
				'in':'in'
			}
		},
		methods:{
			moreCom:function() {
				g_moreComDlg.show = true;
			},
			onSwitchComType:function(t) {
				this.curr_com_type = t;
			},
			addCom:function(c_type) {
				if(c_type == 'text-com') {
					addTextCom();
				} else if(c_type == 'img-com') {
					addImgCom();
				} else if(c_type == 'btn-com') {
					addBtnCom();
				} else if(c_type == 'title-com') {
					addTitleCom();
				} else if(c_type == 'carousel-com') {
					addCarouselCom();
				} else if(c_type == 'category-com') {
					addCategoryCom();
				} else if(c_type == 'piclist-com') {
					addPicListCom();
				} else if(c_type == 'pictxt-set-com') {
					addPicTxtSetCom();
				} else if(c_type == "floatbtn-com") {
					addFloatBtnCom();
				} else if(c_type == 'map-com') {
					addMapCom();
				} else if(c_type == "normal-panel") {
					addNormalPanel();
				} else if(c_type == "free-panel") {
					addFreePanel();
				} else if(c_type == "topnav-com") {
					addTopNavCom();
				} else if(c_type == "bottomnav-com") {
					addBottomNavCom();
				} else if(c_type == "livevideo-com") {
					addLiveVideoCom();
				} else if(c_type == "chat-com") {
					addChatCom();
				} else if(c_type == "videolist-com") {
					addVideoListCom();
				} else if(c_type == "goodslist-com") {
					addGoodsListCom();
				} else if(c_type == "line-com") {
					addLineCom();
				} else if(c_type == "usercenter-com") {
					addUsercenterCom();
				}
			},
			createPageGroup:function() {
				g_dlgCreatePageGroup.show = true;
			},
			createPage:function() {
				g_dlgCreatePage.show = true;
			},
			onSelGroup:function(new_id) {
				this.curr_group_id = new_id;
			}
		}
	});

	function hasBottomNav() {
		if(g_page.coms.length < 2) {
			return false;
		}
		
		for(var i = 0; i < g_page.coms.length; i++) {
			if(g_page.coms[i].c_type == "bottomnav-com") {
				return true;
			}
		}
		return false;
	}
	
	function addLineCom() {
		var com_id = guid();
		var iIndex = 0;
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		
		g_page.coms.insert(iIndex, {
			c_type:'line-com',
			prop:{
				styles:{
					sizeStyle:{
						'height':'10px'
					},
					marginStyle:{
						'margin-left':'0px',
						'margin-right':'0px'
					},
					bkcolorStyle:{
						'background-color':'#999'
					},
					borderStyle:{
						'border-style':'none',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'0px'
					},
					positionStyle:{
						position:'relative'
					},
					indexStyle:{
						'z-index':10
					}
				},
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	function addTopNavCom() {
		for(var i = 0;i < g_page.coms.length; i++) {
			if(g_page.coms[i].c_type == 'topnav-com') {
				new $.zui.Messager('已经有顶部导航啦！', {
		        icon: 'bell' // 定义消息图标
		    }).show();
		    return;
			}
		}
		var com_id = guid();
		g_page.coms.insert(0, {
			c_type:'topnav-com',
			prop:{
				phone_pos:g_page.phone_pos,
				phone_size:g_page.phone_size,
				title:'首页导航',
				leftBtn:{
					use:"true",
					text:'返回',
					defaultStyle:{
						position:'absolute',
						display:'block',
						left:'0px',
						top:'0px',
						height:'100%',
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'32px',
						'padding-top':'10px',
						'padding-bottom':'10px'
					},
					fontStyle:{
						'font-size':'16px',
						'color':'#ffffff'
					},
					fontPosStyle:{
						left:'0px'
					},
					sizeStyle:{
						'width':'56px'
					},
					action:{//点击动作
						type:'none',
						subtype:'none',
						param:""
					},
					imgSrc:''
				},
				rightBtn:{
					use:"false",
					text:'返回',
					defaultStyle:{
						position:'absolute',
						display:'block',
						right:'0px',
						top:'0px',
						height:'100%',
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'32px',
						'padding-top':'10px',
						'padding-bottom':'10px'
					},
					fontStyle:{
						'font-size':'16px',
						'color':'#ffffff'
					},
					fontPosStyle:{
						right:'0px'
					},
					sizeStyle:{
						'width':'56px'
					},
					action:{//点击动作
						type:'none',
						subtype:'none',
						param:""
					},
					imgSrc:''
				},
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					fontStyle:{
						'font-size':'16px',
						'font-weight':'bold',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#ffffff'
					},
					marginStyle:{
						'margin-top':'0px'
					},
					sizeStyle:{
						'height':'40px',
						'line-height':'40px'
					},
					bkcolorStyle:{
						'background-color':'#34b6fd'
					}
				},
				
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addTextCom() {
		var com_id = guid();
		var iIndex = 0;
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		
		g_page.coms.insert(iIndex, {
			c_type:'text-com',
			prop:{
				currAnimateIndex:0,
				animates:[],
				sorting:false,
				text:'文本内容',
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					fontStyle:{
						'font-size':'16px',
						'font-weight':'normal',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#666666'
					},
					alignStyle:{
						'text-align':'center',
					},
					sizeStyle:{
						'height':'30px'
					},
					lhStyle:{
						'line-height':'30px'
					},
					marginStyle:{
						'margin-top':'0px'
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					bkcolorStyle:{
						'background-color':'#ffffff'
					},
					borderStyle:{
						'border-style':'none',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'0px'
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					indexStyle:{
						'z-index':10
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					animateStyle:{},
				},
				action:{//点击动作
					type:'none',
					//none:无动作，page_act：打开页面，fun_act：其他功能（领取优惠券或者其他的）
					subtype:'none',
					param:""
				},
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addImgCom() {
		var com_id = guid();
		var iIndex = 0;
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		
		var com_id = guid();
		g_page.coms.push({
			c_type:'img-com',
			prop:{
				currAnimateIndex:0,
				animates:[],
				sorting:false,
				src:'http://oeu8cw34d.bkt.clouddn.com/default.png',
				showControl:false,
				index:0,
				id:com_id,
				action:{//点击动作
					type:'none',
					//none:无动作，page：打开页面，fun：其他功能（拨打电话）
					subtype:'none',
					param:""
				},
				widthMode:"100",
				heightMode:"auto",
				
				styles:{
					animateStyle:{},
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					marginStyle:{
						'margin-right':'0px',
						'margin-left':'0px',
						'margin-top':'0px',
						'margin-bottom':'0px'
					},
					borderStyle:{
						'border-style':'none',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'0px'
					},
					alignStyle:{
						'text-align':'center'
					},
					sizeStyle:{
						width:"auto",
						height:"auto"
					}
				}
			}
		});
		g_edit_panel.curr_com_id = com_id;
		markComIndex();
	}
	
	function addBtnCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'btn-com',
			sorting:false,
			prop:{
				currAnimateIndex:0,
				animates:[],
				text:"按钮",
				action:{//点击动作
					type:'none',
					subtype:'none',
					param:""
				},
				styles:{
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					indexStyle:{
						'z-index':10
					},
					positionStyle:{
						position:'relative'
					},
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					fontStyle:{
						'font-size':'14px',
						'font-weight':'normal',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#fff'
					},
					sizeStyle:{
						width:"100px",
						'line-height':"30px"
					},
					marginStyle:{
						'margin-top':'0px',
						'margin-right':'auto',
						'margin-left':'auto'
					},
					innerAlignStyle:{
						'text-align':'center'
					},
					alignStyle:{
						'text-align':'center'
					},
					bkcolorStyle:{
						'background-color':"#3c3c3c"
					},
					borderStyle:{
						'border-style':'none',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'0px'
					},
					animateStyle:{
					}
				},
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addTitleCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'title-com',
			sorting:false,
			prop:{
				currAnimateIndex:0,
				animates:[],
				
				text:'标题',
				showControl:false,
				index:0,
				id:com_id,
				styles:{
					animateStyle:{},
					fontStyle:{
						'font-size':'14px',
						'font-weight':'normal',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#666666'
					},
					markColorStyle:{
						'color':'#000000',
						'background-color':'#000000'
					},
					sizeStyle:{
						width:"100%",
						'line-height':"30px",
						'height':"30px"
					},
					marginStyle:{
						'margin-top':'0px',
						'margin-left':'auto',
						'margin-right':'auto'
					},
					innerAlignStyle:{
						'text-align':'center'
					},
					alignStyle:{
						'text-align':'left'
					},
					bkcolorStyle:{
						'background-color':"#ffffff"
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					borderStyle:{
						'border-style':'solid',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'2px'
					},
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					}
				},
				action:{//点击动作
					type:'none',
					subtype:'none',
					param:""
				}
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addCarouselCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'carousel-com',
			sorting:false,
			prop:{
				currAnimateIndex:0,
				animates:[],
				interval:2,
				heightMode:"auto",
				styles:{
					animateStyle:{},
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						height:'auto',
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					}
				},
				figureColor:{
					'background-color':'#ff0000'
				},
				figureAlign:"left",
				figureType:"dot",
				slideList:[
					{
			      "clickUrl": "#",
			      "desc": "nhwc",
			      "image": "http://dummyimage.com/1745x492/f1d65b",
			      action:{
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      "clickUrl": "#",
			      "desc": "hxrj",
			      "image": "http://dummyimage.com/1745x492/40b7ea",
			      action:{
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      "clickUrl": "#",
			      "desc": "rsdh",
			      "image": "http://dummyimage.com/1745x492/40b7ea",
			      action:{
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    }
				],
				currentIndex:0,
				showControl:false,
				index:0,
				timer:'',
				id:com_id
			}
		});
		
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addCategoryCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'category-com',
			sorting:false,
			prop:{
				sorting:false,
				currentIndex:0,
				
				styles:{
					active_color:"#28c3fd",
					outterStyle:{
						'padding-top':'0px',
						'padding-bottom':'0px'
					},

					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},

					itemStyle:{
						'float':'left',
						'position':'relative',
						'border-color':"#28c3fd",
						'border-bottom':'2px solid transparent',
						'color':'',
						'border-bottom-color':'transparent',
					},
					fontStyle:{
						'color':'#000000',
						'font-size':'14px',
						'font-style':'normal',
						'font-weight':'normal',
						'text-decoration':'none',
						'text-align':'center'
					},
					bkcolorStyle:{
						'background-color':'#fff'
					}
				},
				items:[
					{
			      "title": "小程序",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
			      "image": "http://dummyimage.com/1745x492/f1d65b",
			      attach_com_id:"",
			      attach_com_type:""
			    },
			    {
			      "title": "互联网",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
			      "image": "http://dummyimage.com/1745x492/40b7ea",
			      attach_com_id:"",
			      attach_com_type:""
			    },
			    {
			      "title": "微信营销",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
			      "image": "http://dummyimage.com/1745x492/40b7ea",
			      attach_com_id:"",
			      attach_com_type:""
			    },
			    {
			      "title": "创业沙龙",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
			      "image": "http://dummyimage.com/1745x492/40b7ea",
			      attach_com_id:"",
			      attach_com_type:""
			    }
				],
				showControl:false,
				index:0,
				id:com_id
			}
		});
		
		g_edit_panel.curr_com_id = com_id;
		g_page.curr_com_id = com_id;
	}
	
	function addPicListCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'piclist-com',
			sorting:false,
			prop:{
				col:2,
				
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},

					mode:1,
					itemFontStyle:{
						'font-size':'20px',
						'font-weight':'normal',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#fff'
					},
					itemMarginStyle:{
						'margin-left':'20px',
						'margin-top':'10px'
					},
					markColorStyle:{
						'color':'#000000',
						'background-color':'#000000'
					},
					itemHeightStyle:{
						height:'auto'
					},
					itemBorderStyle:{
						'border-radius':'0px'
					},
					marginStyle:{
						'margin-top':'0px',
						'margin-left':'0px',
						'margin-right':'0px',
						'margin-bottom':'0px'
					},
					innerAlignStyle:{
						'text-align':'center'
					},
					alignStyle:{
						'text-align':'left'
					},
					bkcolorStyle:{
						'background-color':"#ffffff"
					},
					borderStyle:{
						'border-style':'solid',
						'border-width':'0px',
						'border-color':'#000000',
						'border-radius':'2px'
					}
				},
				items:[
					{
			      "clickUrl": "#",
			      "desc": "图片1",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      "clickUrl": "#",
			      "desc": "图片2",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      "clickUrl": "#",
			      "desc": "图片3",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      "clickUrl": "#",
			      "desc": "图片4",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png",
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    }
				],
				showControl:false,
				index:0,
				id:com_id
			}
		});
		
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addPicTxtSetCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'pictxt-set-com',
			sorting:false,
			prop:{
				items:[
					{
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
  					title:'标题',
			      "desc": "图文简介",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png"
			    },
			    {
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
  					title:'标题',
			      "desc": "图文简介",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png"
			    },
			    {
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					},
  					title:'标题',
			      "desc": "图文简介",
			      "image": "http://oeu8cw34d.bkt.clouddn.com/default.png"
			    }
				],
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					mode:1,
					itemTitleStyle:{
						'font-size':'21px',
						'font-weight':'bold',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#666666',
						'text-overflow': 'ellipsis',
						'text-align':'left',
						'text-indent': '10px',
						'line-height': '1.6em',
						'margin':'0px'
					},
					itemDescStyle:{
						'font-size':'14px',
						'font-weight':'normal',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#666666',
						'margin':'0px',
						'text-overflow': 'ellipsis',
						'text-indent':'10px',
						'line-height':'1.6em',
						'text-align': 'left'
					},

					bkcolorStyle:{
						'background-color':"#fff"
					},
					itemBkColorStyle:{
						'background-color':"#ebebeb"
					},
					marginStyle:{
						'margin-top':'10px',
						'margin-left':'0px',
						'margin-right':'0px'
					},
					
					itemMarginStyle:{
						'margin-top':'3px'
					},
					itemImageSizeStyle:{
						width:"70px",
						height:'auto'
					},
					itemImageMarginStyle:{
						'margin-left':'0px'
					},
					itemHeightStyle:{
						'line-height':"80px"
					}
				},
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addNormalPanel() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex, {
			c_type:'normal-panel',
			prop:{
				currAnimateIndex:0,
				animates:[],
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					isrealheight:false,
					isfillleft:false,
					viewheight:200,//可视高度
					realheight:200,//实际高度
					shadow_color:'#000000',
					animateStyle:{},
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						width:'100%',
						'min-height':'60px',
						height:'200px',
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					outterStyle:{
						'overflow-y':'auto',
						'overflow-x':'hidden',
						'margin-left':'0px',
						'margin-top':'0px',
						'background-color':'#ffffff'
					},
					showStyle:{
						display:'block'
					}
				},
				curr_sel_id:"a",
				subcoms:[],
				index:0,
				id:com_id,
				showControl:false
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addFreePanel() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex, {
			c_type:'free-panel',
			sorting:false,
			startPos:{
				x:0,
				y:0
			},
			eleSize: {
				width:0,
				height:0
			},
			startOffset:{
				left:0,
				right:0
			},
			containerSize:{
				width:0,
				height:0
			},
			prop:{
				sortable:true,
				gridSize:20,
				alignToGrid:false,
				gridColor:"rgba(255,0,0,0.2)",
				showGrid:true,
				
				styles:{
					showStyle:{
						'display':'block'
					},
					isrealheight:false,
					isfillleft:false,
					viewheight:200,//可视高度
					realheight:200,//实际高度
					
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					sizeStyle:{
						height:'200px',
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					bkcolorStyle:{
						'background-color':"#ffffff"
					},
					gridStyle:{
						'background-image':'-webkit-linear-gradient(top, transparent 18px, rgba(255,0,0,0.2) 19px, transparent 20px), -webkit-linear-gradient(left, transparent 18px, rgba(255,0,0,0.2) 19px,transparent 20px)',
						'background-size':'20px 20px',
						'background-repeat':'repeat repeat'
					},
					outterStyle:{
						'overflow-y':'auto',
						'overflow-x':'hidden',
						'border-width':'1px !important',
						'border-style':'dashed', 
						'border-color':'gray',
						'margin-left':'0px',
						'margin-top':'0px'
					},
					cursorStyle:{
						cursor:'pointer'
					}
				},
				action:{
					type:'none',
					subtype:'none',
					param:""
				},
				curr_sel_id:"a",
				subcoms:[],
				index:0,
				id:com_id,
				showControl:false
			}
		});

		g_edit_panel.curr_com_id = com_id;
	}
	
	function addUsercenterCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex, {
			c_type:'usercenter-com',
			prop:{
				addr:true,
				order:true,
				cart:true,
				item:true,
				showControl:false,
				bkimg:'http://img.weiye.me/zcimgdir/album/file_59468b372d932.jpg',
				id:com_id,
			}
		});
	}
	
	function addMapCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'map-com',
			prop:{
				text:'地图名称',
				resolved:true,
				bindPlace:'深圳市宝安区流塘阳光',
				showAttachBtn:true,
				styles:{
					cursorStyle:{
						cursor:'pointer'
					},
					showStyle:{
						'display':'block'
					},
					indexStyle:{
						'z-index':10
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					sizeStyle:{
						height:'300px',
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					
					fontStyle:{
						'font-size':'20px',
						'font-weight':'bold',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#000000'
					},
					marginStyle:{
						'margin-top':'0px',
						'margin-left':'0px'
					},
					bkcolorStyle:{
						'background-color':'#000000'
					},
					alignStyle:{
						'text-align':'center'
					}
				},
				
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	/*
	function addMapCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'line-com',
			prop:{
				styles:{
					indexStyle:{
						'z-index':10
					},
					positionStyle:{
						position:'relative'
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					sizeStyle:{
						height:'10px',
						width:'100%'
					},
				
					marginStyle:{
						'margin-top':'0px',
						'margin-left':'0px'
					},
					bkcolorStyle:{
						'background-color':'#000000'
					}
				},
				
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	*/
	function addBottomNavCom() {
		for(var i = 0;i < g_page.coms.length; i++) {
			if(g_page.coms[i].c_type == 'bottomnav-com') {
				new $.zui.Messager('已经有底部导航啦！', {
		        icon: 'bell' // 定义消息图标
		    }).show();
		
		    return;
			} else if(g_page.coms[i].c_type == "chat-com") {
				if(!g_page.coms[i].prop.mounted_com_id) {
					new $.zui.Messager('已存在聊天界面，底部导航会覆盖聊天输入部分，您可以将聊天组件挂载到分栏组件中！', {
			        icon: 'bell' // 定义消息图标
			    }).show();
			  
			    return;
			  }
			}
		}
		
		var margincom_id = guid();
		g_page.coms.insert(g_page.coms.length,{
			c_type:'margin-com',
			prop:{
				styles:{
					marginStyle:{
						'margin-bottom':'0px'
					}
				}
			}
		});
		
		var com_id = guid();
		g_page.coms.insert(g_page.coms.length,{
			c_type:'bottomnav-com',
			sorting:false,
			prop:{
				phone_pos:g_page.phone_pos,
				phone_size:g_page.phone_size,
				styles:{
					showStyle:{
						display:'block'
					},
					hotTextColor:{
						'color':'#666'
					},
					fontStyle:{
						color:'#666',
						'font-size':'14px',
						'font-weight':'normal',
						'font-style':'normal'
					},
					paddingStyle:{
						'padding-top':'5px',
						'padding-bottom':'0px',
						'padding-left':'0px',
						'padding-right':'0px'
					},
					imgSizeStyle:{
						width:'30px',
						height:'30px'
					},
					bkcolorStyle:{
						'background-color':'#fff'
					}
				},
				items:[
					{
			      imgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      hotImgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      text:'标签',
			      link:'',
			      
			      action:{//点击动作
  						type:'page',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      imgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      hotImgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      text:'标签',
			      link:'',
			      
			      action:{//点击动作
  						type:'page',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      imgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      hotImgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      text:'标签',
			      link:'',
			      
			      action:{//点击动作
  						type:'page',
  						subtype:'none',
  						param:""
  					}
			    },
			    {
			      imgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      hotImgSrc:'http://oeu8cw34d.bkt.clouddn.com/default.png',
			      text:'标签',
			      link:'',
			      
			      action:{//点击动作
  						type:'none',
  						subtype:'none',
  						param:""
  					}
			    }
				],
				currentIndex:0,
				showControl:false,
				index:0,
				timer:'',
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addLiveVideoCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex, {
			c_type:'livevideo-com',
			prop:{
				currAnimateIndex:0,
				animates:[
				],
				curr_time:0,
				phone_pos:g_page.phone_pos,
				phone_size:g_page.phone_size,
				video:{
					title:'直播标题',
					desc:'直播描述',
					cover_img:'http://oeu8cw34d.bkt.clouddn.com/default.png',
					viewed_count:100,
					duration:2000,
					headimg:'http://toqive.com.cn/static/img/timg'
				},
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					videoColor:"rgb(255, 153, 0)",
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					animateStyle:{
						'animation-name':'',
						'animation-play-state':'running',
						'animation-iteration-count':0,
						'animation-duration':'0s',
						'animation-delay':'0s',
						'-webkit-animation-delay':'0s'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					sizeStyle:{
						height:'auto',
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					
					fontStyle:{
						'font-size':'20px',
						'font-weight':'bold',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#ffffff'
					},
					marginStyle:{
						'margin-top':'0px'
					},
					bkcolorStyle:{
						'background-color':'#000000'
					}
				},
				
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addChatCom() {
		for(var i = 0;i < g_page.coms.length; i++) {
			if(g_page.coms[i].c_type == "bottomnav-com") {
				new $.zui.Messager('已存底部导航，底部导航会覆盖聊天输入部分，您可以将聊天组件挂载到分栏组件中！', {
			        icon: 'bell' // 定义消息图标
			    }).show();
			    return;
			}
		}
		
		//判断聊天组件高度是否够
		var otherComsHeight = 0;
		for(var i = 0; i < g_page.coms.length; i++) {
			if(g_page.coms[i].c_type != "bottomnav-com") {
				otherComsHeight += $('#'+g_page.coms[i].prop.id).outerHeight();
			}
		}
		
		if(otherComsHeight >= g_page.phone_size.height) {
			//alert('手机已经被填满'+otherComsHeight+","+g_page.phone_size.height);
			alert('手机已经被填满,无法加入聊天组件');
			return;
		}
	
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'chat-com',
			prop:{
				refresh:false,
				msgs:[],
				bindType:"none",
				chatRoomID:"",
				showAttachBtn:true,
				phone_pos:g_page.phone_pos,
				phone_size:g_page.phone_size,
				video:{
					title:'我的直播',
					desc:'我的直播描述',
					cover_img:'http://toqive.com.cn/static/img/timg',
					viewed_count:100,
					duration:2000,
					headimg:'http://toqive.com.cn/static/img/timg'
				},
				styles:{
					useShadow:false,
					shadow_blur:0,
					shadow_x:0,
					shadow_y:0,
					shadow_color:'#000000',
					
					showStyle:{
						'display':'block'
					},
					videoColor:"rgb(255, 153, 0)",
					myColor:"#fff",
					otherColor:"#fff",
					shadowStyle:{
						'box-shadow':'0px 0px 0px #000000'
					},
					indexStyle:{
						'z-index':10
					},
					transformDeg:0,
					transformStyle:{
						transform:"rotateZ(0deg)",
						'-webkit-transform':"rotateZ(0deg)"
					},
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					positionStyle:{
						position:'relative'
					},
					paddingStyle:{
						'padding-left':'0px',
						'padding-right':'0px',
						'padding-top':'0px',
						'padding-bottom':'0px'
					},
					sizeStyle:{
						height:'auto',
						width:'100%'
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					},
					
					fontStyle:{
						'font-size':'20px',
						'font-weight':'bold',
						'font-style':'normal',//italic
						'text-decoration':'none',
						'color':'#ffffff'
					},
					marginStyle:{
						'margin-top':'0px'
					},
					bkcolorStyle:{
						'background-color':'#fff'
					}
				},
				
				showControl:false,
				index:0,
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addVideoListCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}
		g_page.coms.insert(iIndex,{
			c_type:'videolist-com',
			prop:{
				bind:'',
				bind_param:'',
				link:'',
				showControl:true,
				videoList:[
				],
				styles:{
					orgPos:{
						left:0,
						top:0,
						height:0
					},
					posStyle:{
						left:'0px',
						top:'0px'
					},
					btnColor:'#f60',
					positionStyle:{
						position:'relative'
					},
					bkColor:{
						'background-color':'#fff'
					},
					indexStyle:{
						'z-index':10
					},
					opacity:1,
					alphaStyle:{
						opacity:1,
						filter:"alpha(opacity=100)"
					}
				},
				id:com_id
			}
		});
		g_edit_panel.curr_com_id = com_id;
	}
	
	function addGoodsListCom() {
		var com_id = guid();
		if(hasBottomNav()) {
			iIndex = g_page.coms.length - 2;
		} else {
			iIndex = g_page.coms.length;
		}

		g_page.coms.insert(iIndex, {
				c_type:'goodslist-com',
				prop:{
					id:com_id,
					buy_btn_name:'立即购买',
					cate_id:'',
					goodsList:[
					],
					cate_mode:'fun',
					showControl:true,
					styles:{
						orgPos:{
							left:0,
							top:0,
							height:0
						},
						posStyle:{
							left:'0px',
							top:'0px'
						},
						btnColor:'#f60',
						positionStyle:{
							position:'relative'
						},
						indexStyle:{
  						'z-index':10
  					},
						opacity:1,
						alphaStyle:{
							opacity:1,
							filter:"alpha(opacity=100)"
						}
					}
				}
		});
		g_edit_panel.curr_com_id = com_id;
	}
});