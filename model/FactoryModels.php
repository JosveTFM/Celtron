<?php

require_once __DIR__ ."/Usuario.php";
require_once __DIR__ ."/Producto.php";
require_once __DIR__ ."/Proforma.php";
require_once __DIR__ ."/Cliente.php";
require_once __DIR__ ."/ComprobanteDePago.php";
require_once __DIR__ ."/UsuarioPrivilegio.php";
require_once __DIR__ ."/Observacion.php";
require_once __DIR__ ."/Categoria.php";
require_once __DIR__ ."/Marca.php";
require_once __DIR__ ."/EstadoEntidad.php";

class FactoryModels{
    public static function getModel($name){
        $model = null;
        switch($name){
            case "usuario":
                $model = new Usuario;
                break;
            case "cliente":
                $model = new Cliente;
                break;
            case "producto":
                $model = new Producto;
                break;
            case "proforma":
                $model = new Proforma;
                break;
            case "comprobante":
                $model = new ComprobanteDePago;
                break;
            case "usuarioPrivilegio":
                $model = new UsuarioPrivilegio;
                break;
            case "observacion":
                $model = new Observacion;
                break;
            case "categoria":
                $model = new Categoria;
                break;
            case "marca":
                $model = new Marca;
                break;
            case "estado_entidad":
                $model = new EstadoEntidad;
                break;
        }
        return $model;
    }
}

?>