<?php
class User extends CI_Controller {
    public function index() {
        $this->load->model('muser');
        $data = $this->muser->get();
        $total = $this->muser->countTotal();
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php/user';
        $config['total_rows'] = $total;
        $config['per_page'] = 5;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $pagenum = $this->input->get('page', TRUE); 
        $offset = ($pagenum  == 0) ? 0 : ($pagenum * $config['per_page']) - $config['per_page'];
        $data = $this->muser->show($offset, $config['per_page']);

        echo "<table border='1'><tr><th>No</th><th>Username</th><th>Email</th><th>Fullname</th><th>Status</th><tr>";
        $no = 0;
        foreach ($data->result() as $item ) {
            $no++;
            $id = $item->id;
            $username = $item->username;
            $email = $item->email;
            $fullname = $item->fullname;
            $status = $item->status;
            echo "<tr>";
            echo "<td>$id</td><td>$username</td><td>$email</td><td>$fullname</td><td>$status</td>";
            echo "</tr>";
            
            
        }
        echo "</table>";
        echo "<br>";
        echo $this->pagination->create_links();
    }

    public function add() {
        echo "<form action='' method='post'>";
        echo "<input type='text' name='username' required placeholder='Username'><br>";
        echo "<input type='password' name='password' required placeholder='Password'><br>";
        echo "<input type='text' name='fullname' required placeholder='Full Name'><br>";
        echo "<input type='email' name='email' required placeholder='Email'><br>";
        echo "<select name='status'>";
        echo "<option value='0' disabled selected hidden>Pilih</option>";
        echo "<option value='1'>Satu</option>";
        echo "<option value='2'>Dua</option>";
        echo "</select>";
        echo "<input type='submit' name='submit' value='Submit'><br>";
        echo "</form>";

        if ($this->input->post('submit', TRUE) != null) {
            $data = [
                "id" => "",
                "username" => $this->input->post('username', TRUE),
                "password" => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                "fullname" => $this->input->post('fullname', TRUE),
                "email" => $this->input->post('email', TRUE),
                "status" => $this->input->post('status', TRUE),
                "registered" => date('Y-m-d h:m:s:ss')
            ];

            $this->load->model('muser');
            $this->muser->save($data);
        }
        
    }

    public function cari() {
        $keyword = $this->input->get('keyword', TRUE);
        $this->load->model('muser');
        $this->load->library('pagination');
        $total = $this->muser->search($keyword, 'fullname')->num_rows();
        $config['base_url'] =  base_url().'index.php/user/cari?keyword='.$keyword;
        $config['total_rows'] = $total;
        $config['per_page'] = 5;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $pagenum = $this->input->get('page', TRUE);
        $from = ($pagenum  == 0) ? 0 : ($pagenum * $config['per_page']) - $config['per_page']; //page number dari perkalian halaman dan perpage
        $data = $this->muser->search($keyword, 'fullname', $from, $config['per_page']);
        foreach ($data->result() as $value) {
            $username = $value->username;
            $fullname = $value->fullname;
            $id = $value->id;
            $email = $value->email;

            echo $id." ".$username." : $email : $fullname <br>";
        }

        echo "<br>";
        echo $this->pagination->create_links();
    }

}


?>