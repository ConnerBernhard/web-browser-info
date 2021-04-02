<?php

public function print_report($org_id,$contract_id,$type)
		{
		
					
					$style='<style>
					.DataTable td{padding:10px;}
					.DataTable tr th{font-weight:bold;background-color:#F2F2F2;}
					.DataTable tr.odd{background-color:#F2F2F2;}
					.DataTable tr.sub_total{background-color: #ffc88e;font-weight:bold;text-transform: uppercase; }
					.DataTable tr.total{background-color: #d0d0d0 !important;font-weight:bold;}
					td.modal-header {background-color:#FE8302;border-bottom: 1px solid #EEEEEE;color: #FFFFFF;padding: 10px;font-size:20px;line-height:34px;}
					.DataTable {border: 1px solid #EEEEEE;font-size:12px;}
					.right{text-align:right;}
					p{font-size:1px;line-height:8px;margin:0px;padding:0px;}
					</style>
					';
					
					if($this->get_contract($contract_id))
					{
					$contract_data=$this->get_contract($contract_id);
					$filename=str_replace(' ','_',$contract_data["asset_desc"])."_".str_replace(' ','_',$this->contract_type($contract_data['contract_type']))."_Report";
					ob_start();
					$this->final_report($contract_data);
					$report_html=utf8_decode(ob_get_contents());
					ob_clean();
					
					if($type=='xls')
					{
					header('Content-type: application/excel');                                  
					header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
					echo $style;
					echo $report_html;
					}
					if($type=='pdf')
					{
						// create new PDF document
						$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						
						// set document information
						$pdf->SetCreator('HP KEEPER');
						$pdf->SetAuthor('HP KEEPER');
						$pdf->SetTitle($filename);
						$pdf->SetSubject('report');
						$pdf->SetKeywords('HP KEEPER, ');
						
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
						//$html =$report_html
						//echo $html;
					}
					}else
					{
					echo "<h3>No contract found</h3>";
					
					}
					 exit;
		}
		?>