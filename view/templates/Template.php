<?php

class Template {

    protected $filename;
    protected $vars;
    protected $template_root;

    public function __construct($filename, $vars = array(), $template_root = null) {
        if (!is_array($vars)) {
            $vars = array();
        }
        if($template_root==null){
            $template_root=SITE_STATIC.DS."html";
        }
        $this->filename = $filename;
        $this->vars = $vars;
        $this->template_root = $template_root;
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

    public function __get($name) {
        return $this->vars[$name];
    }

    public function render() {
        $output = '';
        if (file_exists($this->template_root . DS . $this->filename)) {
            extract($this->vars);
            
            ob_start();

            include $this->template_root . DS . $this->filename;

            $output = ob_get_clean();
        }
        return $output;
    }

}

?>
