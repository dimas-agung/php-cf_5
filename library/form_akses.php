<?php
	$q_akses = mysql_query("SELECT '1' AS `kode_role`, '1' AS `form`, '1' AS `r`, '1' AS `w` UNION SELECT `kode_role`, `form`, `r`, `w` FROM `mst_role_dtl` WHERE `kode_role`= '" . $_SESSION['app_level'] . "'");
