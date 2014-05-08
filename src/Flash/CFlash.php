<?php

namespace Anax\Flash;

class CFlash extends \Anax\Flash\CFlashBasic
{
    public function __construct()
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
    }

    public function clearKey($key)
    {
        unset($_SESSION['flash'][$key]);
    }

    public function clear($startAgain = true)
    {
        unset($_SESSION['flash']);
        if ($startAgain) {
            if (!isset($_SESSION['flash'])) {
                $_SESSION['flash'] = [];
            }
        }
    }

    private function setKey($key, $value)
    {
        $_SESSION['flash'][$key][] = $value;
    }

    public function error($message)
    {
        $this->setKey('error', $message);
    }

    public function notice($message)
    {
        $this->setKey('notice', $message);
    }

    public function warning($message)
    {
        $this->setKey('warning', $message);
    }

    public function success($message)
    {
        $this->setKey('success', $message);
    }

    private function toHtml($class, $message)
    {
        return "<div class='{$class}Message'>{$message}</div>";
    }

    public function dump()
    {
        dump($_SESSION['flash']);
    }
}
