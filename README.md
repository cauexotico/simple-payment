
# Desafio: Sistema de Pagamento Simplificado

Neste desafio, você será responsável por desenvolver um sistema de pagamento simplificado em PHP. O sistema permitirá que usuários comuns e lojistas realizem transferências de dinheiro entre si.

## Requisitos

Aqui estão os requisitos principais para o funcionamento do sistema:

- Cadastro de usuários: Ambos os tipos de usuários (comuns e lojistas) devem fornecer nome completo, CPF/CNPJ, e-mail e senha. CPF/CNPJ e e-mails devem ser únicos no sistema, permitindo apenas um cadastro por CPF ou endereço de e-mail.
- Transferências de dinheiro: Usuários comuns podem enviar dinheiro para lojistas e entre si. Lojistas só recebem transferências e não enviam dinheiro para ninguém.
- Validação de saldo: Antes de efetuar uma transferência, o sistema deve validar se o usuário possui saldo suficiente em sua carteira.
- Consulta a serviço externo autorizador: Antes de finalizar uma transferência, o sistema deve consultar um serviço externo autorizador. Utilize este [mock](https://run.mocky.io/v3/4a9ebf69-e2df-448d-b7d5-7bd5a3fa3f62) para simular a autorização.
- Transações reversíveis: Toda transferência deve ser tratada como uma transação, revertendo em caso de inconsistência e devolvendo o dinheiro para a carteira do usuário remetente.
- Notificação de pagamento: Após o recebimento de um pagamento, tanto o usuário quanto o lojista devem receber uma notificação por e-mail ou SMS. Utilize este [mock](https://run.mocky.io/v3/1875b264-8fdb-4707-aa52-5ac1d120ac07) para simular o envio de notificações.

## Variáveis de Ambiente

Você pode customizar alguns comportamentos utilizando variáveis de ambiente.

`IGNORE_EXTERNAL_SERVICES` utilizada para ignorar os mocks externos em caso de erros.

`PAYMENT_GATEWAY` (mock01) utiliado para trocar o gateway que irá aprovar as transações

`NOTIFICATION_GATEWAY` (mock02) utiliado para trocar o gateway que irá notificar os usuários


## Instalação

Clone o repositório e então para subir os containers:

```
docker-compose up -d
```

Então rode os próximos comandos de dentro do container do PHP-FPM

```
docker-compose exec php-fpm sh
```

Você deve copiar o .env.example usando o comando:
```
cp .env.example .env
```

Instalar as dependências do composer
```
composer install
```

E então gere a `APP_KEY` usando o comando:
```
php artisan key:generate
```

Na sequência, rode as migrations usando:

```
php artisan migrate
```

Você pode verificar os testes da aplicação usando:

```
php artisan test
```

## Documentação da API

A URL padrão configurada para o projeto é http://localhost:8000, então você pode realizar chamadas de api utilizando as seguintes rotas:

#### Cria um usuário

```http
  POST /api/user
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Obrigatório**. Seu nome |
| `email` | `string` | **Obrigatório**. Seu email |
| `document` | `string` | **Obrigatório**. CNPJ caso seller, CPF caso customer  |
| `type` | `string` | **Obrigatório**. `seller` ou `customer` |
| `password` | `string` | **Obrigatório**. Sua senha |

#### Faz uma transferência

```http
  POST /api/transactions
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `payer_id`      | `string` | **Obrigatório**. O ID do pagador |
| `payee_id`      | `string` | **Obrigatório**. O ID do recebedor |
| `amount`      | `string` | **Obrigatório**. O valor a ser enviado |


Também é possível encontrar um arquivo com a Collection  das rotas desse projeto no repositório do GitHub, assim conseguindo realizar requisições por meio do Postman.