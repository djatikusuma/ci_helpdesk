
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>
        <li>
          <a href="<?=base_url('bigadmin');?>">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
        <li>
          <?php
            $this->load->model('post_model');
            $did = $this->ion_auth->get_users_groups($this->ion_auth->get_user_id())->result();
            $groupId = "";
            $i = 0;
            foreach($did as $d){
                $groupId .= "'$d->id'";
                if($i < count($did)-1) $groupId .=",";
                $i++;
            }
            if (!$this->ion_auth->is_admin())
              $where = array("department_id IN($groupId)" => null);
            else
              $where = null;
            $count = $this->post_model->read('tickets', $where)->result();
          ?>
          <a href="<?=base_url('bigadmin/tickets');?>">
            <i class="fa fa-file-archive-o"></i> <span>Tiket</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=count($count);?></span>
            </span>
          </a>
        </li>
<?php if($this->ion_auth->is_admin()) : ?>
        <li class="header">NAVIGASI MANAJEMEN</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Manajemen Pengguna</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('bigadmin/users/add');?>"><i class="fa fa-plus"></i> Tambah Pengguna</a></li>
            <li><a href="<?=base_url('bigadmin/users');?>"><i class="fa fa-list"></i> Daftar Pengguna</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span>Manajemen Departemen</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('bigadmin/groups/create_group');?>"><i class="fa fa-plus"></i> Tambah Departemen</a></li>
            <li><a href="<?=base_url('bigadmin/groups');?>"><i class="fa fa-list"></i> Daftar Departemen</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Manajemen Klien</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('bigadmin/clients/add');?>"><i class="fa fa-plus"></i> Tambah Klien</a></li>
            <li><a href="<?=base_url('bigadmin/clients');?>"><i class="fa fa-list"></i> Daftar Klien</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span>Manajemen Projek</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('bigadmin/projects/add');?>"><i class="fa fa-plus"></i> Tambah Projek</a></li>
            <li><a href="<?=base_url('bigadmin/projects');?>"><i class="fa fa-list"></i> Daftar Projek</a></li>
            <li><a href="<?=base_url('bigadmin/project_categories');?>"><i class="fa fa-tags"></i> Daftar Kategori Projek</a></li>
          </ul>
        </li>
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span>Manajemen Departemen</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('bigadmin/departments/add');?>"><i class="fa fa-plus"></i> Tambah Departemen</a></li>
            <li><a href="<?=base_url('bigadmin/departments');?>"><i class="fa fa-list"></i> Daftar Departemen</a></li>
          </ul>
        </li> -->
<?php endif;?>
      </ul>
    </section>