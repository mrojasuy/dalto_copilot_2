# Plugin "Modo Daltónico" para MantisBT

## Descripción
Plugin para mejorar la accesibilidad de MantisBT aplicando ajustes de contraste y filtros no invasivos que ayudan a usuarios con protanopia, deuteranopia o tritanopia. Incluye un botón flotante para activar/desactivar el modo y una página de configuración.

---

## Guía rápida (Español)

### Instalación
1. Copia la carpeta `ModoDaltonico` dentro de `plugins/` de tu instalación de MantisBT.
2. Inicia sesión como administrador y ve a: Administración → Complementos.
3. Localiza "Modo Daltónico" y pulsa "Instalar".

### Configuración
- Desde Administración → Complementos → Plugins instalados, haz clic en "Modo Daltónico" (o en el enlace del menú principal) para abrir la página de configuración.
- Opciones disponibles:
  - Activación por defecto (Activado/Desactivado)
  - Tipo de contraste: Protanopia, Deuteranopia, Tritanopia

### Uso
- En cualquier página, usa el botón flotante para activar/desactivar el modo. El estado se guarda en el navegador (localStorage) y persiste entre pestañas y sesiones.
- El indicador/badge del botón muestra si el modo está activo.

### Compatibilidad
- MantisBT 2.0 o superior.
- Navegadores recientes: Google Chrome, Safari y Microsoft Edge.

---

## Quick Guide (English)

### Installation
1. Copy the `ModoDaltonico` folder into your MantisBT `plugins/` directory.
2. Log in as administrator and go to: Administration → Manage Plugins.
3. Find "Color-blind Mode" and click "Install".

### Configuration
- From Administration → Plugins → Installed plugins, click the plugin name to open the configuration page.
- Available options:
  - Default activation (Enabled/Disabled)
  - Contrast type: Protanopia, Deuteranopia, Tritanopia

### Usage
- Use the floating button on any page to toggle the mode on/off. The state is stored in the browser (localStorage) and persists across tabs and sessions.
- The small badge indicates whether the mode is currently active.

### Compatibility
- MantisBT 2.0 or newer.
- Modern browsers: Google Chrome, Safari, Microsoft Edge.

---

## Notas técnicas
- Cumplimiento CSP: sin JavaScript inline ni atributos `on*`; listeners se agregan con `addEventListener` desde `files/modoDaltonico.js`.
- Recursos estáticos en `files/` y cargados con `plugin_file()`.
- Textos localizados en `lang/strings_spanish.txt` y `lang/strings_english.txt` con prefijo `s_plugin_ModoDaltonico_*`.
- Config del lado del servidor expuesta a JS vía `pages/config_data.php` (sin `<script>` inline).
