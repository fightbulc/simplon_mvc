<?php

namespace Simplon\Mvc\Core\Views\Browser;

use Simplon\Mvc\Core\Interfaces\BrowserViewInterface;
use Simplon\Mvc\Core\Interfaces\DataInterface;
use Simplon\Mvc\Core\Utils\CastAway;
use Simplon\Mvc\Core\Views\Browser\Helper\PageBrowserViewHelper;
use Simplon\Template\Template;

/**
 * Class BrowserView
 * @package Simplon\Mvc\Core\Views\Browser
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
    protected $dataResponse;

    /**
     * @var string
     */
    protected $result;

    /**
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data = null)
    {
        $this->dataResponse = $data;
        $this->renderer = new Template();
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
     * @return BrowserView
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
            $params['partial' . ucfirst(strtolower($viewKey))] = $partial;
        }

        return $this->renderPartial($page->getPage(), $params);
    }

    /**
     * @param string $pathCss
     * @param string $blockId
     *
     * @return $this
     */
    protected function addCss($pathCss, $blockId = null)
    {
        $this->getRenderer()->addAssetCss($pathCss, $blockId);

        return $this;
    }

    /**
     * @param string $pathJs
     * @param null $blockId
     *
     * @return $this
     */
    protected function addJs($pathJs, $blockId = null)
    {
        $this->getRenderer()->addAssetJs($pathJs, $blockId);

        return $this;
    }

    /**
     * @param array $code
     * @param null $blockId
     *
     * @return $this
     */
    protected function addJsCode(array $code, $blockId = null)
    {
        $this->getRenderer()->addAssetCode($code, $blockId);

        return $this;
    }

    /**
     * @return Template
     */
    private function getRenderer()
    {
        return $this->renderer;
    }
}