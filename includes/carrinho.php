<?php

// =========================================================
// HELPERS CENTRAIS DO CARRINHO E CHECKOUT
// Este ficheiro concentra a logica partilhada do modulo:
// - sessao e CSRF
// - catalogo e opcoes de personalizacao
// - validacoes e calculo de preco
// - operacoes do carrinho em $_SESSION
// =========================================================

if (!function_exists('dd_start_session')) {
    function dd_start_session()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}

if (!function_exists('dd_catalogo_bolos')) {
    function dd_catalogo_bolos()
    {
        return [
            'bolo-avos' => [
                'nome' => 'Bolo de Avos',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-avós-aniv.jpg',
                'desc' => 'Um bolo especial dedicado aos avos.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-camisa' => [
                'nome' => 'Bolo Camisa',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-camisa-aniv.jpg',
                'desc' => 'Perfeito para os apaixonados por futebol.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-cars' => [
                'nome' => 'Bolo Cars',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-cars-aniv.jpg',
                'desc' => 'Bolo inspirado no filme Cars.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-conchas' => [
                'nome' => 'Bolo Conchas',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-conchas-aniv.jpg',
                'desc' => 'Bolo decorado com conchas.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-panda' => [
                'nome' => 'Bolo Panda',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-panda-aniv.jpg',
                'desc' => 'Fofissimo bolo panda.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-pasteleiro' => [
                'nome' => 'Bolo Pasteleiro',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-pasteleiro-aniv.jpg',
                'desc' => 'Classico bolo pasteleiro.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-praia' => [
                'nome' => 'Bolo Praia',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-praia-aniv.jpg',
                'desc' => 'Bolo com tema de praia.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-rosa' => [
                'nome' => 'Bolo Rosa',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-rosa-aniv.jpg',
                'desc' => 'Bolo rosa delicado.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-sofa' => [
                'nome' => 'Bolo Sofa',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-sofa-aniv.jpg',
                'desc' => 'Confortavel bolo sofa.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-sonic' => [
                'nome' => 'Bolo Sonic',
                'img' => 'img-pap/nossos-bolos/aniversario/bolo-sonic-aniv.jpg',
                'desc' => 'Bolo do velocissimo Sonic.',
                'categoria' => 'aniversario',
                'preco_base' => 25.00,
            ],
            'bolo-batismo' => [
                'nome' => 'Bolo Batismo',
                'img' => 'img-pap/nossos-bolos/batizado/bolo-batismo-bat.jfif',
                'desc' => 'Um bolo especial dedicado aos batismos.',
                'categoria' => 'batizado',
                'preco_base' => 25.00,
            ],
            'bolo-1ºcomunhão' => [
                'nome' => 'Bolo 1º Comunhao',
                'img' => 'img-pap/nossos-bolos/batizado/bolo-1ºcomunhão-bat.jfif',
                'desc' => 'Um bolo especial para a primeira comunhao.',
                'categoria' => 'batizado',
                'preco_base' => 25.00,
            ],
            'bolo-baloiço' => [
                'nome' => 'Bolo Baloico',
                'img' => 'img-pap/nossos-bolos/batizado/bolo-baloiço-bat.jfif',
                'desc' => 'Um bolo tematico de baloico.',
                'categoria' => 'batizado',
                'preco_base' => 25.00,
            ],
            'bolo-aliancas' => [
                'nome' => 'Bolo Aliancas',
                'img' => 'img-pap/nossos-bolos/casamento/bolo-aliancas-cas.jpg',
                'desc' => 'Um bolo elegante com tema de aliancas.',
                'categoria' => 'casamento',
                'preco_base' => 25.00,
            ],
            'bolo-bodas-diamante' => [
                'nome' => 'Bolo Bodas Diamante',
                'img' => 'img-pap/nossos-bolos/casamento/bolo-bodas-diamante-cas.jpg',
                'desc' => 'Bolo especial para bodas de diamante.',
                'categoria' => 'casamento',
                'preco_base' => 25.00,
            ],
            'bolo-flores' => [
                'nome' => 'Bolo Flores',
                'img' => 'img-pap/nossos-bolos/casamento/bolo-flores-cas.jpg',
                'desc' => 'Bolo decorado com flores delicadas.',
                'categoria' => 'casamento',
                'preco_base' => 25.00,
            ],
            'bolo-flores-comestiveis' => [
                'nome' => 'Bolo Flores Comestiveis',
                'img' => 'img-pap/nossos-bolos/casamento/bolo-flores-comestiveis-cas.jpg',
                'desc' => 'Bolo com flores comestiveis.',
                'categoria' => 'casamento',
                'preco_base' => 25.00,
            ],
        ];
    }
}

if (!function_exists('dd_opcoes_encomenda')) {
    function dd_opcoes_encomenda()
    {
        return [
            'tamanho' => [
                'pequeno' => [
                    'label' => 'Pequeno (10-12 pessoas)',
                    'preco' => 25.00,
                ],
                'medio' => [
                    'label' => 'Medio (13-16 pessoas)',
                    'preco' => 35.00,
                ],
                'grande' => [
                    'label' => 'Grande (17-20 pessoas)',
                    'preco' => 50.00,
                ],
                'muito_grande' => [
                    'label' => 'Muito Grande (20+ pessoas)',
                    'preco' => 70.00,
                ],
            ],
            'massa' => [
                'baunilha' => [
                    'label' => 'Baunilha',
                    'preco' => 0.00,
                ],
                'laranja_canela' => [
                    'label' => 'Laranja e Canela',
                    'preco' => 0.00,
                ],
                'papoila_limao' => [
                    'label' => 'Papoila e Limao',
                    'preco' => 0.00,
                ],
                'chocolate' => [
                    'label' => 'Chocolate Negro',
                    'preco' => 10.00,
                ],
                'red_velvet' => [
                    'label' => 'Red Velvet',
                    'preco' => 12.00,
                ],
                'cenoura' => [
                    'label' => 'Laranja e Amendoa',
                    'preco' => 8.00,
                ],
            ],
            'recheio' => [
                'caramelo' => [
                    'label' => 'Caramelo Salgado',
                    'preco' => 0.00,
                ],
                'morango' => [
                    'label' => 'Curd de Morango',
                    'preco' => 0.00,
                ],
                'limao' => [
                    'label' => 'Curd de Limao',
                    'preco' => 0.00,
                ],
                'creamcheese' => [
                    'label' => 'Cream Cheese Laranja',
                    'preco' => 0.00,
                ],
                'brigadeiro' => [
                    'label' => 'Brigadeiro Negro',
                    'preco' => 8.00,
                ],
                'mascarpone' => [
                    'label' => 'Mascarpone',
                    'preco' => 10.00,
                ],
                'framboesa' => [
                    'label' => 'Ganache Framboesa',
                    'preco' => 12.00,
                ],
                'maracuja' => [
                    'label' => 'Ganache Maracuja',
                    'preco' => 12.00,
                ],
            ],
        ];
    }
}

if (!function_exists('dd_carrinho_get')) {
    function dd_carrinho_get()
    {
        dd_start_session();

        if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $normalized = [];
        foreach ($_SESSION['carrinho'] as $item) {
            if (!is_array($item)) {
                continue;
            }

            $normalized[] = dd_carrinho_normalizar_item($item);
        }

        $_SESSION['carrinho'] = $normalized;

        return $_SESSION['carrinho'];
    }
}

if (!function_exists('dd_carrinho_set')) {
    function dd_carrinho_set($items)
    {
        dd_start_session();
        $_SESSION['carrinho'] = array_values($items);
    }
}

if (!function_exists('dd_csrf_token')) {
    function dd_csrf_token()
    {
        dd_start_session();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('dd_verify_csrf')) {
    function dd_verify_csrf($token)
    {
        dd_start_session();
        return is_string($token)
            && isset($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('dd_flash_set')) {
    function dd_flash_set($type, $message)
    {
        dd_start_session();
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}

if (!function_exists('dd_flash_get')) {
    function dd_flash_get()
    {
        dd_start_session();

        if (empty($_SESSION['flash_message']) || !is_array($_SESSION['flash_message'])) {
            return null;
        }

        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);

        return $message;
    }
}

if (!function_exists('dd_limpar_texto')) {
    function dd_limpar_texto($value, $maxLength)
    {
        $value = is_string($value) ? trim($value) : '';
        $value = strip_tags($value);
        $value = preg_replace('/\s+/u', ' ', $value);

        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, $maxLength);
        }

        return substr($value, 0, $maxLength);
    }
}

if (!function_exists('dd_data_evento_valida')) {
    function dd_data_evento_valida($date)
    {
        $date = is_string($date) ? trim($date) : '';
        $eventDate = DateTime::createFromFormat('Y-m-d', $date);

        if (!$eventDate || $eventDate->format('Y-m-d') !== $date) {
            return false;
        }

        $today = new DateTime('today');
        $minimumDate = (clone $today)->modify('+7 days');

        return $eventDate >= $minimumDate;
    }
}

if (!function_exists('dd_preco_encomenda')) {
    function dd_preco_encomenda($tamanho, $massa, $recheio)
    {
        $opcoes = dd_opcoes_encomenda();

        if (
            !isset($opcoes['tamanho'][$tamanho]) ||
            !isset($opcoes['massa'][$massa]) ||
            !isset($opcoes['recheio'][$recheio])
        ) {
            return null;
        }

        $total = $opcoes['tamanho'][$tamanho]['preco']
            + $opcoes['massa'][$massa]['preco']
            + $opcoes['recheio'][$recheio]['preco'];

        return round($total, 2);
    }
}

if (!function_exists('dd_formata_preco')) {
    function dd_formata_preco($value)
    {
        return number_format((float) $value, 2, ',', '.');
    }
}

if (!function_exists('dd_formata_data')) {
    function dd_formata_data($date)
    {
        $eventDate = DateTime::createFromFormat('Y-m-d', (string) $date);

        if (!$eventDate) {
            return '';
        }

        return $eventDate->format('d/m/Y');
    }
}

if (!function_exists('dd_carrinho_adicionar')) {
    function dd_carrinho_adicionar($item)
    {
        $cart = dd_carrinho_get();
        $item = dd_carrinho_normalizar_item($item);
        $signature = $item['assinatura'];

        foreach ($cart as &$cartItem) {
            if (isset($cartItem['assinatura']) && hash_equals($cartItem['assinatura'], $signature)) {
                $cartItem['quantidade'] += $item['quantidade'];
                $cartItem['subtotal'] = round($cartItem['quantidade'] * $cartItem['preco_unitario'], 2);
                dd_carrinho_set($cart);
                return;
            }
        }
        unset($cartItem);

        $cart[] = $item;

        dd_carrinho_set($cart);
    }
}

if (!function_exists('dd_carrinho_remover')) {
    function dd_carrinho_remover($signature)
    {
        $cart = array_filter(dd_carrinho_get(), function ($item) use ($signature) {
            return !isset($item['assinatura']) || !hash_equals($item['assinatura'], $signature);
        });

        dd_carrinho_set($cart);
    }
}

if (!function_exists('dd_carrinho_atualizar_quantidade')) {
    function dd_carrinho_atualizar_quantidade($signature, $quantity)
    {
        $cart = dd_carrinho_get();

        foreach ($cart as $index => $item) {
            if (!isset($item['assinatura']) || !hash_equals($item['assinatura'], $signature)) {
                continue;
            }

            if ($quantity <= 0) {
                unset($cart[$index]);
                dd_carrinho_set($cart);
                return true;
            }

            $cart[$index]['quantidade'] = $quantity;
            $cart[$index]['subtotal'] = round($quantity * $item['preco_unitario'], 2);
            dd_carrinho_set($cart);
            return true;
        }

        return false;
    }
}

if (!function_exists('dd_carrinho_totais')) {
    function dd_carrinho_totais($items)
    {
        $subtotal = 0.00;
        $quantidadeTotal = 0;

        foreach ($items as $item) {
            $subtotal += (float) ($item['subtotal'] ?? 0);
            $quantidadeTotal += (int) ($item['quantidade'] ?? 0);
        }

        return [
            'subtotal' => round($subtotal, 2),
            'total' => round($subtotal, 2),
            'quantidade_total' => $quantidadeTotal,
            'linhas' => count($items),
        ];
    }
}

if (!function_exists('dd_carrinho_assinatura')) {
    function dd_carrinho_assinatura($item)
    {
        return hash('sha256', json_encode([
            'bolo_id' => (string) ($item['bolo_id'] ?? ''),
            'tamanho' => (string) ($item['tamanho'] ?? ''),
            'massa' => (string) ($item['massa'] ?? ''),
            'recheio' => (string) ($item['recheio'] ?? ''),
            'data_evento' => (string) ($item['data_evento'] ?? ''),
            'observacoes' => (string) ($item['observacoes'] ?? ''),
        ]));
    }
}

if (!function_exists('dd_carrinho_normalizar_item')) {
    function dd_carrinho_normalizar_item($item)
    {
        $normalized = [
            'bolo_id' => (string) ($item['bolo_id'] ?? ''),
            'nome' => (string) ($item['nome'] ?? 'Produto personalizado'),
            'imagem' => (string) ($item['imagem'] ?? '../img-pap/logotipo-docesdias.jpg'),
            'descricao' => (string) ($item['descricao'] ?? ''),
            'categoria' => (string) ($item['categoria'] ?? ''),
            'tamanho' => (string) ($item['tamanho'] ?? ''),
            'tamanho_label' => (string) ($item['tamanho_label'] ?? ''),
            'massa' => (string) ($item['massa'] ?? ''),
            'massa_label' => (string) ($item['massa_label'] ?? ''),
            'recheio' => (string) ($item['recheio'] ?? ''),
            'recheio_label' => (string) ($item['recheio_label'] ?? ''),
            'data_evento' => (string) ($item['data_evento'] ?? ''),
            'observacoes' => (string) ($item['observacoes'] ?? ''),
            'quantidade' => max(1, (int) ($item['quantidade'] ?? 1)),
            'preco_unitario' => round((float) ($item['preco_unitario'] ?? $item['preco'] ?? 0), 2),
        ];

        $normalized['assinatura'] = (string) ($item['assinatura'] ?? dd_carrinho_assinatura($normalized));
        $normalized['subtotal'] = round(
            (float) ($item['subtotal'] ?? ($normalized['quantidade'] * $normalized['preco_unitario'])),
            2
        );

        return $normalized;
    }
}
