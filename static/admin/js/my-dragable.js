(function($, document) {
	'use strict';

	var NAME     = 'zui.draggable',
		DEFAULTS = {
		// selector: '',
		container: 'body',
		move: true
	};
	var idIncrementer = 0;

	var Draggable = function(element, options) {
		var that     = this;
		that.$       = $(element);
		that.id      = idIncrementer++;
		that.options = $.extend({}, DEFAULTS, that.$.data(), options);
		that.containerSize = {};
		that.eleSize = {};
		that.init();
	};

	Draggable.DEFAULTS = DEFAULTS;
	Draggable.NAME     = NAME;

	Draggable.prototype.init = function() {
		var that           = this,
			$root          = that.$,
			BEFORE         = 'before',
			DRAG           = 'drag',
			FINISH         = 'finish',
			eventSuffix    = '.' + NAME + '.' + that.id,
			mouseDownEvent = 'mousedown' + eventSuffix,
			mouseUpEvent   = 'mouseup' + eventSuffix,
			mouseMoveEvent = 'mousemove' + eventSuffix,
			setting        = that.options,
			selector       = setting.selector,
			handle         = setting.handle,
			$ele           = $root,
			startPos,
			cPos,
			startOffset,
			mousePos,
			moved;
			

		var mouseMove = function(event) {
			var mX      = event.pageX,
				mY      = event.pageY;
				moved   = true;
			var dragPos = {
				left: mX - startOffset.x,
				top: mY - startOffset.y
			};

			$ele.removeClass('drag-ready').addClass('dragging');
			
			if(dragPos.left < 0) {
				dragPos.left = 0;
			}
			
			if(dragPos.top < 0) {
				dragPos.top = 0;
			}
			
			if((dragPos.left + that.eleSize.width) >= that.containerSize.width) {
				dragPos.left = that.containerSize.width - that.eleSize.width;
			}
			
			if((dragPos.top + that.eleSize.height) >= that.containerSize.height) {
				dragPos.top = that.containerSize.height - that.eleSize.height;
			}

			if(setting.move) {
			  $ele.css(dragPos);
			}
						console.log(dragPos.left, that.containerSize.width, that.eleSize.width);
			setting[DRAG] && setting[DRAG]({
				event: event,
				element: $ele,
				startOffset: startOffset,
				pos: dragPos,
				offset: {
					x: mX - startPos.x,
					y: mY - startPos.y
				},
				smallOffset: {
					x: mX - mousePos.x,
					y: mY - mousePos.y
				}
			});
			mousePos.x = mX;
			mousePos.y = mY;

			if(setting.stopPropagation) {
				event.stopPropagation();
			}
		};

		var mouseUp = function(event) {
			$(document).off(eventSuffix);
			if(!moved) {
				$ele.removeClass('drag-ready');
				return;
			}
			var endPos = {
				left: event.pageX - startOffset.x,
				top: event.pageY - startOffset.y
			};
			$ele.removeClass('drag-ready dragging');
			
			if(endPos.left < 0) {
				endPos.left = 0;
			}
			
			if(endPos.top < 0) {
				endPos.top = 0;
			}
			
			if((endPos.left + that.eleSize.width) >= that.containerSize.width) {
				endPos.left = that.containerSize.width - that.eleSize.width;
			}
			
			if((endPos.top + that.eleSize.height) >= that.containerSize.height) {
				endPos.top = that.containerSize.height - that.eleSize.height;
			}
			
			if(setting.move) {
			   $ele.css(endPos);
			}
						
						
			setting[FINISH] && setting[FINISH]({
				event: event,
				element: $ele,
				startOffset: startOffset,
				pos: endPos,
				offset: {
					x: event.pageX - startPos.x,
					y: event.pageY - startPos.y
				},
				smallOffset: {
					x: event.pageX - mousePos.x,
					y: event.pageY - mousePos.y
				}
			});
			event.preventDefault();
			if(setting.stopPropagation) {
				event.stopPropagation();
			}
		};

		var mouseDown = function(event) {
			var $mouseDownEle = $(this);
			if(selector) {
				$ele = handle ? $mouseDownEle.closest(selector) : $mouseDownEle;
			}

			if(setting[BEFORE]) {
				var isSure = setting[BEFORE]({
					event: event,
					element: $ele
				});
				if(isSure === false) return;
			}

			var $container = $(setting.container);
			var pos        = $ele.offset();//这个是元素距离左上角的绝对位绿
			var cPos       = $container.offset();//这个是容器距离左上角的绝对位绿
						
						that.containerSize = {
							width:$container.width(),
							height:$container.height()
						};
						
						that.eleSize = {
							width:$ele.width(),
							height:$ele.height()
						};
						
			startPos  = {
				x: event.pageX,
				y: event.pageY
			};
			
			startOffset = {
				x: event.pageX - pos.left + cPos.left,
				y: event.pageY - pos.top + cPos.top
			};

			mousePos    = $.extend({}, startPos);
			moved       = false;

			$ele.addClass('drag-ready');
			event.preventDefault();

			if(setting.stopPropagation) {
				event.stopPropagation();
			}

			$(document).on(mouseMoveEvent, mouseMove).on(mouseUpEvent, mouseUp);
		};

		if(handle) {
			$root.on(mouseDownEvent, handle, mouseDown);
		} else if(selector) {
			$root.on(mouseDownEvent, selector, mouseDown);
		} else {
			$root.on(mouseDownEvent, mouseDown);
		}
	};

	Draggable.prototype.destroy = function() {
		var eventSuffix = '.' + NAME + '.' + this.id;
		this.$.off(eventSuffix);
		$(document).off(eventSuffix);
		this.$.data(NAME, null);
	};

	$.fn.draggable = function(option) {
		return this.each(function() {
			var $this = $(this);
			var data = $this.data(NAME);
			var options = typeof option == 'object' && option;

			if(!data) $this.data(NAME, (data = new Draggable(this, options)));
			if(typeof option == 'string') data[option]();
		});
	};

	$.fn.draggable.Constructor = Draggable;
	}(jQuery, document));

	;( function ( $ ){
	 $.fn.addBack = $.fn.addBack || $.fn.andSelf;

	 $.fn.extend({

	   actual : function ( method, options ){
		 // check if the jQuery method exist
		 if( !this[ method ]){
		   throw '$.actual => The jQuery method "' + method + '" you called does not exist';
		 }

		 var defaults = {
		   absolute      : false,
		   clone         : false,
		   includeMargin : false
		 };

		 var configs = $.extend( defaults, options );

		 var $target = this.eq( 0 );
		 var fix, restore;

		 if( configs.clone === true ){
		   fix = function (){
			 var style = 'position: absolute !important; top: -1000 !important; ';

			 // this is useful with css3pie
			 $target = $target.
			   clone().
			   attr( 'style', style ).
			   appendTo( 'body' );
		   };

		   restore = function (){
			 // remove DOM element after getting the width
			 $target.remove();
		   };
		 }else{
		   var tmp   = [];
		   var style = '';
		   var $hidden;

		   fix = function (){
			 // get all hidden parents
			 $hidden = $target.parents().addBack().filter( ':hidden' );
			 style   += 'visibility: hidden !important; display: block !important; ';

			 if( configs.absolute === true ) style += 'position: absolute !important; ';

			 // save the origin style props
			 // set the hidden el css to be got the actual value later
			 $hidden.each( function (){
			   var $this = $( this );

			   // Save original style. If no style was set, attr() returns undefined
			   tmp.push( $this.attr( 'style' ));
			   $this.attr( 'style', style );
			 });
		   };

		   restore = function (){
			 // restore origin style values
			 $hidden.each( function ( i ){
			   var $this = $( this );
			   var _tmp  = tmp[ i ];

			   if( _tmp === undefined ){
				 $this.removeAttr( 'style' );
			   }else{
				 $this.attr( 'style', _tmp );
			   }
			 });
		   };
		 }

		 fix();
		 // get the actual value with user specific methed
		 // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
		 // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
		 var actual = /(outer)/.test( method ) ?
		   $target[ method ]( configs.includeMargin ) :
		   $target[ method ]();

		 restore();
		 // IMPORTANT, this plugin only return the value of the first element
		 return actual;
	   }
	 });
})( jQuery );