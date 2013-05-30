<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Post
 *
 * @author max
 */
class Post extends Controller {

    /**
     * A list of all posts 
     */
    public function index() {
        $rg = Registry::getInstance();
        $params = $rg->uri->params;
        $page=1;
        if (isset($params[0]) && is_numeric($params[0]) && $page>$params[0]) {
            $page= (int) ($params[0]);
        }
    }

    /**
     * Show spescific post 
     */
    public function show() {
        $rg = Registry::getInstance();
        $params = $rg->uri->params;
        $id = false;
        if (isset($params[0]) && is_numeric($params[0])) {
            $id = (int) ($params[0]);
        }
        if ($id === false) {
            $this->view = new PageNotFoundView();
            Utils::debug("Invalid parameter");
        } else {
            try {
                $helper = new PostVHelper($id);
                $am = AccessManager::getInstance();
                $user = $rg->user;
                if ($am->canViewPost($helper->getPost(),$user)) {
                    $this->view = new SingleView($helper);
                } else {
                    $this->view = new PageAccessDeniedView();
                    Utils::debug("Object with id=$id cannot be accesed");
                }
            } catch (InvalidArgumentException $exc) {
                $this->view = new PageNotFoundView();
                Utils::debug("Object with id=$id was not found<br>{$exc->getMessage()}");
            }
        }
    }

    /**
     * Show posts for a tag 
     */
    public function tag() {
        print 'Tag posts';
    }

    /**
     * Admin access
     * Show edit a post 
     */
    public function edit() {
        print 'Edit a post';
    }

    /**
     * Admin access
     * Create new Post 
     */
    public function create_post() {
        $rg=  Registry::getInstance();
        $this->create("CreatePageViewHelper",$rg->access_manager->canCreatePost());

    }
    
    public function create_page(){
        $rg=  Registry::getInstance();
        $this->create("CreatePostViewHelper",$rg->access_manager->canCreatePage());
        
    }
    
    private function create($vhelper,$access){
        if(!$access){
            $this->view = new PageAccessDenied();
            return;
        }
        $viewHelper=new $vhelper();
        $this->view= new EditPostView($viewHelper);
    }

    /**
     * Admin access
     * Delete a post 
     */
    public function delete() {
        print 'Delete a post';
    }

    /**
     * Admin access
     * List of post with management buttons 
     */
    public function manage() {
        print 'manage posts';
    }

}

?>
