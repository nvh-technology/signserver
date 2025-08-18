<?php

return [
    'baseurl' => env("RSSP_BASE_URL", "http://localhost:8000"),
    'name' => env("RSSP_NAME"),
    'user' => env("RSSP_USER"),
    'password' => env("RSSP_PASSWORD"),
    'signature' => env("RSSP_SIGNATURE"),
    'keystore.file' => env("RSSP_KEYSTORE_FILE"),
    'keystore.password' => env("RSSP_KEYSTORE_PASSWORD"),
];
