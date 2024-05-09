<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | ASISTENCIA</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Responsabilidades</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href=""> <b> Responsabilidades - Semanas</b></a>
                    </li>
                </ol>
            </div>

        </div>
        <style>
            .juntar {
                margin-bottom: 0px;
            }

            table {
                margin: 0 auto;
                width: 80%;
                border-collapse: collapse;
                background-color: #ffffff;
                margin-bottom: 20px;
            }

            tr {
                width: 100%;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 18px;
                text-align: center;
            }

            th {
                background-color: #4E7BBF;
                color: rgb(255, 255, 255);
                padding: 15px;
            }

            .semana {
                background-color: #4E7BBF;
                position: relative;
            }

            .semana button {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                background-color: antiquewhite;
            }

            .area {
                background-color: #78EA91;
                color: #000000;
            }

            .colabo {
                background-color: #eaeaeb;
                color: #000000;
            }

            .check,
            .x {
                cursor: pointer;
            }

            .respon {
                background-color: #A0D6F4;
                color: #000000;
                padding: 10px;
            }

            #semana2 {
                display: none;
            }

            .semanaactiva {
                display: block;
            }

            .regre {
                position: absolute;
                left: 10px;
                background-color: antiquewhite;
            }
        </style>

        <div>
            <table class="juntar">
                <tr>
                    <th> Marzo </th>
                    <th class="semana" colspan="8">Semana: 1
                        <button onclick="avanzarSemana()">-></button>

                    </th>
                </tr>
                <tr>
                    <th> Área </th>
                    <th class="area" colspan="8">Estructura</th>
                </tr>
            </table>
            <table id="semana1">
                <thead>
                    <tr>
                        <th> Colaboradores / Responsabilidades </th>
                        <td class="respon">Asistencia diaria</td>
                        <td class="respon">Reuniones Virtuales</td>
                        <td class="respon">Aportes de Ideas</td>
                        <td class="respon">Participación</td>
                        <td class="respon">Presentación de trabajos</td>
                        <td class="respon">Lecturas</td>
                        <td class="respon">Faltas justificadas</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="colabo">Marlo Samaniego</th>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">❌</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                    </tr>
                    <tr>
                        <th class="colabo">Daniel Roman</th>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                    </tr>
                    <tr>
                        <th class="colabo">Isabel Torres</th>
                        <td class="check" onclick="toggleCheck(this)">❌</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                    </tr>
                    <tr>
                        <th class="colabo">Paolo Guerrero</th>
                        <td class="check" onclick="toggleCheck(this)">❌</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                    </tr>
                    <tr>
                        <th class="colabo">Julio Flores</th>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">❌</td>
                        <td class="check" onclick="toggleCheck(this)">❌</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                        <td class="check" onclick="toggleCheck(this)">✔️</td>
                    </tr>
                </tbody>
            </table>
        </div>


        







        @include('components.inspinia.footer-inspinia')
        </div>
    </div>

</body>

</html>