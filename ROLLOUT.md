# ROLLOUT

## Pré-Requisitos
- Docker

### Para inicializar o projeto execute o composer a partir da raiz

```
docker run --rm --interactive --tty -v "$PWD":/app --workdir=/app composer install
```

### Para executar o projeto utilizando Docker, execute a partir da raiz
```
docker run --rm --interactive --tty -v "$PWD":/app --workdir=/app php:7.2-cli php teste-avaliador.php
```
