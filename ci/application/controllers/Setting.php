<?php
class Setting extends CI_Controller {
    public function index() {
        $this->load->model('msetting');
        $data = $this->msetting->get();
        echo "<table border='1'><tr><th>No</th><th>ID</th><th>Name</th><th>Value</th><tr>";
        $no = 0;
        foreach ($data as $item ) {
            $no++;
            $id = $item->id;
            $name = $item->name;
            $value = $item->value;
            echo "<tr>";
            echo "<td>$no</td><td>$id</td><td>$name</td><td>$value</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function add() {
        $data = [
            "id" => "",
            "name" => "add post",
            "value" => "allowed"
        ];
        $this->load->model('msetting');
        $this->msetting->save($data);
    }

}


?>