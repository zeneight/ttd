<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <div class="col-md-12">
        @if($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <section class="content">

        <div class="row">
                <div class="col-lg-offset-4 col-lg-4 col-xs-12">

                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $total }}</h3>
                            <p>Total Surat</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>

                

            </div>

            <div class="row">
                

                <div class="col-lg-offset-3 col-lg-3 col-xs-6">

                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$sudah}}</h3>
                            <p>Sudah Di-tandatangani</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">

                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$belum}}</h3>
                            <p>Belum Di-tandatangani</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>

            </div>


            <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tag"></i> Jenis Surat</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach($kategori as $jn)
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-default"><i class="fa fa-envelope-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{$jn['judul']}}</span>
                                    <span class="info-box-number">{{$jn['jml']}}</span>
                                </div>

                            </div>

                        </div>
                        @endforeach


                    </div>

                </div>

            </div>




        </section>

    </div>
</div>
@endsection
