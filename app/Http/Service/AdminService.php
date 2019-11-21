<?php


namespace App\Http\Service;


use App\Events\ApiExceptionEvents;
use App\Http\Model\AdminModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminService extends BaseService
{
    /**
     * 管理员表
     *
     * @var \App\Http\Model\AdminModel
     */
    private $adminModel;

    public function __construct(AdminModel $adminModel)
    {
        $this->adminModel = $adminModel;
    }

    /**
     * 登录
     *
     * @param string $account
     * @param string $password
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(string $account, string $password)
    {
        /**
         * @var \App\Http\Model\AdminModel $user
         */
        $user = $this->adminModel->getOneByUsername($account);

        if (empty($user)) {
            event(new ApiExceptionEvents(10000));
        }

        if (!(Hash::check($password, $user->password))) {
            event(new ApiExceptionEvents(10001));
        }

        if ($user->status == config('table.admin.status.off')) {
            event(new ApiExceptionEvents(10002));
        }

        $client = new Client();

        try {
            $request = $client->request('POST', request()->root() . '/oauth/token', [
                'form_params' => config('passport.admin_api') + ['username' => $account, 'password' => $password],
            ]);

        } catch (RequestException $e) {
            event(new ApiExceptionEvents(10003));
        }

        if ($request->getStatusCode() == 401) {
            event(new ApiExceptionEvents(10003));
        }

        return json_decode($request->getBody()->getContents(), true);
    }

    /**
     * 登出
     *
     * @return void
     */
    public function logout()
    {
        /**
         * @var \Laravel\Passport\Token $accessToken
         */
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')
          ->where('access_token_id', $accessToken->id)
          ->update([
              'revoked' => 1,
          ]);

        $accessToken->revoke();

        return;
    }

    /**
     * 管理员资料
     *
     * @return array
     */
    public function getPersonalInfo()
    {
        return Auth::user()->toArray();
    }
}
