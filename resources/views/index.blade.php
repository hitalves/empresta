<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="height=device-height,width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#EF6C00" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#EF6C00" />
    <meta name="msapplication-navbutton-color" content="#EF6C00" />
    <title>Simulador de Empréstimos</title>

    <style>
        #all-loader {
            background: #fff;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: 1;
            backdrop-filter: blur(4px);
        }
        @keyframes spin {
            from {
                transform: translate(-50%, -50%) rotate(0deg)
            }
            to {
                transform: translate(-50%, -50%) rotate(360deg)
            }
        }
        #all-loader::before {
            content: '';
            display: block;
            border-top: 2px solid #EF6C00;
            border-left: 2px solid transparent;
            border-right: 2px solid transparent;
            border-bottom: 2px solid transparent;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            border-radius: 100px;
            animation: spin;
            animation-iteration-count: infinite;
            animation-duration: 1s;
            animation-timing-function: linear;
        }
    </style>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;900&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all" />
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('fav/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('fav/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('fav/site.webmanifest') }}">

</head>
<body>
    <div id="all-loader">
    </div>
    <header role="banner" class="clearfix" id="header">
        <div class="grid t-center">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img alt="Empresta - Bem Melhor" title="Empresta - Bem Melhor" src="{{ asset('img/logo.svg') }}" />
                </a>
            </div>
            <h1>Simulador de Empréstimo</h1>
        </div>
    </header>

<main role="main" class="clearfix" id="main-site">
    <div class="grid">
        <form id="simular">
            <div class="welcome we1">
                <img widht="75" height="75" alt="Avatar" title="Avatar" src="{{ asset('img/avatar.svg') }}" />
                <p class="lo s1">Bem-vindo(a) ao simulador de Empréstimos da Empresta, Bem melhor :)</p>
                <p class="lo hi s2">Qual é o <b>valor do empréstimo</b> que deseja fazer?</p>
            </div>
            <div class="hi s3 field valor_emprestimo">
                <label for="valor_emprestimo">Digite aqui o quantia (R$)</label>
                <input class="money" required type="tel" name="valor_emprestimo" />
                <a></a>
            </div>
            <div class="value_emprestimo us hi"><p></p></div>
            <div class="welcome we2 hi">
                <img widht="75" height="75" alt="Avatar" title="Avatar" src="{{ asset('img/avatar.svg') }}" />
                <p class="lo hi s4">Com quais instituições deseja simular seu empréstimo?</p>
            </div>
            <div class="hi s5 field instituicoes">
                <div class="dest"></div>
                <a></a>
            </div>
            <div class="value_instituicao us hi"><p></p></div>
            <div class="welcome we3 hi">
                <img widht="75" height="75" alt="Avatar" title="Avatar" src="{{ asset('img/avatar.svg') }}" />
                <p class="lo hi s6">Ótima escolha! E quais são os convênios da simulação?</p>
            </div>
            <div class="hi s7 field convenios">
                <div class="dest"></div>
                <a></a>
            </div>
            <div class="value_convenio us hi"><p></p></div>
            <div class="welcome we4 hi">
                <img widht="75" height="75" alt="Avatar" title="Avatar" src="{{ asset('img/avatar.svg') }}" />
                <p class="lo hi s8">Agora é a última pergunta. Em quantas parcelas deseja financiar?</p>
            </div>
            <div class="hi s9 field parcela">
                <label for="parcela">Escolha a quantidade de vezes</label>
                <select name="parcela">
                    <option selected hidden>Clique e selecione</option>
                    <option value="36">36</option>
                    <option value="48">48</option>
                    <option value="60">60</option>
                    <option value="72">72</option>
                    <option value="84">84</option>
                </select>
                <a></a>
            </div>
            <div class="value_parcela us hi"><p></p></div>
            <div class="hi s10 field">
                <button>Simular</button>
            </div>               
        </form>
        <div id="resultado" class="hide">
            <h2>Resultados da sua simulação</h2>
            <p>Veja agora as opções disponíveis de acordo com a sua simulação.</p>
            <div id="resultados">
                <h3 class="noload">Sua simulação não retornou resultados :(</h3>
                <div>
                    
                </div>

            </div>
            <br />
            <p>Quer saber mais ou fechar negócio? Entre em contato com uma de nossas lojas</p>
            <a class="btn" href="https://empresta.com.br/lojas/" target="_blank" title="Ver unidades da Empresta">Ver Lojas</a>
        </div>
    </div>
</main>

<footer class="clearfix" id="footer">
     
</footer>
<script>
    var apiURL = "{{url('/api/')}}"
</script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
