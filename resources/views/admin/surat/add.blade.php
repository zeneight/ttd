@extends('crudbooster::admin_template')
@section('content')
<style>
    .select2-container--default .select2-selection--single {
        border-radius: 0px !important
    }
    .select2-container .select2-selection--single {
        height: 35px
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3c8dbc !important;
        border-color: #367fa9 !important;
        color: #fff !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
    }
    .spin {
        display: none;
    }
</style>

<p><a title='Return' href="{{ crudbooster::adminPath() }}"><i class='fa fa-chevron-circle-left '></i>
        &nbsp; Kembali</a></p>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><i class="fa fa-road"></i> Tambah Data</strong>
    </div>

    <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data"
        action="{{ crudbooster::mainpath('add-save') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="panel-body">
            
            <hr>

            {{ form_input("Tanggal Input", "tgl_input", "date", 6, "", "required") }}

            {{ form_start_combobox("Aplikasi", "app_id", 6, "", "required", "select2") }}
            @foreach ($aplikasi as $item)
                <option value="{!! $item->id !!}">{!! $item->val !!}</option>
            @endforeach
            {{ form_end_combobox() }}

            <hr>
            {{ form_textarea("Keterangan", "keterangan", "", "required", "") }}
            {{ form_start_combobox("Status", "status", 6, "", "required", "select2") }}
                <option value="0">Tidak Aktif</option>
                <option value="1">Aktif</option>
            {{ form_end_combobox() }}

        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" value="{{trans('crudbooster.button_save_more')}}"
                class='btn btn-success'>
            <input type="submit" name="submit" class="btn btn-primary" value="Save Data">
        </div>
    </form>
</div>
@endsection