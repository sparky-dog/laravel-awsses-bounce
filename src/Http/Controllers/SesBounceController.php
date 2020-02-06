<?php
namespace Fligno\SesBounce\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Fligno\SesBounce\Models\AwsBouceList;
use Fligno\SesBounce\Mail\TestMail;

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

        if (null !== @$request['email'])
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

        if (null !== @$request['mail']['destination'])
        {
            $bounce = AwsBouceList::firstOrNew(['email' => $request['mail']['destination']]);
            $bounce->email = $request['mail']['destination'][0];
            $bounce->source_ip = $request['mail']['sourceIp'];
            $bounce->save();
        }
        $data['status'] = 'Ok'; 
        $statusCode = 200;

        return response()->json($data, $statusCode, array(), JSON_PRETTY_PRINT);
    }


}
