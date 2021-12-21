<?php

namespace Dev\Banner\Controller\Redirect;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class RedirectController extends \Magento\Framework\App\Action\Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $this->_redirect('devbanner/Forward/ForwardController/');
    }
}
