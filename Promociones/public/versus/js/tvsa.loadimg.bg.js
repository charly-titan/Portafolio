(function($){var options=$.tvsaloadimg,bgAttr=options.bgAttr||'data-bg';options.selector+=',['+bgAttr+']';$(document).on('tvsaimgshow',function(e){var $this=$(e.target);$this.css('background-image',"url('"+$this.attr(bgAttr)+"')").removeAttr(bgAttr);});})(window.jQuery||window.Zepto||window.$);