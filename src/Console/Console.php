<?php

namespace Chronos\Console;

class Console
{
    private $stdin;

    public function run($argc, $argv)
    {
        $this->stdin = fopen('php://stdin', 'r');
        if ($argc <= 1) {
            $this->printUsage();
            exit(1);
        }

        $command = $argv[1];
        switch ($command) {
        case 'test-input':
            do {
                $x = $this->askQuestion('info...', true);
                $x = ($x) ? 'y' : 'n';
            } while ('n' === $x);

            break;
        default:
            echo "Unknown command '$command'\n";
            $this->printUsage();
            exit(1);
        }

        return 0;
    }

    protected function printUsage()
    {
        echo
'usage: Console <command> <parameters>
command:
    test-input
';
    }

    private function printLastError()
    {
        $err = error_get_last();
        echo "Last error: {$err['message']}\n";
    }

    private function getUserInput($default)
    {
        $line = fgets($this->stdin);
        if (false === $line || '' === ($ui = trim($line))) {
            return $default;
        }

        return $ui;
    }

    private function askQuestion($descr, $defaultTrue)
    {
        if ($defaultTrue) {
            $y = 'Y';
            $n = 'n';
        } else {
            $y = 'y';
            $n = 'N';
        }
        echo "$descr [$y/$n]? ";
        $ret = strtolower($this->getUserInput($defaultTrue ? 'y' : 'n'));

        return 'y' === $ret;
    }
}

//php src/Console/Console.php test-input
(new Console())->run($argc, $argv);
