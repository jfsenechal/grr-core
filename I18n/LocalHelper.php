<?php

namespace Grr\Core\I18n;

use Grr\Core\Contrat\Entity\Security\UserInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class LocalHelper
{
    private ParameterBagInterface $parameterBag;
    private RequestStack $requestStack;
    private Security $security;

    public function __construct(ParameterBagInterface $parameterBag, Security $security, RequestStack $requestStack)
    {
        $this->parameterBag = $parameterBag;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function getDefaultLocal(): string
    {
        /**
         * User preference.
         *
         * @var UserInterface
         */
        $user = $this->security->getUser();
        if ($user && $user->getLanguageDefault()) {
            return $user->getLanguageDefault();
        }
        /**
         * Url.
         */
        $request = $this->requestStack->getMasterRequest();
        if (null !== $request) {
            return $request->getLocale();
        }

        /*
         * Parameter from symfony config/translation.yaml
         * */
        $local = $this->parameterBag->get('kernel.default_locale');
        if (null != $local) {
            return $local;
        }

        return 'fr'; //a cause de test phpunit
    }

    public function getSupportedLocales(): array
    {
        $locales = $this->parameterBag->get('grr.supported_locales');

        return array_combine($locales, $locales);
    }
}
