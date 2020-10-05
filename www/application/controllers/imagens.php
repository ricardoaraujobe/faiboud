<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Imagens extends MY_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('template');
    }

    //Como este controller estende o MY_Controller, que é onde está a verificação de login e senha, então aqui você não precisa
    //fazer nenhuma verifição se o usuário está logado.
    //Lembre-se: os controllers que você deseja proteger, devem estender o MY_Controller. 
    //O controller Login não pode estender o MY_Controller, caso contrário o código entra em loop, e também não tem sentido proteger
    //a tela de login. :)
    public function get_image() {

        $usuario = $this->session->userdata('login');
        $this->load->helper("color");
//        $context = $this->uri->segment(3, 0); //"ColoredMaps";
        $context = $this->uri->segment(4, 0);
       
        $contexto = $this->uri->segment(3, 0);
        $preferencia = "pref_" . $context . "_" . $this->session->userdata('login');


        $deut = array(1, 2);
        $prot = array(3, 4);

        $peso_cor = 1;

        if (in_array($this->session->userdata('idPatologia'), $deut)) {
            $patologia = 'Deut';
            $peso_r = 0.4;
            $peso_g = 0.2;
            $peso_b = 0.4;
            
//            $peso_r = 0.2;
//            $peso_g = 0.6;
//            $peso_b = 0.2;
        } elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
            $patologia = 'Prot';
            $peso_r = 0.2;
            $peso_g = 0.4;
            $peso_b = 0.4;
        } else {
            $patologia = "Trit";
            $peso_r = 0.4;
            $peso_g = 0.4;
            $peso_b = 0.2;
        }


        $resultado = $patologia.$contexto."AdaptedColorRule";
//        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac   -cp ".:lib/*" colorblind/GetPreferences.java');
        $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -XX:GCTimeLimit=1 -XX:GCHeapFreeLimit=1 -Xms512M -Xmx1500M -cp ".:lib/*" colorblind.GetPreferences ' . $preferencia . ' ' . $resultado;
        $teste = exec($executa_classe);
        $arquivo = ('http://127.0.0.1/includes/json/' . $preferencia . "_preference.json");


        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
            )
        );
        $contexts1 = stream_context_create($opts);

        $info = file_get_contents($arquivo, false, $contexts1);
        $lendo = json_decode($info, true);

        $arquivo_tecnicas = ('http://127.0.0.1/includes/json/' . $preferencia . "_technique_preference.json");

        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
            )
        );
        $contexts2 = stream_context_create($opts);


        $info_tecnicas = file_get_contents($arquivo_tecnicas, false, $contexts2);
        $lendo_tecnicas = json_decode($info_tecnicas, true);


        if (!empty($lendo)) {


            for ($j = 0; $j < count($lendo_tecnicas['technique']); $j++) {
                $cor_original_tecnicas = explode("-", $lendo_tecnicas['technique'][$j]);
                $alg_original_tecnicas = explode("_", $lendo_tecnicas['technique'][$j]);

                $valor = str_replace('R', '', $cor_original_tecnicas[0]);

                for ($i = 0; $i < count($lendo['preference']); $i++) {

                    $cor_original[$i] = explode("-", $lendo['preference'][$i]);
                    $cor[$i] = explode("_", $lendo['preference'][$i]);
                    $valor_pref = str_replace('R', '', $cor[$i][0]);

                    $valor_pref_original = str_replace('R', '', $cor_original[$i][1]);



                    if ($valor == $valor_pref_original) {


                        if ($alg_original_tecnicas[1] == $patologia) {
//                            echo "<b>#Cor original: " . $valor_pref_original . "</b> - RGB: ";
//                            echo "R: " . hexdec(extract_red($valor_pref_original)) . " - ";
//                            echo "G: " . hexdec(extract_green($valor_pref_original)) . " - ";
//                            echo "B: " . hexdec(extract_blue($valor_pref_original)) . "<br>";
                            $cor_tecnica = explode("-", $alg_original_tecnicas[0]);
                            $cor_tecnica_final = str_replace('R', '', $cor_tecnica[1]);

//                            echo "   &nbsp;&nbsp; -Tecnica: " . $cor_tecnica_final . "&nbsp;&nbsp;&nbsp;&nbsp; - RGB: ";
//                            echo "R: " . hexdec(extract_red($cor_tecnica_final)) . " - ";
//                            echo "G: " . hexdec(extract_green($cor_tecnica_final)) . " - ";
//                            echo "B: " . hexdec(extract_blue($cor_tecnica_final)) . "<br>";
//                            echo "   &nbsp;&nbsp; -Preferencia: " . $valor_pref . " - RGB: ";
//                            echo "R: " . hexdec(extract_red($valor_pref)) . " - ";
//                            echo "G: " . hexdec(extract_green($valor_pref)) . " - ";
//                            echo "B: " . hexdec(extract_blue($valor_pref)) . "<br>";

//                            $calculo = calcula_distancia($cor_tecnica_final, $valor_pref, $peso_r, $peso_g, $peso_b, $peso_cor);
                        $calculo = calcula_distancia_sem_peso($cor_tecnica_final, $valor_pref, $peso_r, $peso_g, $peso_b, $peso_cor);
//                         $nome_tecnica[$i] = explode("-", $cor[$i][2]);
//                            echo "Calculo " . $alg_original_tecnicas[2] . ": " . $calculo . "<br>";
                            $total[$alg_original_tecnicas[2]] = $total[$alg_original_tecnicas[2]] + $calculo;
//                            echo "Total parcial " . $alg_original_tecnicas[2] . ": " . $total[$alg_original_tecnicas[2]] . "<br>";
                        }
                    }
                }
            }

            echo "<br><br>===============DEBUG==============<br>";
            echo 'Total Rasche: ' . $total['Rasche'] . "<br>";
            echo 'Total Kuhn: ' . $total['Kuhn'] . "<br>";
            echo 'Total Huang: ' . $total['Huang'] . "<br>";
            echo 'Total Pre adaptada: ' . $total[$contexto] . "<br>";
            $menor = min($total['Rasche'], $total['Kuhn'], $total['Huang'], $total[$contexto]) . "<br>";
            echo 'Menor: ' . $menor . "<br>";

            if (compara_cores($menor, $total['Rasche'], 0.4) == 0) {
                $alg_pref = "rasche2005";
                $nome_imagem = "" . $context . "_" . $patologia . "_rasche.jpg";
            } else if (compara_cores($menor, $total['Kuhn'], 0.4) == 0) {
                $alg_pref = "kuhn2008";
                $nome_imagem = "" . $context . "_" . $patologia . "_kuhn.jpg";
            } else if (compara_cores($menor, $total['Huang'], 0.4) == 0) {
                $alg_pref = "huang2009";
                $nome_imagem = "" . $context . "_" . $patologia . "_huang.jpg";
            } else {
                $alg_pref = "Pre_colored";
                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            }

            echo 'A técnica preferida é: ' . $alg_pref . "<br>";

//            exec('cd /var/www/workspace/Prototipo/src/; sudo javac -Xlint -cp ".:lib/*" colorblind/AddPreferences.java');
//
//            $executa_classe = 'cd /var/www/workspace/Prototipo/src; sudo java -cp ".:lib/*" colorblind.AddPreferences ' . $preferencia . ' ' . $alg_pref;
//
//            $teste = exec($executa_classe);
//
//            redirect('preferencia/');
        } else {



            $resultado = "Common" . $patologia . $contexto . "Rule";
            echo '<br><br>Action: '.$resultado."<br>";


//            exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -Xlint  -cp ".:lib/*" colorblind/CreateCommonRule.java');
            $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -XX:GCTimeLimit=1 -XX:GCHeapFreeLimit=1 -Xms512M -Xmx1500M -cp ".:lib/*" colorblind.CreateCommonRule ' . $patologia . ' ' . $contexto . ' ' . $usuario . ' ' . $resultado;

            $teste = exec($executa_classe);

            $arquivo_comum = ('http://127.0.0.1/includes/json/' . $usuario . '_' . $contexto . '_common_preferences.json');


            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
                )
            );

            $contexts3 = stream_context_create($opts);

            $info_comum = file_get_contents($arquivo_comum, false, $contexts3);




            $lendo_comum = json_decode($info_comum, true);




            echo "<br><br>===============DEBUG==============<br>";
            for ($k = 0; $k < count($lendo_comum['tech']); $k++) {

                $pref = $lendo_comum['tech'][$k];


                echo "<br><br>Técnica escolhida: .$pref.<br>";
            }



            if ($pref == "rasche2005") {

                $nome_imagem = "" . $context . "_" . $patologia . "_rasche.jpg";
            } else if ($pref == "kuhn2008") {

                $nome_imagem = "" . $context . "_" . $patologia . "_kuhn.jpg";
            } else if ($pref == "huang2009") {

                $nome_imagem = "" . $context . "_" . $patologia . "_huang.jpg";
            }  else {
                $alg_pref = "pre colored";
                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            }
        }
//exec("sudo wine /var/www/html/assets/imagens/alg/kuhn_rasche/cvdKuhn2008.exe  /var/www/html/assets/imagens/alg/kuhn_rasche/mapa_deut.bmp 1 & sleep 10; kill $!");

        $this->template->load('templates/template1', 'imagens/get_image', array('nome_imagem' => $nome_imagem, 'contexto'=>$contexto));
    }

    public function grafico() {



        $this->template->load('templates/template1', 'imagens/grafico');
    }

    public function tomografia() {



        $this->template->load('templates/template1', 'imagens/tomografia');
    }

}
