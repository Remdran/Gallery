<?php


class User extends Db_Object
{
    protected $id;
    protected $username;
    protected $password;
    protected $first_name;
    protected $last_name;
    protected $user_image;
    protected $uploadDir = "images";
    protected $imagePlaceholder = "http://placehold.it/400x400&text=image";

    protected static $dbTable = "users";

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

    public static function verifyUser($username, $password)
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $result = self::doQuery($sql);
        return ! empty($result) ? array_shift($result) : false;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create()
    {
        global $database;

        $sql = "INSERT INTO " . static::$dbTable . " (username, password, first_name, last_name, user_image) VALUES ('";
        $sql .= $database->escapeString($this->username) . "', '";
        $sql .= $database->escapeString($this->password) . "', '";
        $sql .= $database->escapeString($this->first_name) . "', '";
        $sql .= $database->escapeString($this->last_name) . "', '";
        $sql .= $database->escapeString($this->user_image) . "')";

        if ($database->query($sql)) {
            $this->id = $database->insertedId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        global $database;

        $sql = "UPDATE " . static::$dbTable . " SET ";
        $sql .= "username= '" . $database->escapeString($this->username) . "', ";
        $sql .= "password= '" . $database->escapeString($this->password) . "', ";
        $sql .= "first_name= '" . $database->escapeString($this->first_name) . "', ";
        $sql .= "last_name= '" . $database->escapeString($this->last_name) . "' ";
        $sql .= " WHERE id= " . $database->escapeString($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
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

    public function imagePath()
    {
        return empty($this->user_image) ? $this->imagePlaceholder : $this->uploadDir . DS . $this->user_image;
    }

    public function setFile($file)
    {
        if (empty($file) || ! $file || ! is_array($file)) {
            $this->errors[] = "There was no file uploaded";
            return false;
        } else {
            if ($file['error'] != 0) {
                $this->errors[] = $this->uploadErrors[$file['error']];
                return false;
            } else {
                $this->user_image = basename($file['name']);
                $this->tmpPath = $file['tmp_name'];
                $this->type = $file['type'];
                $this->size = $file['size'];
            }
        }
    }

    public function saveImage()
    {
        if ($this->id) {
            $this->update();
        } else {
            if ( ! empty($this->errors)) {
                return false;
            }

            if (empty($this->user_image) || empty($this->tmpPath)) {
                $this->errors[] = "The file was not available";
                return false;
            }

            $targetPath = DS . 'home' . DS . 'kel' . DS . SITE_ROOT . DS . 'admin' . DS . $this->uploadDir . DS . $this->user_image;

            var_dump($targetPath);

            if (file_exists($targetPath)) {
                $this->errors[] = "The file {$this->user_image} already exists";
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

    //region Getters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    public function getUserImage()
    {
        return $this->user_image;
    }
    //endregion

    //region Setters
    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setUserImage($user_image)
    {
        $this->user_image = $user_image;
    }
    //endregion
}