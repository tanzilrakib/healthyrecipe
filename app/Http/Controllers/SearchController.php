<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Guzzle\Common\Exception\MultiTransferException;
use Guzzle\Http\Message\RequestInterface;
use GuzzleHttp\Pool;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Auth;
use Session;
use App\Recipe;
use App\User;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $appId;
    protected $appKey;
    protected $client;

    public function __construct(){

        $this->appId = config('services.edamam.appId');

        $this->client = new GuzzleHttpClient();

        $this->appKey = config('services.edamam.appKey');


    }



    public function paginateRecipes($pageIndex){

    }


    public function sendQuery(Request $request)
    {
        //

        $input = $request->all();
        

        $pageIndexes = [
            [ 'from' => 0, 'to' => 8],
            [ 'from' => 8, 'to' => 16],
            [ 'from' => 16, 'to' => 24],
            [ 'from' => 24, 'to' => 32],
            [ 'from' => 32, 'to' => 40],
            [ 'from' => 40, 'to' => 48],
            [ 'from' => 48, 'to' => 56],
            [ 'from' => 56, 'to' => 64],
        ];

        // dd($input);

        if(!Auth::guest()){
            $bookedIds = Auth::user()->recipes()->pluck('uri')->toArray(); 
            foreach ($bookedIds as $b) {
                $bookedUris[] = "http://www.edamam.com/ontologies/edamam.owl#". $b;
            }

        }


        $q=$input['query'];

        $url = "https://api.edamam.com/search?q=".$q."&app_id=".$this->appId."&app_key=".$this->appKey;
//      
        if(!is_null($input['from']) || !is_null($input['to'])){
           $url .= "&from=".$input['from']."&to=".$input['to'];
        } else {
            $url .= "&from=0&to=8";
        }

        !is_null($input['diet'])? $url .= "&diet=". strtolower($input['diet']) : '';
        !is_null($input['health'])? $url .= "&health=". strtolower($input['health']) : '';
        
        // dd($url);

        $apiRequest = $this->client->request('GET', $url, ['verify' => false]);

        $data = json_decode($apiRequest->getBody());
        
        // dd($data);
        
        if(!Auth::guest()){
            if(count($data->hits)>0 && isset($bookedUris)){
                foreach ($data->hits as $key => $value) {
                    foreach ($bookedUris as $booked) {
                        if($value->recipe->uri === $booked ){
                            $data->hits[$key]->userBooked = true;
                            break;                        
                        }                  
                    }
                }
            }
        }
        // dd($data);
        return view('home')->with('data',$data)->with('query',$input)->with('pageIndexes',$pageIndexes);
    }


    public function bookmark($uri)
    {
        //
        $user = Auth::user();

        $toDelete = $user->recipes()->where('uri', '=', $uri)->first();

        if(count($toDelete)>0){
            $toDelete->delete();
        } 

        else{

            if(count($user->recipes()->get())<=16){

                $usedBefore = $user->recipes()->onlyTrashed()->where('uri', '=', $uri)->first();
                if(count($usedBefore)>0){
                    $usedBefore->restore();
                }
                else{

                    $bookmark = new Recipe;
                    $bookmark->user_id = $user->id;
                    $bookmark->uri = $uri;
                    $user->recipes()->save($bookmark);
                }
            } else{
                session()->flash('max','Maximum limit reached!');
            }
        
        }
    

        return redirect()->back();
    }


    // function getId ($uri)
    // {
    //     if (!is_bool(strpos($uri, "#")))
    //     return substr($uri, strpos($uri,"#")+strlen("#"));
    // }


    public function getSavedRecipes(){

        $savedUris = Auth::user()->recipes()->pluck('uri')->toArray();

        if(count($savedUris)>0){
            foreach ($savedUris as $b) {
                $bookedUris[] = "https://api.edamam.com/search?r=http://www.edamam.com/ontologies/edamam.owl%23". $b;
            }

            foreach ($bookedUris as $uri) {
                 $req = $this->client->request('GET', $uri, ['verify' => false]);
                 $apiRequests[] = json_decode($req->getBody())[0];
            }

            return view('saved')->with('data', $apiRequests);
        }
        else{
            $apiRequests = []; 
            return view('saved')->with('data', $apiRequests);
        }
    }



}
