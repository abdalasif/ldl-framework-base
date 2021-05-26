<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByInterface
{
    /**
     * @param string $interface
     *
     * @throws \InvalidArgumentException
     *
     * @return CollectionInterface
     */
    public function filterByInterface(string $interface) : CollectionInterface;

    /**
     * If the strict parameter is passed, the item must conform to all passed interfaces
     *
     * @param iterable $interfaces
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @return CollectionInterface
     */
    public function filterByInterfaces(iterable $interfaces, bool $strict=true) : CollectionInterface;

    /**
     * @param string $interface
     * @return CollectionInterface
     */
    public function filterByInterfaceRecursive(string $interface) : CollectionInterface;

    /**
     * @param iterable $interfaces
     * @return CollectionInterface
     */
    public function filterByInterfacesRecursive(iterable $interfaces) : CollectionInterface;
}