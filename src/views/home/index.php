<?php
    /* @var $this yii\web\View */
    $this->title = 'Home';
?>

<style>
  .cs-userlist-title {
    font-size: 1.5rem;
  }

  .cs-userlist {
    margin-top: 5vh;
  }
</style>

<script src="js/home.js"></script>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <nav class="navbar navbar-light bg-light cs-userlist-toolbar">
        <span class="navbar-brand cs-userlist-title">已註冊人員清單</span>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="cs-userlist">
        <table id="cs-userlist-table" class="display bg-light">
          <thead>
            <tr>
              <th>人名</th>
              <th>角色</th>
              <th>註冊時間</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: modify user role -->
<div class="modal fade" id="modifyRoleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >指派新角色</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select class="et-role-select">
          <!-- render by ajax -->
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <button type="button" class="btn btn-primary et-modify-role-send">修改</button>
      </div>
    </div>
  </div>
</div>
