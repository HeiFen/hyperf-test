<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id 
 * @property string $uuid 
 * @property string $name 
 * @property string $phone 
 * @property string $password 
 * @property string $avatar 
 * @property int $gender 
 * @property int $age 
 * @property string $device 
 * @property string $oaid_idfa 
 * @property int $client 
 * @property string $channel 
 * @property string $version 
 * @property string $model 
 * @property int $login_type 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class User extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'gender' => 'integer', 'age' => 'integer', 'client' => 'integer', 'login_type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
