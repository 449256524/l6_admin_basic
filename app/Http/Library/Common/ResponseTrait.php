<?php


namespace App\Http\Library\Common;


trait ResponseTrait
{
    public function response($code,string $message,array $data)
    {
        return response()->json(compact('code', 'message', 'data'));
    }

    public function success(array $data = [],$code = 0)
    {
        return $this->response($code, ErrorResolve::resolve($code), $data);
    }

    public function error($code,string $message)
    {
        return $this->response($code, $message, []);
    }
}
