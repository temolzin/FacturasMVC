<?php require 'menu.php';
    $menu = new Menu();
    $menu->header('Inicio','Inicio')
?>

    <h1 class="text-info text-center">Bienvenido </h1><br>
    <div class="text-center">
        <img class="img-fluid" src="<?php echo constant('URL').'public/img/phpimgg.png'; ?>" alt="">
    </div>
<?php $menu->footer()?>