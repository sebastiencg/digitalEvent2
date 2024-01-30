<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionManager
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function createSession($key, $value): void
    {
        $data = $this->session->get($key, []);
        $data[] = $value;
        $this->session->set($key, $data);
    }


    public function getSession($key)
    {
        $serializedValue = $this->session->get($key);
        if ($serializedValue !== null) {
            return $serializedValue;
        }

        return null;
    }
    public function clearSession()
    {
        $this->session->clear();
    }
}
