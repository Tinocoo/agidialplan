#!/usr/bin/php
<?php

require_once('phpagi/phpagi.php');
require_once('connection.php');

$agi=new AGI();
$cliente=$argv[1];
$tipo=$argv[2];
$dialnumber=$argv[3];

$query = "SELECT * FROM PermissionExten WHERE defaultuser = '$cliente'";
$result = $connect->query($query);
$row = mysqli_fetch_assoc($result);
if ($result->num_rows > 0) {
	$agi->set_variable("MROTA","1");
	$agi->set_variable("RECIN",$row['recin']);
	$agi->set_variable("RECOUT",$row['recout']);
	$agi->set_variable("GROTA",$row['routeout']);
	if ($tipo == 'local'){
		$rota = $row['local'];
	}elseif ($tipo == 'ldn'){
                $rota = $row['ldn'];
        }elseif ($tipo == 'ldi'){
                $rota = $row['ldi'];
        }
	elseif ($tipo == 'vc1'){
                $rota = $row['vc1'];
        }
	elseif ($tipo == 'vc2'){
                $rota = $row['vc2'];
        }
        if($rota == 1){
        	$agi->set_variable("PERMISSAO", $rota);
                $name = $row['routeout'];
                $nquery = "SELECT * FROM RouteInterface WHERE name = '$name'";
                $nresult = $connect->query($nquery);
                $nrow = mysqli_fetch_assoc($nresult);
                if ($nresult->num_rows > 0) {
			$agi->set_variable("ROTA", "1");
			if ($tipo == 'ldn'){
				$codcsp = $nrow['cspldn'];
				$trunk = $nrow['ldn'];
				$ndialnumber = substr($dialnumber, -(strlen($dialnumber) - 1));
	                        $agi->set_variable("DIALNUMBER", $nrow['cspldn']."".$ndialnumber);
			}elseif ($tipo == 'vc2'){
				$codcsp = $nrow['cspvc2'];
                                $trunk = $nrow['vc2'];
                                $ndialnumber = substr($dialnumber, -(strlen($dialnumber) - 1));
                                $agi->set_variable("DIALNUMBER", $codcsp."".$ndialnumber);
			}elseif ($tipo == 'local'){
                                $trunk = $nrow['local'];
                                $agi->set_variable("DIALNUMBER", $dialnumber);
                        }elseif ($tipo == 'vc1'){
                                $trunk = $nrow['vc1'];
                                $agi->set_variable("DIALNUMBER", $dialnumber);
                        }
			$agi->set_variable("TRUNK", $trunk);
                }else{
                        $agi->set_variable("ROTA", "0");
                }
	}else{
        	$agi->set_variable("PERMISSAO", $row['ldn']);
        }
}else{
	$agi->set_variable("MROTA","0");
}

exit();

?>
