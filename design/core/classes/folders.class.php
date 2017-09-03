<?php
class folders{
    public function dir($path = ""){
        if($path == ""){
            $path = ($config['foto']);
        }else{
            $path = iconv("UTF-8", "WINDOWS-1251", (string)$path);
            $path = ($config['foto'].$path);
        }

        if(!is_dir($path)){return array();}
        
        $dirs = scandir($path);

        if(count($dirs) >= 1){
            $full_dirs = array();$i = 0;
            foreach($dirs as $dir){
                if($dir !== "." and $dir !== ".."){
                    $i++;
                    if(is_dir($path."/".$dir)){
                        $full_dirs[$i] = iconv("WINDOWS-1251", "UTF-8", (string)$dir);
                    }
                }
            }

            return $full_dirs;
        }
        return array();
    }

    public function menu(){
          
        $i = 0;
        foreach (self::dir() as $dir){
            if(count(self::dir($dir)) >= 1){
                $i++;
                $str = '<li>';
                $str .='<a data-toggle="collapse" href="#dir'.$i.'open" aria-expanded="false" aria-controls="collapseExample">
                    '.$dir.' <span class="pull-right scn"></span>
                </a>';
                $str .= '<ul class="collapse" id="dir'.$i.'open">';
                foreach(self::dir($dir) as $subdir){
                    $str .= '<li><a href="#">'.$subdir.'</a></li>';
                }
                $str .= '</ul>';
                $str .= '</li>';
            } else {
                $str = '<li>';
                $str .='<a data-toggle="collapse" href="URL">
                    '.$dir.'
                </a>';
                $str .= '</li>';
            }

            echo $str;
        }
    }
}

?>