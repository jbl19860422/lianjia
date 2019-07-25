Array.prototype.insert = function (index, item) {
	this.splice(index, 0, item);
};
//给组件添加上序号
function markComIndex() {
	var j = 0;
	for(var i = 0; i < g_page.coms.length;i++) {
		if(g_page.coms[i].c_type != "floatbtn-com") {
			g_page.coms[i].prop.index = j;
			j++;
		}
	}
}

function guid() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
    return v.toString(16);
  });
}

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


//$(document).scroll(function() {
//	console.log('scroll');
//	g_page.phone_pos.left = $(".phone-content").offset().left;
//	//g_page.phone_pos.top = $(".phone-content").offset().top-$(window).scrollTop();
//	//g_page.phone_pos.top = $(".phone-content").offset().top;
//	g_page.phone_pos.scrollTop = $(window).scrollTop();
//});

//$(function() {
//	//扩展数组操作
//	var g_inFreePanel = false;
//	function initDroppable() {
//		$('#multiDroppableContainer').droppable({
//	    selector: '.btn-droppable', // 定义允许拖放的元粿
//	    target: '.droppable-target',
//	    trigger:'.move-handle',
//	    start: function() {
//	    	console.log("start", g_page.coms.length);
//	    },
//	    drop: function(event) {
//        if(event.target && event.target.hasClass("phone-content")) {
//        	var c_type = event.element.attr("c-type");
//        	if(c_type == "floatbtn-com") {
//	        	var left = event.mouseOffset.left - $(".phone-content").offset().left-40;
//	    			var top = event.mouseOffset.top - $(".phone-content").offset().top-40;
//	    			var com_id = guid();
//	    			g_page.coms.insert(g_page.curr_alert_index, {
//	    				c_type:c_type,
//	    				prop:{
//	    					currAnimateIndex:0,
//	    					animates:[],
//	    					locateHor:"left",
//	    					locateVer:"top",
//	    					imgSrc:'https://1251027630.cdn.myqcloud.com/1251027630/zhichi_frontend/static/webapp/images/default.png',
//	    					action:{
//	    						type:'none',
//	    						subtype:'none',
//	    						param:''
//	    					},
//	    					styles:{
//	    						animateStyle:{},
//	    						useShadow:false,
//	    						shadow_blur:0,
//	    						shadow_x:0,
//	    						shadow_y:0,
//	    						shadow_color:'#000000',
//	    						
//	    						shadowStyle:{
//	    							'box-shadow':'0px 0px 0px #000000'
//	    						},
//	      					indexStyle:{
//	      						'z-index':12
//	      					},
//	      					transformDeg:0,
//	    						transformStyle:{
//	    							transform:"rotateZ(0deg)",
//	    							'-webkit-transform':"rotateZ(0deg)"
//	    						},
//	    						cursorStyle:{
//	    							cursor:'pointer'
//	    						},
//	    						orgPos:{
//	    							left:left,
//	    							top:top,
//	    							height:0
//	    						},
//	    						posStyle:{
//	    							left:'0px',
//	    							top:'0px'
//	    						},
//	    						borderStyle:{
//	    							'border-radius':'0px'
//	    						},
//	    						positionStyle:{
//	    							position:'fixed'
//	    						},
//	    						paddingStyle:{
//										padding:'0px'
//	    						},
//	    						sizeStyle:{
//	    							height:'80px',
//	    							width:'80px'
//	    						},
//	    						opacity:1,
//	    						alphaStyle:{
//	    							opacity:1,
//										filter:"alpha(opacity=100)"
//	    						},
//	    						
//	    						fontStyle:{
//	    							'font-size':'20px',
//	    							'font-weight':'bold',
//	    							'font-style':'normal',//italic
//	    							'text-decoration':'none',
//	    							'color':'#ffffff'
//	    						},
//	    						marginStyle:{
//	    							'margin-top':'0px'
//	    						},
//	    						bkcolorStyle:{
//	    							'background-color':'transparent'
//	    						}
//	    					},
//	    					
//	    					showControl:false,
//	    					index:0,
//	    					id:com_id
//	    				}
//	    			});
//	    		}
//        }
//		  },
//	    drag: function(event) {
//	    }
//		});
//		
//		//$("body").height( $(window).height() );
//		$(document).scroll(function() {
//			console.log('scroll');
//			g_page.phone_pos.left = $(".phone-content").offset().left;
//			//g_page.phone_pos.top = $(".phone-content").offset().top-$(window).scrollTop();
//			//g_page.phone_pos.top = $(".phone-content").offset().top;
//			g_page.phone_pos.scrollTop = $(window).scrollTop();
//		});
//	}
//	
//	function finishDroppable() {
//		$("#multiDroppableContainer").droppable('destroy');
//	}
//	
//	initDroppable();
//});