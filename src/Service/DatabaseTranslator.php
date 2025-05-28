<?php

namespace App\Service;

use App\Repository\TranslationRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\MessageCatalogueInterface;

class DatabaseTranslator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface
{
    private $translator;
    private $translationRepository;
    private $translations = [];
    private $locale;

    public function __construct(TranslatorInterface $translator, TranslationRepository $translationRepository)
    {
        $this->translator = $translator;
        $this->translationRepository = $translationRepository;
        $this->locale = $translator->getLocale();
    }

    public function loadTranslations()
    {
        $translations = $this->translationRepository->findAll();
        foreach ($translations as $translation) {
            $this->translations[$translation->getLocale()][$translation->getTranslationKey()] = $translation->getTranslation();
        }
    }

    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        $locale = $locale ?? $this->getLocale();
        
        if (isset($this->translations[$locale][$id])) {
            return strtr($this->translations[$locale][$id], $parameters);
        }

        return $this->translator->trans($id, $parameters, $domain, $locale);
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getCatalogue(string $locale = null): MessageCatalogueInterface
    {
        $locale = $locale ?? $this->getLocale();
        $catalogue = new MessageCatalogue($locale);

        if (isset($this->translations[$locale])) {
            foreach ($this->translations[$locale] as $key => $translation) {
                $catalogue->set($key, $translation);
            }
        }

        return $catalogue;
    }

    public function getCatalogues(): array
    {
        $catalogues = [];
        foreach (array_keys($this->translations) as $locale) {
            $catalogues[] = $this->getCatalogue($locale);
        }
        return $catalogues;
    }
}