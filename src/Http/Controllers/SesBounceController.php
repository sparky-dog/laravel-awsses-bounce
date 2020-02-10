<?php
namespace Fligno\SesBounce\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        if (null !== @$request['email'] && env('APP_ENV') != 'production' )
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $_request)
    {
        $request = ($_request->all() == null ?  json_decode($_request->getContent(), true) : $_request->all());
        $data=null;
        $statusCode = 200;
        
        if (null !== @$request['mail']['destination'] )
        {
            $bounce = AwsBouceList::firstOrNew(['email' => $request['mail']['destination']]);
            $bounce->email = $request['mail']['destination'][0];
            $bounce->source_ip = $request['mail']['sourceIp'];
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
