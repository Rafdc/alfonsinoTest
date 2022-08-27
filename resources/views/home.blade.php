@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- end col -->
                    <div class="col-sm-6">
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container-fluid -->
        </div>
        <!-- end content-header -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $arrayCount['partner'] }}</h3>
        
                            <p>Partner</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('showPartner') }}" class="small-box-footer">Partner <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $arrayCount['prodotti'] }}</h3>
        
                            <p>Prodotti</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('showProdotti') }}" class="small-box-footer">Prodotti <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $arrayCount['prodotti'] }}</h3>
        
                            <p>Ordini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('showOrdini') }}" class="small-box-footer">Ordini <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </section><!-- end content -->
@endsection
