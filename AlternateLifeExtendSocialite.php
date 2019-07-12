<?php

namespace AlternateLife\Socialite\Portal;

use SocialiteProviders\Manager\SocialiteWasCalled;

class AlternateLifeExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'alternatelife',
            __NAMESPACE__ . '\Provider'
        );
    }
}
