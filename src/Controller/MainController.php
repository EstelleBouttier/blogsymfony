<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MainController extends AbstractController
{
    #[Route([
        'fr' => '/',
        'en' => '/en',
        'it' => '/it',
        'ru' => '/ru'
    ], name: 'app_main')]
    public function index(
        UsersRepository $users,
        CacheItemPoolInterface $cache
    ): Response {
        $utilisateur = $this->getOrSetCache(
            $cache,
            "user",
            fn ()=> $users->findAll()
        );

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    public function getOrSetCache(
        CacheItemPoolInterface $cache,
        string $key,
        callable $callback,
        int $ttl = 3600
        ): mixed {
            
            $item = $cache->getItem($key);
            if(!$item->isHit()) {
                $item->set($callback());
                $item->expiresAfter($ttl);
                $cache->save($item);
            }
            return $item->get();

    }
}
