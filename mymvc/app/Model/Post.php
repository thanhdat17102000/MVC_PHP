<?php

namespace App\Model;

class Post extends \Core\Model {

    const table = 'post_content';
    const m_id = 'id';
    const m_title = 'm_title';

    public function __construct() {
        parent::__construct();
        $this->db->table(self::table);
    }

    public function addPost($data = []) {
        $this->db->reset()->insert($data);
    }
    public function update($id, $data = []) {
        $this
                ->db
                ->reset()
                ->where([
                    self::m_id => $id])
                ->update($data);
    }

    public function getList() {
        return $this
                        ->db
                        ->reset()
                        ->order([
                            self::m_id => "desc"
                        ])
                        ->get()
                        ->result();
    }

    public function delete($id = 0) {
        $this
                ->db
                ->reset()
                ->where([
                    self::m_id => $id
                ])
                ->delete();
    }
    
    public function getDetail($id){
        $list = $this
                        ->db
                        ->reset()
                        ->where([
                            self::m_id => $id
                        ])
                        ->get()
                        ->result();
        if ($list == false){
            return false;
        }
        return $list[0];
    }

}
