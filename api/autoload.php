<?php
/**
 * Autoload
 * Classe utilizada para carregar
 * automaticamente as outras classes
 * conforme vão sendo utilizadas
 */
class Autoload
{
	public function __construct() {
		spl_autoload_extensions(MISC['class_ext']);
		spl_autoload_register(array($this, 'load'));
	}

	private function load($className) {
		$className = str_replace('\\', '/', $className);
		$className = str_replace(ucfirst(DIR['classes']).'/', '', $className);
		$extension = spl_autoload_extensions();
		require_once (DIR['classes'] . '/' . strtolower($className) . $extension);
	}
}
