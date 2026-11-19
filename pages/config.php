<?php
# Modo Daltónico - Página de configuración

require_api( 'authentication_api.php' );
require_api( 'access_api.php' );
require_api( 'config_api.php' );
require_api( 'form_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'print_api.php' );
require_api( 'string_api.php' );

# Asegurar permisos para gestionar plugins
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$t_title = plugin_lang_get( 'configuracion' );
$t_saved = gpc_get_bool( 'saved', false );

# Procesamiento de formulario (POST)
if( gpc_get_string( 'action', '', false ) === 'save' ) {
	form_security_validate( 'plugin_ModoDaltonico_config' );

	$t_default_enabled = gpc_get_bool( 'default_enabled', false );
	$t_contrast_type = gpc_get_string( 'contrast_type', 'deuteranopia' );

	$t_allowed = array( 'protanopia', 'deuteranopia', 'tritanopia' );
	if( !in_array( $t_contrast_type, $t_allowed, true ) ) {
		$t_contrast_type = 'deuteranopia';
	}

	plugin_config_set( 'default_enabled', $t_default_enabled );
	plugin_config_set( 'contrast_type', $t_contrast_type );

	form_security_purge( 'plugin_ModoDaltonico_config' );
	print_header_redirect( plugin_page( 'config', true ) . '&saved=1' );
	exit;
}

# Valores actuales
$t_current_enabled = (bool) plugin_config_get( 'default_enabled', true );
$t_current_type = (string) plugin_config_get( 'contrast_type', 'deuteranopia' );

# Layout
layout_page_header( $t_title );
layout_page_begin( 'manage_overview_page.php' );
?>
<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>
	<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<?php echo string_display_line( plugin_lang_get( 'configuracion' ) ); ?>
			</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<?php if( $t_saved ) { ?>
					<div class="alert alert-success">
						<?php print_icon( 'fa-check', 'ace-icon' ); ?>
						<?php echo string_display_line( plugin_lang_get( 'guardado_ok' ) ); ?>
					</div>
				<?php } ?>
				<form method="post" action="<?php echo string_attribute( plugin_page( 'config' ) ); ?>" class="form-horizontal">
					<?php echo form_security_field( 'plugin_ModoDaltonico_config' ); ?>
					<input type="hidden" name="action" value="save" />

					<div class="form-group">
						<label class="col-sm-3 control-label" for="default_enabled">
							<?php echo string_display_line( plugin_lang_get( 'activado' ) ); ?>
						</label>
						<div class="col-sm-9">
							<label>
								<input type="checkbox" id="default_enabled" name="default_enabled" class="ace" <?php echo $t_current_enabled ? 'checked' : ''; ?>>
								<span class="lbl"> <?php echo string_display_line( $t_current_enabled ? plugin_lang_get( 'modo_activo' ) : plugin_lang_get( 'modo_inactivo' ) ); ?></span>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="contrast_type">
							<?php echo string_display_line( plugin_lang_get( 'configuracion' ) ); ?> - <?php echo string_display_line( plugin_lang_get( 'indicador_activo' ) ); ?>
						</label>
						<div class="col-sm-9">
							<select id="contrast_type" name="contrast_type" class="input-sm">
								<option value="protanopia" <?php echo $t_current_type === 'protanopia' ? 'selected' : ''; ?>><?php echo string_display_line( plugin_lang_get( 'protanopia' ) ); ?></option>
								<option value="deuteranopia" <?php echo $t_current_type === 'deuteranopia' ? 'selected' : ''; ?>><?php echo string_display_line( plugin_lang_get( 'deuteranopia' ) ); ?></option>
								<option value="tritanopia" <?php echo $t_current_type === 'tritanopia' ? 'selected' : ''; ?>><?php echo string_display_line( plugin_lang_get( 'tritanopia' ) ); ?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<input type="submit" class="btn btn-primary btn-sm" value="<?php echo string_attribute( plugin_lang_get( 'guardar' ) ); ?>" />
							<a class="btn btn-default btn-sm" href="<?php echo string_attribute( helper_mantis_url( 'manage_overview_page.php' ) ); ?>">
								<?php echo string_display_line( plugin_lang_get( 'cancelar' ) ); ?>
							</a>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<?php
layout_page_end();
