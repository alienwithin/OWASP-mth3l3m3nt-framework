/*
 * jQuery BorderFlow
 * Copyright (c) 2013 Christian Knuth <ikkez0n3@gmail.com>
 * licensed under the LGPL Version 3 license.
 * http://www.gnu.org/licenses/lgpl.html
 */
(function ( $, window, document, undefined ) {

    var borderFlow = {
        init:function (options, elem) {
            this.options = $.extend({}, this.options, options);
            this.elem = elem;
            this.$elem = $(elem);
            this._build();
            return this;
        },
        options:{
            borderWidth: 8,
            duration: 4000,
            speed: 1
        },
        _build:function () {

            if(this.$elem.css('position') == 'static')
                this.$elem.css({position:'relative'});

            var shadow = $('<div />').addClass('shadow').css('opacity',0);
            var wrap = $('<div />').addClass('shadowWrap').html(shadow);
                wrap.css({
                    left:-this.options.borderWidth/2+'%',
                    top:-this.options.borderWidth/2+'%',
                    padding:this.options.borderWidth,
                    overflow:'hidden',
                    zIndex: -1,
                    position: 'absolute',
                    width: 100+this.options.borderWidth+'%',
                    height: 100+this.options.borderWidth+'%'
                });
            // fix webkit animation rendering bug
            // TODO if elem.width != elem.height
            this.$elem.append(wrap);
            if(parseInt(this.$elem.find('.shadowWrap').css('border-left-width')) == 0) {
                wrap.css('border','1px solid transparent');
            }
        },

        playSimple:function (options) {
            var options = $.extend({}, this.options, options);
            this.$elem.find('.shadow')
                .animate({ rotate:450*(options.duration/1000)*options.speed },
                    { queue:false, duration:options.duration, easing:'linear' })
                .animate({ opacity:'1' }, { queue:false, duration:500 / options.speed })
                .delay(options.duration - 600 / options.speed).animate(
                    { opacity:'0' }, { queue:true, duration:600 / options.speed });
        }
    };

    if (typeof Object.create !== 'function') {
        Object.create = function (o) {
            function F() {}
            F.prototype = o;
            return new F();
        };
    }
    $.plugin = function (name, object) {
        $.fn[name] = function (options) {
            return this.each(function () {
                if (!$.data(this, name)) {
                    $.data(this, name, Object.create(object).init(options, this));
                }
            });
        };
    };
    $.plugin('borderFlow', borderFlow);


// and at this point we could do the following
// $('#elem').myobj({name: "John"});
// var inst = $('#elem').data('myobj');
// inst.myMethod('I am a method');

})( jQuery, window, document );

/*
 * JQuery CSS Rotate property using CSS3 Transformations
 * Copyright (c) 2011 Jakub Jankiewicz  <http://jcubic.pl>
 * licensed under the LGPL Version 3 license.
 * http://www.gnu.org/licenses/lgpl.html
 */
(function($){function getTransformProperty(element){var properties=['transform','WebkitTransform','MozTransform','msTransform','OTransform'];var p;while(p=properties.shift()){if(element.style[p]!==undefined){return p;}}
return false;}
$.cssHooks['rotate']={get:function(elem,computed,extra){var property=getTransformProperty(elem);if(property){return elem.style[property].replace(/.*rotate\((.*)deg\).*/,'$1');}else{return'';}},set:function(elem,value){var property=getTransformProperty(elem);if(property){value=parseInt(value);$(elem).data('rotatation',value);if(value==0){elem.style[property]='';}else{elem.style[property]='rotate('+value%360+'deg)';}}else{return'';}}};$.fx.step['rotate']=function(fx){$.cssHooks['rotate'].set(fx.elem,fx.now);};})(jQuery);