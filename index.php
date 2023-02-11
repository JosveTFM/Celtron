<?php 
require_once __DIR__."/model/FacadeViews.php";
$facade = new FacadeViews;
$objFormAutenticacion  = $facade->getFormAutenticarUsuarioShow();
    
?>