<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit45fc565c7d48a2c37f2504ef2e3c75ee
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RestJson\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RestJson\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit45fc565c7d48a2c37f2504ef2e3c75ee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit45fc565c7d48a2c37f2504ef2e3c75ee::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
