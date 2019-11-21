<?php

namespace App\Listeners;

use App\Events\ApiExceptionEvents;
use App\Http\Library\Common\ErrorResolve;

class ThrowException
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
     * @param  ApiExceptionEvents $event
     *
     * @return void
     */
    public function handle(ApiExceptionEvents $event)
    {
        ErrorResolve::throwException($event->code);
    }
}
