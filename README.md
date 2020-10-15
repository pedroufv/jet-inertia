##### Modelagem #####
Para criadas as seguintes tabelas:
- owners:
    * id: big integer 
    * name: string(255)
    * email: string(255)
    * type: enum('private', 'legal')
    * identifier: string(14)
    * created_at: datetime
    * updated_at: datetime
     
- estates:
    * id: uuid
    * owner_id: big integer nullable
    * state: string(255)
    * city: string(255)
    * neighborhood: string (255)
    * street: string(255)
    * number: integer unsigned nullable
    * details: text nullable
    * created_at: datetime
    * updated_at: datetime


## Tecnologias e ferramentas
Este projeto funciona e foi construído sobre as seguintes tecnologias:

* Linguagem: PHP 7.4
* Servidor http: Nginx
* Banco de dados: MySQL
* Framework: Laravel

## Arquivos de configuração
Este projeto depende do arquivo `.env` e `.env.testing`, que não é versionado. Este arquivo pode ser criado a partir do seguintes modelos que se encontra na pasta `src`:

* `.env.example`
* `.env.testing.example`

## Configuração de ambiente de desenvolvimento
1. Docker
```shell script
## updating the package index
sudo apt update

## install the Docker package
sudo apt install docker.io

## verify the installation
docker --version

## start Dcoker
sudo systemctl start docker

## automate docker (optional)
sudo systemctl enable docker
```
2. Docker Compose
```shell script
## download the current stable release of Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/download/1.26.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

## apply executable permissions to the binary
sudo chmod +x /usr/local/bin/docker-compose
```

## Docker
> Configure USER_UID, WEB_PORT, HOST_DB_PORT e HOST_PMA_PORT no arquivo .env na raiz do projeto.   
- Alterar configurações em `.env`
- Use o serviço como host do banco `db` se estiver usando o serviço de banco local
- Montar as imagens `docker-compose build`
- Levantar os serviços `docker-compose up -d`
- Instalar dependencias PHP `docker-compose exec app composer install`
- Instalar dependencias JS `docker-compose exec app /bin/sh -c "npm install && npm run dev"`
- Aplicar migrations `docker-compose exec app php artisan migrate`
- Verificar logs `docker-compose logs -t`

### Docker dicas
- Contruir e levantar os serviços `docker-compose up -d --buld`
- Subir apenas o app, nginx e banco `docker-compose up -d app`
- Acessar o bash `docker-compose exec app /bin/sh`
- Verificar logs de um serviço `docker-compose logs -t app`
- Verificar logs de um serviço em execução `docker-compose logs -tf app`

### Makefile
* `make build` constrói as imagens no docker-compose
* `make clean` limpa cache e arquivos compilados
* `make composer` instala dependencias php
* `make down` desliga os containers com remoção de órfãos 
* `make dump` atualiza composer autoload no container da aplicação
* `make logs` exibe 100 ultimos registros de log da aplicacao
* `make migrate` executa migrations 
* `make npm` instala dependencias js 
* `make shell` acessa o terminal do container da aplicação
* `make seed` popula banco de dados
* `make test` executa tests
* `make up` inicializa os containers
