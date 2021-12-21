<?php

namespace Dev\Banner\Controller\Forward;

use Dev\Banner\Controller\Redirect\RedirectController;
use Dev\Banner\Model\Banner;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class ForwardController extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_forward('nami', 'index', 'luffy');
    }
}
