<div class="button_action" style="text-align:center;width:130px;">
	@if(CRUDBooster::isRead())
	<!-- <a class="btn btn-xs btn-primary btn-detail" title="Detil Data" onclick="test({{$sql->id}}, 'surveis')"><i class="fa fa-eye"></i>&nbsp; Info</a> -->
	@endif
	@if(CRUDBooster::isUpdate() && $sql->id != NULL)
		@if($sql->status==0)
		<a class="btn btn-xs btn-primary btn-ttd" title="Tanda-tangani" href="javascript:;" onclick="swal({   
				title: &quot;Tanda-tangani Surat&quot;,   
				text: &quot;Inputkan passcode Anda!&quot;,   
				type: &quot;input&quot;,   
				showCancelButton: true,     
				confirmButtonText: &quot;Submit&quot;,  
				cancelButtonText: &quot;Kembali&quot;,
				inputPlaceholder: &quot;Input di sini&quot;,  
				closeOnConfirm: false }, 
				function(inputValue){
					if (inputValue === null) return false;
					
					if (inputValue === '') {
						swal.showInputError('Mohon isikan field!');
						return false
					} else if (inputValue != false){
						$.ajax({
							type:'post',
							url:&quot;{{CRUDBooster::mainpath('ttd')}}&quot;,
							data:{
								id: &quot;{{$sql->id}}&quot;, 
								passcode: inputValue,
								_token: &quot;{{ csrf_token() }}&quot;,
							},
							dataType: 'json',
							beforeSend: function() {
								$('.sa-confirm-button-container .confirm').append(' &nbps;<i class=\'fa fa-refresh fa-spin fa-fw\'></i>');
							},
							success:function(data){
								if(data.msg==='salah') swal('Ups!', 'Passcode yang Anda inputkan salah, silahkan mengulangi input lagi!', 'error');
								if(data.msg==='benar') {
									swal('Selamat!', 'Surat telah di-tandatangani!', 'success');
									$('#example').DataTable().ajax.reload();
									$('#belum').DataTable().ajax.reload();
								}
							}
						});
					}
				});"><i class="fa fa-book"></i> TTD</a>
				<a target="_BLANK" class="btn btn-xs btn-warning btn-download" title="Lihat" href='{{CRUDBooster::mainpath("pdf/".$sql->id)}}'><i class="fa fa-eye"> </i></a>
		@else
		<a target="_BLANK" class="btn btn-xs btn-success btn-download" title="Lihat" href='{{CRUDBooster::mainpath("download/".str_slug($sql->judul))}}'><i class="fa fa-download"> </i></a>
		@endif
		
	@endif
	@if(CRUDBooster::isDelete())
	<a class="btn btn-xs btn-danger btn-delete" title="Hapus" href="javascript:;" onclick="swal({   
				title: &quot;Apakah anda yakin ?&quot;,   
				text: &quot;Anda tidak akan dapat mengembalikan data anda!&quot;,   
				type: &quot;warning&quot;,   
				showCancelButton: true,   
				confirmButtonColor: &quot;#ff0000&quot;,   
				confirmButtonText: &quot;Ya&quot;,  
				cancelButtonText: &quot;Tidak&quot;,  
				closeOnConfirm: false }, 
				function(){  location.href=&quot;{{CRUDBooster::mainpath('delete/'.$sql->id)}}&quot; });"><i class="fa fa-trash"></i></a>
	@endif

</div>