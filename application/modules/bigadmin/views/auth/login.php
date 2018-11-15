
<div class="login-box">
  <div class="login-logo">
    <b>BIGIO</b>Helpdesk
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php if(!empty($message)) : ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      <?php echo $message;?>
    </div>
    <?php endif;?>
    
    <?php echo form_open("bigadmin/login");?>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="identity" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    <?php echo form_close();?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->