<?php
/**
 * This file is part of the Jacobine package.
 *
 * (c) Andreas Grunwald <andygrunwald@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jacobine\Command;

use Jacobine\Consumer\ConsumerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class ListConsumerCommand
 *
 * Command to list all available consumer which can be used to get some messages (tasks) done.
 * This command does not execute something. It will only output a list of usable consumer.
 *
 * A consumer must be registered in the DIC as a consumer (tag "jacobine.consumer").
 *
 * Usage:
 *  php console jacobine:list-consumer
 *
 * @package Jacobine\Command
 * @author Andy Grunwald <andygrunwald@gmail.com>
 */
class ListConsumerCommand extends Command implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    /**
     * Pad length for consumer name
     *
     * @var integer
     */
    const PAD_LENGTH = 30;

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('jacobine:list-consumer')
             ->setDescription('Lists all available consumer');
    }

    /**
     * Executes the current command.
     *
     * Lists all available consumer + description.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     * @return null|integer null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var \Jacobine\DependencyInjection\ConsumerList $consumerListService */
        $consumerListService = $this->container->get('dependencyInjection.consumerList');
        $consumerCollection = $consumerListService->getAllConsumer();

        $table = new Table($output);
        $table->setHeaders(['Consumer', 'Description']);

        foreach ($consumerCollection as $consumer) {
            $consumerName = $this->buildConsumerName($consumer);
            $table->addRow([
                    "<comment>" . $consumerName . "</comment>",
                    $consumer->getDescription()
                ]);
        }

        $table->render();

        return 0;
    }

    /**
     * Builds the consumer name (which should be used to execute a consumer) from a consumer instance.
     *
     * E.g.:
     *      $consumer: Instance of \Jacobine\Consumer\Download\Git
     *      Return: Download\\Git
     *
     * @param ConsumerInterface $consumer
     * @return string
     */
    protected function buildConsumerName(ConsumerInterface $consumer)
    {
        $className = get_class($consumer);
        $classNameParts = explode('\\', $className);
        $classNameParts = array_slice($classNameParts, -2);
        $consumerName = implode('\\\\', $classNameParts);

        return $consumerName;
    }
}