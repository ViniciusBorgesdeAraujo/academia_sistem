# Sistema de Academia FitPromanage

O FitPromanage é um sistema de gestão de academia desenvolvido para ajudar proprietários e administradores de academias a gerenciar suas operações de forma eficiente. Este sistema foi desenvolvido utilizando o PHPMaker 2020 e PHP 7.4, com suporte ao MySQL 8.0 e está pronto para uso com o XAMPP 7.4.

## Sobre o Projeto

Este sistema foi criado como parte de um teste de conhecimento para a vaga de Desenvolvedor PHP Júnior na empresa [ACS Consultoria e Serviços](http://www.acslab.com.br/). 

## Requisitos

Para executar este projeto em sua máquina, você precisará ter as seguintes ferramentas instaladas:

- Composer,
- PHP v8.1,
- MySQL v8.0,
- Node.js v14.17.6,
-PHPMaker 2020,

## Instruções para Instalação e Execução

Siga as etapas abaixo para configurar e executar o sistema em sua máquina:

1. Clone o repositório: `https://github.com/ViniciusBorgesdeAraujo/sistema_academia`
2. Acesse a pasta do projeto: `cd sistema_academia`
3. Instale as dependências do projeto: `composer install` e `npm install`
4. Copie o arquivo `.env.example` para `.env`
5. Gere a chave da aplicação: `php artisan key:generate`
6. Crie um link simbólico para a pasta storage: `php artisan storage:link`
7. Crie um banco de dados no MySQL e configure o arquivo `.env` com as informações de conexão.
8. Execute as migrações do banco de dados: `php artisan migrate`
9. Execute o projeto: `php artisan serve` e `npm run dev`

![image](https://github.com/ViniciusBorgesdeAraujo/sistema_academia/assets/105869015/0ccb0e65-eb76-41d6-8333-56bd3f93e626)


## PHPMaker 2020

Este projeto foi desenvolvido utilizando o PHPMaker 2020 como uma ferramenta poderosa para gerar código PHP rapidamente. O PHPMaker é conhecido por sua capacidade de acelerar o desenvolvimento de aplicativos web e simplificar tarefas comuns, como a criação de formulários, relatórios e autenticação.

### Recursos do PHPMaker 2020

- **Geração de Código Automatizada:** O PHPMaker 2020 permite gerar automaticamente código PHP, HTML, JavaScript e SQL para criar rapidamente aplicativos web funcionais.

- **Suporte a Múltiplos Bancos de Dados:** Você pode usar o PHPMaker com uma variedade de sistemas de gerenciamento de banco de dados, incluindo MySQL, PostgreSQL, SQL Server e outros.

- **Controle de Acesso Avançado:** O PHPMaker oferece recursos de autenticação e autorização flexíveis para proteger suas páginas e dados.

- **Integração de Front-end e Back-end:** Você pode personalizar facilmente a aparência do seu aplicativo web e conectá-lo a um banco de dados com facilidade.

- **Recursos de Exportação:** Os aplicativos gerados pelo PHPMaker podem exportar dados para formatos como Excel, CSV, PDF e outros.

### Como Usar o PHPMaker 2020

Se você deseja aprender mais sobre como usar o PHPMaker 2020 para acelerar o desenvolvimento do seu projeto, consulte a [documentação oficial do PHPMaker 2020](https://www.hkvstore.com/phpmaker) para obter tutoriais e guias detalhados.

Lembre-se de que o PHPMaker é uma ferramenta poderosa que pode economizar tempo e esforço no desenvolvimento de aplicativos web. Aproveite ao máximo seus recursos para criar aplicativos web de alta qualidade de forma eficiente.

## Contribuições

Este projeto é de código aberto e as contribuições são bem-vindas. Sinta-se à vontade para enviar pull requests, relatar problemas ou sugerir melhorias.

## Licença

Este sistema é distribuído sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter detalhes.

## Contato

Para mais informações ou suporte, entre em contato conosco em vinnepaul@gmil.com.
