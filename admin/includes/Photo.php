<?php


class Photo extends Db_Object
{

    protected static $dbTable = "photos";
    protected $id;
    protected $title;
    protected $desc;
    protected $filename;
    protected $type;
    protected $size;

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function update()
    {
        global $database;

        $sql = "UPDATE " . static::$dbTable . " SET ";
        $sql .= "title= '" . $database->escapeString($this->title) . "', ";
        $sql .= "desc= '" . $database->escapeString($this->desc) . "', ";
        $sql .= "filename= '" . $database->escapeString($this->filename) . "', ";
        $sql .= "type= '" . $database->escapeString($this->type) . "' ";
        $sql .= "size= '" . $database->escapeString($this->size) . "' ";
        $sql .= " WHERE id= " . $database->escapeString($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function create()
    {
        global $database;

        $sql = "INSERT INTO " . static::$dbTable . " (title, description, filename, type, size) VALUES ('";
        $sql .= $database->escapeString($this->title) . "', '";
        $sql .= $database->escapeString($this->desc) . "', '";
        $sql .= $database->escapeString($this->filename) . "', '";
        $sql .= $database->escapeString($this->type) . "', '";
        $sql .= $database->escapeString($this->size) . "')";

        if ($database->query($sql)) {
            $this->id = $database->insertedId();
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        global $database;

        $sql = "DELETE FROM " . static::$dbTable;
        $sql .= " WHERE id=" . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    //region Getters and Setters

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    //endregion
}