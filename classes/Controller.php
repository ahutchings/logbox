<?php

class Controller
{
    /**
     * parse the request URL
     *
     * @return array|bool Matched route or false
     */
    public static function parseRequest()
    {
        $routes = array(
            'index' => array('url' => '/\\A\\z/', 'controller' => 'SiteHandler', 'action' => 'display_home'),
            'statistics' => array('url' => '%^statistics/?\\z%', 'controller' => 'SiteHandler', 'action' => 'display_statistics'),
            'settings' => array('url' => '%^settings/?\\z%', 'controller' => 'SiteHandler', 'action' => 'display_settings'),
        	'logs' => array('url' => '%^logs/?\\z%', 'controller' => 'SiteHandler', 'action' => 'display_logs'),
            'login' => array('url' => '%^login/?\\z%', 'controller' => 'SiteHandler', 'action' => 'display_login'),
            'logout' => array('url' => '%^logout/?\\z%', 'controller' => 'SiteHandler', 'action' => 'do_logout'),
            '404' => array('url' => '/\\A.*$/', 'controller' => 'SiteHandler', 'action' => 'display_404')
        );

        // get the request parts, 404 on error
        if (!$request_parts = parse_url($_SERVER['REQUEST_URI'])) {
            trigger_error('Unable to parse the request URI.', E_USER_ERROR);
            return $routes['404'];
        }

        // format the request url before matching
        $base_path   = parse_url(Options::get('base_url'), PHP_URL_PATH);
        $request_url = substr($request_parts['path'], strlen($base_path));

        // match a route
        foreach ($routes as $route) {

            if (preg_match($route['url'], $request_url, $route['params']) == 1) {

                // remove numeric keys
                foreach (array_keys($route['params']) as $k) {
                    if (is_int($k)) { unset($route['params'][$k]); }
                }

                if (isset($request_parts['query'])) {
                    parse_str($request_parts['query'], $query_params);
                    $route['params'] = array_merge($route['params'], $query_params);
                }

                return $route;
            }
        }

        return $routes['404'];
    }

    /**
     * parses the request, sets up page variables, and directs to the correct page
     *
     * @return null
     */
    public static function dispatchRequest()
    {
        $request = self::parseRequest();

        $controller = new $request['controller'];

        $controller->$request['action']();
    }
}
