<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;


class Role extends SpatieRole
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'uuid';
    protected $table = 'roles';
    protected $fillable =  ['name', 'guard_name'];

    public function user(){
        return $this->belongsTo("App\Models\User"); 
    }
    
}
