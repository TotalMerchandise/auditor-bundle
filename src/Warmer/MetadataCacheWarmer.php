<?php

namespace DH\AuditorBundle\Warmer;

use DH\Auditor\Provider\Doctrine\Configuration;
use DH\Auditor\Provider\Doctrine\DoctrineProvider;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class MetadataCacheWarmer implements CacheWarmerInterface
{
    private DoctrineProvider $doctrineProvider;

    public function __construct(DoctrineProvider $doctrineProvider)
    {
        $this->doctrineProvider = $doctrineProvider;
    }

    /**
     * If a metadata cache is defined in configuration then this will 'getEntities()' and cache the result in the
     * provided Symfony PSR-6 Cache
     */
    public function warmUp(string $cacheDir)
    {
        /** @var Configuration $configuration */
        $configuration = $this->doctrineProvider->getConfiguration();

        if (null !== $configuration->getMetadataCache()) {
            $this->doctrineProvider->getConfiguration()->getEntities();
        }
    }

    public function isOptional(): bool
    {
        return true;
    }
}