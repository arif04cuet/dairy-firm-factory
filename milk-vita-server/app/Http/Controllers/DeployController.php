<?php

namespace App\Http\Controllers;

use Artisan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {

        //Gate::authorize('viewHorizon');
        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');
        $localToken = config('app.deploy_secret');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        if (hash_equals($githubHash, $localHash)) {

            $this->gitPull();
            $this->deployLaravel();
            $this->deployNuxt();
        }
    }

    private function gitPull()
    {
        shell_exec('cd /var/www/html/milkvita.rdcd.gov.bd && git pull origin main');
        #shell_exec('git pull origin main');
    }

    private function deployLaravel()
    {

        $commands = <<<IDENTIFIER
        cd /var/www/html/milkvita.rdcd.gov.bd/milk-vita-server && chmod +x .scripts/deploy_stage.sh 
        && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
        && php artisan clear-compiled
        && php artisan optimize:clear
        && php artisan migrate --force
IDENTIFIER;

        $output = shell_exec($commands);

        #shell_exec("cd /var/www/html/milkvita.rdcd.gov.bd/milk-vita-server && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader &&");
        #shell_exec('chmod +x ' . base_path('.scripts/deploy_stage.sh'));
        #shell_exec('sh .scripts/deploy_stage.sh');

        // $script =  './.scripts/deploy_stage.sh';

        // $process = new Process([$script], '/var/www/html/milkvita.rdcd.gov.bd/milk-vita-server');
        // $process->run();

        // // executes after the command finishes
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // $output = $process->getOutput();
        logger($output);
    }

    private function deployNuxt()
    {

        shell_exec('cd /var/www/html/milkvita.rdcd.gov.bd/milk-vita-cli && npm install && npm run generate && cp .htaccess dist/');
        // shell_exec('npm install');
        // $output = shell_exec('npm run generate');
        // shell_exec('cp .htaccess dist/');
        // logger($output);
    }
}
