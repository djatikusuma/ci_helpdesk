<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ubah Projek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open(current_url());?>
                        <div class="form-group">
                              <label for="name">Nama Kategori Projek</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kategori Projek" value="<?=isset($name) ? $name['value'] : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="code">Kode Kategori Projek</label>
                              <input type="text" class="form-control" id="code" name="code" placeholder="Kode Kategori Projek" value="<?=isset($code) ? $code['value'] : '';?>">
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