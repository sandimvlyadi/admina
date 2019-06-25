<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_laporan` FROM `laporan` a LEFT JOIN `jenis_laporan` b ON a.`id_jenis_laporan` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_laporan` LIKE '%". $s ."%' OR a.`tahun_laporan` LIKE '%". $s ."%' OR a.`bulan_laporan` LIKE '%". $s ."%' OR a.`catatan` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_laporan') {
                    $q .= "ORDER BY b.`nama_laporan` ". $dir ." ";
                } elseif ('tahun_laporan') {
                    $q .= "ORDER BY a.`tahun_laporan` ". $dir ." ";
                } else {
                    $q .= "ORDER BY a.`". $col ."` ". $dir ." ";
                }
        	} else{
        		$q .= "ORDER BY a.`id` ". $dir ." ";
        	}
        } else{
        	$q .= "ORDER BY a.`id` DESC ";
        }

        return $q;
    }

    function _list($data = array())
    {
        $q = $this->_get($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();
        
        return $r;
    }

    function _filtered($data = array())
    {
        $q = $this->_get($data);
        $r = $this->db->query($q, false)->result_array();
        
        return count($r);
    }

    function _all($data = array())
    {
        $data['all'] = true;
        $q = $this->_get($data);
        $r = $this->db->query($q)->result_array();
        
        return count($r);
    }
    
	function datatable($data = array())
	{
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all($data),
                'recordsFiltered'   => $this->_filtered($data),
                'data'              => $list,
                'result'            => true,
                'msg'               => 'Loaded.',
                'start'             => (int) $data['start'] + 1
            );
        } else{
            $result['msg'] = 'No data left.';
        }

        return $result;
	}

    function edit($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => 'Data laporan tidak ditemukan.'  
        );

        $q = "SELECT * FROM `laporan` WHERE `id` = '". $this->db->escape_str($id) ."';";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];
        }

        return $result;
    }

	function save($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);

		$q = '';
		if ($id == 0) {
            $q =    "SELECT 
                        * 
                    FROM 
                        `laporan` 
                    WHERE 
                        `id_jenis_laporan` = '". $this->db->escape_str($f['id_jenis_laporan']) ."' 
                            AND 
                        `tahun_laporan` = '". $this->db->escape_str($f['tahun_laporan']) ."' 
                            AND 
                        `bulan_laporan` = '". $this->db->escape_str($f['bulan_laporan']) ."' 
                            AND 
                        `deleted_at` IS NULL
                    ;";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $result['msg'] = 'Laporan sudah pernah dibuat sebelumnya.';
                return $result;
            }

			$q =    "INSERT INTO 
                        `laporan` 
                        (
                            `id_jenis_laporan`,
                            `tahun_laporan`,
                            `bulan_laporan`,
                            `catatan`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['id_jenis_laporan']) ."',
                            '". $this->db->escape_str($f['tahun_laporan']) ."',
                            '". $this->db->escape_str($f['bulan_laporan']) ."',
                            '". $this->db->escape_str($f['catatan']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `laporan` 
                    SET 
                        `id_jenis_laporan` = '". $this->db->escape_str($f['id_jenis_laporan']) ."', 
                        `tahun_laporan` = '". $this->db->escape_str($f['tahun_laporan']) ."', 
                        `bulan_laporan` = '". $this->db->escape_str($f['bulan_laporan']) ."', 
                        `catatan` = '". $this->db->escape_str($f['catatan']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menyimpan data.';
		}

		return $result;
	}

	function delete($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		$q = "UPDATE `laporan` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_jenis_laporan($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `jenis_laporan` WHERE `deleted_at` IS NULL ORDER BY `nama_laporan` ASC;";
        } else{
            $q = "SELECT * FROM `jenis_laporan` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function cetak($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => 'Data laporan tidak ditemukan.'  
        );

        $q = "SELECT * FROM `laporan` WHERE `id` = '". $this->db->escape_str($id) ."';";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];

            $idJenisLaporan = $r[0]['id_jenis_laporan'];
            $periode = $r[0]['tahun_laporan'] . '-' . $r[0]['bulan_laporan'];
            $q = '';
            switch ($idJenisLaporan) {
                case '1':
                    
                    break;
                case '2':
                    $q = "SELECT * FROM `jenis_penyakit` WHERE `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    $q = "SELECT * FROM `rentang_umur` WHERE `deleted_at` IS NULL;";
                    $u = $this->db->query($q)->result_array();
                    if (count($r) > 0) {
                        for ($i=0; $i < count($r); $i++) { 
                            if (count($u) > 0) {
                                for ($j=0; $j < count($u); $j++) { 
                                    $q = "SELECT COUNT(*) AS `total` FROM `detail_pemeriksaan_umum` WHERE `jenis_kelamin` = 'L' AND `id_penyakit` = '". $r[$i]['id'] ."' AND `id_rentang_umur` = '". $u[$j]['id'] ."' AND `deleted_at` IS NULL AND `created_at` IS NOT NULL;";
                                    $sum = $this->db->query($q)->result_array();
                                    $sumL = $sum[0]['total'];
                                    $q = "SELECT COUNT(*) AS `total` FROM `detail_pemeriksaan_umum` WHERE `jenis_kelamin` = 'P' AND `id_penyakit` = '". $r[$i]['id'] ."' AND `id_rentang_umur` = '". $u[$j]['id'] ."' AND `deleted_at` IS NULL AND `created_at` IS NOT NULL;";
                                    $sum = $this->db->query($q)->result_array();
                                    $sumP = $sum[0]['total'];
                                    $u[$j]['L'] = $sumL;
                                    $u[$j]['P'] = $sumP;
                                }
                                $r[$i]['rekap'] = $u;
                            }
                        }
                    }

                    $result['rentangUmur'] = $u;
                    break;
                case '3':
                    $q = "SELECT * FROM `detail_program_ispa` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '4':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_satuan`,
                                c.`nama_alat`
                            FROM 
                                `detail_pemeriksaan_kb` a 
                            LEFT JOIN
                                `satuan_usia` b
                                    ON
                                a.`id_satuan_usia` = b.`id`
                            LEFT JOIN
                                `alat_kontrasepsi` c
                                    ON
                                a.`id_alat_kontrasepsi` = c.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                            AND 
                                a.`deleted_at` IS NULL
                            ;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '5':
                    $q = "SELECT * FROM `detail_imunisasi` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '6':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_pasien`
                            FROM 
                                `detail_persalinan` a 
                            LEFT JOIN
                                `pasiens` b
                                    ON
                                a.`id_pasien` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL
                            ;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '7':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_pasien`
                            FROM 
                                `detail_pemeriksaan_kehamilan` a 
                            LEFT JOIN
                                `pasiens` b
                                    ON
                                a.`id_pasien` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                default:
                    # code...
                    break;
            }

            $result['detail'] = $r;
        }

        return $result;
    }

}