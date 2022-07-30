<?php

namespace App\Command;

use App\Content;
use App\EstCeQueCEst;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'app:post-gif', description: 'Send gif to Slack with remaining days')]
class PostGifCommand extends Command
{
    public function __construct(
        private EstCeQueCEst $estCeQueCEst,
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger,
        private string $kernelProjectDir,
        private string $slackWebhookUrl,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nbDays = $this->estCeQueCEst->getRemainingDays();

        if ($nbDays > 60 || $nbDays < 0) {
            return self::SUCCESS;
        }

        $imagePublicPath = sprintf('images/J%s.gif', $nbDays);

        if (!file_exists($this->kernelProjectDir . '/public/' . $imagePublicPath)) {
            $this->logger->notice(sprintf('No gif for today (nbDays = %s)', $nbDays));

            return self::SUCCESS;
        }

        $content = new Content($this->estCeQueCEst->bientotLaClasseVerte());
        $payload = $this->getSlackPayload($content, $imagePublicPath);

        try {
            $response = $this->httpClient->request(
                'POST',
                $this->slackWebhookUrl,
                [
                    'json' => $payload,
                ]
            );

            $statusCode = $response->getStatusCode();

            if (200 !== $statusCode) {
                $this->logger->error(sprintf('Error when sending notification to Slack, %s returned', $statusCode));
            }
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Fail to send notification to Slack', [
                'exception' => $e,
            ]);
        }

        return self::SUCCESS;
    }

    private function getSlackPayload(Content $content, string $imagePublicPath): array
    {
        return [
            'username' => 'Est-ce que c\'est bientôt la classe verte ?',
            'icon_url' => 'https://estcequecestbientotlaclasseverte.fr/logo.png',
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
}
