<?php
namespace App\Helpers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class ExcelReport implements FromView
{
    use Exportable;

    private $viewnya    = "excel.";
    private $tabel      = "";  

    public function __construct($v) {
        $this->viewnya .= $v;
        $this->tabel    = $v;
    }

    public function view(): View
    {
        return view($this->viewnya, [
            $this->tabel => DB::table($this->tabel)->get()
        ]);
    }
}