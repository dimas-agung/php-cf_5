<?php 
	session_start();
	include "library/conn.php";
	include "library/helper.php";
	
	date_default_timezone_set("Asia/Jakarta");
	if(empty($_SESSION['app_id']) and empty($_SESSION['app_user'])){
		redirect(base_url().'login.php'); die();
	}
	
	include "library/form_akses.php";
?>


<?php
include "pages/element/v_atas.php";
?>


      <!-- Main content -->
      <section class="content">
       
         <?php
		if(isset($_GET['page'])){
			if(file_exists('pages/data/'.$_GET['page'].'.php')) {
				switch($_GET['page']){
					case ''.$_GET['page'].'' : include 'pages/data/'.$_GET['page'].'.php'; break;
					default : include 'pages/data/dashboard.php'; break;
				}
			}
			elseif(file_exists('pages/data/'.$_GET['page'].'/index.php')) {
				switch($_GET['page']){
					case ''.$_GET['page'].'' : include 'pages/data/'.$_GET['page'].'/index.php'; break;
					default : include 'pages/data/dashboard.php'; break;
				}
			} 
			else {
				include 'pages/data/dashboard.php';
			}
		} else {
			include 'pages/data/dashboard.php';
		}
	?>
        
    <!-- /.box -->
      </section>

<?php
include "pages/element/v_bawah.php";
?> 