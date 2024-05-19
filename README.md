## TLDR

Doesn't work yet)

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

- The WebView Controller is initialized ONLY after the window has been moved, 
  otherwise `Failed to create WebView Controller` has been thrown.
- TODO: The WebView is not rendering at the moment.

## Example

```php
require __DIR__ . '/vendor/autoload.php';

// Window Factory
$app = new \Serafim\WinUI\Application();

// Window Instance
$window = $app->create(new \Serafim\WinUI\CreateInfo(
    title: 'My Window', // Optional, default empty string
    width: 640,         // Optional, default 0
    height: 480,        // Optional, default 0
));

// [get; set] Change window size
$window->size->width = 640;
$window->size->height = 480;

// [get; set] Change window position
$window->position->x = 100;
$window->position->y = 100;

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
