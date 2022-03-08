<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Datatables;
	use Carbon\Carbon;

	class AdminSuratsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "judul";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "surats";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Judul","name"=>"judul"];
			$this->col[] = ["label"=>"Kategori","name"=>"kat_id","join"=>"categories,judul"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Kategori','name'=>'kat_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'categories,judul'];
			$this->form[] = ['label'=>'Judul','name'=>'judul','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'Anda hanya dapat memasukkan huruf saja'];
			$this->form[] = ['label'=>'File Surat','name'=>'file_surat','type'=>'upload','validation'=>'required','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Kategori','name'=>'kat_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'categories,judul'];
			//$this->form[] = ['label'=>'Judul','name'=>'judul','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'Anda hanya dapat memasukkan huruf saja'];
			//$this->form[] = ['label'=>'File Surat','name'=>'file_surat','type'=>'upload','validation'=>'required','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        // $this->script_js = NULL;
			if(CRUDBooster::getCurrentMethod() == "getIndex"){
				$this->script_js .= "
				var tb = $('#example').DataTable({
					\"processing\": true,
					\"serverSide\": true,
					\"ajax\": '".CRUDBooster::mainpath('json-index')."',
					\"columns\": [
						{ data: \"aksi\", name:\"aksi\", orderable:false},
						{ data: \"judul\", name:\"judul\"},
						{ data: \"kategori\", name:\"kat_id\"},
					],
					\"language\": {
						\"lengthMenu\": \"Tampilkan _MENU_ Data per Halaman\",
						\"zeroRecords\": \"Tidak ada Data\",
						\"info\": \"Menampilkan _START_ sampai _END_ dari _TOTAL_ total data\",
						\"infoEmpty\": \"Tabel kosong\",
						\"infoFiltered\": \"(Difilter dari _MAX_ total data)\",
						\"search\": \"Cari\",
						\"paginate\": {
							\"first\":      \"Pertama\",
							\"last\":       \"Terakhir\",
							\"next\":       \">\",
							\"previous\":   \"<\"
						},
					},
					columnDefs: [{
						\"orderable\": false,
					}],
					\"dom\": \"ltrip\",
					order: [[ 1, \"desc\" ]]
				});
				// pencarian
				// $('#pedagang_filter').on('change', function(){
				// 	var searchText1;
				// 	if($(this).val()=='') {
				// 		searchText1 = '';
				// 	} else {
				// 		searchText1 = '^' + $(this).val() + '$';
				// 	}
				// 	tb.column(1).search(searchText1, true, false, true).draw();   
				// });
				
				//tombol
				function set_button(id) {
					var content = \"<a href='".CRUDBooster::mainpath('edit')."/\"+ id +\"' class='btn btn-lg btn-success'><i class='fa fa-pencil'></i> Edit</a>\";
					content += \"<a data-dismiss='modal' class='btn btn-lg btn-default'><i class='fa fa-times'></i>  Tutup</a>\";

					return content;
				}
				//fungsi koma
				function numberWithCommas(x) {
					if(x==null) {
						return 0;
					} else {
						return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, \",\");
					}
				}

				//fungsi untuk filtering data berdasarkan tanggal 
				var start_date;
				var end_date;
				var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
					var dateStart = parseDateValue(start_date);
					var dateEnd = parseDateValue(end_date);
					//Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
					var evalDate= parseDateValue(aData[0]);
						if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
								( isNaN( dateStart ) && evalDate <= dateEnd ) ||
								( dateStart <= evalDate && isNaN( dateEnd ) ) ||
								( dateStart <= evalDate && evalDate <= dateEnd ) )
						{
							return true;
						}
						return false;
				});

				// fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
				function parseDateValue(rawDate) {
					var dateArray= rawDate.split(\"/\");
					var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11   
					return parsedDate;
				}    

				//konfigurasi daterangepicker pada input dengan id datesearch
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
				
				var tgl_awal;
            	var tgl_akhir;
				$(function() {
					$('#datesearch').daterangepicker({
						locale: id_daterangepicker,
						opens: 'left'
					}, function(start, end, label) {
						tgl_awal = start.format('YYYY-MM-DD');
						tgl_akhir = end.format('YYYY-MM-DD');
					});
				});

				//menangani proses saat apply date range
				$('#datesearch').on('apply.daterangepicker', function(ev, picker) {
					$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
					start_date=picker.startDate.format('DD/MM/YYYY');
					end_date=picker.endDate.format('DD/MM/YYYY');
					$.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
					tb.draw();
				});

				$('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
					$(this).val('');
					start_date='';
					end_date='';
					$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
					tb.draw();
				});
				";
			}

			$this->script_js .= "

				// input
				$('.select2').select2();
			";


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
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
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
			$this->load_css[] = asset('vendor/crudbooster/assets/select2/dist/css/select2.min.css');
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here
			// $pdf = new FPDI();
			// $pdf->AddPage();

			// //Set the source PDF file
			// $pagecount = $pdf->setSourceFile(“Tally_PO.pdf”);

			// //Import the first page of the file
			// $tppl = $pdf->importPage(1);

			// //Use this page as template
			// // use the imported page and place it at point 20,30 with a width of 170 mm
			// $pdf->useTemplate($tppl, -10, 20, 210);

			// #Print Hello World at the bottom of the page

			// //Select Arial italic 8
			// $pdf->SetFont(‘Arial’,”,8);
			// $pdf->SetTextColor(0,0,0);
			// $pdf->SetXY(90, 160);

			// $pdf->Image(‘om12iii.jpg’,45,220,15,10);
			// $pdf->Image(‘Om.jpg’,65,220,15,10);
			// $pdf->Image(‘think.jpg’,80,220,15,10);
			// $pdf->Image(‘Om.jpg’,140,240,15,10);

			// //$pdf->Write(0, “Hello World”);

			// $pdf->Output(“modified_pdf.pdf”, “F”);

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

		// index
		public function getIndex(){
			$data['page_title'] = "Data Surat";

			// $data['offline'] = DB::table('tb_monitoring_domain')
			// 	->where('tgl_input', '=', Carbon::now()->format('Y-m-d'))
			// 	->where('status', '=', 0)
			// 	->count();
			
			return $this->view('admin/surat/index', $data);
		}

		// add
		public function getAdd(){
			$data['page_title'] = "Tambah Surat";

			return $this->view('admin/surat/add', $data);
		}

		// json index
		public function getJsonIndex() {
			$sql = DB::table("surats")
			->rightJoin(
				'categories', 
				'surats.kat_id', 
				'=', 
				'categories.id'
				)
			->select(
				'categories.judul as kategori',
				'surats.*'
				)
			->get();
				
			// datatable
			return Datatables::of($sql)
			->addColumn('aksi', function($sql){
				return view('admin/datatables/default', compact('sql'));
			})
			->make(true);
		}

		// download
		public function getDownload($data) {
			return 'test'.$data;
		}


	}