<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BIG IO | <?=isset($title) ? $title : "Helpdesk";?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->  
  <link rel="stylesheet" href="<?=base_url("assets/");?>bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?=base_url("assets/");?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=base_url("assets/");?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?=base_url("assets/");?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url("assets/");?>dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<?php if($this->uri->segment(2) == "login") :?>
<body class="hold-transition login-page">
  <?=$contents;?>
<?php else: ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url("users");?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BIG</b>IO</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BIG IO</b> HELPDESK</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?=$users->username;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
                  <?=$users->name;?> - <?=$users->company;?>
                  <small>Member sejak <?=tanggalindo($users->created_at);?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url('users/profile');?>" class="btn btn-default btn-flat">Profil</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('users/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
      <?php $this->load->view('public/sidebar');?>
  </aside>

  <!-- =============================================== -->
  
  <?=$contents;?>
  

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?php echo date("Y");?>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<?php endif;?>


<!-- jQuery 3 -->
<script src="<?=base_url("assets/");?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url("assets/");?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url("assets/");?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url("assets/");?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url("assets/");?>dist/js/adminlte.min.js"></script>

<script src="<?=base_url("assets/");?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url("assets/");?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url("assets/");?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url("assets/");?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?=base_url("assets/");?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url("assets/");?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url("assets/");?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?=base_url("assets/");?>plugins/iCheck/icheck.min.js"></script>
<script src="<?=base_url("assets/");?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script type="text/javascript">

  let base_url = $("#base_url").val();
  let path     = window.location.pathname;
  let host     = window.location.hostname;
  var table;

$(document).ready(function() {
    $(".project_select").select2();
    $('#replyTicket').hide();
    $('#replyTicket').hide();

    $('#replyButtonTicket').click(function(){
        if ($('#replyTicket').css('display') == 'none') {
            $('#replyTicket').fadeIn();
        }else{
            $('#replyTicket').fadeOut();
        }        
    });

    //add more file
    $("#add-more").click(function() {
      $("#form-file").append('<input type="file" name="attachments[]" id="attachment" class="form-control">');
    });

  if(path.search('login') > 0){
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  }

    $('#editor').wysihtml5();
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
 
 
    //check all
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    //add more file
    $("#add-more").click(function() {
      $("#form-file").append('<input type="file" name="attachments[]" id="attachment" class="form-control">');
    });

    if(path.search('users/tickets')>0){
      table =$('#TicketsTable').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "tickets/ajax_list/",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
      });
    }
});
</script>
</body>
</html>
