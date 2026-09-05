@extends('layout.admin')
@section('titulo', 'Crear Paquete - Magic Tours')
@section('css')
    <link href="{{ asset('assets-admin/vendors/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('contenido')
    <br><br><br><br>
    <div class="page-header pl-5">
        <h2 class="header-title">Administrador</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Dashboard</a>
                <a class="breadcrumb-item" href="{{ route('admin.paquetes') }}">Editando Paquetes</a>
                <span class="breadcrumb-item active">{{ $paquete->titulo }}</span>
            </nav>
        </div>
    </div>


    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.paquetes.update', $paquete->id) }}">

        @csrf
        @method('PUT')    
        <div class="card">
            <div class="card-body">
                <h4>Formulario de creación de paquete</h4>

                <div class="row">
                    <div class="col-12 col-md-6 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Título del paquete</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Título del paquete" name="titulo" required value="{{ $paquete->titulo }}">
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Duración del paquete</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Duración del paquete" name="duracion" required value="{{ $paquete->duracion }}">
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Cantidad de personas</span>
                        </div>
                        <input type="number" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Precio del paquete" name="can_personas" required value="{{ $paquete->can_personas }}">
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Tipo</span>
                        </div>
                        <select class="select2 form-control" name="tipo">
                            
                            <option value="tour" @if($paquete->tipo == 'tour') selected @endif>Tour</option>
                            <option value="paquete" @if($paquete->tipo == 'paquete') selected @endif>Paquete</option>
                            <option value="treks" @if($paquete->tipo == 'treks') selected @endif>Caminata>Caminata</option>
                            <option value="diferente" @if($paquete->tipo == 'diferente') selected @endif>Algo Diferente</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Dificultad</span>
                        </div>
                        <select class="select2 form-control" name="dificultad">
                            <option value="baja" @if($paquete->dificultad == 'baja') selected @endif>Baja</option>
                            <option value="media" @if($paquete->dificultad == 'media') selected @endif>Media</option>
                            <option value="alta" @if($paquete->dificultad == 'alta') selected @endif>Alta</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Estado</span>
                        </div>
                        <select class="select2 form-control" name="estado">
                            <option value="activo" @if($paquete->estado == 'activo') selected @endif>Activo</option>
                            <option value="inactivo" @if($paquete->estado == 'inactivo') selected @endif>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Categoría</span>
                        </div>
                        <select class="select2 form-control" name="categoria_id">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $categoria->id == $paquete->categoria_id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Altitud</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Altitud" name="altitud" required value="{{ $paquete->altitud }}">
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Ubicación</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Ubicación" name="ubicacion" required value="{{ $paquete->ubicacion }}">
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Precio</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="Precio" name="precio" required value="{{ $paquete->precio }}">
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Imagen Principal</span>
                        </div>
                        <!-- Input file -->
                        <input type="file" class="form-control" id="imageInput" aria-describedby="basic-addon3"
                            placeholder="imagen" name="imagen"  accept="image/*">

                        <!-- Imagen de previsualización -->
                        <div class="mt-3">
                            <img id="imagePreview"
                                src="{{ Storage::url( $paquete->imagen) }}"
                                class="img-fluid" alt="Previsualización de imagen" />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Video Adjunto</span>
                        </div>
                        <input type="file" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="video_adjunto" name="adj_video" accept="video/*">
                        <!-- Imagen de previsualización -->
                        <div class="mt-3">
                            <img src="https://static.vecteezy.com/system/resources/previews/007/567/154/non_2x/select-image-icon-vector.jpg"
                                class="img-fluid" alt="Previsualización de imagen" />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">PDF adjunto</span>
                        </div>
                        <input type="file" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            placeholder="pdf_adjunto" name="adj_pdf" accept="application/pdf">
                        <!-- Imagen de previsualización -->
                        <div class="mt-3">
                            <img src="https://static.vecteezy.com/system/resources/previews/007/567/154/non_2x/select-image-icon-vector.jpg"
                                class="img-fluid" alt="Previsualización de imagen" />
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <h4>Descripción del Paquete</h4>
                        <div id="editor"> {!! $paquete->descripcion  !!} </div> 
                        <input type="hidden" name="descripcion" id="descripcion">
                    </div>
                </div>

            </div>
        </div>




        <div class="card">
            <div class="col-12 col-md-12 input-group mb-3">
                <input type="submit" value="Editar Paquete" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>




    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Obtener el primer archivo seleccionado

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src =
                    "https://static.vecteezy.com/system/resources/previews/007/567/154/non_2x/select-image-icon-vector.jpg";
            }
        });
    </script>


@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('assets-admin/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets-admin/js/pages/form-elements.js') }}"></script>
    <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Verificar si el editor ya ha sido inicializado
            if (document.getElementById('editor') && !window.quillDescripcion) {
                // Inicializa Quill solo si no está inicializado aún
                var quillDescripcion = new Quill('#editor', {
                    theme: 'bubble', // Cambia el tema si lo necesitas
                    
                });
    
                // Guarda el contenido de Quill en el input de descripcion cuando se cambia el texto
                quillDescripcion.on('text-change', function() {
                    document.getElementById('descripcion').value = quillDescripcion.root.innerHTML;
                });
    
                // Verificar que el valor de 'descripcion' se actualice correctamente antes de enviar el formulario
                document.querySelector('form').onsubmit = function(event) {
                    var descripcion = document.getElementById('descripcion');
                    
                };
    
                // Guardamos la instancia de quill en la ventana global para evitar duplicados
                window.quillDescripcion = quillDescripcion;
            }
        });
    </script>
@endsection
