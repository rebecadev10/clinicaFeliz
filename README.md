/clinicaFeliz
│
├── /controlador
│ ├── usuarios.php # Controlador para la gestión de usuarios (login, registro, etc.)
│ ├── personal.php # Controlador para la gestión de personal (listar, editar, etc.)
│ ├── citas.php # Controlador para la gestión de citas
│ └── logout.php # Controlador para cerrar sesión
│
├── /modelo
│ ├── Usuarios.php # Modelo para la gestión de usuarios, incluyendo funciones de acceso a datos
│ ├── Clinica.php # Modelo para la gestión de datos clínicos (especialidades, cargos, departamentos)
│ └── Personal.php # Modelo para la gestión de datos de personal
│
├── /vistas
│ ├── /componentes
│ │ ├── header.php # Componente de encabezado común a todas las vistas
│ │ ├── navbar.php # Componente de barra de navegación
│ │ └── footer.php # Componente de pie de página
│ │
│ ├── principal.php # Página principal del sistema, acceso después de iniciar sesión
│ ├── login.php # Página de inicio de sesión
│ ├── usuario.php # Página para gestionar usuarios (registro, edición)
│ ├── personal.php # Página para listar y gestionar personal
│ ├── pacientes.php # Página para listar y gestionar pacientes
│ ├── citas.php # Página para listar y gestionar citas
│ └── mensaje.php # Página para mostrar mensajes de éxito o error
│
├── /data
│ ├── /datos
│ │ ├── especialidades.json # Archivo JSON con datos de especialidades
│ │ ├── cargos.json # Archivo JSON con datos de cargos
│ │ └── departamentos.json # Archivo JSON con datos de departamentos
│
├── /public
│ ├── /css
└── /base # Carpeta con Archivo CSS para estilos globales
│ │ └── /componentes # Carpeta con archivos CSS para estilos detallados de cada vista
│
└── README.md # Este archivo
