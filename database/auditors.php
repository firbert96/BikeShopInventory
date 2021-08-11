<?php
   class Auditors extends Database{
        private $table = "auditors";

        public function insert($fullname,$email,$phone,$password){
            $fullname = $this->sanitize($fullname);
            $email = $this->sanitize($email);
            $phone = $this->sanitize($phone);
            $password = $this->sanitize($password);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO " .$this->table. "(fullname,email,phone,password)
                VALUES ('".$fullname."','".$email."','".$phone."','".$password_hash."')";
            if(mysqli_query($this->db, $sql)){
                return $this->login($email,$password);
            }
            else if (mysqli_errno($this->db) == 1062) {
                // print 'no way!';
                return "error duplicate key";
            }
            else{
                die($this->get_error());
            }
        }

        public function login($email,$password){
            $email = $this->sanitize($email);
            $password = $this->sanitize($password);
            $sql = "SELECT id, password FROM ".$this->table." WHERE email='".$email."'";
            $result = mysqli_query($this->db, $sql);
            if ($result) {
                if ($result->num_rows == 1) {
                    $row = mysqli_fetch_array($result);
                    if (password_verify($password, $row['password'])) {
                        return $row ["id"];
                    }
                    else
                        return -1;
                }
            } 
            else {
                die($this->get_error());
            }
        }

        public function selectId($id){
            $sql = "SELECT fullname,email,phone FROM ".$this->table." WHERE id=".$id;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            if($result){
                $row = mysqli_fetch_array($result);
                return $row;
            }
        }

        public function editUser($fullname,$email,$phone,$id){
            $fullname = $this->sanitize($fullname);
            $email = $this->sanitize($email);
            $phone = $this->sanitize($phone);
            $sql = "UPDATE ".$this->table." 
            SET fullname = '".$fullname."', email = '".$email."', phone = '".$phone."', updated_date = now() 
            WHERE id = ".$id;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }
   }
?>