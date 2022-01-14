<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->
<!-- <div class="col-md-12 card text-white bg-light mb-3">
    <div class="card-header">Header</div>
    <div class="card-body">
        <h5 class="card-title">Selamat Datang di halaman Admin!</h5>
        <p class="card-text">Silahkan atur dan tambahkan data sesuai pada menu yang ada di sidebar sebelah kiri. Jika ada permasalahan atau hal yang ingin ditanyakan terkait dengan teknis sistem silahkan kirim email ke <a href="mailto:teknis@jengetprabhu.com">teknis@jengetprabhu.com</a>. </p>
    </div>
</div> -->
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
        <form method="POST" action="{{ route('signature.store') }}">
            @csrf
            <div class="col-md-12">
                <label class="" for="">Draw Signature:</label>
                <br/>
                <div id="sig"></div>
                <br><br>
                <button id="clear" class="btn btn-danger">Clear Signature</button>
                <button class="btn btn-success">Save</button>
                <textarea id="signature" name="signed" style="display: none"></textarea>
            </div>
        </form>
    </div>
</div>
@endsection