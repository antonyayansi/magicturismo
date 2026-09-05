@extends('layout.admin')
@section('titulo', 'Dashboard')
@section('contenido')
    <div class="page-container">
        <!-- Content Wrapper START -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h4>Agregando paquete Turístico</h4>
                    <form action="" method="POST">
                        @csrf
                        <div class="row pt-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="titulo">Titulo</label>
                                    <input type="text" class="form-control" placeholder="Titulo" name="titulo" id="titulo"
                                        value="{{ old('titulo') }}">
                                    @error('titulo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editor">Descripción</label>
                                    <div>
                                        <div id="editor-es"> </div>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion"
                                            style="display: none;">
                                    </div>
                                    @error('descripcion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="tipo">Tipo </label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value="paquete">Paquete </option>
                                        <option value="tour">Tours </option>
                                        <option value="treks">Caminatas </option>
                                    </select>
                                    @error('tipo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="tipo">Duracion </label>
                                    <input type="text" class="form-control" value="1 dia" placeholder="días" name="duracion"
                                        value="{{ old('duracion') }}">
                                    @error('duracion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="categoria">Categoria </label>
                                    <select name="categoria" id="categoria" class="form-control">
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                        <option value="paquete">Paquete </option>
                                    </select>

                                    @error('categoria')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicacion <strong>Google Maps</strong></label>
                                    <input type="text" class="form-control" placeholder="Ubicacion" name="ubicacion"
                                        id="ubicacion" value="{{ old('ubicacion') }}">
                                    @error('ubicacion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                    <div class="accordion mt-4" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Incluye / No incluye
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="tipo">Tipo </label>
                                                    <select name="tipo" id="tipo" class="form-control">
                                                        <option value="incluido">Incluye </option>
                                                        <option value="no_incluido">No incluye </option>
                                                    </select>
                                                    @error('tipo')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-9">
                                                <div class="form-group">
                                                    <label for="incluye">Incluye</label>
                                                    <input type="text" class="form-control" placeholder="Incluye"
                                                        name="incluye" id="incluye" value="{{ old('incluye') }}">
                                                    @error('incluye')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Galeria
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-9">
                                                    <div class="form-group">
                                                        <label for="imagen">Imagen</label>
                                                        <input type="file" class="form-control" placeholder="Imagen"
                                                            name="imagen" id="imagen" value="{{ old('imagen') }}">
                                                        @error('imagen')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="{{ asset('assets-admin/vendors/quill/quill.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Declara las instancias globalmente
            var quillDescripcion, quillDescripcionEn, quillPlan, quillPlanEn;

            $(document).ready(function () {
                // Inicializa las instancias de Quill Editor
                quillDescripcion = new Quill('#editor-es', {
                    theme: 'snow' // Cambia el tema si lo necesitas
                });

                // Actualiza el valor de los inputs al cambiar los editores
                quillDescripcion.on('text-change', function () {
                    document.getElementById('descripcion').value = quillDescripcion.root.innerHTML;
                });


            });


            function generateSlug(text) {
                return text
                    .toLowerCase() // Convertir a minúsculas
                    .trim() // Eliminar espacios al inicio y al final
                    .replace(/[^a-z0-9\s-]/g, '') // Eliminar caracteres especiales
                    .replace(/\s+/g, '-') // Reemplazar espacios por guiones
                    .replace(/-+/g, '-'); // Eliminar guiones repetidos
            }

            // Vincula el título con el slug
            document.getElementById('titulo').addEventListener('input', function () {
                const slug = generateSlug(this.value); // Genera el slug
                document.getElementById('slug').value = slug; // Asigna al input de slug
            });
        </script>
    </div>
@endsection