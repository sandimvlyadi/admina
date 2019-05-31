var tableDilayani = '';
var tableProses = '';
var tableTerlayani = '';

$('#li-dashboard').addClass('active');

$(document).ready(function(){
	tableDilayani = $('#tableDilayani').DataTable({
		'processing'	: true,
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
		'processing'	: true,
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
		'processing'	: true,
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

        'order' 	: [[ 5, 'ASC' ]]
	});

	getInfo();
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
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
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