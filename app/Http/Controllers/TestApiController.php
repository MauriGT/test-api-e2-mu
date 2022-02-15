<?php

namespace App\Http\Controllers;

use App\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class TestApiController extends Controller
{
    public function index(){
        $url='https://jsonplaceholder.typicode.com/photos';
        $helper=new Helpers();
        $response =$helper->get($url) ;

        if($response->successful() && !$response->failed()){

            $body=json_decode($response->body());
            foreach ($body as $item){
                try {
                    DB::table('images')->insert([
                        'title'=>$item->title,
                        'url'=>$item->url,
                        'thumbnailUrl'=>$item->thumbnailUrl,
                        'albumId'=>$item->albumId,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                    ]);
                }catch (\Exception $exception){
                    return  $exception;
                }
            }

            return "Los Datos Han sido importados correctamente";
        }
        return "Error los datos no han podido ser importados";

    }
}
