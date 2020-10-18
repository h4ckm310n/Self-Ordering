<?php
declare(strict_types=1);


namespace App\Application\Actions\User;


use App\Domain\User\FailedLoginException;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Handler\Curl;


class UserLoginAction extends UserAction
{
    /**
     * {@inheritdoc}
     * @throws FailedLoginException
     */
    protected function action(): Response
    {
        $body = $this->getFormData();
        $code = $body->code;
        $appid = $this->request->getAttribute('appid');
        $appsecret = $this->request->getAttribute('appsecret');

        $api = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $login_result = json_decode(Curl\Util::execute($ch, 3));
        if (isset($login_result->errcode))
            throw new FailedLoginException;

        $open_id = $login_result->openid;
        $session_key = $login_result->session_key;
        $skey = md5($open_id.$session_key.strval(rand()));
        $user_id = md5($open_id.strval(rand()));
        $nickname = $body->nickname;
        $avatar = $body->avatar;
        $user = $this->userRepository->login($user_id, $open_id, $skey, $nickname, $avatar);
        $result = ['user_id' => $user->getUserId(),
                   'skey' => $user->getSkey(),
                   'nickname' => $user->getNickname(),
                   'avatar' => $user->getAvatar()];

        return $this->respondWithData($result);
    }
}
