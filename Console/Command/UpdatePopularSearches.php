<?php

namespace Tagalys\Frontend\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class UpdatePopularSearches extends Command
{
    public function __construct(
        \Magento\Framework\App\State $appState,
        \Tagalys\Frontend\Helper\Search $searchHelper,
        \Tagalys\Sync\Helper\Configuration $tagalysConfiguration
    ) {
        $this->appState = $appState;
        $this->searchHelper = $searchHelper;
        $this->tagalysConfiguration = $tagalysConfiguration;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('tagalys:update_popular_searches');
        $this->setDescription('Update Tagalys popular searches');

        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->appState->setAreaCode('adminhtml');
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            // do nothing
        }
        $utcNow = new \DateTime("now", new \DateTimeZone('UTC'));
        $timeNow = $utcNow->format(\DateTime::ATOM);
        $this->tagalysConfiguration->setConfig('heartbeat:command:update_popular_searches', $timeNow);

        $this->searchHelper->cachePopularSearches();

        $output->writeln("Done");
    }
}
