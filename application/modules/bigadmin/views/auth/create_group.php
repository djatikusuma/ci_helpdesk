<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tambah Department</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open("bigadmin/groups/create_group");?>
                        <div class="form-group">
                              <label for="group_name">Nama</label>
                              <input type="text" class="form-control" id="name" name="group_name" placeholder="Nama Grup">
                        </div>
                        <div class="form-group">
                              <label for="description">Deskripsi</label>
                              <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
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