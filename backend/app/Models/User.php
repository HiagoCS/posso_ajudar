<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $table = 'user_tb';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'password',
        'email'
      ];
    protected $hidden = ['password'];

    public $timestamps = false;

    public function validateData($data){
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['response' => "Invalid Email", "stts" => 500];
        }
        $user_data = ['name' => $data['name'], 'password' => $data['password'], 'email' => $data['email']];
        return [
            'user_data' => $user_data
        ];
    }
    public function store($user){
        $user = $this->create($user);
        if($user)
            return ['response' => "Usuário Criado", "stts" => 200, "user" => $user];
    }
}
