<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description = 'v';

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();
        $commandArgs = $this->getCommandArgs();
        $args = [];
        foreach ($commandArgs as $key => $value) {
            $args[] = sprintf("{%s : The %s number}", $value, $value);
        }
        $this->signature = sprintf('%s %s', $commandVerb, implode(", ", $args));
        $this->description = sprintf('%s the given number', ucfirst($this->getCommandPassiveVerb()));
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'pow';
    }

    protected function getCommandArgs(): array
    {
        return ['base', 'exp'];
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'exponent';
    }

    public function handle(): void
    {
        $base = $this->getInput('base');
        $exp = $this->getInput('exp');
        $description = $this->generateCalculationDescription([$base, $exp]);
        $result = $this->calculateAll([$base, $exp]);

        $this->comment(sprintf('%s = %s', $description, $result));
    }
    protected function getInput($args): string

    {
        return $this->argument($args);
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '^';
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 ** $number2;
    }
}
