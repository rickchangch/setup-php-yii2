<?php
    /* @var $this yii\web\View */
    $this->title = 'RBAC setting';
?>

<style>
  .cs-relationship-title {
    font-size: 1.5rem;
  }

  .cs-relationship {
    margin-top: 5vh;
  }
</style>

<script src="js/rbac.js"></script>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <nav class="navbar navbar-light bg-light cs-relationship-toolbar">
        <span class="navbar-brand cs-relationship-title">Role / Permission 管理</span>
        <div class="d-flex">
          <button class="btn btn-outline-success et-add-role">新增角色</button>
        </div>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="cs-relationship">
        <table id="cs-relationship-table" class="display bg-light">
          <thead>
            <tr>
              <th></th>
              <th>角色</th>
              <th>權限</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: setup relationship within role/permission -->
<div class="modal fade" id="assignRoleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >編輯角色</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="col-12-lg">
          <label>．Role: </label>
          <div class="et-role-name"></div>
        </div>
        <div class="col-12-lg">
          <label>．Permissions: </label>
          <form class="et-permission-checkbox">
            <!-- render by ajax -->
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <button type="button" class="btn btn-primary et-assign-role-send">修改</button>
      </div>
    </div>
  </div>
</div>
