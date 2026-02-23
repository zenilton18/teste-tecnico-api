
# Propostas API

API REST para gestão de clientes e propostas, desenvolvida em Laravel.
## tecnologias
- PHP 8.2+
- Laravel
- MySQL
- Docker (opcional)

## Requisitos
### Sem Docker:
- PHP 8.2+
- Composer
- MySQL

### Com Docker:
- Docker
- Docker Compose

##  Criar nosso container docker (opcional)

git clone https://github.com/zenilton18/teste-tecnico-api.git

cd teste-tecnico-api

Rode os comandos abaixo
obs:  para facilitar deixei as configurações no .env.example então temos um comando para copiar ele para o .env principal que não foi versionado.

docker compose up -d --build
docker exec -it laravel_app bash
cd /var/www
composer install
cp .env.example .env 
php artisan key:generate
php artisan migrate --seed
exit

Acesse para ver o banco de dados usando o phpmyadin:
http://localhost:8000


## Rodando sem Docker
git clone https://github.com/zenilton18/teste-tecnico-api.git
cd teste-tecnico-api/src

composer install
cp .env.example .env
obs: como o env.example foi criado para a imagem docker será necessario mudar a conexão do banco 
no arquivo .env mude a conexão para de DB_HOST=db para  DB_HOST=127.0.0.1

crie o banco de dados chamado propostas
php artisan key:generate
php artisan migrate --seed
php artisan serve

## detalhes

Banco de dados
O projeto utiliza:

Migrations
Factories
Seed automático


Fluxo de Status da Proposta

DRAFT → SUBMITTED → APPROVED
    ↘ → REJECTED
    ↘ → CANCELED

Status finais (imutáveis):

APPROVED
REJECTED
CANCELED

## Endpoints
Clientes

POST /api/v1/clientes
GET /api/v1/clientes/{id}

Propostas

POST /api/v1/propostas
PATCH /api/v1/propostas/{id}
POST /api/v1/propostas/{id}/submit
POST /api/v1/propostas/{id}/approve
POST /api/v1/propostas/{id}/reject
POST /api/v1/propostas/{id}/cancel
GET /api/v1/propostas
GET /api/v1/propostas/{id}
GET /api/v1/propostas/{id}/auditoria

Exemplos de Request
no seu headers configure tambem os  
Content-Type: application/json
aceppt: application/json


no caminho src\postman\collections\
Você vai encontrar as collections para importação no postman, basta realizar a importação para facilitar os testes
Criar cliente

POST /api/v1/clientes

  {
    "nome": "João da Silva",
    "email": "joao@email.com",
    "documento": "12345678901"
  }

Buscar Cliente
GET /api/v1/clientes/1

Criar proposta
POST /api/v1/propostas

  {
    "cliente_id": 1,
    "produto": "Seguro Vida",
    "valor_mensal": 99.90,
    "origem": "APP"
  }

Atualizar proposta (PATCH)
PATCH /api/v1/propostas/1

  {
    "produto": "Seguro Residencial",
    "valor_mensal": 120.00,
    "versao": 1
  }

para atualizar um proposta 
POST /api/v1/propostas/1/submit
POST /api/v1/propostas/1/approve
POST /api/v1/propostas/1/reject
POST /api/v1/propostas/1/cancel
DELETE /api/v1/propostas/1

  {
    "versao": 1
  }

Para listar propostas  com alguns exemplos de filtros 
GET http://127.0.0.1:8000/api/v1/propostas?cliente_id=1
GET http://127.0.0.1:8000/api/v1/propostas?status=DRAFT
GET http://127.0.0.1:8000/api/v1/propostas?min_valor=50&max_valor=100

buscar adutitoria 
GET /api/v1/propostas/{id}/auditoria

Regras de negócio

Controle de concorrência via campo versao

Fluxo de status controlado

Estados finais são imutáveis

Auditoria automática

Exclusão lógica

Paginação em listagem

Validação padronizada de erros

Observações

Docker é opcional
Projeto executável localmente
Seeds criam dados de exemplo

API versionada em /api/v1

Autor

Zenilton Sousa


