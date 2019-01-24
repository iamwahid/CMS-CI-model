<?php 
class Mpost extends CMS_Model {
    public function __construct(){
        $table = "posts";
        parent::__construct($table);
    }

}
?>