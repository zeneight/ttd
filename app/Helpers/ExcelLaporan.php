<?php
namespace App\Helpers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class ExcelLaporan implements FromView
{


    private $viewnya    = "excels.";
    private $tabel      = "";
    private $datanya    = [];

    private $jenis      = "harian";

    public function __construct($j, $d) {
        // $this->viewnya .= $v;
        // $this->tabel    = $v;

        $this->jenis = $j;
        $this->datanya = $d;

        dd($this->datanya);
    }

    public function view(): View
    {
        if($this->jenis=="harian"){
            // $data = DB::table('')->get();

            $query = "SELECT * from (
                select `pangans`.`id`, `pangans`.`nama_pangan`, avg(surveis.harga) AS rata_harga, sum(surveis.persediaan) AS total_persediaan 
                from `surveis` right join `pangans` on `surveis`.`pangan_id` = `pangans`.`id` 
                where (`surveis`.`tgl_input` = '2021-04-08')
                group by `id`, `nama_pangan`    
                UNION 
                select `pangans`.`id`, `pangans`.`nama_pangan`, null as rata_harga, null as total_persediaan 
                from `pangans` group by `id`, `nama_pangan`) as data
                group by `id`,`nama_pangan`
                order by `id` ASC";
    
            $data['laporan'] = DB::select($query);
    
            $no = 1;
            $dt['laporan']['instansi'] = "Dinas Perikanan";
            $dt['laporan']['tanggal'] = $request->get('tgl_laporan');
    
            foreach ($data['laporan'] as $key => $item) {
                $ko = DB::table('kebutuhans')
                            ->select('kebetuhan_harian')
                            ->where([
                                'tahun_sk' => $request->get('tahun_sk'),
                                'pangan_id' => $item->id
                            ])
                            ->first();
    
                $pe = DB::table('penduduks')
                            ->select('jml_penduduk')
                            ->where('tahun_sk', $request->get('tahun_sk'))
                            ->first();
    
                $kebutuhan = $ko->kebetuhan_harian*$pe->jml_penduduk;
    
                $dt['laporan']['data'][$key]['no_urut']             = $no++;
                $dt['laporan']['data'][$key]['nama_pangan']         = $item->nama_pangan;
                $dt['laporan']['data'][$key]['harga']               = number_format($item->rata_harga);
                $dt['laporan']['data'][$key]['persediaan']          = number_format($item->total_persediaan);
    
                $dt['laporan']['data'][$key]['kebutuhan']           = number_format($kebutuhan);
            }
            
            // dd($dt['laporan']);
            // dd(\Carbon\Carbon::now()->diffForHumans());
    
            if ($dt['laporan']['data'] == null) {
                return redirect('admin/h/laporan')->with('status', 'Maaf, Anda tidak dapat membuat laporan ini karena belum ada data di dalam database!');
            }

            return view('admin.laporan.excelHarian', [
                'data' => $dt
            ]);
        } else {
            return "No Data";
        }
    }
}