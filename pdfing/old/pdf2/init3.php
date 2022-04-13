<?php

// your variables

$text = "TOP SECRETdsakj ldsakj dklsa dklsajd lksa djlksadj salkds alkdsaj k";

$fontColor = array(255/255, 0/255, 0/255);

$outlineColor = array(255/255, 0/255, 0/255);

$opacity = 0.5;

$encryption = false;

$permission = "";

$ownerPassword = "";

$userPassword = "";

$filename = "embedded-font.pdf";



require_once("library/SetaPDF/Autoload.php");

// create a file writer

$writer = new SetaPDF_Core_Writer_File("stamper-watermark-demo.pdf");

// load document by filename

$document = SetaPDF_Core_Document::loadByFilename($filename, $writer);



// create a stamper instance for the document

$stamper = new SetaPDF_Stamper($document);



// create a font for this document

$font = SetaPDF_Core_Font_Standard_Helvetica::create($document);

// create a stamp with the created font and font size 120

$stamp = new SetaPDF_Stamper_Stamp_Text($font, 120);



// center the text to the text block

$stamp->setAlign(SetaPDF_Core_Text::ALIGN_CENTER);

// set text for the stamp

$stamp->setText($text);



// set text color to your chosen color

// all color definitions need to be between 0 and 1

$stamp->setTextColor($fontColor);



// rendering mode on "Fill, then stroke text."

// for more rendering modes look pdf-reference PDF32000-1:2008 9.3.6

$stamp->setRenderingMode(2);

// set outline width to 0.5 (default is 1)

$stamp->setOutlineWidth(0.5);

// set color to your chosen color

$stamp->setOutlineColor($outlineColor);



// set the opacity, need to be between 0 and 1

$stamp->setOpacity($opacity);



// add the stamp to the stamper on every page

// at the position center_middle

// rotated by 60 degrees

$stamper->addStamp($stamp, SetaPDF_Stamper::POSITION_CENTER_MIDDLE, SetaPDF_Stamper::PAGES_ALL, 0, 0, 60);



// stamp the document

$stamper->stamp();

// save the file and finish the writer (e.g. file handler will closed)

$document->save()->finish();


