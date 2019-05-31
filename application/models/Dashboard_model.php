<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	function _get_dilayani($data = array())
    {
        $d = date('Y-m-d');

        $q = "SELECT a.*, b.`nama_dokter`, c.`nama_pasien`, d.`nama_pelayanan` FROM `antrians` a LEFT JOIN `dokters` b ON a.`id_dokter` = b.`id` LEFT JOIN `pasiens` c ON a.`id_pasien` = c.`id` LEFT JOIN `jenis_pelayanans` d ON a.`id_jenis_pelayanan` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
            $s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`status_antrian` LIKE '%". $s ."%' OR a.`tgl_antrian` LIKE '%". $s ."%' OR b.`nama_dokter` LIKE '%". $s ."%' OR c.`nama_pasien` LIKE '%". $s ."%' OR d.`nama_pelayanan` LIKE '%". $s ."%' OR a.`kode_antrian` LIKE '%". $s ."%') AND a.`status_antrian` = 'Proses' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        } else{
            $q .= "WHERE a.`status_antrian` = 'Proses' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
            $dir = $this->db->escape_str($data['order'][0]['dir']);
            $col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
            if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_dokter') {
                    $q .= "ORDER BY b.`nama_dokter` ". $dir ." ";
                } elseif ($col == 'nama_pasien') {
                    $q .= "ORDER BY c.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'nama_pelayanan') {
                    $q .= "ORDER BY d.`nama_pelayanan` ". $dir ." ";
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

    function _list_dilayani($data = array())
    {
        $q = $this->_get_dilayani($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();
        
        return $r;
    }

    function _filtered_dilayani($data = array())
    {
        $q = $this->_get_dilayani($data);
        $r = $this->db->query($q, false)->result_array();
        
        return count($r);
    }

    function _all_dilayani($data = array())
    {
        $data['all'] = true;
        $q = $this->_get_dilayani($data);
        $r = $this->db->query($q)->result_array();
        
        return count($r);
    }
    
    function datatable_dilayani($data = array())
    {
        $result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list_dilayani($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all_dilayani($data),
                'recordsFiltered'   => $this->_filtered_dilayani($data),
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

    function _get_proses($data = array())
    {
        $d = date('Y-m-d');

        $q = "SELECT a.*, b.`nama_dokter`, c.`nama_pasien`, d.`nama_pelayanan` FROM `antrians` a LEFT JOIN `dokters` b ON a.`id_dokter` = b.`id` LEFT JOIN `pasiens` c ON a.`id_pasien` = c.`id` LEFT JOIN `jenis_pelayanans` d ON a.`id_jenis_pelayanan` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
            $s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`status_antrian` LIKE '%". $s ."%' OR a.`tgl_antrian` LIKE '%". $s ."%' OR b.`nama_dokter` LIKE '%". $s ."%' OR c.`nama_pasien` LIKE '%". $s ."%' OR d.`nama_pelayanan` LIKE '%". $s ."%' OR a.`kode_antrian` LIKE '%". $s ."%') AND a.`status_antrian` = 'Sedang Dilayani' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        } else{
            $q .= "WHERE a.`status_antrian` = 'Sedang Dilayani' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
            $dir = $this->db->escape_str($data['order'][0]['dir']);
            $col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
            if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_dokter') {
                    $q .= "ORDER BY b.`nama_dokter` ". $dir ." ";
                } elseif ($col == 'nama_pasien') {
                    $q .= "ORDER BY c.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'nama_pelayanan') {
                    $q .= "ORDER BY d.`nama_pelayanan` ". $dir ." ";
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

    function _list_proses($data = array())
    {
        $q = $this->_get_proses($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();
        
        return $r;
    }

    function _filtered_proses($data = array())
    {
        $q = $this->_get_proses($data);
        $r = $this->db->query($q, false)->result_array();
        
        return count($r);
    }

    function _all_proses($data = array())
    {
        $data['all'] = true;
        $q = $this->_get_proses($data);
        $r = $this->db->query($q)->result_array();
        
        return count($r);
    }
    
    function datatable_proses($data = array())
    {
        $result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list_proses($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all_proses($data),
                'recordsFiltered'   => $this->_filtered_proses($data),
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

    function _get_terlayani($data = array())
    {
        $d = date('Y-m-d');

        $q = "SELECT a.*, b.`nama_dokter`, c.`nama_pasien`, d.`nama_pelayanan` FROM `antrians` a LEFT JOIN `dokters` b ON a.`id_dokter` = b.`id` LEFT JOIN `pasiens` c ON a.`id_pasien` = c.`id` LEFT JOIN `jenis_pelayanans` d ON a.`id_jenis_pelayanan` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
            $s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`status_antrian` LIKE '%". $s ."%' OR a.`tgl_antrian` LIKE '%". $s ."%' OR b.`nama_dokter` LIKE '%". $s ."%' OR c.`nama_pasien` LIKE '%". $s ."%' OR d.`nama_pelayanan` LIKE '%". $s ."%' OR a.`kode_antrian` LIKE '%". $s ."%') AND a.`status_antrian` = 'Selesai' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        } else{
            $q .= "WHERE a.`status_antrian` = 'Selesai' AND a.`tgl_antrian` LIKE '". $d ."%' AND a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
            $dir = $this->db->escape_str($data['order'][0]['dir']);
            $col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
            if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_dokter') {
                    $q .= "ORDER BY b.`nama_dokter` ". $dir ." ";
                } elseif ($col == 'nama_pasien') {
                    $q .= "ORDER BY c.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'nama_pelayanan') {
                    $q .= "ORDER BY d.`nama_pelayanan` ". $dir ." ";
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

    function _list_terlayani($data = array())
    {
        $q = $this->_get_terlayani($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();
        
        return $r;
    }

    function _filtered_terlayani($data = array())
    {
        $q = $this->_get_terlayani($data);
        $r = $this->db->query($q, false)->result_array();
        
        return count($r);
    }

    function _all_terlayani($data = array())
    {
        $data['all'] = true;
        $q = $this->_get_terlayani($data);
        $r = $this->db->query($q)->result_array();
        
        return count($r);
    }
    
    function datatable_terlayani($data = array())
    {
        $result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list_terlayani($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all_terlayani($data),
                'recordsFiltered'   => $this->_filtered_terlayani($data),
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

    function layani($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $u = $data['userData'];
        $d = $data['postData'];
        $id = $d['id'];
        $q = "UPDATE `antrians` SET `status_antrian` = 'Sedang Dilayani' WHERE `id` = '". $this->db->escape_str($id) ."';";
        if ($this->db->simple_query($q)) {
            $result['result'] = true;
            $result['msg'] = 'Data berhasil diperbaharui.';
        } else{
            $result['msg'] = 'Terjadi kesalahan saat memperbaharui data.';
        }

        return $result;
    }

    function selesai($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $u = $data['userData'];
        $d = $data['postData'];
        $id = $d['id'];
        $q = "UPDATE `antrians` SET `status_antrian` = 'Selesai' WHERE `id` = '". $this->db->escape_str($id) ."';";
        if ($this->db->simple_query($q)) {
            $result['result'] = true;
            $result['msg'] = 'Data berhasil diperbaharui.';
        } else{
            $result['msg'] = 'Terjadi kesalahan saat memperbaharui data.';
        }

        return $result;
    }

    function info()
    {
        $result = array(
            'result'    => true,
            'msg'       => '',
            'data'      => array(
                'antrian'       => 0,
                'pembayaran'    => 0
            )  
        );

        $d = date('Y-m-d');

        $q = "SELECT COUNT(*) AS `total` FROM `antrians` WHERE `status_antrian` = 'Proses' AND `tgl_antrian` LIKE '". $d ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['data']['antrian'] = $r[0]['total'];
        }

        $q = "SELECT COUNT(*) AS `total` FROM `pembayarans` WHERE `status_pembayaran` = 'Selesai' AND `tgl_bayar` = '". $d ."' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['data']['pembayaran'] = $r[0]['total'];
        }

        return $result;
    }

}