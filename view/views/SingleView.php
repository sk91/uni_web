<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SingleView
 *
 * @author max
 */
class SingleView extends FrontView{
   
    private $filename='single.html';
    
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
        $this->template=new Template($this->filename, $vars);
        
        return $this->render();
    }
    
}



?>
