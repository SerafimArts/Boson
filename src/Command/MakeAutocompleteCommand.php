<?php

declare(strict_types=1);

namespace Serafim\WinUI\Command;

use FFI\Generator\Metadata\CastXMLGenerator;
use FFI\Generator\Metadata\CastXMLParser;
use FFI\Generator\PhpStormMetadataGenerator;
use FFI\Generator\SimpleNamingStrategy;
use Serafim\WinUI\Driver;
use Serafim\WinUI\Driver\Library;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('make:autocomplete')]
final class MakeAutocompleteCommand extends Command
{
    /**
     * @var list<class-string<Library>>
     */
    private const array LIBRARIES = [
        Driver\Win32\Lib\Advapi32::class,
        Driver\Win32\Lib\Kernel32::class,
        Driver\Win32\Lib\Ole32::class,
        Driver\Win32\Lib\User32::class,
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (self::LIBRARIES as $class) {
            $output->writeln('Generate autocompletion for <comment>' . $class . '</comment>');

            // -----------------------------------------------------------------
            //  Step 1
            // -----------------------------------------------------------------

            $metadata = $this->getGeneratedXmlPathname($class);

            if (\is_file($metadata)) {
                $output->writeln('- [1/4] <comment>Loading metadata file</comment>');
            } else {
                $output->writeln('- [1/4] <comment>Generate metadata file</comment>');

                $header = $this->storeHeaderPathname($class);

                (new CastXMLGenerator(
                    // @phpstan-ignore-next-line
                    binary: (string) ($_SERVER['FFI_GENERATOR_CASTXML_BINARY'] ?? 'castxml'),
                ))
                    ->generate($header)
                    ->save($metadata);
            }

            // -----------------------------------------------------------------
            //  Step 3
            // -----------------------------------------------------------------

            $output->writeln('- [2/4] <comment>Building AST</comment>');

            $ast = (new CastXMLParser())->parse($metadata);

            // -----------------------------------------------------------------
            //  Step 4
            // -----------------------------------------------------------------

            $output->writeln('- [3/4] <comment>Generate IDE autocompletion</comment>');

            $result = (new PhpStormMetadataGenerator(
                argumentSetPrefix: 'ffi_' . $this->getIdentifierByClass($class),
                ignoreDirectories: $this->getIgnoreDirectories(),
                naming: new class ($class, $this->getNamespaceByClass($class)) extends SimpleNamingStrategy {
                    protected function getEnumTypeName(string $name): string
                    {
                        return $this->entrypoint;
                    }
                }
            ))
                ->generate($ast);

            // -----------------------------------------------------------------
            //  Step 5
            // -----------------------------------------------------------------

            $pathname = \dirname(__DIR__, 2) . '\\resources\\.phpstorm.meta.php\\'
                . $this->getShortNameByClass($class)
                . '.php';

            $output->writeln('- [4/4] <comment>Saving into ' . $pathname . '</comment>');

            \file_put_contents($pathname, (string) $result);

            $output->writeln('<info>Done</info>');
        }

        return self::SUCCESS;
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-string
     */
    private function getGeneratedXmlPathname(string $class): string
    {
        return $this->getTempDirectory()
            . '/metadata-' . $this->getIdentifierByClass($class)
            . '.' . \hash('xxh32', $class::getHeader())
            . '.xml';
    }

    /**
     * @return non-empty-string
     */
    private function getTempDirectory(): string
    {
        return __DIR__ . '/../../resources/temp';
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-lowercase-string
     */
    private function getIdentifierByClass(string $class): string
    {
        return \strtolower($this->getShortNameByClass($class));
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-string
     */
    private function storeHeaderPathname(string $class): string
    {
        $pathname = $this->getGeneratedHeaderPathname($class);

        if (!\is_file($pathname)) {
            $contents = '#include <stdint.h>' . "\n" . $class::getHeader();

            \file_put_contents($pathname, $contents);
        }

        return $pathname;
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-string
     */
    private function getGeneratedHeaderPathname(string $class): string
    {
        return $this->getTempDirectory()
            . '/metadata-' . $this->getIdentifierByClass($class)
            . '.' . \hash('xxh32', $class::getHeader())
            . '.h';
    }

    /**
     * @return list<non-empty-string>
     */
    private function getIgnoreDirectories(): array
    {
        /** @var list<non-empty-string> */
        return \array_filter([
            '/usr',
            'C:\Program Files',
            // @phpstan-ignore-next-line
            ...\explode(',', $_SERVER['FFI_GENERATOR_IGNORE_PATHS'] ?? '/usr'),
        ], static fn(string $value): bool => $value !== '');
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-string
     */
    private function getShortNameByClass(string $class): string
    {
        /** @var non-empty-string */
        return \substr($class, (int) \strrpos($class, '\\') + 1);
    }

    /**
     * @param class-string<Library> $class
     *
     * @return non-empty-string
     */
    private function getNamespaceByClass(string $class): string
    {
        /** @var non-empty-string */
        return \substr($class, 0, (int) \strrpos($class, '\\'));
    }
}
