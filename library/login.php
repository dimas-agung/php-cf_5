<?php
if(isset($_POST['username'])){
	$usern = mres($_POST['username']);
	$passw = mres($_POST['password']);
	//$captcha = md5($_POST['captcha']);
	define('LOG','log.txt');
			function write_log($log){  
			 $time = @date('[Y-m-d H:i:s]');
			 $op=$time.' '.'Action for '.$log."\n".PHP_EOL;
			 $fp = @fopen(LOG, 'a');
			 $write = @fwrite($fp, $op);
			 @fclose($fp);
			}

	//if($captcha == $_SESSION['verify_captcha']) {
		$cek	= mysql_query("SELECT * FROM user WHERE username = '$usern' AND password = '$passw' AND aktif='1'");
		if(mysql_num_rows($cek) > 0){
			$row	= mysql_fetch_array($cek);
			$_SESSION['app_id']		= $row['kd_user'];
			$_SESSION['app_user']	= $row['nm_user'];
			$_SESSION['app_level']	= $row['level'];
			
			$nama_user = $row['nm_user'];
			
			
			redirect(base_url());
			write_log("login '".$nama_user."' Sukses");
		} else {
			//write_log("login '".$nama_user."' Gagal");
			$response	= "99|Username Password salah atau akun sudah tidak aktif.";
		}
	//} else {$response = "99|Kode captcha salah.";}
}





?>