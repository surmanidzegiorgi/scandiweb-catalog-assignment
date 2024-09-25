<?php
namespace Magento\Framework\App\StaticResource;

/**
 * Interceptor class for @see \Magento\Framework\App\StaticResource
 */
class Interceptor extends \Magento\Framework\App\StaticResource implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $state, \Magento\Framework\App\Response\FileInterface $response, \Magento\Framework\App\Request\Http $request, \Magento\Framework\App\View\Asset\Publisher $publisher, \Magento\Framework\View\Asset\Repository $assetRepo, \Magento\Framework\Module\ModuleList $moduleList, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader, ?\Magento\Framework\App\DeploymentConfig $deploymentConfig = null, ?\Magento\Framework\Filesystem\Driver\File $driver = null, ?\Magento\Framework\View\Design\Theme\ThemePackageList $themePackageList = null, ?\Magento\Framework\Validator\Locale $localeValidator = null)
    {
        $this->___init();
        parent::__construct($state, $response, $request, $publisher, $assetRepo, $moduleList, $objectManager, $configLoader, $deploymentConfig, $driver, $themePackageList, $localeValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function launch()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'launch');
        return $pluginInfo ? $this->___callPlugins('launch', func_get_args(), $pluginInfo) : parent::launch();
    }

    /**
     * {@inheritdoc}
     */
    public function catchException(\Magento\Framework\App\Bootstrap $bootstrap, \Exception $exception)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'catchException');
        return $pluginInfo ? $this->___callPlugins('catchException', func_get_args(), $pluginInfo) : parent::catchException($bootstrap, $exception);
    }
}
