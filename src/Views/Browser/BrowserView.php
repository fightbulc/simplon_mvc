<?php

namespace Simplon\Mvc\Views\Browser;

use Simplon\Mvc\Interfaces\BrowserViewInterface;
use Simplon\Mvc\Interfaces\DataInterface;
use Simplon\Mvc\Utils\CastAway;
use Simplon\Mvc\Views\Browser\Helper\PageBrowserViewHelper;
use Simplon\Template\Template;

/**
 * Class BrowserView
 * @package Simplon\Mvc\Views\Browser
 */
abstract class BrowserView implements BrowserViewInterface
{
    /**
     * @var Template
     */
    protected $renderer;

    /**
     * @var DataInterface
     */
    protected $data;

    /**
     * @var string
     */
    protected $result;

    /**
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data = null)
    {
        $this->data = $data;
    }

    /**
     * @param DataInterface $data
     *
     * @return static
     */
    public function setData(DataInterface $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     *
     * @return static
     */
    protected function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @param PageBrowserViewHelper $page
     *
     * @return string
     */
    protected function buildPage(PageBrowserViewHelper $page)
    {
        return $this->renderPage($page);
    }

    /**
     * @param string $pathTemplate
     * @param array $params
     *
     * @return string
     */
    protected function renderPartial($pathTemplate, array $params = [])
    {
        return $this->getRenderer()->renderPhtml(CastAway::trimPath($pathTemplate), $params);
    }

    /**
     * @param PageBrowserViewHelper $page
     *
     * @return string
     */
    protected function renderPage(PageBrowserViewHelper $page)
    {
        $params = $page->getParamsFlattened();

        foreach ($page->getPartials() as $viewKey => $pathTemplate)
        {
            $partial = $this->renderPartial($pathTemplate, $params);
            $params[$viewKey] = $partial;
        }

        return $this->renderPartial($page->getPage(), $params);
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addCssVendor($path)
    {
        return $this->addCss($path, 'vendor');
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addCssPage($path)
    {
        return $this->addCss($path, 'page');
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addCssComponent($path)
    {
        return $this->addCss($path, 'component');
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addJsVendor($path)
    {
        return $this->addJs($path, 'vendor');
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addJsPage($path)
    {
        return $this->addJs($path, 'page');
    }

    /**
     * @param string $path
     *
     * @return static
     */
    protected function addJsComponent($path)
    {
        return $this->addJs($path, 'component');
    }

    /**
     * @param array $code
     *
     * @return static
     */
    protected function addCode(array $code)
    {
        $this->getRenderer()->addAssetCode($code);

        return $this;
    }

    /**
     * @param string $path
     * @param string $blockId
     *
     * @return static
     */
    private function addCss($path, $blockId = null)
    {
        $this->getRenderer()->addAssetCss($path, $blockId);

        return $this;
    }

    /**
     * @param string $path
     * @param null $blockId
     *
     * @return static
     */
    private function addJs($path, $blockId = null)
    {
        $this->getRenderer()->addAssetJs($path, $blockId);

        return $this;
    }

    /**
     * @return Template
     */
    private function getRenderer()
    {
        if ($this->renderer === null)
        {
            $this->renderer = new Template();
        }

        return $this->renderer;
    }
}