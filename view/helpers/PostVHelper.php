<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostVHalper
 *
 * @author max
 */
class PostVHelper extends ViewHelper implements SingleViewInterface {
    private $post;
    
    public function __construct($id) {
        $model=new PostModel();
        parent::__construct($model);
        $this->post=$model->getPost($id);
        if($this->post===false){
            throw new InvalidArgumentException;
        }
    }
    

    public function getCommentCount() {
        return $this->post->getCommentCount();
    }

    public function getComments() {
        //TODO handle comments
        return "";
    }

    public function getCommentsStatus() {
        return $this->post->getCommentStatus();
    }

    public function getContent() {
        return $this->post->getContent();
    }

    public function getCreateDate() {
        return $this->post->getCreateDate();
    }

    public function getExcerpt() {
        return $this->post->getExcerpt();
    }

    public function getID() {
        return $this->post->getId();
    }

    public function getMeta() {
        return $this->post->getMeta();
    }
    

    public function getPublishDate() {
        return $this->post->getPublishDate();
    }

    public function getStatus() {
        return $this->post->getStatus();
    }

    public function getTitle() {
        return $this->post->getTitle();
    }
    
    public function isStaffOnly(){
        return $this->post->getStaffOnly()==1;
    }

   public function getPost(){
       return $this->post;
   }
}

?>
