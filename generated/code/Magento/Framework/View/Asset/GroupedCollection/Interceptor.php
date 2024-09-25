<?php
namespace Magento\Framework\View\Asset\GroupedCollection;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\GroupedCollection
 */
class Interceptor extends \Magento\Framework\View\Asset\GroupedCollection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Asset\PropertyGroupFactory $propertyFactory)
    {
        $this->___init();
        parent::__construct($propertyFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function add($identifier, \Magento\Framework\View\Asset\AssetInterface $asset, array $properties = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'add');
        return $pluginInfo ? $this->___callPlugins('add', func_get_args(), $pluginInfo) : parent::add($identifier, $asset, $properties);
    }

    /**
     * {@inheritdoc}
     */
    public function insert($identifier, \Magento\Framework\View\Asset\AssetInterface $asset, $key)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'insert');
        return $pluginInfo ? $this->___callPlugins('insert', func_get_args(), $pluginInfo) : parent::insert($identifier, $asset, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilteredProperties(\Magento\Framework\View\Asset\AssetInterface $asset, $properties = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFilteredProperties');
        return $pluginInfo ? $this->___callPlugins('getFilteredProperties', func_get_args(), $pluginInfo) : parent::getFilteredProperties($asset, $properties);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($identifier)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'remove');
        return $pluginInfo ? $this->___callPlugins('remove', func_get_args(), $pluginInfo) : parent::remove($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGroups');
        return $pluginInfo ? $this->___callPlugins('getGroups', func_get_args(), $pluginInfo) : parent::getGroups();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupByContentType($contentType)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGroupByContentType');
        return $pluginInfo ? $this->___callPlugins('getGroupByContentType', func_get_args(), $pluginInfo) : parent::getGroupByContentType($contentType);
    }

    /**
     * {@inheritdoc}
     */
    public function has($identifier)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'has');
        return $pluginInfo ? $this->___callPlugins('has', func_get_args(), $pluginInfo) : parent::has($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAll');
        return $pluginInfo ? $this->___callPlugins('getAll', func_get_args(), $pluginInfo) : parent::getAll();
    }
}
