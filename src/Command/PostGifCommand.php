<?php

namespace App\Command;

use App\Content;
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

    protected function configure(): void
    {
        $this->setDescription('Send gif to Slack with remaining days');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nbDays = $this->estCeQueCEst->getRemainingDays();

        if ($nbDays > 60 || $nbDays < 0) {
            return 0;
        }

        $image = sprintf('https://classe-verte.fr/images/J%s.gif?', $nbDays).uniqid();

        if ($this->is404($image)) {
            $output->writeln(sprintf('No gif for today (nbDays = %s)', $nbDays));

            return 0;
        }

        $content = new Content($this->estCeQueCEst->bientotLaClasseVerte());
        $data = 'payload='.json_encode($this->getSlackPayload($content, $image));

        $ch = curl_init(getenv('SLACK_WEBHOOK_URL'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if ('ok' !== $result) {
            $output->writeln(sprintf('Slack returned "%s"', $result));
        }

        return 0;
    }

    private function getSlackPayload(Content $content, $image): array
    {
        return [
            'username' => 'Est-ce que c\'est bientôt la classe verte ?',
            'attachments' => [
                [
                    'title' => sprintf('%s %s', $content->getTitle(), $content->getSubtitle()),
                    'title_link' => 'https://estcequecestbientotlaclasseverte.fr',
                    'fallback' => sprintf('%s %s', $content->getTitle(), $content->getSubtitle()),
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
     * Quick and dirty.
     */
    private function is404(string $url): bool
    {
        $headers = get_headers($url);

        return '404' === substr($headers[0], 9, 3);
    }
}
