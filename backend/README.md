# Plataforma de Gestão de Usuários: Laravel & Vue 3

## Descrição Geral
Este projeto é um sistema de gerenciamento de usuários construído com Laravel 11 para o backend e Vue 3 para o frontend.

## Ferramentas Utilizadas
- PHP: Linguagem de programação utilizada no Laravel.
- Laravel 11: Framework PHP para desenvolvimento web.
- PostgreSQL: Banco de dados relacional.
- Docker: Ferramenta para criar, gerenciar e executar contêineres.
- Mailtrap: Serviço de envio de e-mail.


## Containers
- PHP: Serviço de desenvolvimento PHP com Apache e PHP-FPM.
- PostgreSQL: Serviço de banco de dados relacional.
- Queue: Serviço de tratamento de tarefas em segundo plano.
- Redis: Serviço de cache em memória.
- Minio: Serviço de armazenamento de arquivos.

## Instalação
1. Pré-requisitos:
    - Docker
    - Docker Compose
2. Clone o repositório:
```bash
    git clone https://github.com/RayconLima/user-crudify.git
```

3. Entre na pasta do projeto:
```bash
    cd user-crudify/backend
```

4. Execute o comando para criar os containers:
```bash
    ./vendor/bin/sail up -d
```

5. Caso haja algum erro com relação a portas, configure outra porta no .env:
```bash
    APP_PORT=8000
```

6. Acesse as rotas de api do projeto em http://localhost:8000

## Configuração do Banco de Dados com PostgreSQL
1. No arquivo `.env`, configure os seguintes parâmetros:
```bash
    DB_CONNECTION=pgsql
    DB_HOST=pgsql
    DB_PORT=5432
    DB_DATABASE=nome_do_banco
    DB_USERNAME=usuario
    DB_PASSWORD=senha
```
2. Execute as migrações para criar as tabelas:
```bash
    ./vendor/bin/sail artisan migrate
```

## Configuração de Envio de Email com Mailtrap
1. No arquivo `.env`, configure as credenciais de Mailtrap:
```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=seu_usuario
    MAIL_PASSWORD=sua_senha
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=seu_email@example.com
    MAIL_FROM_NAME="Nome do Projeto"
```
2. Teste o envio de email executando o comando:
```bash
    ./vendor/bin/sail artisan tinker
```
   Em seguida, envie um email de teste:
```php
    Mail::raw('Teste de envio de email', function ($message) {
        $message->to('destinatario@example.com')
                ->subject('Email de Teste');
    });
```

## Minio
O projeto utiliza o serviço de armazenamento de arquivos Minio para armazenar arquivos de imagens. 

1. Para acessar o serviço, use a seguinte URL: http://localhost:9000
2. Para acessar o console do serviço, use a seguinte URL: http://localhost:8900
3. Para acessar o dashboard do serviço, use a seguinte URL: http://localhost:9000/minio/login
4. Acesse o dashboard com as credenciais configuradas no arquivo .env:
```bash
    AWS_ACCESS_KEY_ID=sail
    AWS_SECRET_ACCESS_KEY=password
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=custom-bucket
    AWS_ENDPOINT=http://minio:9000
    AWS_URL=http://localhost:9000/custom-bucket
    AWS_USE_PATH_STYLE_ENDPOINT=true
```
5. Precisamos criar um bucket para armazenar os arquivos. Para isso, no menu lateral esquerdo, clique em "Buckets" e clique em "Create Bucket".
6. Acesse o bucket criado e no Summary altere o Access Policy para "Public".
7. Em seguida, configure a região no menu lateral esquerdo clicando em "Configuration", clique em Region e preencha o campo "Server Location" para salvar.

## Referências
- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [PostgreSQL](https://www.postgresql.org/)
- [Docker](https://www.docker.com/)                                        
- [Docker Compose](https://docs.docker.com/compose/)

