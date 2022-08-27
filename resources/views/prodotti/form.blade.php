@extends('layouts.app')

@section('title', 'Form Partner')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary">{{ count(Request::segments()) == 2 ? 'Crea Nuovo Prodotto' : 'Aggiorna Prodotto' }}</h1>
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
                    @if(session()->get('danger'))
                        <div class="alert alert-danger alert-dismissible">
                            {{ session()->get('danger') }}
                        </div>
                    @endif
                    <div class="callout callout-info">
                        <p>
                            Compilare il form per inserire un nuovo prodotto.<br>
                            Regole per caricare il file: non deve superare i <b>5MB</b> e deve essere nel formato: <b>JPG, JPEG, PNG</b>
                        </p>
                        <span class="text-sm">*Campi obbligatori</span>
                    </div>
                </div><!--end col 12-->

                <div class="col-sm-12">
                    <div class="card">
                        <form method="POST" action="{{ route('addOrUpdateProdotto') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <x-input type="hidden" for="ext_id" value="{{ isset($prodottoData->external_id) ? $prodottoData->external_id : '' }}"></x-input>
                                <x-input type="hidden" for="path_image" value="{{ isset($prodottoData->foto) ? $prodottoData->foto : ' ' }}"></x-input>
                                <div class="form-group">
                                    <x-label for="titolo">Nome*</x-label>
                                    <x-input for="titolo" value="{{ old('titolo', isset($prodottoData->titolo) ? $prodottoData->titolo : '' ) }}" required></x-input>
                                    <x-errormsg for="titolo"></x-errormsg>
                                </div>
                                <div class="form-group">
                                    <x-label for="image">Carica Foto</x-label><br>
                                    <input type="file" id="image" name="image">
                                    <x-errormsg for="image"></x-errormsg>
                                    @error('image')
                                    <br>
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <x-btn typeBtn="default" href="{{ route('showProdotti') }}">Annulla</x-btn>
                                <x-btnsubmit class="float-right">{{ count(Request::segments()) == 2 ? 'Crea' : 'Aggiorna' }}</x-btnsubmit>
                            </div>
                        </form>
                    </div><!--end card-->
                </div><!--end col 12-->
            </div><!--end row-->
        </div><!--end container fluid-->
    </section>
    <!--End Main Content -->
@endsection