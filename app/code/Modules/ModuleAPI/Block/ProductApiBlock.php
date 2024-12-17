<?php

namespace Modules\ModuleAPI\Block;

use Magento\Framework\View\Element\Template;

class ModuleAPIBlock extends Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }
}
