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
    if  (empty($_POST['pac_cedula'])){$pac_cedula='';}else{ $pac_cedula= $_POST['pac_cedula'];}
    if  (empty($_POST['desde_fecha'])){$desde='';}else{ $desde= $_POST['desde_fecha'];}
    if  (empty($_POST['hasta_fecha'])){$hasta='';}else{ $hasta= $_POST['hasta_fecha'];}
    $conectate=pg_connect("host=localhost port=5432 dbname=consulta user=postgres password="
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"Select pac.id_pacnt, pac.nom_pacnt || ' ' || pac.apel_pacnt as nombres from pacnt_cnslt pac where pac.ci_pacnt =$pac_cedula");
$nombres =pg_result($consulta,0,'nombres');
    //table header CABECERA        
    $this->SetFont('Arial','B',12);
    $this->SetTitle('Historial');
    $this->text(48,50,'INFORMES DE HISTORIALES POR RANGO DE FECHAS');
    $this->text(75,60,'Resumen de Pacientes');
    $this->text(20,75,'Paciente:');
    $this->text(48,75,$nombres);
    
    }
}
$pdf= new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'
$pdf->AddPage();
//------------------------RECIBIMOS LOS VALORES DE POST-----------
   if  (empty($_POST['pac_cedula'])){$pac_cedula='';}else{ $pac_cedula= $_POST['pac_cedula'];}
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
$pdf->SetXY(10,100);
$pdf->Cell(45,10,'Fecha Consulta',1,0,'C',50);
$pdf->Cell(45,10,'Enfermedad',1,0,'C',50);
$pdf->Cell(100,10,'Diagnostico',1,1,'C',50);
$fill=false;
$i=0;
$pdf->SetFont('Arial','',9);

//------------------------QUERY and data cargue y se reciben los datos-----------
$conectate=pg_connect("host=localhost port=5432 dbname=consulta user=postgres password="
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"Select hp.id_cita, pac.id_pacnt,
cit.fecha_cita as fecha_consulta, 
pac.nom_pacnt as nombre, 
pac.apel_pacnt as apellido,
pac.dir_pacnt as direccion, 
enf.enf_nom as enfermedad, 
hp.diagnostico,
hp.enf_cod 
from hist_pacnt hp, cita_cnslt cc, enfermedad enf, pacnt_cnslt pac, cita_cnslt cit
where hp.id_cita = cc.id_cita 
and hp.enf_cod= enf.enf_cod
and pac.ci_pacnt=hp.ci_pacnt_hist
and hp.id_cita=cit.id_cita
and cc.fecha_cita >= '$desde'
and cc.fecha_cita <= '$hasta'
and pac.ci_pacnt =$pac_cedula");
$numregs=pg_numrows($consulta);
while($i<$numregs)
{   
    $pdf->SetX(10);
    $fecha =pg_result($consulta,$i,'fecha_consulta');
    $enfermedad =pg_result($consulta,$i,'enfermedad');
    $diagnostico =pg_result($consulta,$i,'diagnostico');
    $pdf->Cell(45,5,$fecha,1,0,'C',$fill);
    $pdf->Cell(45,5,$enfermedad,1,0,'L',$fill);
    $pdf->Cell(100,5,$diagnostico,1,1,'L',$fill);
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