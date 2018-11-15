<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manajemen Department</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <a class="btn btn-success" href="<?=base_url('bigadmin/groups/create_group');?>"><i class="glyphicon glyphicon-plus"></i> Tambah Grup</a>
                <br><br>
                  <table id="GroupsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nama</th>
                      <th>Deskripsi</th>
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