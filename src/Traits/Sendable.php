<?php
namespace Fligno\SesBounce\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Fligno\SesBounce\Models\AwsBouceList;
use Fligno\SesBounce\Mail\TestMail;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;


// TODO add something here
trait Sendable {

    /**
     * Get the request Array
     * @param \Illuminate\Http\Request  $request
     *  email:String
     * @return \Illuminate\Http\Response
     */
    public function send_bounce($data){
        Mail::to($data['email'])->send(new TestMail());
        $response = array([
           'status'=>'OK',
        ]);

        return $response;
    }

    public function get_bounce_list(){
        $emails = AwsBouceList::all();
        return $emails;
    }

    public function unblock_email($data){
        // grab the email
        $email = AwsBouceList::query()->find($data->id)->first();
        //Block or Unblock Complaints/Email
        $affected_rows = DB::table('aws_bouce_lists')->where('id', $data->id)->delete();
        return [$email];
    }
}