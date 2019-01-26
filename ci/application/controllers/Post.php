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
        echo "<form action='' method='post'>";
        echo "<input type='text' name='title' required placeholder='Post Title'><br>";
        echo "<textarea name='content' required placeholder='Post Content'></textarea>";
        echo "<select name='status'>";
        echo "<option value='0' disabled selected hidden>Pilih</option>";
        echo "<option value='1'>Satu</option>";
        echo "<option value='2'>Dua</option>";
        echo "</select>";
        echo "<input type='submit' name='submit' value='Submit'><br>";
        echo "</form>";



        if ($this->input->post('submit', TRUE) != null) {
            $judul = $this->input->post('title', TRUE);
            $this->load->model('mpost');
            $data = [
            "id" => "",
            "author" => 1,
            "title" => $judul,
            "content" => $this->input->post('content', TRUE),
            "status" => $this->input->post('status', TRUE),
            "slug" => $this->mpost->makeslug($judul, 0) ,
            "parent" => 0,
            "post_type" => "post",
            "post_created" => date('Y-m-d h:m:s:ss'),
            "post_modified" => time(),
            ];
        
        $this->mpost->save($data);
        }
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

    public function cari() {
        $keyword = $this->input->get('keyword', TRUE);
        $this->load->model('mpost');
        $this->load->library('pagination');
        $total = $this->mpost->search($keyword, 'content')->num_rows();
        $config['base_url'] =  base_url().'index.php/post/cari?keyword='.$keyword;
        $config['total_rows'] = $total;
        $config['per_page'] = 6;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $pagenum = $this->input->get('page', TRUE);
        $from = ($pagenum  == 0) ? 0 : ($pagenum * $config['per_page']) - $config['per_page']; //page number dari perkalian halaman dan perpage
        $data = $this->mpost->search($keyword, 'content', $from, $config['per_page']);
        foreach ($data->result() as $value) {
            $judul = $value->title;
            $isi = $value->content;
            $id = $value->id;
            echo $id." ".$judul." : $isi <br>";
        }

        echo "<br>";
        echo $this->pagination->create_links();
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