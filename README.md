## Blog Laravel

Aplicação web de blog desenvolvida com Laravel, focada na construção de uma API e estrutura backend seguindo o padrão MVC.  
O projeto demonstra autenticação, gerenciamento de usuários e manipulação de dados utilizando boas práticas do ecossistema Laravel.

#### Demonstração do Projeto

Este projeto implementa funcionalidades típicas de um sistema de blog:
- Cadastro e autenticação de usuários
- CRUD de usuários
- Controle de acesso baseado em autenticação
- API para consumo de dados
- Estrutura organizada seguindo padrão MVC

#### Tecnologias Utilizadas

- PHP
- Laravel
- MySQL / PostgreSQL
- Eloquent ORM
- REST API
- Composer
- Insomnia / Postman para testes de API

#### Arquitetura

O projeto segue a arquitetura padrão do Laravel:
```
app/
 ├── Http/
 │   ├── Controllers
 │   └── Middleware
 ├── Models
routes/
 ├── web.php
 └── api.php
database/
 ├── migrations
 └── seeders
```

Principais conceitos utilizados:
- **Controllers** para organização da lógica de aplicação
- **Models + Eloquent ORM** para manipulação do banco
- **Migrations** para versionamento do banco de dados
- **Middleware** para controle de acesso

#### Funcionalidades

**Autenticação**  
- Login de usuário
- Proteção de rotas autenticadas
- Gerenciamento de sessão

**Usuários**
- Criar usuário
- Atualizar dados
- Listar usuários
- Remover usuário

**API**  
- Endpoints REST
- Retorno de dados em JSON
- Testável via Insomnia/Postman

#### Instalação

Clone o repositório:  
`git clone https://github.com/andressa-mb/blog-laravel.git`  
Entre na pasta:  
`cd blog-laravel`  
Instale as dependências:  
`composer install`  
Copie o arquivo de ambiente:  
`cp .env.example .env`  
Gere a chave da aplicação:  
`php artisan key:generate`  
Configure o banco de dados no .env e execute:  
`php artisan migrate`  
Inicie o servidor:  
`php artisan serve`  
