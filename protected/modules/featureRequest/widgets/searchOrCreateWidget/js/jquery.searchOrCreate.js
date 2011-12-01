/**
 * @see "http://wiki.jqueryui.com/w/page/12138135/Widget%20factory"
 */
(function( $ ) {
  $.widget( "mod_featureRequest.searchOrCreate", {

    // These options will be used as defaults
    options: {
      clear: null
    },

    // Set up the widget
    _create: function() {
    },

    // Use the _setOption method to respond to changes to options
    _setOption: function( key, value ) {
      switch( key ) {
        case "clear":
          // handle changes to clear option
          break;
      }

      // In jQuery UI 1.8, you have to manually invoke the _setOption method from the base widget
      $.Widget.prototype._setOption.apply( this, arguments );
    },

    // Use the destroy method to clean up any modifications your widget has made to the DOM
    destroy: function() {
      // In jQuery UI 1.8, you must invoke the destroy method from the base widget
      $.Widget.prototype.destroy.call( this );
    }
  });
}( jQuery ) );
