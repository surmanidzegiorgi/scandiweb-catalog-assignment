<?php
namespace Magento\RequireJs\Model\FileManager;

/**
 * Interceptor class for @see \Magento\RequireJs\Model\FileManager
 */
class Interceptor extends \Magento\RequireJs\Model\FileManager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\RequireJs\Config $config, \Magento\Framework\Filesystem $appFilesystem, \Magento\Framework\App\State $appState, \Magento\Framework\View\Asset\Repository $assetRepo)
    {
        $this->___init();
        parent::__construct($config, $appFilesystem, $appState, $assetRepo);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequireJsConfigAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createRequireJsConfigAsset');
        return $pluginInfo ? $this->___callPlugins('createRequireJsConfigAsset', func_get_args(), $pluginInfo) : parent::createRequireJsConfigAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createMinResolverAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createMinResolverAsset');
        return $pluginInfo ? $this->___callPlugins('createMinResolverAsset', func_get_args(), $pluginInfo) : parent::createMinResolverAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createRequireJsMixinsAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createRequireJsMixinsAsset');
        return $pluginInfo ? $this->___callPlugins('createRequireJsMixinsAsset', func_get_args(), $pluginInfo) : parent::createRequireJsMixinsAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createRequireJsAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createRequireJsAsset');
        return $pluginInfo ? $this->___callPlugins('createRequireJsAsset', func_get_args(), $pluginInfo) : parent::createRequireJsAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createUrlResolverAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createUrlResolverAsset');
        return $pluginInfo ? $this->___callPlugins('createUrlResolverAsset', func_get_args(), $pluginInfo) : parent::createUrlResolverAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createRequireJsMapConfigAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createRequireJsMapConfigAsset');
        return $pluginInfo ? $this->___callPlugins('createRequireJsMapConfigAsset', func_get_args(), $pluginInfo) : parent::createRequireJsMapConfigAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createStaticJsAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createStaticJsAsset');
        return $pluginInfo ? $this->___callPlugins('createStaticJsAsset', func_get_args(), $pluginInfo) : parent::createStaticJsAsset();
    }

    /**
     * {@inheritdoc}
     */
    public function createBundleJsPool()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createBundleJsPool');
        return $pluginInfo ? $this->___callPlugins('createBundleJsPool', func_get_args(), $pluginInfo) : parent::createBundleJsPool();
    }

    /**
     * {@inheritdoc}
     */
    public function clearBundleJsPool()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'clearBundleJsPool');
        return $pluginInfo ? $this->___callPlugins('clearBundleJsPool', func_get_args(), $pluginInfo) : parent::clearBundleJsPool();
    }
}
