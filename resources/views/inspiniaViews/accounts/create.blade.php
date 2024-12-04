<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Incluir la librería Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <title>Crear Cuenta</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center ">
            <div class="col-lg-10">
                <h2>CREAR CUENTA</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('accounts.index')}}">Cuentas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Crear Cuenta</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            @error('colaborador_id')
            <div id="alert-colaborador_id-error" class="alert alert-danger alert-dismissible fade show d-flex align-items-start"
                role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Error:</strong> {{ $message }}
                </div>
                <button onclick="deleteAlert('alert-colaborador_id-error')" type="button" class="btn btn-outline-dark btn-xs"
                    style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fa fa-close"></i></button>
            </div>
            @enderror
            @error('areas_id')
            <div id="alert-areas_id-error" class="alert alert-danger alert-dismissible fade show d-flex align-items-start"
                role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Error:</strong> {{ $message }}
                </div>
                <button onclick="deleteAlert('alert-areas_id-error')" type="button" class="btn btn-outline-dark btn-xs"
                    style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fa fa-close"></i></button>
            </div>
            @enderror
            @if(session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show d-flex align-items-start"
                role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
                <button onclick="deleteAlert('alert-error')" type="button" class="btn btn-outline-dark btn-xs"
                    style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fa fa-close"></i></button>
            </div>
            @endif
            @if(session('success'))
            <div id="alert-success" class="alert alert-success alert-dismissible fade show d-flex align-items-start"
                role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Éxito:</strong> {{ session('success') }}
                </div>
                <button onclick="deleteAlert('alert-success')" type="button" class="btn btn-outline-dark btn-xs"
                    style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fa fa-close"></i></button>
            </div>
            @endif
            <div class="ibox">
                <div class="ibox-content d-flex flex-column gap-5">
                    <div class="d-flex justify-content-between">
                        <h2>Agregar Nuevo Usuario</h2>
                        <button id="btnModalColaboradores" type="button" href="#modalColaboradores"
                            class="btn btn-secondary btn-sm text-white d-flex align-items-center" data-toggle="modal"
                            disabled>Crear a base de colaborador</button>
                    </div>
                    <div>
                        <form method="POST" action="{{route('accounts.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tipo de Usuario</label>
                                        <select onchange="handleTypeChange()" class="form-control" name="type"
                                            id="selectUserType">
                                            <option value="1">Administrador</option>
                                            <option value="2">Jefe de Área</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Correo</label>
                                        <input onchange="verifyCorrectInputs()" type="email" id="email" name="email" class="form-control" required />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input onchange="verifyCorrectInputs()" id="password" name="password" type="password" class="form-control" required />
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="areasJefe">

                                    </div>
                                    <div class="form-group" id="colabInputCont">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input onchange="verifyCorrectInputs()"  name="name" id="name" type="text" class="form-control" required />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido</label>
                                        <input onchange="verifyCorrectInputs()" name="apellido" id="apellido" type="text" class="form-control"
                                            required />
                                        @error('apellido')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmar Contraseña</label>
                                        <input onchange="verifySamePassword()" name="confirm_password" type="password" id="confirm_password"
                                            class="form-control" required />
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span id="errorMessage" class="text-danger" hidden></span>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="btn btn-primary" id="submitButton" disabled>Crear Usuario</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="modalColaboradores" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modalColaboradoresLabel">Selecciona a un colaborador</h4>
                            </div>
                            <div class="modal-body d-flex flex-column gap-20">
                                <select class="form-control" id="colaboradorSelectedId">
                                    <option value="" disabled selected>Busca un colaborador</option>
                                    @foreach($colaboradores as $colaborador)
                                        <option value="{{$colaborador->id}}">{{$colaborador->candidato->nombre}} {{$colaborador->candidato->apellido}}</option>
                                    @endforeach
                                </select>
                                <button onclick="handleColabSelect()" class="btn btn-info">Seleccionar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                

            </div>
        </div>


        @include('components.inspinia.footer-inspinia')
    </div>
    </div>

</body>
<script>
    

    const deleteAlert = (id) => {
            let alertError = document.getElementById(id);
            if (alertError) {
                alertError.remove();
            } else{
                console.error(`Elemento con ID '${id}' no encontrado.`);
            }
        }
        
    let cacheEmail = '';
    let cacheNombre = '';
    let cacheApellido = ''
    let cacheColabId = null;

   // Inicializar Choices.js para permitir escribir en el select
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('colaboradorSelectedId');
    
    // Crear un nuevo objeto Choices para hacer el select escribible y filtrable
    const choices = new Choices(selectElement, {
        searchEnabled: true,  
        itemSelectText: '',  
        noResultsText: 'No se encontraron colaboradores',  
    });
});


const handleColabSelect = () => {
    const selectedColabId = document.getElementById('colaboradorSelectedId').value;

    if (selectedColabId) {
        // Aquí obtienes los datos del colaborador según su ID
        const colaborador = @json($colaboradores->keyBy('id')); // Suponiendo que `$colaboradores` es un array de objetos en tu backend

        const selectedColab = colaborador[selectedColabId];
        
        // Asigna los valores a los campos correspondientes
        let email = document.getElementById('email');
        let name = document.getElementById('name');
        let apellido = document.getElementById('apellido');

        email.value = selectedColab.candidato.correo;
        name.value = selectedColab.candidato.nombre;
        apellido.value = selectedColab.candidato.apellido;

        // Almacena en caché los valores para el formulario
        cacheEmail = email.value;
        cacheNombre = name.value;
        cacheApellido = apellido.value;
        cacheColabId = selectedColab.id;

        renderColabInput(cacheColabId);
        verifyCorrectInputs();
    }
};


    const renderColabInput = (colaborador_id) => {
        const colabInputCont = document.getElementById('colabInputCont');
        const toRender = `
            <input id="colabInput" name="colaborador_id" value="${colaborador_id}" hidden/>
        `;
        colabInputCont.innerHTML = toRender;
    }

    const destroyColabInput = () => {
        const colabInput = document.getElementById('colabInput');
        if (colabInput != null) {
            colabInput.remove();
        }
    }

    const handleTypeChange = () => {
        const selectType = document.getElementById('selectUserType');
        const btnColabs = document.getElementById('btnModalColaboradores');
        const selectedValue = selectType.value;

        let email = document.getElementById('email');
        let name = document.getElementById('name');
        let apellido = document.getElementById('apellido');

        if(selectedValue == 1){
            btnColabs.disabled = true;
            email.value = '';
            name.value = '';
            apellido.value = '';
            destroyAreas();
            destroyColabInput();
        } else if(selectedValue == 2){
            btnColabs.disabled = false;
            email.value = cacheEmail;
            name.value = cacheNombre;
            apellido.value = cacheApellido;
            renderAreas();
            if(cacheColabId != null) renderColabInput(cacheColabId);
        }

        verifyCorrectInputs();

    }

    const renderAreas = () => {
        const areasJefe = document.getElementById('areasJefe');
        const areas = @json($areas);
        const optionAreas = areas.map((area) => `<option value="${area.id}">${area.especializacion}</option>`)
        const toRender = `
            <label id="lblAreas">Áreas Jefe</label>
            <select id="selectAreas" onchange="verifyCorrectInputs()" class="form-control multiple_areas_select" name="areas_id[]" multiple required>
                   ${optionAreas.join('')}
            </select>
        `;
        areasJefe.innerHTML = toRender;
        $(document).ready(function() {
            $('.multiple_areas_select').select2();
        });
    }

    const destroyAreas = () => {
        const lblAreas = document.getElementById('lblAreas');
        const selectAreas = document.getElementById('selectAreas');
        const select2Container = document.querySelector('.select2-container');
        lblAreas.remove();
        selectAreas.remove();
        select2Container.remove();
    }

    const verifySamePassword = () => {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMessage = document.getElementById('errorMessage')

        if (password !== confirmPassword) {
            errorMessage.hidden = false;
            errorMessage.innerText = 'Las contraseñas no coinciden'

        } else{
            errorMessage.hidden = true
            errorMessage.innerText = '';
        }

        verifyCorrectInputs();
    }

    verifyCorrectInputs = () => {
        const submitButton = document.getElementById('submitButton');
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const apellido = document.getElementById('apellido').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const selectAreas = document.getElementById('selectAreas');

        if(email != '' && name != '' && apellido != '' && password != '' && confirmPassword != '' && password == confirmPassword) {
            if(selectAreas != null){
                //verificar que no este vacio
                const selectedOptions = Array.from(selectAreas.selectedOptions)
                if(selectedOptions.length > 0) {
                    submitButton.disabled = false
                } else{
                    submitButton.disabled = true
                }
            } else{
                submitButton.disabled = false
            }
        } else{
            submitButton.disabled = true
        }

    }


    
</script>

</html>