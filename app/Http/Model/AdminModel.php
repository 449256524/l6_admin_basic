<?php


namespace App\Http\Model;


use App\Http\Library\Common\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AdminModel extends Authenticatable
{
    use HasApiTokens, Notifiable, ModelTrait, SoftDeletes, HasRoles;

    /**
     * auth.guard名称
     *
     * @var
     */
    public $guard_name = 'admin_api';

    protected $table = 'BS_Admin';

    protected $guarded = ['id'];

    /**
     * 在数组中隐藏的属性
     *
     * @var array
     */
    protected $hidden = ['password', 'deleted_at'];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }

    public function getOneByUsername($username)
    {
        $params = [
            'where' => [
                [
                    'username',
                    $username
                ]
            ]
        ];
        return $this->getOne($params);
    }
}
