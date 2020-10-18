<?php
declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    /**
     * @var string|null
     */
    private $user_id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $open_id;

    /**
     * @var string
     */
    private $skey;

    /**
     * @var int
     */
    private $credit;

    /**
     * @param string|null  $user_id
     * @param string    $nickname
     * @param string    $avatar
     * @param string    $open_id
     * @param string    $skey
     * @param int    $credit
     */
    public function __construct(?string $user_id, string $nickname, string $avatar, string $open_id, string $skey, int $credit)
    {
        $this->user_id = $user_id;
        $this->nickname = $nickname;
        $this->avatar = $avatar;
        $this->open_id = $open_id;
        $this->skey = $skey;
        $this->credit = $credit;
    }

    /**
     * @return string|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getOpenId()
    {
        return $this->open_id;
    }

    /**
     * @return string
     */
    public function getSkey()
    {
        return $this->skey;
    }

    /**
     * @return int
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'user_id' => $this->user_id,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'open_id' => $this->open_id,
            'skey' => $this->skey,
            'credit' => $this->credit
        ];
    }
}
