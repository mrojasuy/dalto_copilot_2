<?php
# Emite JavaScript para window.ModoDaltonicoConfig (CSP-safe, sin inline)

header( 'Content-Type: application/javascript; charset=UTF-8' );

$t_data = array(
	'initialActive' => (bool) plugin_config_get( 'default_enabled', true ),
	'contrastType' => (string) plugin_config_get( 'contrast_type', 'deuteranopia' ),
	'toggleUrl' => plugin_page( 'toggle' ),
	'activeLabel' => (string) plugin_lang_get( 'activar' ),
	'inactiveLabel' => (string) plugin_lang_get( 'desactivar' ),
	'strings' => array(
		'nombre' => (string) plugin_lang_get( 'nombre' ),
		'descripcion' => (string) plugin_lang_get( 'descripcion' ),
		'modo_activo' => (string) plugin_lang_get( 'modo_activo' ),
		'modo_inactivo' => (string) plugin_lang_get( 'modo_inactivo' ),
		'indicador_activo' => (string) plugin_lang_get( 'indicador_activo' ),
		'protanopia' => (string) plugin_lang_get( 'protanopia' ),
		'deuteranopia' => (string) plugin_lang_get( 'deuteranopia' ),
		'tritanopia' => (string) plugin_lang_get( 'tritanopia' ),
		'activar' => (string) plugin_lang_get( 'activar' ),
		'desactivar' => (string) plugin_lang_get( 'desactivar' ),
	),
);

echo 'window.ModoDaltonicoConfig = ' . json_encode( $t_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . ';';
