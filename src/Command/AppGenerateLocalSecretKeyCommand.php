<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'App:Generate-Local-Secret-Key',
    description: 'Create .env.dev.local file with a generated APP_SECRET key',
)]
class AppGenerateLocalSecretKeyCommand extends Command
{
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
       
        $enviFile='.env.dev.local';

        if (file_exists($enviFile)) {
            $io->error($enviFile.' file already exists. Aborting to avoid overwriting existing file.');
            return Command::FAILURE;
        }

       bin2hex(random_bytes(16));

        $appSecret = bin2hex(random_bytes(16));
        
        file_put_contents($enviFile, "APP_SECRET=$appSecret\n");
        $io->success($enviFile.' file created with a new APP_SECRET key.');
        
    
     return Command::SUCCESS;
 }
}
