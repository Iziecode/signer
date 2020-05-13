<?php

return [
    'keystore_type' => env('SIGNER_KEYSTORE_TYPE', 'PKCS12'),
    'keystore_file' => env('SIGNER_KEYSTORE_FILE', null),
    'keystore_password' => env('SIGNER_KEYSTORE_PASSPHRASE', null),
    'hash_algorithm' => 'SHA256',
    'tsa_hash_algorithm' => 'SHA256',
    'tsa_server_url' => null,
    'tsa_authentication' => 'PASSWORD',
    'tsa_user' => '',
    'tsa_password' => '',
    'location' => null,
    'reason' => null,
    'contact' => null,
    'output_prefix' => '',
    'output_suffix' => 'signed'
];
