<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use PDO;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var PDO
     */
    private $conn;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param PDO $conn
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function detail(string $user_id): User
    {
        $sql = "SELECT * FROM User WHERE user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $user_id);
        $q->execute();
        $r = $q->fetch();
        if ($r == null) {
            throw new UserNotFoundException();
        }

        return new User($r['user_id'], $r['nickname'], $r['avatar'], $r['open_id'], $r['skey'], (int) $r['credit']);
    }

    /**
     * {@inheritdoc}
     */
    public function login(string $user_id, string $open_id, string $skey, string $nickname, string $avatar): User
    {
        // User exists ?
        $sql1 = "SELECT user_id, credit FROM User WHERE open_id=?";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $open_id);
        $q1->execute();
        $exist_user = $q1->fetch();

        if (!$exist_user)
        {
            $credit = 0;
            $sql2 = "INSERT INTO User (user_id, nickname, avatar, open_id, skey, credit)
                     VALUES (?, ?, ?, ?, ?, ?)";
            $q2 = $this->conn->prepare($sql2);
            $q2->bindParam(1, $user_id);
            $q2->bindParam(2, $nickname);
            $q2->bindParam(3, $avatar);
            $q2->bindParam(4, $open_id);
            $q2->bindParam(5, $skey);
            $q2->bindParam(6, $credit);
        }
        else
        {
            $user_id = $exist_user['user_id'];
            $credit = $exist_user['credit'];
            $sql2 = "UPDATE User SET nickname=?, avatar=?, skey=? WHERE open_id=?";
            $q2 = $this->conn->prepare($sql2);
            $q2->bindParam(1, $nickname);
            $q2->bindParam(2, $avatar);
            $q2->bindParam(3, $skey);
            $q2->bindParam(4, $open_id);
        }
        $q2->execute();

        return new User($user_id, $nickname, $avatar, $open_id, $skey, (int) $credit);
    }

    /**
     * {@inheritdoc}
     */
    public function credits(string $user_id): int
    {
        $sql = "SELECT credit FROM User WHERE user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $user_id);
        $q->execute();
        $credit = (int) $q->fetch()['credit'];
        return $credit;
    }
}
