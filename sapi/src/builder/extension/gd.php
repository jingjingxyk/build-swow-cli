<?php

use SwooleCli\Library;
use SwooleCli\Preprocessor;
use SwooleCli\Extension;

return function (Preprocessor $p) {
    $options = '--enable-gd --with-jpeg --with-freetype --with-webp ';
    $depends = ['libjpeg', 'freetype', 'libwebp', 'libpng', 'libgif'];

    if ($p->getInputOption('with-libavif')) {
        $options .= ' --with-avif ';
        $depends[] = 'libavif';
    }

    $ext = (new Extension('gd'))
        ->withHomePage('https://www.php.net/manual/zh/book.image.php')
        ->withOptions($options);
    call_user_func_array([$ext, 'withDependentLibraries'], $depends);
    $p->addExtension($ext);

    $p->withExportVariable('FREETYPE2_CFLAGS', '$(pkg-config  --cflags --static  libbrotlicommon libbrotlidec libbrotlienc freetype2 zlib libpng)');
    $p->withExportVariable('FREETYPE2_LIBS', '$(pkg-config    --libs   --static  libbrotlicommon libbrotlidec libbrotlienc freetype2 zlib libpng)');
};
