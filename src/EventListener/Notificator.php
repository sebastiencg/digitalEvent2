<?php

namespace App\EventListener;

use App\Entity\Point;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

class Notificator
{
    private $publisher;

    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function postUpdate(Point $point, PostUpdateEventArgs $event ): void
    {

        $javascriptUpdate = [
            "party"=>$point->getUsername()->getParty(),
        ];
        $json=json_encode($javascriptUpdate);
        $update=new Update("points",$json);
        $this->publisher->__invoke($update);

    }
}