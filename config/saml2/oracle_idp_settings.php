<?php

// If you choose to use ENV vars to define these values, give this IdP its own env var names
// so you can define different values for each IdP, all starting with 'SAML2_'.$this_idp_env_id
$this_idp_env_id = 'ORACLE';

//This is variable is for simplesaml example only.
// For real IdP, you must set the url values in the 'idp' config to conform to the IdP's real urls.
//$idp_host = env('SAML2_'.$this_idp_env_id.'_IDP_HOST', 'http://localhost:8000/simplesaml');

return $settings = array(

    /*****
     * One Login Settings
     */

    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => true, //@todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => env('APP_DEBUG', false),

    // Service Provider Data that we are deploying
    'sp' => array(

        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
//       'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:emailAddress',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => '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',
        'privateKey' => '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
JLfrCMEfq4JoJE+sDnD+bI/g',

        // Identifier (URI) of the SP entity.
        // Leave blank to use the '{idpName}_metadata' route, e.g. 'test_metadata'.
        'entityId' => '',

        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-POST binding.
            // Leave blank to use the '{idpName}_acs' route, e.g. 'test_acs'
            'url' => '',
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        // Remove this part to not include any URL Location in the metadata.
        'singleLogoutService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-Redirect binding.
            // Leave blank to use the '{idpName}_sls' route, e.g. 'test_sls'
            'url' => '',
        ),
    ),

    // Identity Provider Data that we want connect with our SP
    'idp' => array(
        // Identifier of the IdP entity  (must be a URI)
        'entityId' => 'https://wna-ext.gcad.gc.telenor.com:443/oam/fed',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the SP will send the Authentication Request Message,
            // using HTTP-Redirect binding.
            'url' => 'https://wna-ext.gcad.gc.telenor.com/oamfed/idp/samlv20',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where the SP will send the SLO Request,
            // using HTTP-Redirect binding.
            'url' => 'https://wna-ext.gcad.gc.telenor.com/oamfed/idp/samlv20',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Public x509 certificate of the IdP
        'x509cert' => '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',
        /*
                 *  Instead of use the whole x509cert you can use a fingerprint
                 *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it)
                 */
        // 'certFingerprint' => '',
    ),


    /***
     *
     *  OneLogin advanced settings
     *
     *
     */
    // Security settings
    'security' => array(

        /** signatures and encryptions offered */

        // Indicates that the nameID of the <samlp:logoutRequest> sent by this SP
        // will be encrypted.
        'nameIdEncrypted' => false,

        // Indicates whether the <samlp:AuthnRequest> messages sent by this SP
        // will be signed.              [The Metadata of the SP will offer this info]
        'authnRequestsSigned' => false,

        // Indicates whether the <samlp:logoutRequest> messages sent by this SP
        // will be signed.
        'logoutRequestSigned' => false,

        // Indicates whether the <samlp:logoutResponse> messages sent by this SP
        // will be signed.
        'logoutResponseSigned' => false,

        /* Sign the Metadata
         False || True (use sp certs) || array (
                                                    keyFileName => 'metadata.key',
                                                    certFileName => 'metadata.crt'
                                                )
        */
        'signMetadata' => false,


        /** signatures and encryptions required **/

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => false,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => false,
    ),

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => array(
        'technical' => array(
            'givenName' => 'name',
            'emailAddress' => 'no@reply.com'
        ),
        'support' => array(
            'givenName' => 'Support',
            'emailAddress' => 'no@reply.com'
        ),
    ),

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => array(
        'en-US' => array(
            'name' => 'Name',
            'displayname' => 'Display Name',
            'url' => 'http://url'
        ),
    ),

    /* Interoperable SAML 2.0 Web Browser SSO Profile [saml2int]   http://saml2int.org/profile/current

       'authnRequestsSigned' => false,    // SP SHOULD NOT sign the <samlp:AuthnRequest>,
                                          // MUST NOT assume that the IdP validates the sign
       'wantAssertionsSigned' => true,
       'wantAssertionsEncrypted' => true, // MUST be enabled if SSL/HTTPs is disabled
       'wantNameIdEncrypted' => false,
    */

);
