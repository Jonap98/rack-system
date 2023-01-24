@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-contnet-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h5>Requerimientos</h5>
                    <form action="{{ route('requerimientos.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="ruta" name="ruta" value="3Z">
                        <button type="submit" class="btn btn-primary">
                            Solicitar material
                        </button>
                    </form>
                    {{-- @include('racks.create') --}}
                </div>
                <hr>
                @if(session('success'))
                    <div class="alert alert-success mt-2" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="d-flex justify-content-between">

                </div>

                <div class="container">

                        <div class="row g-2">

                            <div class="card col-md-12 p-2">
                                <table id="requerimientos" class="table table-striped m-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Línea</th>
                                            <th scope="col">Parte</th>
                                            <th scope="col">Ubicación</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Fecha solicitada</th>
                                            <th scope="col">Fecha entrega</th>
                                            <th scope="col">Fecha crítico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requerimientos as $requerimiento)
                                            <tr>
                                                <td>{{ $requerimiento->id }}</td>
                                                <td>{{ $requerimiento->tipo_requerimiento }}</td>
                                                <td>{{ $requerimiento->ubicacion_linea }}</td>
                                                <td>{{ $requerimiento->parte }}</td>
                                                <td>{{ $requerimiento->ubicacion_linea }}</td>
                                                <td>{{ round($requerimiento->cantidad_solicitada, 0) }}</td>
                                                <td>{{ $requerimiento->created_at }}</td>
                                                <td>{{ $requerimiento->created_at }}</td>
                                                <td>{{ $requerimiento->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#requerimientos').DataTable({
                    order: [0, 'desc']
                });
            });
        </script>
    @endsection
    
@endsection