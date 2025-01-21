<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Colaborador</title>
</head>
<body>
    <div class="container">
        <h1>Editar Colaborador</h1>

        <div>
            <input type="text" id="buscar-input" placeholder="Ingrese DNI o Correo">
            <button id="buscar-btn">Buscar</button>
        </div>

        <div id="resultados" style="margin-top: 20px;">
        </div>
    </div>

    <script>
        let colaborador = null;

        document.getElementById('buscar-btn').addEventListener('click', function () {
            const input = document.getElementById('buscar-input').value.trim();

            fetch(`/colaborador/search?input=${input}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    colaborador = data;
                    mostrarFormulario(data);
                })
                .catch(err => {
                    const resultadosDiv = document.getElementById('resultados');
                    resultadosDiv.innerHTML = `<p style="color: red;">${err.error}</p>`;
                });
        });

        function mostrarFormulario(data) {
            const resultadosDiv = document.getElementById('resultados');
            resultadosDiv.innerHTML = `
                <h2>Editar Datos del Colaborador</h2>
                <form id="editar-form">

                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" value="${data.candidato.nombre}">
                    <br>

                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" value="${data.candidato.apellido}">
                    <br>

                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" value="${data.candidato.dni}">
                    <br>

                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" value="${data.candidato.correo}">
                    <br>

                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" value="${data.candidato.celular}">
                    <br>

                    <label for="fecha_nacimiento">Fecha Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" value="${data.candidato.fecha_nacimiento}">
                    <br>

                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" value="${data.candidato.direccion}">
                    <br>

                    <label for="sede_id">Sede:</label>
                    <input type="text" id="sede_id" value="${data.candidato.sede_id}">
                    <br>

                    <label for="ciclo_de_estudiante">Ciclo de Estudiante:</label>
                    <input type="text" id="ciclo_de_estudiante" value="${data.candidato.ciclo_de_estudiante}">
                    <br>

                    <label for="carrera_id">Carrera:</label>
                    <input type="text" id="carrera_id" value="${data.candidato.carrera_id}">
                    <br>

                    <button type="submit">Actualizar</button>
                </form>
            `;

            document.getElementById('editar-form').addEventListener('submit', function(event) {
                event.preventDefault();
                actualizarColaborador();
            });
        }

        function actualizarColaborador() {
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const dni = document.getElementById('dni').value;
            const correo = document.getElementById('correo').value;
            const celular = document.getElementById('celular').value;
            const fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
            const direccion = document.getElementById('direccion').value;
            const sede_id = document.getElementById('sede_id').value;
            const ciclo_de_estudiante = document.getElementById('ciclo_de_estudiante').value;
            const carrera_id = document.getElementById('carrera_id').value;

            fetch(`/colaborador/update/${colaborador.candidato.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    nombre,
                    apellido,
                    dni,
                    correo,
                    celular,
                    fecha_nacimiento,
                    direccion,
                    sede_id,
                    ciclo_de_estudiante,
                    carrera_id,
                })
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                alert('Ocurrió un error al actualizar los datos.');
            });
        }
    </script>
</body>
</html>
