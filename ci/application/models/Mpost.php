<?php 
class Mpost extends CMS_Model {
    public function __construct(){
        $table = "posts";
        parent::__construct($table);
    }

    public function search($keyword, $column = 'title') {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like($column, $keyword);
        return $this->db->get()->result();
    }

    function show($num, $offs) {
        return $query  = $this->db->get($this->table, $num, $offs)->result();
    }

}
?>