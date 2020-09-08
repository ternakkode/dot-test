<?php 

use Illuminate\Http\Response;

if(!function_exists('pindahFile')){
    function pindahFile($file, $directory){
        return $file->move($directory, $file->getClientOriginalName());
    }
}

if(!function_exists('api_success')){
    function api_success($message, $data=null, $code=200){
        $output = [
            'success' => true,
            'message' => $message,
            'data'    => $data ?? null
        ];

        return response()->json($output, $code);
    }
}

if(!function_exists('api_error')){
    function api_error($message, $code=400){

        $output = [
            'success' => false,
            'message' => $message,
        ];
        
        return response()->json($output, $code);
    }
}