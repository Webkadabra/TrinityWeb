<?php

namespace core\components\filesystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use trntv\filekit\filesystem\FilesystemBuilderInterface;

/**
 * Class LocalFlysystemProvider
 */
class LocalFlysystemBuilder implements FilesystemBuilderInterface
{
    public $path;

    /**
     * @return Filesystem|mixed
     */
    public function build()
    {
        $adapter = new Local(\Yii::getAlias($this->path));
        return new Filesystem($adapter);
    }
}
