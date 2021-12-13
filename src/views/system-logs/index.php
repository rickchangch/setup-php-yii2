<?php
    /* @var $this yii\web\View */
    $this->title = 'System logs';
?>


<style>
  .cs-syslog-title {
    font-size: 1.5rem;
  }

  .cs-syslog {
    margin-top: 5vh;
  }
</style>

<script src="js/systemLogs.js"></script>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <nav class="navbar navbar-light bg-light cs-syslog-toolbar">
        <span class="navbar-brand cs-syslog-title">使用者系統紀錄</span>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="cs-syslog">
        <table id="cs-syslog-table" class="display bg-light">
          <thead>
            <tr>
              <th>時間</th>
              <th>人員</th>
              <th>行為</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
