<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->
<div class="box">
    <div class="box-body">
        <div class="col-md-12">
            <div class="pull-left"><br></div>
            <div class="pull-right"></div>
        </div>
        
        <div class="col-md-12">
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
    </div>
</div>
@endsection