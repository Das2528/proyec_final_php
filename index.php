<?php
include('include/header.php');
include('include/footer.php');
require 'service.php';
$casas = array();
$casas = new casas();
$listCiudades = $casas->Login_City();
$listTipo = $casas->Logion_Type();
$Precio = 100000;
$Data = array();

if (isset($_GET['full'])) {
  $Data = $casas->get_full_home();
  $canti = count($Data);
}


if (isset($_POST['filtrar'])) {
  $Precio = $_POST['precio1'];
  $Tipo = $_POST['tipo'];
  $Ciudad = $_POST['ciudad'];

  $Data = $casas->Option_filter_($Precio, $Ciudad, $Tipo);
  $canti= count($Data);
}

?>


<div class="contenedor">
  <div class="card rowTitulo">
    <h1>Buscador</h1>
  </div>
  <div class="colFiltros">
    <form action="index.php" method="post" id="formulario">
      <div class="filtrosContenido">
        <div class="tituloFiltros">
          <h5>Realiza una búsqueda personalizada</h5>
        </div>
        <div class="filtroCiudad input-field">
          <select class="select-wrapper" name="ciudad" id="selectCiudad">
            <option value="nada" selected>Elige una ciudad</option>
            <?php
            foreach ($listCiudades as $ciudad) {
              if ($ciudad == $Ciudad) { ?>
                <option selected="selected" value="<?php echo $ciudad ?>"> <?php echo $ciudad ?> </option>
              <?php
              } else { ?>
                <option value="<?php echo $ciudad ?>"> <?php echo $ciudad ?> </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="filtroTipo input-field">

          <select class="select-wrapper" name="tipo" id="selectTipo">
            <option value="nada" selected>Elige un tipo</option>
            <?php
            foreach ($listTipo as $tipo) {
              if ($tipo == $Tipo) {
            ?>

                <option selected="selected" value="<?php echo $tipo ?>"> <?php echo $tipo ?> </option>
              <?php
              } else { ?>
                <option value="<?php echo $tipo ?>"> <?php echo $tipo ?> </option>

            <?php }
            } ?>
          </select>
        </div>
        <div class="filtroPrecio">
          <label for="rangoPrecio">Precio inicial: de 0 - <?php echo $Precio?></label>
          <input type="range" id="rangoPrecio" name="precio1" value="<?php echo $Precio ?>" min="0" max="100000" />
        </div>
        <div class="botonField">
          <input type="submit" class="btn white" value="Buscar" id="submitButton" name="filtrar">
        </div>
      </div>
    </form>
  </div>

  <div class="colContenido">
    <div class="tituloContenido card">
      <h5>Resultados de la búsqueda: <?php echo $canti?></h5>
      <div class="divider">
        <?php


        foreach ($Data as $value) {
        ?>
          <div class="itemMostrado">

            <img src="img/home.jpg" alt="casa ">

            <div class="card-stacked">
              <h3 class="titulo"> Tipo: <?php echo $value['Tipo'] ?></h3>
              <P class="info">Ciudad: <?php echo $value['Ciudad'] ?></P>
              <P class="info">Direecion: <?php echo $value['Direccion'] ?></P>
              <P class="info">Telefono: <?php echo $value['Telefono'] ?></P>
              <P class="info">Código postal: <?php echo $value['Codigo_Postal'] ?></P>
              <P class="precioTexto info">Precio: <?php echo $value['Precio'] ?></P>

            </div>
          </div>
        <?php } ?>
      </div>
      <a href="index.php?full" name="todos" class="btn-flat waves-effect" id="mostrarTodos">Mostrar Todos</a>

    </div>
  </div>
</div>
</div>