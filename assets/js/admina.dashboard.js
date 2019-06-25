var tableDilayani = '';
var tableProses = '';
var tableTerlayani = '';

var selectPenyakit = '';
var selectRentangUmur = '';
var selectSatuanUsia = '';
var selectAlatKontrasepsi = '';

$('#li-dashboard').addClass('active');

$(document).ready(function(){
	tableDilayani = $('#tableDilayani').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-dilayani/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_layani" class="btn btn-info btn-sm" title="Layani"><i class="fa fa-check"></i> Layani</button>';

	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian,
	            			'aksi'	        : button
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 5, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 6 ]
    		}
  		]
	});

	tableProses = $('#tableProses').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-proses/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_selesai" class="btn btn-success btn-sm" title="Selesai"><i class="fa fa-check"></i> Selesai</button>';

	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian,
	            			'aksi'	        : button
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 5, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 6 ]
    		}
  		]
	});

	tableTerlayani = $('#tableTerlayani').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-terlayani/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' }
        ],

        'order' 	: [[ 5, 'DESC' ]]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-penyakit/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataPemeriksaanUmum select[name="id_penyakit"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_penyakit+'</option>');
                }
            }
        }
    });
    selectPenyakit = $('#formDataPemeriksaanUmum select[name="id_penyakit"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-rentang-umur/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataPemeriksaanUmum select[name="id_rentang_umur"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].rentang_umur+'</option>');
                }
            }
        }
    });
    selectRentangUmur = $('#formDataPemeriksaanUmum select[name="id_rentang_umur"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanUmum select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataProgramIspa select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataImunisasi select[name="hb0"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="bcg"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="dpt1"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="dpt2"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="dpt3"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="dpt4"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio1"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio2"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio3"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio4"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="ipy"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="campak1"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="campak2"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPersalinan select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPersalinan select[name="imd"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanKehamilan select[name="k1"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanKehamilan select[name="k4"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-satuan-usia/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataKB select[name="id_satuan_usia"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_satuan+'</option>');
                }
            }
        }
    });
    selectSatuanUsia = $('#formDataKB select[name="id_satuan_usia"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-alat-kontrasepsi/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataKB select[name="id_alat_kontrasepsi"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_alat+'</option>');
                }
            }
        }
    });
    selectAlatKontrasepsi = $('#formDataKB select[name="id_alat_kontrasepsi"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="pasang_baru"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="pasang_cabut"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="t_4"]').select2({
        'theme': 'bootstrap4'
    });

	setInterval('autoRefreshData()', 3000);
});

$('#tableDilayani').on('click', 'button[name="btn_layani"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/layani/',
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
                tableDilayani.ajax.reload(null, false);
                tableProses.ajax.reload(null, false);
                tableTerlayani.ajax.reload(null, false);
                getInfo();
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

$('#tableProses').on('click', 'button[name="btn_selesai"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/pre-selesai/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;
                // console.log(d);

                switch(d.id_jenis_pelayanan){
                    case '9': // pemeriksaan umum
                        $('#formDataPemeriksaanUmum input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPemeriksaanUmum input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPemeriksaanUmum input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPemeriksaanUmum input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPemeriksaanUmum select[name="jenis_kelamin"]').val('L');
                        $(selectPenyakit).val('20').trigger('change');
                        $(selectRentangUmur).val('1').trigger('change');
                        $('button[name="btn_selesai_pemeriksaan_umum"]').attr('id', d.id);

                        $('#pemeriksaanUmum').modal('show');
                        break;
                    case '34': // program ispa
                        $('#formDataProgramIspa input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataProgramIspa input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataProgramIspa input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataProgramIspa input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataProgramIspa input[name="nama_anak"]').val('');
                        $('#formDataProgramIspa select[name="jenis_kelamin"]').val('L').trigger('change');
                        $('#formDataProgramIspa input[name="umur_tahun"]').val('');
                        $('#formDataProgramIspa input[name="umur_bulan"]').val('');
                        $('#formDataProgramIspa input[name="tb_pb"]').val('');
                        $('#formDataProgramIspa input[name="bb"]').val('');
                        $('#formDataProgramIspa textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_program_ispa"]').attr('id', d.id);

                        $('#programIspa').modal('show');
                        break;
                    case '8': // imunisasi
                        $('#formDataImunisasi input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataImunisasi input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataImunisasi input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataImunisasi input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataImunisasi input[name="nama_anak"]').val('');
                        $('#formDataImunisasi input[name="no_kk"]').val('');
                        $('#formDataImunisasi input[name="alamat"]').val('');
                        $('#formDataImunisasi input[name="tgl_lahir"]').val(getToday());
                        $('#formDataImunisasi input[name="bb_lahir"]').val('');
                        $('#formDataImunisasi input[name="bb"]').val('');
                        $('#formDataImunisasi input[name="pb"]').val('');
                        $('#formDataImunisasi select[name="hb0"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="bcg"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="dpt1"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="dpt2"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="dpt3"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="dpt4"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio1"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio2"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio3"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio4"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="ipy"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="campak1"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="campak2"]').val('0').trigger('change');
                        $('#formDataImunisasi textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_imunisasi"]').attr('id', d.id);

                        $('#imunisasi').modal('show');
                        break;
                    case '3': // persalinan
                        $('#formDataPersalinan input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPersalinan input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPersalinan input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataPersalinan input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPersalinan input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPersalinan input[name="umur"]').val('');
                        $('#formDataPersalinan textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataPersalinan input[name="anak_ke"]').val('');
                        $('#formDataPersalinan input[name="bb"]').val('');
                        $('#formDataPersalinan input[name="pb"]').val('');
                        $('#formDataPersalinan input[name="tgl_lahir"]').val(getToday());
                        $('#formDataPersalinan input[name="jam_lahir"]').val('');
                        $('#formDataPersalinan select[name="jenis_kelamin"]').val('L').trigger('change');
                        $('#formDataPersalinan select[name="imd"]').val('1').trigger('change');
                        $('#formDataPersalinan input[name="lingkar_kepala"]').val('');
                        $('#formDataPersalinan textarea[name="resiko"]').val('');
                        $('#formDataPersalinan textarea[name="keterangan"]').val('');
                        $('#formDataPersalinan textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_persalinan"]').attr('id', d.id);

                        $('#persalinan').modal('show');
                        break;
                    case '1': // pemeriksaan kehamilan
                        $('#formDataPemeriksaanKehamilan input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPemeriksaanKehamilan input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPemeriksaanKehamilan input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataPemeriksaanKehamilan input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPemeriksaanKehamilan input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPemeriksaanKehamilan input[name="tgl_lahir"]').val(d.tgl_lahir);
                        $('#formDataPemeriksaanKehamilan input[name="nik"]').val(d.nik);
                        $('#formDataPemeriksaanKehamilan input[name="umur"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="nama_suami"]').val(d.nama_suami);
                        $('#formDataPemeriksaanKehamilan input[name="no_kk"]').val(d.no_kk);
                        $('#formDataPemeriksaanKehamilan input[name="buku_kia"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataPemeriksaanKehamilan input[name="hpht"]').val(getToday());
                        $('#formDataPemeriksaanKehamilan input[name="tp"]').val(getToday());
                        $('#formDataPemeriksaanKehamilan input[name="bb"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="tb"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="usia_kehamilan"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="gpa"]').val('');
                        $('#formDataPemeriksaanKehamilan select[name="k1"]').val('1').trigger('change');
                        $('#formDataPemeriksaanKehamilan select[name="k4"]').val('1').trigger('change');
                        $('#formDataPemeriksaanKehamilan input[name="tt"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="lila"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="hb"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="resiko"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="keterangan"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="vct"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_pemeriksaan_kehamilan"]').attr('id', d.id);

                        $('#pemeriksaanKehamilan').modal('show');
                        break;
                    case '37': // KB
                        $('#formDataKB input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataKB input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataKB input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataKB input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataKB input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataKB input[name="umur"]').val('');
                        $('#formDataKB input[name="nama_suami"]').val(d.nama_suami);
                        $('#formDataKB textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataKB input[name="jml_anak_laki"]').val('0');
                        $('#formDataKB input[name="jml_anak_perempuan"]').val('0');
                        $('#formDataKB input[name="jml_anak"]').val('0');
                        $('#formDataKB input[name="usia_anak_terkecil"]').val('');
                        $(selectSatuanUsia).val('1').trigger('change');
                        $('#formDataKB select[name="pasang_baru"]').val('1').trigger('change');
                        $('#formDataKB select[name="pasang_cabut"]').val('PEMASANGAN').trigger('change');
                        $(selectAlatKontrasepsi).val('1').trigger('change');
                        $('#formDataKB input[name="akli"]').val('');
                        $('#formDataKB select[name="t_4"]').val('1').trigger('change');
                        $('#formDataKB input[name="ganti_cara"]').val('');
                        $('#formDataKB textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_kb"]').attr('id', d.id);

                        $('#pemeriksaanKB').modal('show');
                        break;
                    default:
                        break;
                }
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

function getInfo()
{
	$.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/info/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('.card-antrian .card-category').text(d.antrian);
                $('.card-pembayaran .card-category').text(d.pembayaran);
            }
        }
    });
}

function autoRefreshData()
{
    tableDilayani.ajax.reload(null, false);
    tableProses.ajax.reload(null, false);
    tableTerlayani.ajax.reload(null, false);
    getInfo();
}

function getToday()
{
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

    return output
}

$('button[name="btn_selesai_pemeriksaan_umum"]').click(function(){
    $(this).attr('disabled', 'disabled');

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPemeriksaanUmum').serialize()
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

                $('#pemeriksaanUmum').modal('hide');
                autoRefreshData();
                $(this).removeAttr('disabled');
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
                $(this).removeAttr('disabled');
            }
        }
    });
});

$('button[name="btn_selesai_program_ispa"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataProgramIspa').find('input').each(function(){
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataProgramIspa').serialize()
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

                $('#programIspa').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_imunisasi"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataImunisasi').find('input').each(function(){
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataImunisasi').serialize()
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

                $('#imunisasi').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_persalinan"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataPersalinan').find('input').each(function(){
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPersalinan').serialize()
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

                $('#persalinan').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_pemeriksaan_kehamilan"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataPemeriksaanKehamilan').find('input').each(function(){
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPemeriksaanKehamilan').serialize()
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

                $('#pemeriksaanKehamilan').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_kb"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataKB').find('input').each(function(){
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataKB').serialize()
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

                $('#pemeriksaanKB').modal('hide');
                autoRefreshData();
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

$('input[name="filterDate"]').on('change', function(){
    tableTerlayani.search($(this).val()).draw();
});