<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreatePostView
 *
 * @author max
 */
class EditPostView extends BackView{
    
    public function get() {
        $vars=$this->generalVars();
        $hlpr=$this->viewHelper;
        $vars['title']=$hlpr->getTitle();
        $vars['content']=$hlpr->getContent();
        $vars['excerpt']=$hlpr->getExcerpt();
        $vars['meta']=$hlpr->getMeta();
        $vars['created']=$hlpr->getCreateDate();
        $vars['published']=$hlpr->getPublishDate();
        $vars['comments']=$hlpr->getComments();
        $vars['comment_count']=$hlpr->getCommentCount();
        $vars['status']=$hlpr->getStatus();
        $vars['comments_status']=$hlpr->getCommentsStatus();
        $vars['id']=$hlpr->getID();
        $vars['comments_possible']=$hlpr->commentsPossible();
        $vars['author']=$hlpr->getAuthor();
       
        $this->template=new Template($this->filename, $vars);
        return $this->render();
    }

    public function post() {
        if(isset($_POST['edit_post_form'])){
            if(!$this->viewHelper->save()){
               return get();
            }else{
                Utils::redirect($this->viewHelper->getSuccessUrl());
            }
        }
    }
    
    
      
    

}

?>
