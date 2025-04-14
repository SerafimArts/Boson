<?php

namespace PHPSTORM_META;

/* @link https://github.com/chromium/chromium/blob/137.0.7122.1/net/base/mime_util.cc#L95-L255 */
registerArgumentsSet('boson_mime_types',
    'video/webm',
    'audio/mpeg',
    'application/wasm',
    'application/x-chrome-extension',
    'application/xhtml+xml',
    'audio/flac',
    'audio/mp3',
    'audio/ogg',
    'audio/wav',
    'audio/webm',
    'audio/x-m4a',
    'image/avif',
    'image/gif',
    'image/jpeg',
    'image/png',
    'image/apng',
    'image/svg+xml',
    'image/webp',
    'multipart/related',
    'text/css',
    'text/html',
    'text/javascript',
    'text/xml',
    'video/mp4',
    'video/ogg',
    'text/csv',
    'image/x-icon',
    'application/epub+zip',
    'application/font-woff',
    'application/gzip',
    'application/javascript',
    'application/json',
    'application/msword',
    'application/octet-stream',
    'application/pdf',
    'application/pkcs7-mime',
    'application/pkcs7-signature',
    'application/postscript',
    'application/rdf+xml',
    'application/rss+xml',
    'application/rtf',
    'application/vnd.android.package-archive',
    'application/vnd.mozilla.xul+xml',
    'application/vnd.ms-excel',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/x-gzip',
    'application/x-mpegurl',
    'application/x-shockwave-flash',
    'application/x-tar',
    'application/x-x509-ca-cert',
    'application/zip',
    'audio/webm',
    'image/bmp',
    'image/jpeg',
    'image/tiff',
    'image/vnd.microsoft.icon',
    'image/x-png',
    'image/x-xbitmap',
    'message/rfc822',
    'text/calendar',
    'text/html',
    'text/plain',
    'text/vtt',
    'text/x-sh',
    'text/xml',
    'video/mpeg'
);

expectedArguments(\Serafim\Boson\FileSystem\Embedded\EmbeddedStorage::load(), 1,
    argumentsSet('boson_mime_types'));
expectedArguments(\Serafim\Boson\FileSystem\Embedded\EmbeddedStorage::loadFromPathname(), 1,
    argumentsSet('boson_mime_types'));

expectedReturnValues(\Serafim\Boson\FileSystem\Embedded\Mime\FileDetectorInterface::detectByFile(),
    argumentsSet('boson_mime_types'));
expectedReturnValues(\Serafim\Boson\FileSystem\Embedded\Mime\DataDetectorInterface::detectByData(),
    argumentsSet('boson_mime_types'));
expectedReturnValues(\Serafim\Boson\FileSystem\Embedded\Mime\ExtensionFileDetector::detectByFile(),
    argumentsSet('boson_mime_types'));
expectedReturnValues(\Serafim\Boson\FileSystem\Embedded\Mime\FileInfoDetector::detectByFile(),
    argumentsSet('boson_mime_types'));
expectedReturnValues(\Serafim\Boson\FileSystem\Embedded\Mime\FileInfoDetector::detectByData(),
    argumentsSet('boson_mime_types'));

expectedArguments(\Serafim\Boson\FileSystem\VirtualFileSystemInterface::mount(), 2,
    argumentsSet('boson_mime_types'));
expectedArguments(\Serafim\Boson\FileSystem\VirtualFileSystem::mount(), 2,
    argumentsSet('boson_mime_types'));


