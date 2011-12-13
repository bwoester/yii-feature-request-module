/**
 * @see "http://wiki.jqueryui.com/w/page/12138135/Widget%20factory"
 */
(function( $ ) {

  $.widget( "mod_featureRequest.locationBar", {

    // autocomplete: $.ui.autocomplete.prototype,

    // These options will be used as defaults
    options: {
      autocomplete: {
        focus: function(event, ui) {
          var self = $(this).data( 'locationBar' );
          var hoveredText = self._getObjectAttribute( ui.item, self.options.displayAttribute );
          var decoded = self._decode( hoveredText );
          self.element.val( decoded );
          return false;
        },
        select: function(event, ui) {
          var self = $(this).data( 'locationBar' );
          var hoveredText = self._getObjectAttribute( ui.item, self.options.displayAttribute );
          var decoded = self._decode( hoveredText );
          self.element.val( decoded );
          self.element.next().val( 'View' );
          // TODO: Create button should appear when user modifies editline value
          //       It should disappear when a suggestion is selected.
          self.element.next().after( '<input type="submit" value="Create" />' );
          return false;
        }
      },
      displayAttribute: 'title',
      idAttribute: 'id',
      viewUrl: '#',
      clear: null
    },

    // Set up the widget
    _create: function() {
      var self = this;
      self.element.autocomplete( self.options.autocomplete );
      self.element.data( "autocomplete" )
        ._renderItem = function( ul, item ) {
          return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( '<a>' +  self._getObjectAttribute( item, self.options.displayAttribute ) + "</a>" )
            .appendTo( ul );
        };
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

    _decode: function( string ) {
      return $("<div/>").html( string ).text();
    },

    _getObjectAttribute: function( obj, attrib ) {
      var path = attrib.split(".");
      for (var i = 0; i < path.length; i++) {
        obj = obj[path[i]];
      }
      return obj;
    },

    // Use the destroy method to clean up any modifications your widget has made to the DOM
    destroy: function() {
      // In jQuery UI 1.8, you must invoke the destroy method from the base widget
      $.Widget.prototype.destroy.call( this );
    }

  }); // $.widget( "mod_featureRequest.locationBar", {

}( jQuery ) );

///////////////////////////////////////////////////////////////////////////////

// parseUri 1.2.2
// (c) Steven Levithan <stevenlevithan.com>
// MIT License

function parseUri (str) {
	var	o   = parseUri.options,
		m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
		uri = {},
		i   = 14;

	while (i--) uri[o.key[i]] = m[i] || "";

	uri[o.q.name] = {};
	uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
		if ($1) uri[o.q.name][$1] = $2;
	});

	return uri;
};

parseUri.options = {
	strictMode: false,
	key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
	q:   {
		name:   "queryKey",
		parser: /(?:^|&)([^&=]*)=?([^&]*)/g
	},
	parser: {
		strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
		loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
	}
};

///////////////////////////////////////////////////////////////////////////////

