<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <?php require 'view/main/menu.php';
        $menu = new Menu();
        $menu->header('Inicio','Error')
    ?>
	<div id="main">
		<h1 class="text-danger text center">
		<?php 
			echo $this->mensaje;
		?>	
		</h1>
	</div>

    <?php $menu->footer()?>
</body>
</html>