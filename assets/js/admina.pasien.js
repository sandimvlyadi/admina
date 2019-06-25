var table = '';
var selectJenisPasien = '';
var selectPendidikanPasien = '';
var selectPendidikanSuami = '';
var selectAgamaPasien = '';
var selectAgamaSuami = '';
var selectPekerjaanPasien = '';
var selectPekerjaanSuami = '';
var selectKota = '';
var selectDesa = '';
var selectDarah = '';
var selectCatatan = '';

$('#li-pasien').addClass('active');

$(document).ready(function(){
	table = $('#tablePasien').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'pasien/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'jenis_pasien'      : response.data[x].jenis_pasien,
                            'no_registrasi'     : response.data[x].no_registrasi,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            // 'tgl_lahir'         : response.data[x].tgl_lahir,
                            // 'nama_suami'        : response.data[x].nama_suami,
                            // 'tgl_lahir_suami'   : response.data[x].tgl_lahir_suami,
                            // 'nama_kota_suami'   : response.data[x].nama_kota,
                            // 'hpht'              : response.data[x].hpht,
                            // 'taksiran_partus'   : response.data[x].taksiran_partus,
	            			'aksi'	            : button
	            		});
	            		i = i + 1;
	            	}

	            	response.data = row;
            		return row;
            	} else{
            		response.draw = 0;
            		return [];
            	}
            }
        },

        'columns' : [
        	{ 'data' : 'no' },
            { 'data' : 'jenis_pasien' },
            { 'data' : 'no_registrasi' },
            { 'data' : 'nama_pasien' },
            // { 'data' : 'tgl_lahir' },
            // { 'data' : 'nama_suami' },
            // { 'data' : 'tgl_lahir_suami' },
            // { 'data' : 'nama_kota_suami' },
            // { 'data' : 'hpht' },
            // { 'data' : 'taksiran_partus' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 4 ]
    		}
  		]
	});

    selectJenisPasien = $('select[name="jenis_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    selectPendidikanPasien = $('select[name="pendidikan_istri"]').select2({
        'theme': 'bootstrap4'
    });

    selectAgamaPasien = $('select[name="agama_istri"]').select2({
        'theme': 'bootstrap4'
    });

    selectPendidikanSuami = $('select[name="pendidikan_suami"]').select2({
        'theme': 'bootstrap4'
    });

    selectAgamaSuami = $('select[name="agama_suami"]').select2({
        'theme': 'bootstrap4'
    });

    selectDarah = $('select[name="gol_darah"]').select2({
        'theme': 'bootstrap4'
    });

    selectCatatan = $('select[name="catatan_bidan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-pekerjaan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="pekerjaan_istri"]').append('<option value="0">- Pilih Pekerjaan -</option>');
                for(var x in response.data){
                    $('select[name="pekerjaan_istri"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pekerjaan+'</option>');
                }
            } else{
                $('select[name="pekerjaan_istri"]').append('<option value="0">- Pilih Pekerjaan -</option>');
            }
        }
    });
    selectPekerjaanPasien = $('select[name="pekerjaan_istri"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-pekerjaan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="pekerjaan_suami"]').append('<option value="0">- Pilih Pekerjaan -</option>');
                for(var x in response.data){
                    $('select[name="pekerjaan_suami"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pekerjaan+'</option>');
                }
            } else{
                $('select[name="pekerjaan_suami"]').append('<option value="0">- Pilih Pekerjaan -</option>');
            }
        }
    });
    selectPekerjaanSuami = $('select[name="pekerjaan_suami"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-kota/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_kota"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kota+'</option>');
                }
            } else{
                $('select[name="id_kota"]').append('<option value="164">Kabupaten Bandung Barat</option>');
            }
        }
    });
    selectKota = $('select[name="id_kota"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-desa/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_desa"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_desa+'</option>');
                }
            } else{
                $('select[name="id_desa"]').append('<option value="8">Tidak Ada</option>');
            }
        }
    });
    selectDesa = $('select[name="id_desa"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

	$('button[name="btn_save"]').attr('id', '0');
    $(selectJenisPasien).val('Bersalin').trigger('change');
    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/input-no-registrasi/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_registrasi"]').val(response.value);
            } else{
                $('input[name="no_registrasi"]').val('');
            }
        }
    });
    $('input[name="nama_pasien"]').val('');
    $('input[name="tgl_lahir"]').val(output);
    $(selectPendidikanPasien).val('Tidak Tamat').trigger('change');
    $(selectAgamaPasien).val('Islam').trigger('change');
    $(selectPekerjaanPasien).val('0').trigger('change');
    $('input[name="alamat_istri"]').val('');
    $('input[name="nama_suami"]').val('');
    $('input[name="tgl_lahir_suami"]').val(output);
    $(selectPendidikanSuami).val('Tidak Tamat').trigger('change');
    $(selectAgamaSuami).val('Islam').trigger('change');
    $(selectPekerjaanSuami).val('0').trigger('change');
    $(selectKota).val('164').trigger('change');
    $(selectDesa).val('8').trigger('change');
    $(selectDarah).val('-').trigger('change');
    $('input[name="no_telp_pasien"]').val('');
    $('input[name="gravida"]').val('1');
    $('input[name="para"]').val('0');
    $('input[name="abortus"]').val('0');
    $('input[name="hpht"]').val(output);
    $('input[name="siklus"]').val('5');
    $('input[name="durasi_haid"]').val('5');
    $('input[name="taksiran_partus"]').val(output);
    $(selectCatatan).val('');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePasien').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectJenisPasien).find('option').each(function(){
                    if ($(this).val() == d.jenis_pasien) {
                        $(selectJenisPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="no_registrasi"]').val(d.no_registrasi);
                $('input[name="nama_pasien"]').val(d.nama_pasien);
                $('input[name="tgl_lahir"]').val(d.tgl_lahir);

                $(selectPendidikanPasien).find('option').each(function(){
                    if ($(this).val() == d.pendidikan_istri) {
                        $(selectPendidikanPasien).val($(this).val()).trigger('change');
                    }
                });

                $(selectAgamaPasien).find('option').each(function(){
                    if ($(this).val() == d.agama_istri) {
                        $(selectAgamaPasien).val($(this).val()).trigger('change');
                    }
                });

                $(selectPekerjaanPasien).find('option').each(function(){
                    if ($(this).val() == d.pekerjaan_istri) {
                        $(selectPekerjaanPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="alamat_istri"]').val(d.alamat_istri);
                $('input[name="nama_suami"]').val(d.nama_suami);
                $('input[name="tgl_lahir_suami"]').val(d.tgl_lahir_suami);

                $(selectPendidikanSuami).find('option').each(function(){
                    if ($(this).val() == d.pendidikan_suami) {
                        $(selectPendidikanSuami).val($(this).val()).trigger('change');
                    }
                });

                $(selectAgamaSuami).find('option').each(function(){
                    if ($(this).val() == d.agama_suami) {
                        $(selectAgamaSuami).val($(this).val()).trigger('change');
                    }
                });

                $(selectPekerjaanSuami).find('option').each(function(){
                    if ($(this).val() == d.pekerjaan_suami) {
                        $(selectPekerjaanSuami).val($(this).val()).trigger('change');
                    }
                });

                $(selectKota).find('option').each(function(){
                    if ($(this).val() == d.id_kota) {
                        $(selectKota).val($(this).val()).trigger('change');
                    }
                });

                $(selectDesa).find('option').each(function(){
                    if ($(this).val() == d.id_desa) {
                        $(selectDesa).val($(this).val()).trigger('change');
                    }
                });

                $(selectDarah).find('option').each(function(){
                    if ($(this).val() == d.gol_darah) {
                        $(selectDarah).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="no_telp_pasien"]').val(d.no_telp_pasien);
                $('input[name="gravida"]').val(d.gravida);
                $('input[name="para"]').val(d.para);
                $('input[name="abortus"]').val(d.abortus);
                $('input[name="hpht"]').val(d.hpht);
                $('input[name="siklus"]').val(d.siklus);
                $('input[name="durasi_haid"]').val(d.durasi_haid);
                $('input[name="taksiran_partus"]').val(d.taksiran_partus);
                
                var catat = new Array();
                $(selectCatatan).find('option').each(function(){
                    if (d.catatan_bidan.indexOf($(this).val()) != -1) {
                        catat.push($(this).val());
                    }
                });
                $(selectCatatan).val(catat).trigger('change');

                $('button[name="btn_save"]').attr('id', id);
                $('#formTitle').text('Edit Data');

                $('#table').hide();
                setTimeout(function(){
                    $('#form').fadeIn()
                }, 100);
            } else{
                $.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'danger',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
            }
        }
    });
});

$('#tablePasien').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'pasien/delete/',
        data: {
        	'id': id
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	$.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'primary',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                table.ajax.reload(null, false);
            } else{
                $.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'danger',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
            }
        }
    });
});

$('button[name="btn_cancel"]').click(function(){
	$('#form').hide();
	setTimeout(function(){
		$('#table').fadeIn();
	}, 100);
});

$('button[name="btn_save"]').click(function(){
	$(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formData').find('input').each(function(){
        if($(this).prop('required')){
            if($(this).val() == ''){
                var placeholder = $(this).attr('placeholder');
                $.notify({
                    icon: 'now-ui-icons ui-1_bell-53',
                    message: 'Kolom '+ placeholder +' tidak boleh kosong.'
                }, {
                    type: 'warning',
                    delay: 1000,
                    timer: 500,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                $(this).focus();
                missing = true;
                return false;
            }
        }
    });

    $(this).removeAttr('disabled');
    if(missing){
        return;
    }

    if ($('select[name="pekerjaan_istri"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pekerjaan pasien terlebih dahulu.'
        }, {
            type: 'warning',
            delay: 1000,
            timer: 500,
            placement: {
              from: 'top',
              align: 'center'
            }
        });
        $(this).focus();
        return;
    }

    if ($('select[name="pekerjaan_suami"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pekerjaan penanggung jawab terlebih dahulu.'
        }, {
            type: 'warning',
            delay: 1000,
            timer: 500,
            placement: {
              from: 'top',
              align: 'center'
            }
        });
        $(this).focus();
        return;
    }

    $.ajax({
        type: 'POST',
        url: baseurl + 'pasien/save/',
        data: {
        	'id': $(this).attr('id'),
        	'form': $('#formData').serialize()
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	$.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'primary',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                table.ajax.reload(null, false);
                $('#form').hide();
				setTimeout(function(){
					$('#table').fadeIn();
				}, 100);
            } else{
                $.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'danger',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
            }
        }
    });
});

$('#formData').on('change', 'select[name="jenis_pasien"]', function(){
    var jenis = $(this).val();
    
    if (jenis == 'Hamil' || jenis == 'Melahirkan') {
        $('.formTambahan').show();
    } else{
        $('.formTambahan').hide();
    }
});