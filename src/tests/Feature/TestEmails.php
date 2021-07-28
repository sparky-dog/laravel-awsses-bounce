<?php


namespace Tests\Feature;

use Fligno\SesBounce\Mail\TestMail;
use Fligno\SesBounce\Models\AwsBouceList;
use Fligno\SesBounce\Traits\Sendable;
use http\Env\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TestEmails extends TestCase
{
    use Sendable;
    public function test_get(){
        $response = $this->get('/api/awsbounce/get');
        $response->assertStatus(200);
        $this->assertNotEquals(0, $response);
    }

    public function test_black_list(){
        $emails = AwsBouceList::query()->where('email', 'blockable@blocked.com');
        $this->assertNotEquals(0 ,$emails->count(), 'It\'s not in the bounce list');
    }

    public function test_unblock(){
        DB::table('aws_bouce_lists')->where('id', 3)->delete();
        $this->assertDeleted('aws_bouce_lists', ['id' => 1]);
    }
}

