<?php

declare(strict_types=1);

namespace code\Pages\Model;

use libraries\Database;

class Pages
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPosts(): array
    {
        $this->db->query("SELECT * FROM posts");

        return $this->db->resultSet();
    }

// model goes here
}
