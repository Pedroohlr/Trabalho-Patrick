<?php

namespace dao\mysql;

use generic\MysqlFactory;

class MemeDAO extends MysqlFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM memes ORDER BY criado_em DESC";
        $memes = $this->banco->executar($sql);

        foreach ($memes as &$m) {
            $idMeme = (int) $m['id'];

            $sqlTags =
                "SELECT t.id AS tag_id, t.nome 
         FROM tags t
         JOIN meme_tag mt ON t.id = mt.tag_id
         WHERE mt.meme_id = :meme_id";
            $tags = $this->banco->executar($sqlTags, [':meme_id' => $idMeme]);
            $m['tags'] = $tags;

            $sqlVotos =
                "SELECT 
            SUM(CASE WHEN tipo = 'like' THEN 1 ELSE 0 END) AS likes,
            SUM(CASE WHEN tipo = 'dislike' THEN 1 ELSE 0 END) AS dislikes
         FROM votos
         WHERE meme_id = :meme_id";
            $votos = $this->banco->executar($sqlVotos, [':meme_id' => $idMeme]);

            $m['likes'] = (int) ($votos[0]['likes'] ?? 0);
            $m['dislikes'] = (int) ($votos[0]['dislikes'] ?? 0);
        }
        return $memes;
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT id, titulo, imagem_url, legenda, autor, criado_em FROM memes WHERE id = :id";
        $resultado = $this->banco->executar($sql, [':id' => $id]);

        if (count($resultado) === 0) {
            return null;
        }

        $meme = $resultado[0];
        $sqlTags =
            "SELECT t.id AS tag_id, t.nome 
             FROM tags t
             JOIN meme_tag mt ON t.id = mt.tag_id
             WHERE mt.meme_id = :meme_id";
        $tags = $this->banco->executar($sqlTags, [':meme_id' => $id]);
        $meme['tags'] = $tags;

        $sqlVotos =
            "SELECT 
            SUM(CASE WHEN tipo = 'like' THEN 1 ELSE 0 END) AS likes,
            SUM(CASE WHEN tipo = 'dislike' THEN 1 ELSE 0 END) AS dislikes
         FROM votos
         WHERE meme_id = :meme_id";
        $votos = $this->banco->executar($sqlVotos, [':meme_id' => $id]);

        $meme['likes'] = (int) ($votos[0]['likes'] ?? 0);
        $meme['dislikes'] = (int) ($votos[0]['dislikes'] ?? 0);

        return $meme;
    }

    public function buscarPorTagName(string $tagName): ?array
    {
        $sql = "
        SELECT m.id, m.titulo, m.imagem_url, m.legenda, m.autor, m.criado_em
        FROM memes m
        JOIN meme_tag mt ON m.id = mt.meme_id
        JOIN tags t ON t.id = mt.tag_id
        WHERE t.nome = :tagName
        ORDER BY m.criado_em ASC
    ";
        $memes = $this->banco->executar($sql, [':tagName' => $tagName]);

        if (count($memes) === 0) {
            return null;
        }

        foreach ($memes as &$meme) {
            $idMeme = (int) $meme['id'];

            $sqlTags = "
            SELECT t.id AS tag_id, t.nome
            FROM tags t
            JOIN meme_tag mt ON t.id = mt.tag_id
            WHERE mt.meme_id = :meme_id
        ";
            $tags = $this->banco->executar($sqlTags, [':meme_id' => $idMeme]);
            $meme['tags'] = $tags;

            $sqlLikes = "SELECT COUNT(*) AS total FROM votos WHERE meme_id = :meme_id AND tipo = 'like'";
            $likes = $this->banco->executar($sqlLikes, [':meme_id' => $idMeme])[0]['total'];
            $meme['likes'] = (int) $likes;

            $sqlDislikes = "SELECT COUNT(*) AS total FROM votos WHERE meme_id = :meme_id AND tipo = 'dislike'";
            $dislikes = $this->banco->executar($sqlDislikes, [':meme_id' => $idMeme])[0]['total'];
            $meme['dislikes'] = (int) $dislikes;
        }

        return $memes;
    }

    public function inserir(string $titulo, string $imagem_url, string $legenda, string $autor): int
    {
        $sql = "INSERT INTO memes (titulo, imagem_url, legenda, autor) 
                VALUES (:titulo, :imagem_url, :legenda, :autor)";
        $novoId = $this->banco->executar($sql, [
            ':titulo' => $titulo,
            ':imagem_url' => $imagem_url,
            ':legenda' => $legenda,
            ':autor' => $autor
        ]);
        return $novoId;
    }

    public function atualizar(int $id, ?string $titulo, ?string $imagem_url, ?string $legenda, ?string $autor): bool
    {
        $sets = [];
        $params = [':id' => $id];

        if ($titulo !== null) {
            $sets[] = "titulo = :titulo";
            $params[':titulo'] = $titulo;
        }
        if ($imagem_url !== null) {
            $sets[] = "imagem_url = :imagem_url";
            $params[':imagem_url'] = $imagem_url;
        }
        if ($legenda !== null) {
            $sets[] = "legenda = :legenda";
            $params[':legenda'] = $legenda;
        }
        if ($autor !== null) {
            $sets[] = "autor = :autor";
            $params[':autor'] = $autor;
        }

        if (empty($sets)) {
            return false;
        }

        $sql = "UPDATE memes SET " . implode(", ", $sets) . " WHERE id = :id";
        $rowCount = $this->banco->executar($sql, $params);

        return ($rowCount > 0);
    }

    public function deletar(int $id): bool
    {
        $sql = "DELETE FROM memes WHERE id = :id";
        $rowCount = $this->banco->executar($sql, [':id' => $id]);
        return ($rowCount > 0);
    }

    public function recriarTags(int $meme_id, array $novasTagIds): void
    {
        $sqlDelete = "DELETE FROM meme_tag WHERE meme_id = :meme_id";
        $this->banco->executar($sqlDelete, [':meme_id' => $meme_id]);

        $sqlInsert = "INSERT INTO meme_tag (meme_id, tag_id) VALUES (:meme_id, :tag_id)";
        foreach ($novasTagIds as $tag_id) {
            $this->banco->executar($sqlInsert, [
                ':meme_id' => $meme_id,
                ':tag_id' => $tag_id
            ]);
        }
    }
}
