<?php

namespace core\classes;
use Mpdf\Mpdf;

class PDF {

    private $pdf;
    private string $html;

    private int $x;
    private int $y;
    private int $width; // Largura
    private int $height; // Altura
    private string $align = "left"; // Alinhar texto

    private string $color = "#333"; // Cor
    private string $background = "transparent"; // Background

    private string $fontFamily; // Família de fonte
    private string $fontSize; // Tamanho da fonte
    private string $fontType; // Tipo de fonte

    private bool $showAreas; // Mostrar ou esconder um contorno em volta das caixas de texto

    /**
     * @param bool $show
     * @param string $format
     * @param string $orientation
     * @param string $mode 
    */
    public function __construct($show = false, $format = "A4", $orientation = "P", $mode = "utf-8") {
        
        // Criando a instancia da classe Mpdf
        $this->pdf = new Mpdf([
            "format" => $format,
            "orientation" => $orientation,
            "mode" => $mode
        ]);

        // Iniciar o html em branco
        $this->startHtml();

        // Caso precise mostrar as bordas nos elementos
        // Definimos o valor de showAreas para [true] ao instanciar a classe PDF, como padrão deixamos [false].
        // Example: $pdf = new PDF(true)
        $this->showAreas = $show;
    }

    /**
     * @param $template
    */
    public function setTemplate($template) {
        $this->pdf->SetDocTemplate($template);
    }

    public function startHtml() {
        // Deixar o html em branco[vazio]
        $this->html = "";
    }

    /**
     * @param string $color 
    */
    public function setColor(string $color) {
        // Definindo a cor do texto
        $this->color = $color;
    }

    /**
     * @param string $background 
    */
    public function setBackground(string $background) {
        // Definindo a cor de background
        $this->background = $background;
    }

    /**
     * @param string $align 
    */
    public function setAlignText(string $align) {
        // Definindo o alinhamento do texto
        $this->align = $align;
    }

    /**
     * @param string $fontFamily 
    */
    public function setFontFamily(string $fontFamily) {

        $familyPossible = [ "Arial", "Lucida Sans", "Times New Roman", "Courier New", "Franklin Gothic Medium", "Ping Pong" ];

        // Verificar se a família permite as fontes permitidas
        if(in_array($fontFamily, $familyPossible)) {
            // Definindo a família de fontes
            $this->fontFamily = $fontFamily;
        } else {
            $this->fontFamily = 'Arial';
        }

    }

    /**
     * @param string $size 
    */
    public function setFontSize(string $size) {
        // Definindo o tamanho da fonte
        $this->fontSize = $size;
    }

    /**
     * @param string $fontWeight 
    */
    public function setFontWeight(string $fontWeight) {
        $this->fontType = $fontWeight;
    }

    /**
     * @param int $x 
    */
    public function setX(int $x) {
        $this->x = $x;
    }

    /**
     * @param int $y 
    */
    public function setY(int $y) {
        $this->y = $y;
    }

    /**
     * @param int $width 
    */
    public function setWidth(int $width) {
        $this->width = $width;
    }

    /**
     * @param int $height 
    */
    public function setHeight(int $height) {
        $this->height = $height;
    }

    /**
     * @param int $x
     * @param int $y 
    */
    public function position(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param int $width
     * @param int $height 
    */
    public function dimension(int $width, int $height) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @param int $x
     * @param int $y 
     * @param int $width
     * @param int $height 
    */
    public function positionAndDimension(int $x, int $y, int $width, int $height) {
        // Definindo as posições e dimensões
        $this->position($x, $y);
        $this->dimension($width, $height);
    }

    public function newPage() {
        $this->html .= "<pagebreak>";
    }

    /**
     * @param string $message 
    */
    public function writePDF($text) {

        $this->html .= '<div style="';
        
        // Posicionamento
        $this->html .= 'position: absolute;';
        $this->html .= 'left: ' . $this->x . 'px;';
        $this->html .= 'top: ' . $this->y . 'px;';
        $this->html .= 'width: ' . $this->width . 'px;';
        $this->html .= 'height: ' . $this->height . 'px;';

        // Alinhar texto
        $this->html .= 'text-align: ' . $this->align . ';';

        // Cores
        $this->html .= 'color: ' . $this->color . ';';
        $this->html .= 'background-color: ' . $this->background . ';';
        
        // Fontes
        $this->html .= 'font-family: ' . $this->fontFamily . ';';
        $this->html .= 'font-size: ' . $this->fontSize . ';';
        $this->html .= 'font-weight: ' . $this->fontType . ';';

        // Mostrar contorno do box
        if($this->showAreas) {
            $this->html .= 'box-shadow: inset 0px 0px 0px 1px black';
        }

        $this->html .= '">' . $text . '</div>';
    }

    public function presentPDF() {
        $this->pdf->writeHtml($this->html);
        $this->pdf->Output();
    }

    /**
     * @param array $permissions
     * @param string @password 
    */
    public function setPermissions(array $permissions = [], string $password = "") {
        // Definir permississões para o pdf
        $this->pdf->SetProtection($permissions, $password);
    }

    /**
     * @param string $name 
    */
    public function savePDF(string $name) {
        // Salvar o arquivo pdf com um nome
        $this->pdf->writeHtml($this->html);
        $this->pdf->Output(PDF_PATH . $name);
    }

}