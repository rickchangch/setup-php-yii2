(($, app) => {
  $(() => {
    app();
  });
})(window.jQuery, () => {
  'use strict';

  var $container = $('div.container');

  // sub navbar component
  var subNavbar = {
    $el: $container.find('.cs-relationship-toolbar'),
    /**
     * bind events
     */
    bindEvents: () => {
      // create new r/p relationship
      subNavbar.$el.find('.et-add-role').on('click', () => {
        assignRoleModal.fetchAndRender();
      });
    },
    /**
     * init
     */
    init: () => {
      subNavbar.bindEvents();
    }
  };

  // assign role component
  var assignRoleModal = {
    $el: $('#assignRoleModal'),
    data: undefined,
    /**
     * fetch permission data and render modal elements
     *
     * @param {Object} checkedData
     */
    fetchAndRender: (checkedData) => {
      let $modal = assignRoleModal.$el.clone();
      let $roleName = $modal.find('.et-role-name');
      let $permissionForm = $modal.find('.et-permission-checkbox');
      let isNew = $.isEmptyObject(checkedData);

      $.ajax({
        type: 'GET',
        url: '/api/v1/authItems/getPermissions',
        dataType: 'json',
      }).done((res) => {

        // render role info
        if (isNew) {
          // create new role
          $roleName.append($('<input>'));
        } else {
          // update old role
          $roleName.append($('<label>').text(checkedData.role));
        }

        // render permission checkboxes
        $.each(res, (idx, row) => {
          let random = Math.random();
          let permission = row.name;
          let $input = $('<input>')
            .addClass('form-check-input')
            .attr({
              type: 'checkbox',
              value: permission,
              id: permission + '_' + random,
            });

          if (!isNew && checkedData.permissions.includes(permission)) {
            $input.attr('checked', true);
          }

          let $label = $('<label>')
            .addClass('form-check-label')
            .attr({
              for: permission + '_' + random,
            })
            .text(permission);

          $permissionForm.append(
            $('<div>').addClass('form-check')
              .append($input)
              .append($label)
          );
        });

        // show modal
        $modal.modal('show');

        // confirm the change of r/p relationship
        $modal.find('.et-assign-role-send').on('click', () => {

          let postParams = [];

          $.each($modal.find('input:checked'), (i, el) => {
            postParams.push($(el).val());
          });

          $.ajax({
            type: 'POST',
            url: isNew
              ? '/api/v1/authItems/createRelationship'
              : '/api/v1/authItems/updateRelationship',
            data: {
              role: isNew
                ? $roleName.find('input').val()
                : checkedData.role,
              permissions: postParams,
            },
            dataType: 'json',
          }).done((res) => {
            $modal.modal('hide');
            // reload
            roleTable.fetchAndRender();
          }).fail((xhr) => {
            console.log('>> update failure', xhr.responseJSON, xhr.responseText)
          });
        });

      }).fail((xhr) => {
        console.log('fail', xhr.responseJSON, xhr.responseText, xhr)
      });
    },
  };

  // role table component
  var roleTable = {
    $el: $('#cs-relationship-table'),
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
            // editor
            className: 'text-center',
            data: null,
            render: (data, type, row, meta) => {
              return $('<i>')
                .addClass('fas fa-pen et-assign-role')
                .attr('style', 'cursor:pointer')
                .prop('outerHTML');
            },
          },
          {
            // role
            className: 'text-center',
            data: 'role',
          },
          {
            // permissions
            className: 'text-center',
            data: 'permissions',
          }
        ],
        createdRow: (row, data, dataIndex, cells) => {
          let $row = $(row);

          $row.find('i.et-assign-role').on('click', () => {
            // render table
            assignRoleModal.fetchAndRender(data);
          });
        },
      },
    },
    /**
     * Fetch roles and render table
     */
    fetchAndRender: () => {
      $.ajax({
        type: 'GET',
        url: '/api/v1/authItems/getRelationships',
        dataType: 'json',
      }).done((res) => {
        let tableOptions = $.extend(
          {},
          roleTable.options.table, {
          data: res,
        });
        roleTable.renderTable(tableOptions);
      }).fail((xhr) => {
        console.log('fail', xhr.responseJSON, xhr.responseText, xhr)
      });
    },
    /**
     * Render the datatable
     *
     * @param {object} option
     */
    renderTable: (option) => {
      let $table = roleTable.$el;

      if ($.fn.dataTable.isDataTable($table)) {
        $table.DataTable().destroy();
      }

      $table.DataTable(option);
    },
    /**
     * Initialize
     */
    init: () => {
      roleTable.fetchAndRender();
    },
  };

  // Constructor
  var constructor = () => {

    // activate role table
    roleTable.init();

    // activate sub navbar
    subNavbar.init();
  };

  constructor();
})
