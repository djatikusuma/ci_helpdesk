<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ubah Department</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open(current_url());?>
                        <div class="form-group">
                              <label for="department_name">Nama</label>
                              <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Nama" value="<?=isset($department_name) ? $department_name['value'] : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="department_description">Deskripsi</label>
                              <textarea name="department_description" id="editor" cols="30" rows="10" class="form-control"><?=isset($department_description) ? $department_description['value'] : '';?></textarea>
                        </div>

                <div class="box-footer">
                  <center>
                  <a onclick='window.history.go(-1); return false;' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> Kembali</a>
                  <button type="submit" class='btn btn-success'><i class="fa fa-save"></i> Simpan</button>
                  </center>

                  <?php echo form_close();?>
                </div>
                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
     </div>
    </section>
</div>