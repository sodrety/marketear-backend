<?php

namespace App\Services;

use App\Models\TokenHistory;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TokenService
{
    public function checkToken($userId)
    {
        $checkUser = User::find($userId);
        
        if (!$checkUser) {
            throw new HttpException(404, 'User not found');
        }

        return $checkUser->token;
    }

    public function addToken($userId, $amount = 10)
    {

        $checkUser = User::find($userId);
        
        if (!$checkUser) {
            throw new HttpException(404, 'User not found');
        }

        $checkUser->token = $checkUser->token + $amount;
        $checkUser->save();

        $history = new TokenHistory();
        $history->user_id = $userId;
        $history->type = 'plus';
        $history->amount = $amount;
        $history->save();

        return $checkUser;

    }

    public function minusToken($userId, $amount = 10)
    {

        $checkUser = User::find($userId);
        
        if (!$checkUser) {
            throw new HttpException(404, 'User not found');
        }

        $checkUser->token = $checkUser->token - $amount;
        $checkUser->save();

        $history = new TokenHistory();
        $history->user_id = $userId;
        $history->type = 'minus';
        $history->amount = $amount;
        $history->save();

        return $checkUser;

    }
}
