<?php

namespace Civi\CompilePlugin\Util;

use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventDispatcher;

class ShellRunner
{
    use ComposerIoTrait;

    /**
     * Run a shell command in the same style as Composer's EventDispatcher.
     *
     * @param string $cmd
     *   Ex: '@php -r "echo 123;"'
     *   Ex: '@composer require foo/bar'
     */
    public function run($cmd)
    {
        // On BOA server, @php cmd exit with code status 1... but php cmd works. ?!
        $cmd = str_replace('@', '', $cmd);

        $d = new EventDispatcher($this->composer, $this->io);
        $d->addListener('shell-runner', $cmd);
        $d->dispatch('shell-runner', new Event('shell-runner'));
    }
}
