<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // modul configuration
        /*
        | ---------------------------------------------------------------------- 
        | Add css style at body 
        | ---------------------------------------------------------------------- 
        | css code in the variable 
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = "
            .kbw-signature { 
                width: 50%; height: 200px;
            }
            #sig canvas{ 
                width: 100% !important; height: auto;
            }
        ";

        $this->load_css = array();
        $this->load_css[] = asset('vendor/crudbooster/assets/select2/dist/css/select2.min.css');
        $this->load_css[] = "//keith-wood.name/css/jquery.signature.css";
        // $this->load_css[] = asset('css/custom.css');


        /*
        | ---------------------------------------------------------------------- 
        | Add javascript at body 
        | ---------------------------------------------------------------------- 
        | javascript code in the variable 
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = "
            // lokal
            

            // select
            $('.select2').select2();
        ";

        /*
        | ---------------------------------------------------------------------- 
        | Include Javascript File 
        | ---------------------------------------------------------------------- 
        | URL of your javascript each array 
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();
        $this->load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");
    }

    public function getIndex()
    {
        //First, Add an auth
        if (CRUDBooster::me() == null) {
            CRUDBooster::redirect(CRUDBooster::adminPath('login'), 'Login terlebih dahulu', 'danger');
            exit();
        }

        //Create your own query 
        $data = [];
        $data['page_title'] = "Dashboard";

        // get total
        $total = DB::table("surats")->count();

        // get sudah
        $sudah = DB::table("surats")->select('id')->where('status', '=', 1)->count();
        // get belum
        $belum = DB::table("surats")->select('id')->where('status', '=', 0)->count();

        // ----------------
        $jenis = [];
        $kategoris = DB::table("categories")->select('judul', 'id')->get();

        foreach($kategoris as $key => $kt) {
            $jenis[$key]['judul'] = $kt->judul;

            $count = DB::table("surats")->select('id')->where('kat_id', '=', $kt->id)->count();
            $jenis[$key]['jml'] = $count;
        }
        
        $data['total'] = $total;
        $data['sudah'] = $sudah;
        $data['belum'] = $belum;
        $data['kategori'] = $jenis;

        return $this->view('admin/dashboard', $data);
    }
}