<?php
# Handler de alternancia (no persiste en servidor). Devuelve JSON { ok: true|false }

header( 'Content-Type: application/json; charset=UTF-8' );

require_api( 'gpc_api.php' );

$t_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if( $t_method !== 'POST' ) {
	echo json_encode( array( 'ok' => false, 'error' => 'method_not_allowed' ) );
	exit;
}

$t_estado = gpc_get_string( 'activo', '' );
if( $t_estado !== 'on' && $t_estado !== 'off' ) {
	echo json_encode( array( 'ok' => false, 'error' => 'invalid_param' ) );
	exit;
}

echo json_encode( array( 'ok' => true ) );
