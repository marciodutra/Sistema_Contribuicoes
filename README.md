# Contribution System

Application to manage contributions including taxpayer registration and also a reporting and lottery system among contributors.

## Interface

Home screen with registered taxpayers and settings

![01](https://user-images.githubusercontent.com/74942532/139558201-e437fd1c-2656-4ded-bc53-b3604d640f41.png)

![001](https://user-images.githubusercontent.com/74942532/139558246-b325b465-bff3-4916-a17f-b78cf29259b5.png)

Taxpayer registration screen

![02](https://user-images.githubusercontent.com/74942532/139558254-24cd7afc-0729-4ab7-95d6-9163e02b07de.png)

Screen with contributions

![03](https://user-images.githubusercontent.com/74942532/139558267-eaef2307-87f3-4c3f-afbf-c7d12dea3022.png)

Report screen

![04](https://user-images.githubusercontent.com/74942532/139558270-c8955500-2cb1-42ed-a9de-cccbb4146ea8.png)

Draw screen

![05](https://user-images.githubusercontent.com/74942532/139558276-4690273f-94cf-48ca-91ce-4b28258e728c.png)

Screen with the draws made

![06](https://user-images.githubusercontent.com/74942532/139558286-719ca644-c486-484b-9253-b1e85905246e.png)

## What are the functions?

Complete contribution system with the ability to add contributors, manage contributors and contributions with a complete report and a lottery system among contributors.

## Before running the project

`1` To run the project, we use Wamp (https://www.wampserver.com/en/) as our local server. wamp by default can generate different ports than
configured in the project, so go to the file in the directory `\sistema-de-contribuicao-php\conexao\conexao_bd.php` and configure the variable `$server` with localhost and port
specific file that Wamp generated on your machine.

`2` Import the database located in the `\sistema-de-contribuicao-php\banco_de_dados\sdd.sql` directory into MySql

After the steps, access the Wamp localhost and enjoy.

## About

Application developed using the following technologies: Wamp (Local Server), MySql (Database), PHP, HTML, CSS, JavaScript and Bootstrap.
