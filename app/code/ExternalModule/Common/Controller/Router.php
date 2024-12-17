<?php

namespace ExternalModule\Common\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ActionFactory;
use Psr\Log\LoggerInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param ActionFactory $actionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ActionFactory $actionFactory,
        LoggerInterface $logger
    ) {
        $this->actionFactory = $actionFactory;
        $this->logger = $logger;
    }

    /**
     * Match the request and forward it to the appropriate action
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        $this->logger->info('Custom Router: Checking path - ' . $pathInfo);

        // Define custom routes
        $routes = [
            '/weather.html' => [
                'module' => 'owm',
                'controller' => 'index',
                'action' => 'weather',
            ],
            '/vietcombank.html' => [
                'module' => 'vcb',
                'controller' => 'index',
                'action' => 'vietcombank',
            ],
            '/vnexpress.html' => [
                'module' => 'vne',
                'controller' => 'index',
                'action' => 'vnexpress',
            ],
        ];

        if ($request->getModuleName() === 'owm') {
            $this->logger->info('Custom Router: Request already processed.');
            return null;
        }

        if ($request->getModuleName() === 'vcb') {
            $this->logger->info('Custom Router: Request already processed.');
            return null;
        }
        
        if ($request->getModuleName() === 'vne') {
            $this->logger->info('Custom Router: Request already processed.');
            return null;
        }
        
        // Check if the current path matches any custom route
        if (isset($routes['/' . $pathInfo])) {
            $route = $routes['/' . $pathInfo];
            $this->logger->info('Custom Router: Matched route - ' . json_encode($route));

            // Set module, controller, and action for the request
            $request->setModuleName($route['module'])
                ->setControllerName($route['controller'])
                ->setActionName($route['action']);

            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }

        // No match found, return null
        $this->logger->info('Custom Router: No matching route found.');
        return null;
    }
}
