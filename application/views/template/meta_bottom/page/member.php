<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script>
$(function(){
	$(".data-member").DataTable();
});
function change_status(str){
	str = str.split('#');
	$("#member_id").val(str[0]);
	$("#member_status").val(str[1]);
	$("#member_name").val(str[2]);
	if(str[1] == 1){
		action = 'memblokir <b>'+str[2]+'</b>';
		$(".btnaction").val('Blokir');
	}else{
		action = 'mengaktifkan <b>'+str[2]+'</b>';
		$(".btnaction").val('Aktifkan');
	}
	$(".msg").html('Apakah Anda yakin ingin '+action+'?');
}
function delete_member(str){
	id = str.split("#");
	$("#member_id_delete").val(id[0]);
	$("#member_name_delete").val(id[1]);
	$(".msg-delete").html('Apakah Anda yakin ingin menghapus member dengan nama <b>'+id[1]+'</b>');
}
</script>