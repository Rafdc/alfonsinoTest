@extends('layouts.app')

@section('title', 'Lista Prodotti')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <h1>Lista Ordini</h1>
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
                    <div class="callout callout-info">
                        <p>In questa pagina puoi visualizzare tutti gli ordini efettuati</p>
                        <h6>Legenda Simboli:</h6>
                        <ul>
                            <li><i class="fa fa-eye text-primary mr-2"></i>Visualizza il dettaglio dell'Ordine</li>
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
                                        <th>Cliente</th>
                                        <th>Totale</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordini as $singleOrdine)
                                        <tr>
                                            <td>{{ $singleOrdine->partner }}</td>
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
            </div><!--end row-->
        </div><!--end container fluid-->
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