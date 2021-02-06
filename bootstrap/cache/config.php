<?php return array (
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'timezone' => 'America/Chihuahua',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => 'base64:KgmJzIWxRdHyjOisN/gUQcfqDROkBjYAYSBj+MkToxE=',
    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'log_level' => 'debug',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Laravel\\Tinker\\TinkerServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\AuthServiceProvider',
      25 => 'App\\Providers\\EventServiceProvider',
      26 => 'App\\Providers\\RouteServiceProvider',
      27 => 'App\\Auth\\Passport\\PassportServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'passport',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/home/isai/Documentos/padron/SOP-master/api/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'u389004884_sopolitica',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'u389004884_sopolitica',
        'username' => 'root',
        'password' => '.Santana7391',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => 'sop_',
        'strict' => true,
        'engine' => NULL,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'u389004884_sopolitica',
        'username' => 'root',
        'password' => '.Santana7391',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'u389004884_sopolitica',
        'username' => 'root',
        'password' => '.Santana7391',
        'charset' => 'utf8',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/home/isai/Documentos/padron/SOP-master/api/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/home/isai/Documentos/padron/SOP-master/api/storage/app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.mailtrap.io',
    'port' => '2525',
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Example',
    ),
    'encryption' => NULL,
    'username' => NULL,
    'password' => NULL,
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/home/isai/Documentos/padron/SOP-master/api/resources/views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/home/isai/Documentos/padron/SOP-master/api/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
  ),
  'sidebar' => 
  array (
    'menu' => 
    array (
      0 => 
      array (
        'icon' => 'fa fa-th-large',
        'title' => 'Dashboard',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/dashboard/v1',
            'title' => 'Dashboard v1',
          ),
          1 => 
          array (
            'url' => '/dashboard/v2',
            'title' => 'Dashboard v2',
          ),
        ),
      ),
      1 => 
      array (
        'icon' => 'fa fa-hdd',
        'title' => 'Email',
        'url' => 'javascript:;',
        'badge' => '10',
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/email/inbox',
            'title' => 'Inbox',
          ),
          1 => 
          array (
            'url' => '/email/compose',
            'title' => 'Compose',
          ),
          2 => 
          array (
            'url' => '/email/detail',
            'title' => 'Detail',
          ),
        ),
      ),
      2 => 
      array (
        'icon' => 'fa fa-gem',
        'title' => 'UI Elements',
        'url' => 'javascript:;',
        'label' => 'NEW',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/ui/general',
            'title' => 'General',
          ),
          1 => 
          array (
            'url' => '/ui/typography',
            'title' => 'Typography',
          ),
          2 => 
          array (
            'url' => '/ui/tabs-accordions',
            'title' => 'Tabs & Accordions',
          ),
          3 => 
          array (
            'url' => '/ui/unlimited-nav-tabs',
            'title' => 'Unlimited Nav Tabs',
          ),
          4 => 
          array (
            'url' => '/ui/modal-notification',
            'title' => 'Modal & Notification',
            'highlight' => true,
          ),
          5 => 
          array (
            'url' => '/ui/widget-boxes',
            'title' => 'Widget Boxes',
          ),
          6 => 
          array (
            'url' => '/ui/media-object',
            'title' => 'Media Object',
          ),
          7 => 
          array (
            'url' => '/ui/buttons',
            'title' => 'Buttons',
          ),
          8 => 
          array (
            'url' => '/ui/icons',
            'title' => 'Icons',
          ),
          9 => 
          array (
            'url' => '/ui/simple-line-icons',
            'title' => 'Simple Line Ioncs',
          ),
          10 => 
          array (
            'url' => '/ui/ionicons',
            'title' => 'Ionicons',
          ),
          11 => 
          array (
            'url' => '/ui/tree-view',
            'title' => 'Tree View',
          ),
          12 => 
          array (
            'url' => '/ui/language-bar-icon',
            'title' => 'Language Bar & Icon',
          ),
          13 => 
          array (
            'url' => '/ui/social-buttons',
            'title' => 'Social Buttons',
          ),
          14 => 
          array (
            'url' => '/ui/intro-js',
            'title' => 'Intro JS',
          ),
        ),
      ),
      3 => 
      array (
        'img' => '/assets/img/logo/logo-bs4.png',
        'title' => 'Bootstrap 4',
        'url' => '/bootstrap-4',
        'label' => 'NEW',
      ),
      4 => 
      array (
        'icon' => 'fa fa-list-ol',
        'title' => 'Form Stuff',
        'url' => 'javascript:;',
        'label' => 'NEW',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/form/elements',
            'title' => 'Form Elements',
            'highlight' => true,
          ),
          1 => 
          array (
            'url' => '/form/plugins',
            'title' => 'Form Plugins',
            'highlight' => true,
          ),
          2 => 
          array (
            'url' => '/form/slider-switcher',
            'title' => 'Form Slider + Switcher',
          ),
          3 => 
          array (
            'url' => '/form/validation',
            'title' => 'Form Validation',
          ),
          4 => 
          array (
            'url' => '/form/wizards',
            'title' => 'Wizards',
          ),
          5 => 
          array (
            'url' => '/form/wizards-validation',
            'title' => 'Wizards + Validation',
          ),
          6 => 
          array (
            'url' => '/form/wysiwyg',
            'title' => 'WYSIWYG',
          ),
          7 => 
          array (
            'url' => '/form/x-editable',
            'title' => 'X-Editable',
          ),
          8 => 
          array (
            'url' => '/form/multiple-file-upload',
            'title' => 'Multiple File Upload',
          ),
          9 => 
          array (
            'url' => '/form/summernote',
            'title' => 'Summernote',
          ),
          10 => 
          array (
            'url' => '/form/dropzone',
            'title' => 'Dropzone',
          ),
        ),
      ),
      5 => 
      array (
        'icon' => 'fa fa-table',
        'title' => 'Tables',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/table/basic',
            'title' => 'Basic',
          ),
          1 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Managed Tables',
            'sub_menu' => 
            array (
              0 => 
              array (
                'url' => '/table/manage/default',
                'title' => 'Default',
              ),
              1 => 
              array (
                'url' => '/table/manage/autofill',
                'title' => 'Autofill',
              ),
              2 => 
              array (
                'url' => '/table/manage/buttons',
                'title' => 'Buttons',
              ),
              3 => 
              array (
                'url' => '/table/manage/colreorder',
                'title' => 'ColReorder',
              ),
              4 => 
              array (
                'url' => '/table/manage/fixed-column',
                'title' => 'Fixed Column',
              ),
              5 => 
              array (
                'url' => '/table/manage/fixed-header',
                'title' => 'Fixed Header',
              ),
              6 => 
              array (
                'url' => '/table/manage/keytable',
                'title' => 'KeyTable',
              ),
              7 => 
              array (
                'url' => '/table/manage/responsive',
                'title' => 'Responsive',
              ),
              8 => 
              array (
                'url' => '/table/manage/rowreorder',
                'title' => 'RowReorder',
              ),
              9 => 
              array (
                'url' => '/table/manage/scroller',
                'title' => 'Scroller',
              ),
              10 => 
              array (
                'url' => '/table/manage/select',
                'title' => 'Select',
              ),
              11 => 
              array (
                'url' => '/table/manage/combine',
                'title' => 'Extension Combination',
              ),
            ),
          ),
        ),
      ),
      6 => 
      array (
        'icon' => 'fa fa-star',
        'title' => 'Frontend',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => 'javascript:;',
            'title' => 'One Page Parallax',
          ),
          1 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Blog',
          ),
          2 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Forum',
          ),
          3 => 
          array (
            'url' => 'javascript:;',
            'title' => 'E-Commerce',
          ),
        ),
      ),
      7 => 
      array (
        'icon' => 'fa fa-envelope',
        'title' => 'Email Template',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/email-template/system',
            'title' => 'System Template',
          ),
          1 => 
          array (
            'url' => '/email-template/newsletter',
            'title' => 'Newsletter Template',
          ),
        ),
      ),
      8 => 
      array (
        'icon' => 'fa fa-chart-pie',
        'title' => 'Chart',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/chart/flot',
            'title' => 'Flot Chart',
          ),
          1 => 
          array (
            'url' => '/chart/morris',
            'title' => 'Morris Chart',
          ),
          2 => 
          array (
            'url' => '/chart/js',
            'title' => 'Chart JS',
          ),
          3 => 
          array (
            'url' => '/chart/d3',
            'title' => 'd3 Chart',
          ),
        ),
      ),
      9 => 
      array (
        'icon' => 'fa fa-calendar',
        'title' => 'Calendar',
        'url' => '/calendar',
      ),
      10 => 
      array (
        'icon' => 'fa fa-map',
        'title' => 'Map',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/map/vector',
            'title' => 'Vector Map',
          ),
          1 => 
          array (
            'url' => '/map/google',
            'title' => 'Google Map',
          ),
        ),
      ),
      11 => 
      array (
        'icon' => 'fa fa-image',
        'title' => 'Gallery',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/gallery/v1',
            'title' => 'Gallery v1',
          ),
          1 => 
          array (
            'url' => '/gallery/v2',
            'title' => 'Gallery v2',
          ),
        ),
      ),
      12 => 
      array (
        'icon' => 'fa fa-cogs',
        'title' => 'Page Options',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/page-option/page-blank',
            'title' => 'Blank Page',
          ),
          1 => 
          array (
            'url' => '/page-option/page-with-footer',
            'title' => 'Page with Footer',
          ),
          2 => 
          array (
            'url' => '/page-option/page-without-sidebar',
            'title' => 'Page without Sidebar',
          ),
          3 => 
          array (
            'url' => '/page-option/page-with-right-sidebar',
            'title' => 'Page with Right Sidebar',
          ),
          4 => 
          array (
            'url' => '/page-option/page-with-minified-sidebar',
            'title' => 'Page with Minified Sidebar',
          ),
          5 => 
          array (
            'url' => '/page-option/page-with-two-sidebar',
            'title' => 'Page with Two Sidebar',
          ),
          6 => 
          array (
            'url' => '/page-option/page-full-height',
            'title' => 'Full Height Content',
          ),
          7 => 
          array (
            'url' => '/page-option/page-with-wide-sidebar',
            'title' => 'Page with Wide Sidebar',
          ),
          8 => 
          array (
            'url' => '/page-option/page-with-light-sidebar',
            'title' => 'Page with Light Sidebar',
          ),
          9 => 
          array (
            'url' => '/page-option/page-with-mega-menu',
            'title' => 'Page with Mega Menu',
          ),
          10 => 
          array (
            'url' => '/page-option/page-with-top-menu',
            'title' => 'Page with Top Menu',
          ),
          11 => 
          array (
            'url' => '/page-option/page-with-boxed-layout',
            'title' => 'Page with Boxed Layout',
          ),
          12 => 
          array (
            'url' => '/page-option/page-with-mixed-menu',
            'title' => 'Page with Mixed Menu',
          ),
          13 => 
          array (
            'url' => '/page-option/boxed-layout-with-mixed-menu',
            'title' => 'Boxed Layout with Mixed Menu',
          ),
          14 => 
          array (
            'url' => '/page-option/page-with-transparent-sidebar',
            'title' => 'Page with Transparent Sidebar',
          ),
        ),
      ),
      13 => 
      array (
        'icon' => 'fa fa-gift',
        'title' => 'Extra',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/extra/timeline',
            'title' => 'Timeline',
          ),
          1 => 
          array (
            'url' => '/extra/coming-soon',
            'title' => 'Coming Soon Page',
          ),
          2 => 
          array (
            'url' => '/extra/search-result',
            'title' => 'Search Results',
          ),
          3 => 
          array (
            'url' => '/extra/invoice',
            'title' => 'Invoice',
          ),
          4 => 
          array (
            'url' => '/extra/error-page',
            'title' => '404 Error Page',
          ),
          5 => 
          array (
            'url' => '/extra/profile',
            'title' => 'Profile Page',
          ),
        ),
      ),
      14 => 
      array (
        'icon' => 'fa fa-key',
        'title' => 'Login & Register',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/login/v1',
            'title' => 'Login',
          ),
          1 => 
          array (
            'url' => '/login/v2',
            'title' => 'Login v2',
          ),
          2 => 
          array (
            'url' => '/login/v3',
            'title' => 'Login v3',
          ),
          3 => 
          array (
            'url' => '/register/v3',
            'title' => 'Register v3',
          ),
        ),
      ),
      15 => 
      array (
        'icon' => 'fa fa-cube',
        'title' => 'Version',
        'url' => 'javascript:;',
        'label' => 'NEW',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => 'javascript:;',
            'title' => 'HTML',
          ),
          1 => 
          array (
            'url' => 'javascript:;',
            'title' => 'AJAX',
          ),
          2 => 
          array (
            'url' => 'javascript:;',
            'title' => 'ANGULAR JS',
          ),
          3 => 
          array (
            'url' => 'javascript:;',
            'title' => 'ANGULAR JS 5',
          ),
          4 => 
          array (
            'url' => 'javascript:;',
            'title' => 'LARAVEL',
            'highlight' => true,
          ),
          5 => 
          array (
            'url' => 'javascript:;',
            'title' => 'MATERIAL DESIGN',
          ),
          6 => 
          array (
            'url' => 'javascript:;',
            'title' => 'APPLE DESIGN',
          ),
          7 => 
          array (
            'url' => 'javascript:;',
            'title' => 'TRANSPARENT DESIGN',
          ),
        ),
      ),
      16 => 
      array (
        'icon' => 'fa fa-medkit',
        'title' => 'Helper',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => '/helper/css',
            'title' => 'Predefined CSS Classes',
          ),
        ),
      ),
      17 => 
      array (
        'icon' => 'fa fa-align-left',
        'title' => 'Menu Level',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => 
        array (
          0 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Menu 1.1',
            'sub_menu' => 
            array (
              0 => 
              array (
                'url' => 'javascript:;',
                'title' => 'Menu 2.1',
                'sub_menu' => 
                array (
                  0 => 
                  array (
                    'url' => 'javascript:;',
                    'title' => 'Menu 3.1',
                  ),
                  1 => 
                  array (
                    'url' => 'javascript:;',
                    'title' => 'Menu 3.2',
                  ),
                ),
              ),
              1 => 
              array (
                'url' => 'javascript:;',
                'title' => 'Menu 2.2',
              ),
              2 => 
              array (
                'url' => 'javascript:;',
                'title' => 'Menu 2.3',
              ),
            ),
          ),
          1 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Menu 1.2',
          ),
          2 => 
          array (
            'url' => 'javascript:;',
            'title' => 'Menu 1.3',
          ),
        ),
      ),
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/home/isai/Documentos/padron/SOP-master/api/resources/views',
    ),
    'compiled' => '/home/isai/Documentos/padron/SOP-master/api/storage/framework/views',
  ),
  'passport' => 
  array (
    'private_key' => NULL,
    'public_key' => NULL,
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
