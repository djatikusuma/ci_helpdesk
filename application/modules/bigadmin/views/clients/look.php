<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Detail Klien</h3>
                  <div class="pull-right">
                        <a onclick='window.history.go(-1); return false;' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> Kembali</a>
                        <a class="btn btn-success" href="<?=base_url('bigadmin/clients/edit/'.$client->username);?>"><i class="glyphicon glyphicon-pencil"></i> Ubah Klien</a>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="DepartmentsTable" class="table table-bordered table-striped">
                        <tr>
                            <th width="10%">Nama</th>
                            <td width="2%">:</td>
                            <td><?=$client->name;?></td>
                        </tr>
                        <tr>
                            <th width="10%">Perusahaan</th>
                            <td width="2%">:</td>
                            <td><?=$client->company;?></td>
                        </tr>
                        <tr>
                            <th width="10%">Email</th>
                            <td width="2%">:</td>
                            <td><?=$client->email;?></td>
                        </tr>
                        <tr>
                            <th width="20%">No. Telepon / No. Handphone</th>
                            <td width="2%">:</td>
                            <td><?=$client->phone;?></td>
                        </tr>
                        <tr>
                            <th width="10%">Project</th>
                            <td width="2%">:</td>
                            <td>
                            <ol>
                                <?php foreach($projects as $p) :?>
                                    <li><?=$p->project_name;?></li>
                                <?php endforeach; ?>
                            </ol>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
     </div>
    </section>
</div>