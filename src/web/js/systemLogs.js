(($, app) => {
  $(() => {
    app();
  });
})(window.jQuery, () => {
  'use strict';

  var $container = $('div.container');

  // syslog table component
  var syslogTable = {
    $el: $('#cs-syslog-table'),
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
            // 時間
            className: 'text-center',
            data: 'created_at',
          },
          {
            // 人員
            className: 'text-center',
            data: 'username',
          },
          {
            // 行為
            className: 'text-center',
            data: 'action',
          },
        ],
      },
    },
    /**
     * Fetch system logs and render table
     */
    fetchAndRender: () => {
      $.ajax({
        type: 'GET',
        url: '/api/v1/systemLogs/listWithUserInfo',
        dataType: 'json',
      }).done((res) => {
        let tableOptions = $.extend(
          {},
          syslogTable.options.table, {
          data: res,
        });
        syslogTable.renderTable(tableOptions);
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
      let $table = syslogTable.$el;

      if ($.fn.dataTable.isDataTable($table)) {
        $table.DataTable().destroy();
      }

      $table.DataTable(option);
    },
    /**
     * Initialize
     */
    init: () => {
      syslogTable.fetchAndRender();
    },
  };

  // Constructor
  var constructor = () => {

    // activate syslog table
    syslogTable.init();
  };

  constructor();
})
