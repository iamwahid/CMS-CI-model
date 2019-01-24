<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {
    public function index() {
        $this->load->model('mpost');
        $data = $this->mpost->get();
        // $data = $this->page();
        echo "<ul>";
        foreach ($data as $value) {
            $title = $value->title;
            $content = $value->content;
            $slug = $value->slug;
            echo "<li>";
            echo "<b>$title</b><br>$content"." <a href='single/$slug'>here</a>";
            echo "</li>";
        }
        echo "</ul>";

        // echo $this->pagination->create_links();
        
    }

    public function add() {
        $judul = "City in Indonesia";
        $data = [
            "id" => "",
            "author" => 1,
            "title" => $judul,
            "content" => "PonorogoxMadiun, Jakarta, Bandung",
            "status" => 0,
            "slug" => strtolower(str_replace(' ', '-', $judul)),
            "parent" => 0,
            "post_type" => "post",
            "post_created" => date('Y-m-d h:m:s:ss'),
            "post_modified" => time(),
        ];
        $this->load->model('mpost');
        $this->mpost->save($data);
    }

    public function single($id) {
        $this->load->model('mpost');
        $data = $this->mpost->getById($id, 'slug');
        $title = $data->title;
        $author = $data->author;
        $content = $data->content;
        echo "<h1>$title</h1>";
        echo "<p>author by : $author</p>";
        echo "<p>$content</p>";

    }

    public function cari($keyword) {
        $this->load->model('mpost');
        $data = $this->mpost->search($keyword, 'content');
        foreach ($data as $value) {
            $judul = $value->title;
            $isi = $value->content;
            echo $judul." : $isi <br>";
        }
    }

    public function page() {
        $this->load->model('mpost');
        $total = $this->mpost->countTotal();
        $this->load->library('pagination');
        $config['base_url'] =  base_url().'index.php/post/page/';
        $config['total_rows'] = $total;
        $config['per_page'] = 5;
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $post = $this->mpost->show($config['per_page'],$from);
        foreach ($post as $value) {
            echo $value->title."<br>";
            echo $value->id."<br>";
        }

        echo "<br>";
        echo $this->pagination->create_links();
    }

}


?>