### Sobre a Accordous
##### Não perca mais tempo com seus contratos.
Somos uma empresa de tecnologia voltada a simplificação de processos burocráticos! Desde a concepção até a cobrança de contratos, seja ele de imóveis, acordo, prestação de serviços, entre outros.

##### Modelagem #####
Para esse teste foram criadas as seguintes tabelas:
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
Este projeto depende do arquivo `.env` e ' `.env.testing`, que não é versionado. Este arquivo pode ser criado a partir do seguintes modelos que se encontra na pasta `src`:

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


##### Teste Full Stack Laravel
O objetivo deste teste é entendermos um pouco mais sobre seus conhecimentos de Frontend e Backend no Laravel.

##### Requisitos
- PHP 7.1+
- Laravel (Preferência 5.8+)
- Vue.JS
- Docker Engine

##### Orientações
Faça um fork deste projeto.

Para facilitar o seu desenvolvimento, nós disponibilizamos um ``docker-compose.yml`` com o serviços que utilizamos habitualmente no nosso dia a dia.

#### O Desafio
Simular o cadastro de uma propriedade e criar um contrato para o mesmo.

##### Funcionalidade 1:
  - Permitir o cadastro de um imóvel com algumas características. 
  - o cadastro de um imóvel deve possuir:
  - e-mail do proprietário, rua, número, complemento, bairro, cidade, estado;

Para que o cadastro ocorra deverá haver validações em dois níveis. Frontend e backend:
- 1 - e-mail, rua, bairro, cidade e estado são campos obrigatórios;
- 2 - e-mail deverá ser validado;

##### Funcionalidade 2:
  - Contexto: Permitir visualização dos imóveis cadastrados.
    Os dados de imóveis deverão ser carregados via request assíncrona. Esses dados deverão ser exibidos numa tabela e ao menos uma das colunas serem ordenáveis.
    Dados que deverão ser exibidos na tabela:
  - E-mail do proprietário;
  - Rua, número, cidade, estado (separados por vírgula);
  - Status (Contratado / Não contratado)
  - Coluna para ações (remover).

##### Funcionalidade 3:
  - Contexto: permitir a remoção de uma propriedade via chamada assíncrona com atualização posterior da lista de propriedades.
  - Observação: a remoção de uma propriedade deverá ser virtual.

##### Funcionalidade 4:
  - Contexto: Criação de um contrato que permita associação com uma propriedade. Um contrato possui os seguintes campos:
  - Propriedade (deverá ser selecionável a propriedade. Sendo usado como informação da propriedade a rua, número, complemento, bairro);
  - Tipo de pessoa (Pessoa física ou Pessoa Jurídica);
  - Documento (A máscara do campo de documento deverá alterar de acordo com o tipo de pessoa. Pessoa física deverá ser máscara de CPF e pessoa jurídica deverá ser máscara de CNPJ)
  - E-mail do contratante;
  - Nome completo do contratante;

##### Regras específicas sobre a criação de contrato:
- Uma propriedade não pode estar associada a dois contratos;
- Todos os campos do contrato são obrigatórios;
- Deverá ocorrer validação do documento;
- Deverá ocorrer validação do e-mail;


### Extras
- Job: deve-se utilizar alguma forma de job;
- Teste unitário de backend;
- Teste de integração backend;
- SPA.
- Usabilidade (A usabilidade das funcionalidades fica a cargo do desenvolvedor) :D


### Entrega
Deixar um repositório público e nos enviar por e-mail - o mesmo e-mail que foi enviado o teste.
