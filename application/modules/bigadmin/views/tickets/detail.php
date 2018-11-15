<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        <h3 class="box-title">Lihat Tiket</h3>
        <hr>
        <div class="row">
            <div class="col-md-offset-4 col-md-4">
                <center>
                    <button id="replyButtonTicket" class='btn btn-info btn-block btn-lg'><i class="fa fa-pencil"></i> Reply</button>
                </center>
            </div>
             <div class="col-xs-12" id="replyTicket" style="display:none">
            <br>
                    <div class="box box-info">
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
                                    <input type="text" class="form-control" id="nama" name="nama" disabled value="<?=$users->first_name. ' '.$users->last_name;?>">
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
                            <label for="content">Message</label>
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
                        
                        <input type="hidden" name="ticket_code" value="<?=$this->uri->segment(4);?>">

                        <div class="box-footer">
                        <center>
                        <a onclick='window.history.go(-1); return false;' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> Kembali</a>
                        <button type="submit" class='btn btn-info'><i class="fa fa-send"></i> Submit</button>
                        </center>

                        <?php echo form_close();?>
                        </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
        </div>
        <br>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <!-- <img class="img-circle" src="https://adminlte.io/themes/AdminLTE/dist/img/user1-128x128.jpg" alt="User Image"> -->
                        <span class="username"><?=$result->name;?></span>
                        <span class="description">Client - <?=tanggal_indo($result->created_at);?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?=$result->content;?>
                </div>
                <!-- /.box-body -->
                <?php $attach = json_decode($result->attachment);
                    if(count($attach) > 0) :?>
                <div class="box-footer">
                    <b><h6>Attachment (<?=count($attach)?>)</h6></b>
                    <ol>
                    <?php foreach($attach as $c) : ?>
                        <li><a href="<?=base_url('users_uploads/file/'.$c);?>" target="_blank"><?=$c;?></a></li>
                    <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif;?>
            </div>
              <!-- /.box -->
        </div>

        <?php if(count($solutions) > 0) :?>
        <div class="col-xs-12">
            <h4>Solusi</h4>
        </div>
        <?php foreach($solutions as $solution) : ?>
        <?php $color = ($solution->user_id != null) ? 'red' : 'aqua'; ?>
        <div class="col-xs-12">
            <div class="box box-widget text-white">
                <div class="box-header with-border bg-<?=$color;?>">
                    <div class="user-block">
                        <!-- <img class="img-circle" src="https://adminlte.io/themes/AdminLTE/dist/img/user1-128x128.jpg" alt="User Image"> -->
                        <?php if($solution->user_id != null) :?>
                            <span class="username"><?=$solution->first_name." ".$solution->last_name;?></span>
                            <?php $type = "Staff";?>
                        <?php else:?>
                            <span class="username"><?=$solution->name;?></span>
                            <?php $type = "Client";?>
                        <?php endif;?>
                        <span class="description" style="color:#ffffff"><?=$type;?> - <?=tanggal_indo($solution->created_at);?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" style="color:#ffffff" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?=$solution->content;?>
                </div>
                <!-- /.box-body -->
                <?php $attach = json_decode($solution->attachment);
                    if(count($attach) > 0) :?>
                <div class="box-footer">
                    <b><h6>Attachment (<?=count($attach)?>)</h6></b>
                    <ol>
                    <?php foreach($attach as $c) : ?>
                        <li><a href="<?=base_url('users_uploads/solution/'.$c);?>" target="_blank"><?=$c;?></a></li>
                    <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif;?>
            </div>
              <!-- /.box -->
        </div>
        <?php endforeach;?>
        <?php endif;?>
     </div>
    </section>
</div>