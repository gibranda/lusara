<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title;?>-Bootstrap Sample</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/3.3.4/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/font-awesome/4.3.0/css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/select2/css/select2.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/simple-sidebar.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap_styling.css');?>">

	<script type="text/javascript" src="<?php echo base_url('assets/vendor/jquery/2.1.3/jquery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap/3.3.4/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/vendor/select2/js/select2.min.js');?>"></script>
</head>
<body>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Start Bootstrap
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('kategori');?>">Kategori Produk</a>
                </li>
                <li>
                    <a href="<?php echo site_url('produk');?>">Produk</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<div id="toggler">
                        	<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>                    		
                    	</div>
                        <?php 
                        	echo $output;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>