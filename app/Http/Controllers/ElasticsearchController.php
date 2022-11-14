<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
use Elastica\Client as ElasticaClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ElasticsearchController extends Controller
{
    public function es(Request $request)
    {
        $client = ClientBuilder::create()->build();
        
        $search = $request->input('search');
        $search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($search))))));
        if($search == '' || Str::length($search) == 0) {
            return redirect('/home');
        }
        $params = [
            'index' => 'webproject',
            'explain' => true,
            'from' => 0,
            'size' => 500,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $search,
                        'fields' => ['title','$year','abstract','wiki_terms','university','author','degree','program','advisor','$etd_file_id','pdf'],
                    ],
                    ],
                    'highlight' => [
                        "pre_tags" => ["<b>"],
                        "post_tags" => ["</b>"],
                        "fields" => [
                            "title" => new \stdClass(),
                            "abstract" => new \stdClass(),
                            "wiki_terms" => new \stdClass(),
                        ],
                        'require_field_match' => false
                    ],
                ]
            ];
        $results = $client->search($params);
        $count = $results['hits']['total']['value'];
        $response = $results['hits']['hits'];
        //echo "Success";

        if (Auth::check()) 
        {
            return view('serp');
        }
        else
        {
            return view('search');
        }        
     
        // ,compact('response','count'));
    
    }
    // public function callTest($sentStr){
    //     dd("IMcalledd??????", $sentStr);  
    // }

    // public function counter(Request $request)
    // {
    //         $client = ClientBuilder::create()->build();
    
    //         $params = [
    //             'index' => 'webproject',
    //             'body'  => [
    //                 'query' => [
    //                     'match_all' => new \stdClass()
    //                 ]
    //             ]
    //         ];
    //         $results = $client->search($params);
    //         $count = $results['hits']['total']['value'];
    //         $response = $results['hits']['hits'];
    //         return view('search' ,compact('response','count'));
    // }
    public function dissertation_details($id)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'webproject',
            'from' => 0,
            'size' => 500,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $id,
                        'fields' => ['title','$year','abstract','wiki_terms','university','author','degree','program','advisor','$etd_file_id','pdf'],
                    ],
                    ],
                    'highlight' => [
                        "pre_tags" => ["<mark>"],
                        "post_tags" => ["</mark>"],
                        "fields" => [
                            "title" => new \stdClass(),
                            "abstract" => new \stdClass(),
                            "wiki_terms" => new \stdClass(),
                        ],
                        'require_field_match' => false
                    ],
                ]
            ];
        // echo "Success";

        if (Auth::check()) 
        {
            return view('serp_summary',["id"=>$id])->withquery($params);
        }
        else
        {
            return view('summary',["id"=>$id])->withquery($params);
        }        

    }
    public function pdf($pdfid)
    {
        
        $file = '/Applications/XAMPP/xamppfiles/htdocs/PDF'."/$pdfid";
       //$filename = $pdfid;
          
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $file . '"');
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        @readfile($file);

        // header("content-disposition: attachment; filename=" .urlencode($filename));
        // $f = fopen($file,"r");
        // while(!feof($f))
        // {
        //     echo fread($f, 8192); 
        //}

    }
}   
