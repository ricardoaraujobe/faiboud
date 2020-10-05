<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Elementos extends MY_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('template');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function get_element() {

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
       exec('cd /vagrant/workspace/Prototipo/src/; sudo javac   -cp ".:lib/*" colorblind/GetPreferences.java');
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
                $alg_pref = "Manual_Colored_" . $contexto;
                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            }

            echo 'A técnica preferida é: ' . $alg_pref . "<br>";

            $preferida = $alg_pref;

//            exec('cd /var/www/workspace/Prototipo/src/; sudo javac -Xlint -cp ".:lib/*" colorblind/AddPreferences.java');
//
//            $executa_classe = 'cd /var/www/workspace/Prototipo/src; sudo java -cp ".:lib/*" colorblind.AddPreferences ' . $preferencia . ' ' . $alg_pref;
//
//            $teste = exec($executa_classe);
//
//            redirect('preferencia/');
        } else {



            $resultado = "Common" . $patologia . $contexto . "Rule";


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
            } else {
                $alg_pref = "pre colored";
                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            }

            $preferida = $pref;
        }

        $resultado = $patologia . $contexto . $preferida . "Rule";

        echo "Action " . $resultado . "<br>";



//        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -Xlint  -cp ".:lib/*" colorblind/GetColorElementTechnique.java');
        $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -XX:GCTimeLimit=1 -XX:GCHeapFreeLimit=1 -Xms512M -Xmx1500M -cp ".:lib/*" colorblind.GetColorElementTechnique ' . $patologia . ' ' . $contexto . ' ' . $usuario . ' ' . $resultado;

        $teste = exec($executa_classe);



        $arquivo_elemento = ('http://127.0.0.1/includes/json/element_' . $contexto . '_' . $usuario . '_export_list_Adapted_color_java.json');


        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
            )
        );

        $contexto_elemento = stream_context_create($opts);

        $info_elemento = file_get_contents($arquivo_elemento, false, $contexto_elemento);




        $lendo_elemento = json_decode($info_elemento, true);
        if ($contexto == "Form") {

            $background_form = "#009946";
            $button_return = "#FE0000";
            $button_send = "#F1C85F";
            $logo = "";

            for ($x = 0; $x < count($lendo_elemento['color']); $x++) {

                // echo $lendo_elemento['color'][$x] . "<br>";
                $cores = explode("-", $lendo_elemento['color'][$x]);
                $cores_tec = explode("_", $cores[0]);
                $tecnica = str_replace('R', '#', $cores_tec[0]);
                $original = str_replace('R', '#', $cores[1]);

//                echo "Original: " . $original . " - Tecnica: " . $tecnica . "<br>";

                if ($background_form == $original) {
                    $background_form = $tecnica;
                }

                if ($button_return == $original) {
                    $button_return = $tecnica;
                }

                if ($button_send == $original) {
                    $button_send = $tecnica;
                }
            }



            $this->template->load('templates/template1', 'elementos/formulario', array('background_form' => $background_form, 'button_return' => $button_return, 'button_send' => $button_send, 'nome_imagem' => $nome_imagem));
        } elseif ($contexto == "Menu") {

            $background_menu = "#009946";

            $background_home = "#BEE826";
            $texto_home = "#577305";

            $background_sobre = "#01BEF6";
            $texto_sobre = "#223144";

            $background_servico = "#FF7D01";
            $texto_servico = "#6F3F11";

            $background_portfolio = "#FDD40A";
            $texto_portfolio = "#88690F";

            $background_contato = "#D338AE";
            $texto_contato = "#640D44";





            for ($x = 0; $x < count($lendo_elemento['color']); $x++) {

                // echo $lendo_elemento['color'][$x] . "<br>";
                $cores = explode("-", $lendo_elemento['color'][$x]);
                $cores_tec = explode("_", $cores[0]);
                $tecnica = str_replace('R', '#', $cores_tec[0]);
                $original = str_replace('R', '#', $cores[1]);

//                echo "Original: " . $original . " - Tecnica: " . $tecnica . "<br>";

                if ($background_menu == $original) {
                    $background_menu = $tecnica;
                }

                if ($background_home == $original) {
                    $background_home = $tecnica;
                }

                if ($texto_home == $original) {
                    $texto_home = $tecnica;
                }

                if ($background_sobre == $original) {
                    $background_sobre = $tecnica;
                }

                if ($texto_sobre == $original) {
                    $texto_sobre = $tecnica;
                }

                if ($background_servico == $original) {
                    $background_servico = $tecnica;
                }

                if ($texto_servico == $original) {
                    $texto_servico = $tecnica;
                }

                if ($background_portfolio == $original) {
                    $background_portfolio = $tecnica;
                }

                if ($texto_portfolio == $original) {
                    $texto_portfolio = $tecnica;
                }

                if ($background_contato == $original) {
                    $background_contato = $tecnica;
                }

                if ($texto_contato == $original) {
                    $texto_contato = $tecnica;
                }
            }



            $this->template->load('templates/template1', 'elementos/menu', array('background_menu' => $background_menu,
                'background_home' => $background_home, 'texto_home' => $texto_home, 'background_sobre' => $background_sobre,
                'texto_sobre' => $texto_sobre, 'background_servico' => $background_servico, 'texto_servico' => $texto_servico,
                'background_portfolio' => $background_portfolio, 'texto_portfolio' => $texto_portfolio, 'background_contato' => $background_contato,
                'texto_contato' => $texto_contato, 'nome_imagem' => $nome_imagem));
        } elseif ($contexto == "Table") {

            $background_titulo = "#009900";
            
            $borda = "#006600";

            $cotacao_positiva = "#006600";
            $cotacao_negativa = "#FE0000";
            $link_visitado = "#F84F4C";
            $link_nao_visitado = "#5A9F5E";

            $logo = "economy_" . $patologia . "_" . $preferida . ".jpg";
            $seta_cima = "up_" . $patologia . "_" . $preferida . ".jpg";
            $seta_baixo = "down_" . $patologia . "_" . $preferida . ".jpg";
            $alto_risco = "red_" . $patologia . "_" . $preferida . ".jpg";
            $baixo_risco = "green_" . $patologia . "_" . $preferida . ".jpg";





            for ($x = 0; $x < count($lendo_elemento['color']); $x++) {

                // echo $lendo_elemento['color'][$x] . "<br>";
                $cores = explode("-", $lendo_elemento['color'][$x]);
                $cores_tec = explode("_", $cores[0]);
                $tecnica = str_replace('R', '#', $cores_tec[0]);
                $original = str_replace('R', '#', $cores[1]);

//                echo "Original: " . $original . " - Tecnica: " . $tecnica . "<br>";

                if ($background_titulo == $original) {
                    $background_titulo = $tecnica;
                }

                if ($cotacao_positiva == $original) {
                    $cotacao_positiva = $tecnica;
                }

                if ($cotacao_negativa == $original) {
                    $cotacao_negativa = $tecnica;
                }
                if ($link_visitado == $original) {
                    $link_visitado = $tecnica;
                }
                if ($link_nao_visitado == $original) {
                    $link_nao_visitado = $tecnica;
                }
            }



            $this->template->load('templates/template1', 'elementos/tabela', array('background_titulo' => $background_titulo,
                'cotacao_positiva' => $cotacao_positiva, 'cotacao_negativa' => $cotacao_negativa,
                'link_visitado' => $link_visitado, 'link_nao_visitado' => $link_nao_visitado, 'logo' => $logo,
                'seta_cima' => $seta_cima, 'seta_baixo' => $seta_baixo, 'alto_risco' => $alto_risco,
                'baixo_risco' => $baixo_risco, 'borda'=>$borda));
        } else {
            
        }
    }

    public function menu() {



        $this->template->load('templates/template1', 'elementos/menu');
    }

    public function formulario() {



        $background_form = "#009946";

        $this->template->load('templates/template1', 'elementos/formulario', array('background_form' => $background_form));
    }

    public function confirma_form() {




        $nome = $this->input->post('username');
        $email = $this->input->post('email');
        $cidade = $this->input->post('cidade');
        $background_form = $this->input->post('background_form');
        $button_return = $this->input->post('button_return');
        $nome_imagem = $this->input->post('nome_imagem');


        $this->template->load('templates/template1', 'elementos/confirma_form', array('nome' => $nome, 'email' => $email, 'cidade' => $cidade, 'background_form' => $background_form, 'button_return' => $button_return, 'nome_imagem' => $nome_imagem));
    }

    public function tabela() {



        $this->template->load('templates/template1', 'elementos/tabela');
    }

}
