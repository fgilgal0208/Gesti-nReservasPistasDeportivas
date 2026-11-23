# Cerro Muriano Pádel – Gestión de Reservas de Pistas 🎾

Aplicación web full-stack desarrollada en Laravel y Livewire para reservar las pistas deportivas municipales de Cerro Muriano. Los vecinos reservan y gestionan sus pistas online, y el Ayuntamiento cuenta con un panel exclusivo para controlar todas las reservas y exportarlas.

> ℹ️ **Nota:** proyecto realizado con fines de aprendizaje durante mis estudios de Desarrollo de Aplicaciones Web (DAW). Puede contener errores o aspectos mejorables; cualquier sugerencia es bienvenida.

## 🚀 Características principales

### Zona de usuario
- **Cuentas de usuario:** registro, inicio de sesión, verificación de email y perfil, con Laravel Breeze y Livewire Volt.
- **Calendario de reservas en tiempo real:** componente Livewire con vista semanal por pista y navegación entre semanas, sin recargar la página.
- **Franjas horarias inteligentes:** reservas de 90 minutos entre las 9:00 y las 22:00, en franjas de 30 minutos. Solo se muestran los huecos libres y se descartan las horas ya pasadas.
- **Control de solapamientos:** el sistema impide reservar una pista en un horario ya ocupado.
- **Código de pago único:** cada reserva genera un código (por ejemplo, `MUR-3F9A1C`) y queda registrada como pendiente de pago.
- **Envío del justificante de pago:** el usuario sube una foto del justificante (máx. 10 MB) y se envía por correo al Ayuntamiento como archivo adjunto.
- **Mis próximas reservas:** consulta de las reservas futuras y opción de anularlas.

### Panel del Ayuntamiento
- **Acceso restringido:** middleware propio (`AdminMiddleware`) que solo permite la entrada a usuarios administradores.
- **Listado de reservas** con todos los datos de cada una.
- **Exportación a PDF y Excel** del listado de reservas, con DomPDF y Laravel Excel.

## 🛠️ Stack tecnológico

- **Backend:** PHP 8.2, Laravel 12
- **Frontend:** Livewire 3, Livewire Volt, Blade, Tailwind CSS, Vite
- **Autenticación:** Laravel Breeze
- **Base de datos:** MySQL (usuarios, pistas y reservas)
- **Exportación:** barryvdh/laravel-dompdf (PDF), maatwebsite/excel (Excel)
- **Correo:** Laravel Mail con archivos adjuntos
- **Control de versiones:** Git, GitHub

## ⚙️ Instalación en local

Necesitas tener instalados PHP 8.2+, Composer y Node.js.

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/fgilgal0208/Gesti-nReservasPistasDeportivas.git
   cd Gesti-nReservasPistasDeportivas
   ```
2. Instalar las dependencias de PHP:
   ```bash
   composer install
   ```
3. Instalar y compilar las dependencias de frontend:
   ```bash
   npm install
   npm run build
   ```
4. Configurar las variables de entorno y generar la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. En el archivo `.env`, definir la conexión a la base de datos y los datos del servidor de correo (`MAIL_*`) para el envío de justificantes. Después, crear las tablas con las pistas y los usuarios de prueba:
   ```bash
   php artisan migrate --seed
   ```
6. Levantar el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

La aplicación estará disponible en http://localhost:8000. Para acceder al panel del Ayuntamiento, el usuario debe tener el campo `is_admin` activado en la base de datos.

## 📄 Licencia y copyright

© 2026 Francisco Gilarte Galán. Todos los derechos reservados.

Este repositorio y su contenido se proporcionan exclusivamente con fines de exhibición y evaluación profesional (portafolio). No se otorga permiso para utilizar, copiar, modificar o distribuir este código con fines comerciales o derivados sin autorización expresa del autor.
