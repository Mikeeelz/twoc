<?php

namespace App\Twig;

use App\Repository\ConsultantsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConsultantExtension extends AbstractExtension
{
    private ConsultantsRepository $consultantsRepository;

    public function __construct(
        ConsultantsRepository $consultantsRepository,
    )
    {
        $this->consultantsRepository = $consultantsRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getConsultants', [$this, 'getConsultants']),
        ];
    }

    public function getConsultants(): array
    {
        return $this->consultantsRepository->findAll();
    }
}