# Curso [PHP e TDD][PHP e TDD]
Curso realizado na plataforma [Alura][Alura].

Tópicos abordados:

1. Por que testar?
2. Conhecendo o PHPUnit
3. Classes de equivalência
4. Organizando os testes
5. Test Driven Development
6. Testando exceções

[Certificado][Certificado]

## Para rodar o projeto

### Pré-Requisitos
- Docker

#### Inicializar o projeto

```
docker run --rm --interactive --tty -v ${PWD}:/app --workdir=/app composer install
```

#### Rodar o projeto
```
docker run --rm --interactive --tty -v ${PWD}:/app --workdir=/app php:7.2-cli vendor/bin/phpunit --colors tests
```

[Certificado]: 

[PHP e TDD]: https://cursos.alura.com.br/course/phpunit-tdd

[Alura]: https://www.alura.com.br/