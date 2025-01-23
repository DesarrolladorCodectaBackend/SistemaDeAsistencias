<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/colaboradores/edit-colab.css') }}">
    <title>Editar Colaborador</title>
</head>
<body>
    <main class="main-colaborador">
        <section class="section-colaborador">

            <div class="search-content">
                <h1 class="search-title">Ingrese DNI o correo</h1>

                <div class="search-input-content">
                    <input type="text" id="buscar-input">
                    <button id="buscar-btn">Buscar</button>
                </div>

            </div>

            <div id="resultados">
            </div>

        </section>
    </main>

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
                    resultadosDiv.innerHTML = `<p class="text-colab-error">${err.error}</p>`;
                });
        });

        function mostrarFormulario(data) {
            const resultadosDiv = document.getElementById('resultados');
            resultadosDiv.innerHTML = `
                <h3 class="title-form">Datos del Colaborador</h3>
                <div class="form-colab-content">
                    <form id="editar-form">
                        <div class="nombre-content data-colab">
                            <label for="nombre">Nombres</label>
                            <input type="text" id="nombre" value="${data.candidato.nombre}">
                            <span class="error-message" id="error-nombre"></span>
                        </div>

                        <div class="apellido-content data-colab">
                            <label for="apellido">Apellidos</label>
                            <input type="text" id="apellido" value="${data.candidato.apellido}">
                            <span class="error-message" id="error-apellido"></span>
                        </div>

                        <div class="dni-content data-colab">
                            <label for="dni">DNI</label>
                            <input type="text" id="dni" value="${data.candidato.dni ? data.candidato.dni : ''}">
                            <span class="error-message" id="error-dni"></span>
                        </div>

                        <div class="correo-content data-colab">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" value="${data.candidato.correo ? data.candidato.correo : ''}">
                            <span class="error-message" id="error-correo"></span>
                        </div>

                        <div class="celular-content data-colab">
                            <label for="celular">Celular</label>
                            <input type="text" id="celular" value="${data.candidato.celular ? data.candidato.celular : ''}">
                            <span class="error-message" id="error-celular"></span>
                        </div>

                        <div class="fecha_nacimiento-content data-colab">
                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" value="${data.candidato.fecha_nacimiento}">
                        </div>

                        <div class="direccion-content data-colab">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" value="${data.candidato.direccion}">
                        </div>

                        <div class="sede-content data-colab">
                            <label for="sede_id">Sede</label>
                            <select class="form-select" aria-label="Default select example" id="sede_id">
                                ${data.sedes.map(sede => `
                                    <option value="${sede.id}" ${sede.id === data.candidato.sede_id ? 'selected' : ''}>
                                        ${sede.nombre}
                                    </option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="ciclo-content data-colab">
                            <label for="ciclo_de_estudiante">Ciclo de Estudiante</label>
                            <select class="form-select" aria-label="Default select example" id="ciclo_de_estudiante">
                                ${[4, 5, 6, 7, 8, 9, 10].map(ciclo => `
                                    <option value="${ciclo}" ${ciclo === data.candidato.ciclo_de_estudiante ? 'selected' : ''}>
                                        ${ciclo}
                                    </option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="carrera-content data-colab">
                            <label for="carrera_id">Carrera</label>
                            <select class="form-select" aria-label="Default select example" id="carrera_id">
                                ${data.carreras.map(carrera => `
                                    <option value="${carrera.id}" ${carrera.id === data.candidato.carrera_id ? 'selected' : ''}>
                                        ${carrera.nombre}
                                    </option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="especialista-content data-colab">
                            <label for="especialista_id">Especialista</label>
                            <select class="form-select" aria-label="Default select example" id="especialista_id">
                                ${data.especialistas.map(especialista => `
                                    <option value="${especialista.id}" ${especialista.id === data.colaborador.especialista_id ? 'selected' : ''}>
                                        ${especialista.nombres}
                                    </option>
                                `).join('')}
                                ${!data.colaborador.especialista_id ? '<option value="" selected>Sin especialista</option>' : ''}
                            </select>
                        </div>

                        <div class="btn-colab-content">
                            <button type="submit" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path>
                                </svg>
                                Actualizar
                            </button>
                        </div>

                    </form>
                </div>
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
            const especialista_id = document.getElementById('especialista_id').value;

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
                    especialista_id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    mostrarErrores(data.errors);
                } else {
                    window.location.reload();
                }
            })
            .catch(err => {
                alert('Ocurrió un error al actualizar los datos.');
            });
        }

        function mostrarErrores(errors) {
            document.querySelectorAll('.error-message').forEach(span => {
                span.textContent = '';
            });

            for (const [field, message] of Object.entries(errors)) {
                const errorSpan = document.getElementById(`error-${field}`);
                if (errorSpan) {
                    errorSpan.textContent = message;
                }
            }
        }
    </script>

</body>
</html>
