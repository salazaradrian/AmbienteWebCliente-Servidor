<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'usuario') {
    header('Location: Login.html');
    exit;
}

$nombreUsuario = htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Abuelo - Circulo de Apoyo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/brite/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --azul-panel: #0d6efd;
            --fondo: #f4f7fb;
            --texto: #1f2937;
            --borde: #000;
            --amarillo: #ffd95a;
            --verde: #57cc99;
            --celeste: #66c7f4;
            --rojo: #ef476f;
        }

        body {
            background: radial-gradient(circle at top left, #e6f2ff, #f7fbff 40%, #eef8f2);
            font-family: Arial, Helvetica, sans-serif;
            color: var(--texto);
            min-height: 100vh;
        }

        .navbar-abuelo {
            background: var(--azul-panel);
            border-bottom: 3px solid var(--borde);
            box-shadow: 0 6px 0 var(--borde);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .navbar-title {
            color: #fff;
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        .btn-cartoon {
            border: 2px solid var(--borde);
            box-shadow: 5px 5px 0 var(--borde);
            font-weight: 700;
            border-radius: 12px;
            transition: transform .08s ease, box-shadow .08s ease;
        }

        .btn-cartoon:active {
            transform: translate(5px, 5px);
            box-shadow: 0 0 0 var(--borde);
        }

        .welcome-box {
            background: #fff;
            border: 3px solid var(--borde);
            border-radius: 14px;
            box-shadow: 7px 7px 0 var(--borde);
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 900;
            margin: 0;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            margin-top: .5rem;
            margin-bottom: 0;
        }

        .help-btn {
            width: 100%;
            height: 205px;
            border: 3px solid var(--borde);
            border-radius: 24px;
            box-shadow: 8px 8px 0 var(--borde);
            font-size: 2rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .help-btn:hover {
            transform: translate(-4px, -4px);
            box-shadow: 12px 12px 0 var(--borde);
        }

        .help-btn:active {
            transform: translate(6px, 6px);
            box-shadow: 0 0 0 var(--borde);
        }

        .help-btn .emoji {
            font-size: 3.6rem;
            line-height: 1;
        }

        .btn-compras {
            background: var(--amarillo);
            color: #202020;
        }

        .btn-farmacia {
            background: var(--verde);
            color: #0b2e13;
        }

        .btn-compania {
            background: var(--celeste);
            color: #0f2940;
        }

        .btn-emergencia {
            background: var(--rojo);
            color: #fff;
        }

        .estado-card {
            margin-top: 2rem;
            background: #fff;
            border: 3px solid var(--borde);
            border-radius: 14px;
            box-shadow: 7px 7px 0 var(--borde);
            padding: 1.25rem;
        }

        .estado-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
        }

        .estado-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2f9e44;
        }

        .quick-actions {
            margin-top: 1.2rem;
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .quick-actions .btn {
            font-size: 1rem;
            font-weight: 700;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            margin-bottom: 1.2rem;
            color: #4b5563;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .navbar-title {
                font-size: 1.5rem;
            }

            .welcome-title {
                font-size: 1.6rem;
            }

            .welcome-subtitle {
                font-size: 1.05rem;
            }

            .help-btn {
                height: 160px;
                font-size: 1.5rem;
            }

            .help-btn .emoji {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar-abuelo">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="navbar-title">Hola, <?php echo $nombreUsuario; ?></h1>
            <button class="btn btn-light btn-cartoon" onclick="location.href='logout.php'">Cerrar sesión</button>
        </div>
    </nav>

    <main class="container">
        <section class="welcome-box">
            <h2 class="welcome-title">¿En qué podemos ayudarle hoy?</h2>
            <p class="welcome-subtitle">Presione para enviar su solicitud en segundos.</p>
        </section>

        <section class="row g-4 text-center" aria-label="Acciones rapidas de ayuda">
            <div class="col-6">
                <button class="help-btn btn-compras" onclick="enviarSolicitud('Mandados')" aria-label="Solicitar mandados">
                    <span class="emoji">🛒</span>
                    <span>Mandados</span>
                </button>
            </div>
            <div class="col-6">
                <button class="help-btn btn-farmacia" onclick="enviarSolicitud('Farmacia')" aria-label="Solicitar farmacia">
                    <span class="emoji">💊</span>
                    <span>Farmacia</span>
                </button>
            </div>
            <div class="col-6">
                <button class="help-btn btn-compania" onclick="enviarSolicitud('Platicar')" aria-label="Solicitar compania para platicar">
                    <span class="emoji">💬</span>
                    <span>Platicar</span>
                </button>
            </div>
            <div class="col-6">
                <button class="help-btn btn-emergencia" onclick="enviarSolicitud('Emergencia')" aria-label="Solicitar emergencia">
                    <span class="emoji">🚨</span>
                    <span>EMERGENCIA</span>
                </button>
            </div>
        </section>

        <section class="estado-card" aria-live="polite">
            <h3 class="estado-title">Estado de su ultima solicitud:</h3>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="spinner-grow text-success" role="status" aria-hidden="true"></div>
                <p id="estadoTexto" class="estado-text mb-0">El voluntario Carlos esta en camino</p>
            </div>

            <div class="quick-actions">
                <button class="btn btn-primary btn-cartoon" onclick="location.href='RegistroAyuda.html'">Registro de Ayuda</button>
                <button class="btn btn-warning btn-cartoon" onclick="actualizarEstado()">Actualizar estado</button>
            </div>
        </section>
    </main>

    <footer>
        Circulo de Apoyo Costa Rica - 2026
    </footer>

    <script>
        function enviarSolicitud(tipo) {
            var tipoBD = '';
            switch (tipo) {
                case 'Mandados':
                    tipoBD = 'mandados';
                    break;
                case 'Farmacia':
                    tipoBD = 'farmacia';
                    break;
                case 'Platicar':
                    tipoBD = 'compania';
                    break;
                case 'Emergencia':
                    tipoBD = 'medico';
                    break;
                default:
                    tipoBD = 'compania';
            }

            var estado = document.getElementById('estadoTexto');
            estado.textContent = 'Enviando solicitud de ' + tipo + '...';

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'crear_solicitud.php';
            form.style.display = 'none';

            var inputTipo = document.createElement('input');
            inputTipo.type = 'hidden';
            inputTipo.name = 'tipo_servicio';
            inputTipo.value = tipoBD;
            form.appendChild(inputTipo);

            var inputDesc = document.createElement('input');
            inputDesc.type = 'hidden';
            inputDesc.name = 'descripcion';
            inputDesc.value = 'Solicitud automatica desde dashboard: ' + tipo;
            form.appendChild(inputDesc);

            var inputUrgencia = document.createElement('input');
            inputUrgencia.type = 'hidden';
            inputUrgencia.name = 'urgencia';
            inputUrgencia.value = 'normal';
            form.appendChild(inputUrgencia);

            var now = new Date();
            var horaActual = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0');
            var inputHora = document.createElement('input');
            inputHora.type = 'hidden';
            inputHora.name = 'hora_solicitud';
            inputHora.value = horaActual;
            form.appendChild(inputHora);

            document.body.appendChild(form);
            form.submit();
        }

        function actualizarEstado() {
            var mensajes = [
                'Voluntario asignado. Llegara en 20 minutos.',
                'Su solicitud esta siendo validada por el equipo.',
                'Un voluntario cercano acepto su solicitud.'
            ];

            var indice = Math.floor(Math.random() * mensajes.length);
            document.getElementById('estadoTexto').textContent = mensajes[indice];
        }

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.get('success') === '1') {
                const mensaje = 'Solicitud registrada con exito. Hemos recibido tu peticion de ayuda. Un equipo se comunicara contigo pronto.';
                alert('✅ ' + mensaje);
                document.getElementById('estadoTexto').textContent = mensaje;
            }

            if (urlParams.get('error') === '1') {
                alert('❌ Error al enviar la solicitud. Por favor intenta de nuevo.');
            }
        };
    </script>
</body>

</html>
