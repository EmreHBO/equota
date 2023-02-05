<?php

namespace App\Traits;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
trait ResourceTrait
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var null
     */
    private $doctrine = null;

    /**
     * @return void
     */
    public function getDoctrine()
    {
        $this->doctrine = $this->container->get('doctrine');
    }

    /**
     * @return EntityManager
     */
    public function getManager(): EntityManager
    {
        if ($this->doctrine == null) {
            $this->getDoctrine();
        }

        return $this->doctrine->getManager();
    }

    /**
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository(string $class): EntityRepository
    {
        return $this->getManager()->getRepository($class);
    }


}