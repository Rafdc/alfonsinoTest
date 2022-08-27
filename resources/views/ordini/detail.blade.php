@extends('layouts.app')

@section('title', 'Lista Prodotti')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="callout callout-info">
                        <h5>Ordine Cliente {{ $ordine->nome.' '.$ordine->cognome }}</h5>
                    </div>
                </div><!--end col 12-->

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="lead">Ordine creato il {{ $ordine->created_at->format('d-m-Y H:i:s') }}</p>

                            <div class="table-responsive">
                                <table class="table">
                                    @foreach($dettaglioOrdine as $singleDettaglio)
                                        <tr>
                                            <th>{{ $singleDettaglio->prodotto }}</th>
                                            <td>{{ $singleDettaglio->prezzo }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Totale</th>
                                        <td>{{ $ordine->totale }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div><!--end card-->
                </div><!--end col 12-->
            </div><!--end row-->
        </div><!--end container fluid-->
    </section>
@endsection