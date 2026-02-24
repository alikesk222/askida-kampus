<?php

return [
    'name'                    => $_ENV['APP_NAME']                    ?? 'Askıda Kampüs',
    'env'                     => $_ENV['APP_ENV']                     ?? 'development',
    'secret'                  => $_ENV['APP_SECRET']                  ?? 'change_me_in_env_file',
    'reservation_expire_min'  => (int)($_ENV['RESERVATION_EXPIRE_MINUTES'] ?? 30),
    'iban'                    => $_ENV['IBAN']                        ?? '',
];
