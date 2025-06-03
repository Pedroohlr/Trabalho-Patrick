# 📡 API REST - Curadoria de Memes

Esta é uma API RESTful desenvolvida em PHP seguindo o padrão MVC. Ela permite gerenciar memes, tags e votos de forma simples e estruturada. Ideal para ser consumida por aplicações front-end como React, Postman, ou outras ferramentas via HTTP.

---

## 📁 Endpoints da API

### 🖼 MEMES

| Método  | Endpoint                        | Descrição                                                  |
|---------|---------------------------------|------------------------------------------------------------|
| GET     | `/api/memes`                    | Lista todos os memes cadastrados.                          |
| POST    | `/api/memes`                    | Cria um novo meme. Espera os dados no corpo da requisição. |
| PUT     | `/api/memes`                    | Atualiza um meme existente. Requer `id` + campos no corpo. |
| DELETE  | `/api/memes`                    | Exclui um meme. Requer `id` no body ou query string.       |
| GET     | `/api/memes/buscar/id`          | Busca um meme pelo `id`. Requer `?id=NUMERO` na query.     |
| GET     | `/api/memes/buscar/tagName`     | Lista memes filtrados por uma `tagName`. Usa `?tagName=NOME` na query.|

---

### 🏷 TAGS

| Método  | Endpoint          | Descrição                                                  |
|---------|-------------------|------------------------------------------------------------|
| GET     | `/api/tags`       | Lista todas as tags cadastradas.                           |
| POST    | `/api/tags`       | Cria uma nova tag. Requer `nome` no body.                  |
| PUT     | `/api/tags`       | Atualiza uma tag. Requer `id` e novo `nome` no body.       |
| DELETE  | `/api/tags`       | Deleta uma tag. Requer `id` e `nome` no body ou query.     |

---

### 👍 VOTOS

| Método  | Endpoint          | Descrição                                                              |
|---------|-------------------|------------------------------------------------------------------------|
| GET     | `/api/votos`      | Lista todos os votos registrados. Pode usar `?meme_id=ID` como filtro. |
| POST    | `/api/votos`      | Cria um novo voto. Requer `meme_id` e `tipo` ("like" ou "dislike") no corpo.|

---

## 📦 Exemplos de Formatos de Requisição

### 🔹 MEMES

#### ➕ Criar Meme  
`POST /api/memes`
```json
{
  "titulo": "Meme Apocalíptico",
  "imagem_url": "https://exemplo.com/imagem.jpg",
  "legenda": "Quando o mundo acaba e só resta rir",
  "autor": "ZumbiEngraçado",
  "tags": [1, 2]
}
```

#### 🔄 Atualizar Meme  
`PUT /api/memes`
```json
{
  "id": 7,
  "titulo": "Meme Atualizado",
  "imagem_url": "https://exemplo.com/nova_imagem.jpg",
  "legenda": "Nova legenda apocalíptica",
  "autor": "Autor Atualizado",
  "tags": [2, 4]
}
```

#### ❌ Deletar Meme  
`DELETE /api/memes?id=7`

Ou via JSON:
```json
{
  "id": 7
}
```

#### 🔍 Buscar Meme por ID  
`GET /api/memes/buscar/id?id=7`

#### 🔍 Buscar Meme por Tag Name  
`GET /api/memes/buscar/tagName?tagName=humor`

#### 📋 Listar Memes  
`GET /api/memes`

---

### 🔹 TAGS

#### ➕ Criar Tag  
`POST /api/tags`
```json
{
  "nome": "humor"
}
```

#### 🔄 Atualizar Tag  
`PUT /api/tags`
```json
{
  "id": 3,
  "nome": "ironia"
}
```

#### ❌ Deletar Tag  
`DELETE /api/tags?id=3&nome=humor`

Ou via JSON:
```json
{
  "id": 3,
  "nome": "humor"
}
```

#### 📋 Listar Tags  
`GET /api/tags`

---

### 🔹 VOTOS

#### ➕ Criar Voto  
`POST /api/votos`
```json
{
  "meme_id": 3,
  "tipo": "like"
}
```

#### 📋 Listar Votos  
`GET /api/votos`

Filtrar por meme:
`GET /api/votos?meme_id=3`