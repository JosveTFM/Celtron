<?php 

include_once("formulario.php");
// include_once("headIniSingleton.php");
// include_once("footerSingleton.php");
class formMensajeSistema extends formulario
{public function __construct()
	{   
		$this->path = "..";
		$this -> encabezadoShowIni("Mensaje Sistema");
	}
	public function formMensajeSistemaShow($mensaje,$enlace,$exito = false)
	{
		// headIniSingleton::getHead("Mensaje del sistema","..");
		?>
		<div class="form-message">
			<img src="../img/<?php echo $exito?'exito.png':'alert.png' ?>" alt="" class="form-message__img">
			<p class="form-message__content">
				<?php echo $mensaje;?>
			</p>
			<?php echo $enlace;?>
		</div>

		<?php
		// footerSingleton::getFooter('..');
		$this->piePaginaShow();
	}
}
?>