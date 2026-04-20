<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'voluntario') {
    header('Location: Login.html');
    exit;
}

$nombreVoluntario = htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tareas - Voluntario | Círculo de Apoyo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/brite/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --azul-primary: #0d6efd;
            --fondo: #f4f7fb;
            --texto: #1f2937;
            --borde: #000;
            --verde: #10a95b;
            --naranja: #fd8d3e;
            --rojo: #dc3545;
        }

        body {
            background: #eef8f2;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--texto);
        }

        .navbar-vol {
            background: var(--azul-primary);
            border-bottom: 3px solid var(--borde);
            box-shadow: 0 6px 0 var(--borde);
            padding: 1rem 0;
            margin-bottom: 1.5rem;
        }

        .navbar-vol-title {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
        }

        .navbar-vol-info {
            color: #fff;
            font-size: 0.95rem;
            margin: 0;
        }

        /* ========== HEADER CON FILTROS ========== */
        .header-section {
            background: #fff;
            border: 3px solid var(--borde);
            border-radius: 14px;
            box-shadow: 7px 7px 0 var(--borde);
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 900;
            color: var(--azul-primary);
            margin-bottom: 1.2rem;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-label {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .filter-select {
            border: 2px solid var(--borde);
            border-radius: 8px;
            box-shadow: 3px 3px 0 var(--borde);
            padding: 0.6rem 1rem;
            font-weight: 600;
            min-width: 160px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-box {
            background: #f8f9fa;
            border: 2px solid var(--borde);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--azul-primary);
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #5a6373;
        }

        /* ========== TARJETAS DE TAREAS ========== */
        .task-card {
            background: #fff;
            border: 3px solid var(--borde);
            border-radius: 12px;
            box-shadow: 6px 6px 0 var(--borde);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .task-card:hover {
            transform: translate(-3px, -3px);
            box-shadow: 9px 9px 0 var(--borde);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .task-type {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--azul-primary);
        }

        .task-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            border: 2px solid var(--borde);
        }

        .badge-urgente {
            background: #ffcccc;
            color: var(--rojo);
        }

        .badge-asignada {
            background: #fff3cd;
            color: #856404;
        }

        .badge-pendiente {
            background: #d1ecf1;
            color: #0c5460;
        }

        .task-details {
            margin: 1rem 0;
            line-height: 1.8;
        }

        .detail-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.7rem;
            font-size: 1.05rem;
        }

        .detail-label {
            font-weight: 700;
            min-width: 110px;
        }

        .user-info {
            background: #f8f9fa;
            border-left: 4px solid var(--azul-primary);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 6px;
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 800;
            color: #1f2937;
        }

        .user-contact {
            font-size: 0.95rem;
            color: #5a6373;
            margin-top: 0.3rem;
        }

        .task-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }

        .btn-cartoon {
            border: 2px solid var(--borde);
            box-shadow: 4px 4px 0 var(--borde);
            font-weight: 700;
            border-radius: 10px;
            transition: transform .08s ease, box-shadow .08s ease;
        }

        .btn-cartoon:active {
            transform: translate(4px, 4px);
            box-shadow: 0 0 0 var(--borde);
        }

        .btn-accept {
            background: var(--verde);
            color: #fff;
        }

        .btn-decline {
            background: #e9ecef;
            color: #495057;
        }

        .btn-view {
            background: #35d7e5;
            color: #000;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            background: #fff;
            border: 3px dashed var(--borde);
            border-radius: 12px;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #8b92a0;
        }

        .empty-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: #5a6373;
        }

        /* ========== MODAL DE DETALLE ========== */
        .modal-header {
            border-bottom: 3px solid var(--borde);
            background: #f8f9fa;
        }

        .modal-title {
            font-weight: 900;
            font-size: 1.5rem;
        }

        .modal-body {
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .modal-footer {
            border-top: 3px solid var(--borde);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-vol-title {
                font-size: 1.4rem;
            }

            .header-title {
                font-size: 1.6rem;
            }

            .filter-group {
                gap: 10px;
            }

            .filter-select {
                min-width: 140px;
                font-size: 0.95rem;
            }

            .task-card {
                padding: 1rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.3rem;
            }

            .stats-container {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- ========== NAVBAR ========== -->
    <nav class="navbar-vol">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h1 class="navbar-vol-title">Panel del Voluntario</h1>
                <p class="navbar-vol-info">Bienvenido, <?php echo $nombreVoluntario; ?></p>
            </div>
            <button class="btn btn-light btn-cartoon" onclick="location.href='logout.php'">Cerrar sesión</button>
        </div>
    </nav>

    <main class="container">

        <!-- ========== HEADER CON FILTROS Y STATS ========== -->
        <section class="header-section">
            <h2 class="header-title">📋 Tareas Activas en tu Comunidad</h2>

            <div class="filter-group">
                <span class="filter-label">Filtrar por:</span>
                <select class="filter-select" id="filterType" onchange="filtrarTareas()">
                    <option value="">Todos los tipos</option>
                    <option value="mandados">🛒 Mandados</option>
                    <option value="farmacia">💊 Farmacia</option>
                    <option value="compania">💬 Compañía</option>
                    <option value="transporte">🚗 Transporte</option>
                    <option value="medico">⚕️ Médico</option>
                </select>

                <select class="filter-select" id="filterStatus" onchange="filtrarTareas()">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="asignada">Asignada</option>
                    <option value="urgente">Urgente</option>
                </select>

                <button class="btn btn-cartoon btn-view" onclick="location.reload()">🔄 Actualizar</button>
            </div>

            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-number" id="statTotal">8</div>
                    <div class="stat-label">Tareas disponibles</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number" id="statUrgent">2</div>
                    <div class="stat-label">Urgentes</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number" id="statAssigned">5</div>
                    <div class="stat-label">Mis tareas</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number" id="statCompleted">42</div>
                    <div class="stat-label">Completadas</div>
                </div>
            </div>
        </section>

        <!-- ========== TAREAS ========== -->
        <section id="tasksContainer">
            <!-- Las tareas se cargan dinámicamente aquí -->
        </section>

    </main>

    <!-- ========== MODAL DE DETALLE ========== -->
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTaskTitle">Detalle de la Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modalTaskBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-cartoon btn-accept" id="modalAcceptBtn">Aceptar esta tarea</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let tareas = []; // Variable global para almacenar las tareas

        // CARGAR TAREAS DESDE EL SERVIDOR
        async function cargarTareas() {
            try {
                const response = await fetch('obtener_solicitudes.php', {
                    credentials: 'include'
                });

                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseError) {
                    console.error('Respuesta inválida de obtener_solicitudes.php:', text);
                    mostrarError('Error en respuesta del servidor');
                    return;
                }

                if (data.error) {
                    console.error('Error:', data.error);
                    mostrarError('Error al cargar las solicitudes');
                    return;
                }

                tareas = data.solicitudes;

                tareas = data.solicitudes;

                // Actualizar estadísticas
                actualizarEstadisticas(data.estadisticas);

                // Renderizar tareas
                renderizarTareas(tareas);

            } catch (error) {
                console.error('Error al cargar tareas:', error);
                mostrarError('Error de conexión al cargar las solicitudes');
            }
        }

        // ACTUALIZAR ESTADÍSTICAS
        function actualizarEstadisticas(stats) {
            document.getElementById('statTotal').textContent = stats.total;
            document.getElementById('statUrgent').textContent = stats.urgentes;
            document.getElementById('statAssigned').textContent = stats.asignadas;
            document.getElementById('statCompleted').textContent = stats.completadas;
        }

        // RENDERIZAR TAREAS
        function renderizarTareas(tareasFiltradas) {
            const container = document.getElementById('tasksContainer');
            container.innerHTML = '';

            if (tareasFiltradas.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">✉️</div>
                        <div class="empty-text">No hay solicitudes disponibles en este momento.</div>
                    </div>
                `;
                return;
            }

            tareasFiltradas.forEach(tarea => {
                const card = crearTarjeta(tarea);
                container.innerHTML += card;
            });
        }

        // CREAR TARJETA HTML DE TAREA
        function crearTarjeta(tarea) {
            const iconos = {
                mandados: '🛒',
                farmacia: '💊',
                compania: '💬',
                transporte: '🚗',
                medico: '⚕️'
            };

            const estadoBadge = tarea.urgencia === 'urgente'
                ? `<span class="task-badge badge-urgente">🔴 URGENTE</span>`
                : `<span class="task-badge badge-pendiente">⏳ Pendiente</span>`;

            const tituloServicio = {
                mandados: 'Compras y mandados',
                farmacia: 'Compra de medicinas',
                compania: 'Visita y compañía',
                transporte: 'Transporte y movilidad',
                medico: 'Apoyo médico'
            };

            return `
                <div class="task-card" data-task-id="${tarea.id}">
                    <div class="task-header">
                        <div class="task-type">${iconos[tarea.tipo]} ${tituloServicio[tarea.tipo] || tarea.titulo}</div>
                        ${estadoBadge}
                    </div>

                    <div class="user-info">
                        <div class="user-name">${tarea.usuario}</div>
                        <div class="user-contact">📱 ${tarea.telefono} • 📍 ${tarea.ubicacion}</div>
                    </div>

                    <div class="task-details">
                        <div class="detail-row">
                            <span class="detail-label">📝 Solicitud:</span>
                            <span>${tarea.descripcion}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">📅 Fecha/Hora:</span>
                            <span>${tarea.fecha} a las ${tarea.hora}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">ℹ️ Detalles:</span>
                            <span>${tarea.detalles}</span>
                        </div>
                    </div>

                    <div class="task-actions">
                        <button class="btn btn-cartoon btn-view" onclick="verDetalle(${tarea.id})">👁️ Ver más</button>
                        <button class="btn btn-cartoon btn-accept" onclick="aceptarTarea(${tarea.id})">✓ Aceptar</button>
                        <button class="btn btn-cartoon btn-decline" onclick="rechazarTarea(${tarea.id})">✗ No puedo</button>
                    </div>
                </div>
            `;
        }

        // MOSTRAR ERROR
        function mostrarError(mensaje) {
            const container = document.getElementById('tasksContainer');
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">⚠️</div>
                    <div class="empty-text">${mensaje}</div>
                </div>
            `;
        }

        // VER DETALLE EN MODAL
        function verDetalle(id) {
            const tarea = tareas.find(t => t.id === id);
            if (!tarea) return;

            const tituloServicio = {
                mandados: 'Compras y mandados',
                farmacia: 'Compra de medicinas',
                compania: 'Visita y compañía',
                transporte: 'Transporte y movilidad',
                medico: 'Apoyo médico'
            };

            document.getElementById('modalTaskTitle').textContent = tituloServicio[tarea.tipo] || tarea.titulo;
            document.getElementById('modalTaskBody').innerHTML = `
                <p><strong>Solicitante:</strong> ${tarea.usuario}</p>
                <p><strong>Teléfono:</strong> ${tarea.telefono}</p>
                <p><strong>Ubicación:</strong> ${tarea.ubicacion}</p>
                <p><strong>Descripción:</strong> ${tarea.descripcion}</p>
                <p><strong>Fecha y Hora:</strong> ${tarea.fecha} a las ${tarea.hora}</p>
                <p><strong>Prioridad:</strong> ${tarea.prioridad.charAt(0).toUpperCase() + tarea.prioridad.slice(1)}</p>
                <p><strong>Detalles adicionales:</strong> ${tarea.detalles}</p>
            `;

            document.getElementById('modalAcceptBtn').onclick = () => aceptarTarea(id);

            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }

        // ACEPTAR TAREA
        async function aceptarTarea(id) {
            if (!confirm('¿Estás seguro de que quieres aceptar esta solicitud? Te pondremos en contacto con el solicitante.')) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('solicitud_id', id);

                const response = await fetch('aceptar_solicitud.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });

                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseError) {
                    console.error('Respuesta inválida de aceptar_solicitud.php:', text);
                    alert('Error en respuesta del servidor al aceptar la solicitud');
                    return;
                }

                if (data.success) {
                    alert(`✓ Solicitud aceptada exitosamente. Te comunicaremos pronto con ${data.solicitud.descripcion ? 'el solicitante' : 'la persona que hizo la solicitud'}.`);

                    // Cerrar modal si está abierto
                    const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
                    if (modal) modal.hide();

                    // Recargar las tareas
                    await cargarTareas();
                } else {
                    alert('Error: ' + data.message);
                }

            } catch (error) {
                console.error('Error al aceptar tarea:', error);
                alert('Error de conexión al aceptar la solicitud');
            }
        }

        // RECHAZAR TAREA
        function rechazarTarea(id) {
            const tarea = tareas.find(t => t.id === id);
            if (!tarea) return;

            if (confirm(`¿Estás seguro de que no puedes atender esta solicitud: "${tarea.descripcion}"?`)) {
                // Por ahora solo mostramos el mensaje, después podríamos implementar lógica de rechazo
                alert('Entendido. Buscaremos otro voluntario disponible.');
            }
        }

        // FILTRAR TAREAS
        function filtrarTareas() {
            const tipo = document.getElementById('filterType').value;
            const estado = document.getElementById('filterStatus').value;

            let filtradas = tareas;

            if (tipo) {
                filtradas = filtradas.filter(t => t.tipo === tipo);
            }

            if (estado) {
                if (estado === 'urgente') {
                    filtradas = filtradas.filter(t => t.urgencia === 'urgente');
                } else if (estado === 'pendiente') {
                    filtradas = filtradas.filter(t => t.estado === 'pendiente');
                }
            }

            renderizarTareas(filtradas);
        }

        // INICIALIZAR
        window.addEventListener('load', cargarTareas);
    </script>

</body>

</html>