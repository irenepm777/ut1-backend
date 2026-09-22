# Informe Técnico de Consultoría Backend

## 1. Cliente y servidor

En una aplicación web, el **cliente** es normalmente el navegador del usuario, donde se interpretan HTML y CSS y se ejecuta JavaScript. El **servidor** recibe las peticiones HTTP/HTTPS y ejecuta la lógica de negocio, como consultar una base de datos, autenticar usuarios o calcular el precio de un pedido.

La regla fundamental de seguridad es **no confiar nunca en los datos procedentes del cliente**, ya que el usuario puede modificar formularios, JavaScript o incluso enviar peticiones HTTP manipuladas. Por ello, los datos deben validarse en el servidor y escaparse correctamente al mostrarlos en HTML para reducir riesgos como XSS.

Por ejemplo, una tienda online no debe aceptar como válido el precio enviado desde el navegador, el servidor debe obtenerlo o recalcularlo usando los datos almacenados en su base de datos.

---

## 2. Web estática y web dinámica

Una **web estática** entrega archivos cuyo contenido ya está creado, mientras que una **web dinámica** genera total o parcialmente la respuesta según la petición, el usuario o los datos almacenados.

Para una tienda online, la generación dinámica es necesaria para gestionar productos, precios, stock, usuarios, carritos y pedidos.

Ambos modelos pueden combinarse: el servidor puede entregar recursos estáticos y el frontend consultar datos dinámicos al backend mediante una **API**, normalmente en formato **JSON**. Esto permite reutilizar la misma lógica de servidor desde distintos clientes, como una web o una aplicación móvil.

---

## 3. Infraestructura: servidores web y ejecución de PHP

Un **servidor web**, como Apache o Nginx, recibe las peticiones HTTP/HTTPS. Puede servir directamente recursos estáticos o delegar el procesamiento cuando es necesario ejecutar código del servidor.

En PHP, el modelo tradicional **CGI** podía crear un nuevo proceso por cada petición, lo que generaba una sobrecarga importante. **PHP-FPM (FastCGI Process Manager)** mejora este modelo utilizando *pools* de procesos PHP persistentes que pueden reutilizarse para atender varias peticiones.

Esto permite gestionar mejor los recursos y la concurrencia, además de controlar el número de procesos y aislar aplicaciones mediante distintos *pools*.

Las capas principales son:

- **Apache/Nginx:** recibe y dirige las peticiones.
- **PHP-FPM:** gestiona los procesos que ejecutan PHP.
- **Laravel:** organiza la lógica de la aplicación.

Laravel no sustituye al servidor web ni a PHP-FPM. Como framework, gestiona elementos como rutas, controladores, acceso a datos, validación, autenticación y generación de respuestas.

---

## 4. Evaluación de PHP y Laravel 12

Para este proyecto se propone **PHP con Laravel 12**. Existen otras alternativas válidas, como Node.js, Java con Spring o Python con Django, pero PHP destaca por su orientación al desarrollo web, su ecosistema maduro y su amplia compatibilidad con servidores y bases de datos.

Laravel 12 aporta una estructura organizada basada en **MVC (Modelo-Vista-Controlador)**, separando datos, presentación y lógica de control. Esto mejora la mantenibilidad y facilita la evolución del proyecto.

Además, incorpora herramientas de seguridad y desarrollo como **Blade**, protección **CSRF**, validación de datos, autenticación y **Eloquent ORM** para trabajar con la base de datos. También incluye herramientas como migrations, Artisan y middleware.

Aunque Laravel añade cierta complejidad respecto a una aplicación PHP sencilla, en una tienda online con usuarios, catálogo, pedidos y permisos esa estructura se justifica por la reducción de código repetitivo, la seguridad y la facilidad de mantenimiento.