<?php 
class Msetting extends CMS_Model {
    public function __construct(){
        $table = "settings";
        parent::__construct($table);
    }

}
?>