<?php
class Helper {
    public $rowsperpage = 1000;

    public function format_tanggal($tanggal){
        $arr=explode(" ",$tanggal);
        $time=$arr[1];
        $time=explode(".",$time);$time=$time[0];
        $arr=explode("-",$arr[0]);
        return $arr[2]."-".$arr[1]."-".$arr[0]." ".$time;
    }

    public function validate_domain_email($email){
        $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
        if(eregi($exp,$email)){
            if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function tulis_file($namafile,$content,$modeopen="w"){
        $fp = fopen($namafile, $modeopen);
        fwrite($fp, $content);
        fclose($fp);
    }

}
?>
