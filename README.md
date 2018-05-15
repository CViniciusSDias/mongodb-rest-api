# mongodb-rest-api
API RESTful de estados e cidades utilizando MongoDB

## Endpoints

  - GET /estados
    - Listar todos os estados.
    - Para filtrar, adicione na queryString:
      - {campo}={valor a filtrar}
      - Ex.: /estados?sigla=SP
    - Para ordenar, adicione na queryString:
      - Passar orderByField={campo} para filtrar pelo {campo} em ordem crescente
      - Passar orderByDirection=DESC para filtrar em ordem decrescente
      - Ex.: /estados?orderByField=sigla&orderByDirection=DESC
  - GET /estados/{id}
    - Buscar um estado específico, pelo ID
  - POST /estados
    - Inserir um estado
  - PATCH /estados/{id}
    - Atualizar um estado pelo ID
    - Não é necessário enviar todos os campos para atualizar
  - DELETE /estados/{id}
    - Remover um estado
  - GET /cidades
    - Listar todos as cidades.
        - Para filtrar, adicione na queryString:
          - {campo}={valor a filtrar}
          - Ex.: /cidades?sigla=SP
        - Para ordenar, adicione na queryString:
          - Passar orderByField={campo} para filtrar pelo {campo} em ordem crescente
          - Passar orderByDirection=DESC para filtrar em ordem decrescente
          - Ex.: /cidades?orderByField=nome&orderByDirection=DESC
  - GET /cidades/{id}
    - Buscar uma cidade específica, pelo ID
  - POST /cidades
    - Inserir uma cidade
  - PATCH /cidades/{id}
    - Atualizar uma cidade pelo ID
    - Não é necessário enviar todos os campos para atualizar
  - DELETE /cidades/{id}
    - Remover uma cidade
