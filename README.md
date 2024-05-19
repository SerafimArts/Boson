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

## Example

```php
use Serafim\Boson\Application;
use Serafim\Boson\CreateInfo;
use Serafim\Boson\Event;
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
$app->on(Event\WindowBlurEvent::class, ...);            // Window loses focus
$app->on(Event\WindowCloseEvent::class, ...);           // Window is closed
$app->on(Event\WindowCreatedEvent::class, ...);         // Window is created
$app->on(Event\WindowFocusEvent::class, ...);           // Window gains focus
$app->on(Event\WindowHideEvent::class, ...);            // Window is hidden
$app->on(Event\WindowMoveEvent::class, ...);            // Window is moved
$app->on(Event\WindowResizeEvent::class, ...);          // Window is resized
$app->on(Event\WindowShowEvent::class, ...);            // Window is shown
// - WebView
$app->on(Event\WebViewCreatedEvent::class, ...);        // WebView is created
$app->on(Event\WebViewNavigationStarting::class, ...);  // WebView navigation starts
$app->on(Event\WebViewNavigationCompleted::class, ...); // WebView navigation is successfully completed
$app->on(Event\WebViewNavigationFailed::class, ...);    // WebView navigation fails

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
