<?php
session_start();
require_once('tcpdf/config/tcpdf_config.php');
require_once 'tcpdf/tcpdf.php';
require_once 'functions.php';
$specs=$_SESSION['specs'];
	
		
					
					$style='<style>
					.DataTable td{padding:20px;}
					.DataTable tr th{font-weight:bold;background-color:#F2F2F2;}
					.DataTable tr.odd{background-color:#F2F2F2;}
					.DataTable tr.sub_total{background-color: #ffc88e;font-weight:bold;text-transform: uppercase; }
					.DataTable tr.total{background-color: #d0d0d0 !important;font-weight:bold;}
					td.modal-header {background-color:#FE8302;border-bottom: 1px solid #EEEEEE;color: #FFFFFF;padding: 10px;font-size:20px;line-height:44px;}
					.DataTable {border: 1px solid #EEEEEE;font-size:18px;}
					.right{text-align:right;}
					p{font-size:1px;line-height:10px;margin:0px;padding:0px;}
					</style>
					';
					


					$filename='OS_Report';
					ob_start();
					?>
					
<table class="DataTable">
<tr class="odd">
<td>Operating System</td>
<td><?php echo $specs['os']; ?></td>
</tr>

<tr >
<td >Screen Resolution</td>
<td><?php echo $specs['sr']; ?></td>
</tr>
<tr  class="odd">
<td>Web Browser</td>
<td><?php echo $specs['wb']; ?></td>
</tr>
<tr>
<td>Browser Size</td>
<td><?php echo $specs['bs']; ?></td>
</tr>
<tr  class="odd">
<td>IP Address</td>
<td><?php echo $specs['ia']; ?></td>
</tr>
<tr>
<td>Color Depth</td>
<td><?php echo $specs['cd']; ?></td>
</tr>
<tr  class="odd">
<td>Javascript</td>
<td><?php echo $specs['js']; ?></td>
</tr>
<tr>
<td>Java Version</td>
<td><?php echo $specs['jv']; ?></td>
</tr>
<tr class="odd">
<td  >Cookies</td>
<td><?php echo $specs['ck']; ?></td>
</tr>
<tr>
<td>Silverlight</td>
<td><?php echo $specs['sl']; ?></td>
</tr>
<tr  class="odd">
<td >Flash Version</td>
<td><?php echo $specs['fv']; ?></td>
</tr>
</table>
					<?php
					$report_html=utf8_decode(ob_get_contents());
					ob_clean();
					

					
						// create new PDF document
						$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						
						// set document information
						$pdf->SetCreator('SUPPORT PROJECT');
						$pdf->SetAuthor('HP KEEPER');
						$pdf->SetTitle($filename);
						$pdf->SetSubject('report');
						$pdf->SetKeywords('SUPPORT PROJECT, ');
						
						// set default header data
						$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
						
						// set header and footer fonts
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
						$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
						
						// set default monospaced font
						$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						
						// set margins
						$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
						$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
						$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
						
						// set auto page breaks
						$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
						
						// set image scale factor
						$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
						$pdf->AddPage('L', 'A4');
						$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
					$style
					$report_html
EOF;
						$pdf->writeHTML($html, true, false, true, false, '');
						$pdf->lastPage();
						//echo $report_html;
						$pdf->Output($filename.'.pdf', 'I');
						//$pdf = convertURI('http://localhost/SupportProject/');
						//$html =$report_html
						//echo $html;
					
					
					 exit;

		?>