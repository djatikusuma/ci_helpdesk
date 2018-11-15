<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tambah Klien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open("bigadmin/clients/add");?>
                       <div class="form-group">
                              <label for="username">Username</label>
                              <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=$this->input->post('username') != null ? $this->input->post('username') : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="name">Nama</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="<?=$this->input->post('name') != null ? $this->input->post('name') : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="company">Perusahaan</label>
                              <input type="text" class="form-control" id="company" name="company" placeholder="Perusahaan" value="<?=$this->input->post('company') != null ? $this->input->post('company') : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?=$this->input->post('email') != null ? $this->input->post('email') : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="phone">No Telepon / No. Handphone</label>
                              <input type="text" class="form-control" id="phone" name="phone" placeholder="No Telepon / No. Handphone" value="<?=$this->input->post('phone') != null ? $this->input->post('phone') : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="password">Katasandi</label>
                              <input type="text" class="form-control" id="password" name="password" placeholder="Katasandi" value="<?=$this->input->post('password') != null ? $this->input->post('password') : '';?>">
                        </div>

                        <div class="form-group">
                          <label for="projects">Projek</label>
                          <select data-placeholder="Pilih Project" style="width:100%;" multiple class="form-control project_select" name="projects[]">
                            <?php foreach($projects as $c) :?>
                              <option value="<?=$c->id;?>"><?=$c->project_name;?></option>
                            <?php endforeach; ?>
                          </select>
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