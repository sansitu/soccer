<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleModel extends Model
{
	protected $table = 'roles';

	/**
     * Used to get the user role id
     *
     * @param int $userId
     * @return int
     */
	public static function getUserRole($userId)
    {
        return DB::table('user_role')->where('user_id', $userId)->value('role_id');
    }
}