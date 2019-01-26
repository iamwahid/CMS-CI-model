<?php 
class Mpost extends CMS_Model {
    public function __construct(){
        $table = "posts";
        parent::__construct($table);
    }

    public function search($keyword, $column = 'title', $from = 0, $num = 0) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like($column, $keyword);
        if ($num > 0 || $from > 0) {
            $this->db->limit($num, $from);
        }

        return $this->db->get();
    }

    function show($offs, $num) {
        return $query  = $this->db->get($this->table, $offs, $num)->result();
    }

    public function searchcount($keyword, $column = 'title')
	{
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like($column, $keyword);
		$q = $this->db->get();
		return $q->num_rows();
    }
    
    public function makeslug($title, $count = 0) {
        $temp_slug = strtolower(str_replace(' ', '-', $title));
        $count++;
        if ( $this->isUnique('slug', $temp_slug) ) {
            return $temp_slug;
        } else {
            return $this->makeslug($title.' '.$count, $count);
        }
    }

}
?>