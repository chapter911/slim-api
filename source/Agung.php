<?php
use Slim\Http\Response;
use Slim\Http\Request;

class Agung extends Library {

    public function __construct($function)
    {
        parent::__construct();
        self::$function();
        return $this->app->run();
    }
    
    public function Login(){
        $this->app->get($this->pattern."/{User}/{Password}", function(Request $request, Response $response, $args){
            $User = $args['User'];
            $Password = $args['Password'];
            $Query = "SELECT * FROM itd_user WHERE Username = '$User' AND Password = '$Password'";
            $Fetch = $this->db->query($Query)->fetchAll();
            if ($Fetch) {
                return $response->withJson($Fetch, 200);
            } else {
                return $response->withJson(array(["status" => "failed"]), 200);
            }
        });
    }
    
    protected function AllUser(){
        $this->app->get($this->pattern, function(Request $request, Response $response){
            $Query = "SELECT * FROM itd_user";
            $Fetch = $this->db->query($Query)->fetchAll();
            if ($Fetch) {
                return $response->withJson($Fetch, 200);
            } else {
                return $response->withJson(array(["status" => "failed"]), 200);
            }
        });
    }

    private function insertUser()
    {
        $this->app->post($this->pattern, function (Request $request, Response $response) {
            $value_data = $request->getParsedBody();
            $sql = "INSERT INTO itd_user(username, password, apikey) VALUES (:username, :password, :apikey)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ":username"    => $value_data["username"],
                ":password"     => $value_data["password"],
                ":apikey"    => $value_data["apikey"]
            ];
            if ($stmt->execute($data)) {
                return $response->withJson(array(["status" => "success"]), 200);
            }
            return $response->withJson(array(["status" => "failed"]), 200);
        });
    }

    private function AllBuku()
    {
        $this->app->get($this->pattern, function (Request $request, Response $response) {
            $Query = "SELECT * FROM itd_buku";
            $Fetch = $this->db->query($Query)->fetchAll();
            if ($Fetch) {
                return $response->withJson($Fetch, 200);
            } else {
                return $response->withJson(array(["status" => "failed"]), 200);
            }
        });
    }

    private function getBukuUser()
    {
        $this->app->get($this->pattern . "/{createdby}", function (Request $request, Response $response, $args) {
            $createdby = $args['createdby'];
            $Query = "SELECT * FROM itd_buku WHERE createdby = '$createdby'";
            $Fetch = $this->db->query($Query)->fetchAll();
            if ($Fetch) {
                return $response->withJson($Fetch, 200);
            } else {
                return $response->withJson(array(["status" => "failed"]), 200);
            }
        });
    }
    
    private function insertBuku(){
        $this->app->post($this->pattern, function(Request $request, Response $response){
            $value_data = $request->getParsedBody();
            $sql = "INSERT INTO itd_buku(judul, isbn, tahun, penerbit, jumlah, kategori, createdby) VALUES (:judul, :isbn, :tahun, :penerbit, :jumlah, :kategori, :createdby)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ":judul"    => $value_data["judul"],
                ":isbn"     => $value_data["isbn"],
                ":tahun"    => $value_data["tahun"],
                ":penerbit" => $value_data["penerbit"],
                ":jumlah"   => $value_data["jumlah"],
                ":kategori" => $value_data["kategori"],
                ":createdby"=> $value_data["createdby"]
            ];
            if($stmt->execute($data)){
               return $response->withJson(array(["status" => "success"]), 200);
            }
            return $response->withJson(array(["status" => "failed"]), 200);
        });
    }

    private function updateBuku()
    {
        $this->app->post($this->pattern, function (Request $request, Response $response) {
            $value_data = $request->getParsedBody();
            $sql = "UPDATE itd_buku SET judul=:judul, isbn=:isbn, tahun=:tahun, penerbit=:penerbit, jumlah=:jumlah, kategori=:kategori, createdby=:createdby WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $data = [
                ":judul"        => $value_data["judul"],
                ":isbn"         => $value_data["isbn"],
                ":tahun"        => $value_data["tahun"],
                ":penerbit"     => $value_data["penerbit"],
                ":jumlah"       => $value_data["jumlah"],
                ":kategori"     => $value_data["kategori"],
                ":createdby"    => $value_data["createdby"],
                ":id"           => $value_data["id"]
            ];
            if ($stmt->execute($data)) {
                return $response->withJson(array(["status" => "success"]), 200);
            }
            return $response->withJson(array(["status" => "failed"]), 200);
        });
    }
}