<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCallbackRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListPolicyCallbacks extends Command
{
    const ARG_POLICY_ID = 'policy-id';
    private PolicyCallbackRepositoryInterface $callbackRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        PolicyCallbackRepositoryInterface $callbackRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->callbackRepository = $callbackRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('group-ship-policy:list-callbacks');
        $this->setDescription('Lists all group shipping policy callback records');
        $this->addArgument(self::ARG_POLICY_ID, InputArgument::REQUIRED, 'Policy ID');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $policyId = (int) $input->getArgument(self::ARG_POLICY_ID);

        $this->searchCriteriaBuilder->addFilter('policy_id', $policyId);
        $callbacks = $this->callbackRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        foreach ($callbacks as $callback) {
            $output->writeln(print_r($callback->getData(), true));
        }

        return 0;
    }
}
