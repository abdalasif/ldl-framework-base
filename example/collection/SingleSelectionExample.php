<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SingleSelectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\SingleSelectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Exception\LockingException;

class SingleSelectionCollection implements CollectionInterface, AppendableInterface, SingleSelectionInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use SingleSelectionInterfaceTrait;
}

echo "Create collection instance\n";
$collection  = new SingleSelectionCollection();

echo "Append item 123 using my_key_1 as key\n";
$collection->append('123','my_key_1');

echo "Append item 456 using my_key_2 as key\n";
$collection->append('456','my_key_2');

echo "Check if collection has a selection (must return false)\n";

var_dump($collection->hasSelection());

echo "Select item my_key_1 in collection\n";
$collection->select('my_key_1');

echo "Check if collection has a selection (must return true)\n";

var_dump($collection->hasSelection());

echo "Is selection locked?\n";
var_dump($collection->isSelectionLocked());

echo "Get selected item key\n";
var_dump($collection->getSelectedKey());

echo "Selected item value\n";
var_dump($collection->getSelectedItem());

echo "Lock selection\n";
$collection->lockSelection();

echo "Try to select another item, exception must be thrown (due to the selection being locked)\n";

try {
    $collection->select('my_key_2');
}catch(LockingException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}