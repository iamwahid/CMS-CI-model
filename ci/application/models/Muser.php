<?php 
class Muser extends CMS_Model {
    public function __construct(){
        $table = "users";
        parent::__construct($table);
    }

    public function search($keyword, $column = 'username', $from = 0, $num = 0) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like($column, $keyword);
        if ($num > 0 || $from > 0) {
            $this->db->limit($num, $from);
        }

        return $this->db->get();
    }

    public function show($offset, $limit) {
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table);

    }

    

}
?>