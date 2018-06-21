# Dev Test - Versão Slim Micro framework

Esta versão do teste foi programada usando o [Slim Micro framework](https://www.slimframework.com).

## Execução

Para execução deste projeto, execute o comando abaixo.

    docker-compose up

Ao final do processo de instalação, o projeto estará disponível em `http://localhost:3000`.

#### Endereços

* Formulário: [http://localhost:3000/form](http://localhost:3000/form)
* Documentação da API: [http://localhost:3000/docs](http://localhost:3000/docs)
* Base da API: [http://localhost:3000/api/v1](http://localhost:3000/api/v1)


## Informações

O projeto foi desenvolvido usando abordagem de programação agnóstica a frameworks e conceitos de [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design).

A camada de negócio está na pasta `src/Application`, sendo totalmente portável
para qualquer outro framework ou sistema que utilize PHP 7.1 ou superior.

A camada de infraestrutura está na pasta `src/App`, sendo ela responsável por tratar a requisição,
interação com a camada de negócio e retorno da requisição.

Para acesso a banco de dados, foi utilizado o componente [PDO](https://secure.php.net/manual/en/book.pdo.php), do core do PHP.

Todo código fonte de `src/Application` e `src/App` estão em conformidade com as [PSR-1](https://www.php-fig.org/psr/psr-1/) e [PSR-2](https://www.php-fig.org/psr/psr-2/)
e estão documentados no padrão [PHPDoc](https://en.wikipedia.org/wiki/PHPDoc).

Todo código fonte de `src/Application` foram codificados considerando type hint e return type.

Durante o desenvolvimento, foi necessário correção de uma biblioteca de terceiros,
conforme pode ser conferido em [https://github.com/adrianfalleiro/slim-cli-runner/pull/8](https://github.com/adrianfalleiro/slim-cli-runner/pull/8),
porém, como a correção não foi aplicada a tempo da entrega do teste, existe um patch no composer
para aplicar as devidas correções e manter o app funcionando.

## Todo

A validação de um CPF válido está na model `CpfBlacklist` e `CpfBlacklistEvent`, porém,
seria interessante desacoplar, criar um [Value Object](https://en.wikipedia.org/wiki/Value_object) `Cpf` e atribuir a ele a responsabilidade
por validar a string de CPF, tornando `CpfBlacklist`, `CpfBlacklistEvent` e outras implementações usuários de `Cpf` 

Implementação de configuração externa por meio de `yaml`, tornando mais fácil
edição de parâmetros do sistema.