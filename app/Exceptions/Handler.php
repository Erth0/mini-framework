<?php 

namespace App\Exceptions;

use Exception;
use App\Views\View;
use ReflectionClass;
use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;

class Handler
{   
    /**
     * Exception
     *
     * @var object $exception
     */
    protected $exception;

    /**
     * SessionStore
     *
     * @var object $session
     */
    protected $session;

    /**
     * ResponseInterface
     *
     * @var $response
     */
    protected $response;

    /**
     * Twig view
     *
     * @var $view
     */
    protected $view;

    public function __construct(
        Exception $exception,
        SessionStore $session,
        ResponseInterface $response,
        View $view
    ){
        $this->exception = $exception;
        $this->session = $session;
        $this->response = $response;
        $this->view = $view;
    }

    /**
     * Returns the exception
     *
     * @return void
     */
    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if(method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    /**
     * Handels validation exception
     *
     * @param Exception $e
     * @return void
     */
    public function handleValidationException(Exception $e)
    {
        $this->session->set([
            'errors' => $e->getErrors(),
            'old' => $e->getOldInput(),
        ]);

        return redirect($e->getPath());
    }

    /**
     * Handels csrf token exception
     *
     * @param Exception $e
     * @return void
     */
    public function handleCsrfTokenException(Exception $e)
    {
        $this->view->render($this->response, 'erros/csrf.twig');
    }

    /**
     * Throws unhandled exceptions
     *
     * @param Exception $e
     * @return void
     */
    public function unhandledException(Exception $e)
    {
        throw $e;
    }
}