# Instalación

Para instalar el plugin se requiere agregar el siguiente código en el `composer.json` de un plugin o del OctoberCMS.

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@bitbucket.org:SoftWorksPySA/softworkspywinter.git"
    },
    {
        "type": "vcs",
        "url": "git@bitbucket.org:SoftWorksPySA/wn-appconfig-plugin.git"
    }
],
"require": {
    "softworkspy/wn-appconfig-plugin": "^2.3.1"
}
```

Luego de debe ejecutar el comando `composer update && php artisan winter:up` para descargar e instalar el plugin y todas sus dependencias.
