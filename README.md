<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser verdaderamente satisfactorio. Laravel elimina el dolor del desarrollo facilitando tareas comunes utilizadas en muchos proyectos web, tales como:

- [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
- [Contenedor de inyección de dependencias potente](https://laravel.com/docs/container).
- Múltiples back-ends para almacenamiento de [sesiones](https://laravel.com/docs/session) y [caché](https://laravel.com/docs/cache).
- [ORM de base de datos](https://laravel.com/docs/eloquent) expresivo e intuitivo.
- [Migraciones de esquema](https://laravel.com/docs/migrations) independientes de la base de datos.
- [Procesamiento robusto de trabajos en segundo plano](https://laravel.com/docs/queues).
- [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, poderoso y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Estructura del Proyecto

### Carpetas Principales

- **app/**: Contiene la lógica principal de la aplicación, incluyendo modelos, controladores, middleware y servicios.
- **bootstrap/**: Contiene archivos de inicialización de la aplicación, como el archivo `app.php` que carga el framework.
- **config/**: Contiene todos los archivos de configuración de la aplicación (base de datos, caché, sesiones, etc.).
- **database/**: Contiene las migraciones, seeders y factories de la base de datos.
- **public/**: Es la carpeta pública accesible desde el web. Contiene el archivo `index.php` que es el punto de entrada.
- **resources/**: Contiene los archivos de vistas (Blade templates), assets CSS/JS sin compilar, y archivos de idioma.
- **routes/**: Contiene todos los archivos de definición de rutas (web.php, api.php, console.php, channels.php).
- **storage/**: Contiene archivos generados por la aplicación como caché, logs, sesiones y archivos subidos.
- **tests/**: Contiene los archivos de pruebas unitarias y de características.
- **vendor/**: Contiene las dependencias de Composer instaladas.

## Aprendiendo Laravel

Laravel tiene la [documentación](https://laravel.com/docs) y la biblioteca de tutoriales en video más extensas y exhaustivas de todos los frameworks de aplicaciones web modernos, lo que hace que sea muy fácil comenzar con el framework.

Además, [Laracasts](https://laracasts.com) contiene miles de tutoriales en video sobre una variedad de temas que incluyen Laravel, PHP moderno, pruebas unitarias y JavaScript. Mejora tus habilidades explorando nuestra biblioteca de videos completa.

También puedes ver lecciones breves con proyectos del mundo real en [Laravel Learn](https://laravel.com/learn), donde te guiarán a través de la construcción de una aplicación Laravel desde cero mientras aprendes los fundamentos de PHP.

## Desarrollo con IA

La estructura predecible y las convenciones de Laravel lo hacen ideal para agentes de codificación de IA como Claude Code, Cursor y GitHub Copilot. Instala [Laravel Boost](https://laravel.com/docs/ai) para potenciar tu flujo de trabajo con IA:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost proporciona a tu agente más de 15 herramientas y habilidades que ayudan a los agentes a construir aplicaciones Laravel mientras siguen las mejores prácticas.

## Contribuyendo

¡Gracias por considerar contribuir al framework Laravel! La guía de contribución se puede encontrar en la [documentación de Laravel](https://laravel.com/docs/contributions).

## Código de Conducta

Para asegurar que la comunidad de Laravel sea acogedora para todos, por favor revisa y cumple con el [Código de Conducta](https://laravel.com/docs/contributions#code-of-conduct).

## Vulnerabilidades de Seguridad

Si descubres una vulnerabilidad de seguridad dentro de Laravel, por favor envía un correo electrónico a Taylor Otwell vía [taylor@laravel.com](mailto:taylor@laravel.com). Todas las vulnerabilidades de seguridad serán abordadas rápidamente.

## Licencia

El framework Laravel es software de código abierto licenciado bajo la [licencia MIT](https://opensource.org/licenses/MIT).
