<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Tiket Baru</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <?php if(!empty(validation_errors())):?>
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo validation_errors();?>
                </div>
                <?php endif;?>

                  <?php echo form_open_multipart(current_url());?>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="nama">Nama</label>
                              <input type="text" class="form-control" id="nama" name="nama" disabled value="<?=$users->name;?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" id="email" name="email" disabled value="<?=$users->email;?>">
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="title">Subjek</label>
                    <input type="text" class="form-control" name="title" placeholder="Subjek" value="<?=$this->input->post('title') != null ? $this->input->post('title') : '';?>">
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="" disabled selected>None</option>
                                <?php foreach($departments as $d) : ?>
                                    <?php if($d->id != 1) : ?>
                                    <option value="<?=$d->id;?>" 
                                    <?=($this->input->post('department_id') != null ? ($this->input->post('department_id') == $d->id ? 'selected' : '') : '');?>><?=$d->name;?></option>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_id">Relasi Projek</label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="" disabled selected>None</option>
                                <?php foreach($projects as $d) : ?>
                                <option value="<?=$d->id;?>"
                                <?=($this->input->post('project_id') != null ? ($this->input->post('project_id') == $d->id ? 'selected' : '') : '');?>
                                ><?=$d->project_name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="priority_id">Prioritas</label>
                            <select name="priority_id" id="priority_id" class="form-control">
                                <option value="" disabled selected>None</option>
                                <?php foreach($priorities as $d) : ?>
                                <option value="<?=$d->id;?>"
                                <?=($this->input->post('priority_id') != null ? ($this->input->post('priority_id') == $d->id ? 'selected' : '') : '');?>><?=$d->priority_name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="content">Deskripsi Tiket</label>
                    <textarea name="content" id="editor" cols="30" rows="10" class="form-control"><?=$this->input->post('content') != null ? $this->input->post('content') : '';?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <a class="btn btn-xs btn-default pull-right" id="add-more"><i class="fa fa-plus"></i> Tambah File</a>
                    <div id="form-file">
                        <input type="file" name="attachments[]" class="form-control">
                    </div>
                    <span>File yang diijinkan :  .jpg, .jpeg, .gif, .png, .zip, .rar, .gz, .7z, .txt, .xls, .xlsx, .doc, .docx, .pdf, .htm, .html, .csv, .sql</span>
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