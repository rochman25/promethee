<?php

class DataModel extends CI_Model
{

    function custom($q)
    {
        $query = $this->db->query($q);
        return $query;
    }

    function select($col)
    {
        $query = $this->db->select($col);
        return $query;
    }

    function getWhere($col, $kon)
    {
        $query = $this->db->where($col, $kon);
        return $query;
    }

    function getWhereArr($array)
    {
        $query = $this->db->where($array);
        return $query;
    }

    function getData($table)
    {
        $query = $this->db->get($table);
        return $query;
    }

    function getJoin($table, $condition, $type)
    {
        $query = $this->db->join($table, $condition, $type);
        return $query;
    }

    function distinct($col)
    {
        $query = $this->db->distinct();
        $query = $this->db->select($col);
        return $query;
    }

    function insert($table, $data)
    {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    public function insert_multiple($table,$data)
    {
        $query = $this->db->insert_batch($table, $data);
        return $query;
    }

    public function update_multiple($table,$data,$id){
        $query = $this->db->update_batch($table,$data,$id);
        return $query;
    }

    function update($table, $data)
    {
        $query = $this->db->update($table, $data);
        return $query;
    }

    function delete($col, $condition, $table)
    {
        $query = $this->db->where($col, $condition);
        $query = $this->db->delete($table);
        return $query;
    }

    function Login($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
}
