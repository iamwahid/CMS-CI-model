<?php 
class Muser extends CMS_Model {
    public function __construct(){
        $table = "users";
        parent::__construct($table);
    }

}
?>