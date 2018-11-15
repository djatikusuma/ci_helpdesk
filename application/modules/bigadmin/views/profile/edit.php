<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ubah Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open(current_url());?>
                       <div class="form-group">
                              <label for="username">Username</label>
                              <input type="text" class="form-control" id="username" name="username" placeholder="Username" disabled value="<?=$this->input->post('username') != null ? $this->input->post('username') : $users->username;?>">
                        </div>
                        <div class="form-group">
                              <label for="first_name">Nama Depan</label>
                              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nama Depan" value="<?=$this->input->post('first_name') != null ? $this->input->post('first_name') : $users->first_name;?>">
                        </div>
                        <div class="form-group">
                              <label for="last_name">Nama Belakang</label>
                              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang" value="<?=$this->input->post('last_name') != null ? $this->input->post('last_name') : $users->last_name;?>">
                        </div>
                        <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?=$this->input->post('email') != null ? $this->input->post('email') : $users->email;?>">
                        </div>
                        <div class="form-group">
                              <label for="phone">No Telepon / No. Handphone</label>
                              <input type="text" class="form-control" id="phone" name="phone" placeholder="No Telepon / No. Handphone" value="<?=$this->input->post('phone') != null ? $this->input->post('phone') : $users->phone;?>">
                        </div>
                        <hr>
                        <label for="">Jika mengubah kata sandi</label>
                        <div class="form-group">
                              <label for="password">Kata sandi baru</label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Kata sandi baru" value="">
                        </div>
                        <div class="form-group">
                              <label for="password_confirm">Konfirmasi Kata sandi</label>
                              <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Kata sandi" value="">
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