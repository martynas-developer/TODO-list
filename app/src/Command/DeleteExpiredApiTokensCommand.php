<?php

namespace App\Command;

use App\Entity\ApiToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteExpiredApiTokensCommand extends Command
{
    protected static $defaultName = 'delete_expired_api_tokens';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this->setDescription('Delete all expired api tokens');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $expiredApiTokens = $this->em->getRepository(ApiToken::class)->getExpiredTokens();
        foreach ($expiredApiTokens as $expiredApiToken) {
            $this->em->remove($expiredApiToken);
        }
        $this->em->flush();
        $io->success(count($expiredApiTokens) . ' tokens have been deleted');
        return Command::SUCCESS;
    }
}
