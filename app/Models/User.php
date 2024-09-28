<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'ho_hp',
        'password',
        'kelamin',
        'pekerjaan',
        'tgl_lahir',
        'foto',
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

    public function getFoto(){
        $path_foto = $this->foto;
        // data:image/*;base64, {{ base64_encode(Storage::get($foto)) }}

        if($path_foto!=null){
            return "data:image/*;base64," .base64_encode(Storage::get($path_foto));
        }else{
            return  asset('/media/avatars/avatar15.jpg');
        }
    }
}
