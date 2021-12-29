<?php

namespace App\Command;

use App\Controller\MainController;
use App\Enum\OperandTypeEnum;
use App\Service\CalculatorHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'calc:op',
    description: 'Performs math operation on the given operands',
)]
class CalcOpCommand extends Command
{
    private MainController $calculatorController;
    private CalculatorHelper $calc;

    public function __construct(MainController $calculatorController, CalculatorHelper $calc, string $name = null)
    {
        parent::__construct($name);

        $this->calculatorController = $calculatorController;
        $this->calc = $calc;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('numA', InputArgument::REQUIRED, 'Operand A')
            ->addArgument('op', InputArgument::REQUIRED, 'Operand')
            ->addArgument('numB', InputArgument::REQUIRED, 'Operand B');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // read parameters
        $numA = $input->getArgument('numA');
        $op = $input->getArgument('op');
        $numB = $input->getArgument('numB');

        // return if all values are entered, run the wizard otherwise
        if (null !== $numA && null !== $op && null !== $numB) {
            return;
        }

        // wizard initialization & presentation
        $io = new SymfonyStyle($input, $output);
        $io->title('Interactive wizard for calculation');
        $io->text([
            'If you prefer not to use this interactive wizard,',
            'just provide the required arguments in the given order:',
            '<question>$ symfony console calc:op <numA> <operator> <NumB></question>',
            'You always will be asked for the missing arguments.',
        ]);
        $io->newLine();

        // ask for <numA> if missing
        if (null !== $numA) {
            $io->text('<info>Operand A</info>: ' . $numA);
        } else {
            $numA = $io->ask('Operand A');
            $input->setArgument('numA', $numA);
        }

        // ask for <operator> if missing
        if (null !== $op) {
            $io->text('<info>Operator</info>: ' . $op);
        } else {
            $op = $io->ask('Operator (+, -, /, x)');
            $input->setArgument('op', $op);
        }

        // ask for <numB> if missing
        if (null !== $numB) {
            $io->text('<info>Operand B</info>: ' . $numB);
        } else {
            $numB = $io->ask('Operand B');
            $input->setArgument('numB', $numB);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // read parameters
        $numA = $input->getArgument('numA');
        $op = $input->getArgument('op');
        $numB = $input->getArgument('numB');

        // check that operands are numbers
        if (!is_numeric($numA) || !is_numeric($numB)) {
            $io->error("Operands must be numbers.");
            return Command::FAILURE;
        }

        // check that operation is defined
        if (!OperandTypeEnum::isOperatorDefined($op)) {
            $io->error(sprintf("The operation %s is not defined.", $op));
            return Command::FAILURE;
        }

        // controller as service
        $response = $this->calculatorController->calculator(OperandTypeEnum::getTypeByOperator($op), $numA, $numB, $this->calc);
        $content = json_decode($response->getContent(), true);

        // if error, print & exit
        if (200 !== $response->getStatusCode()) {
            $io->error(sprintf("%d - %s", $content['error'], $content['message']));
            return Command::FAILURE;
        }

        // print result & exit
        $io->success(sprintf("%d %s %d = %d", $numA, $op, $numB, $content['result']));
        return Command::SUCCESS;
    }
}
