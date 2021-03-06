<?php

namespace Simplon\Mvc\Views\Browser;

use Simplon\Mvc\Interfaces\SessionStoreInterface;

/**
 * Class FlashMessage
 * @package Simplon\Mvc\Views\Browser
 */
class FlashMessage
{
    const SESSION_KEY = 'SIMPLON_FRONTEND_FLASH';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    /**
     * @var SessionStoreInterface
     */
    private $sessionStore;

    /**
     * @param SessionStoreInterface $sessionStorage
     */
    public function __construct(SessionStoreInterface $sessionStorage)
    {
        $this->sessionStore = $sessionStorage;
    }

    /**
     * @return bool
     */
    public function hasFlash()
    {
        return $this->getSessionStore()->has(self::SESSION_KEY);
    }

    /**
     * @return null|string
     */
    public function getFlash()
    {
        // fetch message
        $flash = $this->getSessionStore()->get(self::SESSION_KEY);

        // remove from session
        $this->getSessionStore()->del(self::SESSION_KEY);

        if ($flash === null)
        {
            return null;
        }

        return '<div class="ui huge ' . $flash['type'] . ' message flash-message">' . $flash['message'] . '</div>';
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashNormal($message)
    {
        return $this->setFlash($message);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashInfo($message)
    {
        return $this->setFlash($message, self::TYPE_INFO);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashSuccess($message)
    {
        return $this->setFlash($message, self::TYPE_SUCCESS);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashWarning($message)
    {
        return $this->setFlash($message, self::TYPE_WARNING);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashError($message)
    {
        return $this->setFlash($message, self::TYPE_ERROR);
    }

    /**
     * @param string $message
     * @param string $type
     *
     * @return bool
     */
    private function setFlash($message, $type = null)
    {
        return $this->getSessionStore()->set(self::SESSION_KEY, ['message' => $message, 'type' => $type]);
    }

    /**
     * @return SessionStoreInterface
     */
    private function getSessionStore()
    {
        return $this->sessionStore;
    }
}