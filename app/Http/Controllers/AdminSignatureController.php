<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use CRUDBooster;
use DB;
use PDF;
use Carbon\Carbon;

class AdminSignatureController extends \crocodicstudio\crudbooster\controllers\CBController
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
            var id_daterangepicker = {
                'direction': 'ltr',
                'format': 'DD/MM/YYYY',
                'separator': ' - ',
                'applyLabel': 'Terapkan',
                'cancelLabel': 'Batal',
                'fromLabel': 'Dari',
                'toLabel': 'Sampai',
                'customRangeLabel': 'Atur',
                'daysOfWeek': [
                    'Min',
                    'Sen',
                    'Sel',
                    'Rab',
                    'Kam',
                    'Jum',
                    'Sab'
                ],
                'monthNames': [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ],
                'firstDay': 1
            };

            // signature
            var sig = $('#sig').signature({syncField: '#signature', syncFormat: 'PNG'});
            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $('#signature').val('');
            });

            // select
            $('.select2').select2();

            // daterange
            var tgl_awal;
            var tgl_akhir;
            $(function() {
                $('input[name=\"jaraktanggal\"]').daterangepicker({
                    locale: id_daterangepicker,
                    opens: 'left'
                }, function(start, end, label) {
                    tgl_awal = start.format('YYYY-MM-DD');
                    tgl_akhir = end.format('YYYY-MM-DD');
                });

                // tgl laporan
                $('input[name=\"tgl_laporan\"]').datepicker( {
                    format: \"dd/mm/yyyy\",
                    autoclose: true
                });
            });

            // date bulan
            $('input[name=\"bulan\"]').datepicker( {
                format: \"mm-yyyy\",
                viewMode: \"months\", 
                minViewMode: \"months\",
                autoclose: true
            });

            // date tahun
            $('input[name=\"tahun\"]').datepicker( {
                format: \"yyyy\",
                viewMode: \"years\", 
                minViewMode: \"years\",
                autoclose: true
            });
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
        $this->load_js[] = "//code.jquery.com/ui/1.12.1/jquery-ui.min.js";
        $this->load_js[] = "//keith-wood.name/js/jquery.signature.js";

    }

    public function index()
    {
        //First, Add an auth
        if (CRUDBooster::me() == null) {
            CRUDBooster::redirect(CRUDBooster::adminPath('login'), 'Login terlebih dahulu', 'danger');
            exit();
        }

        //Create your own query 
        $data = [];
        $data['page_title'] = "Tanda Tangan Digital";

        return $this->view('admin/signature/index', $data);
    }
    
      
    public function store(Request $request)
    {
        $folderPath = public_path('images/');
        $image = explode(";base64,", $request->signed);
        $image_type = explode("image/", $image[0]);
        $image_type_png = $image_type[1];
        $image_base64 = base64_decode($image[1]);
        $file = $folderPath . uniqid() . '.'.$image_type_png;
        file_put_contents($file, $image_base64);
      
        return back()->with('success', 'Tanda Tangan telah disimpan!');
    }
}
