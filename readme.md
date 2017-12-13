### Presentación 
El siguiente repositorio es una __prueba__ que integra los servicios de PlaceToPay con una aplicación sencilla en Laravel 5.5.

La aplicación está diseñada para ser bastante intuitiva en su uso por eso no hay una descripción detallada de cómo funciona.

### Uso recomendado
1. Clonar el repositorio 
2. Ejecutar `composer install`
2. En el repositorio usar `php artisan serve`. O se recomienda el uso de __laravel valet__.

### Tests
1. Hay algunos (13) tests que puedes verificar usando `./vendor/bin/phpunit --exclude-group=integration` 
2. En el punto 3 se excluden los test de integración con la plataforma real de __place to pay__, si los quieres incluir  puedes usar `./vendor/bin/phpunit`.

### Advertencia
1. Este repositorio por defecto no excluye el archivo `.env`, lo que es una mala practica, ten cuidado al agregar tus datos en este
2. Hay una base de datos __sqlite__ en `/database/database.sqlite` incluida para las pruebas,  si la quieres reiniciar, puedes usar el comando `php artisan migrate:fresh --seed`

