<?php 
include('lib/TCPDF/tcpdf.php');
include('data.php');
class MYPDF extends TCPDF {
    // Page footer
    
    public function Footer() {
        // Position at 15 mm from bottom
        $font = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetY(-20);
        // Set font
        $this->SetFont($font, '', 12);
        $style = array(
            'T' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
        );
        // Page number
        $this->Cell(0, 10, 'Numerology - Năng lượng số', $style, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function configDefault() {
        $font_default = TCPDF_FONTS::addTTFfont('font/SVN-Arial/SVN-Arial 2.ttf');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($font_default, '', 12);
    }

    public function customTitle($text, $font, $size, $align = 'C', $color = array(0, 0, 0), $back_default = true) {
        $this->SetTextColor($color[0], $color[1], $color[2]);
        $this->SetFont($font, 'B', $size);
        $this->Write(0, $text, '', 0, $align, true, 0, false, false, 0);

        if($back_default) 
            $this->configDefault();
    }

    public function cellImageBorder($img, $txt, $h, $w, $x, $y, $font, $colorTxt = array(0, 0, 0)) {
        $img_type = ltrim(strstr($img, '.', false), '.');
        
        $this->setCellPaddings(8, 5, 1, 1);
        $this->SetLineStyle(array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $this->SetFont($font, 'B', 16);
        $this->SetTextColor($colorTxt[0], $colorTxt[1], $colorTxt[2]);
        $this->Image($img, $x, $y, $h, $w, $img_type, '', '', true, 300, '', false, false, 0, false, false, false);
        $this->RoundedRect($x, $y, $h, $w, 5.4, '1111');
        $this->MultiCell($h, $w, $txt, 0, 'C', 0, 1, $x-2, $y-2, true);
        $this->setCellPaddings(1, 1, 1, 1);
    }

    public function printBgFullPage($bgImg, $bookMark = false, $txt = '', $level = 0, $page = '', $color = array(0,0,0)) {
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

    public function customParagraph($text, $font, $size, $style, $color = array(0 ,0 ,0), $back_default = true) {
        $this->setCellHeightRatio(1);
        $this->setCellPaddings(1,1,1,1);
        $this->SetTextColor($color[0], $color[1], $color[2]);
        $this->SetFont($font, $style, $size);
        $this->writeHTML($text, true, false, true, false, '');

        if($back_default) 
            $this->configDefault();
    }

    public function printPart($start, $end, $list_title, $list_content, $list_image_detail, $background_image, $font_title, $font_cotent) {
        $text = '';
        for ($i = $start; $i <= $end; $i++) {
            $img_type = ltrim(strstr($list_image_detail[$i], '.', false), '.');
            $text = '<p style="text-align: justify;">'.$list_content[$i].'</p>';
            
            $this->AddPage();
            $this->setPrintFooter(true);
            $this->Bookmark($list_title[$i], 1, 0, '', '');
            $this->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
            $this->Image('image/arrow-head.png', 16, 13, strlen($list_title[$i]) * 2.5  + 30, 25, 'png', '', '', true);
            $this->setCellPaddings(5, 1, 1, 1);
            $this->customTitle($list_title[$i], $font_title, 18, 'L', array(255, 255, 255), false);

            $this->Image($list_image_detail[$i], 0, 40, 220, '', $img_type, '', '', true, 300, '', false, false, 0, false, false, false);
            $this->Ln($this->getImageRBY()-21);
            $this->customParagraph($text, $font_cotent, 14, '', array(111,47,159), false);
            
            if ($i != $end) {
                $this->AddPage();
                $this->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
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
$font_title_header = TCPDF_FONTS::addTTFfont($font_header);
$pdf->SetFont($font, '', 12);
$pdf->setCellHeightRatio(1.4);
// $pdf->SetTextColor();



// ------------------------------- BEGIN PAGE 1 --------------------------------------
// -----------------------------------------------------------------------------------
$pdf->AddPage();
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->Image('image/ceo.jpg',  124, 15, 92.5, 92.5, 'JPG', '', '', true);


$regions = array(
    array('page' => '', 'xt' => 123, 'yt' =>  20, 'xb' => 123, 'yb' =>  110, 'side' => 'R'),
);
    
// set page regions, check also getPageRegions(), addPageRegion() and removePageRegion()
$pdf->setPageRegions($regions);

$pdf->customTitle("GIỚI THIỆU VỀ", $font, 23, 'C', array(88,12,109));
$pdf->customTitle("NHÀ SÁNG LẬP", $font, 23, 'C', array(88,12,109));
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
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->Image('image/vs-logo.jpg',  8, 8, 29.8, 28.5, 'JPG', '', '', true, 300, '', false, false, 1);
$pdf->Image('image/numerology-logo.jpg',  164, 8, 45.1, 32.8, 'JPG', '', '', true);


$pdf->customTitle("Ứng dụng", $font, 23, 'C', array(88,12,109));
$pdf->customTitle("Numerology - Năng lượng số", $font, 23, 'C', array(88,12,109));
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

$pdf->printBgFullPage('image/book.jpg');

// ------------------------------- END PAGE 3 --------------------------------------
// ---------------------------------------------------------------------------------




// ------------------------------- BEGIN PAGE 4 ------------------------------------
// --------------------------------  MUC LUC  --------------------------------------
// ------------------------------- END PAGE 4 --------------------------------------
// ---------------------------------------------------------------------------------




// ------------------------------- BEGIN PAGE 5 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->setPrintFooter(true);
$pdf->AddPage();
$pdf->Bookmark('Lời mở đầu', 0, 0, '', 'B', array(0,0,0));
$pdf->Image('image/foreword-img.png', 0, 190, 220, 69.3, 'PNG', '', '', true, 200, '', false, false, 0, false, false, false);
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$pdf->customTitle('LỜI MỞ ĐẦU', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Ln(5, false);


$html = "
    <p>Bạn thân mến! Cảm ơn bạn đã tin tưởng và lựa chọn Chúng tôi  trở  thành 
        người dẫn lối cho bạn đi  tới đúng con đường của mình, cũng như tìm kiếm 
        con người  hoàn hảo nhất của mình.
    </p>";
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
$pdf->customTitle('TỔNG QUAN VỀ NĂNG LƯỢNG SỐ', $font_title_header, 30, 'C', array(88,12,109));
// $pdf->customTitle('LƯỢNG SỐ', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Image('image/numer-img-1.jpg', 0, 55, 215.9, 161.6, 'JPG', '', '', true, 200, '', false, false, 0, false, false, false);

// ------------------------------- END PAGE 6 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 7 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

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
$pdf->customTitle('PHẦN 1. BỘ SỐ BẢN MỆNH', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

$pdf->cellImageBorder($list_image_overview[0], $list_title[0], 67.3, 40.6, 34, 40, $font);
$pdf->cellImageBorder($list_image_overview[1], $list_title[1], 67.3, 40.6, 115, 40, $font);
$pdf->cellImageBorder($list_image_overview[2], $list_title[2], 67.3, 40.6, 34, 94, $font);
$pdf->cellImageBorder($list_image_overview[3], $list_title[3], 67.3, 40.6, 115, 94, $font, array(255, 255, 0));
$pdf->cellImageBorder($list_image_overview[4], $list_title[4], 67.3, 40.6, 34, 149, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[5], $list_title[5], 67.3, 40.6, 115, 149, $font, array(255, 255, 0));
$pdf->cellImageBorder($list_image_overview[6], $list_title[6], 67.3, 40.6, 34, 204, $font);
$pdf->cellImageBorder($list_image_overview[7], $list_title[7], 67.3, 40.6, 115, 204, $font, array(255, 255, 255));

// ------------------------------- END PAGE 8 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 9 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->customTitle('PHẦN 2. BỘ SỐ NỘI LỰC', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

$pdf->cellImageBorder($list_image_overview[8], $list_title[8], 67.3, 40.6, 34, 40, $font, array(255, 255, 0));
$pdf->cellImageBorder($list_image_overview[9], $list_title[9], 67.3, 40.6, 115, 40, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[10], $list_title[10], 67.3, 40.6, 34, 94, $font, array(255, 0, 0));
$pdf->cellImageBorder($list_image_overview[11], $list_title[11], 67.3, 40.6, 115, 94, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[12], $list_title[12], 67.3, 40.6, 34, 149, $font);
$pdf->cellImageBorder($list_image_overview[13], $list_title[13], 67.3, 40.6, 115, 149, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[14], $list_title[14], 67.3, 40.6, 34, 204, $font);
$pdf->cellImageBorder($list_image_overview[15], $list_title[15], 67.3, 40.6, 115, 204, $font, array(255, 255, 0));

// ------------------------------- END PAGE 9 --------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 10 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->customTitle('PHẦN 3. THÔNG ĐIỆP CUỘC SỐNG', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);

$pdf->cellImageBorder($list_image_overview[16], $list_title[16], 67.3, 40.6, 34, 70, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[17], $list_title[17], 67.3, 40.6, 115, 70, $font, array(255, 255, 0));
$pdf->cellImageBorder($list_image_overview[18], $list_title[18], 67.3, 40.6, 34, 125, $font);
$pdf->cellImageBorder($list_image_overview[19], $list_title[19], 67.3, 40.6, 115, 125, $font, array(255, 255, 255));

// ------------------------------ END PAGE 10 --------------------------------------
// ---------------------------------------------------------------------------------


// ------------------------------- BEGIN PAGE 11 ------------------------------------
// ---------------------------------------------------------------------------------

$pdf->AddPage();
$pdf->customTitle('PHẦN 4. HÀNH TRÌNH CUỘC ĐỜI', $font_title_header, 30, 'C', array(88,12,109));
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);

$pdf->cellImageBorder($list_image_overview[20], $list_image_overview[20], 67.3, 40.6, 5, 70, $font);
$pdf->cellImageBorder($list_image_overview[21], $list_image_overview[21], 67.3, 40.6, 75, 70, $font);
$pdf->cellImageBorder($list_image_overview[22], $list_image_overview[22], 67.3, 40.6, 145, 70, $font, array(255, 255, 0));
$pdf->cellImageBorder($list_image_overview[23], $list_image_overview[23], 67.3, 40.6, 5, 125, $font);
$pdf->cellImageBorder($list_image_overview[24], $list_image_overview[24], 67.3, 40.6, 75, 125, $font);
$pdf->cellImageBorder($list_image_overview[25], $list_image_overview[25], 67.3, 40.6, 145, 125, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[26], $list_image_overview[26], 67.3, 40.6, 5, 180, $font, array(255, 255, 255));
$pdf->cellImageBorder($list_image_overview[27], $list_image_overview[27], 67.3, 40.6, 75, 180, $font);
$pdf->cellImageBorder($list_image_overview[28], $list_image_overview[28], 67.3, 40.6, 145, 180, $font);

// ------------------------------- END PAGE 11 -------------------------------------
// ---------------------------------------------------------------------------------



// ------------------------------- BEGIN PAGE 12 - 70-------------------------------
// ---------------------------------------------------------------------------------

// Phần 1 Bộ số bản mệnh
$pdf->printBgFullPage('image/image_chapter/phan1.jpg', true, 'Phần 1. Bộ số bản mệnh');
$pdf->printPart(0, 7, $list_title, $list_txt_so_ban_menh, $list_image_detail, $background_image, $font, $font_IB);

// Phần 2 Bộ số nội lực
$pdf->printBgFullPage('image/image_chapter/phan2.jpg', true, 'Phần 2. Bộ số nội lực');
$pdf->printPart(8, 15, $list_title, $list_txt_so_ban_menh, $list_image_detail, $background_image, $font, $font_IB);

// Phần 3 Thông điệp cuộc sống
$pdf->printBgFullPage('image/image_chapter/phan3.jpg', true, 'Phần 3. Thông điệp cuộc sống');
$pdf->printPart(16, 19, $list_title, $list_txt_so_ban_menh, $list_image_detail, $background_image, $font, $font_IB);

// Phần 4 Hành trình cuộc đời
$pdf->printBgFullPage('image/image_chapter/phan4.png', true, 'Phần 4. Hành trình cuộc đời');
$pdf->Ln(120);
$html = '
    <p style="text-align: justify">Sau khi giúp bạn thấu hiểu bạn thân từ những điểm mạnh, điểm yếu, tiềm 
        năng ẩn sâu bên trong hay những điều bạn cần bù đắp để hoàn thiện bản 
        thân. Chúng tôi sẽ giúp bạn nhìn thấy toàn cảnh bức tranh cuộc đời bạn 
        từ lúc sinh ra cho đến khi kết thúc cuộc đời. Đó chính là con đường được 
        định sẵn cho riêng bạn. Đi trên con đường đó hay không còn phụ thuộc 
        vào nhận thức và hành động của bạn. Nhưng nếu bạn đi sai hướng, bạn sẽ 
        cảm thấy chênh vênh và khó khăn trên đường đời. Nếu bạn biết được 
        điều gì đang chuẩn bị đến với mình, bạn sẽ có sự chuẩn bị và đón nhận 
        điều đó tốt hơn. Trên con đường đó sẽ có những thách thức, những vấp 
        ngã, nhưng tất cả đều là những bài học dạy bạn điều gì đó, những 
        chướng ngại mà Vũ trụ mang đến cho bạn. Nhưng tất nhiên, khi bạn vượt 
        qua bài kiểm tra đó, bạn sẽ nhận được những phần thưởng xứng đáng 
        bởi sự nỗ lực và hi sinh của mình. 
        <br/>
        <br/>
        Hãy để năng lượng của các con số dẫn lối cho bạn. Nhưng đừng để bản 
        thân bị cuốn theo dòng đó mà hãy tự làm chủ bản thân mình.
    </p>';
$pdf->customParagraph($html, $font, 14, 'B', array(255,255,255));

$pdf->printPart(20, 28, $list_title, $list_txt_so_ban_menh, $list_image_detail, $background_image, $font, $font_IB);

// ------------------------------- END PAGE 12 - 70 --------------------------------
// ---------------------------------------------------------------------------------

// Lời kết
$pdf->AddPage();
$pdf->customTitle('LỜI KẾT', $font_title_header, 24, 'C', array(111, 47, 159));
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
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
    </p>';
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
$pdf->Image($background_image, 60, 55, 100, 130, 'JPG', '', '', true, 300, '', false, false, 0, false, false, true);
$pdf->Image('image/ios-qr.png', 108, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);
$pdf->Image('image/android-qr.png', 0, 245, 108, '', 'png', '', '', true, 300, '', false, false, 0, false, false, false);

$html = '
    <p style="font-size: 16px"><b>Công ty Cổ phần Khởi Nghiệp Việt<br/>
        Email: vstartup@gmail.com<br/>
        numerologyleo@gmail.com<br/>
        SĐT: 0901.508.999 - 0867.880.577<b/>
    </p>';

$pdf->writeHTML($html, true, false, true, false,'');
$pdf->Ln(165);

$html = 'Quét mã cài đặt app';
$pdf->SetFont($font, 'B', 28);
$pdf->Write(0, $html, '', false, 'C', true);

// --------------------------------------------------------------------------

// --------------------------------- mục lục (Table of contents/TOC) --------------------------------
$pdf->addTOCPage();
$pdf->setPrintFooter(true);
$pdf->setCellHeightRatio(1);
$pdf->Image($background_image, 49, 55, 119.1, 152.9, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

// write the TOC title
$pdf->customTitle('MỤC LỤC', $font_title_header, 24, 'C', array(88,12,109));
$pdf->SetFont($font, '', 12);

// add a simple Table Of Content at custom page 4
$pdf->addTOC(4, 'courier', '.', 'INDEX', 'B', array(128,0,0));
// end of TOC page
$pdf->endTOCPage();

// --------------------------------------------------------------------------

//out put
$pdf->Output();
?>