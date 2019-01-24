<?php
class User extends CI_Controller {
    public function index() {
        $this->load->model('muser');
        $data = $this->muser->get();
        echo "<table border='1'><tr><th>No</th><th>Username</th><th>Email</th><th>Fullname</th><th>Status</th><tr>";
        $no = 0;
        foreach ($data as $item ) {
            $no++;
            $id = $item->id;
            $username = $item->username;
            $email = $item->email;
            $fullname = $item->fullname;
            $status = $item->status;
            echo "<tr>";
            echo "<td>$no</td><td>$username</td><td>$email</td><td>$fullname</td><td>$status</td>";
            echo "</tr>";
            
            
        }
        echo "</table>";
    }

    public function add() {
        $data = [
            "id" => "",
            "username" => "niam",
            "password" => password_hash('12345678', PASSWORD_DEFAULT),
            "fullname" => "Wahid Niam",
            "email" => "email@iam.com",
            "status" => 1,
            "registered" => date('Y-m-d h:m:s:ss')
        ];
        $this->load->model('muser');
        $this->muser->save($data);
    }

}


?>