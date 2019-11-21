<?php


namespace App\Listeners;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Events\AccessTokenCreated;

class RevokeOldTokens
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(AccessTokenCreated $accessTokenCreated)
    {
        DB::table('oauth_access_tokens')
          ->where([
              [
                  'client_id',
                  $accessTokenCreated->clientId,
              ],
              [
                  'id',
                  '!=',
                  $accessTokenCreated->tokenId,
              ],
              [
                  'user_id',
                  $accessTokenCreated->userId,
              ],
          ])
          ->update(['revoked' => 1]);
    }
}
