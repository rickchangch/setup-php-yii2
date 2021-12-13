(($, app) => {
  $(() => {
    app();
  });
})(window.jQuery, () => {
  'use strict';

  var $container = $('div.container');

  // register modal component
  var registerModal = {
    el: '#registerModalBlock',
    /**
     * Form validator
     *
     * @param   {object}  $el
     * @returns {boolean}
     */
    validator: ($el) => {
      let result = true;
      let columns = {
        $account: $el.find('input[name="account"]'),
        $pwd: $el.find('input[name="password"]'),
        $pwd2: $el.find('input[name="password2"]'),
        $nickname: $el.find('input[name="nickname"]'),
        $email: $el.find('input[name="email"]'),
      };

      // Check all required inputs have been filled in
      $.each(columns, (key, $col) => {
        let $label = $col.prev();
        if ($col.val() === '') {
          // clean old status
          $label.find('span').remove();
          // filed in error message
          $label.append($('<span>').addClass('cs-error-msg').text(' * 必填'));
          // alter validate result
          result = false;
        } else {
          // clean old status
          $label.find('span').remove();
        }
      });

      // Check that the password is consistent with the secondary password
      let pwdMatched = columns.$pwd.val() === columns.$pwd2.val();
      if (!pwdMatched) {
        let $label = columns.$pwd.prev();
        // clean old status
        $label.find('span').remove();
        // filed in error message
        $label.append($('<span>').addClass('cs-error-msg').text(' * 密碼不一致'));
        // alter validate result
        result = false;
      }

      return result;
    },
    /**
     * Bind event listener
     *
     * @param {object} $el
     */
    bindEvents: ($el) => {

      // send
      $el.find('.register-check-button').on('click', $container, () => {
        if (registerModal.validator($el)) {
          $.ajax({
            type: 'POST',
            url: '/api/v1/accounts/register',
            data: $el.find('form').serialize(),
          }).done((res) => {
            console.log('success', res);
            $el.modal('hide');
          }).fail((xhr) => {
            console.log('fail', xhr.responseJSON, xhr.responseText);
          });
        }
      });
    },
    /**
     * Initialize
     */
    init: () => {
      let $el = $(registerModal.el);
      registerModal.bindEvents($el);
    },
  };

  // login panel component
  var loginPanel = {
    el: '.cs-login-panel',
    /**
     * Bind event listener
     *
     * @param {object} $el
     */
    bindEvents: ($el) => {

      // login button
      $el.find('.login-button').on('click', () => {
        $.ajax({
          type: 'POST',
          url: '/api/v1/accounts/login',
          data: $el.find('form').serialize(),
        }).done((res) => {
          console.log('success', res)
          // login success & redirect to homepage
          window.location.href = '/home';
        }).fail((xhr) => {
          console.log('fail', xhr.responseJSON, xhr.responseText)
        });
      });

      // register button
      $el.find('.register-button').on('click', () => {
        // set 'value' to GTM variable name {entity}.
        // by this way, GTM can create a Tag and call this variable using {{variable name}}
        // then pass DataLayer value to 3rd-party media platform like the function below:
        // gtag('event', 'ev-name', { 'value': {{entity}} });
        dataLayer.push({'entity': 'value'});

        // dataLayer.push({
        //   'entity01': 'test',
        //   'event': 'click-register-btn'
        // });
        console.log('trigger click', dataLayer);
      });
    },
    /**
     * Initialize
     */
    init: () => {
      let $el = $(loginPanel.el);

      loginPanel.bindEvents($el);
    },
  };

  // Constructor
  var constructor = () => {

    // activate login component
    loginPanel.init();

    // activate register component
    registerModal.init();
  };

  constructor();

})
