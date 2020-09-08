<?php 

if(!function_exists('prosesUpload')){
    function pindahFile($file, $directory){
        return $file->move($directory, $file->getClientOriginalName());
    }
}