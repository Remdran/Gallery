;<?php


class Db_Object
{

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

    public static function findAll()
    {
        return self::doQuery('SELECT * FROM ' . static::$dbTable); //late static binding
    }


    public static function findById($id)
    {
        $resultArray = self::doQuery("SELECT * FROM " . static::$dbTable . " WHERE id= $id LIMIT 1");

        return ! empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function doQuery($sql)
    {
        global $database;

        $result = $database->query($sql);
        $objArray = [];

        while ($row = mysqli_fetch_array($result)) {
            $objArray[] = self::Instantiate($row);
        }

        return $objArray;
    }

    public static function Instantiate($object)
    {
        $callingClass = get_called_class();
        $createdObject = new $callingClass;
        $class_props = get_object_vars($createdObject);

        foreach ($object as $property => $value) {
            if (array_key_exists($property, $class_props)) {
                $createdObject->$property = $value;
            }
        }

        return $createdObject;
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
                $this->filename = basename($file['name']);
                $this->tmpPath = $file['tmp_name'];
                $this->type = $file['type'];
                $this->size = $file['size'];
            }
        }
    }

}