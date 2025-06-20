# Sistema de Gestión de Reservas para Autocaravanas

Desarrollado con Laravel 10, API REST y arquitectura escalable


<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>


## 📌 Visión General

Sistema profesional de reservas desarrollado como proyecto académico, implementando:

- Backend: API REST con Laravel 10 + MySQL

- Frontend: Panel administrativo (Livewire) + Clientela (Blade)

- Mobile: App Android nativa (Kotlin)

- Infraestructura: VPS optimizado (Ubuntu 24.04 LTS + LAMP)


## ✨ Características Clave


### 🔐 Gestión de Usuarios
- Autenticación JWT (Sanctum)

- Roles: Cliente/Administrador

- Límite de 5 reservas simultáneas por cliente


### 🚐 Motor de Reservas

- Validación inteligente de disponibilidad

- Reglas de negocio:

    - Mínimo 2 días (7 en temporada alta)

    - Límite de 60 días de antelación

    - Historial automatizado (Cron Jobs)


### 📊 Dashboard Administrativo

- CRUD completo de autocaravanas

- Visualización de reservas activas/históricas.

- Exportación de datos.


### 🛠️ Tecnologías Implementadas

- ***Backend***:	Laravel 10, Eloquent ORM, Sanctum, PHP 8.2.

- ***Frontend***:	Blade, Livewire, Alpine.js, Tailwind CSS.

- ***Mobile***:	Kotlin, Retrofit (consumo API).
  
- ***DevOps***:	VPS (4GB RAM), Ubuntu 24.04, Apache2, Certbot (SSL).


### 💳 Mejoras propuestas

- Pasarela de pagos (Stripe/PayPal) con cobro del 20%

- Notificaciones por email (SMTP propio)


### 📂 Estructura del Proyecto

app/

├── Http/
│   ├── Controllers/  # Lógica de negocio
│   ├── Middleware/   # Validación de roles/reservas
│   └── Services/     # Lógica de pagos/emails
database/
├── migrations/       # Esquema completo
├── seeders/          # Datos de prueba
└── factories/        # Modelos para testing


### 🔧 Configuración Técnica


#### 1. Requisitos del Servidor

# Ejemplo de instalación (Ubuntu)
sudo apt install php8.2 php8.2-mysql mysql-server apache2

#### 2. Variables Críticas (.env)
ini
APP_ENV=production
DB_HOST=127.0.0.1
DB_DATABASE=reservas_prod

## ¡Nota: Las credenciales reales están protegidas!

#### 3. Diagrama de Base de Datos
![Modelo Relacional](https://github.com/user-attachments/assets/0b480fa3-374b-4ce6-be41-d146bd9a0f7d)
