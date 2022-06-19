<?php
class casas{


//carga todos los dar}tos
    public function get_full_home()
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();       
        $listadeCasa = array();


        foreach($extraData->extraer() as $row){
    
        array_push($listadeCasa, $row);
        }

        return $listadeCasa;
    }
//cargha la lista de ciudades en el select
    public function Login_City()
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();       
        $listadeCidad = array();
        $existe = false;

        foreach($extraData->extraer() as $row){
  
       foreach( $listadeCidad as $ciudad){

        if($row['Ciudad']==$ciudad){
            $existe= true;
            break;
        }
        else{
            $existe = false;
        }
        }
        if (!$existe) {
        array_push($listadeCidad, $row['Ciudad']);
        }
        }
        return $listadeCidad;
    }
//carga lista de tipos en el select 
    public function Logion_Type()
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaTipo = array();
        $existe = false;

        foreach ($extraData->extraer() as $row) {

            foreach ($listaTipo as $tipo) {

                if ($row['Tipo'] == $tipo) {
                    $existe = true;
                    break;
                } else {
                    $existe = false;
                }
            }
            if (!$existe) {
                array_push($listaTipo, $row['Tipo']);
            }
        }

        return $listaTipo;
    }
//Convierte el precio en un int
    public function convertirPrecio($precio)
    {
        
        $ValorSeparado = explode('$', $precio);
        $ValorSeparado2 = explode(',', $ValorSeparado[1]);
        $valor = (int)$ValorSeparado2[0] . $ValorSeparado2[1];
        return$valor;
    }
//controlador de la solicitud
    public function Option_filter_($precio,$ciudad,$tipo )
    {   
        $option=0;
        if($precio == 100000 && $ciudad== "nada" && $tipo== "nada"){
            $option=0;
            //cargar todos 
        }elseif ($precio < 100000 && $ciudad == "nada" && $tipo == "nada") {
            $option=1;
            //filtra  x precio
        } elseif ($precio == 100000 && $ciudad <> "nada" && $tipo == "nada") {
            $option = 2;
            //filtra  x ciudad
        } elseif ($precio == 100000 && $ciudad == "nada" && $tipo <> "nada") {
            $option = 3;
            //filtra  x tipo
        } elseif ($precio == 100000 && $ciudad <> "nada" && $tipo <> "nada") {
            $option = 4;
            //filtra  x tipo ciudad
        } elseif ($precio < 100000 && $ciudad == "nada" && $tipo <> "nada") {
            $option = 5;
            //filtra  x precio tipo
        } elseif ($precio < 100000 && $ciudad <> "nada" && $tipo == "nada") {
            $option = 6;
            //filtra  x precio ciudad
        } elseif ($precio < 100000 && $ciudad <> "nada" && $tipo <> "nada") {
            $option = 7;
            //filtra  x precio tipo ciudad
        }else{
            $option=0;
        }


        switch ($option){
            case 0: return $this->get_full_home();
                    break;

            case 1:
                return $this->get_by_Price($precio);
                break;

            case 2:
                return $this->get_by_city($ciudad);
                break;

            case 3:
                return $this->get_by_Type($tipo);
                break;

            case 4:
                return $this->get_by_city_type($ciudad, $tipo);
                break;

            case 5:
                return $this->get_by_price_type($precio,$tipo);
                break;
            case 6:
                return $this->get_by_city_price($precio, $ciudad);
                break;

            case 7:
                return $this->get_by_city_price_type($precio,$ciudad,$tipo);
                break;
            default:
               
                break;
        }
    
    }


//filtra solo x la ciudad
    public function get_by_city($ciudad)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaCasa = array();
        foreach ($extraData->extraer() as $row) {
            if ($row['Ciudad'] == $ciudad) {
                array_push($listaCasa, $row);
            }
        }

        return $listaCasa;
    }
//filtra solo x tipo
    public function get_by_Type($Type)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaCasa = array();
        foreach ($extraData->extraer() as $row) {
            if ($row['Tipo'] == $Type) {
                array_push($listaCasa, $row);
            }
        }

        return $listaCasa;
    }
//filtra solo pro precio 
    public function get_by_Price($Price)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaCasa = array();
        foreach ($extraData->extraer() as $row) {
            if ($this->convertirPrecio( $row['Precio']) <= $Price) {
                array_push($listaCasa, $row);
            }
        }

        return $listaCasa;
    }
    //filtro x precio y ciudad
    public function get_by_city_price($precio, $ciudad)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaId = array();


        foreach ($extraData->extraer() as $row) {
            if ($row['Ciudad'] == $ciudad && $this->convertirPrecio($row['Precio']) <= $precio) {
                array_push($listaId, $row['Id']);
            }
        }
        $listadeCasa = array();

        foreach ($listaId as $id) {

            foreach ($extraData->extraer() as $row) {
                if ($id == $row['Id']) {
                    array_push($listadeCasa, $row);
                    break;
                }
            }
        }

        return $listadeCasa;
    }
    //filtro x precio y tipo
    public function get_by_price_type($precio, $tipo)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaId = array();


        foreach ($extraData->extraer() as $row) {
            if ($row['Tipo'] == $tipo && $this->convertirPrecio($row['Precio']) <= $precio) {
                array_push($listaId, $row['Id']);
            }
        }
        $listadeCasa = array();

        foreach ($listaId as $id) {

            foreach ($extraData->extraer() as $row) {
                if ($id == $row['Id']) {
                    array_push($listadeCasa, $row);
                    break;
                }
            }
        }

        return $listadeCasa;
    }
    //filtro x tipo y ciudad 
    public function get_by_city_type( $ciudad, $tipo)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaId = array();


        foreach ($extraData->extraer() as $row) {
            if ($row['Tipo'] == $tipo && $row['Ciudad'] == $ciudad ) {
                array_push($listaId, $row['Id']);
            }
        }
        $listadeCasa = array();

        foreach ($listaId as $id) {

            foreach ($extraData->extraer() as $row) {
                if ($id == $row['Id']) {
                    array_push($listadeCasa, $row);
                    break;
                }
            }
        }

        return $listadeCasa;
    }

    //filtro x todo los parámetros
    public function get_by_city_price_type($precio, $ciudad, $tipo)
    {
        require_once('Import_DB.php');
        $extraData = new extraerDataJson();
        $listaId = array();


        foreach ($extraData->extraer() as $row) {
            if ($row['Tipo'] == $tipo && $row['Ciudad'] == $ciudad && $this->convertirPrecio($row['Precio']) <= $precio) {
                array_push($listaId, $row['Id']);
            }
        }
        $listadeCasa = array();

        foreach ($listaId as $id) {

            foreach ($extraData->extraer() as $row) {
                if ($id == $row['Id']) {
                    array_push($listadeCasa, $row);
                    break;
                }
            }
        }

        return $listadeCasa;
    }


}

?>