<?php
include_once 'includes/database.php';
include_once 'includes/functions.php';

class Rule {
    private $id;
    private $name;
    private $condition;
    private $action;
    private $user_id;

    public function __construct($id = null, $name = null, $condition = null, $action = null, $user_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->condition = $condition;
        $this->action = $action;
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

    public function getCondition() {
        return $this->condition;
    }

    public function setCondition($condition) {
        $this->condition = sanitizeInput($condition);
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = sanitizeInput($action);
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
            'condition' => $this->condition,
            'action' => $this->action,
            'user_id' => $this->user_id
        );
        if ($this->id === null) {
            $this->id = insert('rules', $data);
        } else {
            update('rules', $this->id, $data);
        }
    }

    public function delete() {
        if ($this->id !== null) {
            delete('rules', $this->id);
            $this->id = null;
        }
    }

    public static function getAll($user_id) {
        $rows = fetchAll('rules');
        $rules = array();
        foreach ($rows as $row) {
            if ($row['user_id'] == $user_id) {
                $rule = new Rule(
                    $row['id'],
                    $row['name'],
                    $row['condition'],
                    $row['action'],
                    $row['user_id']
                );
                $rules[] = $rule;
            }
        }
        return $rules;
    }

    public static function getById($id) {
        $row = fetchById('rules', $id);
        if ($row) {
            return new Rule(
                $row['id'],
                $row['name'],
                $row['condition'],
                $row['action'],
                $row['user_id']
            );
        }
        return null;
    }
}
?>
