<?php

namespace Simplon\Mvc\Views\Browser;

use Simplon\Form\FormView;
use Simplon\Locale\Locale;
use Simplon\Mvc\Interfaces\BrowserViewInterface;
use Simplon\Mvc\Utils\CastAway;
use Simplon\Mvc\Views\Browser\Helper\PageBrowserViewHelper;
use Simplon\Template\Template;
use Store\UserSessionModelInterface;

/**
 * Class BrowserView
 * @package Simplon\Mvc\Views\Browser
 */
abstract class BrowserView implements BrowserViewInterface
{
    /**
     * @var Template
     */
    private $renderer;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var UserSessionModelInterface
     */
    private $userSessionModel;

    /**
     * @var string
     */
    private $result;

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->locale->getCurrentLocale();
    }

    /**
     * @param Locale $locale
     *
     * @return BrowserViewInterface
     */
    public function setLocale(Locale $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return UserSessionModelInterface
     */
    public function getUserSessionModel()
    {
        return $this->userSessionModel;
    }

    /**
     * @param UserSessionModelInterface $model
     *
     * @return BrowserView
     */
    public function setUserSessionModel(UserSessionModelInterface $model = null)
    {
        $this->userSessionModel = $model;

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
     * @param string $code
     *
     * @return static
     */
    protected function addCode($code)
    {
        $this->getRenderer()->addAssetCode($code);

        return $this;
    }

    /**
     * @param FormView $formView
     *
     * @return static
     */
    protected function addFormAssets(FormView $formView)
    {
        return $this
            ->addCssForm($formView->getCssAssets())
            ->addJsForm($formView->getJsAssets())
            ->addCodeForm($formView->getCodeAssets());
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
     * @param array $paths
     *
     * @return static
     */
    private function addCssForm(array $paths)
    {
        foreach ($paths as $path)
        {
            $this->addCss($path, 'form');
        }

        return $this;
    }

    /**
     * @param array $paths
     *
     * @return static
     */
    private function addJsForm(array $paths)
    {
        foreach ($paths as $path)
        {
            $this->addJs($path, 'form');
        }

        return $this;
    }

    /**
     * @param string $code
     *
     * @return static
     */
    private function addCodeForm($code)
    {
        $this->getRenderer()->addAssetCode($code, 'form');

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