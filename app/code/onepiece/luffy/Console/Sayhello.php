<?php
namespace onepiece\luffy\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class Sayhello extends Command
{
    const NAME = 'name';

    protected function configure()
    {
        $options = [
            new InputOption(
                self::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Name'
            )
        ];
        $this->setName('example:sayhelloonepiece');
        $this->setDescription('Demo command line For Onepiece')->setDefinition($options);

        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($name = $input->getOption(self::NAME)) {

            $output->writeln("Hello " . $name);


        } else {

            $output->writeln("Hello Onepiece");

        }

        return $this;
    }
}
