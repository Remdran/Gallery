<?php


class Comment extends Db_Object
{

    protected static $dbTable = "comments";
    protected $id;
    protected $photo_id;
    protected $author;
    protected $body;

    public static function create($photo_id, $author, $body)
    {
        if ( ! empty($photo_id) && ! empty($author) && ! empty($body)) {
            $comment = new Comment();

            $comment->photo_id = $photo_id;
            $comment->author = $author;
            $comment->body = $body;

            return $comment;
        } else {
            return false;
        }
    }

    public static function findComment($photo_id)
    {
        global $database;

        $sql = "SELECT * FROM " . self::$dbTable;
        $sql .= " WHERE photo_id = " . $database->escapeString($photo_id);
        $sql .= " ORDER BY photo_id ASC";

        return self::doQuery($sql);
    }


    //region Getters and Setters

    /**
     * @return string
     */
    public static function getDbTable()
    {
        return self::$dbTable;
    }

    /**
     * @param string $dbTable
     */
    public static function setDbTable($dbTable)
    {
        self::$dbTable = $dbTable;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param mixed $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
    //endregion
}