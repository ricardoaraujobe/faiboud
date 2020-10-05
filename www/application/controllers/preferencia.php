<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Preferencia extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('template');
        $this->load->model('preferencia_model');
    }

    public function teste() {

        $usuario = $this->session->userdata('login');
        $this->load->helper("color");
//        $context = $this->uri->segment(3, 0); //"ColoredMaps";
        $context = "ColoredMaps";
        $contexto = "Maps";
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


        $resultado = $patologia . "Rule";
        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac   -cp ".:lib/*" colorblind/GetPreferences.java');
        $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -cp ".:lib/*" colorblind.GetPreferences ' . $preferencia . ' ' . $resultado;
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
//                            $calculo = sqrt(abs(hexdec(extract_red($cor_tecnica_final)) - hexdec(extract_red($valor_pref))) +
//                                    abs(hexdec(extract_green($cor_tecnica_final)) - hexdec(extract_green($valor_pref))) +
//                                    abs(hexdec(extract_blue($cor_tecnica_final)) - hexdec(extract_blue($valor_pref))));

                            $calculo = calcula_distancia($cor_tecnica_final, $valor_pref, $peso_r, $peso_g, $peso_b, $peso_cor);

//                        $nome_tecnica[$i] = explode("-", $cor[$i][2]);
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
            echo 'Total Pre adaptada: ' . $total['Maps'] . "<br>";
            $menor = min($total['Rasche'], $total['Kuhn'], $total['Huang'], $total['Maps']) . "<br>";
            echo 'Menor: ' . $menor . "<br>";

            if (compara_cores($menor, $total['Rasche'], 0.4) == 0) {
                $alg_pref = "rasche2005";
                $nome_imagem = "" . $context . "_" . $patologia . "_rasche.jpg";
            } else if (compara_cores($menor, $total['Kuhn'], 0.4) == 0) {
                $alg_pref = "kuhn2008";
                $nome_imagem = "" . $context . "_" . $patologia . "_kuhn.jpg";
            } else if (compara_cores($menor, $total['Huang'], 0.4) == 0) {
                $alg_pref = "huang2009";
                $nome_imagem = "" . $context . "_" . $patologia . "_huang.png";
            } else if (compara_cores($menor, $total['Maps'], 0.4) == 0) {
                $alg_pref = "Manual_Colored_Maps";
                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            } else {
                $alg_pref = "";
                $nome_imagem = "" . $context . "_" . $patologia . ".bmp";
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


            exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -Xlint  -cp ".:lib/*" colorblind/CreateCommonRule.java');
            $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -cp ".:lib/*" colorblind.CreateCommonRule ' . $patologia . ' ' . $contexto . ' ' . $usuario . ' ' . $resultado;

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

                $nome_imagem = "" . $context . "_" . $patologia . "_huang.png";
            } else if ($pref == "Manual_Colored_Maps") {

                $nome_imagem = "" . $context . "_" . $patologia . "_pre_colored.jpg";
            } else {
                $alg_pref = "";
                $nome_imagem = "" . $context . "_" . $patologia . ".bmp";
            }
        }
    }

    public function index() {

        //$login = $this->session->userdata('login');
        //Descomentar para acessar a ontologia
//        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -cp ".:lib/*" colorblindOWL/CreateUser.java');
//
//
//        $teste= exec('cd /vagrant/workspace/Prototipo/src; sudo java -cp ".:lib/*" colorblindOWL.CreateUser ricardo.araujo');
//
//        $this->template->load('templates/template1', 'index', array('teste' => $teste));

        $this->template->load('templates/template1', 'preferencia/index');
    }

    public function contexto() {



        $patologia = $this->session->userdata('nomePatologia');


        $deut = array(1, 2);
        $prot = array(3, 4);


        if (in_array($this->session->userdata('idPatologia'), $deut)) {
            $tipo = 'Deut';
        } elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
            $tipo = 'Prot';
        } else {
            $tipo = "";
        }

        $contexto = $this->uri->segment(3, 0);
        $contexto_especifico = $this->uri->segment(4, 0);
        $resultado = $tipo . $contexto . "Rule";



        $usuario = $this->session->userdata('login');
//        
//        echo $patologia."<br>";
//        echo $contexto."<br>";
//        echo $usuario."<br>";
//echo $resultado."<br>";
//break;
//        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -cp ".:lib/*" colorblind/CreateRule.java');

        $executa_classe = 'cd /vagrant/workspace/Prototipo/src; sudo java -Xmx1000m  -cp ".:lib/*" colorblind.CreateRule ' . $patologia . ' ' . $contexto . ' ' . $usuario . ' ' . $resultado;



        exec($executa_classe);


        //$arquivo = (base_url('includes/json/' . $usuario . 'export_list_color_java.json/'));

        $arquivo = ('http://127.0.0.1/includes/json/' . $usuario . '_' . $contexto . 'export_list_color_java.json');




        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
            )
        );

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $info = file_get_contents($arquivo, false, $context);

        $lendo = json_decode($info, true);

        $dados = "";
        $pref_cor = "";
        $flag = 0;
        for ($i = 0; $i < count($lendo['color']); $i++) {

            $cor[$i] = explode("-", $lendo['color'][$i]);
            $original_color = $cor[$i][0];



            $pref_cor = $this->preferencia_model->get_cor($original_color, $contexto);

            if (!empty($pref_cor)) {
                $flag = 1;
                foreach ($pref_cor as $pref) {
                    $id_color_preference = $pref->idcolorPreferences;
                    $cor_pref = $pref->preferedColor;
                    $codigo_cor = explode("_", $cor_pref);

                    $cod_cor = str_replace('R', '#', $codigo_cor[0]);
                    $celula = ("<td style='background-color:" . $cod_cor . ";'>Cor alternativa selecionada</td><td><a   href='" . base_url('index.php/preferencia/delcoralterantiva') . "/" . $cor[$i][0] . "/" . $id_color_preference . "/" . $cor_pref . "/" . $contexto . "/" . $contexto_especifico . "' ><button class='del-button'  ><i class='glyphicon glyphicon-minus'></i> Excluir cor alternativa</button></a></td>");
                }
            } else {

                // $flag = 0;
                $celula = ("<td>Nenhuma cor selecionada</td><td><a  href='" . base_url('index.php/preferencia/getcoralterantiva') . "/" . $cor[$i][0] . "/" . $contexto . "/" . $contexto_especifico . "'  ><button class='add-button'   ><i class='glyphicon glyphicon-plus'></i> Adicionar cor alternativa</button></a></td>");
            }

            $dados .=(" <tr><td style='background-color:" . $cor[$i][1] . ";'></td>" . $celula . "</tr>");
        }


        if ($contexto == "Maps") {
            $context = "Mapas";
        } elseif ($contexto == "Graph") {
            $context = "Gráficos";
        } elseif ($contexto == "TechnicalImages") {
            $context = "Tomografia";
        } elseif ($contexto == "Form") {
            $context = "Formulário";
        }elseif ($contexto == "Menu") {
            $context = "Menu";
        }elseif ($contexto == "Table") {
            $context = "Tabela";
        }else {
            $context = "";
        }

        $this->template->load('templates/template1', 'preferencia/contexto', array('dados' => $dados, 'context' => $context));
    }

    public function mapa() {

        $arquivo = (base_url('includes/json/' . $this->session->userdata('login') . 'export_list_color_java.json/'));




        $info = file_get_contents($arquivo);


        $lendo = json_decode($info, true);



        $this->template->load('templates/template1', 'preferencia/mapa', array('lendo' => $lendo));
    }

    public function getcoralterantiva() {

        $deut = array(1, 2);
        $prot = array(3, 4);

        $peso_cor = 1;

        if (in_array($this->session->userdata('idPatologia'), $deut)) {
            $patologia = 'Deut';
           
        } elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
            $patologia = 'Prot';
            
        } else {
            $patologia = "Trit";
           
        }


        $cor = $this->uri->segment(3, 0);
        $contexto = $this->uri->segment(4, 0);
        $contexto_especifico = $this->uri->segment(5, 0);
        $usuario = $this->session->userdata('login');

        $resultado = $patologia.$contexto."AdaptedColorRule";


//       exec('cd /vagrant/workspace/Prototipo/src/; sudo javac  -Xlint -cp ".:lib/*" colorblindOWL/AdaptedColor.java');
//        sleep(5);
//        $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -Xmx512m -cp ".:lib/*" colorblindOWL.AdaptedColor ' . $cor . ' ' . $usuario;


        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac  -Xlint -cp ".:lib/*" colorblind/GetAdaptedColor.java');
        sleep(5);
        $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -Xmx1000m -cp ".:lib/*" colorblind.GetAdaptedColor ' . $cor . ' ' . $usuario . ' '.$resultado;


        $teste = exec($executa_classe);






        redirect('preferencia/listacoralterantiva/' . $cor . '/' . $contexto . '/' . $contexto_especifico);
    }

    public function listacoralterantiva() {


        $cor_or = $this->uri->segment(3, 0);
        $contexto = $this->uri->segment(4, 0);
        $contexto_especifico = $this->uri->segment(5, 0);

        $usuario = $this->session->userdata('login');

        $arquivo = ('http://127.0.0.1/includes/json/' . $cor_or . '_' . $usuario . '_export_list_Adapted_color_java.json');




        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
            )
        );

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $info = file_get_contents($arquivo, false, $context);

        $lendo = json_decode($info, true);



        $cor_original = str_replace('R', '#', $cor_or);

        if ($contexto == "Maps") {
            $context = "Mapas";
        } elseif ($contexto == "Graph") {
            $context = "Gráficos";
        } elseif ($contexto == "TechnicalImages") {
            $context = "Tomografia";
        } elseif ($contexto == "Form") {
            $context = "Formulário";
        }elseif ($contexto == "Menu") {
            $context = "Menu";
        }elseif ($contexto == "Table") {
            $context = "Tabela";
        }else {
            $context = "";
        }

        $this->template->load('templates/template1', 'preferencia/listacoralterantiva', array('lendo' => $lendo, 'cor_original' => $cor_original, 'cor_or' => $cor_or, 'contexto' => $contexto, 'contexto_especifico' => $contexto_especifico, 'context' => $context));
    }

    public function inserepreferencia() {

        $cor = $this->uri->segment(3, 0);
        $cor_original = $this->uri->segment(4, 0);
        $contexto = $this->uri->segment(5, 0);
        $contexto_especifico = $this->uri->segment(6, 0);
        $cod_cor = explode("_", $cor);
        echo 'Cor: ' . $cor . "<br>";
        $codigo_cor = str_replace('R', '', $cod_cor[0]);
        echo 'Cor codigo: ' . $codigo_cor . "<br>";
        echo 'Cor original: ' . $cor_original . "<br>";
        $context = "ColoredMaps";

        $dados = array(
            'originalColor' => $cor_original,
            'preferedColor' => $cor,
            'context' => $contexto,
            'user_idUser' => $this->session->userdata('idUsuario')
        );

        if ($this->preferencia_model->salva_dados($dados) == TRUE) {


//            exec('cd /vagrant/workspace/Prototipo/src/; sudo javac  -cp ".:lib/*" colorblind/CreatePreference.java');
            sleep(5);
            $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -Xmx1000m -cp ".:lib/*" colorblind.CreatePreference ' . $this->session->userdata('login') . ' ' . $cor . ' ' . $codigo_cor . ' ' . $cor_original . ' ' . $contexto_especifico;

            $teste = exec($executa_classe);


            redirect('preferencia/contexto/' . $contexto . '/' . $contexto_especifico);
        }
    }

    public function delcoralterantiva() {

        $cor = $this->uri->segment(3, 0);
        $id_cor = $this->uri->segment(4, 0);
        $pref_cor = $this->uri->segment(5, 0);
        $contexto = $this->uri->segment(6, 0);
        $contexto_especifico = $this->uri->segment(7, 0);
        $preferencia = "pref_" . $contexto_especifico . "_" . $this->session->userdata('login');


        if ($this->preferencia_model->deleta_dados($id_cor) == TRUE) {

//            exec('cd /vagrant/workspace/Prototipo/src/; sudo javac  -cp ".:lib/*" colorblind/RemovePreference.java');

            $executa_classe = 'cd /vagrant/workspace/Prototipo/src/; sudo java -Xmx1000m -cp ".:lib/*" colorblind.RemovePreference ' . $preferencia . ' ' . $pref_cor;

            $teste = exec($executa_classe);

            redirect('preferencia/contexto/' . $contexto . '/' . $contexto_especifico);
        }
    }

    public function gravapreferencia() {

        $this->load->helper("color");
//        $context = $this->uri->segment(3, 0); //"ColoredMaps";
        $context = "ColoredMaps";
        $preferencia = "pref_" . $context . "_" . $this->session->userdata('login');


        $deut = array(1, 2);
        $prot = array(3, 4);


        if (in_array($this->session->userdata('idPatologia'), $deut)) {
            $patologia = 'Deut';
        } elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
            $patologia = 'Prot';
        } else {
            $patologia = "";
        }


        $resultado = $patologia . "Rule";
//        exec('cd /var/www/workspace/Prototipo/src/; sudo javac  -cp ".:lib/*" colorblind/GetPreferences.java');
        $executa_classe = 'cd /var/www/workspace/Prototipo/src; sudo java -Xmx1000m -cp ".:lib/*" colorblind.GetPreferences ' . $preferencia . ' ' . $resultado;
        $teste = exec($executa_classe);
        $arquivo = (base_url('includes/json/' . $preferencia . "_preference.json"));

        $info = file_get_contents($arquivo);
        $lendo = json_decode($info, true);

        $arquivo_tecnicas = (base_url('includes/json/' . $preferencia . "_technique_preference.json"));
        $info_tecnicas = file_get_contents($arquivo_tecnicas);
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
                            echo "<b>#Cor original: " . $valor_pref_original . "</b> - RGB: ";
                            echo "R: " . hexdec(extract_red($valor_pref_original)) . " - ";
                            echo "G: " . hexdec(extract_green($valor_pref_original)) . " - ";
                            echo "B: " . hexdec(extract_blue($valor_pref_original)) . "<br>";
                            $cor_tecnica = explode("-", $alg_original_tecnicas[0]);
                            $cor_tecnica_final = str_replace('R', '', $cor_tecnica[1]);

                            echo "   &nbsp;&nbsp; -Tecnica: " . $cor_tecnica_final . "&nbsp;&nbsp;&nbsp;&nbsp; - RGB: ";
                            echo "R: " . hexdec(extract_red($cor_tecnica_final)) . " - ";
                            echo "G: " . hexdec(extract_green($cor_tecnica_final)) . " - ";
                            echo "B: " . hexdec(extract_blue($cor_tecnica_final)) . "<br>";

                            echo "   &nbsp;&nbsp; -Preferencia: " . $valor_pref . " - RGB: ";
                            echo "R: " . hexdec(extract_red($valor_pref)) . " - ";
                            echo "G: " . hexdec(extract_green($valor_pref)) . " - ";
                            echo "B: " . hexdec(extract_blue($valor_pref)) . "<br>";

                            $calculo = sqrt(abs(hexdec(extract_red($cor_tecnica_final)) - hexdec(extract_red($valor_pref))) +
                                    abs(hexdec(extract_green($cor_tecnica_final)) - hexdec(extract_green($valor_pref))) +
                                    abs(hexdec(extract_blue($cor_tecnica_final)) - hexdec(extract_blue($valor_pref))));

//                        $nome_tecnica[$i] = explode("-", $cor[$i][2]);
                            echo "Calculo " . $alg_original_tecnicas[2] . ": " . $calculo . "<br>";
                            $total[$alg_original_tecnicas[2]] = $total[$alg_original_tecnicas[2]] + $calculo;
                            echo "Total parcial " . $alg_original_tecnicas[2] . ": " . $total[$alg_original_tecnicas[2]] . "<br>";
                        }
                    }
                }
            }

            echo "------------------------------------------------------------------------------<br>";
            echo 'Total Rasche: ' . $total['Rasche'] . "<br>";
            echo 'Total Kuhn: ' . $total['Kuhn'] . "<br>";
            echo 'Total Huang: ' . $total['Huang'] . "<br>";
            echo 'Total Pre: ' . $total['Maps'] . "<br>";
            $menor = min($total['Rasche'], $total['Kuhn'], $total['Huang'], $total['Maps']) . "<br>";
            echo 'menor: ' . $menor . "<br>";

            if (compara_cores($menor, $total['Rasche'], 0.4) == 0) {
                $alg_pref = "rasche2005";
            } else if (compara_cores($menor, $total['Kuhn'], 0.4) == 0) {
                $alg_pref = "kuhn2008";
            } else if (compara_cores($menor, $total['Huang'], 0.4) == 0) {
                $alg_pref = "huang2009";
            } else if (compara_cores($menor, $total['Maps'], 0.4) == 0) {
                $alg_pref = "Manual_Colored_Maps";
            } else {
                $alg_pref = "";
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
            echo 'Usar preferencia geral<br>';
        }

        echo '################################################################################<br>';


//        if (!empty($lendo)) {
//
//            for ($i = 0; $i < count($lendo['preference']); $i++) {
//
//
//                $cor_original[$i] = explode("-", $lendo['preference'][$i]);
//                $cor[$i] = explode("_", $lendo['preference'][$i]);
//                $valor = str_replace('R', '', $cor[$i][0]);
//                echo "Cor: " . $valor . "<br>";
//                echo "Cor original: " . $cor_original[$i][1] . "<br>";
//                echo "Red: " . extract_red($valor);
//                echo " - " . hexdec(extract_red($valor)) . "<br>";
//                echo "Green: " . extract_green($valor);
//                echo " - " . hexdec(extract_green($valor)) . "<br>";
//                echo "Blue: " . extract_blue($valor);
//                echo " - " . hexdec(extract_blue($valor)) . "<br>";
//            }
//        } else {
//            echo 'não existe';
//        }
//
//        echo '============================================================<br><br>';
//
//
//        for ($j = 0; $j < count($lendo_tecnicas['technique']); $j++) {
//
//
//            $cor_original_tecnicas = explode("-", $lendo_tecnicas['technique'][$j]);
//            echo "Cor original: " . $cor_original_tecnicas[0] . " Cor adaptada: " . $cor_original_tecnicas[1] . "<br>";
//        }
    }

}
