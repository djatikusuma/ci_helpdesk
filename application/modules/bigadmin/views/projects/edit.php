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
                              <label for="project_name">Name Projek</label>
                              <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Name Projek" value="<?=isset($project_name) ? $project_name['value'] : '';?>">
                        </div>
                        <div class="form-group">
                              <label for="project_description">Deskripsi Projek</label>
                              <textarea name="project_description" id="editor" cols="30" rows="10" class="form-control"><?=isset($project_description) ? $project_description['value'] : '';?></textarea>
                        </div>

                        <div class="form-group">
                              <label for="project_date">Tanggal Projek</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="project_date" class="form-control pull-right" id="datepicker" value="<?=isset($project_date) ? date("m/d/Y", strtotime($project_date['value'])) : '';?>">
                              </div>
                        </div>
                        <div class="form-group">
                          <label for="category_code">Jenis Projek</label>
                          <select name="category_code" id="category_code" class="form-control">
                            <option value="" disabled selected>PILIH JENIS PROJEK</option>
                            <?php foreach($categories as $c) :?>
                            <option value="<?=$c->code;?>" 
                                <?=($category_code['value'] == $c->code) ? "selected" : "";?>><?=$c->name;?></option>
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