<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public string $title;
    public string $body;
    public string $date;
    public string $slug;

    public  function __construct($title,$body,$date,$slug)
    {
        $this->title=$title;
        $this->body=$body;
        $this->date=$date;
        $this->slug=$slug;
    }
    public static function find($slug)
    {
        return static::all()->firstWhere('slug',$slug);
    }



    public static  function all(){

        return cache()->rememberForever('posts.all',function (){
            $files=File::files(resource_path("posts"));
            return collect($files)->map(function ($file){
                $doc = YamlFrontMatter::parseFile($file);
                return new Post(
                    $doc->matter('title'),
                    $doc->body(),
                    $doc->matter('date'),
                    $doc->matter("slug"),
                );
            })->sortBy('date');
        });









//       return array_map(function ($file){
//           $doc = YamlFrontMatter::parseFile($file);
//           return new Post(
//               $doc->matter('title'),
//               $doc->body(),
//               $doc->matter('date')
//
//           );
//       },$files);






//        $posts=[];
//        foreach ($files as $file ) {
////            $doc = YamlFrontMatter::parseFile($file);
////
////            $posts[] = new Post(
////                $doc->matter('title'),
////                $doc->body(),
////                $doc->matter('date')
////
////            );
//
//        }
//        return $posts;

    }





}
