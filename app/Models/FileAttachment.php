<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileAttachment extends Model
{
    protected $fillable = ['filename', 'path', 'attachable_id', 'attachable_type'];

    public function attachable()
    {
        return $this->morphTo();
    }
}
