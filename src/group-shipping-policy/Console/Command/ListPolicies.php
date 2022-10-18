<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListPolicies extends Command
{
    private GroupShippingPolicyRepositoryInterface $policyRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        GroupShippingPolicyRepositoryInterface $policyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->policyRepository = $policyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('group-ship-policy:list-policies');
        $this->setDescription('Lists all group shipping policies');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $policies = $this->policyRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        foreach ($policies as $policy) {
            $output->writeln(print_r($policy->getData(), true));
        }

        return 0;
    }
}
