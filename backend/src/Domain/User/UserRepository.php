<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @param string $user_id
     * @return User
     * @throws UserNotFoundException
     */
    public function detail(string $user_id): User;

    /**
     * @param string $user_id
     * @param string $open_id
     * @param string $skey
     * @param string $nickname
     * @param string $avatar
     * @return User
     */
    public function login(string $user_id, string $open_id, string $skey, string $nickname, string $avatar): User;

    /**
     * @param string $user_id
     * @return int
     */
    public function credits(string $user_id): int;
}
