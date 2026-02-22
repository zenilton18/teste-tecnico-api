
# Propostas API

API REST para gestão de clientes e propostas, desenvolvida em Laravel.

##  Tecnologias
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

##  Rodando com Docker (opcional)

bash
git clone https://github.com/zenilton18/teste-tecnico-api.git
cd projeto

docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed

Acesse:
http://localhost:8000

 Rodando sem Docker
git clone https://github.com/zenilton18/teste-tecnico-api.git
cd projeto
composer install
cp .env.example .env
php artisan key:generate

Configure o banco no .env:

DB_DATABASE=propostas
DB_USERNAME=root
DB_PASSWORD=

Depois:

php artisan migrate --seed
php artisan serve

Banco de dados
O projeto utiliza:

Migrations
Factories
Seed automático

Para recriar tudo:

php artisan migrate:fresh --seed

Fluxo de Status da Proposta

DRAFT → SUBMITTED → APPROVED
    ↘ → REJECTED
    ↘ → CANCELED

Status finais (imutáveis):

APPROVED
REJECTED
CANCELED

Endpoints
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
Criar cliente
POST /api/v1/clientes
Content-Type: application/json

{
  "nome": "João da Silva",
  "email": "joao@email.com",
  "documento": "12345678901"
}

Criar proposta
POST /api/v1/propostas
Content-Type: application/json

{
  "cliente_id": 1,
  "produto": "Seguro Vida",
  "valor_mensal": 99.90,
  "origem": "APP"
}

Atualizar proposta (PATCH)
PATCH /api/v1/propostas/1
Content-Type: application/json

{
  "produto": "Seguro Residencial",
  "valor_mensal": 120.00,
  "versao": 1
}
Submeter proposta
POST /api/v1/propostas/1/submit
Content-Type: application/json

{
  "versao": 2
}

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


