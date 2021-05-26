<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByClassInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

trait FilterByClassInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByClassInterface methods">
    public function filterByClass(string $class, bool $strict=true) : CollectionInterface
    {
        return $this->filterByClasses([$class], $strict);
    }

    public function filterByClasses(iterable $classes, bool $strict=true) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        /**
         * Validate Classes
         */
        $classes = IterableHelper::map($classes, static function($class){
            if(!is_string($class)){
                throw new \InvalidArgumentException(
                    sprintf(
                        'Given item in class collection is not of type string, "%s" given',
                        gettype($class)
                    )
                );
            }

            if(!class_exists($class)){
                throw new \InvalidArgumentException("Class '$class' does not exists");
            }

            return $class;
        });

        return $this->filter(static function($v) use ($classes, $strict){
            if(!is_object($v)){
                return false;
            }

            if(false === $strict) {
                return array_filter($classes, static function ($class) use ($v) {
                    return get_class($v) === $class || is_subclass_of($v, $class);
                });
            }

            foreach($classes as $class){
                if(get_class($v) === $class){
                    return true;
                }
            }

            return false;
        });
    }

    public function filterByClassRecursive(string $className) : CollectionInterface
    {
        return $this->filterByClassesRecursive([$className]);
    }

    public function filterByClassesRecursive(iterable $classes) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = $this->getEmptyInstance();

        $classes = IterableHelper::toArray($classes);

        $filter = static function($item, $offset) use (&$filter, $collection, $classes){
            foreach($classes as $className){
                if(is_object($item) && get_class($item) === $className){

                    if($collection instanceof AppendableInterface){
                        return $collection->append($item, $offset);
                    }

                    $collection->setItem($item, $offset);
                }
            }

            if($item instanceof \Traversable){
                foreach($item as $o => $i){
                    $filter($i, $o);
                }
            }

            return null;
        };

        foreach($this as $offset => $item){
            $filter($item, $offset);
        }

        return $collection;
    }
    //</editor-fold>
}