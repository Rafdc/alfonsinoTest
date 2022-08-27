@extends('layouts.app')

@section('title', 'Form Partner')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary">{{ count(Request::segments()) == 2 ? 'Crea Listino' : 'Aggiorna Listino' }} per Partner: {{ $partnerData->titolo }}</h1>
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
                    @elseif(session()->get('danger_inserimento'))
                        <div class="alert alert-danger alert-dismissible">
                            {{ session()->get('danger_inserimento') }}
                        </div>
                    @endif
                    <div class="callout callout-info">
                        <p>
                            Compilare il form per associare un prodotto ad un partner
                        </p>
                        <span class="text-sm">*Campi obbligatori</span>
                    </div>
                </div><!--end col 12-->

                <div class="col-sm-12">
                    <div class="card">

                        <form method="POST" action="{{ route('createListino') }}">
                            @csrf

                            <div class="card-body">
                                <x-input type="hidden" for="ext_id_partner" value="{{ isset($partnerData->external_id) ? $partnerData->external_id : '' }}"></x-input>
                                <x-input type="hidden" for="id_prod_assoc" value="{{ isset($prodottoAssociato->id) ? $prodottoAssociato->id : '' }}"></x-input>
                                <div class="form-group">
                                    <x-label for="prodotto_id">Seleziona Prodotto*</x-label>
                                    <select id="prodotto_id" name="prodotto_id" class="form-control" required>
                                        @foreach($prodottiList as $extId => $titolo)
                                            <option value="{{ $extId }}" {{ isset($prodottoAssociato->prodotto_id) ? (($extId == $prodottoAssociato->prodotto_id) ? 'selected' : '') : '' }}>{{ $titolo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <x-label for="prezzo">Prezzo*</x-label>
                                    <x-input type="text" for="prezzo" value="{{ old('prezzo', isset($prodottoAssociato->prezzo) ? $prodottoAssociato->prezzo : '' ) }}" required></x-input>
                                    <x-errormsg for="number"></x-errormsg>
                                </div>
                                @error('prodotto_id')
                                <br>
                                <span class="text-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="card-footer">
                                <x-btn typeBtn="default" href="{{ route('showPartner') }}">Annulla</x-btn>
                                <x-btnsubmit class="float-right">{{ count(Request::segments()) == 2 ? 'Associa Prodotto' : 'Carica Prodotto' }}</x-btnsubmit>
                            </div>
                        </form>

                    </div><!--end card-->
                </div><!--end col 12-->

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover data-table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Prodotto</th>
                                        <th>Prezzo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prodottiAssociatiList as $singleProdotto)
                                        <tr>
                                            <td>{{ $singleProdotto->nome_prodotto }}</td>
                                            <td>{{ $singleProdotto->prezzo }}</td>
                                            <td>
                                                <a href=" {{ route('listino', ['idPartner' => $partnerData->external_id, 'idProdottoAssociato' => $singleProdotto->id_associazione]) }}" data-toggle="tooltip" data-placement="top" title="Modifica"><i class="fa fa-edit text-warning mr-3"></i></a>
                                                <a href=" {{ route('deleteAssociazioneProdotto', ['idPartner' => $partnerData->external_id, 'idProdottoAssociato' => $singleProdotto->id_associazione]) }}" onclick="return confirm('Procedere con la cancellazione del prodotto associato partner?')" data-toggle="tooltip" data-placement="top" title="Elimina"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                autoWidth: false,
                responsive: true
            });
        });
    </script>
@endpush