<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manajemen Projek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <a class="btn btn-success" href="<?=base_url('bigadmin/projects/add');?>"><i class="glyphicon glyphicon-plus"></i> Tambah Projek</a>
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
                <button class="btn btn-danger" onclick="bulk_delete('projects/ajax_bulk_delete')"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                <br><br>
                  <table id="DepartmentsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th width="5%"><input type="checkbox" id="check-all"></th>
                      <th>Nama Projek</th>
                      <th>Deksripsi</th>
                      <th>Tanggal Projek</th>
                      <th>Diperbarui</th>
                      <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
     </div>
    </section>
</div>