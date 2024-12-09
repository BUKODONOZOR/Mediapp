<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


![image](https://github.com/user-attachments/assets/814ebe2f-acbd-4c3c-b3f0-341f2a84764a)


Gestión de Citas Médicas (Laravel)
Descripción del Proyecto
Este módulo es parte de una solución integral para resolver problemas críticos en la gestión de citas médicas en una clínica. Utilizando Laravel como framework principal, hemos implementado una arquitectura MVC híbrida que centraliza y optimiza la lógica de negocio, facilitando la interacción entre pacientes, doctores y la administración de citas.

El sistema resuelve problemas comunes en las clínicas, como citas duplicadas, falta de control sobre la disponibilidad de médicos, y la ausencia de seguimiento del historial de citas. Además, automatiza la notificación por correo electrónico, lo que mejora significativamente la comunicación y reduce los errores humanos.

Funcionalidades Principales
1. Gestión de Citas
Creación de Citas: Los pacientes pueden crear citas de manera eficiente a través de formularios personalizados.
Estado de la Cita: Los médicos tienen control total sobre el estado de las citas, pudiendo marcarlas como confirmadas, canceladas o completadas.
2. Gestión de Usuarios
Doctores:
Registro de nuevos doctores con un formulario dedicado.
Acceso a una vista independiente para gestionar citas y revisar horarios.
Pacientes:
Registro de pacientes con un formulario específico.
Acceso a una vista independiente donde pueden agendar y visualizar sus citas.
3. Notificaciones por Correo Electrónico
Los pacientes y doctores reciben notificaciones automáticas por correo electrónico cada vez que se crea, modifica o cancela una cita, mejorando la comunicación y reduciendo la incertidumbre.
4. Base de Datos
Estructura Principal:
Tabla doctors: Almacena los datos de los médicos.
Tabla patients: Registra la información de los pacientes.
Tabla appointments: Contiene los datos de las citas, relacionando a doctores y pacientes.
Rutas Principales
Registro de Usuarios
Registro de Doctores
get('register/doctor'),
Registro de Pacientes , 
get ('register/patient')

Login 
get(Login) 


Desafíos Técnicos y Soluciones
1. Integración de Passport
Problema: Durante la implementación, surgieron dificultades al instalar y configurar Laravel Passport, necesario para la autenticación de la API.
Solución: Se siguieron las guías oficiales para configurar Passport correctamente, asegurando que los tokens de acceso se gestionen de manera segura y eficiente.
2. Configuración de Routes/Api.php
Problema: La configuración inicial de las rutas en api.php presentó errores al compilar.
Solución: Se reorganizaron las rutas y controladores para que las funciones críticas del sistema se gestionaran en rutas web, dejando api.php para futuras integraciones.
Objetivos Específicos
Evitar la Duplicación de Citas:
Implementar validaciones estrictas en el backend para garantizar que un médico no sea asignado a dos citas en el mismo horario.
Aumentar la Eficiencia del Agendamiento:
Crear vistas y formularios claros que agilicen el registro de citas y reduzcan el margen de error.
Mejorar el Seguimiento del Historial Médico:
Diseñar vistas en las que los médicos puedan consultar fácilmente el historial de citas de cada paciente.
Optimizar la Comunicación:
Automatizar el envío de notificaciones por correo electrónico para mantener informados tanto a pacientes como a doctores.
Futuras Mejoras
Implementar un sistema visual de calendario para que los médicos puedan gestionar su disponibilidad de forma gráfica.
Desarrollar una API RESTful que permita la integración con aplicaciones móviles y otros sistemas.
Automatizar la reprogramación de citas en caso de imprevistos médicos.
get(login)
