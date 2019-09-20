<?php


namespace App\Commands;

use \Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

abstract class Command extends BaseCommand
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $question
     * @return mixed
     */
    protected function ask(InputInterface $input, OutputInterface $output, string $question)
    {
        $helper = $this->getHelper('question');
        $question = new Question($question);

        $question->setNormalizer(function ($value) {
            return $value ? trim($value) : '';
        });

        return $helper->ask($input, $output, $question);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $question
     * @param array $choices
     * @return mixed
     */
    protected function choice(InputInterface $input, OutputInterface $output, string $question, array $choices)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion($question, $choices);

        return $helper->ask($input, $output, $question);
    }
}
