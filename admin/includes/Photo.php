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

    public $tmpPath;
    public $uploadDir = 'images';

    public $errors = [];
    public $uploadErrors = [   // Translating constant error codes to readable errors
        UPLOAD_ERR_OK         => 'There is no error',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize in php.ini',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE in php.ini',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write a file to disk',
        UPLOAD_ERR_EXTENSION  => 'A php extension stopped the file upload'
    ];

    // $file = $_FILES['uploaded_file'] from upload form
    public function set_file($file)
    {
        if (empty($file) || ! $file || ! is_array($file)) {
            $this->errors[] = "There was no file uploaded";
            return false;
        } else if ($file['error'] != 0) {
            $this->errors[] = $this->uploadErrors[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->tmpPath = $file['tmpName'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            if ( ! empty($this->errors)) {
                return false;
            }

            if (empty($this->filename) || empty($this->tmpPath)) {
                $this->errors[] = "The file was not available";
                return false;
            }

            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDir . DS . $this->filename;

            if (file_exists($targetPath)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }

            if (move_uploaded_file($this->tmpPath, $targetPath)) {
                if ($this->create()) {
                    unset($this->tmpPath);
                    return true;
                }
            } else {
                $this->errors[] = "The images folder has a problem with its permissions";
                return false;
            }
        }
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