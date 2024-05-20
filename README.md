## Boson

Why Boson? Because it's not an [Electron](https://www.electronjs.org)! 
And much easier than that =)

- See [example](/example) directory.

## Requirements

- Windows OS
- PHP 8.3+
- ext-ffi

| OS      | CPU   | Supported             |
|---------|-------|-----------------------|
| Windows | x64   | Yes                   |
| Windows | x86   | Possible (Not Tested) |
| Windows | ARM64 | Possible (Not Tested) |
| Linux   | Any   | No (TODO)             |
| MacOS   | Any   | No (TODO)             |

## Known Issues

- Multiple windows is not supported.

## Short Documentation

```php
use Serafim\Boson\Application;
use Serafim\Boson\Event;
use Serafim\Boson\Window\CreateInfo;
use Serafim\Boson\Window\Position;
use Serafim\Boson\Window\Size;

require __DIR__ . '/vendor/autoload.php';

// Window Factory
$app = new Application();

// Window Instance
$window = $app->create(new CreateInfo(
    title: 'My Window', // Optional, default empty string
    width: 640,         // Optional, default 0
    height: 480,        // Optional, default 0
    resizable: true,    // Optional, default false
    closable: true,     // Optional, default true
    debug: true,        // Optional, default false
));

// Add event listener
$listener = $app->on(Event\EventName::class, function (Event\EventName $event) { /** do something */ });

// Remove event listener
$app->off(Event\EventName::class, $listener);

// Events list:
// - Window
$app->on(Event\Window\WindowFocusLostEvent::class, ...);        // Window loses focus
$app->on(Event\Window\WindowClosedEvent::class, ...);           // Window is closed
$app->on(Event\Window\WindowCreatedEvent::class, ...);          // Window is created
$app->on(Event\Window\WindowFocusReceivedEvent::class, ...);    // Window gains focus
$app->on(Event\Window\WindowHiddenEvent::class, ...);           // Window is hidden
$app->on(Event\Window\WindowMovedEvent::class, ...);            // Window is moved
$app->on(Event\Window\WindowResizeEvent::class, ...);           // Window is resized
$app->on(Event\Window\WindowShownEvent::class, ...);            // Window is shown
// - WebView
$app->on(Event\WebView\WebViewCreatedEvent::class, ...);        // WebView is created
$app->on(Event\WebView\WebViewNavigationStarted::class, ...);   // WebView navigation starts
$app->on(Event\WebView\WebViewNavigationCompleted::class, ...); // WebView navigation is successfully completed
$app->on(Event\WebView\WebViewNavigationFailed::class, ...);    // WebView navigation fails

// [get; set] Change window size
$window->size->width = 640;
$window->size->height = 480;

// [get; set] Atomic window resize
$window->size = new Size(
    width: 800,
    height: 600,
);

// [get; set] Change window position
$window->position->x = 100;
$window->position->y = 100;

// [get; set] Atomic window move
$window->position = new Position(
    x: 200,
    y: 200,
);

// Move to center of screen
$window->position->center();

// [get; set] Change window icon (string|null)
// Only ICO format is supported now 
$window->icon = __DIR__ . '/path/to/icon.ico';

// [get; set] Change window title (string)
$window->title = 'Hello World!';

// [get] Window Handle (object { ptr: CData<HWND> })
dump($window->handle);

$app->run();
```

## App Example

```php
use Serafim\Boson\Application;
use Serafim\Boson\Event\WebView\WebViewCreatedEvent;
use Serafim\Boson\Window\CreateInfo;

$app = new Application();

$app->on(WebViewCreatedEvent::class, function (WebViewCreatedEvent $e): void {
    $e->webview->uri = 'https://nesk.me';
});

$window = $app->create(new CreateInfo(title: 'Example Application'));
$window->position->center();
$window->show();

$app->run();
```
