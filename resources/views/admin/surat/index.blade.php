<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Surat sudah ditandatangani</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Surat belum ditandatangani</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <table id="example" class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th style="width:2%;text-align:right"></th>
                            <th>Judul</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="tab_2">
                <table id="belum" class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th style="width:2%;text-align:right"></th>
                            <th>Judul</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


        </div>

    </div>
    
</div>
@endsection
