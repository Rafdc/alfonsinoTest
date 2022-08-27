@extends('layouts.app')

@section('title', 'Form Partner')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profilo {{ $partner->titolo }}</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ Storage::url($partner->foto) }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $partner->titolo }}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>E-mail</b> <span class="float-right">{{ $partner->mail }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Telefono</b> <span class="float-right">{{ $partner->recapito }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#prodotti" data-toggle="tab">Prodotti</a></li>
                                <li class="nav-item"><a class="nav-link" href="#ordini" data-toggle="tab">Ordini</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="prodotti">
                                    <table class="table table-bordered table-hover data-table nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Prodotto</th>
                                                <th>Prezzo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prodottiAssociatiList as $singleProdotto)
                                                <tr>
                                                    <td>{{ $singleProdotto->nome_prodotto }}</td>
                                                    <td>{{ $singleProdotto->prezzo }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="ordini">
                                    <div class="tab-content" id="ordini">
                                        <table class="table table-bordered table-hover data-table nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Totale</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ordini as $singleOrdine)
                                                    <tr>
                                                        <td>{{ $singleOrdine->nome.' '.$singleOrdine->cognome }}</td>
                                                        <td>{{ $singleOrdine->totale }}</td>
                                                        <td>
                                                            <a href="{{ route('detailOrdine', $singleOrdine->id) }}" data-toggle="tooltip" data-placement="top" title="Visualizza"><i class="fa fa-eye text-primary mr-3"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.tab-content -->
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
            </div>
        </div>
    </section>
@endsection
@push('third_party_scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                autoWidth: false,
                responsive: true
            });
        });
    </script>
@endpush