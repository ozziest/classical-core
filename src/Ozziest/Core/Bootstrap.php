<?php namespace Ozziest\Core;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Logger as MonoLogger;
use Philo\Blade\Blade;
use Ozziest\Windrider\ValidationException;
use Ozziest\Windrider\Windrider;
use Ozziest\Core\Exceptions\UserException;
use Ozziest\Core\Exceptions\HTTPException;
use Exception, Router, Session, Form, Redirect, Lang;
use Ozziest\Core\HTTP\Response;
use Ozziest\Core\HTTP\Request;
use Ozziest\Core\Data\DB;
use Ozziest\Core\System\Logger;

class Bootstrap {

    private $request;
    private $response;
    private $db;
    private $matcher;
    private $logger;

    /**
     * Bootstrapping framework
     *
     * @return null
     */
    public function bootstrap()
    {
        try
        {
            class_alias('\Ozziest\Core\HTTP\Router', 'Router');
            class_alias('\Ozziest\Core\Data\Session', 'Session');
            class_alias('\Ozziest\Core\Data\Form', 'Form');
            class_alias('\Ozziest\Core\Data\Redirect', 'Redirect');
            class_alias('\Ozziest\Core\Data\Lang', 'Lang');
            class_alias('\Ozziest\Core\Helpers\DateHelper', 'Dater');
            $this->initLogger();
            $this->initSetups();
            $this->initConfigurations();
            $this->initRequest();
            $this->initResponse();
            $this->initDatabase();
            $this->initErrorHandler();
            $this->initApplicationLayers();
            $this->callAppcalition();
            if ($this->request->getMethod() !== "POST")
            {
                Session::set('last_page', $this->request->getPathInfo());
            }
            Form::clear();
        }
        catch (ModelNotFoundException $exception)
        {
            Session::set('validation_errors', ["Record not found!"]);
            Redirect::to(Session::get('last_page'));
        }
        catch (ValidationException $exception)
        {
            Session::set(Windrider::getPrefix().'validation_errors', Windrider::getErrors());
            Redirect::to(Session::get('last_page'));
        }
        catch (HTTPException $exception)
        {
            Session::set('http_exception_code', $exception->getCode());
            Redirect::to('/error');
        }
        catch (UserException $exception)
        {
            Session::set('validation_errors', [$exception->getMessage()]);
            Redirect::to(Session::get('last_page'));
        }
        catch (MethodNotAllowedException $exception)
        {
            $this->showError($exception, 404, "Method not found!");
        }
        catch (ResourceNotFoundException $exception)
        {
            $this->showError($exception, 404, "Request couldn't be resolved!.");
        }
        catch (Exception $exception)
        {
            $this->showError($exception, 500);
        }

    }

    /**
     * Initializing Logger class.
     *
     * @return null
     */
    private function initLogger()
    {
        $this->logger = new Logger(new MonoLogger('sorucevap'));
    }

    /**
     * Showing error
     *
     * @param  Exception $exception
     * @param  integer   $status
     * @param  string    $message
     * @return null
     */
    private function showError($exception, $status = 500, $message = null)
    {
        
        $this->failOnProduction($exception);
        return $this->response->view('errors.'.$status);

    }

    /**
     * This method checks the environment is production or not.
     * If the environment is not production, throwing the exception
     *
     * @param  Exception $exception
     * @return null
     */
    private function failOnProduction($exception)
    {
        if (getenv('environment') !== "production") {
            throw $exception;
        }
        
        $this->logger->error(
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
    }

    /**
     * Initializing application layers
     *
     * @return null
     */
    private function initApplicationLayers()
    {
        require_once ROOT.'App/bootstrap.php';
        require_once ROOT.'App/routes.php';
    }

    /**
     * Initializing error handler
     *
     * @return null
     */
    private function initErrorHandler()
    {
        $whoops = new \Whoops\Run();
        if (getenv('environment') === 'production')
        {
            $whoops->pushHandler(function($exception, $inspector, $run) {
                $this->logger->error(
                    $exception->getMessage(),
                    $exception->getFile(),
                    $exception->getLine()
                );
                Session::set('http_exception_code', 500);
                Redirect::to('/error');
                return Handler::DONE;
            });        
        }
        else 
        {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());            
        }
        $whoops->register();
    }

    /**
     * Initializing the database
     *
     * @return null
     */
    private function initDatabase()
    {
        $this->db = new DB(new Capsule());
        $this->db->connect();
        Redirect::setDB($this->db);
    }

    /**
     * Initializing the response object
     *
     * @return null
     */
    private function initResponse()
    {
        $this->response = new Response(
            $this->request,
            new SymfonyResponse(),
            new Blade(ROOT.'resource/views', ROOT.'resource/cache')
        );
    }

    public function redirectExtension()
    {
        var_dump('redirectExtension');
    }

    /**
     * Initializing the request object
     *
     * @return null
     */
    private function initRequest()
    {
        $this->request = SymfonyRequest::createFromGlobals();
        
        // Dil tanımlaları kontrol ediliyor
        $domain = str_replace(['http://', 'https://'], '', getenv('domain'));
        $domainParts = explode('.', $this->request->getHttpHost());
        $subdomains = ['en', 'tr', 'beta'];
        if (in_array($domainParts[0], $subdomains) === false)
        {
            $domainParts[0] = 'tr';
            $url = 'http://tr.'.$domain;
            Redirect::toDomain($url);
        }
        Lang::set($domainParts[0]);
        
        $context = new RequestContext();
        $context->fromRequest($this->request);
        $this->matcher = new UrlMatcher(Router::getCollection(), $context);
        if ($this->request->getMethod() === "POST")
        {
            Form::setRequestData($this->request->request->all());
        }
    }

    /**
     * Initializing common setups
     *
     * @return null
     */
    private function initSetups()
    {
        // Zaman dilimi ayarlanır
        // date_default_timezone_set('Europe/Istanbul');
    }

    /**
     * Calling the application controller with request object and routing
     * arguments.
     *
     * @return null
     */
    private function callAppcalition()
    {
        // Controller çalıştırılır
        $parameters = $this->matcher->match($this->request->getPathInfo());

        foreach ($parameters["middlewares"] as $key => $middleware)
        {
            $this->callMiddleware($middleware);
        }

        // Controller oluşturulur.
        $controller = new $parameters['controller']($this->db, $this->logger);
        $this->request->parameters = $parameters;

        // Bağımlılık enjeksionları gerçekleştirilir.
        $arguments = [
            new Request($this->request),
            $this->response
        ];

        // Controller çağrılır
        $content = call_user_func_array([$controller, $parameters['method']], $arguments);
    }

    /**
     * This method calls the middleware layers
     *
     * @param  string   $name
     * @return null
     */
    private function callMiddleware($name)
    {
        $name = "\App\Middlewares\\".$name;
        if (!class_exists($name))
        {
            throw new Exception("Middleware class not found: ".$name);
        }
        $instance = new $name();
        $instance->exec($this->request, $this->db);
    }

    /**
     * This method loads the configuration file
     *
     * @return null
     */
    private function initConfigurations()
    {
        $configurations = json_decode(file_get_contents(ROOT.'.env.config.json'));

        if ($configurations === NULL)
        {
            throw new Exception("Configuration file is not correct!");
        }

        foreach ($configurations as $key => $value)
        {
            putenv("$key=$value");
        }
    }

}
