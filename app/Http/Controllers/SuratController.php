<?php
namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Storage;
use QrCode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use URL;

class SuratController extends Controller
{
    public function index($data)
    {
        $file = public_path().DIRECTORY_SEPARATOR.'surat'.DIRECTORY_SEPARATOR.$data.'-ttd.pdf';
		$file = File::get($file);
		
		$response = Response::make($file,200);
		$response->header('Content-Type', 'application/pdf');
		return $response;	
    }
    
}