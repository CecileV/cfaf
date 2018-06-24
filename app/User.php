<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_connexion_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relations
     *
     */
    public function creator() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function deletor() {
        return $this->belongsTo('App\User', 'deleted_by');
    }

    public function updator() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function roles() {
      return $this
        ->belongsToMany('App\Role')
        ->withTimestamps();
    }

    public function articles() {
      return $this
        ->belongsToMany('App\Article')
        ->withTimestamps();
    }

    public function categories() {
      return $this
        ->belongsToMany('App\Category')
        ->withTimestamps();
    }

    public function tags() {
      return $this
        ->belongsToMany('App\Tag')
        ->withTimestamps();
    }

    public function species() {
      return $this
        ->belongsToMany('App\Specie')
        ->withTimestamps();
    }

    /**
     * Roles
     *
     */
    public function authorizeRoles($roles)
    {
      if ($this->hasAnyRole($roles)) {
        return true;
      }
      abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
      if (is_array($roles)) {
        foreach ($roles as $role) {
          if ($this->hasRole($role)) {
            return true;
          }
        }
      } else {
        if ($this->hasRole($roles)) {
          return true;
        }
      }
      return false;
    }

    public function hasRole($role)
    {
      return $this->roles()->where('name', $role)->first();
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
