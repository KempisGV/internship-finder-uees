# Internship Finder

El presente manual técnico tiene como finalidad describir los componentes del sistema desarrollado para la gestión de ofertas y postulaciones de prácticas pre profesionales y proyectos de vinculación con la sociedad. En este documento también se explica la estructura y lógica del sistema.

#### Requisitos del Sistema
El sistema utiliza PHP como lenguaje del lado del servidor, MySQL como sistema de base de datos y Apache como servidor web. A continuación se detallan las versiones mínimas para garantizar el correcto funcionamiento del sistema.
* PHP 5.5.0 en adelante (versiones anteriores no usan “password_hash” o “password_verify”).
* MYSQL 5.5 en adelante (versiones anteriores tienen problemas con pdo). - Extensiones de PHP: pdo, gd, openssl.
* La extensión “mod_rewrite” debe estar activada en Apache.
En el caso de los servidores compartidos es probable que no se puedan modificar los archivos de configuración de Apache y PHP, por este motivo se debe consultar con el proveedor directamente en caso de no tener habilitadas estas opciones.

#### Instalación y Configuración
Para iniciar la instalación primero se descomprime el archivo “internship_finder.zip”. En este archivo podemos encontrar un directorio llamado “application”, este directorio se lo debe copiar en un nivel más alto del directorio público del servidor. Luego el contenido del directorio “public_html” debe copiarse en el directorio público del servidor, que normalmente es llamado de igual manera. Es posible que en el directorio público se encuentren archivos relevantes para el sistema de administración, por lo que es importante copiar el contenido del directorio “public_html” al directorio público del servidor en lugar de simplemente reemplazarlo.
Una vez copiados todos los archivos necesarios, se crea la base de datos. Como en muchos servidores compartidos no se tiene total control sobre la base de datos, de preferencia la base de datos se la creará manualmente. En el caso de utilizar un servidor compartido la base se la crear mediante un wizzard, al igual que el usuario con el cual se conectará el sistema.
En el caso de tener los permisos suficientes en servidor simplemente se ejecuta la sentencia “CREATE DATABASE <nombre de base>;” en MySQL. Para crear el usuario se ejecuta la sentencia “CREATE USER '<nombre usuario>'@'localhost/internship_finder' IDENTIFIED BY '<contraseña>';”. Para darle todos los permisos al usuario se ejecuta la sentencia “GRANT ALL PRIVILEGES ON * . * TO '<nombre usuario>'@'localhost/internship_finder';”. Finalmente para hacer efectivo estos cambios se refrescan los privilegios mediante la sentencia “FLUSH PRIVILEGES;”.
Luego de crear correctamente la base de datos, se deben agregar los datos de la base de datos que se creó anteriormente en el archivo de configuración. Este archivo se encuentra en “application/config/config.php”. Dentro de este archivo se encuentra un arreglo de PHP con las diferentes opciones configuración. Las únicas opciones que se deben modificar son “DB_NAME”, “DB_USER”, “DB_PASS”; por el nombre de la base de datos, el nombre del usuario y la contraseña respectivamente. En ciertos servidores compartidos puede darse el caso que el host no se pueda acceder mediante localhost/internship_finder, si este fuese el caso se debe consultar el nombre del host de la base de datos con el proveedor y reemplazarlo en el archivo de configuración en “DB_HOST”.

![DB Config](/readme_images/db.png)

Finalmente para concluir la instalación del sistema, se debe ejecutar el script que se encuentra en “application/config/dbmodel.sql”, el cual contiene las tablas necesarias de la base de datos. Una vez realizado todos los pasos mencionados, se podrá navegar a través de la aplicación. Por defecto se crea un usuario administrador cuyo correo es “admin@internshipfinder.com” y contraseña es “123456”. Los datos del usuario administrador pueden cambiarse en cualquier momento, consultar manual de usuario del sistema.

#### Estructura del Sistema
La estructura del sistema consiste en dos directorios principales, “application” y “public_html”. El directorio “application” corresponde al backend del sistema que contiene todas las clases y métodos que el sistema utiliza. Por otro lado el directorio “public_html” corresponde a los archivos de acceso público y estilos y procesamiento del frontend.

![Structure](/readme_images/structure.png)

El directorio “application/config” contiene todos los archivos referentes a la configuración del sistema. El primer archivo y el más importante es “config.php” que contiene un arreglo con todos los valores considerados relevantes para la aplicación, como se muestra a continuación.

![Email Config](/readme_images/email.png)

Otro archivo de configuración relevante es “texts.json”, en donde se almacenan los mensajes que se muestran a los usuarios en el sistema. El objetivo de este archivo es poder modificar todos los mensajes en un solo lugar sin necesidad de recorrer método por método todas las clases del sistema. Por el momento solo existen mensajes de éxito y mensajes de error, sin embargo en caso de requerirlo se puede extender.

![Texts](/readme_images/texts.png)

El siguiente directorio es “application/core”, en donde se almacenan todas las clases que no pertenecen al modelo de negocio del sistema, pero contribuyen a su funcionamiento. Entre las funcionalidades de las clases que se almacenan en este directorio, se tiene filtros XSS, CSRF, Encriptación, entre otras funcionalidades. Estas clases no deberían modificarse, sin embargo se pueden extender para crear nuevas funcionalidades en el sistema.

Otro directorio es “application/controller” en donde se alamacenan los controladores del sistema. Todo controlador extiende la clase “controller” que se encuentra en “application/core/controller.php”. Además todo controlador tiene un método constructor en donde se pueden realizar validaciones para todo el controlador sin necesidad de cargar vistas o datos en el sistema. Por ejemplo el controlador “AccountController”, solo permite usuarios conectados y en caso contrario los redirige a la página inicial. El primer segmento de la URL corresponde al nombre del controlador, el segundo segmento corresponde al método del controlador y los segmentos siguientes corresponden a los parámetros del método. Por ejemplo la URL “<dominio>/public/companyprofile/3”, utiliza el controlador “public” e invoca al método “companyProfile” junto al parámetro “3”.

![Controller](/readme_images/controller.png)

El siguiente directorio es “application/model” en donde se almacenan todos los modelos del sistema. En los modelos se realiza todo el procesamiento de la información del sistema. De forma general los modelos corresponden a entidades de la base de datos, sin embargo existen modelos que representan estados o acciones del sistema en lugar de entidades de la base de datos. Un ejemplo de esto es el modelo “LoginModel”, que se encarga de validar al usuario que quiere iniciar sesión y contabilizar los intentos fallidos. Es importante mencionar que los métodos de los modelos tienen como modificador “static”, de esta forma no hace falta instanciar el modelo para invocar sus métodos.

![Model](/readme_images/model.png)

El último directorio de “application” corresponde a las vistas del sistema, “application/views”, en donde se agrupan según el controlador que las invoca. Las vistas son simplemente archivos HTML con código PHP incrustado para presentar la información relevante. En algunos casos, como es la vista de ofertas, la información se carga mediante AJAX y no en la vista como tal.

El archivo “public_html/index.php” es donde se cargan todos los modelos y clases del directorio “application/core”. Los controladores se cargan de forma dinámica en base a la URL solicitada. En el caso particular del desarrollo de este sistema, los archivos se cargan de forma manual, sin embargo esto se puede hacer de forma autmática mediante una regla de “composer” para cargar todos los archivos del directorio “core” y “model”.

![Autoload](/readme_images/autoload.png)

#### Administración
La administración consiste en el manejo de solicitudes por parte de las empresas y universidades, además de las variables incluidas en los elementos de tipo lista de los formularios a través de toda la aplicación.

En el caso de las solicitudes se manejan a través de la aplicación de forma dinámica, como se muestra en la siguiente figura. El administrador puede revisar todas las solicitudes recibidas, y en caso de ser necesario puede editar la información de la misma o eliminarla por completo. Una vez aprobada la solicitud, se crea un nuevo usuario y se elimina la solicitud.

![Admin Home](/readme_images/admin_home.png)
![Admin Get Requests](/readme_images/admin_requests.png)

En el caso de querer modificar las variables de los elementos de tipo lista, se lo puede hacer desde el archivo de configuración “application/config.php”, como se muestra en la figura.

![Cities Config](/readme_images/cities.png)
