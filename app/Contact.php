<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    public function creator() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function deletor() {
        return $this->belongsTo('App\User', 'deleted_by');
    }

    public function updator() {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
            