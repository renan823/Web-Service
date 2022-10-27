<?php 
    require_once __DIR__."/../configs/BancoDados.php";

    class User{

        private static function criptografia($senha){
            return sha1($senha);
        }

        public static function create($nome, $login, $senha){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("insert into user(nome, login, senha) values(?, ?, ?)");
                $stmt->execute([$nome, $login, self::criptografia($senha)]);
                if($stmt->rowCount()){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function isCreated($login){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("select count(*) from user where login=?");
                $stmt->execute([$login]);
                if($stmt->fetchColumn() > 0){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function getAll(){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("select id, nome, login from user");
                $stmt->execute();
                return $stmt->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function update($id, $nome, $login, $senha){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("update user set nome=?, login=?, senha=? where id=?");
                $stmt->execute([$nome, $login, self::criptografia($senha), $id]);
                if($stmt->rowCount()){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function delete($login){
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("delete from user where login=?");
            $stmt->execute([$login]);
            if($stmt->fetchColumn() > 0){
                return true;
            }
            return false;
        }

        public static function exists($id){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("select count(*) from user where id=?");
                $stmt->execute([$id]);
                if($stmt->fetchColumn() > 0){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }

    }
?>