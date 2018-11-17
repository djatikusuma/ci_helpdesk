<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Tiket</h3>
                  <a class="btn btn-info btn-md pull-right" href="<?=base_url('users/tickets/new_ticket');?>"><i class="glyphicon glyphicon-pencil"></i> Tiket Baru</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="TicketsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th  class="text-center" width="15%">Department</th>
                      <th class="text-center">Subjek</th>
                      <th  class="text-center"  width="5%">Status</th>
                      <th  class="text-center"  width="20%">Dibuat</th>
                      <th  class="text-center" width="10%">Aksi</th>
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