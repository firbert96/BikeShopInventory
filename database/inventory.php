<?php
    class Inventory extends Database{
        private $table = "inventory";
        private $table_flows = "inventory_flows";

        public function insert($auditor_id,$product_name,$product){
            $product_name = $this->sanitize($product_name);
            $sql = "INSERT INTO " .$this->table. "(auditor_id,product_name,product,quantity)
            VALUES ('".$auditor_id."','".$product_name."','".$product."',0)";
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }

        public function selectId($id){
            $sql = "SELECT product_name, product, quantity FROM ".$this->table." WHERE id=".$id;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            if($result){
                $row = mysqli_fetch_array($result);
                return $row;
            }
        }

        public function editProduct($auditor_id,$product_name,$product,$id){
            $product_name = $this->sanitize($product_name);
            $sql = "UPDATE ".$this->table." 
            SET auditor_id = ".$auditor_id.", product_name = '".$product_name."', product = ".$product.", updated_date = now() 
            WHERE id = ".$id;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }

        public function delete($id){
            $sql = "DELETE FROM ".$this->table." WHERE id=".$id;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }

        public function countSelectAll(){
            $sql = "SELECT COUNT(*) AS total FROM ".$this->table;
            $result = mysqli_query($this->db, $sql) or die($this->get_error()); 
            if($result){
                $row = mysqli_fetch_array($result);
                return $row;
            }
        }

        public function selectAll($start,$limit_page){
            $sql = "SELECT * FROM ".$this->table." ORDER BY updated_date DESC LIMIT ".$start.", ".$limit_page;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }

        public function countSearch($product_name){
            $product_name = $this->sanitize($product_name);
            $sql = "SELECT COUNT(*) AS total FROM ".$this->table." WHERE product_name LIKE '%".$product_name."%'";
            $result = mysqli_query($this->db, $sql) or die($this->get_error()); 
            if($result){
                $row = mysqli_fetch_array($result);
                return $row;
            }
        }

        public function search($product_name,$start,$limit_page){
            $product_name = $this->sanitize($product_name);
            $sql = "SELECT * FROM ".$this->table." WHERE product_name LIKE '%".$product_name."%' ORDER BY updated_date DESC LIMIT ".$start.", ".$limit_page;
            $result = mysqli_query($this->db, $sql) or die($this->get_error());
            return $result;
        }

        public function editQuantity($product_id,$auditor_id,$quantity,$changer,$changer_name){
            $changer_name = $this->sanitize($changer_name);
            $sql_flows = "INSERT INTO ".$this->table_flows."(inventory_id,auditor_id,quantity,changer,changer_name,updated_date)
                VALUES(".$product_id.",".$auditor_id.",".$quantity.",".$changer.",'".$changer_name."',now())";
            if(mysqli_query($this->db, $sql_flows)){
                $row = $this->selectId($product_id);
                if($changer==0){
                    if($row['quantity']<$quantity){
                        return false;
                    }
                    $quantity= $quantity*(-1);
                }
                $total_quantity = $row['quantity']+$quantity;
                $sql = "UPDATE ".$this->table." SET auditor_id = ".$auditor_id.",quantity = ".$total_quantity.", updated_date = now() WHERE id = ".$product_id;
                $result = mysqli_query($this->db, $sql) or die($this->get_error());
                return $result;
            }
            else{
                return die($this->get_error());
            }
        }

    }
?>