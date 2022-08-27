<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

function generateUuid($extId){
    if($extId == ""){
        $uuid = Uuid::uuid4()->toString();
    }else{
        $uuid = $extId;
    }

    return $uuid;
}

function generateFilePath($pathImage, $file, $nomeCartella){
    if($pathImage !== null){
        $path = $pathImage;
    }else{
        $path = "";
    }

    if($file !== null){
        $date = (int) Carbon::now()->valueOf();
        $fileExt = $file->getClientOriginalExtension();
        $filename = $date.'.'.$fileExt;

        $path = Storage::putFileAs('public/'.$nomeCartella , $file, $filename);
    }

    return $path;
}