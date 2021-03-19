<?php declare(strict_types=1);

namespace LDL\Framework\Base\Exception\Combined;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;

interface CombinedExceptionInterface extends \Throwable, CollectionInterface, AppendableInterface, RemovableInterface, LockAppendInterface, LockRemoveInterface
{
    public function getCombinedMessage();
}