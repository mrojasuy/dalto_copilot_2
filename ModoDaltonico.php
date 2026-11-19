<?php
# Modo Daltónico plugin for MantisBT

class ModoDaltonicoPlugin extends MantisPlugin {
	/**
	 * Plugin registration
	 */
	public function register() {
		$this->name = plugin_lang_get( 'nombre' );
		$this->description = plugin_lang_get( 'descripcion' );
		$this->version = '1.0.0';
		$this->requires = array( 'MantisCore' => '2.0.0' );
		$this->author = 'Proyecto de Grado';
		$this->contact = 'admin@example.com';
		$this->url = 'https://example.com/modo-daltonico';
		// Página principal de configuración del plugin
		$this->page = 'config';
	}

	/**
	 * Default configuration values
	 */
	public function config() {
		return array(
			'default_enabled' => true,
			'contrast_type' => 'deuteranopia', // protanopia | deuteranopia | tritanopia
		);
	}

	/**
	 * Declare custom events (none for now)
	 */
	public function events() {
		return array();
	}

	/**
	 * Hook into core events
	 */
	public function hooks() {
		return array(
			// Añadir enlace al menú principal para acceder a la configuración
			'EVENT_MENU_MAIN' => 'on_menu_main',
			// Incluir CSS/JS y exponer configuración JS
			'EVENT_LAYOUT_RESOURCES' => 'on_layout_resources',
		);
	}

	/**
	 * Installation hook
	 */
	public function install() {
		return true;
	}

	/**
	 * Uninstall hook
	 */
	public function uninstall() {
		// Limpiar claves de configuración
		if( function_exists( 'plugin_config_delete' ) ) {
			@plugin_config_delete( 'default_enabled' );
			@plugin_config_delete( 'contrast_type' );
		}
		return true;
	}

	/**
	 * Add link to main menu
	 * @return array
	 */
	public function on_menu_main() {
		$t_link = '<a href="' . string_attribute( plugin_page( 'config' ) ) . '">' . string_display_line( plugin_lang_get( 'configuracion' ) ) . '</a>';
		return array( $t_link );
	}

	/**
	 * Output CSS/JS resources and configuration
	 */
	public function on_layout_resources() {
		// CSS
		echo '<link rel="stylesheet" type="text/css" href="' . string_attribute( plugin_file( 'modoDaltonico.css' ) ) . '" />' . "\n";

		// Configuración JS dinámica (evita inline script por CSP)
		echo '<script type="application/javascript" src="' . string_attribute( plugin_page( 'config_data' ) ) . '"></script>' . "\n";

		// JS principal del plugin
		echo '<script type="application/javascript" src="' . string_attribute( plugin_file( 'modoDaltonico.js' ) ) . '"></script>' . "\n";
	}
}
