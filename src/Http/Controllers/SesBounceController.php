<?php
namespace Fligno\SesBounce\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Fligno\SesBounce\Models\AwsBouceList;
use Fligno\SesBounce\Mail\TestMail;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;

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

        if ($_request->email)
        {
            Mail::to($request['email'])->send(new TestMail());        
            $data['status'] = 'Ok';
            $statusCode = 200;
        }
        else
        {       
            $data['status'] = 'Invalid Request. Email required!';
            $statusCode = 400;

        }
        return response()->json($data, $statusCode, array(), JSON_PRETTY_PRINT);
    }

    public function get(){
        $emails = AwsBouceList::all();
        return response($emails);
    }

    public function edit(Request $request){
        // grab the email
        $email = AwsBouceList::all();

        //Block or Unblock Complaints/Email
        $affected_rows = DB::table('aws_bouce_lists')->where('id', $request->id)->delete();

        return response([$email]);
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

            if ($request['email']['destination'] )
            {
                $bounce = AwsBouceList::firstOrNew(['email' => $request['mail']['destination']]);
                $bounce->email = $request['mail']['destination'][0];
                $bounce->source_ip = $request['mail']['sourceIp'];
                $bounce->save();
                $statusCode = 201;
                $data['status'] = 'Created';
            }

            if ($request['Type'] == "SubscriptionConfirmation" )
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


}
