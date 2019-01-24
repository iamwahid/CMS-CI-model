<?php
class Post extends CI_Controller {
    public function index() {
        $this->load->model('mpost');
        $data = $this->mpost->get();
        
        
    }

    public function add() {
        $data = [
            "id" => "",
            "author" => 1,
            "title" => "New Post",
            "content" => "New Post",
            "status" => 0,
            "slug" => "New-Post",
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
}


?>