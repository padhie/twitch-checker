<?php

$packages = [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
];

if (file_exists(__DIR__ . '/bundles_dev.php')) {
    $packages = array_merge(
        $packages,
        include(__DIR__ . '/bundles_dev.php')
    );
}

return $packages;
