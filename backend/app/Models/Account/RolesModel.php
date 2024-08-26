<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = "id";
    protected $fillable = ['name'];
    protected $guard_name = 'web';

    public function bossAccess($user){
        $uRoles = $user->getRoleNames();
        $nvalRoles = [];
        foreach($uRoles as $role){
            $roleModel = $this->where("name", $role)->get()->first();
            if($roleModel['level'] < 3)array_push($nvalRoles, $roleModel['level']);
        }
        if(count($nvalRoles) == count($uRoles)) return false;
        else return true;
    }
    public function admAccess($user){
        $uRoles = $user->getRoleNames();
        $nvalRoles = [];
        foreach($uRoles as $role){
            $roleModel = $this->where("name", $role)->get()->first();
            if($roleModel['level'] < 2)array_push($nvalRoles, $roleModel['level']);
        }
        if(count($nvalRoles) == count($uRoles)) return false;
        else return true;
    }
    public function emplAccess($user){
        $uRoles = $user->getRoleNames();
        $nvalRoles = [];
        foreach($uRoles as $role){
            $roleModel = $this->where("name", $role)->get()->first();
            if($roleModel['level'] < 1)array_push($nvalRoles, $roleModel['level']);
        }
        if(count($nvalRoles) == count($uRoles)) return false;
        else return true;
    }
}
