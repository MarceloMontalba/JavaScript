<?php
  include_once("php/conex.php");
  include_once("php/desplegables.php");
  $link = conectarBd();

  $alumno           = is_numeric($_GET["alumno"])? $_GET["alumno"]:0;
  $consulta         = "SELECT estudiante.estd_rut, 
                      estudiante.sexo_codigo estd_sexo,
                      LTRIM(RTRIM(UPPER(SUBSTRING(estudiante.estd_nombre1, 1, 1)) + 
                      LOWER(SUBSTRING(estudiante.estd_nombre1, 2, 
                      LEN(estudiante.estd_nombre1 + 'X') - 1)))) estd_primer_nombre,
                      UPPER(RTRIM(LTRIM(estudiante.estd_nombre1))+' '+
                      UPPER(RTRIM(estudiante.estd_nombre2))+' '+
                      UPPER(RTRIM(estudiante.estd_paterno))+' '+
                      UPPER(RTRIM(estudiante.estd_materno))) estd_nombre_completo,
                      carrera.estu_registro registro_carrera,
                      CAST(programa.carr_codigo AS VARCHAR(MAX))+' - '+
                      UPPER(LTRIM(RTRIM(programa.carr_nombre))) nombre_carrera,
                      carrera.estu_anho_ing anho_ingreso_carrera,
                      UPPER(LTRIM(RTRIM(situacion.salu_nombre))) situacion_alumno,
                      LTRIM(RTRIM(LOWER(estudiante.estd_email_opc))) estd_email,
                      estudiante.estd_fono_per estd_fono1,
                      estudiante.estd_fono_opc estd_fono2
                      FROM ACADEMIA.dbo.estudiante estudiante
                      LEFT JOIN (
                        SELECT TOP 1 estu_registro, estd_rut, carr_codigo, salu_codigo, estu_anho_ing 
                        FROM ACADEMIA.dbo.estudiante_carrera 
                        WHERE estd_rut=$alumno 
                        ORDER BY estu_fecha_ing DESC
                      ) carrera
                      ON estudiante.estd_rut=carrera.estd_rut
                      LEFT JOIN ACADEMIA.dbo.carrera_programa programa
                      ON carrera.carr_codigo=programa.carr_codigo
                      LEFT JOIN ACADEMIA.dbo.situacion_alumno situacion
                      ON carrera.salu_codigo=situacion.salu_codigo
                      WHERE estudiante.estd_rut=$alumno";

  $query            = mssql_query($consulta, $link);
  $fila             = mssql_fetch_object($query);

  // Variables de información
  $rutAlumno = utf8_encode($fila->estd_rut);
  $sexoAlumno = intval($fila->estd_sexo);
  $nombreAlumno = utf8_encode($fila->estd_nombre_completo);
  $primerNombreAlumno = utf8_encode($fila->estd_primer_nombre);
  $registroCarrera = intval($fila->registro_carrera)>0?intval($fila->registro_carrera):'';
  $nombreCarrera   = utf8_encode($fila->nombre_carrera);
  $anhoIngreso     = intval($fila->anho_ingreso_carrera)>0?intval($fila->anho_ingreso_carrera):'';
  $situacionAlumno = utf8_encode($fila->situacion_alumno);
  $fonoAlumno1     = intval($fila->estd_fono1)>0?intval($fila->estd_fono1):'';
  $fonoAlumno2     = intval($fila->estd_fono2)>0?intval($fila->estd_fono2):'';
  $emailAlumno     = utf8_encode($fila->estd_email);
  $fechaActual     = date("d-m-Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitudes Estudiantes</title>
  <link rel="icon" type="image/png" href="img/icono.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <main class="container">
    <section class="row">
      <article class="container-fluid contenedor-principal col-12 col-md-9 col-lg-7">
        <div class="container contenedor-mensaje-solicitud">
          <h1>Solicitudes estudiantes</h1>
          <p>En esta sección encontrarás el formulario mediante el cual puedes hacer una solicitud de <b>Reincorporación</b>, 
            <b>Suspensión</b> o <b>Renuncia</b>. Además puedes consultar el estado en que se encuentra tu solicitud.
          </p>
          <p>
            Para visualizar el contenido solo debes hacer click sobre el título de tu interés el cual desplegará el 
            contenido deseado.
          </p>
        </div>
    
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed b-apartado" type="button" data-bs-toggle="collapse" data-bs-target="#primerApartado" aria-expanded="true" aria-controls="primerApartado">
                <i class="fa-solid fa-file-signature m-icono"></i> Ingresar Solicitud
              </button>
            </h2>
            <div id="primerApartado" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0">
                <!--Selección del tipo de formulario-->
                <div class="card tarjeta-tipo-solicitud-seleccion rounded-0">
                  <div class="card-header tarjeta-tipo-solicitud-header">
                    <ul class="nav nav-tabs seleccion-formulario card-header-tabs">
                      <li class="nav-item seleccion-formulario">
                        <a class="nav-link btn-solicitud active" id="btn-instrucciones">Instrucciones</a>
                      </li>
                      <li class="nav-item seleccion-formulario">
                        <a class="nav-link btn-solicitud" id="btn-suspension">Suspensión</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link btn-solicitud" id="btn-reincorporacion">Reincorporación</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link btn-solicitud" id="btn-renuncia">Renuncia</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body p-1">
                    <!--Div usado para hacer un scroll automatico-->
                    <div id="posicionador-scroll"></div>
                    
                    <!--Instrucciones-->
                    <div id="mensaje-bienvenida" class="container-fluid mensaje-bienvenida p-5">
                      <div class="contenedor-logo">
                        <img class="logo" src="./img/logo_dara.png"/>
                      </div>

                      <p>
                        <?php echo $sexoAlumno==2?"Estimada ".$primerNombreAlumno.",":"Estimado ".$primerNombreAlumno.",";?>
                      </p>
                      <p>
                        Queremos informarte sobre las opciones disponibles para ti en el presente módulo con relación 
                        a tu situación académica. Por favor, lee cuidadosamente las siguientes opciones y 
                        selecciona la que mejor se adapte a tu situación actual.
                      </p>

                      <div class="card caja-bienvenida-reincorporacion">
                        <div class="card-header pt-1 pb-1">
                          <h5>Reincorporación</h5>
                        </div>
                        <div class="card-body p-3 pt-1 pb-1">
                          <p>
                            Si has suspendido tus estudios anteriormente y ahora estás <?php echo $sexoAlumno==2?"lista":"listo" ?> para regresar, 
                            puedes seleccionar la opción de <span class="destacado">reincorporación</span>.
                          </p>
                        </div>
                      </div>

                      <div class="card caja-bienvenida-suspension">
                        <div class="card-header pt-1 pb-1">
                          <h5>Suspensión</h5>
                        </div>
                        <div class="card-body p-3 pt-1 pb-1">
                          <p>
                            Si necesitas tomar un receso temporal en tus estudios debido a razones personales, 
                            médicas u otras circunstancias, puedes optar por 
                            <span class="destacado">supender</span> tus estudios.
                          </p>
                        </div>
                      </div>

                      <div class="card caja-bienvenida-renuncia">
                        <div class="card-header pt-1 pb-1">
                          <h5>Renuncia</h5>
                        </div>
                        <div class="card-body p-3 pt-1 pb-1">
                          <p>
                            Si has decidido tomar un camino diferente y dejar tus estudios de manera definitiva, 
                            puedes seleccionar la opción de <span class="destacado rojo">renunciar</span> a la carrera.
                          </p>
                        </div>
                      </div>

                      <p>
                        Por favor, toma el tiempo necesario para considerar cada opción antes de tomar una decisión. 
                        Estamos aquí para apoyarte en todo el proceso y responder cualquier pregunta que puedas tener.
                        Si tienes alguna duda o necesitas más información, no dudes en ponerte en contacto con nuestro 
                        equipo de asesoramiento académico desde nuestro correo electrónico <span class="negrita">dara@uctemuco.cl</span>.
                      </p>

                      <p class="remitente">Atentamente,<br>
                        Dirección de Admisión y Registros Académicos<br>
                        <span class="negrita">Universidad Católica de Temuco</span>
                      </p>
                    </div>

                    <!--Seccion de suspensiones academicas-->
                    <div id="seleccion-suspensiones" class="seleccion-tipo-solicitud container-fluid">
                      <div class="container mb-3">
                        <div class="row">
                          <div class="col-1"></div>
                          <div class="col-10 mt-3">
                            <h3 class="contenedor-titulo-barra-progreso mb-4">Progreso de la Solicitud</h3>
                            <ul class="barra-progreso">
                              <li class="barra-progreso-opcion barra-progreso-opcion-activo">paso 1</li>
                              <li class="barra-progreso-opcion">paso 2</li>
                              <li class="barra-progreso-opcion">paso 3</li>
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!--Suspension Academica-->
                      <article class="card paso-suspensiones" id="suspension-academica">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de suspensión academica (1/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <form class="p-3 formulario-llenar">
                            <div class="form-group row">
                              <div class="accordion accordion-flush col-12" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header p-0" id="">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#info-personal-suspensiones-desplegable" aria-expanded="true" aria-controls="info-personal-suspensiones-desplegable">
                                      <i class="fa-solid fa-user m-icono icono-subapartado"></i> Información Personal <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="info-personal-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="info-personal-suspensiones-desplegable">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row">

                                      <div class="form-group row mt-0">
                                        <div class="form-group row col-xl-12">
                                          <div class="col-12 mensaje-bienvenida">
                                            <p class="remitente">Te recomendamos tener tus datos de contacto actualizados para notificarte del estado 
                                              de tu solicitud en un futuro posterior.
                                            </p>
                                          </div>
                                        </div>
                                      </div>

                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-xl-12 col-form-label p-1">Rut</label>
                                          <div class="col-xl-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $rutAlumno;?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-9 mt-2">
                                          <label for="staticEmail" class="col-xl-12 col-form-label p-1">Nombre Completo</label>
                                          <div class="col-xl-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $nombreAlumno;?>">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row p-0 mb-3">
                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fono 1<span class="obligatorio">(*)</span></label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $fonoAlumno1; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fono 2</label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $fonoAlumno2; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-6 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">E-Mail Personal <span class="obligatorio">(*)</span></label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $emailAlumno; ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#info-academica-suspensiones-desplegable" aria-expanded="true" aria-controls="info-academica-suspensiones-desplegable">
                                      <i class="fa-solid fa-graduation-cap m-icono icono-subapartado"></i>Información Academica
                                    </button>
                                  </h2>
                                  <div id="info-academica-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row">
                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Registro</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $registroCarrera;?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-9 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Carrera</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $nombreCarrera;?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                        <div class="form-group row col-xl-4 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Año de Ingreso</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $anhoIngreso;?>">
                                          </div>
                                        </div>
                                        <div class="form-group row col-xl-4 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Situación Actual</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm fw-bold" id="staticEmail" value="<?php echo $situacionAlumno;?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-suspensiones-desplegable" aria-expanded="true" aria-controls="detalles-suspensiones-desplegable">
                                      <i class="fa-solid fa-calendar-days m-icono icono-subapartado"></i> Periodo de la Suspensión <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="detalles-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row mt-2">
                                        <div class="form-group row col-xl-4">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fecha solicitud</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $fechaActual; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group row col-xl-6">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Semestre solicitud</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="SEGUNDO SEMESTRE DEL AÑO 2023">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-2 mb-2">
                                        <div class="form-group row col-xl-9">
                                          <label for="inputPassword" class="col-12 col-form-label p-1">
                                            Proyección de la suspensión <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-xl-12 p-1">
                                            <select name="" id="" class="form-select form-select-sm">
                                              <option value="">AÑO COMPLETO - 2023</option>
                                              <option value="">SEMESTRE 1 - 2023 </option>
                                              <option value="">SEMESTRE 2 - 2023</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#motivos-suspensiones-desplegable" aria-expanded="true" aria-controls="motivos-suspensiones-desplegable">
                                      <i class="fa-solid fa-question m-icono icono-subapartado"></i>Motivos de la Solicitud <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="motivos-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      
                                      <div class="form-group row mt-1">
                                        <div class="form-group row col-xl-12">
                                          <div class="col-12 mensaje-bienvenida">
                                            <p class="remitente">En esta sección, se le solicita que seleccione al menos un motivo y luego especifique el motivo particular, 
                                              para finalmente agregarlo a la lista con el botón <span class="negrita">Agregar</span>.
                                            </p>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-2">
                                        <div class="form-group row col-xl-5">
                                          <label for="inputPassword" class="col-12 col-form-label p-1">
                                            Motivo <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12 p-1">
                                            <select id="input-motivo-suspension1" class="form-select form-select-sm">
                                              <option value="-1" selected>Seleccionar motivo...</option>
                                              <?php foreach(listarMotivos() as $motivo ){ ?>
                                                <option value="<?php echo $motivo["id"] ?>"><?php echo $motivo["nombre"] ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-7">
                                          <label for="inputPassword" class="col-12 col-form-label p-1">
                                            Motivo principal <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12 p-1">
                                            <select id="input-motivo-detallado-suspension1" class="form-select form-select-sm">
                                              <option value="-1" selected>Seleccionar motivo...</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-3 mb-3">
                                        <div class="form-group row col-12 px-3">
                                          <div>
                                            <button type="button" class="boton boton-verde boton-chico" id="boton-agregar-motivo-suspension1">
                                              <i class="fa-solid fa-plus"></i> Agregar
                                            </button>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="form-group row mt-3 mb-3">
                                        <div class="form-group row col-11">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Lista de motivos
                                          </label>
                                          <div class="col-12">
                                            <!--Lista de Motivos-->
                                            <div class="table-responsive tabla-institucional">
                                              <table class="table tabla-motivos" id="tabla-motivos-suspensiones1">
                                                <thead>
                                                  <tr>
                                                    <th style='width:7rem'>Motivos</th>
                                                    <th>Descripción</th>
                                                    <th style='width:7rem'>Acción</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-3 mb-2">
                                        <div class="form-group row col-xl-10">
                                          <label for="inputPassword" class="col-12 col-form-label">Descripción de los motivos</label>
                                          <div class="col-12">
                                            <textarea name="" id="" class="form-control" placeholder="Ingresar una breve descripción de sus motivos..."></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="container mt-3 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-suspension" data-to_step="2" data-step="1">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </section>
                      </article>

                      <!--Aviso de suspension de Beneficios-->
                      <article class="card paso-suspensiones" id="aviso-suspension-beneficios1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de suspensión de beneficios (2/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <div class="container-fluid mensaje-bienvenida mensaje-bienestar p-5">
                            <div class="contenedor-logo">
                              <img class="logo" src="./img/logo_bienestar_estudiantil.png"/>
                            </div>

                            <p>
                              <?php echo $sexoAlumno==2? "Estimada ".$primerNombreAlumno.",":"Estimado ".$primerNombreAlumno.","; ?>
                            </p>

                            <p>Te informamos que, debido a que cuentas con beneficios MINEDUC, hemos agregado un paso adicional 
                              al proceso actual. Esto con el objetivo de garantizar un tratamiento adecuado de dichos beneficios 
                              durante tu solicitud de suspensión académica.
                            </p>

                            <p>Este paso adicional es esencial para asegurar la correcta <span class="negrita text-uppercase">conservación</span> 
                              de tus beneficios y así poder retomarlos en algún futuro posterior. En este paso y/o apartado, te mostraremos 
                              los beneficios que posees en la actualidad, para que indiques qué deseas hacer con ellos.
                            </p>
                                                        
                            <p><span class="negrita text-uppercase">Requisito Previo:</span> Queremos informarte que antes de realizar este paso, es 
                              necesario que completes el Formulario de Suspensión de Beneficios proporcionado por el MINEDUC. En caso de que 
                              aún no lo hayas hecho, puedes encontrarlo en 
                              <a href="https://portal.beneficiosestudiantiles.cl/sites/default/files/formulario_suspensiones_2023_v2.pdf" target="_blank">
                                https://portal.beneficiosestudiantiles.cl/sites/default/files/formulario_suspensiones_2023_v2.pdf
                              </a>. Rellenar este formulario es un requisito imprescindible, ya que en el siguiente paso te solicitaremos 
                              adjuntarlo junto con otra información relevante. Posteriormente, estos datos serán enviados al MINEDUC 
                              para que procesen tu solicitud de suspensión de beneficios.
                            </p>
                                 
                            <div class="contenedor-imagenes-formulario-beneficios">
                              <img src="img/formulario_MINEDUC_1.png">
                              <img src="img/formulario_MINEDUC_2.png">
                            </div>
                            <p class="remitente text-center negrita mb-4 mt-2">Formulario de Suspensión de Beneficios del MINEDUC.</p>

                            <p>De antemano agradecemos tu colaboración. Ante cualquier duda con respecto a la suspensión de tus beneficios, no dudes en 
                              comunicarte con nuestro equipo al correo electrónico <span class="negrita">bienestarestudiantil@uct.cl</span>, que 
                              está disponible para ayudarte.
                            </p>

                            <p class="remitente">Atentamente,<br>
                              Dirección de Bienestar Estudiantil<br>
                              <span class="negrita">Universidad Católica de Temuco</span>
                            </p>

                            <div class="container mt-5 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-regresar-suspension-academica" data-step="2">
                                  <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                                </button>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-suspension2" data-step="1">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </section>
                      </article>


                      <!--Suspension de Beneficios-->
                      <article class="card paso-suspensiones" id="suspension-beneficios1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de suspensión de beneficios (2/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <form class="p-3 formulario-llenar">
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-suspensiones-beneficios-desplegable" aria-expanded="true" aria-controls="detalles-suspensiones-beneficios-desplegable">
                                      <i class="fa-solid fa-piggy-bank m-icono icono-subapartado"></i> Beneficios actuales<span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="detalles-suspensiones-beneficios-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row mt-2">
                                        <div class="form-group row col-12">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Beneficios a suspender <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12">
                                            <!--Lista de Motivos-->
                                            <div class="table-responsive tabla-institucional">
                                              <table class="table tabla-motivos">
                                                <thead>
                                                  <tr>
                                                    <th>Beneficio</th>
                                                    <th style="width: 14rem">Suspender</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>GRATUIDAD ARANCEL MINEDUC</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>GRATUIDAD MATRICULA MINEDUC</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>BRECHA GRATUIDAD ARANCEL UCT</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>TARJETA ALIMENTACION</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>

                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-4 mb-3">
                                        <div class="form-group row col-12">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Cargar formulario MINEDUC <span class="obligatorio">(*)</span>
                                          </label>
                                          <p class="parrafo-info col-12">El archivo debe de estar en formato PDF y por nombre tiene que llevar 
                                            por nomenclatura RUT-Formulario.pdf. <span class="rojo">Ejemplo: 11222333-Formulario.pdf</span>.
                                          </p>
                                          <div class="col-12">
                                            <input class="form-control form-control-sm" id="formFileSm" type="file">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-4 mb-3">
                                        <div class="form-group row col-6">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            N° de solicitudes de suspensión realiazas anteriormente
                                          </label>
                                          <div class="col-12">
                                            <input class="form-control form-control-sm" id="formFileSm" type="text" disabled value="3">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="container mt-3 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-aviso-suspension-beneficios1" data-step="3">
                                  <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                                </button>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-confirmacion1" data-step="2">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </section>
                      </article>

                      <!--Confirmación-->
                      <article class="card paso-suspensiones" id="suspension-confirmacion1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Confirmación de los datos (3/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-5 mensaje-bienvenida">
                          <div class="contenedor-logo logo-uct">
                            <img class="logo" src="./img/logo_uct.png"/>
                          </div>

                          <p class="text-uppercase rojo negrita">Importante</p>
                          <p>
                            <?php echo $sexoAlumno==2? "Estimada ".$primerNombreAlumno.",":"Estimado ".$primerNombreAlumno.","; ?>
                          </p>
                          <p>Antes de proceder, queremos asegurarnos de que todos los datos ingresados sean precisos y 
                            válidos. Tu seguridad y la integridad de la información son nuestras prioridades.</p>

                          <p>Al hacer clic en el botón de confirmación a continuación, afirmas y garantizas que:</p>
                          <ul>
                            <li>La información proporcionada es precisa y refleja tu situación actual.</li>
                            <li>Has revisado cuidadosamente todos los detalles antes de confirmar.</li>
                            <li>Asumes la responsabilidad de cualquier consecuencia derivada de la información proporcionada.</li>
                          </ul>
                          
                          <p>Por favor, toma un momento para repasar la información ingresada y asegurarte de su 
                            exactitud.</p> 

                          <p>Botón de Confirmación: <span class="negrita">[Confirmar Datos]</span></p>

                          <p>Al confirmar, aceptas que la información proporcionada es correcta y estás de acuerdo 
                            con los términos y condiciones establecidos. Gracias por tu cooperación y compromiso 
                            con la precisión de los datos.</p>

                          <p class="remitente">Atentamente,<br>
                            <span class="negrita">Universidad Católica de Temuco</span>
                          </p>

                          <div class="container mt-3 d-flex justify-content-center">
                            <div class="mt-3">
                              <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-regresar-suspension-beneficios1" data-step="3">
                                <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                              </button>
                              <button class="boton boton-verde btn-success pl-3">
                                <i class="fa-solid fa-check m-icono"></i>Confirmar datos
                              </button>
                            </div>
                          </div>
                        </section>
                      </article>
                    </div>

                    <!--Seccion de renuncia-->
                    <div id="seleccion-renuncia" class="seleccion-tipo-solicitud container-fluid">
                      <div class="container mb-3">
                        <div class="row">
                          <div class="col-1"></div>
                          <div class="col-10 mt-3">
                            <h3 class="contenedor-titulo-barra-progreso mb-4">Progreso de la Solicitud</h3>
                            <ul class="barra-progreso">
                              <li class="barra-progreso-opcion barra-progreso-opcion-activo">paso 1</li>
                              <li class="barra-progreso-opcion">paso 2</li>
                              <li class="barra-progreso-opcion">paso 3</li>
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!--Suspension Academica-->
                      <article class="card paso-suspensiones" id="suspension-academica">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de renuncia academica (1/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <form class="p-3 formulario-llenar">
                            <div class="form-group row">
                              <div class="accordion accordion-flush col-12" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header p-0" id="">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#info-personal-suspensiones-desplegable" aria-expanded="true" aria-controls="info-personal-suspensiones-desplegable">
                                      <i class="fa-solid fa-user m-icono icono-subapartado"></i> Información Personal <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="info-personal-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="info-personal-suspensiones-desplegable">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row">
                                        <div class="form-group row mt-0">
                                          <div class="form-group row col-xl-12">
                                            <div class="col-12 mensaje-bienvenida">
                                              <p class="remitente">Te recomendamos tener tus datos de contacto actualizados para notificarte del estado 
                                                de tu solicitud en un futuro posterior.
                                              </p>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-xl-12 col-form-label p-1">Rut</label>
                                          <div class="col-xl-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $rutAlumno; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-9 mt-2">
                                          <label for="staticEmail" class="col-xl-12 col-form-label p-1">Nombre Completo</label>
                                          <div class="col-xl-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $nombreAlumno; ?>">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row p-0 mb-3">
                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fono 1<span class="obligatorio">(*)</span></label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $fonoAlumno1; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fono 2</label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $fonoAlumno2; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-6 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">E-Mail Personal <span class="obligatorio">(*)</span></label>
                                          <div class="col-12 p-1">
                                            <input type="text" class="form-control form-control-sm" id="staticEmail" value="<?php echo $emailAlumno; ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#info-academica-suspensiones-desplegable" aria-expanded="true" aria-controls="info-academica-suspensiones-desplegable">
                                      <i class="fa-solid fa-graduation-cap m-icono icono-subapartado"></i>Información Academica
                                    </button>
                                  </h2>
                                  <div id="info-academica-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row">
                                        <div class="form-group row col-xl-3 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Registro</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $registroCarrera; ?>">
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-9 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Carrera</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $nombreCarrera; ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                        <div class="form-group row col-xl-4 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Año de Ingreso</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $anhoIngreso; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group row col-xl-4 mt-2">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Situación Actual</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm fw-bold" id="staticEmail" value="<?php echo $situacionAlumno; ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-suspensiones-desplegable" aria-expanded="true" aria-controls="detalles-suspensiones-desplegable">
                                      <i class="fa-solid fa-calendar-days m-icono icono-subapartado"></i> Periodo de la Renuncia <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="detalles-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row mt-3 mb-2">
                                        <div class="form-group row col-xl-4">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Fecha solicitud</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="<?php echo $fechaActual; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group row col-xl-6">
                                          <label for="staticEmail" class="col-12 col-form-label p-1">Semestre solicitud</label>
                                          <div class="col-12 p-1">
                                            <input type="text" disabled class="form-control form-control-sm" id="staticEmail" value="SEGUNDO SEMESTRE DEL AÑO 2023">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row mt-1"></div>
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#motivos-suspensiones-desplegable" aria-expanded="true" aria-controls="motivos-suspensiones-desplegable">
                                      <i class="fa-solid fa-question m-icono icono-subapartado"></i>Motivos de la Solicitud <span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="motivos-suspensiones-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      
                                      <div class="form-group row mt-1">
                                        <div class="form-group row col-xl-12">
                                          <div class="col-12 mensaje-bienvenida">
                                            <p class="remitente">En esta sección, se le solicita que seleccione al menos un motivo y luego especifique el motivo particular, 
                                              para finalmente agregarlo a la lista con el botón <span class="negrita">Agregar</span>.
                                            </p>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-2">
                                        <div class="form-group row col-xl-5">
                                          <label for="inputPassword" class="col-12 col-form-label p-1">
                                            Motivo <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12 p-1">
                                            <select name="" id="" class="form-select form-select-sm">
                                              <option value="">Seleccionar motivo...</option>
                                              <option value="">ACADÉMICO</option>
                                              <option value="">CAMBIO DE UNIVERSIDAD</option>
                                              <option value="">CAMBIO INTERNO UCT</option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="form-group row col-xl-7">
                                          <label for="inputPassword" class="col-12 col-form-label p-1">
                                            Motivo principal <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12 p-1">
                                            <select name="" id="" class="form-select form-select-sm" disabled>
                                              <option value="">Seleccionar motivo...</option>
                                              <option value="">ACADÉMICO</option>
                                              <option value="">CAMBIO DE UNIVERSIDAD</option>
                                              <option value="">CAMBIO INTERNO UCT</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-3 mb-3">
                                        <div class="form-group row col-12 px-3">
                                          <div>
                                            <button type="button" class="boton boton-verde boton-chico">
                                              <i class="fa-solid fa-plus"></i> Agregar
                                            </button>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="form-group row mt-3 mb-3">
                                        <div class="form-group row col-11">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Lista de motivos
                                          </label>
                                          <div class="col-12">
                                            <!--Lista de Motivos-->
                                            <div class="table-responsive tabla-institucional">
                                              <table class="table tabla-motivos">
                                                <thead>
                                                  <tr>
                                                    <th>Motivos</th>
                                                    <th>Descripción</th>
                                                    <th>Acción</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-3 mb-2">
                                        <div class="form-group row col-xl-10">
                                          <label for="inputPassword" class="col-12 col-form-label">Descripción de los motivos</label>
                                          <div class="col-12">
                                            <textarea name="" id="" class="form-control" placeholder="Ingresar una breve descripción de sus motivos..."></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="container mt-3 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-suspension" data-to_step="2" data-step="1">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </section>
                      </article>

                      <!--Aviso de suspension de Beneficios-->
                      <article class="card paso-suspensiones" id="aviso-suspension-beneficios1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de suspensión de beneficios (2/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <div class="container-fluid mensaje-bienvenida mensaje-bienestar p-5">
                            <div class="contenedor-logo">
                              <img class="logo" src="./img/logo_bienestar_estudiantil.png"/>
                            </div>

                            <p>
                              <?php echo $sexoAlumno==2? "Estimada ".$primerNombreAlumno.",":"Estimado ".$primerNombreAlumno.","; ?>
                            </p>

                            <p>Te informamos que, debido a que cuentas con beneficios MINEDUC, hemos agregado un paso adicional 
                              al proceso actual. Esto con el objetivo de garantizar un tratamiento adecuado de dichos beneficios 
                              durante tu solicitud de suspensión académica.
                            </p>

                            <p>Este paso adicional es esencial para asegurar la correcta <span class="negrita text-uppercase">conservación</span> 
                              de tus beneficios y así poder retomarlos en algún futuro posterior. En este paso y/o apartado, te mostraremos 
                              los beneficios que posees en la actualidad, para que indiques qué deseas hacer con ellos.
                            </p>
                                                        
                            <p><span class="negrita text-uppercase">Requisito Previo:</span> Queremos informarte que antes de realizar este paso, es 
                              necesario que completes el Formulario de Suspensión de Beneficios proporcionado por el MINEDUC. En caso de que 
                              aún no lo hayas hecho, puedes encontrarlo en 
                              <a href="https://portal.beneficiosestudiantiles.cl/sites/default/files/formulario_suspensiones_2023_v2.pdf" target="_blank">
                                https://portal.beneficiosestudiantiles.cl/sites/default/files/formulario_suspensiones_2023_v2.pdf
                              </a>. Rellenar este formulario es un requisito imprescindible, ya que en el siguiente paso te solicitaremos 
                              adjuntarlo junto con otra información relevante. Posteriormente, estos datos serán enviados al MINEDUC 
                              para que procesen tu solicitud de suspensión de beneficios.
                            </p>
                                 
                            <div class="contenedor-imagenes-formulario-beneficios">
                              <img src="img/formulario_MINEDUC_1.png">
                              <img src="img/formulario_MINEDUC_2.png">
                            </div>
                            <p class="remitente text-center negrita mb-4 mt-2">Formulario de Suspensión de Beneficios del MINEDUC.</p>

                            <p>De antemano agradecemos tu colaboración. Ante cualquier duda con respecto a la suspensión de tus beneficios, no dudes en 
                              comunicarte con nuestro equipo al correo electrónico <span class="negrita">bienestarestudiantil@uct.cl</span>, que 
                              está disponible para ayudarte.
                            </p>

                            <p class="remitente">Atentamente,<br>
                              Dirección de Bienestar Estudiantil<br>
                              <span class="negrita">Universidad Católica de Temuco</span>
                            </p>

                            <div class="container mt-5 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-regresar-suspension-academica" data-step="2">
                                  <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                                </button>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-suspension2" data-step="1">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </section>
                      </article>


                      <!--Suspension de Beneficios-->
                      <article class="card paso-suspensiones" id="suspension-beneficios1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Solicitud de suspensión de beneficios (2/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-0">
                          <form class="p-3 formulario-llenar">
                            <div class="form-group row">
                              <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-suspensiones-beneficios-desplegable" aria-expanded="true" aria-controls="detalles-suspensiones-beneficios-desplegable">
                                      <i class="fa-solid fa-piggy-bank m-icono icono-subapartado"></i> Beneficios actuales<span class="obligatorio">(*)</span>
                                    </button>
                                  </h2>
                                  <div id="detalles-suspensiones-beneficios-desplegable" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body p-0">
                                      <div class="form-group row mt-2">
                                        <div class="form-group row col-12">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Beneficios a suspender <span class="obligatorio">(*)</span>
                                          </label>
                                          <div class="col-12">
                                            <!--Lista de Motivos-->
                                            <div class="table-responsive tabla-institucional">
                                              <table class="table tabla-motivos">
                                                <thead>
                                                  <tr>
                                                    <th>Beneficio</th>
                                                    <th style="width: 14rem">Suspender</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>GRATUIDAD ARANCEL MINEDUC</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>GRATUIDAD MATRICULA MINEDUC</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>BRECHA GRATUIDAD ARANCEL UCT</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>TARJETA ALIMENTACION</td>
                                                    <td>
                                                      <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                          <label class="form-check-label" for="flexRadioDefault1">
                                                            Si
                                                          </label>
                                                        </div>

                                                        <div class="form-check mx-3">
                                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                          <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>

                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-4 mb-3">
                                        <div class="form-group row col-12">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            Cargar formulario MINEDUC <span class="obligatorio">(*)</span>
                                          </label>
                                          <p class="parrafo-info col-12">El archivo debe de estar en formato PDF y por nombre tiene que llevar 
                                            por nomenclatura RUT-Formulario.pdf. <span class="rojo">Ejemplo: 11222333-Formulario.pdf</span>.
                                          </p>
                                          <div class="col-12">
                                            <input class="form-control form-control-sm" id="formFileSm" type="file">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row mt-4 mb-3">
                                        <div class="form-group row col-6">
                                          <label for="inputPassword" class="col-form-label col-12">
                                            N° de solicitudes de suspensión realiazas anteriormente
                                          </label>
                                          <div class="col-12">
                                            <input class="form-control form-control-sm" id="formFileSm" type="text" disabled value="3">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="container mt-3 d-flex justify-content-center">
                              <div>
                                <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-aviso-suspension-beneficios1" data-step="3">
                                  <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                                </button>
                                <button class="boton boton-azul pl-3 boton-secuencia boton-continua" type="button" id="btn-continuar-confirmacion1" data-step="2">
                                  Continuar <i class="fa-solid fa-caret-right"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </section>
                      </article>

                      <!--Confirmación-->
                      <article class="card paso-suspensiones" id="suspension-confirmacion1">
                        <section class="card-header titulo-formulario p-0">
                          <h4>Confirmación de los datos (3/3)</h4>
                        </section>
                        <!--Cuerpo del formulario-->
                        <section class="card-body p-5 mensaje-bienvenida">
                          <div class="contenedor-logo logo-uct">
                            <img class="logo" src="./img/logo_uct.png"/>
                          </div>

                          <p class="text-uppercase rojo negrita">Importante</p>
                          <p>
                            <?php echo $sexoAlumno==2? "Estimada ".$primerNombreAlumno.",":"Estimado ".$primerNombreAlumno.","; ?>
                          </p>
                          <p>Antes de proceder, queremos asegurarnos de que todos los datos ingresados sean precisos y 
                            válidos. Tu seguridad y la integridad de la información son nuestras prioridades.</p>

                          <p>Al hacer clic en el botón de confirmación a continuación, afirmas y garantizas que:</p>
                          <ul>
                            <li>La información proporcionada es precisa y refleja tu situación actual.</li>
                            <li>Has revisado cuidadosamente todos los detalles antes de confirmar.</li>
                            <li>Asumes la responsabilidad de cualquier consecuencia derivada de la información proporcionada.</li>
                          </ul>
                          
                          <p>Por favor, toma un momento para repasar la información ingresada y asegurarte de su 
                            exactitud.</p> 

                          <p>Botón de Confirmación: <span class="negrita">[Confirmar Datos]</span></p>

                          <p>Al confirmar, aceptas que la información proporcionada es correcta y estás de acuerdo 
                            con los términos y condiciones establecidos. Gracias por tu cooperación y compromiso 
                            con la precisión de los datos.</p>

                          <p class="remitente">Atentamente,<br>
                            <span class="negrita">Universidad Católica de Temuco</span>
                          </p>

                          <div class="container mt-3 d-flex justify-content-center">
                            <div class="mt-3">
                              <button class="boton boton-azul boton-secuencia boton-regresa" type="button" id="btn-regresar-suspension-beneficios1" data-step="3">
                                <i class="fa-solid fa-caret-left m-icono"></i>Regresar
                              </button>
                              <button class="boton boton-verde btn-success pl-3">
                                <i class="fa-solid fa-check m-icono"></i>Confirmar datos
                              </button>
                            </div>
                          </div>
                        </section>
                      </article>
                    </div>

                    <!--Seccion de reincorporacion-->
                    <div id="seleccion-reincorporacion" class="seleccion-tipo-solicitud container-fluid">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item rounded-0">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed b-apartado" type="button" data-bs-toggle="collapse" data-bs-target="#segundoApartado" aria-expanded="true" aria-controls="segundoApartado">
                <i class="fa-solid fa-list-check m-icono"></i> Resultados de la Solicitud
              </button>
            </h2>
            <div id="segundoApartado" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>
        </div>
      </article>
    </section>
  </main>
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/app.js"></script>
</body>
</html>