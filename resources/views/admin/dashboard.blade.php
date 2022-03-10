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

        TESTEST

    </div>
</div>
@endsection