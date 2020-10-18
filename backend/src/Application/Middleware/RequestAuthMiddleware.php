<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\User\UserRepository;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class RequestAuthMiddleware implements Middleware
{
    /**
     * @var PDO
     */
    private $conn;

    /**
     * RequestAuthMiddleware constructor.
     * @param PDO $conn
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (strpos($request->getHeaderLine('Referer'), 'https://servicewechat.com/wx2ec19f6dd5a52d16/') === false)
        {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Invalid Referer');
            return $response;
        }

        $path = $request->getUri()->getPath();
        $allow_paths = ['/user/login', '/dishes'];
        foreach ($allow_paths as $allow_path)
        {
            if (strpos($path, $allow_path) !== false)
                return $handler->handle($request);
        }

        $skey = str_replace('Bearer ', '', $request->getHeaderLine('Authorization'));
        $user_id = $request->getParsedBody()->user_id;

        $sql = "SELECT COUNT(*) AS N FROM User WHERE user_id=? AND skey=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $user_id);
        $q->bindParam(2, $skey);
        $q->execute();
        $n = (int) ($q->fetch()['N']);
        if ($n == 0)
        {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Invalid Session');
            return $response;
        }
        return $handler->handle($request);

    }
}