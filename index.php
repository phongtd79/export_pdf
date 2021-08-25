<?php 
include('lib/TCPDF/tcpdf.php');

class MYPDF extends TCPDF {
    // Page footer
    
    public function Footer() {
        // Position at 15 mm from bottom
        $font = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetY(-20);
        // Set font
        $this->SetFont($font, '', 12);
        // Page number
        $this->Cell(0, 10, 'Numerology - Năng lượng số', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function ConfigDefault() {
        $fontDefault = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($fontDefault, '', 12);
    }

    public function CustomTitle($text, $font, $size, $align = 'C', $color = array(0, 0, 0), $backDefault = true) {
        $this->SetTextColor($color[0], $color[1], $color[2]);
        $this->SetFont($font, 'B', $size);
        $this->Write(0, $text, '', 0, $align, true, 0, false, false, 0);

        if($backDefault) 
            $this->ConfigDefault();
    }

    public function CellImageBorder($img, $img_type, $txt, $h, $w, $x, $y, $font, $colorTxt = array(0, 0, 0)) {
        $this->setCellPaddings(8, 5, 1, 1);
        $this->SetLineStyle(array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $this->SetFont($font, 'B', 16);
        $this->SetTextColor($colorTxt[0], $colorTxt[1], $colorTxt[2]);
        $this->Image($img.'.'.$img_type, $x, $y, $h, $w, 'PNG', '', '', true, 300, '', false, false, 0, false, false, false);
        $this->RoundedRect($x, $y, $h, $w, 5.4, '1111');
        $this->MultiCell($h, $w, $txt, 0, 'C', 0, 1, $x-2, $y-2, true);
        $this->setCellPaddings(1, 1, 1, 1);
    }

    public function PrintBgFullPage($bgImg, $bookMark = false, $txt = '', $level = 0, $page = '', $color = array(0,0,0)) {
        $this->AddPage();
        if($bookMark) 
            $this->Bookmark($txt, $level, 0, $page, 'B', $color);

        $this->setPrintFooter(false);
        // $pdf->Image('image/book.jpg', 0, 0, 0, 0, 'JPG', '', '', true);
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->getAutoPageBreak();
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set background image
        $this->Image($bgImg, -1, 0, 218, 279.5, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    public function ParagraphItalic($text, $font, $size, $style, $color = array(0 ,0 ,0), $backDefault = true) {
        $this->setCellHeightRatio(1);
        $this->SetTextColor($color[0], $color[1], $color[2]);
        $this->SetFont($font, $style, $size);
        $this->writeHTML($text, true, false, true, false, '');

        if($backDefault) 
            $this->ConfigDefault();
    }

    public function PrintPart($start, $end, $listTitle, $listContent, $fontTitle, $fontCotent) {
        $this->setPrintFooter(true);
        $text = '';
        for ($i = $start; $i <= $end; $i++) {
            $this->AddPage();
            $this->Bookmark($listTitle[$i], 1, 0, '', '');
            $text = '<p style="text-align: justify;">'.$listContent[$i].'</p>';

            $this->Image('image/arrow-head.png', 16, 13, strlen($listTitle[$i]) * 2.5  + 30, 25, 'png', '', '', true);
            $this->setCellPaddings(5, 1, 1, 1);
            $this->CustomTitle($listTitle[$i], $fontTitle, 18, 'L', array(255, 255, 255), false);

            $this->Image('image/sobanmenh'.($i + 1).'.jpg', 0, 40, 220, '', 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
            $this->Ln($this->getImageRBY()-21);
            $this->ParagraphItalic($text, $fontCotent, 14, '', array(111,47,159), false);
            
            if ($i != $end) {
                $this->AddPage();
                $this->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
            }
        }
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
// $pdf->SetFooterMargin(25);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, 20);

//add content (student list)
//title
// $font = $pdf->addTTFfont('font/SVN-Arial/SVN-Arial Regular.ttf')
$font = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
$font_italic = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2 italic.ttf');
$font_IB = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2 bold italic.ttf');
$bungee_shade = TCPDF_FONTS::addTTFfont('font/BungeeShade/BungeeShade-Regular.ttf');
$pdf->SetFont($font, '', 12);
$pdf->setCellHeightRatio(1.4);
// $pdf->SetTextColor();






// ------------------------------- BEGIN PAGE 1 --------------------------------------
// -----------------------------------------------------------------------------------
$pdf->AddPage();
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->Image('image/ceo.jpg',  124, 15, 92.5, 92.5, 'JPG', '', '', true);


$regions = array(
    array('page' => '', 'xt' => 123, 'yt' =>  20, 'xb' => 123, 'yb' =>  110, 'side' => 'R'),
);
    
// set page regions, check also getPageRegions(), addPageRegion() and removePageRegion()
$pdf->setPageRegions($regions);

$pdf->CustomTitle("GIỚI THIỆU VỀ", $font, 23, 'C', array(88,12,109));
$pdf->CustomTitle("NHÀ SÁNG LẬP", $font, 23, 'C', array(88,12,109));
$pdf->Ln(5, false);

$html = '
    <p style="text-align:justify;font-size:12px"><b>Nhà sáng lập: Đào Huy Lộc (Leo). 
        Giám đốc Công ty Cổ phần Khởi Nghiệp Việt. 
        Chuyên gia đào tạo và phân tích năng lượng.
        Anh đã nghiên cứu về bộ môn Năng lượng số 
        trong nhiều năm. Với mong muốn giúp mọi 
        người khám phá nhiều hơn về bản thân và cuộc 
        sống xung quanh mình. Anh đã tạo ra Ứng 
        dụng Numerology- Năng lượng số để người sử 
        dụng nhanh chóng tìm ra các con số trong cuộc 
        đời mình.
    <br/>
        Bên cạnh đó, để giúp bạn có một cái nhìn sâu 
        sắc và chi tiết hơn về bộ môn và chính cuộc đời 
        bạn. Anh và đội ngũ của mình tiếp tục cho ra mắt bộ hồ sơ chuyên sâu được thiết kế 
        cho riêng mỗi người</b>
    </p>
    ';
$pdf->writeHTML($html, true, false, true, false,'');

$html = '
    <p style="text-align:justify;">"Tôi biết đến bộ môn này có lẽ là một cơ duyên lớn, lúc đầu chỉ tìm hiểu, cảm thấy thú vị,
        nhưng càng đi sâu vào các tài liệu - đặc biệt là các tài liệu nhiều người trên toàn thế giới
        nghiên cứu và ứng dụng, tôi mới thấy bộ môn này thực sự hữu ích: Trước tiên là giúp bản
        thân mỗi người thấu hiểu mình hơn, sau đó giúp cho các mối quan hệ xung quanh với cha
        mẹ, vợ chồng, con cái, đồng nghiệp... được dễ dàng và thoải mái hơn; không gì hạnh phúc
        hơn khi chúng ta được sống và làm việc khi thấu hiểu lẫn nhau phải không?
        Ngoài ra, tôi liên kết bộ môn này với rất nhiều môn khoa học cơ bản, khoa học tâm linh,
        tâm lý học... khác để mỗi người có cái nhìn toàn diện hơn trong việc áp dụng vào thực tiễn.
        Không có công cụ hay cách thức nào là toàn diện để có một cuộc đời ý nghĩa và hạnh phúc,
        nhưng tôi tự tin rằng, bằng cách đóng góp phần nào giá trị, sẽ rút ngắn được con đường
        khó khăn các bạn đi rất nhiều.
    <br/>
        Chúc mọi người có những trải nghiệm thú vị và hãy đóng góp để Chúng tôi hoàn thiện
        từng ngày công cụ giá trị này.
    <br/>
        Xin cám ơn!"
    </p> 
';
$pdf->writeHTML($html, true, false, true, false,'');

// ------------------------------- END PAGE 1 ----------------------------------------
// -----------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 2 --------------------------------------
// -----------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->Image('image/vs-logo.jpg',  8, 8, 29.8, 28.5, 'JPG', '', '', true, 300, '', false, false, 1);
$pdf->Image('image/numerology-logo.jpg',  164, 8, 45.1, 32.8, 'JPG', '', '', true);


$pdf->CustomTitle("Ứng dụng", $font, 23, 'C', array(88,12,109));
$pdf->CustomTitle("Numerology - Năng lượng số", $font, 23, 'C', array(88,12,109));
$pdf->Ln(5, false);


$html = '
<p style="text-align: justify;">Ngày 1/11/2020 Ứng dụng Numerology- Năng lượng số Ver.1 do Công ty Cổ phần Khởi 
    Nghiệp Việt đầu tư đã chính thức ra mắt cộng đồng. Và là ứng dụng gần như 
    xuất hiện đầu tiên tại Việt Nam đã sở hữu hơn 10.000 lượt tải trên toàn thế giới.
    Sau hơn nửa năm thử nghiệm, Chúng tôi đã ấp ủ lên kế hoạch và tiếp tục cho ra mắt 
    App bản ver 2, và tự tin là ứng dụng sở hữu nhiều chỉ số nhất hiện nay (hơn 35 chỉ số) với những tính năng thu hút và hấp dẫn người dùng.
    <br/>
    Trên ứng dụng này, người dùng có thể:
    <ul class="page2">
        <li>Nhận ra <b>mình là ai, điểm mạnh, điểm yếu và tiềm năng</b> ẩn sâu bên trong.</li>
        <li>Nhận ra <b>sứ mệnh</b> mình cần phải hoàn thiện trong kiếp sống này là gì?</li>
        <li>Định hướng <b>nghề nghiệp</b> tương lai.</li>
        <li><b>Bài học</b> bạn mang theo từ kiếp trước đến kiếp này cần tiếp tục hoàn thiện là gì?</li>
        <li>Những <b>thách thức</b> bạn cần vượt qua là gì?</li>
        <li>Những <b>đỉnh cao cuộc đời</b> cũng là những thành tựu giá trị bạn CÓ THỂ nhận được.</li>
        <li><b>Dự đoán</b> xu hướng qua từng ngày, từng tháng, từng năm để giúp bạn chạm tới các đỉnh cao.</li>
    </ul>
    Ngoài ra bạn còn biết được:
    <ul class="page2">
        <li>Bạn và người ấy có hợp nhau hay không?</li>
        <li>Mối quan hệ giữa các thành viên trong gia đình như thế nào?</li>
        <li>Ý nghĩa những con số “tình cờ” xuất hiện trong cuộc sống của bạn: số điện thoại, biển số xe, số nhà….</li>
        <li>Nhịp sinh học hàng ngày.</li>
        <li>Những thứ giúp bạn lấy lại năng lượng và tinh thần để học tập và làm việc hiệu quả. </li>
    </ul>
    Tất nhiên bạn không chỉ xem được cho bản thân mà còn hiểu được bất cứ ai xung quanh bạn. Giống như một công cụ đọc vị tính cách con người, ứng dụng này bạn có thể sử dụng bất cứ lúc nào, bất cứ nơi đâu. Phù hợp với mọi lứa tuổi và ngành nghề khác nhau.
    <b>NHƯNG</b> đây không chỉ đơn giản là xem các chỉ số. Mà Chúng tôi còn cho phép tất cả người dùng <b>KIẾM TIỀN</b> trên app mà không cần đầu tư bất kì chi phí nào.
    <br/>
    <br/>
    Để khám phá những kiến thức và những điều thú vị. Bạn có thể tải ứng dụng của chúng tôi về máy. Thông tin tải App được cập nhật ở cuối bộ hồ sơ.
</p>
';

$pdf->setHtmlVSpace(array('ul'=>array(0=>array('h'=>0,'n'=>0),1=>array('h'=>0,'n'=>0))));
$pdf->writeHTML($html, true, false, true, false,'');



// ------------------------------- END PAGE 2 --------------------------------------
// ---------------------------------------------------------------------------------





// ------------------------------- BEGIN PAGE 3 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->PrintBgFullPage('image/book.jpg');

// ------------------------------- END PAGE 3 --------------------------------------
// ---------------------------------------------------------------------------------




// ------------------------------- BEGIN PAGE 4 ------------------------------------
// --------------------------------  MUC LUC  --------------------------------------


// ------------------------------- END PAGE 4 --------------------------------------
// ---------------------------------------------------------------------------------




// ------------------------------- BEGIN PAGE 5 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->Bookmark('Lời mở đầu', 0, 0, '', 'B', array(0,0,0));

$pdf->Image('image/foreword-img.png', 0, 190, 220, 69.3, 'PNG', '', '', true, 200, '', false, false, 0, false, false, false);
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->CustomTitle('LỜI MỞ ĐẦU', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->Ln(5, false);


$html = "<p>Bạn thân mến! Cảm ơn bạn đã tin tưởng và lựa chọn Chúng tôi  trở  thành 
người dẫn lối cho bạn đi  tới đúng con đường của mình, cũng như tìm kiếm 
con người  hoàn hảo nhất của mình.</p>";
$pdf->SetFont($font_italic,'',12);
$pdf->writeHTML($html, true, false, true, false,'');

$html = '
    <p style="text-align: justify;">Kể từ khi bạn sinh ra, bạn đã được ấn định sẵn Định Mệnh, đó là những thứ 
        bất biến đã được định trước cho cuộc đời chúng ta, mà chúng ta không thể 
        thay đổi dù bản thân có cố gắng thế nào đi nữa.
        <br/>
        Còn Vận Mệnh, là vận khí theo từng giai đoạn, có thể vui hay sướng, thịnh hay suy, 
        thông suốt hay bế tắc…chúng ta có thể thay đổi nhờ vào nhận thức, lời nói, và hành động. 
        Mệnh được ví như chiếc xe mà bạn đi trong cuộc đời mình, còn Vận chính là cách thức 
        lái xe của bạn. Nếu bạn đang có chiếc xe tốt, đi trên con đường bằng phẳng đầy hoa thơm cỏ lạ, 
        nhưng bạn lại không chuyên tâm lái xe mà mải mê đắm mình vào những thứ trên đường, dễ dẫn đến lái 
        sang một con đường khác, khiến cho cuộc sống trở nên sa ngã, gian truân. 
        <br/>
        Nhưng nếu bạn đang đi trên con đường bùn lầy hay gập ghềnh trên chiếc xe đã cũ, bạn vẫn kiên trì, 
        chăm chỉ, tập trung lái xe, cuộc đời bạn sẽ trở nên bình an, viên mãn.
        <br/>
        Chúng tôi ở đây để giúp cho bạn nhận thức được về bản thân mình, giúp bạn dễ dàng vượt qua những 
        giai đoạn của cuộc đời. Hay đơn giản giúp bạn nắm bắt những món quà mà Vũ trụ ban tặng cho bạn, 
        để từ đó bạn có thể nhận thấy giá trị ở bản thân mình, tự tìm thấy niềm vui, hạnh phúc trên con đường 
        của mình, cũng như ý nghĩa của cuộc sống khi được thức dậy mỗi ngày.
        <br/>
        Mong rằng bạn sẽ suy ngẫm và ứng dụng hồ sơ của Chúng tôi một cách hiệu quả cho bản thân và con đường tương lai của mình.
    </p>
';
$pdf->SetFont($font,'',12);
$pdf->writeHTML($html, true, false, true, false,'');

$html = "<p>Thân ái</p>";
$pdf->SetFont($font_italic,'',12);
$pdf->writeHTML($html, true, false, true, false,'R');

// ------------------------------- END PAGE 5 --------------------------------------
// ---------------------------------------------------------------------------------




// ------------------------------- BEGIN PAGE 6 ------------------------------------
// ---------------------------------------------------------------------------------
$pdf->AddPage();
$pdf->Bookmark('Tổng quan về năng lượng số', 0, 0, '', '', array(0,0,0));
$pdf->CustomTitle('TỔNG QUAN VỀ NĂNG', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->CustomTitle('LƯỢNG SỐ', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->Image('image/numer-img-1.jpg', 0, 55, 215.9, 161.6, 'JPG', '', '', true, 200, '', false, false, 0, false, false, false);

// ------------------------------- END PAGE 6 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 7 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

$html = '
<p style="text-align: justify;"><b style="font-size: 14px;">Năng lượng số là gì?</b>
    <br/>
    Năng lượng số là số khoa học cổ đại, với mỗi con số góp phần vào sự rung cảm duy nhất
    cho mỗi câu chuyện trong cuộc sống của bạn.
    <br/>
    Bạn có thể khám phá thông tin về thế giới và từng cá nhân bằng cách sử dụng Năng lượng
    số. Nó được xem như một ngôn ngữ phổ quát của các con số. Tương tự như Chiêm tinh,
    nhưng Năng lượng số sử dụng một phương pháp khác để có được thông tin và cái nhìn sâu
    sắc: đó chính là CÁC CON SỐ.
    <br/>
    <br/>
    <b style="font-size: 14px;">Lịch sử của Năng lượng số</b>
    <br/>
    Năng lượng số đến từ đâu và nó ra đời như thế nào vẫn còn là một điều bí ẩn. Ai Cập và
    Babylon là những nơi ghi chép sớm nhất về Năng lượng số từ hàng ngàn năm trước. Các
    bằng chứng khác cũng cho thấy rằng Năng lượng số cũng được sử dụng ở những nền văn
    minh cổ đại ở Atlantis, Trung Quốc, Ấn Độ và Hy Lạp.
    <br/>
    Ngày nay, Năng lượng số phương Tây (sử dụng hệ thống Pythagoras) là hệ thống phổ biến
    nhất được sử dụng trên toàn thế giới hiện nay. Mặc dù không biết liệu ông có phát minh ra
    Numerology hay không, nhưng ông có một số lý thuyết đằng sau nó, đưa các con số lên
    một cấp độ hoàn toàn khác. Những lý thuyết này hiện là lý do đằng sau việc Pythagoras có
    công cho ngành số học ngày nay. Tuy nhiên, một số người tin rằng hệ thống phương Tây đã
    không thực sự phát triển cho đến khi ông qua đời.
    <br/>
    <br/>
    <b style="font-size: 14px;">Tìm ý nghĩa trong các con số</b>
    <br/>
    Năng lượng số dựa trên tiền đề rằng chúng ta là những linh hồn vượt thời gian đã và sẽ
    tiếp tục sống, có nhiều mục đích sống để hiểu biết và trưởng thành. Các nhà Năng lượng
    số tin rằng mỗi người trong chúng ta, trong nỗ lực tự làm chủ, có một công việc sắp đặt
    trước bao gồm các bài học cụ thể mà chúng ta muốn học và định mệnh khiến chúng ta nỗ
    lực thực hiện trong khi chúng ta ở đây – những chi tiết về điều đó được tìm thấy trong các
    con số của chúng ta. Nói cách khác, chúng ta đã lựa chọn trước các con số của mình trước
    khi tới kiếp này để cung cấp các công cụ và kinh nghiệm cần thiết để hỗ trợ chúng ta trong
    sứ mệnh của mình. Hệ thống Năng lượng số phương Tây mà tôi sử dụng sẽ giúp bạn khám
    phá bản kế hoạch chi tiết đã được chọn sẵn của cuộc đời bạn bằng cách sử dụng các số
    tương ứng với ngày sinh, tên giấy khai sinh và tên hiện tại bạn đang sử dụng. Khi bạn sở
    hữu bản đồ chi tiết những con số này, bạn sẽ phát hiện ra rằng sứ mệnh của cuộc đời bạn
    được viết trong những con số của bạn.
    <br/>
    Vẻ đẹp của Năng lượng số là nó tập trung vào hai lĩnh vực chính: phân tích tính cách và dự
    đoán tương lai. Vì vậy, bạn sẽ không chỉ xác định được điểm mạnh và điểm yếu của mình,
    bài học cuộc sống, định mệnh và mục đích, mà bạn còn phát hiện ra tiềm năng trong tương
    lai của bạn, môi trường xung quanh bạn và định hướng trong cuộc sống mà đang dẫn dắt
    bạn.
</p>
';
$pdf->writeHTML($html, true, false, true, false,'');
// ------------------------------- END PAGE 7 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 8 ------------------------------------
// ---------------------------------------------------------------------------------
$pdf->AddPage();
$pdf->CustomTitle('PHẦN 1. BỘ SỐ BẢN MỆNH', $bungee_shade, 30, 'C', array(88,12,109));

$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

$pdf->CellImageBorder('image/bosonoiluc1', 'png', '1. SỐ ĐƯỜNG ĐỜI', 67.3, 40.6, 34, 40, $font);
$pdf->CellImageBorder('image/bosonoiluc2', 'png', '2. SỐ THÁI ĐỘ', 67.3, 40.6, 115, 40, $font);
$pdf->CellImageBorder('image/bosonoiluc3', 'png', '3. SỐ NGÀY SINH', 67.3, 40.6, 34, 94, $font);
$pdf->CellImageBorder('image/bosonoiluc4', 'png', '4. SỐ VẬN MỆNH', 67.3, 40.6, 115, 94, $font, array(255, 255, 0));
$pdf->CellImageBorder('image/bosonoiluc5', 'png', '5. SỐ LINH HỒN', 67.3, 40.6, 34, 149, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc6', 'png', '6. SỐ NHÂN CÁCH', 67.3, 40.6, 115, 149, $font, array(255, 255, 0));
$pdf->CellImageBorder('image/bosonoiluc7', 'png', '7. SỐ TRƯỞNG THÀNH', 67.3, 40.6, 34, 204, $font);
$pdf->CellImageBorder('image/bosonoiluc8', 'png', '8. SỐ LẶP', 67.3, 40.6, 115, 204, $font, array(255, 255, 255));


// ------------------------------- END PAGE 8 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 9 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->CustomTitle('PHẦN 2. BỘ SỐ NỘI LỰC', $bungee_shade, 30, 'C', array(88,12,109));

$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

$pdf->CellImageBorder('image/bosonoiluc9', 'png', '9. BIỂU ĐỒ NGÀY SINH', 67.3, 40.6, 34, 40, $font, array(255, 255, 0));
$pdf->CellImageBorder('image/bosonoiluc10', 'png', '10. SỐ THIẾU', 67.3, 40.6, 115, 40, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc11', 'png', '11. BIỂU ĐỒ VÀ ĐẶC ĐIỂM TÊN', 67.3, 40.6, 34, 94, $font, array(255, 0, 0));
$pdf->CellImageBorder('image/bosonoiluc12', 'png', '12. SỐ ĐAM MÊ TIỀM ẨN', 67.3, 40.6, 115, 94, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc13', 'png', '13. SỐ CÂN BẰNG', 67.3, 40.6, 34, 149, $font);
$pdf->CellImageBorder('image/bosonoiluc14', 'png', '14. SỐ AN TOÀN', 67.3, 40.6, 115, 149, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc15', 'png', '15. SỐ NGHIỆP QUẢ', 67.3, 40.6, 34, 204, $font);
$pdf->CellImageBorder('image/bosonoiluc16', 'png', '16. PHẢN HỒI TIỀM THỨC', 67.3, 40.6, 115, 204, $font, array(255, 255, 0));




// ------------------------------- END PAGE 9 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 10 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->CustomTitle('PHẦN 3. THÔNG ĐIỆP', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->CustomTitle('CUỘC SỐNG', $bungee_shade, 30, 'C', array(88,12,109));

$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);

$pdf->CellImageBorder('image/bosonoiluc17', 'png', '17. HÀNH TINH', 67.3, 40.6, 34, 70, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc18', 'png', '18. CUNG HOÀNG ĐẠO', 67.3, 40.6, 115, 70, $font, array(255, 255, 0));
$pdf->CellImageBorder('image/bosonoiluc19', 'png', '19. CHỈ SỐ HẠNH PHÚC', 67.3, 40.6, 34, 125, $font);
$pdf->CellImageBorder('image/bosonoiluc20', 'png', '20. TÌNH YÊU', 67.3, 40.6, 115, 125, $font, array(255, 255, 255));


// ------------------------------- END PAGE 10 --------------------------------------
// ---------------------------------------------------------------------------------


// ------------------------------- BEGIN PAGE 11 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->CustomTitle('PHẦN 4. HÀNH TRÌNH', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->CustomTitle('CUỘC ĐỜI', $bungee_shade, 30, 'C', array(88,12,109));
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);

$pdf->CellImageBorder('image/bosonoiluc21', 'png', '21. 3 GIAI ĐOẠN ĐƯỜNG ĐỜI', 67.3, 40.6, 5, 70, $font);
$pdf->CellImageBorder('image/bosonoiluc22', 'png', '22. CÁC NĂM MỐC QUAN TRỌNG', 67.3, 40.6, 75, 70, $font);
$pdf->CellImageBorder('image/bosonoiluc23', 'png', '23. NĂM NỔI BẬT', 67.3, 40.6, 145, 70, $font, array(255, 255, 0));
$pdf->CellImageBorder('image/bosonoiluc24', 'png', '24. 4 ĐỈNH CAO', 67.3, 40.6, 5, 125, $font);
$pdf->CellImageBorder('image/bosonoiluc25', 'png', '25. 4 THÁCH THỨC', 67.3, 40.6, 75, 125, $font);
$pdf->CellImageBorder('image/bosonoiluc26', 'png', '26. NĂM THẾ GIỚI', 67.3, 40.6, 145, 125, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc27', 'png', '27. NĂM CÁ NHÂN', 67.3, 40.6, 5, 180, $font, array(255, 255, 255));
$pdf->CellImageBorder('image/bosonoiluc28', 'png', '28. THÁNG CÁ NHÂN', 67.3, 40.6, 75, 180, $font);
$pdf->CellImageBorder('image/bosonoiluc29', 'png', '29. NGÀY CÁ NHÂN', 67.3, 40.6, 145, 180, $font);


// ------------------------------- END PAGE 11 -------------------------------------
// ---------------------------------------------------------------------------------



$title = array(
    "1. Số Đường Đời",
    "2. Số Thái Độ",
    "3. Số Ngày Sinh",
    "4. Số Vận Mệnh",
    "5. Số Linh Hồn",
    "6. Số Nhân Cách",
    "7. Số Trưởng Thành",
    "8. Số Lặp",
    "9. Biểu Đồ Ngày Sinh",
    "10. Số Thiếu",
    "11. Biểu Đồ Đặc Điểm Tên",
    "12. Số Đam Mê Tiềm Ẩn",
    "13. Số Cân Bằng",
    "14. Số An Toàn",
    "15. Số Nghiệp Quả",
    "16. Số Phản Hồi Tiềm Thức",
    "17. Hành Tinh",
    "18. Cung",
    "19. Chỉ Số Hạnh Phúc",
    "20. Tình Yêu",
    "21. 3 Giai Đoạn Cuộc Đời",
    "22. Các Giai Đoạn Quan Trọng",
    "23. Năm Nổi Bật 6",
    "24. 4 Đỉnh Cao Cuộc Đời",
    "25. 4 Thách Thức Cuộc Đời",
    "26. Năm Thế Giới 5",
    "27. Năm Cá Nhân",
    "28. Tháng Cá Nhân",
    "29. Ngày Cá Nhân"
);

$list_txt_so_ban_menh = array(
    "Con số đường đời được tính toán dựa trên ngày sinh dương lịch của chúng ta 
    (giống như biểu đồ ngày sinh trong chiêm tinh), vì vậy chúng ta có thể coi 
    con số đường đời như một loại dấu hiệu hoàng đạo của Năng lượng số. Những 
    con số này nói lên giá trị cốt lõi, phương thức hoạt động và sứ mệnh tổng 
    thể của chúng ta trong cuộc sống. Mỗi con số được liên kết với những phẩm 
    chất, điểm mạnh và điểm yếu duy nhất - và chúng được cho là có ý nghĩa sâu 
    sắc và có ảnh hưởng lớn đến các con đường của chúng ta trong cuộc sống.",
    
    "Số Thái độ là con số thể hiện cách bạn ứng xử, hành động với người khác. 
    Nếu bạn không hài lòng với cách người khách nhìn nhận bạn, bạn có thể thay đổi 
    thái độ nếu bạn muốn.",
    
    "Số Ngày sinh là một trong những con số Cốt lõi quan trọng, số Ngày sinh của bạn 
    có thể tiết lộ những khả năng độc đáo và mạnh mẽ mà bạn sở hữu một cách tự nhiên 
    - giống như một món quà bạn phải tặng cho thế giới.",
    
    "Con số định mệnh là con đường dẫn bạn đến định mệnh hay đích đến mà bạn hướng 
    đến trong tương lai. Nó mang lại một cái nhìn bao quát về những cơ hội, thách 
    thức và bài học mà bạn sẽ gặp phải trong cuộc đời này. Mặc dù bạn có thể thay 
    đổi số Vận mệnh một phần nào đó bằng cách đổi tên khai sinh, nhưng nó luôn là 
    nguồn năng lượng ẩn dưới bất kỳ thay đổi nào và sẽ tự bộc lộ ra trong cuộc đời bạn.",
    
    "Số Linh hồn của bạn tiết lộ những gì thúc đẩy bạn và những gì bạn cần để nuôi dưỡng 
    tâm hồn của mình. Nói cách khác, nó tiết lộ những gì trái tim bạn mong muốn và những 
    gì Linh hồn của bạn thôi thúc bạn phải hoàn thành trong cuộc sống này để tạm bằng lòng.",
    
    "Số Nhân cách hay còn gọi là số bên ngoài không ảnh hưởng mạnh đến bạn như các số Cốt lõi khác. 
    Nó đại diện cho 'bên ngoài bạn.' hoặc khía cạnh tính cách mà bạn lựa chọn để thể hiện cho người 
    khác (chứ không phải là sự phản ánh bản chất bên trong thực sự của bạn).",
    
    "Số Trưởng thành chỉ ra tiềm năng tương lai của bạn và mục tiêu cuối cùng trong cuộc sống của bạn.
    Nó cũng cho bạn biết cuộc sống của bạn đang chuẩn bị gì và mong đợi gì. Thú vị thay, Số Trưởng 
    thành không có tác dụng cho đến khi ' trưởng thành ' hoặc tuổi trung niên, khi bạn đã hiểu rõ 
    hơn về bản thân và con đường của bạn. Mỗi người trưởng thành ở những tốc độ khác nhau, độ tuổi 
    khác nhau, nhưng nó thường bắt đầu từ 35- 45 và hoạt động mạnh vào năm 50 tuổi. Mỗi năm trôi qua, 
    năng  lượng của số trưởng thành sẽ tăng mạnh và trưởng thành. Nói cách khác, bạn càng nhiều tuổi, 
    thì Số Trưởng thành của bạn càng ảnh hưởng mạnh vào tính cách và cuộc sống của bạn. Bạn nên ghi nhớ 
    con số này khi đưa ra các mục tiêu và quyết định dài hạn.",
    
    "Mỗi con số đều mang năng lượng số học. Nhưng nếu chúng xuất hiện từ 2 lần trở lên, tức là chúng 
    có độ rung cao hơn các số xuất hiện 1 lần. Khi bạn thấy bất kỳ số nào được lặp lại, nó sẽ khuếch 
    đại ý nghĩa của số đó. Càng nhiều số lặp lại trong một chuỗi, thông điệp càng mạnh mẽ.",
    
    "Khi bạn muốn mở một cánh cửa, bạn cần có chìa khóa. Đối với hầu hết mọi người, 
    nội tâm ẩn sau một cánh cửa khóa chặt, hiếm khi họ phát hiện ra mình thực sự là 
    ai hoặc phát triển tiềm năng cuối cùng của mình. Chìa khóa để khám phá con người 
    bên trong thông qua thuật số là Biểu đồ sinh. Mục đích chính của Biểu đồ sinh là 
    để tiết lộ trong nháy mắt tổng thể về điểm mạnh và điểm yếu của mỗi người.",
    
    "Số còn thiếu thường chỉ ra những đặc điểm, đặc tính còn thiếu - mong muốn hoặc 
    không mong muốn - từ tính cách của một người. Chúng cũng chỉ ra một số bài học 
    quan trọng mà một người cần học hoặc có thể là một số thói quen quan trọng mà một 
    người cần trau dồi để có một cuộc sống cân bằng hơn. Khi bạn hiểu được những thiếu 
    sót của người khác, Bạn cần phải khoan dung, thấu hiểu và ủng hộ họ. Nếu có thể, 
    bạn hãy giúp họ phát triển phẩm chất còn thiếu của họ.",
    
    "Các chữ cái và các ký tự số tương ứng với tên của chúng có thể được nhóm lại 
    thành bốn loại dựa trên “Các mặt phẳng biểu hiện”",
    
    "Số đam mê tiềm ẩn cho bạn biết về một khả năng hoặc tài năng cụ thể mà bạn có, 
    đó là chìa khóa cho toàn bộ bản chất của bạn và có thể giúp bạn hiểu mục đích cuộc 
    sống của mình.",
    
    "Số Cân bằng cung cấp cho bạn hướng dẫn tốt nhất để đối phó với các tình huống 
    khó khăn hoặc khi bị đe dọa.",
    
    "Số an toàn cho bạn biết bạn có những gì bên trong để thành công cả về cá nhân 
    và nghề nghiệp, bất kể điều gì xảy ra theo cách của bạn. Ngay cả trong trường 
    hợp xấu nhất, Số an toàn sẽ là điểm mấu chổ của bạn.",
    
    "Một trong những lý do tại sao bạn được xuất hiện trong cuộc sống này là để học 
    cách làm chủ một số điểm yếu được nhận từ kiếp trước. Số nghiệp chướng của bạn 
    cho biết những điểm yếu đó là gì, cùng với các lĩnh vực cụ thể cần phát triển 
    và phải được giải quyết trong cuộc sống này. Một số nhà Năng lượng số tin rằng 
    số nghiệp chướng chỉ ra một con số hoặc năng lượng mà bạn chưa từng có trong kiếp 
    trước và do đó cần phải phát triển trong kiếp này. Và nó sẽ liên tục xuất hiện 
    trong suốt cuộc đời bạn.",
    
    "Số phản hồi tiềm thức cho biết cách bạn hành động hoặc phản ứng theo bản năng 
    trong thời điểm khẩn cấp hoặc khủng hoảng.",
    
    "Mỗi số được liên kết với một hành tinh. Hành tinh của bạn sẽ cho bạn biết rõ 
    hơn các đặc điểm của mình, đồng thời tìm hiểu cách bạn có thể làm cho vị trí 
    hành tinh của mình mạnh mẽ hơn",
    
    "Trên thực tế, dấu hiệu chiêm tinh có ảnh hưởng đáng kể đến cách mọi người 
    thể hiện bản thân thông qua các con số của họ. Ví dụ, Đường đời 1 của Bạch 
    Dương mạnh mẽ hơn, can đảm hơn và tiên phong hơn và do đó sẽ có xu hướng lãnh 
    đạo mạnh mẽ hơn so với Số Đường đời 1 của Cự Giải nhạy cảm và cảm thông.
    Ngay cả một sự hiểu biết cơ bản về từng dấu hiệu chiêm tinh sẽ giúp bạn 
    trở thành một nhà phân tích các con số tốt hơn.",
    
    "Những điều có thể làm trong cuộc sống khiến bạn cảm thấy hạnh phúc. 
    Đó có thể là sứ mệnh bạn đang theo đuổi. Hay có thể là điều linh hồn 
    bạn vẫn đang khao khát thực hiện. Cũng có thể đơn giản đó là nhân cách 
    bạn vẫn hay thể hiện ra cho mọi người thấy.
    Dù là điều gì, hãy là chính bạn, hãy làm những điều bạn yêu thích để 
    bản thân được hạnh phúc và khiến cuộc sống trở nên ý nghĩa hơn.",
    
    "Bạn là người thế nào trong tình yêu? Bạn nên làm gì để phát triển 
    mối quan hệ của mình theo hướng tốt đẹp?
    Trong một mối quan hệ, thể hiện tính cách thật sự của bản thân là 
    điều tốt, nhưng có những tính cách không thể dung hòa giữa hai người. 
    Lúc này bạn hãy gạt bỏ bớt cái tôi, thay đổi những thói quen tiêu cực 
    và cảm thông cho nhau. Cùng nhau dắt tay đi đến điểm cuối cùng của 
    con đường nhé.",
    
    "Cuộc đời mỗi người chia thành 3 giai đoạn khác nhau:
    đoạn giữa, các tài năng sáng tạo và tính cá nhân của 
    chúng ta dần dần xuất hiện. Tại giai đoạn này, đầu và 
    giữa những năm 30 tuổi- thể hiện một cuộc đấu tranh để tìm 
    vị trí của chúng ta trong xã hội, cuối năm 30, 40 tuổi và 
    đầu những năm 50 tuổi, chúng ta làm chủ được bản thân và ảnh 
    hưởng nhiều hơn đến môi trường. Chu kỳ cuối cùng, có thể đại diện 
    cho sự nở hoa   bên trong chúng ta, đó là khi bản chất thực sự của chúng 
    ta cuối cùng đã thành hiện thực. Đây cũng là giai đoạn một người có mức
    độ thể hiện bản thân và quyền lực lớn nhất.",
    
    "Các năm Mốc là những năm được xác định chính xác trong cuộc đời của bạn 
    có ý nghĩa quan trọng vì một số lý do. Có lẽ bạn đã bắt đầu hoặc tốt nghiệp 
    ra trường, gặp tình yêu đầu tiên của mình, hoặc chuyển đến một ngôi nhà hoặc 
    thành phố mới. Có thể bạn đã bắt đầu một công việc mới, được thăng chức, thành 
    lập công ty riêng, nghỉ phép hoặc thậm chí nghỉ hưu. Những con số sẽ cung cấp 
    cho bạn một bức tranh toàn cảnh của các sự kiện thích hợp xảy ra trong khoảng 
    thời gian giữa các Năm Mốc.",
    
    "Là nhận thức của bạn về sự tiến bộ hoặc đường đua trong cuộc sống của bạn. 
    Khi bạn tiến tới mục tiêu của mình, bạn sẽ nhận thấy nhận thức về những 
    tiến bộ trong sự nghiệp và cuộc sống cá nhân của bạn ngày càng tăng.",
    
    "Mỗi người trong cuộc đời sẽ có 4 Đỉnh cao. Mỗi đỉnh mang những giá trị 
    riêng, giúp chúng ta trưởng thành lên một bậc. Và sau khi kết thúc chu kỳ, 
    chúng ta sẽ sống cuộc đời viên mãn nhờ vào những giá trị trước đó. Ảnh hường 
    của mỗi Đỉnh cao kéo dài từ năm Cá nhân số 8, và giảm dần từ năm Cá nhân số 3. 
    Nên bạn cần biết để có sự chuẩn bị từ năm Cá nhân số 1. Nếu không đến năm Đỉnh, 
    bạn không nhận được món quà nào cả.",
    
    "Tất cả chúng ta đều được sinh ra với những điểm yếu và điểm mạnh nhất định. 
    Năng lượng số xem cuộc sống là một quá trình học hỏi về bản thân không bao 
    giờ kết thúc. Sự học hỏi không ngừng này giúp chúng ta nhận ra tiềm năng 
    của mình và biến điểm yếu thành điểm mạnh. Để làm được điều này, chúng ta 
    cần sẵn sàng đối mặt với những điểm yếu đó và có ý thức cải thiện. Có 4 thách 
    thức mà tất cả chúng ta phải đối mặt trong suốt cuộc đời của mình. 
    Đôi khi nó có thể là cùng một Thử thách lặp lại tại những thời điểm khác nhau. 
    Tuy nhiên, chúng hiện diện và tồn tại để dạy chúng ta những bài học cuộc sống cụ thể.",
    
    "Có những năng lượng số học phổ quát ảnh hưởng đến toàn bộ thế giới. Chúng cung 
    cấp một động lực cho một số loạt sự kiện và hoàn cảnh nhất định xảy ra. Tương tự 
    như biểu đồ số học cá nhân, năng lượng vũ trụ hoặc thế giới thay đổi hàng năm. Đây 
    là xu hướng cho toàn thế giới mỗi năm, không phải xu hướng cá nhân.",
    
    "Cuộc đời mỗi người đi theo chu kì 9 năm một lần, bắt đầu từ năm cá nhân số 1 
    đến năm cá nhân số 9. Mỗi lần kết thúc một chu kì, chúng ta sẽ dần nhận thức 
    nhiều hơn và trưởng thành hơn. Nổi bật là 4 chu kì trong 36 năm với 4 đỉnh cao 
    cũng là những thành tựu mà bạn CÓ THỂ đạt được.
    Tuy nhiên, để thật sự gặt hái được thành tựu ở những đỉnh cao đó, từng năm Cá nhân 
    chính là nền tảng, là quá trình từng bước dẫn lối cho bạn đi đến đỉnh cao của cuộc đời.",
    
    "Mỗi người trong một thời gian sẽ chịu ảnh hưởng của nhiều con số với nhau. 
    Ví dụ trong một tháng, không chỉ là số ngày cá nhân, số tháng cá nhân, 
    và tháng trong năm cá nhân. Việc các con số kết hợp với nhau khiến cho 
    cuộc sống của bạn cũng trở nên thú vị đa màu sắc hơn.",
    
    "Bạn có bao giờ từng thức dậy và không biết hôm nay mình cần phải làm gì 
    chưa? Đừng lo lắng, chỉ cần để bản thân xuôi theo dòng chảy của từng con 
    số. Việc bạn làm trong mỗi ngày, dù là nhỏ nhưng mang lại ảnh hưởng lớn, 
    và bạn sẽ nhìn thấy thành quả rõ rệt sau này."
    
);



// ------------------------------- BEGIN PAGE 12 - 70-------------------------------
// ---------------------------------------------------------------------------------

// Phần 1 Bộ số bản mệnh
$pdf->PrintBgFullPage('image/phan1.jpg', true, 'Phần 1. Bộ số bản mệnh');
$pdf->PrintPart(0, 7, $title, $list_txt_so_ban_menh, $font, $font_IB);

// Phần 2 Bộ số nội lực
$pdf->PrintBgFullPage('image/phan2.jpg', true, 'Phần 2. Bộ số nội lực');
$pdf->PrintPart(8, 15, $title, $list_txt_so_ban_menh, $font, $font_IB);

// Phần 3 Thông điệp cuộc sống
$pdf->PrintBgFullPage('image/phan3.png', true, 'Phần 3. Thông điệp cuộc sống');
$pdf->PrintPart(16, 19, $title, $list_txt_so_ban_menh, $font, $font_IB);

// Phần 4 Hành trình cuộc đời
$pdf->PrintBgFullPage('image/phan4.png', true, 'Phần 4. Hành trình cuộc đời');
$pdf->PrintPart(20, 28, $title, $list_txt_so_ban_menh, $font, $font_IB);

// ------------------------------- END PAGE 12 - 70 --------------------------------
// ---------------------------------------------------------------------------------

// Lời kết
$pdf->AddPage();
$pdf->CustomTitle('LỜI KẾT', $bungee_shade, 24, 'C', array(111, 47, 159));
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
$pdf->Ln(5);

$html = '
<p style="text-align:justify;">Mỗi con số đều ẩn chứa những nguồn năng lượng 
và những sức mạnh riêng. Nhưng con số không tự kích hoạt năng lượng, mà chúng 
sẽ được phát triển dựa vào nhận thức và hành động của chúng ta. Nếu bạn không 
kích hoạt chúng, các con số sẽ trở nên vô nghĩa. Chúng xuất hiện trong cuộc đời 
bạn theo từng giai đoạn, hay xuyên suốt hành trình đường đời của bạn. Thậm chí 
các con số có thể mang lại những món quà nho nhỏ ở mỗi năm, hay những thành tựu 
to lớn ở những năm nổi bật và đỉnh cao của cuộc đời bạn. Tuy nhiên, xin bạn hãy 
nhớ rằng, Vũ trụ đối xử công bằng với tất cả mọi người, và phần thưởng chỉ được 
trao tặng cho những người xứng đáng. Mong bạn hãy luôn sống một cuộc đời tích cực, 
vui vẻ, biết cân bằng giữa thế giới vật chất và tinh thần, biết sẻ chia vô điều kiện, 
biết bao dung, và vị tha với người khác. Làm việc chăm chỉ, biết đứng dậy trước những 
vấp ngã và thất bại, kiên trì, trung thực, rồi sẽ đến ngày bạn nhận được những thành 
quả xứng đáng với điều mình đã hi sinh. Và nắm bắt những kiến thức, những bài học, 
những niềm vui cả trên con đường chông gai của mình.
</p>
';
$pdf->writeHTML($html, true, false, true, false,'');

$pdf->Ln(5);
$pdf->SetFont($font_italic, '', 12);
$html = '<p style="text-align:justify;">Chúc bạn và gia đình luôn hạnh phúc và bình an!</p>';
$pdf->writeHTML($html, true, false, true, false,'');

// ------------------------------- LAST PAGE --------------------------------
$pdf->AddPage();
$pdf->SetFont($font, '', 12);
$pdf->setCellHeightRatio(1.4);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('image/vs-logo.jpg', 165, 20, 35, 35, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
$pdf->Image('image/foreword-img-2.png', 0, 170, 220, 69.3, 'PNG', '', '', true, 200, '', false, false, 0, false, false, false);
$pdf->Image('image/background.jpg', 60, 55, 100, 130, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
$pdf->Image('image/ios-qr.png', 108, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);
$pdf->Image('image/android-qr.png', 0, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);

$html = '<p style="font-size: 16px"><b>Công ty Cổ phần Khởi Nghiệp Việt<br/>
Email: vstartup@gmail.com<br/>
numerologyleo@gmail.com<br/>
SĐT: 0901.508.999 - 0867.880.577<b/></p>';

$pdf->writeHTML($html, true, false, true, false,'');
$pdf->Ln(165);

$html = 'Quét mã cài đặt app';
$pdf->SetFont($font, 'B', 28);
$pdf->Write(0, $html, '', false, 'C', true);

// --------------------------------------------------------------------------

// --------------------------------- mục lục --------------------------------
$pdf->addTOCPage();
$pdf->setPrintFooter(true);
$pdf->Image('image/background.jpg', 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
// write the TOC title
$pdf->SetFont($bungee_shade, 'B', 22);
$pdf->SetTextColor(array(88,12,109));
$pdf->MultiCell(0, 0, 'MỤC LỤC', 0, 'C', 0, 1, '', '', true, 0);

$pdf->SetFont($font, '', 12);

// add a simple Table Of Content at first page
// (check the example n. 59 for the HTML version)
$pdf->addTOC(4, 'courier', '.', 'INDEX', 'B', array(128,0,0));

// end of TOC page
$pdf->endTOCPage();

// --------------------------------------------------------------------------

//out put
$pdf->Output();
?>