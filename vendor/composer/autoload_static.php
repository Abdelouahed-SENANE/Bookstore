<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc0b1ae6a52ef6f57a423caecbffdd1fd
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc0b1ae6a52ef6f57a423caecbffdd1fd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc0b1ae6a52ef6f57a423caecbffdd1fd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc0b1ae6a52ef6f57a423caecbffdd1fd::$classMap;

        }, null, ClassLoader::class);
    }
}
