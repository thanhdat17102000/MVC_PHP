<?php
namespace App\Controller;
class Post extends \Core\Controller{
//    show danh sach
    public function index(){
        $postModel = new \App\Model\Post();
        $list = $postModel->getList();
        $this->view('post/index',[
            'list' => $list
        ]);
    }

    public function getList(){
        $postModel = new \App\Model\Post();
        $list = $postModel->getList();
        echo json_encode($list, JSON_UNESCAPED_UNICODE);
    }
    /**
     * Ham hien thi chi tiet bai viet
     * 
     * @param int $id ID cua bai viet can hien thi
     */
    public function detail($id){
        $this->view('post/detail',[
            'id' => $id
        ]);
    }
    
    public function add(){
        $postModel = new \App\Model\Post();
        $postModel->addPost([
            \App\Model\Post::m_title => $_POST['title']
        ]);
        header('location: ' . \App\Config\Routes::getBaseUrl() . 'Post');
    }
    public function delete($id){
        $postModel = new \App\Model\Post();
        $postModel->delete($id);
        header('location: ' . \App\Config\Routes::getBaseUrl() . 'Post');
    }
    public function formEdit($id){
        $postModel = new \App\Model\Post();
        $postDetail = $postModel->getDetail($id);
        $this->view('post/formEdit',[
            'detail' => $postDetail
        ]);
    }
    public function update($id){
        $postModel = new \App\Model\Post();
        $postModel->update($id, [
            \App\Model\Post::m_title => $_POST['title']
        ]);
        header('location: ' . \App\Config\Routes::getBaseUrl() . 'Post');
    }
}