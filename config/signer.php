<?php

/**
 * This config base on JSignPdf plugins
 * for more information : http://jsignpdf.sourceforge.net/uploads/JSignPdf.pdf
 * 
 */

return [

    /**
     * -------------------------------------------------------------------------
     * General Configuration
     * -------------------------------------------------------------------------
     * 
     */



    /**
     * Type of signature keystore
     * for now just PKCS12 is enable by default
     * but soon will available for
     * BCPKCS12, BKS. BKS-V1, BOUNCYCASTLE, CASEEXACTJKS, CloudFoxy, DKS, JCEKS
     * JKS, KEYCHAINSTORE, PKCS12-3DES-3DES, PKCS12-3DES-40RC2, PKCS12-DEF
     * PKCS12-DEF-3DES-3DES, PKCS12-DEF-3DES-40RC2
     * 
     */

    'keystore_type' => env('SIGNER_KEYSTORE_TYPE', 'PKCS12'),


    /**
     * Default path of keystore stored
     * example : /var/www/apps/storage/keys/keystore.p12
     * 
     */

    'keystore_file' => env('SIGNER_KEYSTORE_FILE', null),


    /**
     * Password or passphrase of keystore
     * 
     */

    'keystore_password' => env('SIGNER_KEYSTORE_PASSPHRASE', null),


    /**
     * Name (alias) of the key, which should be used for signing the document. 
     * If this option is not given, the first key in the keystore is used.
     * 
     */

    'key_alias' => null,


    /**
     * Zero based index of the key, which
     * should be used for signing the document. If neither this option nor
     * alias is given, the first key (index=0) 
     * in the keystore is used.
     * 
     */

    'key_index' => null,


    /**
     * Add signature to existing ones. By default are existing signatures
     * replaced by the new one.
     * 
     */

    'append' => false,


    /**
     * Level of certification. Default value is CERTIFIED_NO_CHANGES_ALLOWED. 
     * Available values are NOT_CERTIFIED, CERTIFIED_NO_CHANGES_ALLOWED,
     * CERTIFIED_FORM_FILLING, CERTIFIED_FORM_FILLING_AND_ANNOTATIONS    
     *                   
     */

    'certification_level' => 'CERTIFIED_NO_CHANGES_ALLOWED',


    /**
     * Enable CRL certificate validation
     * 
     */

    'crl' => false,


    /**
     * Disables the Acrobat 6 layer mode i.e. all signature layers will be created.
     * Acrobat 6.0 and higher recommends that only layer n2 and n4 be present.
     * 
     */

    'disable_acrobat6_layer_mode' => false,


    /**
     * Deny assembly in encrypted documents
     * 
     */

    'disable_assembly' => false,


    /**
     * Deny copy in encrypted documents
     * 
     */

    'disable_copy' => false,


    /**
     * Deny fill encrypted documents
     * 
     */

    'disable_fill' => false,


    /**
     * Deny modify annotations in encrypted documents
     * 
     */

    'disable_modify_annotations' => true,

    /**
     * Deny modify content in encrypted documents
     * 
     */

    'disable_modify_content' => true,


    /**
     * deny screen readers in encrypted documents
     * 
     */

    'disable_screen_readers' => false,


    /**
     * Encryption mode for the output PDF
     * Default value is NONE.
     * Possible values are NONE, PASSWORD, CERTIFICATE.
     * 
     */

    'encryption' => 'NONE',


    /**
     * User password for encrypted documents
     * when using encryption = PASSWORD
     * 
     */

    'user_password' => null,


    /**
     * Path to the certificate file, which is used to encrypt output PDF
     * in case of encryption = CERTIFICATE
     * 
     */

    'encryption_certificate' => null,


    /**
     * Certificate password/passphrase to open certificate
     * in case of encryption = CERTIFICATE
     * 
     */

    'owner_password' => null,


    /**
     * Hash algorithm used for signature.
     * Default value is SHA256. Available values are 
     * SHA1, SHA256, SHA384, SHA512, RIPEMD160
     */

    'hash_algorithm' => 'SHA256',


    /**
     * Folder in which the signed documents will be stored. 
     * Default value is public_path
     * Make sure the output folder exists
     * 
     */

    'output_directory' => public_path(''),


    /**
     * Prefix for signed file. Default value is empty prefix
     * 
     */

    'output_prefix' => '',


    /**
     * Suffix for signed filename. Default value is "_signed".
     * 
     */

    'output_suffix' => '_signed',


    /**
     * Printing rights. Used for encrypted
     * documents. Default value is ALLOW_PRINTING. Available values are
     * DISALLOW_PRINTING, ALLOW_DEGRADED_PRINTING, ALLOW_PRINTING
     * 
     */

    'print_right' => 'ALLOW_PRINTING',



    /**
     * -------------------------------------------------------------------------
     * Signature Information
     * -------------------------------------------------------------------------
     * 
     */

    /**
     * Reason of signature
     * 
     */

    'reason' => null,

    /**
     * Signers contact details
     *  
     */

    'contact' => null,


    /**
     * Signer location
     * 
     */

    'location' => null,


    /**
     * Layer 2 Text : Signature Text
     * You can also use placeholders for signature properties
     * (${signer}, ${timestamp}, ${location}, ${reason}, ${contact})
     * 
     */

    'l2_text' => null,


    /**
     * Layer 4 Text
     * status text
     */

    'l4_text' => null,



    /**
     * -------------------------------------------------------------------------
     * Visible Signature
     * -------------------------------------------------------------------------
     * 
     */

    /**
     * Switch to visible signature
     * 
     */

    'visible_signature' => false,


    /**
     * Page with visible signature. Default
     * value is 1 (first page). If the
     * provided page number is out of bounds, then the last page is used
     * 
     */

    'page' => 1,


    /**
     * Upper Right Corner X Axe
     * For more information visit : http://jsignpdf.sourceforge.net/uploads/JSignPdf.pdf
     */

    'urx' => null,


    /**
     * Upper Right Corner Y Axe
     * 
     */

    'ury' => null,


    /**
     * Lower Left Corner X Axe
     * 
     */

    'llx' => null,


    /**
     * Lower Left Corner Y Axe
     * 
     */

    'lly' => null,


    /**
     * Path of image for visible signature
     * 
     */

    'img_path' => null,


    /**
     * Path of backgroud image for visible signature
     * 
     */

    'bg_path' => null,


    /**
     * Background image scale for visible                                         
     * signatures. Insert positive value to                                         
     * multiply image size with the value.                                         
     * Insert zero value to fill whole                                         
     * background with it (stretch). Insert                                         
     * negative value to best fit resize
     * 
     */

    'bg_scale' => null,


    /**
     * Font size for visible signature text,                                         
     * default value is 10.0
     * 
     */

    'font_size' => 10.0,


    /**
     * render mode for visible signatures.                                         
     * Default value is DESCRIPTION_ONLY.                                         
     * Possible values are 
     * DESCRIPTION_ONLY, GRAPHIC_AND_DESCRIPTION, SIGNAME_AND_DESCRIPTION
     * 
     */

    'render_mode' => 'DESCRIPTION_ONLY',



    /**
     * -------------------------------------------------------------------------
     * TSA & Certificate Revocation
     * -------------------------------------------------------------------------
     * 
     */

    /**
     * Enable OCSP certificate validation
     * 
     */

    'ocsp' => false,


    /**
     * Default OCSP server URL, which will be                                         
     * used in case the signing certificate                                         
     * doesn't contain this information
     * 
     */

    'ocsp_server_url' => null,


    /**
     * Address of timestamping server (TSA).                                         
     * If you use this argument, the timestamp                                         
     * will be included to signature.
     * 
     */

    'tsa_server_url' => null,


    /**
     * Authentication method used when                                         
     * contacting TSA server. 
     * Possible values are NONE, PASSWORD, CERTIFICATE
     * 
     */

    'tsa_authentication' => null,


    /**
     * TSA Username
     * 
     */

    'tsa_user' => '',


    /**
     * TSA Password
     * 
     */

    'tsa_password' => '',



    /**
     * Hash algorithm used to in query to                                         
     * time-stamping server (TSA); the default                                         
     * is SHA256
     * 
     */

    'tsa_hash_algorithm' => 'SHA256',


    /**
     * TSA policy OID which should be set to                                         
     * timestamp request
     * 
     */

    'tsa_policy_oid' => null,


    /**
     * Keystore type for TSA CERTIFICATE                                         
     * authentication
     * 
     */

    'tsa_cert_file_type' => null,


    /**
     * Path to keystore file, which contains                                         
     * private key used to authentication                                         
     * against TSA server, when CERTIFICATE
     * authentication method is used
     * 
     */

    'tsa_cert_file' => null,

    /**
     * TSA Keystore passpord
     * 
     */

    'tsa_cert_password' => null,

    /**
     * Hostname or IP address of proxy server
     * 
     */

    'proxy_host' => null,


    /**
     * Proxy Port
     * 
     */

    'proxy_port' => 80,


    /**
     * Proxy type for internet connections.                                         
     * Default value is DIRECT. Possible                                         
     * values are DIRECT, HTTP, SOCKS
     */

    'proxy_type' => 'DIRECT'
];
