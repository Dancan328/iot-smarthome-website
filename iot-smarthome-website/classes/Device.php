<?php
include_once 'includes/database.php';
include_once 'includes/functions.php';

class Device {
    private $id;
    private $name;
    private $type;
    private $status;
    private $user_id;

    public function __construct($id = null, $name = null, $type = null, $status = null, $user_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->status = $status;
        $this->user_id = $user_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = sanitizeInput($name);
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = sanitizeInput($type);
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = sanitizeInput($status);
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = (int) $user_id;
    }

    public function save() {
        $data = array(
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'user_id' => $this->user_id
        );
        if ($this->id === null) {
            $this->id = insert('devices', $data);
        } else {
            update('devices', $this->id, $data);
        }
    }

    public function delete() {
        if ($this->id !== null) {
            delete('devices', $this->id);
            $this->id = null;
        }
    }

    public static function getAll($user_id) {
        $rows = fetchAll('devices');
        $devices = array();
        foreach ($rows as $row) {
            if ($row['user_id'] == $user_id) {
                $device = new Device(
                    $row['id'],
                    $row['name'],
                    $row['type'],
                    $row['status'],
                    $row['user_id']
                );
                $devices[] = $device;
            }
        }
        return $devices;
    }

    public static function getById($id) {
        $row = fetchById('devices', $id);
        if ($row) {
            return new Device(
                $row['id'],
                $row['name'],
                $row['type'],
                $row['status'],
                $row['user_id']
            );
        }
        return null;
    }
}
?>
