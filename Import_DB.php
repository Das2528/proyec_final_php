<?php
class  extraerDataJson
{
    public static function extraer()
    {

        try {
            $json = file_get_contents('data-1.json'); //permite extraer los datos del json
            //echo $json;
            $date = json_decode($json, true); //convierto los datos en arreglo 
            //print_r($date);
        } catch (Exception $e) {
            die ("Error". $e->getMessage());
            echo "linea de error".$e->getLine();
        }
        return $date;
    }
}


?>