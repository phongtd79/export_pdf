<?php 

include('lib/TCPDF/tcpdf.php');
include('data.php');




class MYPDF extends TCPDF {
    // Page footer
    
    public function Footer() {
        // Position at 15 mm from bottom
        $fontDefault = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetY(-25);
        // Set font
        $this->SetFont($fontDefault, '', 12);
        // Page number
        // $style = array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $style = array(
            'T' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
            
         );
        $this->Cell(0, 10, 'Numerology - Năng lượng số', $style, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function CustomTitle($text, $font, $size, $align = 'C', $color = array(0, 0, 0)) {
        $fontDefault = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetTextColor($color[0], $color[1], $color[2]);
        $this->SetFont($font, 'B', $size);
        $this->setCellPaddings(5);
        $this->Write(0, $text, '', 0, $align, true, 0, false, false, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($fontDefault, '', 12);
    }

    public function ParagraphItalic($text, $font, $size, $style, $color = array(0 ,0 ,0)) {
        $fontDefault = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetTextColor($color[0], $color[0], $color[0]);
        $this->SetFont($font, $style, $size);
        $this->writeHTML($text, true, false, true, false, '');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($fontDefault, '', 12);
    }
}

//make TCPDF object
$pdf = new MYPDF('P','mm','LETTER', true, 'UTF-8', false);


//remove defualt header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true); 

// set margins
$pdf->SetMargins(25, 20, 18, true);
// $pdf->SetHeaderMargin(20);
// $pdf->SetFooterMargin(20);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, 20);

//add content (student list)
//title
// $font = $pdf->addTTFfont('font/SVN-Arial/SVN-Arial Regular.ttf')
$font = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
$font_italic = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2 italic.ttf');
$font_IB = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2 bold italic.ttf');
$pdf->SetFont($font, 'B', 14);
$pdf->setCellHeightRatio(1.4);
// $pdf->SetTextColor();

// 1



// $pdf->AddPage();
$title = array(
    "1. Số Đường Đời",
    "2. Số Thái Độ",
    "3. Số Ngày Sinh",
    "4. Số Vận Mệnh",
    "5. Số Linh Hồn",
    "6. Số Nhân Cách",
    "7. Số Trưởng Thành",
    "8. Số Lặp",
);

$text = "
<p style='text-align: justify;'><b>Con số đường đời được tính toán dựa trên ngày sinh dương lịch của 
chúng ta (giống như biểu đồ ngày sinh trong chiêm tinh), vì vậy chúng ta có 
thể coi con số đường đời như một loại dấu hiệu hoàng đạo của Năng lượng số. 
Những con số này nói lên giá trị cốt lõi, phương thức hoạt động và sứ mệnh tổng 
thể của chúng ta trong cuộc sống. Mỗi con số được liên kết với những phẩm chất, 
điểm mạnh và điểm yếu duy nhất - và chúng được cho là có ý nghĩa sâu sắc và có ảnh 
hưởng lớn đến các con đường của chúng ta trong cuộc sống</b></p>
";

$serial = 0;

// for ($i = 1; $i <= 15; $i++) {
//     $pdf->AddPage();
    
//     if ($i % 2 != 0) {
//         $pdf->CustomTitle($title[$serial], $font, 18);
//         $serial++;
//         $pdf->Image('image/sobanmenh'.$serial.'.jpg', 0, 40, 220, '', 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
//         $pdf->Ln($pdf->getImageRBY()-22);
//         $pdf->ParagraphItalic($text, $font_italic, 14, '', array(0,0,0));
 
//         // $pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
//     } else {
//         // $pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
//     }   
// }






// $pdf->AddPage();
// $pdf->Bookmark('Chapter 1', 0, 0, '', 'B', array(0,64,128));
// $pdf->SetFont($font, '', 12);
// $pdf->setPrintFooter(false);
// $pdf->SetAutoPageBreak(false, 0);
// $pdf->Image('image/vs-logo.jpg', 165, 20, 35, 35, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
// $pdf->Image('image/foreword-img-2.png', 0, 170, 220, 69.3, 'PNG', '', '', true, 200, '', false, false, 0, false, false, false);
// $pdf->Image('image/background.jpg', 60, 55, 100, 130, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
// $pdf->Image('image/ios-qr.png', 108, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);
// $pdf->Image('image/android-qr.png', 0, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);

// $html = '<p style="font-size: 16px"><b>Công ty Cổ phần Khởi Nghiệp Việt<br/>
// Email: vstartup@gmail.com<br/>
// numerologyleo@gmail.com<br/>
// SĐT: 0901.508.999 - 0867.880.577<b/></p>';

// $pdf->writeHTML($html, true, false, true, false,'');
// $pdf->Ln(165);

// $html = 'Quét mã cài đặt app';
// $pdf->SetFont($font, 'B', 28);
// $pdf->Write(0, $html, '', false, 'C', true);



$pdf->AddPage();
                $tbl = <<<EOD
                <h1>BIỂU ĐỒ NGÀY SINH</h1>
                <table style="text-align: center;" cellspacing="0" cellpadding="5" border="0.5">
                <tr>
                <td >COL 1 - ROW 1</td>
                <td >COL 2 - ROW 1</td>
                <td >COL 3 - ROW 1</td>
                </tr>
                <tr>
                <td >COL 1 - ROW 2</td>
                <td >COL 2 - ROW 2</td>
                <td >COL 3 - ROW 2</td>
                </tr>
                <tr>
                <td >COL 1 - ROW 3</td>
                <td >COL 2 - ROW 3</td>
                <td >COL 3 - ROW 3</td>
                </tr>
                </table>
                EOD;
                $pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);

$pdf->writeHTMLCell(100,50,20,0,$tbl,0,false, false, true, 'C');
// $pdf->writeHTML($tbl, true, false, false, false, 'C');


$pdf->AddPage();
$html='<h1>BIỂU ĐỒ TÊN</h1>';
$pdf->writeHTML($html, true, false, false, false, 'C');
$tbl = <<<EOD
<h1>BIỂU ĐỒ TÊN</h1>
<table style="text-align: center;" width="100%" cellspacing="0" cellpadding="8" border="0.5">
    <tr>
        <th colspan="2" width="40%">Loại</th>
        <th colspan="6" width="60%">Đặc điểm</th>    
    </tr>
    <tr>
        <td>Thể chất</td>
        <td style="background-color: #FF8C00;">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td >Tinh thần</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td >Cảm xúc</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td >Trực giác</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td >Tổng</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, 'C');







// $pdf->Arrow($x0 = 200, $y0 = 280, $x1 = 190, $y1 = 263, $head_style = 1, $arm_size = 5, $arm_angle = 15);
// $pdf->Arrow($x0 = 200, $y0 = 280, $x1 = 195, $y1 = 261, $head_style = 2, $arm_size = 5, $arm_angle = 15);
// $pdf->Arrow($x0 = 200, $y0 = 280, $x1 = 200, $y1 = 260, $head_style = 3, $arm_size = 5, $arm_angle = 15);

// Create a fixed link to the first page using the * character



// fixed link to the first page using the * character


// add some pages and bookmarks
// $title = array(
//     "1. Số Đường Đời",
//     "2. Số Thái Độ",
//     "3. Số Ngày Sinh",
//     "4. Số Vận Mệnh",
//     "5. Số Linh Hồn",
//     "6. Số Nhân Cách",
//     "7. Số Trưởng Thành",
//     "8. Số Lặp",
// );
// $serial = 0;
// for ($i = 1; $i <= 15; $i++) {
//     $pdf->AddPage();
//     $pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
 
//     if ($i % 2 != 0) {
//         $pdf->CustomTitle2($title[$serial], $font, 18);
//         // echo $title[$serial];
//         $serial++;
//         $pdf->Image('image/sobanmenh'.$serial.'.jpg', 0, 40, 220, '', 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
//         // echo $pdf->getImageRBY().'------------';
//     }
// }

// . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .


// $pdf->addTOCPage();

// // write the TOC title
// $pdf->SetFont('times', 'B', 16);
// $pdf->MultiCell(0, 0, 'Table Of Content', 0, 'C', 0, 1, '', '', true, 0);
// $pdf->Ln();

// $pdf->SetFont('dejavusans', '', 12);

// // add a simple Table Of Content at first page
// // (check the example n. 59 for the HTML version)
// $pdf->addTOC(1, 'courier', '.', 'INDEX', 'B', array(128,0,0));

// // end of TOC page
// $pdf->endTOCPage();


$pdf->Output();
?>