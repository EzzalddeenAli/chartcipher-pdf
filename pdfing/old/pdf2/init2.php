<? require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');

class WaterMark

{
    public $pdf, $file, $newFile,
        $wmText = "testing company";

/** $file and $newFile have to include the full path. */
public function __construct($file, $newFile)
{
    $this->pdf = new FPDI();
    $this->file = $file;
    $this->newFile = $newFile;
}

/** $file and $newFile have to include the full path. */
public static function applyAndSpit($file, $newFile)
{
    $wm = new WaterMark($file, $newFile);

    if($wm->isWaterMarked())
        return $wm->spitWaterMarked();
    else{
        $wm->doWaterMark();
        return $wm->spitWaterMarked();
    }
}

/** @todo Make the text nicer and add to all pages */
public function doWaterMark()
{
    $currentFile = $this->file;
    $newFile = $this->newFile;

    $pagecount = $this->pdf->setSourceFile($currentFile);

    for($i = 1; $i <= $pagecount; $i++){
        $this->pdf->addPage();//<- moved from outside loop
        $tplidx = $this->pdf->importPage($i);
//        $this->pdf->useTemplate($tplidx);
            $size = $this->pdf->getTemplateSize($tplidx);
        $this->pdf->useTemplate($tplidx, null, null, $size['w'], $size['h'], true);
//now write some text above the imported page
        $this->pdf->SetFont('Arial', 'I', 40);
//	$this->pdf->Image('e.png');

//        $this->pdf->SetTextColor(255,0,0);
//        $this->pdf->SetXY(25, 135);
//        $this->_rotate(55);
//        $this->pdf->Write(0, $this->wmText);
//        $this->_rotate(0);//<-added
    }

    $this->pdf->Output($newFile, 'F');
}

public function isWaterMarked()
{
    return (file_exists($this->newFile));
}

public function spitWaterMarked()
{
    return readfile($this->newFile);
}

protected function _rotate($angle,$x=-1,$y=-1) {

    if($x==-1)
        $x=$this->pdf->x;
    if($y==-1)
        $y=$this->pdf->y;
    if($this->pdf->angle!=0)
        $this->pdf->_out('Q');
    $this->pdf->angle=$angle;

    if($angle!=0){
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->pdf->k;
        $cy=($this->pdf->h-$y)*$this->pdf->k;

        $this->pdf->_out(sprintf(
            'q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',
            $c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
    } 

}
header('Content-type: application/pdf');
//header('Content-Disposition: attachment; filename="downloaded.pdf"');
WaterMark::applyAndSpit('embedded.pdf','embedded' . time(). '.pdf');
?>
