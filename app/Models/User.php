<?php

namespace App\Models;

use App\Models\Traits\IntTimestampsHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, IntTimestampsHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * sub 内容
     * @author klinson <klinson@163.com>
     * @return mixed 默认返回当前主键的值
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * PAYLOAD 附加其他内容配置
     * @author klinson <klinson@163.com>
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
