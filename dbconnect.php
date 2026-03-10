<?php
    class DBHelper {

        private $db;
        public $insert_id;
        public $affected_rows;
        public $num_fields;

        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $db_name = 'masterfile_db';

        function __construct() {
            $this->db = new mysqli($host=$this->host, $username=$this->username, $password=$this->password, $db_name=$this->db_name);
        }

        function connection_status() {
            return $this->db->connect_error ? 'Error connecting to DataBase':'Connection success.';
        }
        
        function result($table, $where='', $orderby='', $limit=0) {
            $Where = (strlen($where) > 0) ? " WHERE $where":'';
            $Orderby = (strlen($orderby) > 0) ? "ORDER BY $orderby":'';
            $Limit = ($limit > 0) ? " LIMIT $limit ":'';
            $results = $this->db->query("SELECT * FROM $table $Where $Orderby $Limit");
            if ($this->db->error) {
                return 'Query error: '.$this->db->error;
            } else {
                $data = array();
                while ($row = $results->fetch_assoc()) {
                    $data[] = (object)$row;
                }
                return $data;
            }
        }

        function row($table, $where='') {
            $results = $this->result($table, $where);
            return gettype($results) != 'string' ? $results[0]:$results;
        }

        function delete($table, $where) {
            $this->db->query("DELETE FROM $table WHERE $where");
            $this->affected_rows = $this->db->affected_rows;
            return $this->db->error ? 'Delete error: '.$this->db->error: $this->db->affected_rows;
        }

        function insert($table, $array_data) {
            $data = array();
            foreach($array_data as $key => $value):
                if (gettype($value) == 'integer' || gettype($value) == 'double') {
                    $data[] = $key . '=' . $value;
                } else {
                    $data[] = $key . '=' . $this->quote($value);
                }
            endforeach;
            $setValue = join(", ", $data);
            $this->db->query("INSERT INTO $table SET $setValue");
            $this->insert_id = $this->db->insert_id;
            return $this->db->error ? 'Insert error: '.$this->db->error:$this->db->insert_id;
        }

        function update($table, $array_data, $where) {
            $data = array();
            foreach($array_data as $key => $value):
                if (gettype($value) == 'integer' || gettype($value) == 'double') {
                    $data[] = $key . '=' . $value;
                } else {
                    $data[] = $key . '=' . $this->quote($value);
                }
            endforeach;
            $setValue = join(", ", $data);
            $this->db->query("UPDATE $table SET $setValue WHERE $where");
            $this->affected_rows = $this->db->affected_rows;
            return $this->db->error ? 'Update error: '.$this->db->error:$this->db->affected_rows;
        }

        function query($query) {
            $results = $this->db->query($query);
            $this->num_fields = $results->field_count;
            $data = array();
            while($row = $results->fetch_assoc()) {
                $data[] = (object) $row;
            }
            return $this->db->error ? 'Query error: '.$this->db->error: $data;
        }

        function query2($query) {
            $results = $this->db->query($query);
            $this->num_fields = $results->field_count;
            $data = array();
            while($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            return $this->db->error ? 'Query error: '.$this->db->error: $data;
        }

        function is_exist($table, $where) {
            $results = $this->result($table, $where);
            return $this->db->error ? 'Error: '.$this->db->error: sizeof($results) > 0;
        }

        function quote($value) {
            return "'" . addslashes($value) . "'";
        }

        private function contains($haystack, $needle) {
            return strpos($haystack, $needle) !== false;
        }

        function createBackup() {
            /*
            $sqlScript = '';
            $pre = 'Tables_in_'.$this->db_name;
            $tables = $this->query("SHOW TABLES");
            foreach ($tables as $r) {
                $table = $r->$pre;
                if ($this->contains($table, 'vw')) {
                    $t = 'VIEW';
                } else {
                    $t = 'TABLE';
                }

                $sqlScript .= "DROP $t IF EXISTS $table;\n";
                $query = "SHOW CREATE TABLE $table";
                $result = $this->query2($query);
                $row = $this->query2($result);

                $sqlScript .= "\n\n" . $row[1] . ";\n\n";


                $query = "SELECT * FROM $table";
                $result = $this->query2($query);

                $columnCount = $this->num_fields;

                // Prepare SQLscript for dumping data for each table
                for ($i = 0; $i < $columnCount; $i ++) {
                    foreach ($result as $row) {
                        if ($t == 'TABLE') {

                            $sqlScript .= "INSERT INTO $table VALUES(";
                            for ($j = 0; $j < $columnCount; $j++) {
                                $row[$j] = $row[$j];

                                if (isset($row[$j])) {
                                    $sqlScript .= '"' . $row[$j] . '"';
                                } else {
                                    $sqlScript .= '""';
                                }
                                if ($j < ($columnCount - 1)) {
                                    $sqlScript .= ',';
                                }
                            }
                            $sqlScript .= ");\n";

                        }
                    }
                }

                $sqlScript .= "\n";
            }

            echo $sqlScript;
            */
        }

        function restoreBackup($path) {

        }

        function notify($from, $to, $message) {
            $insert = $this->insert('notifications', array(
                '_from' => $from,
                '_to' => $to,
                'message' => $message
            ));
        }

        function viewLink($url) {
            require ($_SERVER['DOCUMENT_ROOT'] . '/osa/config.php');
            return '<a href="'.BASE_URL($url).'" class="text-decoration-none">View</a>';
        }

        function createRandomString($n) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $randomString = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            return $randomString;
        }

    }


    $db = new DBHelper();


