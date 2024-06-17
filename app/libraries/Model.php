    <?php
    require './Database.php';
    abstract class Model
    {
        protected string $tablename;
        private array $columns = ["*"];
        protected object $connection;

        public function __construct($tablename)
        {
            $this->connection = Database::getInstance()->connect();
            $this->tablename = $tablename;
        }


        public function __get($proprety)
        {
            if (property_exists($this, $proprety)) {
                return $this->$proprety;
            }
        }

        public function __set($proprety, $value)
        {
            if (property_exists($this, $proprety)) {
                return $this->$proprety = $value;
            }
        }

        public function getAll()
        {
            try {
                $columns = implode(',', $this->columns);
                $statement = $this->connection->query("SELECT {$columns} FROM {$this->tablename}");
                return $statement->fetchAll();
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage());
            }
        }
        public function save($data)
        {
            try {
                $columns = implode(',', array_keys($data));
                $placeholders = implode(',', array_fill(0, count($data), '?'));
                $query = "INSERT INTO {$this->tablename} ({$columns} VALUES {$placeholders})";
                $statement = $this->connection->prepare($query);
                $statement->execute(array_values($data));
                return $this->connection->lastInsertId();
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage());
            }
        }

        public function delete($column, $value)
        {
            try {
                $query = "DELETE FROM {$this->tablename} WHERE {$column} = ?";
                $statement = $this->connection->prepare($query);
                $statement->execute([$value]);
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage());
            }
        }

        public function update($data , $condition) {
            try {
                $placeholders = implode("=? ", array_keys($data)) . '=?';
                foreach($condition as $column){
                $whereCondition = $column . '=?';
                }
                $query = "UPDATE {$this->tablename} SET {$placeholders} WHERE {$whereCondition}";
                $statement = $this->connection->prepare($query);
                $values = array_merge(array_values($data) , array_values($condition));
                $statement->execute($values);
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage());
            }
        }

        public function findByColumn($value , $column){
            try {
                $query = "SELECT * FROM {$this->tablename} WHERE {$column} = ?";
                $statement = $this->connection->prepare($query);
                $statement->execute([$value]);
                $statement->fetchAll();
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage()); 
            }
        }

        public function findOneByColumn($column , $value){
            try {
                $statement = $this->connection->prepare("SELECT * FROM {$this->tablename} WHERE $column = ?");
                $statement->bindParam(1 , $value);
                $statement->execute([$value]);
                $object = $statement->fetch();
                return $object;
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage()); 
            }
        }
        
        public function searchByColumn($column , $value) {
            try {
                $statement = $this->connection->prepare("SELECT * FROM {$this->tablename} WHERE $column LIKE ?");
                $searchValue = '%' . $value . '%';
                $statement->execute([$searchValue]);
                $statement->fetchAll();
            } catch (Exception $e) {
                die("Error throw database" . $e->getMessage()); 
            }
        }

        public function count(){
            $statement = $this->connection->prepare("SELECT COUNT(*) as countTable FROM {$this->tablename} ");
            return $statement->fetch();
        }

        
    }
