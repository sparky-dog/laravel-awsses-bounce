<?php
namespace Fligno\SesBounce\Src\Http\Controllers;

use Fligno\SesBounce\Src\Http\Controllers\Controller;
use Carbon\Traits\Test;
use Illuminate\Http\Request;
use Fligno\Auth\Src\Models\NewsLetter;
use DB;
use Mail;

use Fligno\SesBounce\Src\Models\AwsBouceList;
use Fligno\SesBounce\Src\Mail\TestMail;
use Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;

use Fligno\SesBounce\Src\Traits\Sendable;

class SesBounceController extends Controller
{

    /**
     * Send Test Email
     * @param \Illuminate\Http\Request  $request
     *  email:String
     * @return \Illuminate\Http\Response
     */

    public function send(Request $_request)
    {
        $request = ($_request->all() == null ?  json_decode($_request->getContent(), true) : $_request->all());

        // check if API is on production
        if (env('APP_ENV') == 'local' ) return response(["status"=>"App in production"], 422);

        if(!$request){
            Mail::to($request['email'])->send(new TestMail());
            $data['status'] = "Ok";
            $statusCode = 200;
        }else{
            $data['status'] = "Empty Request";
            $statusCode = 200;
        }
        return response($data);
    }

    public function get(){
        $emails = AwsBouceList::all();
        return response($emails);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $_request)
    {
        if(!$_request){

            return response(['status'=>"Empty Request"]);
        }
        // run the SES bounce
        else {

            $request = ($_request->all() == null ?  json_decode($_request->getContent(), true) : $_request->all());
            $data=null;
            $statusCode = 200;

            if (null !== @$request['email']['destination'] )
            {
                $bounce = AwsBouceList::firstOrNew(['email' => $request['mail']['destination']]);
                $bounce->email = $request['mail']['destination'][0];
                $bounce->source_ip = $request['mail']['sourceIp'];
                $bounce->status = $request['bounce']['bouncedRecipients']['status'];
                $bounce->code =  $request['bounce']['bouncedRecipients']['diagnosticCode'];
                $bounce->save();

                $statusCode = 201;
                $data['status'] = 'Created';
            }

            if (@$request['Type'] == "SubscriptionConfirmation" )
            {
                Log::info("AWS SES Subscription Link:" . $request['SubscribeURL']);
                $headers = [
                    'headers' => [
                        'Accept' => 'application/json',
                    ]
                ];
                $client = new Client(['base_uri' => $request['SubscribeURL']]);

                try {
                    $response  = $client->request('GET');
                    $statusCode = $response->getStatusCode();
                }catch(ClientException $e) {
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();
                }catch(ConnectException $e) {
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();
                }catch(BadResponseException $e) {
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();
                }

                $data['status'] = 'SubscribeURL: '.$statusCode;
            }

            return response()->json($data, $statusCode, array(), JSON_PRETTY_PRINT);
        }

    }

 public function Block(Request $request)
 {

        $contact = NewsLetter::find($request->id);
        AwsBouceList::create(['email'=>$contact->email,
        'source_ip' =>request()->ip(),
        'code' => 'blocked by admin' ]);
        return $this->get();
 }

 public function Unblock($id)
 {
     AwsBouceList::where('id',$id)->delete();
     return $this->get();
 }
}
