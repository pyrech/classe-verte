<?php

namespace App\Command;

use App\EstCeQueCEst;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostGifCommand extends Command
{
    protected static $defaultName = 'app:post-gif';
    private $estCeQueCEst;

    public function __construct(EstCeQueCEst $estCeQueCEst)
    {
        $this->estCeQueCEst = $estCeQueCEst;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Send gif to Slack with remaining days');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nbDays = $this->estCeQueCEst->getRemainingDays();
        $image = sprintf('https://classe-verte.fr/images/J%s.gif?', $nbDays).uniqid();

        if ($nbDays > 60) {
            return;
        } elseif($this->is404($image)) {
            $output->writeln(sprintf('No gif for today (nbDays = %s)', $nbDays));
            return;
        }

        $data = 'payload=' . json_encode($this->getSlackPayload($nbDays, $image));

        $ch = curl_init(getenv('SLACK_WEBHOOK_URL'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result !== 'ok') {
            $output->writeln(sprintf('Slack returned "%s"', $result));
        }
    }

    private function getSlackPayload(int $nbDays, $image): array
    {
        return [
            'username' => 'Est-ce que c\'est bientôt la classe verte ?',
            'attachments' => [
                [
                    'title' => 'J'.($nbDays ? '-' : '+').abs($nbDays),
                    'title_link' => 'https://estcequecestbientotlaclasseverte.fr',
                    'fallback' => $nbDays,
                    'image_url' => $image,
                ],
                [
                    'fallback' => 'footer',
                    'footer' => 'estcequecestbientotlaclasseverte.fr, en étroite collaboration avec classe-verte.fr',
                ],
            ],
        ];
    }

    /**
     * Quick and dirty
     */
    private function is404(string $url): bool
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3) === '404';
    }
}
