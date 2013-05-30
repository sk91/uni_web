<?php

class PostModel extends Model {
    
    public function savePost(array $postData){
        //TODO save post data implementation
    }
    
    public function getPost($id) {
        $post = $this->findPosts("id=?", array($id));
        if (empty($post)) {
            return false;
        }
        return $post[0];
    }

    public function getPosts($ids) {
        $where = $db->prepareWhereidsList($ids);
        return $this->findPosts($where->format, $where->data);
    }

    public function findPosts($where = "", $whereData = null, $orderBy = null, $offset = 0, $limit = -1,  $fetchType = PDO::FETCH_OBJ) {
        //preparing sql

        $baseSelect = $this->db->prepareBasicSelect(Schema::POSTS);
        $limit = $this->db->prepareLimit($offset, $limit);
        $orderBy = $this->db->prepareOrderBy($orderBy);
        if (!empty($where)) {
            $where = "WHERE $where";
        }
        $statement = "$baseSelect $where $orderBy $limit";
        //execute query
        $statement = $this->db->prepare($statement);
        $statement->execute($whereData);
        $posts = $statement->fetchAll($fetchType);
        //rurn std classes to Post Objects
        if ($posts !== false) {
            foreach ($posts as $pind => $post) {
                $postObject = null;
                if ($post->type==PageObject::PAGE_OBJECT_TYPE) {
                    $postObject = PageObject::getFromStd($post);
                } else {
                    $postObject = PostObject::getFromStd($post);
                }
                $posts[$pind] = $postObject;
            }
        }
        return $posts;
    }
    
    public function getPostsCount($where = "", $whereData = null){
        $baseSelect = $this->db->prepareBasicSelect(Schema::POSTS,'COUNT(*)');
        if (!empty($where)) {
            $where = "WHERE $where";
        }
        $statement = "$baseSelect $where";
        //execute query
        $statement = $this->db->prepare($statement);
        $statement->execute($whereData);
        $count = $statement->fetch(PDO::FETCH_COLUMN);
        return $count;
    }

}

?>
