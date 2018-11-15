
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>
        <li>
          <a href="<?=base_url('users');?>">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
        <li>
          <?php
            $this->load->model('post_model');
            $count = $this->post_model->read('tickets', ['client_id' => $sess['id']])->result();
          ?>
          <a href="<?=base_url('users/tickets');?>">
            <i class="fa fa-file-archive-o"></i> <span>Tiket</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=count($count);?></span>
            </span>
          </a>
        </li>
      </ul>
    </section>