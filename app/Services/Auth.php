<?php

namespace App\Services;

use App\Contracts\CookieManager;
use App\Contracts\Hash;
use App\Contracts\SessionManager;
use App\Core\App;
use App\Models\User;

class Auth
{
    protected User $user;
    protected App $app;
    protected CookieFactory $cookieFactory;
    protected CookieManager $cookieManager;

    public function __construct()
    {
        $this->user = new User();
        $this->app = new App();
        $this->cookieFactory = new CookieFactory();
        $this->cookieManager = new Cookie();
    }

    /**
     * @throws \Exception
     */
    public function attempt($email, $password, $remember): bool
    {
        $user = $this->user->find([
            'email' => $email,
        ]);
        if (!$user) {
            return false;
        }
        $passwordChecker = $this->app->get(Hash::class)->check($password, $user->password);
        if (!$passwordChecker) {
            return false;
        }
        $this->setUserToSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }

        return true;
    }

    protected function setUserToSession(User $user)
    {
        $this->app->get(SessionManager::class)->set('user', [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
        ]);
    }

    /**
     * @throws \Exception
     */
    protected function setRememberToken($user)
    {
        list($identifier, $token) = $this->cookieFactory->generate();
        $this->cookieManager->set('remember', $this->cookieFactory->generateValueForCookie($identifier, $token));
        $user->update([
            'remember_identifier' => $identifier,
            'remember_token' => $this->cookieFactory->getTokenHashForDatabase($token)
        ]);
    }

    /**
     * @throws \Exception
     */
    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->cookieFactory->splitCookieValue($this->cookieManager->get('remember'));
        $user = $this->user->find([
            'remember_identifier' => $identifier
        ]);
        if (!$user) {
            $this->cookieManager->clear('remember');
            return;
        }
        if (!$this->cookieFactory->validateToken($token, $user->remember_token)) {
            $this->cookieManager->clear('remember');
            $user->clearUserToken($user['id']);
            throw new \Exception();
        }
        $this->setUserToSession($user);
    }

    public function hasRememberCookie(): bool
    {
        return $this->cookieManager->exists('remember');
    }

    protected function getUserFromSession()
    {
        return $this->app->get(SessionManager::class)->get('user');
    }

    public function check(): bool
    {
        $user = $this->getUserFromSession();
        return isset($user['id']);
    }

    public function user(): array
    {
        return $this->getUserFromSession();
    }

    public function logout()
    {
        (new User())->clearUserToken(auth()->user()['id']);
        $this->cookieManager->clear('remember');
        $this->app->get(SessionManager::class)->clear('user');
    }
}
