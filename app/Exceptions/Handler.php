<?php

namespace App\Exceptions;

use App\Contracts\SessionManager;
use App\Core\App;
use App\Services\FileSession;
use App\Session\SessionStore;
use App\Views\View;
use Exception;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;

class Handler
{
    protected Exception $exception;
    protected App $app;

    public function __construct(
        Exception $exception,
    ) {
        $this->exception = $exception;
        $this->app = new App();
    }

    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    protected function handleAuthenticationException(Exception $exception)
    {
        $this->app->get(SessionManager::class)->set([
            'errors' => $exception->getErrors(),
            'old' => $exception->getOldInput(),
        ]);
        return redirect($exception->getUri());
    }

    protected function handleValidationException(Exception $e)
    {
        $this->app->get(SessionManager::class)->set([
            'errors' => $e->getErrors(),
            'old' => $e->getOldInput(),
        ]);

        return redirect($e->getUri());
    }

    protected function handleCsrfTokenException(Exception $exception)
    {
        return view('errors/500', compact('exception'));
    }

    protected function unhandledException(Exception $exception)
    {
        return view('errors/500/index', compact('exception'));
    }
}
