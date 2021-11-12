<?php

namespace Fligno\SesBounce\Src\Models;

use Illuminate\Database\Eloquent\Model;

class AwsBouceList extends Model
{


    protected $table = 'aws_bouce_lists';

    protected $fillable = [
        'email',
        'source_ip',
        'status',
        'code'
    ];

}
