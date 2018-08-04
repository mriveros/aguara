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
	$this->Line(343,236,15,236);//largor,ubicacion derecha,inicio,ubicacion izquierda
    // Go to 1.5 cm from bottom
        $this->SetY(-15);
    // Select Arial italic 8
        $this->SetFont('Arial','I',8);
    // Print centered page number
	$this->Cell(0,2,utf8_decode('Página: ').$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,234,'Consulta Generada: '.date('d-M-Y').' '.date('h:i:s'));
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
    
    $this->SetFont('Arial','B',8);
    $this->SetTitle('Resumen De Reservas');
    $this->Cell(300,5,'NOCTUA NIGTH CLUB',100,100,'C');//Titulo
    $this->SetFillColor(153,192,141);
    $this->SetTextColor(255);
    $this->SetDrawColor(153,192,141);
    $this->SetLineWidth(.3);
    /*$this->Cell(20,10,'SIAPE',1,0,'L',1);
    $this->Cell(50,10,'Nome',1,1,'L',1);*/
    
    $this->Cell(25,10,'Item',1,0,'C',1);
    $this->Cell(40,10,'Nombre',1,0,'C',1);
    $this->Cell(90,10,'Observaciones',1,0,'C',1);
    $this->Cell(40,10,'Evento',1,0,'C',1);
    $this->Cell(30,10,'Fecha',1,0,'C',1);
    $this->Cell(25,10,'Activo',1,0,'C',1);
    $this->Cell(25,10,'Confirmado',1,0,'C',1);
    $this->Cell(30,10,'Telefono',1,1,'C',1);
   


//Restore font and colors


}
}

$pdf=new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'
//obtener el nombre de organismo------------------------------------------------
//QUERY and data cargue y se reciben los datos

if  (empty($_POST['txtDesdeFecha'])){$fechadesde=0;}else{$fechadesde=$_POST['txtDesdeFecha'];}
if  (empty($_POST['txtHastaFecha'])){$fechahasta=0;}else{$fechahasta=$_POST['txtHastaFecha'];}

  $mes=substr($fechadesde, 5, 2);
//------------------------------------------------------------------------------      
$pdf->AddPage('L', 'Legal');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',10);


//Set font and colors




$conectate=pg_connect("host=localhost port=5432 dbname='aguara' user='postgres' password='postgres'")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"SELECT res.res_cod,res.res_nom,res.res_obs,to_char(res.res_fecha,'DD/MM/YYYY')as res_fecha,res.res_activo,res.res_confirm,res.res_telefono,eve.eve_nom,eve.eve_cod 
                    from reservas res, eventos eve
                    where res.res_cod=eve.eve_cod
                    and res.res_fecha >= '$fechadesde' and res.res_fecha<='$fechahasta' and res.res_confirm='f' order by res_fecha ");

$numregs=pg_numrows($consulta);
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
//Build table
$fill=false;
$i=0;
while($i<$numregs)
{
    
   
    $nombre=pg_result($consulta,$i,'res_nom');
    $observaciones=pg_result($consulta,$i,'res_obs');
    $evento=pg_result($consulta,$i,'eve_nom');
    $fecha=pg_result($consulta,$i,'res_fecha');
    $activo=pg_result($consulta,$i,'res_activo');
    $confirmado=pg_result($consulta,$i,'res_confirm');
    $telefono=pg_result($consulta,$i,'res_telefono');
   
   
  
    
   
     
    $pdf->Cell(25,5,$i+1,1,0,'C',$fill);
    $pdf->Cell(40,5,$nombre,1,0,'L',$fill);
    $pdf->Cell(90,5,$observaciones,1,0,'C',$fill);
    $pdf->Cell(40,5,$evento,1,0,'L',$fill);
    $pdf->Cell(30,5,$fecha,1,0,'C',$fill);
    if($activo=='t'){$activo='Activo';}else{$activo='Inactivo';}
    $pdf->Cell(25,5,$activo,1,0,'C',$fill);
    if($confirmado=='t'){$confirmado='Confirmado';}else{$confirmado='Rechazado';}
    $pdf->Cell(25,5,$confirmado,1,0,'L',$fill);
    $pdf->Cell(30,5,$telefono,1,1,'C',$fill);
   
    

   
    $fill=!$fill;
    $i++;
}

/*
 * 
 * 
 * Aqui haremos las consultas para los totales
 * 
 * 
 */



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
ob_end_clean();
$pdf->Output();
$pdf->Close();
// generamos los meses 
function genMonth_Text($m) { 
 switch ($m) { 
  case '01': $month_text = "Enero"; break; 
  case '02': $month_text = "Febrero"; break; 
  case '03': $month_text = "Marzo"; break; 
  case '04': $month_text = "Abril"; break; 
  case '05': $month_text = "Mayo"; break; 
  case '06': $month_text = "Junio"; break; 
  case '07': $month_text = "Julio"; break; 
  case '08': $month_text = "Agosto"; break; 
  case '09': $month_text = "Septiembre"; break; 
  case '10': $month_text = "Octubre"; break; 
  case '11': $month_text = "Noviembre"; break; 
  case '12': $month_text = "Diciembre"; break; 
 } 
 return ($month_text); 
} 
?>