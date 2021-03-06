<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Auth;

class Category extends Model
{
	use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relations
     *
     */
    public function articles() {
      return $this
        ->belongsToMany('App\Article')
        ->withTimestamps();
    }

    public function creator() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function deletor() {
        return $this->belongsTo('App\User', 'deleted_by');
    }

    public function updator() {
        return $this->belongsTo('App\User', 'updated_by');
    }


    /**
     * Created_by, Updated_by and deleted_by 
     *
     * @param  Request  $request
     * @return Response
     */
    public static function boot() {
        parent::boot();

        static::creating(function($table)  {
            if(Auth::user()){
                $table->created_by = Auth::user()->id;
            }
        });
        static::updating(function($table)  {
            if(Auth::user()){
                $table->updated_by = Auth::user()->id;
            }
        });
        static::deleting(function($table)  {
            if(Auth::user()){
                $table->deleted_by = Auth::user()->id;
                $table->update();
            }
        });
    }
    
}
