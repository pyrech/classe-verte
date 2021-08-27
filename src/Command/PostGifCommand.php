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

    private EstCeQueCEst $estCeQueCEst;
    private string $kernelProjectDir;

    public function __construct(EstCeQueCEst $estCeQueCEst, string $kernelProjectDir)
    {
        $this->estCeQueCEst = $estCeQueCEst;
        $this->kernelProjectDir = $kernelProjectDir;
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

        $imagePublicPath = sprintf('images/J%s.gif', $nbDays);

        if (!file_exists($this->kernelProjectDir . '/public/' . $imagePublicPath)) {
            $output->writeln(sprintf('No gif for today (nbDays = %s)', $nbDays));

            return 0;
        }

        $content = new Content($this->estCeQueCEst->bientotLaClasseVerte());
        $data = 'payload='.json_encode($this->getSlackPayload($content, $imagePublicPath));

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

    private function getSlackPayload(Content $content, string $imagePublicPath): array
    {
        return [
            'username' => 'Est-ce que c\'est bientôt la classe verte ?',
            'attachments' => [
                [
                    'title' => sprintf('%s %s', $content->getTitle(), $content->getSubtitle()),
                    'title_link' => 'https://estcequecestbientotlaclasseverte.fr',
                    'fallback' => sprintf('%s %s', $content->getTitle(), $content->getSubtitle()),
                    'image_url' => 'https://estcequecestbientotlaclasseverte.fr/' . $imagePublicPath . '?' . uniqid(),
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
