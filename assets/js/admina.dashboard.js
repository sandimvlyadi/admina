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
	            			'no'            : i,
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status'       	: response.data[x].status,
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
        	{ 'data' : 'no' },
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status' },
            { 'data' : 'tgl_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 7 ]
    		}
  		]
	});
});