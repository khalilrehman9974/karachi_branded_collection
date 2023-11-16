<?php

Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function (Saml2LoginEvent $event) {
    $messageId = $event->getSaml2Auth()->getLastMessageId();
    // Add your own code preventing reuse of a $messageId to stop replay attacks

    $user = $event->getSaml2User();
    $userData = [
        'id' => $user->getUserId(),
        'attributes' => $user->getAttributes(),
        'assertion' => $user->getRawSamlAssertion()
    ];
    $laravelUser = //find user by ID or attribute
        //if it does not exist create it and go on  or show an error message
        Auth::login($laravelUser);
});

Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
    Auth::logout();
    Session::save();
});
