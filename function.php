<?php
/**
 * @param string $str
 * @return array
 */

declare( strict_types = 1 );

function parser( string $str ) {
    preg_match( '/[^\d]([0-9]{4})/' , $str , $confirmationCode );

    if ( empty ( $confirmationCode ) ) {
        $confirmationCode = 'error';
    } else {
        $confirmationCode = 'confirm:' . $confirmationCode[1];
    }

    preg_match( '/([0-9]+[\.|\,][0-9]{2})[р\.|руб\.|₽]/u' , $str , $amount );

    if ( empty ( $amount ) ) {
        $amount = 'error';
    } else {
        $amount = 'amount:' . $amount[0];
    }

    preg_match( '/([0-9]{13,15})/' , $str , $wallet );

    if ( empty ( $wallet ) ) {
        $wallet = 'error';
    } else {
        $wallet = 'wallet:' . $wallet[0];
    }

    return [
        $confirmationCode,
        $amount,
        $wallet,
    ];
}

$messages = [
    'Пароль: 4550 Спишется 5,03р. Перевод на счет 41001577435854',
    'Недостаточно средств.',
    'Сумма указана неверно.',
    'Пароль: 5728 Спишется 123,62р. Перевод на счет 41001577435854',
    'Пароль: 7076 Спишется 46,24р. Перевод на счет 41001577435854',
    'Кошелек Яндекс.Денег указан неверно.',
    'Пароль: 1234 Перевод на счет 41001577435854 Спишется 46.24р.',
    'Спишется 46,12р. Перевод на счет 41001577435854 Пароль: 7076',
];

foreach ( $messages as $message ) {
    echo '<pre>';
    print_r( parser( $message ) );
    echo '</pre>';
}

?>
