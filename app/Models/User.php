<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group() {
        return $this->belongsTo('App\Models\Group');
    }

    /**
     * Obtém a lista de usuários pela pesquisa
     *
     * @param [type] $query
     * @param [type] $request
     * @return $query
     */
    public function scopeSearch($query, $request = null) {

        $query->select("u.*", "g.name as group_name")->from("users as u")
            ->join("groups as g", "g.id", "u.group_id");

        if ($request) {

            if ($request->search) {

                $search = trim($request->search);

                //Insere as condições where nas colunas pela pesquisa.
                getWheresQuery($query, $search, ["u.name", "u.email", "g.name"]);

            }

        }

        return $query;

    }
    
}
