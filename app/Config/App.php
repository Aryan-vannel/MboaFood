<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * App Configuration — Compatible CI4 4.7.x
 */
class App extends BaseConfig
{
    /**
     * URL de base de l'application.
     * Modifiez selon votre environnement local.
     */
    public string $baseURL = 'http://localhost/mboa_food/public/';

    /**
     * Allowed Hostname List
     */
    public array $allowedHostnames = [];

    /**
     * Index File
     * Laissez vide si mod_rewrite est activé.
     */
    public string $indexPage = '';

    /**
     * URI Protocol
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Default Locale
     */
    public string $defaultLocale = 'fr';

    /**
     * Negotiate Locale
     */
    public bool $negotiateLocale = false;

    /**
     * Supported Locales
     */
    public array $supportedLocales = ['fr', 'en'];

    /**
     * Application Timezone
     */
    public string $appTimezone = 'Africa/Douala';

    /**
     * Default Character Set
     */
    public string $charset = 'UTF-8';

    /**
     * Force Global Secure Requests
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * Proxy IPs
     */
    public array $proxyIPs = [];


    // ---------------------------------------------------------------
    // CSRF Settings
    // ---------------------------------------------------------------

    public string $CSRFTokenName   = 'csrf_token';
    public string $CSRFHeaderName  = 'X-CSRF-TOKEN';
    public string $CSRFCookieName  = 'csrf_cookie';
    public int    $CSRFExpire      = 7200;
    public bool   $CSRFRegenerate  = true;
    public array  $CSRFExcludeURIs = [];
    public string $CSRFSameSite    = 'Lax';

    // ---------------------------------------------------------------
    // Cookie Settings
    // ---------------------------------------------------------------

    public string $cookiePrefix   = '';
    public string $cookieDomain   = '';
    public string $cookiePath     = '/';
    public bool   $cookieSecure   = false;
    public bool   $cookieHTTPOnly = true;
    public string $cookieSameSite = 'Lax';

    // ---------------------------------------------------------------
    // Session Settings
    // ---------------------------------------------------------------

    public string $sessionDriver            = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $sessionCookieName        = 'ci_session';
    public int    $sessionExpiration        = 7200;
    public string $sessionSavePath          = WRITEPATH . 'session';
    public bool   $sessionMatchIP           = false;
    public int    $sessionTimeToUpdate      = 300;
    public bool   $sessionRegenerateDestroy = false;

    // ---------------------------------------------------------------
    // Honeypot Settings
    // ---------------------------------------------------------------

    public string $honeypotHidden   = 'honeypot';
    public string $honeypotLabel    = 'Fill This Field';
    public string $honeypotContainer = 'div';
    public string $honeypotTemplate = '<label>{label}</label><input type="text" name="{name}" autocomplete="off">';

    // ---------------------------------------------------------------
    // Content Security Policy
    // ---------------------------------------------------------------

    public bool $CSPEnabled = false;

    /**
     * Permitted URI chars
     *
     * CI4 Router expects this property to exist.
     */
    public string $permittedURIChars = '';
}

