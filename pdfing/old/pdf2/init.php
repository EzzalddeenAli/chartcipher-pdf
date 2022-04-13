<? require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');

$url = $_SERVER["REQUEST_URI"];

$parsed = parse_url( $url );
$fullfile = ".". $parsed["path"];
$file = basename( $fullfile );

class WaterMark

{
    public $pdf, $file, $newFile,        $wmText;
var $angle=0;

/** $file and $newFile have to include the full path. */
    public function __construct($file, $newFile, $text)
{
    $this->pdf = new FPDI();
    $this->file = $file;
    $this->newFile = $newFile;
    $this->wmText = $text;
}

/** $file and $newFile have to include the full path. */
    public static function applyAndSpit($file, $newFile, $text)
{
    $wm = new WaterMark($file, $newFile, $text);

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

        $this->pdf->useTemplate($tplidx, 0, 0, 210);
        // now write some text above the imported page
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetXY(25, 255);
//        $this->_rotate(55);
        $this->pdf->Write(0, $this->wmText);
//        $this->_rotate(0);//<-added
//	$this->RotatedText( 300, 300, "help", 55 );
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
}
 $fullfile = $file;
// echo( $fullfile );exit;
header('Content-type: application/pdf');
//header('Content-Disposition: attachment; filename="downloaded.pdf"');
if( isset( $_GET["watermark"] ) )
{
    WaterMark::applyAndSpit($fullfile,str_replace( ".pdf", time(). ".pdf", $file ), $_GET["watermark"]);
}
else
{
    return readfile( $fullfile );
}
?>
