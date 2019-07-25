function isArray(object){
  return object && typeof object==='object' &&
          Array == object.constructor;
}

function myDeepCopy(obj) {
	if(typeof obj != 'object') {
		return obj;
	}
	
	if(obj instanceof Array) {
		var newArray = new Array();
		for(var i = 0; i < obj.length; i++) {
			newArray.push(myDeepCopy(obj[i]));
		}
		return newArray;
	} else if(obj instanceof Object) {
		var newobj = {};
    for ( var attr in obj) {
        newobj[attr] = myDeepCopy(obj[attr]);
    }
    return newobj;
	}
}

function inArea(p, area) {
	if(p.left >= area.left && p.left <= area.right) {
		if(p.top >= area.top && p.top <= area.bottom) {
			return true;
		}
	}
	return false;
}
	
var g_animates = {
	enter_animates:[
		{
			name:'淡入',
			className:'appear_fade',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				},
				{
					className:'_center',
					name:'中心'
				}
			],
		},
		{
			name:'弹入',
			className:'appear_bounce',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				},
				{
					className:'_center',
					name:'中心'
				}
			]
		},
		{
			name:'平移',
			className:'appear_translate',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			]
		},
		{
			name:'旋转',
			className:'appear_rotate',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				},
				{
					className:'_center',
					name:'中心'
				}
			]
		},
		{
			name:'光速',
			className:'appear_lightSpeed',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			]
		},
		{
			name:'飞入',
			className:'appear_fly',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			]
		},
		{
			name:'展开',
			className:'appear_unfold',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			]
		},
		{
			name:'翻滚',
			className:'appear_roll',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			]
		},
		{
			name:'大幅缩放',
			className:'appear_bigScale',
			subClasses:[
				{
					className:'_in',
					name:'向内'
				},
				{
					className:'_out',
					name:'向外'
				}
			]
		},
		{
			name:'小幅缩放',
			className:'appear_smallScale',
			subClasses:[
				{
					className:'_in',
					name:'向内'
				},
				{
					className:'_out',
					name:'向外'
				}
			]
		},
		{
			name:'Y翻转',
			className:'appear_flip_y'
		},
		{
			name:'X翻转',
			className:'appear_flip_x'
		}
	],
	show_animates:[
		{
			name:'摇动',
			className:'transit_swing'
		},
		{
			name:'跳动',
			className:'transit_jump'
		},
		{
			name:'转动',
			className:'transit_rotate'
		},
		{
			name:'呼吸灯',
			className:'transit_fade'
		},
		{
			name:'闪动',
			className:'transit_flash'
		},
		{
			name:'抖动',
			className:'transit_shake'
		},
		{
			name:'乱抖动',
			className:'transit_jitter'
		},
		{
			name:'翻转',
			className:'transit_flip'
		},
		{
			name:'果冻',
			className:'transit_jelly'
		}
	],
	leave_animates:[
		{
			name:'淡出',
			className:'disappear_fade',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				},
				{
					className:'_center',
					name:'中心'
				}
			],
		},
		{
			name:'弹出',
			className:'disappear_bounce',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				},
				{
					className:'_center',
					name:'中心'
				}
			],
		},
		{
			name:'移出',
			className:'disappear_translate',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			],
		},
		{
			name:'光速',
			className:'disappear_lightSpeed',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			],
		},
		{
			name:'翻滚',
			className:'disappear_roll',
			subClasses:[
				{
					className:'_right',
					name:'从左向右'
				},
				{
					className:'_left',
					name:'从右向左'
				},
				{
					className:'_up',
					name:'从上到下'
				},
				{
					className:'_down',
					name:'从下到上'
				}
			],
		},
		{
			name:'缩放',
			className:'disappear_scale',
			subClasses:[
				{
					className:'_in',
					name:'向内'
				},
				{
					className:'_out',
					name:'向外'
				}
			],
		},
		{
			name:'Y翻转',
			className:'disappear_flip_y'
		},
		{
			name:'X翻转',
			className:'disappear_flip_x'
		},
		{
			name:'脱落',
			className:'disappear_fall',
			subClasses:[
				{
					className:'_left',
					name:'向左'
				},
				{
					className:'_right',
					name:'向右'
				}
			]
		}
	]
};

$(function() {
  (function($) {
  	$.fn.extend({
			my_spinner:function(config) {
				var defaultCfg = {
	    		minValue:0,
	    		maxValue:100,
	    		minusBtn:".minus-btn",
	    		plusBtn:".plus-btn",
	    		valueSuffix:'px'
	    	};
  	
  			defaultCfg.defaultValue = (defaultCfg.minValue+defaultCfg.maxValue)/2;
				var _cfg = $.extend(defaultCfg, config);
				var input = $(this).find("input");
				var $this = $(this);
				input.val(_cfg.defaultValue);
				input.numeral();
				
				var minusBtn = $(this).find(_cfg.minusBtn);
				var plusBtn = $(this).find(_cfg.plusBtn);
				
				minusBtn.click(function() {
					input.val(parseInt(input.val())-1);
					if(input.val() < _cfg.minValue) {
						input.val(_cfg.minValue);
					}
					
					if(_cfg.change) {
						_cfg.change(input.val());
					}
				});
				
				plusBtn.click(function() {
					input.val(parseInt(input.val())+1);
					if(input.val() > _cfg.maxValue) {
						input.val(_cfg.maxValue);
					}
					
					if(_cfg.change) {
						_cfg.change(input.val());
					}
				});
				
				input.bind("propertychange input", function() {
					var val = input.val();
					if(val > _cfg.maxValue) {
						input.val(_cfg.maxValue);
					} else if(val < _cfg.minValue) {
						input.val(_cfg.minValue);
					}
					
					if(_cfg.change) {
						_cfg.change(input.val());
					}
				});
				
				$this.getVal = function() {
					return input.val();
				};
				
				$this.setVal = function(val) {
					input.val(val);
				}
				return $this;
			}
		}
	);
  })(jQuery);
});

$(function() {
	$(".admin-user-info").click(function() {
		if($(this).hasClass("open")) {
			$(this).removeClass("open");
		} else {
			$(this).addClass("open");
		}
	});
});

$(function(){
	function setFontSize() {
		var win = window;
		doc = document;
　　var winWidth = $(window).width();
　　var size = ((winWidth / 1520) * 724)/60;
　　doc.documentElement.style.fontSize = size + 'px';
	};
	setFontSize();
});