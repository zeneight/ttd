<div class="button_action" style="text-align:center;width:130px;">
	@if(CRUDBooster::isRead())
	<!-- <a class="btn btn-xs btn-primary btn-detail" title="Detil Data" onclick="test({{$sql->id}}, 'surveis')"><i class="fa fa-eye"></i>&nbsp; Info</a> -->
	@endif
	@if(CRUDBooster::isUpdate() && $sql->id != NULL)
		<a class="btn btn-xs btn-default btn-edit" title="Opsi" href='{{CRUDBooster::mainpath("edit/$sql->id")}}'><i class="fa fa-pencil"> </i></a>
		<a class="btn btn-xs btn-primary btn-download" title="Download" href='{{CRUDBooster::mainpath("download/$sql->id")}}'><i class="fa fa-download"> </i></a>
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