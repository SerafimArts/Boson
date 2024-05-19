<?php

use Serafim\Boson\Application;
use Serafim\Boson\CreateInfo;
use Serafim\Boson\Event\WebViewCreatedEvent;
use Serafim\Boson\Event\WebViewNavigationCompleted;
use Serafim\Boson\Event\WebViewNavigationFailed;
use Serafim\Boson\Event\WindowCloseEvent;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app->on(WindowCloseEvent::class, function (WindowCloseEvent $e) use ($app): void {
    $e->target->close();
    $app->stop();
});

$app->on(WebViewCreatedEvent::class, function (WebViewCreatedEvent $e): void {
    $e->webview->uri = 'https://nesk.me';
});

$app->on(WebViewNavigationFailed::class, function (WebViewNavigationFailed $e): void {
    echo 'Error: ' . $e->error->getMessage() . "\n";
});

$app->on(WebViewNavigationCompleted::class, function (WebViewNavigationCompleted $e): void {
    echo $e->webview->uri;
});

$window = $app->create(new CreateInfo(
    title: 'Example Application',
    resizable: true,
));

$window->icon = __DIR__ . '/icon.ico';
$window->position->center();
$window->show();

$app->run();

