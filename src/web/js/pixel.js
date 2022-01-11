(($, app) => {
  $(() => {
    app();
  });
})(window.jQuery, () => {
  'use strict';

  var $container = $('div.container');

  const EVENT_NAMES = [
    'ViewContent',
    'AddToCart',
    'Purchase'
  ];

  var pixelButtons = {
    $el: $('.cs-pixel-btn-area'),
    init: () => {

      // build button jq DOM
      let $btnEl = $('<button>').addClass('btn-info cs-pixel-btn');

      // render all event names
      EVENT_NAMES.forEach((val, idx) => {
        $btnEl.clone().text(val).addClass(`tag-${val}`).appendTo(pixelButtons.$el);
      });
    },
  };

  // Constructor
  var constructor = () => {

    // init pixel buttons
    pixelButtons.init();
  };

  constructor();
})
