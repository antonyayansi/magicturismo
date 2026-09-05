@extends('layout.admin')
@section('titulo', 'Carrusel - Magic Tours')

@section('contenido')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12 mt-5 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0">LISTA DE Carrusels</h1>
                    <!-- Botón para abrir el modal -->
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#carouselModal">Agregar Video al
                        Carrusel</a>

                    <!-- Modal -->
                    <div class="modal fade" id="carouselModal" tabindex="-1" role="dialog"
                        aria-labelledby="carouselModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="carouselModalLabel">Agregar Video al Carrusel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario -->
                                    <form action="{{ route('admin.carrusel.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- Tipo de contenido (Video o Imagen) -->
                                        <div class="form-group">
                                            <label for="tipo">Tipo de contenido</label>
                                            <select class="form-control" id="tipo" name="tipo" required>
                                                <option value="video">Video</option>
                                                <option value="imagen">Imagen</option>
                                            </select>
                                        </div>

                                        <!-- URL (Archivo) -->
                                        <div class="form-group">
                                            <label for="file">URL (Archivo)</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                accept="video/*, image/*" required>
                                        </div>

                                        <!-- Título -->
                                        <div class="form-group">
                                            <label for="titulo">Título</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo"
                                                required>
                                        </div>

                                        <!-- Subtítulo -->
                                        <div class="form-group">
                                            <label for="subtitulo">Subtítulo</label>
                                            <input type="text" class="form-control" id="subtitulo" name="subtitulo"
                                                required>
                                        </div>

                                        <!-- Texto opcional -->
                                        <div class="form-group">
                                            <label for="texto">Texto (opcional)</label>
                                            <textarea class="form-control" id="texto" name="texto" rows="3"></textarea>
                                        </div>

                                        <!-- URL del botón (opcional) -->
                                        <div class="form-group">
                                            <label for="url_boton">URL del botón (opcional)</label>
                                            <input type="url" class="form-control" id="url_boton" name="url_boton">
                                        </div>

                                        <!-- Botones -->
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{--  <div class="col-12 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Buscar Paquete</h3>
                </div>

                <!-- Formulario de búsqueda -->
                <form action="{{ route('paquetes.search') }}" method="GET">
                    <div class="input-group my-3">
                        <input type="text" class="form-control" name="search" placeholder="Buscar Paquete"
                            aria-label="Buscar Paquete">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>

                <!-- Mostrar resultados de la búsqueda -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4 class="mb-0">Resultados: <span class="badge badge-info">{{ $carrus->count() }}</span></h4>
                </div>

               
            </div> --}}


            <div class="col-12 mt-3 card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Url</th>
                                <th scope="col">Subtitulo</th>
                                <th scope="col">Botón</th>

                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carrusels as $carru)
                                <tr>
                                    <td scope="row" class="text-uppercase">{{ $carru->titulo }}</td>
                                    <td>{{ $carru->tipo }}</td>
                                    <td>{{ $carru->url }}</td>
                                    <td>{{ $carru->subtitulo }}</td>
                                    <td>{{ $carru->boton ?? 'N/A' }}</td>

                                    <td>
                                        <!-- Botón de edición -->
                                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editModal" data-id="{{ $carru->id }}"
                                            data-titulo="{{ $carru->titulo }}" data-subtitulo="{{ $carru->subtitulo }}"
                                            data-texto="{{ $carru->texto }}" data-url="{{ $carru->url_boton }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <!-- Modal de edición -->
                                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Editar Carrusel</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Formulario de edición -->
                                                        <form action="{{ route('admin.carrusel.update', $carru->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT') <!-- Método PUT para la actualización -->

                                                            <!-- Tipo de contenido (Video o Imagen) -->
                                                            <div class="form-group">
                                                                <label for="tipo">Tipo de contenido</label>
                                                                <select class="form-control" id="tipo"
                                                                    name="tipo" required>
                                                                    <option value="video">Video</option>
                                                                    <option value="imagen">Imagen</option>
                                                                </select>
                                                            </div>

                                                            <!-- URL (Archivo) -->
                                                            <div class="form-group">
                                                                <label for="file">URL (Archivo)</label>
                                                                <input type="file" class="form-control" id="file"
                                                                    name="file" accept="video/*, image/*">
                                                            </div>

                                                            <!-- Título -->
                                                            <div class="form-group">
                                                                <label for="titulo">Título</label>
                                                                <input type="text" class="form-control" id="titulo"
                                                                    name="titulo" required>
                                                            </div>

                                                            <!-- Subtítulo -->
                                                            <div class="form-group">
                                                                <label for="subtitulo">Subtítulo</label>
                                                                <input type="text" class="form-control" id="subtitulo"
                                                                    name="subtitulo" required>
                                                            </div>

                                                            <!-- Texto opcional -->
                                                            <div class="form-group">
                                                                <label for="texto">Texto (opcional)</label>
                                                                <textarea class="form-control" id="texto" name="texto" rows="3"></textarea>
                                                            </div>

                                                            <!-- URL del botón (opcional) -->
                                                            <div class="form-group">
                                                                <label for="url_boton">URL del botón (opcional)</label>
                                                                <input type="url" class="form-control" id="url_boton"
                                                                    name="url_boton">
                                                            </div>

                                                            <!-- Botones -->
                                                            <button type="submit"
                                                                class="btn btn-primary">Actualizar</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <form action="{{ route('admin.carrusel.destroy', $carru->id) }}" method="POST" style="display:inline;" id="deleteForm-{{ $carru->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="return confirmDelete({{ $carru->id }});">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                {{-- Pagination --}}
                {{-- {{ $carru->links() }} --}}
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets-admin/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets-admin/js/pages/dashboard-default.js') }}"></script>
    <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Cuando el modal se abre, carga los datos del carrusel en el formulario
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id'); // ID del carrusel
            var titulo = button.data('titulo');
            var subtitulo = button.data('subtitulo');
            var texto = button.data('texto');
            var url = button.data('url');

            // Asigna los valores al formulario en el modal
            var modal = $(this);
            modal.find('#titulo').val(titulo);
            modal.find('#subtitulo').val(subtitulo);
            modal.find('#texto').val(texto);
            modal.find('#url_boton').val(url);
            modal.find('form').attr('action', '/admin/carrusel/' + id + '/update'); // Cambia la ruta del formulario
        });
    </script>
    @if (session('success'))
        <script>
            // Mostrar el mensaje con SweetAlert2
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}", // El mensaje de éxito de la sesión
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif
    <script>
        function confirmDelete(carruId) {
            // Usar SweetAlert2 para confirmar la eliminación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este carrusel después de eliminarlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario de eliminación
                    document.getElementById('deleteForm-' + carruId).submit(); // Enviar el formulario de eliminación correspondiente
                } else {
                    // Si el usuario cancela, no hacer nada
                    return false;
                }
            });
            return false; // Prevenir el envío inmediato del formulario
        }
    </script>
    
    
@endsection
