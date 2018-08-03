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
	$this->Cell(0,2,iconv("ISO-8859-1", "UTF-8",'Página: ').$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,283,'Datos Generados en: '.date('d-M-Y').' '.date('h:i:s'));
}

function Header()
{
   // Select Arial bold 15
    $this->SetFont('Arial','',16);
    $this->Image('img/logo.gif',10,14,-300,0,'','');
    // Move to the right
    $this->Cell(80);
    // Framed title
    $this->text(45,19,iconv("ISO-8859-1", "UTF-8",'CENTRO DE FONOAUDIOLOGIA INTEGRAL'));
    $this->SetFont('Arial','',8);
    $this->text(50,24,"Avda. Gral. Artigas 3973 c/ Gral Roa- Tel.: (59521)290 160 -Fax: (595921) 290 873 ");
    $this->text(53,29,"Telefax: (595921) 295 408 e-mail: fono@fonoaudiointegral.gov.py");
    //-----------------------TRAEMOS LOS DATOS DE CABECERA----------------------
   
    //---------------------------------------------------------
    $this->Ln(30);
    $this->Ln(30);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(200,40,10,40);//largor,ubicacion derecha,inicio,ubicacion izquierda
    //------------------------RECIBIMOS LOS VALORES DE POST-----------
    if  (empty($_POST['desde_fecha'])){$desde='';}else{ $desde= $_POST['desde_fecha'];}
    if  (empty($_POST['hasta_fecha'])){$hasta='';}else{ $hasta= $_POST['hasta_fecha'];}
    //table header CABECERA        
    $this->SetFont('Arial','B',12);
    $this->SetTitle('Estadisticas Enfermedades');
    $this->text(67,50,'INFORMES DE ESTADISTICAS');
    $this->text(55,60,'Resumen de Estadisticas de Enfermedades');
    $this->text(20,75,'Desde Fecha:');
    $this->text(48,75,$desde);
    $this->text(20,85,'Hasta Fecha:');
    $this->text(48,85,$hasta);
    
}
}
$pdf= new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'
$pdf->AddPage();
//------------------------RECIBIMOS LOS VALORES DE POST-----------
    if  (empty($_POST['desde_fecha'])){$desde='';}else{ $desde= $_POST['desde_fecha'];}
    if  (empty($_POST['hasta_fecha'])){$hasta='';}else{ $hasta= $_POST['hasta_fecha'];}
    $desde= date("Y-m-d", strtotime($desde));
    $hasta= date("Y-m-d", strtotime($hasta));
    
//-------------------------Damos formato al informe-----------------------------    
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
    
//----------------------------Build table---------------------------------------
$pdf->SetXY(45,100);
$pdf->Cell(45,10,'Enfermedad',1,0,'C',50);
$pdf->Cell(45,10,'Cantidad',1,0,'C',50);
$pdf->Cell(45,10,'Porcentaje',1,1,'C',50);
$fill=false;
$i=0;
$pdf->SetFont('Arial','',10);

//------------------------QUERY and data cargue y se reciben los datos-----------
$conectate=pg_connect("host=localhost port=5432 dbname=consulta user=postgres password="
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"Select max(enf.enf_nom) as enfermedad, count(hp.enf_cod) as cantidad 
from hist_pacnt hp, cita_cnslt cc, enfermedad enf
where hp.id_cita = cc.id_cita 
and hp.enf_cod= enf.enf_cod
and cc.fecha_cita >= '$desde'
and cc.fecha_cita <= '$hasta'
group by enf.enf_cod
order by cantidad DESC");
$numregs=pg_numrows($consulta);
$index=0;

while($index<$numregs)
{  
   $cantidad=pg_result($consulta,$index,'cantidad');
   $total= $total + $cantidad;
   $index++;
}
while($i<$numregs)
{   
    $pdf->SetX(45);
    $enfermedad=pg_result($consulta,$i,'enfermedad');
    $cantidad=pg_result($consulta,$i,'cantidad');
    $porcentaje=pg_result($consulta,$i,'cantidad');
    $pdf->Cell(45,5,$enfermedad,1,0,'C',$fill);
    $pdf->Cell(45,5,$cantidad,1,0,'C',$fill);
    $pdf->Cell(45,5,number_format((($cantidad*100)/$total) ,2 ).'%' ,1,1,'C',$fill);
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