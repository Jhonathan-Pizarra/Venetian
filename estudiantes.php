<?php 

//1) Función para crear archivo
    function crear_fichero($abc){
        $flujo = fopen('dataExportada.xml', 'w');
        fputs($flujo, $abc);
        fclose($flujo);
    }

//2) Conexión a BDD
    $db_host="localhost:3307"; //Yo le puse este puerto porque el 3306 está ocupado...
    $db_nombrebdd="xml";
    $db_user="root";
    $db_password="";

    $dwes=mysqli_connect($db_host, $db_user, $db_password);
    if(mysqli_connect_errno($dwes)){
        echo "No se ha conectado! :( ";

    }else{
        echo "Se conectó ^.^";
    }

    mysqli_set_charset($dwes, "utf8");
    mysqli_select_db($dwes, $db_nombrebdd) or die("No hay esa base de datos");


//3) Consulta para traer regustros del maiSQL
    if(isset($dwes)){
        $a= $sql="SHOW TABLES";
        $xml="<?xml version=\"1.0\"?>\n";
        $b=mysqli_query($dwes, $a);
        while(($ver=mysqli_fetch_row($b))==true){
            echo"<br>"."------------------"."</br>";
            echo $ver[0]." ";
            echo "<br/>";
            echo "------------------"."</br>";

            $xml .= "\t<".$ver[0].">\n";
            $c= $sql="select * from estudiantes";
            $d=mysqli_query($dwes, $c);
                while($fila = mysqli_fetch_array($d, MYSQLI_ASSOC)){
                    $xml .="\t\t<registro>\n";
                    foreach($fila as $pos => $va){
                        echo "$pos => $va.\n";
                        echo "<br/>";
                        $xml .= "\t\t\t<".$pos.">".$va."</".$pos.">\n";
                    }
                    echo "------------------"."<br/>";
                    $xml .="\t\t</registro>\n";              
                }
                $xml .= "\t</".$ver[0].">\n";
        }

        crear_fichero($xml);
    }

?>