<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ReCaptcha;
use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
use Elastica\Client as ElasticaClient;
use Illuminate\Support\Str;
use DB;
use Mail;
use Auth;
use Hash;

class MainController extends Controller
{

    function home()
    {
        return view ('home');
    }

    function login()
    {
        return view('login');
    }

    function register()
    {
        return view('register');
    }    

    function login_auth(Request $request)
    {
        $this->validate($request, [
        'email'   => 'required|email',
        'password'  => 'required|alphaNum|min:5',
        'g-recaptcha-response' => ['required',new ReCaptcha]
        ]);
        
            $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
            );

            if(Auth::attempt($user_data))
            {
                return redirect('/twofactor');
            }
            else
            {
                return back()->with('error', 'Incorrect details');
            }
        


    }
    public function get_key()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();            
            if ($user->getRememberToken() == null) {
                $token = Str::random(32);
                $user->setRememberToken($token);
                $user->save();
            }
            return response()->json(['Key' => $user->getRememberToken()], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function api_search()
    {
        require '/Users/sanjanabolla/example-app/vendor/autoload.php';

        $client = ClientBuilder::create()->build();

        $search = request('query');
        $number = request('range');
        $key = request('key');

        $keys_in_db = (array)DB::select('SELECT remember_token FROM users'); //chng
        $keys_json = json_encode($keys_in_db); //chng
        //echo strpos($keys_json, $key);
        if($key!== null)
        {
            if(strpos($keys_json, $key) !== false) 
            {
                $params = [
                    'index' => 'webproject2',
                    'explain' => true,
                    'from' => 0,
                    'size' => 500,
                    'body'  => [
                        'query' => [
                            'multi_match' => [
                                'query' => $search,
                                'fields' => ['title','abstract','university','author','degree','program','advisor'],
                            ],
                        ],
                    ]
                ];
                $results = $client->search($params);
                $count = $results['hits']['total']['value'];
                $res = $results['hits']['hits'];
                $rank=1;

                    foreach($res as $r)
                    {
                        if($rank <= $number)
                        {
                            $output[$rank]['title'] = $results['hits']['hits'][$rank-1]['_source']['title'];
                            $output[$rank]['abstract'] = $results['hits']['hits'][$rank-1]['_source']['abstract'];
                            $output[$rank]['university'] = $results['hits']['hits'][$rank-1]['_source']['university'];
                            $output[$rank]['author'] = $results['hits']['hits'][$rank-1]['_source']['author'];
                            $output[$rank]['degree'] = $results['hits']['hits'][$rank-1]['_source']['degree'];
                            $output[$rank]['program'] = $results['hits']['hits'][$rank-1]['_source']['program'];
        
                            $rank+=1;
                        }
                    } 
                    $final_output = json_encode($output);

                    if($final_output!= null)
                    {
                        return ($final_output);
                    }
                    else
                    {
                        return response()->json(['No results found'], 200);
                    }
            
            }
            else 
            {
                return response()->json(['error' => 'UnAuthorised Access'], 401);
            }
        }
        else
        {
            echo "Unauthorized user";
        }
    }


    function logout()
    {
        Auth::logout();
        return redirect('/home');
    }

    function edit_profile()
    {
        $user = auth()->user();
        $data['user']=$user;
        return view('updateinfo',$data);
    }

    function update_profile(Request $request)
    {
         $request->validate([
            'firstname' => 'required|min:2|max:70',
            'lastname' => 'required|min:2|max:70',
         ],[
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required',
         ]);

         $user =auth()->user();

         $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
         ]);

         return redirect('/profile')->with('success','Profile is successfully updated');
    }

    function change_password()
    {
        return view('change_password');
    }

    function update_password(Request $request)
    {
         $request->validate([
            'old_password' => 'required|min:5',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ],[
            'old_password.required' => 'Current password is required',
            'new_password.required' => 'New Password is required',
            'confirm_password.required' => 'Confirm Password is required'
         ]);

         $current_user = auth()->user();

         if(Hash::check($request->old_password,$current_user->password)){
            $current_user->update([
                'password' => $request->new_password
            ]);
            return redirect('/index')->with('success','Password is successfully updated');

         }else{
            return redirect('/change_password')->with('error','Current password does not match');
         }
    }

    protected function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }

    
    function uploadetd()
    {
        return view('upload_etd');
    }
    

}
 