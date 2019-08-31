var table = '';

$('#li-apotek').addClass('active');

$(document).ready(function(){
	table = $('#tableApotek').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'apotek/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_bayar" class="btn btn-success btn-sm" title="Bayar"><i class="fas fa-shopping-basket"></i> Bayar</button>';

                        if (response.data[x].status_antrian != 'Selesai') {
                            button = '';
                        }

	            		row.push({
	            			'no'                : i,
                            'waktu'             : response.data[x].tanggal + ' ' + response.data[x].jam,
	            			'nama_pasien'       : response.data[x].nama_pasien,
                            'nama_pelayanan'    : response.data[x].nama_pelayanan,
                            'status_antrian'    : response.data[x].status_antrian,
	            			'aksi'              : button
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
            { 'data' : 'waktu' },
            { 'data' : 'nama_pasien' },
        	{ 'data' : 'nama_pelayanan' },
            { 'data' : 'status_antrian' },
        	{ 'data' : 'aksi' }
        ],

        // 'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 5 ]
    		}
  		]
	});

});