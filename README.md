<p alignment="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p alignment="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Introducción

Este proyecto corresponde con la realización de la tarea presencia 6 de la asignatura HLC del ciclo DAM. el proyecto comprende la parte de la asignatura PSP respectiva a esta tarea como resultado de la finalización del curso y obtencion de los conocimientos necesarios para lanzar un Sistema completo de base de datos en la red usando un sistema Vps configurado previamente en un dominio propio para el que se desarrollara un servicio de API REST, el cuál sera consumido por una web y una app android. La finalidad del ejercicio consiste en crear un sistema de reservas para una empresa de autocaravanas, el cuál estará disponible para el servicio a los clientes y las diferentes gestiones por parte del administrador del sistema. Las condiciones del ejercicio son :

- Cuando se realiza una reserva, hay que comprobar que la autocaravana esté libre en el periodo comprendido entre las fechas dadas.

- Cada cliente podrá realizar 5 reservas futuras, como máximo.

- Crear un servicio web que permita a cada cliente manejar las reservas de vehículos desde el navegador y a través de una app en Android/Kotlin.

- Se diseñará un API REST situada en un servidor LAMP o LEMP en un alojamiento propio en Internet (en un VPS).

- Se utilizará el framework Laravel, la información se guardará en una base de datos MySQL y se accederá por https.

- Cada cliente podrá realizar estas operaciones desde el navegador:
    - Ver las reservas propias.
    - Añadir una nueva reserva.
    - Modificar o eliminar una reserva (solo podrá hacerlo la persona que la creó o el admin).
    - Consultar los vehículos disponibles para unas determinadas fechas.

- Habrá un usuario administrador que podrá gestionar las caravanas y las reservas existentes.

- Se configurará el pago del 20% la reserva a través de una plataforma de pago (Stripe, PayPal, Square, Revolut, etc) en el momento de hacer la reserva. Explicar el API utilizado y la comisión de los pagos.

- Cada vez que se hace una reserva de un vehículo, se enviará un email de confirmación (usando un servidor de correo propio) al usuario que ha realizado dicha reserva.

- Mejoras: La reserva de la autocaravana debe cumplir una serie de normas:
    - Cada reserva tendrá una duración mínima de 2 días.
    - En julio y agosto la la reserva será de 7 días, como mínimo.
    - Se podrá reservar con 3 meses (60 días) de antelación, como máximo.
    - Se mostrarán únicamente las reservas futuras ordenadas de más recientes a más lejanas. No se mostrarán las reservas pasadas.
    - Crear una tabla historial para guardar las reservas anteriores a la fecha actual, se podrán ver por el administrador. Pasar al acabar el día las reservas al historial y eliminarlas de la tabla de reservas.

	Para abordar correctamente el desarrollo de este sistema se dividirá en los siguientes bloques:

# 1. Requisitos previos

- VPS con Droplet operativo Ubuntu 24.04.
- Servidor LAMP operativo.
- Servidor DNS y Dominio propio.

# 2. Configuracion del VPS y servidor DNS

Como tenemos otros sistemas realizados en ejercicios previos corriendo en la base de datos realizaremos las siguientes configuraciones para asegurar el funcionamiento independiente en ambas gracias a un subdominio, este se llamará reservas.

## 2.1. Configuración de DNS

En el servidor DNS crearemos un nuevo registro A apuntando a la IP de nuestra VPS.

![image](https://github.com/user-attachments/assets/0e1eed11-18be-486a-844c-5bbd8c98b363)


## 2.2. Configuración del VPS

- Para configurar correctamente el subdominio en la vps debemos de crear los directorios necesarios para este y otrorgarles los permisos pertinentes a cada uno de ellos.

![image](https://github.com/user-attachments/assets/1174904d-337b-408d-ad56-ad7cd9e23672)

- Luego debemos crear un nuevo virtual host y editar su contenido.

![image](https://github.com/user-attachments/assets/3ec84090-8d10-43bf-bc8c-bbdf576dac31)

- Cuando lo tengamos debemos habilitar el sitio con apache y reiniciar el servicio apache2:

![image](https://github.com/user-attachments/assets/5993be9f-542c-4e73-93de-a6fe71dbb04c)

- Para probar el funcionamiento de la estructura crearemos un index de prueba:

![image](https://github.com/user-attachments/assets/9b3f434b-5e2f-4d3d-9f5f-6ee1003a6a7d)

- Para que dominio y subdominio convivan sin conflicto usando el puerto 80 debemos Habilita el módulo mod_headers y reiniciar apache.

![image](https://github.com/user-attachments/assets/1c902435-8d7d-4fe7-a6ea-13fb266accbd)

- Si ademas queremos agregar seguridad accediendo mediante protocolo https debemos de agregar el subdominio a Certbot el cual debemos tener previamente instalado.

![image](https://github.com/user-attachments/assets/3b1e1bbb-2612-4d57-895f-2901e1e26d2b)

- Ahora, si accedemos al subdominio mediante https deberiamos ver el index de pruebas que creamos previamente.

![image](https://github.com/user-attachments/assets/04e979eb-b19c-42de-8b94-fc83c8132814)

Vemos el index de prueba y en la barra del navegador vemos que se redirige por protocolo https (aunque salga el mensaje “No es seguro”, puede que necesite propagarse la información.

# 3. Creación de la Base de Datos

## 3.1. Creacion de usuario y BD
	
Crearemos un usuario específico para manejar la base de datos y la conexión con esta, esto añade seguridad y simplifica el desarrollo posterior.

## 3.2. Estructura de la Base de Datos

La estructura lógica de la base de datos seguirá el siguiente esquema : 

![image](https://github.com/user-attachments/assets/0b480fa3-374b-4ce6-be41-d146bd9a0f7d)
con este esquema planificamos las siguientes tablas iniciales para la base de datos y sus correspondientes registros de prueba.

### 3.2.1. Tabla usuarios
Usuarios registrados, incluyendo clientes y administradores.
```sql

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') DEFAULT 'cliente',
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3.2.2. Tabla autocaravanas
Lista de vehículos disponibles para alquilar.
```sql
CREATE TABLE autocaravanas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    plazas INT NOT NULL,
    precio_por_dia DECIMAL(10,2) NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3.2.3. Tabla reservas
Reservas activas realizadas por los clientes.
```sql
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_autocaravana INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    pago_realizado BOOLEAN DEFAULT FALSE,
    porcentaje_pagado DECIMAL(5,2) DEFAULT 0.00,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_autocaravana) REFERENCES autocaravanas(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
```

###3.2.4. Tabla historial_reservas
Reservas finalizadas, movidas desde la tabla reservas.

```sql
CREATE TABLE historial_reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_autocaravana INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    pago_realizado BOOLEAN,
    porcentaje_pagado DECIMAL(5,2),
    movido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
### 3.2.5. Tabla pagos
 opcional, si decides registrar detalles de cada pago
 ```
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT NOT NULL,
    metodo_pago ENUM('Stripe', 'PayPal', 'Square', 'Revolut'),
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cantidad_pagada DECIMAL(10,2),
    FOREIGN KEY (id_reserva) REFERENCES reservas(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
```

## 3.3 Inserción de registros de prueba

### 3.3.1. Usuarios
```sql
INSERT INTO users (nombre, email, password, rol)
VALUES 
('Juan Pérez', 'juan@example.com', SHA2('123456', 256), 'cliente'),
('Ana López', 'ana@example.com', SHA2('654321', 256), 'cliente'),
('Admin', 'admin@autocaravanas.com', SHA2('admin123', 256), 'admin');
```
### 3.3.2. Autocaravanas
```sql
INSERT INTO autocaravanas (modelo, descripcion, plazas, precio_por_dia)
VALUES
('Camper Van Deluxe', 'Perfecta para escapadas cortas', 2, 80.00),
('Autocaravana Familiar', 'Espaciosa, ideal para familias', 6, 150.00),
('Autocaravana Premium', 'Lujosa con cocina completa', 4, 200.00);
```
### 3.3.3. Reservas
```sql
INSERT INTO reservas (id_usuario, id_autocaravana, fecha_inicio, fecha_fin, pago_realizado, porcentaje_pagado)
VALUES
(1, 2, '2025-07-10', '2025-07-17', TRUE, 20.00),
(2, 1, '2025-06-01', '2025-06-03', TRUE, 20.00);
```
# 4. instalación y configuracion de Laravel

## 4.1. Instalación y configuración en VPS

### 4.1.1. Preparar VPS Para Laravel

Antes de instalar Laravel, se necesita tener el VPS actualizado y PHP ≥ 8.1 con las siguientes extensiones:
```bash
sudo apt upgrade -y
sudo apt install php php-cli php-mbstring php-xml php-bcmath php-curl php-mysql unzip curl git php-zip php-tokenizer php-common php-gd php-pgsql php-intl
```

### 4.1.2. Usuario Dedicado
A partir de este punto es recomendable operar con un usuario sin privilegios de superusuarios para evitar problemas de permisos y compromisos de seguridad e integridad del sistema. Por ello crearemos un usuario independiente para manejar la instalación de Composer y Laravel y le daremos los permisos pertinentes para acceder al proyecto y manejar la instalación.

### 4.1.3. Instalación de Composer 
Composer es el gestor de dependencias oficial de PHP debemos de instalarlo con el usuario creado para evitar conflictos de permisos entre el usuario root y los demás usuarios y por seguridad.	

Los comandos necesarios para ello son :
```bash
sudo -u laravel_user -i
mkdir -p /home/laravel_user/.local/bin
cd /home/laravel_user
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/home/laravel_user/.local/bin –filename=composer
php -r "unlink('composer-setup.php');"
echo 'export PATH="$HOME/.local/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
composer --version
```

### 4.1.4. Instalación Laravel

- Crear proyecto: Ubícarse en la carpeta pública del subdominio configurado, instalar Laravel como usuario Laravel y organizar el proyecto en la VPS con permisos adecuados:

```bash
cd /var/www/reservas.droblob93.es
sudo -u laravel_user composer create-project laravel/laravel temp-install

sudo -u laravel_user mv temp-install/* public_html/
sudo -u laravel_user mv temp-install/.* public_html/ 2>/dev/null
rm -rf temp-install
sudo chmod -R 775 public_html/storage
sudo chmod -R 775 public_html/bootstrap/cache
```
	
 - Configurar entorno Laravel :Debemos configurar el fichero .env para conectar laravel y la base de datos situandonos en el directorio del subdominio.
	*Notas: los campos DB_ABC.. vienen comentados con # predeterminadamente, debemos eliminar este simbolo para que esas líneas sean leidas.También podriamos aprovechar ahora para modificar los datos del servidor de correo o hacerlo más adelante.

Ahora usaremos Artisan para crear la clave de aplicación (se agrega automaticamente al fichero env anterior )y el correspondiente enlace simbólico con la carpeta storage:
```bash
sudo -u laravel_user php artisan key:generate
sudo -u laravel_user php artisan storage:link
sudo -u laravel_user php artisan optimize
```

### 4.1.5. Instalar JetStream con LiveWire y Sanctum
Debemos situarnos en la carpeta public_html para instalar estos complementos : cd /var/www/reservas.droblob93.es/public_html
```bash
sudo -u laravel_user composer require laravel/jetstream
sudo -u laravel_user php artisan jetstream:install livewire
sudo -u laravel_user php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```
y luego añadir los HasApiTokens al modelo User:
```bash
sudo -u laravel_user nano app/Models/User.php
```

```php
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

Además verificaremos la configuración de Sanctum añadiendo nuestro dominio al archivo PHP:
```bash
sudo -u laravel_user nano config/sanctum.php
```
Por últimoReconfiguraremos el virtualHost, habilitaremos el sitio y reiniciaremos apache :
```bash
sudo a2ensite reservas.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```
Eventualmente todavia no hemos terminado la configuración ; Necesitamos eliminar el index html de prueba , además de habilitar la conexión por https. Para ello crearemos el correspondiente archivo ssl, aplicaremos los cambios y reiniciaremos apache :
```bash
sudo nano /etc/apache2/sites-available/reservas-le-ssl.conf
sudo a2enmod ssl
sudo a2ensite reservas-le-ssl
sudo systemctl restart apache2:
```
Con esta configuración, ahora si veremos la página inicial de Laravel en donde deberia estar nuestro index:
![image](https://github.com/user-attachments/assets/78fb0403-4a47-44ea-96bf-752b1f2febf6)

Limpiaremos cache y realizaremos migraciones :
```bash
sudo -u laravel_user php artisan config:clear
sudo -u laravel_user php artisan cache:clear
sudo -u laravel_user php artisan view:clear
sudo -u laravel_user php artisan route:clear
sudo -u laravel_user php artisan session:table
sudo -u laravel_user php artisan migrate
sudo -u laravel_user npm run build
sudo systemctl restart apache2
sudo -u laravel_user php artisan route:list | grep -E 'register|login'
```
Con las configuraciones hechas obtuvimos un error 500.
![image](https://github.com/user-attachments/assets/39a12c83-3073-4326-bc0b-80b49045cefa)

#### Análisis de Problemas

- El error principal ocurría por **migraciones duplicadas** que intentaban crear las mismas columnas (`two_factor_secret` y `two_factor_recovery_codes`) en la tabla `users`. Esto sucedió porque:
- Cada vez que se ejecutaba `php artisan jetstream:install`, se generaba una nueva migración para las columnas de autenticación en dos pasos, incluso si ya existían.
- Al reinstalar Jetstream sin antes limpiar completamente las migraciones anteriores, se acumulaban archivos conflictivos.

#### Soluciones Implementadas

- Eliminación de migraciones duplicadas:
-  Reinstalación limpia de Jetstream: Generamos una nueva migración única
3. Reconstrucción de la base de datos: Esto creó las tablas desde cero sin conflictos.

4. Recompilación de assets: Aseguró que los recursos frontend (CSS/JS) estuvieran actualizados.

5. Corrección de permisos: Garantiza que Laravel tuviera acceso de escritura donde lo necesitaba.

	Esto se resolvió eliminando el conflicto de raíz reinstalando limpiamente JetStream y recompilandpo el proyecto, y aprendimos que se deben eliminar manualmente las migraciones y que debemos dar los permisos adecuados para evitar el error 500.

### 4.1.6. Instalar Node.js

Node es una herramienta util para Frond-End que ayuda a manejar css, JavaScript y sus dependencias debemos darle permisos al usuario del proyecto Laravel para asegurar su funcionamiento.
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
node -v
npm -v
```
Ademas de instalarlo como root, debemos configurarlo para el usuario Laravel:

1. Creamos y configuramos directorio .npm para usuario

2. Configurar prefijo Global

3. Permiso para directorio del proyecto

4. Verificación final como laravel_user

Con estas configuraciones ahora si accedemos a reservas.droblob93.es, accederemos a la pagina principal de Laravel y tenemos acceso a los Enlaces Login y Register.

 
## 4.2. Instalación y Configuración en iDE VSC 

Antes de comenzar con la instalacion de los plugins necesarios para trabajar con Laravel Remotamente desde VSC debemos tener preparado :
- Visual Studio Code.
- Acceso por SSH al VPS donde está alojado Laravel.
- Conocer el usuario y la IP o dominio del VPS.

### 4.2.1. Instalar extensiones esenciales en VSC

En VSC nos vamos a File → Preferences → Extensions  y accedemos al panel de extensiones Instalaremos las siguientes minimamente:
- Remote – SSH : Conectar con servidores VPS por SSH.
- PHP Intelephense : Autocompletado y análisis inteligente de código PHP.
- Laravel Blade Snippets: Resaltado de sintaxis y snippets para archivos .blade.php.
- Laravel Artisan: Ejecutar comandos Artisan desde VSC.
- Laravel Extra Intellisense: Autocompletado para rutas, modelos y controladores.
- REST Client o Thunder Client: Probar endpoints de API Laravel directamente.


### 4.2.2. Configurar acceso remoto SSH

Para acceder al proyecto via ssh debemos compartir la clave publica con el usuario del VPS y acceder con VSC al proyecto con este usuario. Para ello crearemos el directorio .ssh dentro de la carpeta del usuario laravel y aqui un archivo authorized keys donde copiaremos nuestra clave publica y luego probar a acceder  desde la terminal.

	
Ahora, en VSC Presionamos Ctrl+Shift+P y buscaremos la opción Remote-SSH: Add New SSH Host y agregaremos el usuario@ip del VPS para acceder. 

Luego Abriremos la carpeta del proyecto Laravel remoto desde el menú superior seleccionando la ruta del proyecto /var/www/reservas.droblob93.es/public_html y selecciona esa carpeta haciendo click previamente en  “Open Folder”. Con esto ya veriamos la carpeta del proyecto situada en el VPS desde nuestro IDE VSC.



# 5. Creación de API-REST

Para comenzar a crear el API REST seguiremos una estructura organizada y segura que cumpla con todos los requisitos del proyecto:
	
 ## 5.1. Configuración Inicial
 Creamosun conjunto de archivos iniciales que lñuego se iran modificando en funcion de las necesidades del proyecto:
 1. Controladores:
    Se encargan de gestionar las peticiones HTTP, Reciben datos (ej: formularios, API calls) deciden qué hacer con ellos como consultar BD o procesar info y devuelven respuestas tipo vistas, JSON, redirecciones...
    - Controlador de Autenticación: AuthController.php.
    - Controlador de Autocaravanas: AutocaravanaController.php:
    - Controlador de Reservas: ReservaController.php):
    - Controlador de usuario Admin : AdminController.php necesitaremos otro para el usuario.
2. Factories y seeders : opcionales para generar datos mockeados de prueba. se puede hacer uno por objeto o tabla con relacion como reserva. 
4. Rutas API (routes/api.php)
5. Servicios Adicionales: Gestionarán servicios externos como mensajeria y pagos:
    - Servicio de Pagos (PagoService.php).
    - Servicio de Emails (EmailService.php).
6.  Middleware: Su función es la de filtrar peticiones antes de que lleguen al controlador del admin. Verifican usuarios logueados. Comprueban los roles. Validan Headers/Tokens.
7. Mover reservas al historial : Crearemos un método independiente para mover las reservas pasadas automáticamente al historial:

# 6. Creación de web

## 6.1. MiddleWares.
- ValidateReservation.php: validacion de reservas.
- CheckRole.php: maneja rol de usuario.
- Authenticate.php: gestiona el estado de autenticacion de sesion.
- BootStrap/app.php: Esta es la forma oficial de registrar y configurar middlewares ya que laravel 12 no usa Kernel

## 6.2. Configuración de Rutas.
Dentro de la carpeta /Routes modificaremos el archivo web.php para gestionar los redireccionamientos de los metodos y su interaccion con middlewares.

## 6.3. Controladores Web
- ReservaController.php (Cliente)
- AdminController.php (Admin)
- AutocaravanaController.php (creacion de caravanas para Admin)

## 6.4 Vistas
- panel principal para admin.
- historial de reservas.
- caravanas 
- Formulario Caravanas
- reservas (para cliente y para admin)
- formulario de reservas (para cliente y para admin).

## 6.5. Implementación y puesta en marcha.

Despues de modificar la web aparecion en el navegador error 402 accediendo a la url. activamos debug en la web y comenzamos a corregir fallos.

- Se nos olvido incluir el archivo welcome.blade.php en routes/web. Fue añadido con : 
```php
Route::get('/', function () {
    return view('welcome');
})->name('home');
```
Ahora el error es 500: Fallo en enlances illuminate en laravel 12 cambia la definicion de este complemento a Laravel 12 reorganizó algunos middlewares, moviendo la clase AddQueuedCookiesToResponse de Illuminate\Http\Middleware a Illuminate\Cookie\Middleware. Así que todos los lugares donde use middleware se debe importar desde Illuminate\Cookie\Middleware.

- Falta la clase VerifyCsrfToken.php. se creo la clase y añadieron contenidos minimos.

- Siguiendo un tutorial añadimos una linea equivocada en bootstrap/app . referente a uso de Inertia \App\Http\Middleware\HandleInertiaRequests::class. Solucion : fue eliminada. Ahora aparece welcome correctamente.

- Falla al pulsar botón de login :como movimos autController a la carpeta api, ahora la ruta es incorrecta en web.php modificacion en use: use App\Http\Controllers\API\AuthController; en routes.web no configuramos bien la ruta login, cambiamos a :
  
```php
Route::get('login', function () {
    return view('auth.login');
})->name('login');
```
- Ahora si se accede a Login, pero no a register: Se nos olvido incluir el fichero redirectIfAuthenticated en Middleware. Ya se puede acceder a Register.

- Al hacer Login con cualquier usuario de pruebas no se nos permite por no usar el algoritmo Bcrypt. se deben crear los usuarios con tinker :comando php artisan tinker
```php
use App\Models\User;
User::create([
    'name' => 'Admin',
    'email' => 'admin@tudominio.com',
    'password' => bcrypt('admin123'),
    'role' => 'admin',
]);
```
Además de borrar el usuario anterior. Al acceder efectivamente al login 
```json
{
  "user": {
    "id": 6,
    "nombre": "Admin",
    "email": "admin@caravanas.com",
    "two_factor_confirmed_at": null,
    "current_team_id": null,
    "profile_photo_path": null,
    "created_at": "2025-06-01T18:58:17.000000Z",
    "updated_at": "2025-06-01T18:58:17.000000Z",
    "profile_photo_url": "https://ui-avatars.com/api/?name=&color=7F9CF5&background=EBF4FF"
  },
  "token": "5|YzAcTIj77E1yaL15kSEKnzbum2Fg4KdAQ1Wha2Z8117085d1"
}
```
- Aparece respuesta Json sobre el usuario debido a no actualizar el enlace de controller en routes\web.php para el AuthController de la carpeta web. Ahora accedemos por igual al dashboard con usuarios cliente y admin. 

- Ya tenemos las vistas creadas y ppara diferenciar entre tipos de usuario en web.php cambiamos la linea : Route::get('dashboard', fn () => view('dashboard'))->name('dashboard');
por :
Route::get('dashboard', function () {
    $user = Auth::user();

    if ($user->rol === 'admin') {
        // Puedes devolver una vista admin directamente:
        return redirect()->route('admin.autocaravanas.index');
        // O si quieres una vista específica sin controlador:
        // return view('admin.dashboard');
    }

    if ($user->rol === 'cliente') {
        // Redirige a la ruta principal de cliente
        return redirect()->route('reservas.index');
        // O devolver vista directamente:
        // return view('reservas.index');
    }

    abort(403, 'Acceso no autorizado');
})->name('dashboard');

- Se nos lanza fallo de server, debemos corregir la ruta del use en web.php : use App\Http\Controllers\Web\ReservaController;

- El acceso desde el admin ahora funciona. Falta el de cliente. mejoraremos admin y luego avanzamos con cliente.
- Creamos un index propio para el admin. y modificamos routes/web para poder acceder.
- Actualmente vemos el index del admin al acceder con el debemos arreglar rutas para las funciones del admin. y reserva controller para mostrar todas las reservas para el admin.
- Creamos index propio de reservas para admin y modificamos routes.web.php y reservas controller para acceder. Parece que no funcionaba por haber duplicado controladores api y web sin cambiar el tipo de respuesta.
- Cree unn nuevo controlador para admin en una carpeta aparte y reconfigure los archivos anteriores ahora permite acceder a la gestion de reservas pero no a crear una nueva. El problema esta en reserva controller no importaba el modelo autocaravana y tampoco se trabajaba con el modificaciones en la funcion create para usar caravana en reserva.
- Ahora estamos personalizando el reserva controller del cliente.  ya que nos aparece error pro nombre duplicado de clase en el navegador. al cambiar el nombre del controller reserva del cliente cambio el tipo de error a Call to undefined method App\Http\Controllers\Web\ReservaClienteController::middleware(). El cliente no accedia por fallos en los campos id_usuario era llamado id_cliente en algunas partes del codigo por error. se modifico esto y pudo entrar. en el index.blade.del cliente habia fallos en for else, fueron modificados y ahora se ven sus registros.
- De igual manera se corrigio el front del admin, tampoco se implemento for else, por eso no mostraba reservas. 
- Con casi todo funcional mejore los estilos por defecto y los campos mostrados para cada usuario admin o cliente.

Admin :

no accede a Nueva reserva boorar o editar debido a fallos en los enlaces. se corrigueron las rutas y se añadio campo para agregar el usuario a la reserva.
Yase pueden crear reservas, borrar o editar..
actualmente se accede a todos los paneles aunque con fallos de funcionamiento :

detecte que el boton añadir autocaravana no funciona para el admin. esto era debido a incongruencia entre el nombre de archivo y nombre de rutas ; Faltaba una S!!
Pasamos a configurar correctamente campos de formulario para crear caravanas.
el boton crear caravana,los botones editar y eliminar no tienen funcion asignada.pasamos a añadirla primero a estos. ahora editar te lleva a la pantalla edicion y eliminar pregunta por confirmacion.
en la vista editar no se muestrran los campos actuales del registro. debido a fallo de ruta. corregido.

El area de gestion de caravanas sigue siendo problematica al borrar se borran, pero aparece una excepcion. igual para crear o editar pero no se ejecuta.
habia un limitador de velocidad integrado en bootstrap.app se elimino y apareceun error distinto.
ahora al pulsar en crear desde el formulario de autocaravanas aparece error 419. falta anotación tokencsrf.
despues aparecio otro error de rutas. se corrigio . ahora pareceque no se procede a la creacion aunque no se aprecien fallos.
sigue habiendo errores de rutaws y nombre por eso no se redirigia. solucionado. 
al eliminar una caravana se elimina pero aparece un error de rutas de nuevo. Corregido.
Por ultimo implementamos restricciones sobre el front para realizar las mejoras propuestas al ejercicio limitando la seleccion de fechas e integrando mensajes de error.
Elegi hacerlo sobre front por falta de tiempo y conocimientos de backend php Laravel y debido a mayor conocimiento de desarrollos front html.
-------

Cliente : 
no puede editar sus propias reservas.
teniamos una vista duplicada. reutilizaremos create como es recomendado. borramos edit.
El cliente ya funciona correctamente!
Por ultimo integramops restricciones de feca para cumplir las mejoras propuestas al igual que en el admin sobre el front

Para ambos clientes se consiguieron las mejoras :
minimo de 2 dias de reserva. y de 7 en julio-agosto.
maximo 60 dias de antelacion.
Mover reservas no funciona del todo correctamente, por lo que no se implemento front para ello tambien debido a falta de tiempo por fecha de entrega cercana.

Aspectos a mejorar :

Terminar de implementar pagos y sistema de correo. a medio implementar.
añadir el numero de caravanas de cada tipo y y verificar disponibilidad por ocupacion en fecha.

## 6.6. Gestión del Historial de Reservas

Se implementó un sistema para almacenar y consultar las reservas pasadas de los usuarios, separándolas de las reservas activas.

- **Base de datos:** Se creó una nueva tabla `historial_reservas` con estructura similar a la de `reservas`, incluyendo claves foráneas a usuarios y autocaravanas.

- **Migración de datos:** Se desarrolló un script para mover automáticamente las reservas pasadas (por fecha) al historial. También se actualizaron registros manualmente para corregir datos nulos en los campos `id_usuario` e `id_autocaravana`:
  
  ```sql
  UPDATE historial_reservas SET id_usuario = 3, id_autocaravana = 6 WHERE id = 1;
  UPDATE historial_reservas SET id_usuario = 3, id_autocaravana = 6 WHERE id = 2;
  UPDATE historial_reservas SET id_usuario = 3, id_autocaravana = 6 WHERE id = 3;

