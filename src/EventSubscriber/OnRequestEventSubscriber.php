<?php

namespace App\EventSubscriber;

use App\Doctrine\DatabaseConnection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class OnRequestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'selectDatabase', 10000
            ]
        ];
    }

    public function selectDatabase(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $mode = $request->get('mode', 'prod');

        $connection = $this->em->getConnection();
        if (!$connection instanceof DatabaseConnection) {
            throw new \RuntimeException('Wrong connection');
        }
        $databaseName = $mode === 'test' ? 'app_db_test' : 'app_db';
        $connection->selectDatabase($databaseName);
    }
}
