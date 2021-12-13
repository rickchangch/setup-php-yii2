(($, app) => {
  $(() => {
    app();
  });
})(window.jQuery, () => {
  'use strict';

  var $container = $('div.container');

  var roleModal = {
    el: '#modifyRoleModal',
    data: {
      user: undefined,
    },
    bindEvents: ($modal) => {
      $modal.find('.et-modify-role-send').on('click', () => {
        $.ajax({
          type: 'POST',
          url: '/api/v1/authItems/assignRoles',
          data: {
            user: roleModal.data.user,
            roles: [$modal.find('select').val()],
          },
          dataType: 'json',
        }).done((res) => {
          $modal.modal('hide');
          // reload
          userTable.fetchAndRender();
        }).fail((xhr) => {
          console.log('>> update role failure', xhr.responseJSON, xhr.responseText)
        });
      });
    },
    build: (data) => {
      let $el = $(roleModal.el).clone();

      roleModal.data.user = data.userID;

      $.ajax({
        type: 'GET',
        url: '/api/v1/authItems/getRoles',
        dataType: 'json',
      }).done((res) => {
        console.log(res);
        let $select = $el.find('select');

        // render options
        $.each(res, (i, v) => {
          $('<option>').val(v.name).text(v.name).appendTo($select);
        });

        // show modal
        $el.modal('show');

        // attach events on modal elements
        roleModal.bindEvents($el);

      }).fail((xhr) => {
        console.log('fail', xhr.responseJSON, xhr.responseText, xhr)
      });
    },
  };

  // user table component
  var userTable = {
    $el: $('#cs-userlist-table'),
    options: {
      table: {
        info: true,
        paging: true,
        searching: true,
        ordering: true,
        autoWidth: false,
        deferRender: true,
        destroy: true,
        data: [],
        columns: [
          {
            // username
            className: 'text-center',
            data: 'username',
          },
          {
            // role
            className: 'text-center',
            data: 'item_name',
          },
          {
            // register time
            className: 'text-center',
            data: 'created_at',
          }
        ],
        createdRow: (row, data, dataIndex, cells) => {
          let $row = $(row);

          if (userTable.options.canModify) {
            let $roleCell = $row.children()[1];
            $('<i>')
              .addClass('fas fa-pen et-modify-role')
              .attr('style', 'cursor:pointer')
              .data('userID', data.id)
              .appendTo($roleCell);

            // show modify modal
            $row.find('.et-modify-role').on('click', (evt) => {
              roleModal.build($(evt.target).data());
            });
          }
        },
      },
      canModify: false,
    },
    /**
     * Fetch all users' info
     */
    fetchAndRender: () => {
      $.ajax({
        type: 'GET',
        url: '/api/v1/accounts/listWithRoleInfo',
        dataType: 'json',
      }).done((res) => {
        console.log(res);

        userTable.options.canModify = res.canModify;

        let data = res.data || {};
        let tableOptions = $.extend(
          {},
          userTable.options.table, {
          data: data,
        });
        userTable.buildDataTable(tableOptions);
      }).fail((xhr) => {
        console.log('fail', xhr.responseJSON, xhr.responseText, xhr)
      });
    },
    /**
     * build the datatable
     *
     * @param {object} option
     */
    buildDataTable: (option) => {
      let $table = userTable.$el;

      if ($.fn.dataTable.isDataTable($table)) {
        $table.DataTable().destroy();
      }

      $table.DataTable(option);
    },
    /**
     * Initialize
     */
    init: () => {
      userTable.fetchAndRender();
    },
  };

  // Constructor
  var constructor = () => {

    // activate user table
    userTable.init();
  };

  constructor();
})
