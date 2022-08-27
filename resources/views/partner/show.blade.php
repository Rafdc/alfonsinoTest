@extends('layouts.app')

@section('title', 'Lista Partner')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <h1>Lista Partner</h1>
                </div>
            <div class="col-md-6 col-sm-12 ">
                <x-btn typeBtn="primary" class="float-right" href="{{ route('formPartner') }}">Crea Partner</x-btn>
            </div>
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </section>
    <!--End Content Header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success alert-dismissible">
                            {{ session()->get('success') }}
                        </div>
                    @elseif(session()->get('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            {{ session()->get('warning') }}
                        </div>
                    @elseif(session()->get('danger'))
                        <div class="alert alert-danger alert-dismissible">
                            {{ session()->get('danger') }}
                        </div>
                    @endif
                    <div class="callout callout-info">
                        <p>In questa pagina puoi visualizzare tutti i partner inseriti</p>
                        <h6>Legenda Simboli:</h6>
                        <ul>
                            <li><i class="fas fa-book text-orange mr-2"></i>Associa prodotti al Partner</li>
                            <li><i class="fa fa-eye text-primary mr-2"></i>Visualizza il profilo del Partner</li>
                            <li><i class="fa fa-edit text-warning mr-2"></i>Modifica il Partner</li>
                            <li><i class="fa fa-trash text-danger mr-2"></i>Elimina il Partner</li>
                        </ul>
                    </div>
                </div><!--end col 12-->

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover data-table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Partner</th>
                                        <th>Email</th>
                                        <th>Recapito</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div><!--end card-->
                </div><!--end col 12-->
            </div><!--end row-->
        </div><!--end container fluid-->
    </section>
    <!--End Main Content -->

    
@endsection
@push('third_party_scripts')
    <script type="text/javascript">
    $(function () {
        
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('showPartner') }}",
            columns: [
                {data: 'titolo', name: 'titolo'},
                {data: 'mail', name: 'mail'},
                {data: 'recapito', name: 'recapito'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
    </script>
@endpush