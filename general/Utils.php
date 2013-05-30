<?php

/**
 * Description of utils
 *
 * @author Max
 */
class Utils {

    public static function parseURI() {
        $uriData = new stdClass();
        $uri=  substr($_SERVER["REQUEST_URI"],  strlen(Settings::PATH_FROM_ROOT)+1);
        $uriData->uri = explode('/', $uri);

        $uriData->controller = (isset($uriData->uri[0])) ? $uriData->uri[0] : 'main';
        $uriData->action = (isset($uriData->uri[1])) ? $uriData->uri[1] : 'main';
        $uriData->params = array();
       
        for ($i = 2; $i < count($uriData->uri); $i++) {
            if(!empty($uriData->uri[$i])){
                $uriData->params[] = $uriData->uri[$i];
            }
        }

        return $uriData;
    }

    public static function debug($msg) {
        if (Settings::DEBUG) {
            print "<br>$msg</br>";
        }
    }
    
    
    public static function redirect($url){
        header("Location: $url");
        exit();
    }

}

?>
