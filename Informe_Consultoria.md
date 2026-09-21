# Informe Técnico de Consultoría Backend

## 1. Cliente y servidor

En una aplicación web existen dos entornos principales de ejecución: cliente y servidor.

**Cliente:** Es normalmente el navegador del usuario. En él se interpretan HTML y CSS para construir y representar la interfaz, mientras que JavaScript ejecuta lógica localmente para permitir la interacción con el usuario.

**Servidor:** Es el sistema que recibe las peticiones HTTP/HTTPS del cliente y ejecuta la lógica de negocio que no debe quedar bajo su control. Por ejemplo, puede consultar una base de datos, comprobar credenciales, calcular el precio definitivo de un pedido o generar una respuesta en HTML o JSON.

Esta separación conduce a una regla fundamental de seguridad web: **nunca se debe confiar en los datos procedentes del cliente**.

El cliente está bajo el control del usuario, no de la empresa. El código y los datos presentes en el navegador pueden inspeccionarse o modificarse y, además, un usuario puede fabricar peticiones HTTP directamente sin utilizar la interfaz de la aplicación. Por tanto, una validación realizada únicamente con JavaScript puede mejorar la experiencia de usuario, pero nunca constituye por sí sola una medida de seguridad.

Por ello, el servidor debe validar los datos de entrada antes de utilizarlos y escapar correctamente los datos de salida antes de insertarlos en una página web, reduciendo así riesgos como los ataques XSS.

Por ejemplo, una tienda online nunca debería aceptar como válido el precio enviado desde el navegador. El servidor debe obtener o recalcular ese precio utilizando información fiable almacenada en su propia base de datos.

---

## 2. Web estática y web dinámica

La diferencia principal entre ambos tipos de web no está necesariamente en su apariencia, sino en **cómo se obtiene el contenido que recibe el navegador**.

Una **web estática** entrega archivos cuyo contenido está previamente creado. Para modificar dicho contenido es necesario cambiar los archivos correspondientes.

Una **web dinámica**, en cambio, puede generar total o parcialmente la respuesta en función de la petición realizada, el usuario o la información almacenada en el servidor.

Para una plataforma de comercio electrónico, la generación dinámica resulta especialmente adecuada, ya que permite:

- Mostrar productos y precios almacenados en una base de datos.
- Consultar el stock disponible.
- Gestionar usuarios y sesiones.
- Mantener un carrito de compra.
- Registrar y consultar pedidos.
- Personalizar contenido según el usuario.

Esto no significa que toda la aplicación deba generarse dinámicamente. Las arquitecturas modernas suelen combinar ambos modelos: el servidor puede entregar recursos estáticos como HTML, CSS, JavaScript e imágenes, mientras que el frontend consulta información dinámica al backend mediante una **API**, intercambiando habitualmente datos en formato **JSON**.

Esta separación permite, además, reutilizar el mismo backend desde distintos clientes, por ejemplo una futura aplicación móvil, sin tener que duplicar toda la lógica de negocio.

De esta forma se obtiene una arquitectura híbrida que combina eficiencia en la entrega de recursos con la capacidad de gestionar información actualizada y personalizada.

---

## 3. Infraestructura: servidores web y ejecución de PHP

Un servidor web, como Apache o Nginx, recibe las peticiones HTTP/HTTPS realizadas por los clientes. Puede responder directamente con recursos estáticos (como imágenes, CSS o JavaScript) o delegar el procesamiento de una petición cuando esta requiere ejecutar código del servidor.

Además de entregar recursos, un servidor web puede realizar tareas como gestionar conexiones HTTPS, redirecciones, cabeceras de caché o actuar como proxy inverso.

En PHP existen diferentes mecanismos para realizar la ejecución del código.

En el modelo tradicional **CGI (Common Gateway Interface)**, una petición podía provocar la creación de un nuevo proceso del intérprete PHP. Crear, inicializar y destruir un proceso para cada petición introduce una sobrecarga importante cuando aumenta el número de usuarios concurrentes.

**PHP-FPM (FastCGI Process Manager)** utiliza el protocolo FastCGI y mantiene uno o varios *pools* de procesos PHP persistentes. Sus procesos trabajadores pueden atender sucesivas peticiones sin tener que iniciar un nuevo intérprete desde cero cada vez.

Además, PHP-FPM permite controlar el número de trabajadores y utilizar diferentes modos de gestión de procesos (estático, dinámico o bajo demanda).

Los *pools* también pueden configurarse de forma independiente, con distintos límites de procesos, usuarios o permisos. Esto permite aislar aplicaciones y dimensionar la capacidad de ejecución de PHP de forma independiente al servidor web.

Este modelo reduce la sobrecarga asociada a la creación continua de procesos y permite gestionar de forma más eficiente los recursos y la concurrencia.

Es importante diferenciar las distintas capas de la arquitectura:

- **Apache/Nginx:** recibe y dirige las peticiones web.
- **PHP-FPM:** gestiona los procesos que ejecutan el código PHP.
- **Laravel:** organiza y proporciona herramientas para desarrollar la lógica de la aplicación.

La arquitectura puede representarse de forma simplificada así:

```
Navegador
    ↓
Apache / Nginx
    ↓
PHP-FPM
    ↓
Laravel
    ↓
Base de datos
```
Laravel, por tanto, no sustituye al servidor web ni a PHP-FPM. Como framework de aplicación, gestiona elementos como rutas, controladores, acceso a datos, validación, autenticación, autorización y generación de respuestas, cubriendo muchas de las funciones propias de la capa de aplicación.

---

## 4. Evaluación de PHP y Laravel 12

Para este proyecto se propone utilizar **PHP con Laravel 12**.

Existen diferentes alternativas válidas para desarrollar un backend:

* **JavaScript con Node.js** permite utilizar el mismo lenguaje en frontend y backend y resulta especialmente útil en aplicaciones con abundante comunicación asíncrona.
* **Java con Spring** ofrece un ecosistema muy robusto y es habitual en sistemas empresariales de gran tamaño, aunque suele introducir mayor complejidad inicial.
* **Python con Django** permite un desarrollo rápido y dispone de numerosas herramientas integradas.
* **PHP** está especialmente orientado al desarrollo web, posee un ecosistema maduro, amplia documentación y una excelente compatibilidad con servidores, servicios de alojamiento y bases de datos.

Para una tienda online como la planteada, PHP proporciona una solución madura y apropiada, mientras que **Laravel 12** aporta una arquitectura organizada y herramientas que evitan implementar desde cero muchas funciones habituales de una aplicación web.

### Arquitectura MVC

Laravel favorece una arquitectura basada en el patrón **MVC (Modelo-Vista-Controlador)**:

* **Modelo:** representa y gestiona los datos y las reglas asociadas a ellos.
* **Vista:** presenta la información al usuario.
* **Controlador:** recibe las peticiones y coordina la lógica necesaria para producir una respuesta.

Esta separación de responsabilidades facilita el mantenimiento, las pruebas y la evolución del proyecto.

### Seguridad y validación

Laravel incorpora mecanismos para resolver de forma consistente tareas sensibles.

Las plantillas **Blade** permiten tratar de forma segura las salidas mostradas en las vistas, el framework incluye mecanismos de protección **CSRF** para formularios y herramientas como **Eloquent** facilitan un acceso seguro y estructurado a la base de datos.

También proporciona funcionalidades para autenticación, autorización y validación de datos.

Estas herramientas reducen la necesidad de implementar manualmente soluciones de seguridad que podrían contener errores. No obstante, las protecciones del framework no sustituyen a las buenas prácticas: los datos recibidos del cliente deben seguir siendo validados en el servidor.

### Estructura y mantenibilidad

Laravel 12 proporciona una estructura de proyecto organizada y predecible, separando elementos como modelos, controladores, rutas, vistas y configuración.

Su estructura simplificada evita incluir componentes innecesarios por defecto, pero permite ampliar la aplicación conforme aumenten sus necesidades.

### Ecosistema

Laravel dispone de herramientas que aumentan la productividad del desarrollo backend, entre ellas:

* **Eloquent ORM**, para trabajar con los datos mediante objetos PHP.
* **Migrations**, para versionar la estructura de la base de datos.
* **Artisan**, para automatizar tareas desde la línea de comandos.
* **Middleware**, para intervenir en las peticiones antes de que lleguen a la lógica principal.
* Herramientas para testing, sesiones, autenticación, colas de trabajos y desarrollo de APIs.

### Valoración

Laravel también introduce una capa adicional de abstracción y una curva de aprendizaje que sería innecesaria para una web extremadamente sencilla.

Sin embargo, en una plataforma de comercio electrónico con usuarios, catálogo, pedidos, permisos y acceso a datos, esa estructura adicional se justifica por la reducción de código repetitivo y la mejora de la mantenibilidad.

Por estas razones, la combinación **PHP + Laravel 12** ofrece un equilibrio adecuado entre velocidad de desarrollo, seguridad, organización y capacidad de crecimiento para una plataforma de comercio electrónico.