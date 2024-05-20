<?php

use Serafim\Boson\Application;
use Serafim\Boson\Event\WebView\WebViewCreatedEvent;
use Serafim\Boson\Event\WebView\WebViewNavigationCompleted;
use Serafim\Boson\Event\WebView\WebViewNavigationFailed;
use Serafim\Boson\Event\Window\WindowClosedEvent;
use Serafim\Boson\Window\CreateInfo;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app->on(WindowClosedEvent::class, function (WindowClosedEvent $e) use ($app): void {
    $e->subject->close();
    $app->stop();
});

$app->on(WebViewCreatedEvent::class, function (WebViewCreatedEvent $e): void {
    $e->subject->uri = 'https://nesk.me';
});

$app->on(WebViewNavigationFailed::class, function (WebViewNavigationFailed $e): void {
    echo 'Error: ' . $e->error->getMessage() . "\n";
});

$app->on(WebViewNavigationCompleted::class, function (WebViewNavigationCompleted $e): void {
    echo $e->subject->uri;
});

$window = $app->create(new CreateInfo(
    title: 'Example Application',
    resizable: true,
));

$window->icon = __DIR__ . '/icon.ico';
$window->position->center();
$window->show();

$app->run();

