<?php 
session_start();
?>
<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br

require('fpdf.php');

class PDF extends FPDF{
function Footer()
{
        
       
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(230,280,9,280);//largor,ubicacion derecha,inicio,ubicacion izquierda
    // Go to 1.5 cm from bottom
        $this->SetY(-15);
    // Select Arial italic 8
        $this->SetFont('Arial','I',8);
    // Print centered page number
	$this->Cell(0,2,utf8_decode('Página: ').$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,283,'Datos Generados en: '.date('d-M-Y').' '.date('h:i:s'));
}

function Header()
{
     // Select Arial bold 15
        $this->SetFont('Arial','',9);
	$this->Image('img/noctua_ico.jpeg',15,10,-300,0,'','../../InformeCargos.php');
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(15,32,utf8_decode('Noctua Nigth Club - Pilar'));
	$this->text(300,32,'Sistema Servidor de Aplicaciones Moviles');
        //$this->text(315,37,'Mes: '.utf8_decode(genMonth_Text($mes).' Año: 2016'));
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(30);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(360 ,33,10,33);//largor,ubicacion derecha,inicio,ubicacion izquierda
//table header     
    //-----------------------TRAEMOS LOS DATOS DE CABECERA----------------------
   
  
    //------------------------RECIBIMOS LOS VALORES DE POST-----------
    if  (empty($_POST['txtDesdeFecha'])){$desde='';}else{ $desde= $_POST['txtDesdeFecha'];}
    if  (empty($_POST['txtHastaFecha'])){$hasta='';}else{ $hasta= $_POST['txtHastaFecha'];}
    //table header CABECERA        
    $this->SetFont('Arial','B',12);
    $this->SetTitle('Resumen de Reservas');
    $this->text(55,50,'NOCTUA NIGTH CLUB');
    $this->text(65,60,'Ranking de Reservas');
    $this->text(10,75,'DESDE FECHA:');
    $this->text(45,75,$desde);
    $this->text(10,85,'HASTA FECHA:');
    $this->text(45,85,$hasta);
    
}
}
$pdf= new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'
$pdf->AddPage();
//------------------------RECIBIMOS LOS VALORES DE POST-----------
    if  (empty($_POST['txtDesdeFecha'])){$desde='';}else{ $desde= $_POST['txtDesdeFecha'];}
    if  (empty($_POST['txtHastaFecha'])){$hasta='';}else{ $hasta= $_POST['txtHastaFecha'];}
    
//-------------------------Damos formato al informe-----------------------------    
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
    
//----------------------------Build table---------------------------------------
$pdf->SetXY(10,100);
$pdf->Cell(40,10,'Cantidad',1,0,'C',50);
$pdf->Cell(40,10,'Aprobados',1,0,'C',50);
$pdf->Cell(40,10,'Reprobados',1,0,'C',50);
$pdf->Cell(40,10,'Clausurados',1,1,'C',50);
$fill=false;
$i=0;
$pdf->SetFont('Arial','',10);

//------------------------QUERY and data cargue y se reciben los datos-----------
$conectate=pg_connect("host=localhost port=5432 dbname=estaciones user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"select max(eve.eve_nom)as eve_nom, sum(eve.eve_) as cantidad,sum(reg.reg_aprob)as aprobado, sum(reg.reg_reprob) as reprobado, 
sum(reg.reg_claus) as clausurado
from registros reg,usuarios usu,clientes cli 
where reg.cli_cod=cli.cli_cod 
and reg.usu_cod=usu.usu_cod 
and reg.reg_fecha >=  '$desde'
and reg.reg_fecha <= '$hasta'");
$numregs=pg_numrows($consulta);
while($i<$numregs)
{   
    $cantidad=pg_result($consulta,$i,'cantidad');
    $aproba=pg_result($consulta,$i,'aprobado');
    $reprob=pg_result($consulta,$i,'reprobado');
    $claus=pg_result($consulta,$i,'clausurado');
    $pdf->Cell(40,5,$cantidad,1,0,'C',$fill);
    $pdf->Cell(40,5,$aproba,1,0,'C',$fill);
    $pdf->Cell(40,5,$reprob,1,0,'C',$fill);
    $pdf->Cell(40,5,$claus,1,1,'C',$fill);
    $fill=!$fill;
    $i++;
}

//Add a rectangle, a line, a logo and some text
/*
$pdf->Rect(5,5,170,80);
$pdf->Line(5,90,90,90);
//$pdf->Image('mouse.jpg',185,5,10,0,'JPG','http://www.dnocs.gov.br');
$pdf->SetFillColor(224,235);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,95);
$pdf->Cell(170,5,'PDF gerado via PHP acessando banco de dados - Por Ribamar FS',1,1,'L',1,'mailto:ribafs@dnocs.gov.br');
*/
$pdf->Output();
$pdf->Close();
?>