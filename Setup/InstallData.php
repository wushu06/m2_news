<?php

namespace Tbb\News\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Tbb\News\Setup\InstallData\NewsSetupFactory;
use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface
{
    /**
     * @var PostSetupFactory
     */
    protected $newsSetupFactory;


    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * @param PostSetupFactory     $postSetupFactory
     * @param Config               $eavConfig
     */
    public function __construct(
        newsSetupFactory $newsSetupFactory,
        Config $eavConfig
    ) {
        $this->newsSetupFactory = $newsSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $newsSetup = $this->newsSetupFactory->create(['setup' => $setup]);
        $newsSetup->installEntities();
        $setup->endSetup();
        $this->eavConfig->clear();

    }
}