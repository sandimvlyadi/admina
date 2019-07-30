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
            if ($f['id_jenis_laporan'] == 1 && $id == 0) {
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
                        ORDER BY
                            `id` DESC
                        LIMIT 1
                        ;";
                $r = $this->db->query($q, false)->result_array();
                $id_laporan_bulanan = $r[0]['id'];
                $q =    "INSERT INTO 
                            `detail_laporan_bulanan` 
                            (
                                `id_laporan_bulanan`, 
                                `cihanjuang_rahayu_hamil_b`,
                                `cihanjuang_rahayu_hamil_l`,
                                `cihanjuang_rahayu_kb_baru_iud`,
                                `cihanjuang_rahayu_kb_baru_pil`,
                                `cihanjuang_rahayu_kb_baru_sun`,
                                `cihanjuang_rahayu_kb_lama_iud`,
                                `cihanjuang_rahayu_kb_lama_pil`,
                                `cihanjuang_rahayu_kb_lama_sun`,
                                `cihanjuang_rahayu_imunisasi_bcg`,
                                `cihanjuang_rahayu_imunisasi_dpt_1`,
                                `cihanjuang_rahayu_imunisasi_dpt_2`,
                                `cihanjuang_rahayu_imunisasi_dpt_3`,
                                `cihanjuang_rahayu_imunisasi_polio_1`,
                                `cihanjuang_rahayu_imunisasi_polio_2`,
                                `cihanjuang_rahayu_imunisasi_polio_3`,
                                `cihanjuang_rahayu_imunisasi_polio_4`,
                                `cihanjuang_rahayu_imunisasi_hb_0`,
                                `cihanjuang_rahayu_imunisasi_hb_1`,
                                `cihanjuang_rahayu_imunisasi_hb_2`,
                                `cihanjuang_rahayu_imunisasi_hb_3`,
                                `cihanjuang_rahayu_imunisasi_campak`,
                                `cihanjuang_rahayu_imunisasi_tt_1`,
                                `cihanjuang_rahayu_imunisasi_tt_2`,
                                `cihanjuang_rahayu_imunisasi_tt_wus_1`,
                                `cihanjuang_rahayu_imunisasi_tt_wus_2`,
                                `cihanjuang_rahayu_partus`,
                                `cihanjuang_hamil_b`,
                                `cihanjuang_hamil_l`,
                                `cihanjuang_kb_baru_iud`,
                                `cihanjuang_kb_baru_pil`,
                                `cihanjuang_kb_baru_sun`,
                                `cihanjuang_kb_lama_iud`,
                                `cihanjuang_kb_lama_pil`,
                                `cihanjuang_kb_lama_sun`,
                                `cihanjuang_imunisasi_bcg`,
                                `cihanjuang_imunisasi_dpt_1`,
                                `cihanjuang_imunisasi_dpt_2`,
                                `cihanjuang_imunisasi_dpt_3`,
                                `cihanjuang_imunisasi_polio_1`,
                                `cihanjuang_imunisasi_polio_2`,
                                `cihanjuang_imunisasi_polio_3`,
                                `cihanjuang_imunisasi_polio_4`,
                                `cihanjuang_imunisasi_hb_0`,
                                `cihanjuang_imunisasi_hb_1`,
                                `cihanjuang_imunisasi_hb_2`,
                                `cihanjuang_imunisasi_hb_3`,
                                `cihanjuang_imunisasi_campak`,
                                `cihanjuang_imunisasi_tt_1`,
                                `cihanjuang_imunisasi_tt_2`,
                                `cihanjuang_imunisasi_tt_wus_1`,
                                `cihanjuang_imunisasi_tt_wus_2`,
                                `cihanjuang_partus`,
                                `sariwangi_hamil_b`,
                                `sariwangi_hamil_l`,
                                `sariwangi_kb_baru_iud`,
                                `sariwangi_kb_baru_pil`,
                                `sariwangi_kb_baru_sun`,
                                `sariwangi_kb_lama_iud`,
                                `sariwangi_kb_lama_pil`,
                                `sariwangi_kb_lama_sun`,
                                `sariwangi_imunisasi_bcg`,
                                `sariwangi_imunisasi_dpt_1`,
                                `sariwangi_imunisasi_dpt_2`,
                                `sariwangi_imunisasi_dpt_3`,
                                `sariwangi_imunisasi_polio_1`,
                                `sariwangi_imunisasi_polio_2`,
                                `sariwangi_imunisasi_polio_3`,
                                `sariwangi_imunisasi_polio_4`,
                                `sariwangi_imunisasi_hb_0`,
                                `sariwangi_imunisasi_hb_1`,
                                `sariwangi_imunisasi_hb_2`,
                                `sariwangi_imunisasi_hb_3`,
                                `sariwangi_imunisasi_campak`,
                                `sariwangi_imunisasi_tt_1`,
                                `sariwangi_imunisasi_tt_2`,
                                `sariwangi_imunisasi_tt_wus_1`,
                                `sariwangi_imunisasi_tt_wus_2`,
                                `sariwangi_partus`,
                                `karyawangi_hamil_b`,
                                `karyawangi_hamil_l`,
                                `karyawangi_kb_baru_iud`,
                                `karyawangi_kb_baru_pil`,
                                `karyawangi_kb_baru_sun`,
                                `karyawangi_kb_lama_iud`,
                                `karyawangi_kb_lama_pil`,
                                `karyawangi_kb_lama_sun`,
                                `karyawangi_imunisasi_bcg`,
                                `karyawangi_imunisasi_dpt_1`,
                                `karyawangi_imunisasi_dpt_2`,
                                `karyawangi_imunisasi_dpt_3`,
                                `karyawangi_imunisasi_polio_1`,
                                `karyawangi_imunisasi_polio_2`,
                                `karyawangi_imunisasi_polio_3`,
                                `karyawangi_imunisasi_polio_4`,
                                `karyawangi_imunisasi_hb_0`,
                                `karyawangi_imunisasi_hb_1`,
                                `karyawangi_imunisasi_hb_2`,
                                `karyawangi_imunisasi_hb_3`,
                                `karyawangi_imunisasi_campak`,
                                `karyawangi_imunisasi_tt_1`,
                                `karyawangi_imunisasi_tt_2`,
                                `karyawangi_imunisasi_tt_wus_1`,
                                `karyawangi_imunisasi_tt_wus_2`,
                                `karyawangi_partus`,
                                `cihideung_hamil_b`,
                                `cihideung_hamil_l`,
                                `cihideung_kb_baru_iud`,
                                `cihideung_kb_baru_pil`,
                                `cihideung_kb_baru_sun`,
                                `cihideung_kb_lama_iud`,
                                `cihideung_kb_lama_pil`,
                                `cihideung_kb_lama_sun`,
                                `cihideung_imunisasi_bcg`,
                                `cihideung_imunisasi_dpt_1`,
                                `cihideung_imunisasi_dpt_2`,
                                `cihideung_imunisasi_dpt_3`,
                                `cihideung_imunisasi_polio_1`,
                                `cihideung_imunisasi_polio_2`,
                                `cihideung_imunisasi_polio_3`,
                                `cihideung_imunisasi_polio_4`,
                                `cihideung_imunisasi_hb_0`,
                                `cihideung_imunisasi_hb_1`,
                                `cihideung_imunisasi_hb_2`,
                                `cihideung_imunisasi_hb_3`,
                                `cihideung_imunisasi_campak`,
                                `cihideung_imunisasi_tt_1`,
                                `cihideung_imunisasi_tt_2`,
                                `cihideung_imunisasi_tt_wus_1`,
                                `cihideung_imunisasi_tt_wus_2`,
                                `cihideung_partus`,
                                `cigugur_hamil_b`,
                                `cigugur_hamil_l`,
                                `cigugur_kb_baru_iud`,
                                `cigugur_kb_baru_pil`,
                                `cigugur_kb_baru_sun`,
                                `cigugur_kb_lama_iud`,
                                `cigugur_kb_lama_pil`,
                                `cigugur_kb_lama_sun`,
                                `cigugur_imunisasi_bcg`,
                                `cigugur_imunisasi_dpt_1`,
                                `cigugur_imunisasi_dpt_2`,
                                `cigugur_imunisasi_dpt_3`,
                                `cigugur_imunisasi_polio_1`,
                                `cigugur_imunisasi_polio_2`,
                                `cigugur_imunisasi_polio_3`,
                                `cigugur_imunisasi_polio_4`,
                                `cigugur_imunisasi_hb_0`,
                                `cigugur_imunisasi_hb_1`,
                                `cigugur_imunisasi_hb_2`,
                                `cigugur_imunisasi_hb_3`,
                                `cigugur_imunisasi_campak`,
                                `cigugur_imunisasi_tt_1`,
                                `cigugur_imunisasi_tt_2`,
                                `cigugur_imunisasi_tt_wus_1`,
                                `cigugur_imunisasi_tt_wus_2`,
                                `cigugur_partus`,
                                `cipanas_hamil_b`,
                                `cipanas_hamil_l`,
                                `cipanas_kb_baru_iud`,
                                `cipanas_kb_baru_pil`,
                                `cipanas_kb_baru_sun`,
                                `cipanas_kb_lama_iud`,
                                `cipanas_kb_lama_pil`,
                                `cipanas_kb_lama_sun`,
                                `cipanas_imunisasi_bcg`,
                                `cipanas_imunisasi_dpt_1`,
                                `cipanas_imunisasi_dpt_2`,
                                `cipanas_imunisasi_dpt_3`,
                                `cipanas_imunisasi_polio_1`,
                                `cipanas_imunisasi_polio_2`,
                                `cipanas_imunisasi_polio_3`,
                                `cipanas_imunisasi_polio_4`,
                                `cipanas_imunisasi_hb_0`,
                                `cipanas_imunisasi_hb_1`,
                                `cipanas_imunisasi_hb_2`,
                                `cipanas_imunisasi_hb_3`,
                                `cipanas_imunisasi_campak`,
                                `cipanas_imunisasi_tt_1`,
                                `cipanas_imunisasi_tt_2`,
                                `cipanas_imunisasi_tt_wus_1`,
                                `cipanas_imunisasi_tt_wus_2`,
                                `cipanas_partus`,
                                `created_at`
                            ) 
                        VALUES 
                            (
                                '". $this->db->escape_str($id_laporan_bulanan) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_hamil_b']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_hamil_l']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_rahayu_partus']) ."',
                                '". $this->db->escape_str($f['cihanjuang_hamil_b']) ."',
                                '". $this->db->escape_str($f['cihanjuang_hamil_l']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['cihanjuang_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['cihanjuang_partus']) ."',
                                '". $this->db->escape_str($f['sariwangi_hamil_b']) ."',
                                '". $this->db->escape_str($f['sariwangi_hamil_l']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['sariwangi_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['sariwangi_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['sariwangi_partus']) ."',
                                '". $this->db->escape_str($f['karyawangi_hamil_b']) ."',
                                '". $this->db->escape_str($f['karyawangi_hamil_l']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['karyawangi_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['karyawangi_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['karyawangi_partus']) ."',
                                '". $this->db->escape_str($f['cihideung_hamil_b']) ."',
                                '". $this->db->escape_str($f['cihideung_hamil_l']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['cihideung_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['cihideung_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['cihideung_partus']) ."',
                                '". $this->db->escape_str($f['cigugur_hamil_b']) ."',
                                '". $this->db->escape_str($f['cigugur_hamil_l']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['cigugur_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['cigugur_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['cigugur_partus']) ."',
                                '". $this->db->escape_str($f['cipanas_hamil_b']) ."',
                                '". $this->db->escape_str($f['cipanas_hamil_l']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_baru_iud']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_baru_pil']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_baru_sun']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_lama_iud']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_lama_pil']) ."',
                                '". $this->db->escape_str($f['cipanas_kb_lama_sun']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_bcg']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_dpt_1']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_dpt_2']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_dpt_3']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_polio_1']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_polio_2']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_polio_3']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_polio_4']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_hb_0']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_hb_1']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_hb_2']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_hb_3']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_campak']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_tt_1']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_tt_2']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_tt_wus_1']) ."',
                                '". $this->db->escape_str($f['cipanas_imunisasi_tt_wus_2']) ."',
                                '". $this->db->escape_str($f['cipanas_partus']) ."',
                                NOW()
                            );
                        ";
                $this->db->simple_query($q);
            }

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
                    $q = "SELECT * FROM `detail_laporan_bulanan` WHERE `id_laporan_bulanan` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
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
                    $q =    "SELECT 
                                a.*,
                                b.`nama_tindakan` 
                            FROM 
                                `detail_imunisasi` a
                            LEFT JOIN
                                `macam_tindakan_imunisasi` b
                                    ON
                                a.`id_macam_tindakan_imunisasi` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL;";
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