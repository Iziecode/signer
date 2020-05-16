<?php

return [
    'append' => true,
    'bg_path' => null,
    'bg_scale' => null,
    'certification_level' => 'CERTIFIED_NO_CHANGES_ALLOWED',
    'crl' => false,
    'contact' => null,
    'disable_acrobat6_layer_mode' => false,
    'disable_assembly' => false,
    'disable_copy' => false,
    'disable_fill' => false,
    'disable_modify_annotations' => true,
    'disable_modify_content' => true,
    'disable_screen_readers' => false,
    'encryption' => 'NONE',
    'encryption_certificate' => null,
    'font_size' => 10.0,
    'hash_algorithm' => 'SHA256',
    'img_path' => null,

    /**
     * For now just support for PKCS12
     * and willbe support for others keystore type
     * - BCPKCS12
     * - BKS
     * - BKS-V1
     * - BOUNCYCASTLE
     * - CASEEXACTJKS
     * - CloudFoxy
     * - DKS
     * - JCEKS
     * - JKS
     * - KEYCHAINSTORE
     * - PKCS12-3DES-3DES
     * - PKCS12-3DES-40RC2
     * - PKCS12-DEF
     * - PKCS12-DEF-3DES-3DES
     * - PKCS12-DEF-3DES-40RC2
     * 
     */
    'keystore_type' => env('SIGNER_KEYSTORE_TYPE', 'PKCS12'),
    'keystore_file' => env('SIGNER_KEYSTORE_FILE', null),
    'keystore_password' => env('SIGNER_KEYSTORE_PASSPHRASE', null),
    'key_alias' => null,
    'key_index' => null,
    'l2_text' => null,
    'l4_text' => null,
    'location' => null,
    'llx' => null,
    'lly' => null,

    /**
     * Set the output signed directory
     * 
     */
    'output_directory' => null,
    'output_prefix' => '',
    'output_suffix' => '_signed',
    'ocsp' => false,
    'ocsp_server_url' => null,
    'owner_password' => null,

    'page' => 1,
    'print_right' => 'ALLOW_PRINTING',
    'proxy_host' => null,
    'proxy_port' => 80,
    'proxy_type' => 'DIRECT',
    'render_mode' => 'DESCRIPTION_ONLY',
    'reason' => null,
    'tsa_hash_algorithm' => 'SHA256',
    'tsa_server_url' => null,
    'tsa_authentication' => 'PASSWORD',
    'tsa_user' => '',
    'tsa_password' => '',
    'tsa_policy_oid' => null,
    'tsa_cert_file' => null,
    'tsa_cert_password' => null,
    'tsa_cert_file_type' => null,
    'user_password' => null,
    'urx' => null,
    'ury' => null,
    'visible_signature' => false
];
