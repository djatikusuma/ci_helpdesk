
<div class="login-box">
  <div class="login-logo">
    <b>BIGIO</b>Helpdesk
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php if(!empty(validation_errors())):?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      <?php echo validation_errors();?>
    </div>
    <?php endif;?>
    
    <?php echo form_open("users/login");?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?=$this->input->post('username')!=null ? 
                                                                                                $this->input->post('username') : ''; ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
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