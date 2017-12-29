<?php


class Photo extends Db_Object
{

    protected static $dbTable = "photos";
    protected $id;
    protected $title;
    protected $description;
    protected $filename;
    protected $type;
    protected $size;
    protected $caption;
    protected $alternate_text;

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
        } else {
            if ($file['error'] != 0) {
                $this->errors[] = $this->uploadErrors[$file['error']];
                return false;
            } else {
                $this->filename = basename($file['name']);
                $this->tmpPath = $file['tmp_name'];
                $this->type = $file['type'];
                $this->size = $file['size'];
            }
        }
    }

    public function photoPath()
    {
        return $this->uploadDir . DS . $this->filename;
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

            $targetPath = DS . 'home' . DS . 'kel' . DS . SITE_ROOT . DS . 'admin' . DS . $this->uploadDir . DS . $this->filename;

            var_dump($targetPath);

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
        $sql .= "caption= '" . $database->escapeString($this->caption) . "', ";
        $sql .= "description= '" . $database->escapeString($this->description) . "', ";
        $sql .= "filename= '" . $database->escapeString($this->filename) . "', ";
        $sql .= "alternate_text= '" . $database->escapeString($this->alternate_text) . "', ";
        $sql .= "type= '" . $database->escapeString($this->type) . "', ";
        $sql .= "size= '" . $database->escapeString($this->size) . "' ";
        $sql .= " WHERE id= " . $database->escapeString($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function create()
    {
        global $database;

        $sql = "INSERT INTO " . static::$dbTable . " (title, caption, description, filename, alternate_text, type, size) VALUES ('";
        $sql .= $database->escapeString($this->title) . "', '";
        $sql .= $database->escapeString($this->caption) . "', '";
        $sql .= $database->escapeString($this->description) . "', '";
        $sql .= $database->escapeString($this->filename) . "', '";
        $sql .= $database->escapeString($this->alternate_text) . "', '";
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

    public function deletePhoto()
    {
        if ($this->delete()) {
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->photoPath();

            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
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
        return $this->description;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->description = $desc;
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


    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getAltText()
    {
        return $this->alternate_text;
    }

    /**
     * @param mixed $altText
     */
    public function setAltText($altText)
    {
        $this->alternate_text = $altText;
    }
    //endregion
}