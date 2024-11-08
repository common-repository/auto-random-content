<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6c19d5147995106742b2483aeea675f7
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
    );

    public static $classMap = array (
        'arc_AutoRandomContent' => __DIR__ . '/../..' . '/inc/Class/arc_AutoRandomContent.php',
        'arc_AutoRandomContentTable' => __DIR__ . '/../..' . '/inc/Class/arc_AutoRandomContentTable.php',
        'arc_Comment' => __DIR__ . '/../..' . '/inc/Class/arc_Comment.php',
        'arc_DashBoardWidget' => __DIR__ . '/../..' . '/inc/Class/arc_DashBoardWidget.php',
        'arc_ManageAdminBarButton' => __DIR__ . '/../..' . '/inc/Class/arc_ManageAdminbarButton.php',
        'arc_ManageAjaxRequest' => __DIR__ . '/../..' . '/inc/Class/arc_ManageAjaxRequest.php',
        'arc_ManageAssets' => __DIR__ . '/../..' . '/inc/Class/arc_ManageAssets.php',
        'arc_ManageLogs' => __DIR__ . '/../..' . '/inc/Class/arc_ManageLogs.php',
        'arc_ManagePluginActivate' => __DIR__ . '/../..' . '/inc/Class/arc_ManagePluginActivate.php',
        'arc_ManageTranslation' => __DIR__ . '/../..' . '/inc/Class/arc_ManageTranslation.php',
        'arc_Media' => __DIR__ . '/../..' . '/inc/Class/arc_Media.php',
        'arc_Post' => __DIR__ . '/../..' . '/inc/Class/arc_Post.php',
        'arc_RandomContentOptionPage' => __DIR__ . '/../..' . '/inc/Class/arc_RandomContentOptionPage.php',
        'arc_Taxonomy' => __DIR__ . '/../..' . '/inc/Class/arc_Taxonomy.php',
        'arc_Term' => __DIR__ . '/../..' . '/inc/Class/arc_Term.php',
        'arc_User' => __DIR__ . '/../..' . '/inc/Class/arc_User.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6c19d5147995106742b2483aeea675f7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6c19d5147995106742b2483aeea675f7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6c19d5147995106742b2483aeea675f7::$classMap;

        }, null, ClassLoader::class);
    }
}
