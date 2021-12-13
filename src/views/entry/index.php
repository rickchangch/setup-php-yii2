<?php
    /* @var $this yii\web\View */
    $this->title = 'Login page';
?>

<style>
  .cs-login-panel {
    margin: auto;
    width: 40vw;
    height: auto;
    padding: 1rem;
    background-color: rgb(230, 230, 230);
    border-radius: 1%;
    border: black 0.1rem solid;
  }

  .cs-login-left-panel{
    padding: 1rem;
    display:block;
    margin: auto;
  }
  .cs-login-right-panel{
    padding: 1rem;
  }

  .cs-navbar {
    margin-top: 5vh;
  }

  .cs-row-dot5 {
    margin: .5rem !important;
  }

  .cs-row-2 {
    margin: 2rem !important;
  }

  .cs-error-msg {
    color: red;
    font: bold;
    font-size: 0.8rem;
  }
</style>

<script src="js/entry.js"></script>

<div class="container">
  <div class="row cs-login-panel">
    <div class="col-lg-12 cs-login-right-panel">
      <form>
        <div class="cs-row-2">
          <h3 class="fw-bold">會員登入</h3>
        </div>
        <div class="cs-row-2">
          <label for="loginInputUsername" class="form-label fw-bold">帳號</label>
          <input type="username" name="username" class="form-control" id="loginInputUsername">
        </div>
        <div class="cs-row-2">
          <label for="loginInputPassword" class="form-label fw-bold">密碼</label>
          <input type="password" name="password" class="form-control" id="loginInputPassword">
        </div>
        <div class="d-flex justify-content-end cs-row-2">
          <span class="m-2 btn btn-success login-button">登入</span>
          <span class="m-2 btn btn-warning register-button"  data-bs-toggle="modal" data-bs-target="#registerModalBlock">註冊</span>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Modal: register new user -->
<div class="modal fade" id="registerModalBlock" tabindex="-1" aria-labelledby="registerModalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalTitle">註冊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="cs-row-dot5">
            <label for="usernameInput" class="form-label">帳號</label>
            <input type="text" id="usernameInput" class="form-control" name="username" required />
          </div>
          <div class="cs-row-dot5">
            <label for="passwordInput" class="form-label">密碼</label>
            <input type="password" id="passwordInput" class="form-control" name="password" required />
          </div>
          <div class="cs-row-dot5">
            <label for="passwordInput2" class="form-label">二次密碼</label>
            <input type="password" id="passwordInput2" class="form-control" name="password2" required />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <button type="button" class="btn btn-primary register-check-button">新增</button>
      </div>
    </div>
  </div>
</div>
