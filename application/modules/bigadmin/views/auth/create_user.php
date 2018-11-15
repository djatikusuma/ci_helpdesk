<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tambah Data Pengguna</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="infoMessage"><?php echo $message;?></div>
                  <form class="form-horizontal" action="<?=base_url('bigadmin/users/add');?>" method="POST">
                        <div class="form-group">
                              <label for="first_name" class="col-sm-2 control-label">Nama Depan <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nama Depan" value="<?=isset($first_name) ? $first_name['value'] : '';?>">
                              </div>
                        </div>
                        <div class="form-group">
                              <label for="last_name" class="col-sm-2 control-label">Nama Belakang <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang"  value="<?=isset($last_name) ? $last_name['value'] : '';?>">
                              </div>
                        </div>
                        <div class="form-group">
                              <label for="email" class="col-sm-2 control-label">Email <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email"  value="<?=isset($email) ? $email['value'] : '';?>">
                              </div>
                        </div>
                        <div class="form-group">
                              <label for="phone" class="col-sm-2 control-label">No. Telepon <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon"  value="<?=isset($phone) ? $phone['value'] : '';?>">
                              </div>
                        </div>
                        <div class="form-group">
                              <label for="password" class="col-sm-2 control-label">Password <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                              </div>
                        </div>
                        <div class="form-group">
                              <label for="password_confirm" class="col-sm-2 control-label">Konfirmasi Password <span class="text-danger" title="This field is required">*</span></label>

                              <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Password">
                              </div>
                        </div>

                        <div class="form-group">
                          <label for="groups" class="col-sm-2 control-label">Group User <span class="text-danger" title="This field is required">*</span></label>
                          <div class="col-sm-9">
                              <select data-placeholder="Pilih Groups User" style="width:100%;" multiple class="form-control project_select" name="groups[]">
                                    <?php foreach($groups as $c) :?>
                                          <option value="<?=$c->id;?>"><?=$c->name;?></option>
                                    <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <input type="hidden" class="form-control" id="company" name="company" value="BIGIO">
                </div>
                <div class="box-footer">
                  <center>
                  <a onclick='window.history.go(-1); return false;' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> Kembali</a>
                  <button type="submit" class='btn btn-success'><i class="fa fa-save"></i> Simpan</button>
                  </center>

                  <?php echo form_close();?>
                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
     </div>
    </section>
</div>


