<?php 
    class User{
        private $emailaddr;
        private $hashedPassword;
        public function __construct($emailaddr,$hashedPassword){
            $this->emailaddr = $emailaddr;
            $this->hashedPassword = $hashedPassword;
        }
        public function getemailaddr(){
            return $this->emailaddr;
        }
        public function getHashedPassword(){
            return $this->hashedPassword;
        }
    }
?>