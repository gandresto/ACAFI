<?php

function random_str($length = 8) {
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function normaliza($cadena){
    $originales =   'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}

function nombre_completo($usuario, $ordenarPor='nombre', $con_grado=false){
    $grado = $con_grado ? $usuario->grado : "";
    return $ordenarPor == 'apellido' ? "{$usuario->apellido_paterno} {$usuario->apellido_materno} {$usuario->nombre} {$grado}"
                              : "{$grado} {$usuario->nombre} {$usuario->apellido_paterno} {$usuario->apellido_materno}";
}

function es_verdadero($valor)
{
    return in_array($valor, [1, "1", "true", "y", "s"]);
}

function dar_formato_de_fecha($fecha){
    return Carbon\Carbon::parse($fecha)->format('d/m/Y');
}

function dar_formato_de_hora($fecha){
    return Carbon\Carbon::parse($fecha)->format('h:i A');
}

?>
