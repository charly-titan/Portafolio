<?php

include_once(base_path().'/vendor/gigya/GSSDK.php'); 

class CentroDeCanjeController extends ContestController {

	public function getShowPremios(){ 
		$sitio = Input::get('sitio');
   		$premios = Premios::where('sitio',$sitio)->get();
		return $premios;
	}


    public function getPdf($sitio){	

		$passwordPDF = $this->generatePasswordPDF();

   		$pdf=new FPDF_Protection();

   		$ganadores = PremiosLog::where('sitio',$sitio)->get();

   		if($ganadores){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,'Lista de Ganadores', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			foreach ($ganadores as $value) {

				$userInfo=$this->gigyaUser($value->uid);

				$premio = Premios::where('id',$value->premio_id)->first();

				$pdf->Cell(70,5,'Red Social :',1,0,'L',0);
				$pdf->Cell(90,5,$userInfo->getString("providers",""),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Nickname :',1,0,'L',0);
				$pdf->Cell(90,5,utf8_decode($userInfo->getString("nickname","")),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Email :',1,0,'L',0);
				$pdf->Cell(90,5,$userInfo->getString("email",""),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Regalo :',1,0,'L',0);
				$pdf->Cell(90,5,utf8_decode($premio->nombre),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'URL de Perfil :',1,0,'L',0);
				$pdf->Cell(90,5,$userInfo->getString("profileURL",""),1,0,'L',0);
		        $pdf->Ln(15);
				$pdf->SetFont('helvetica', '', 10);
			}
			
			$pdf->Output('reporteCentrodeCanje'.time().'.pdf','D');


		}

   	}

   	private function gigyaUser($uid){
   		try {
	   		$apiKey = "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF";
			$secretKey = "QONNYe+U07oGe0HfoPWgoDQrj4PLlJlWq9XdkkcOilM=";
	        $method = "socialize.getUserInfo";
	        $request = new GSRequest($apiKey,$secretKey,$method);
	        $request->setParam("uid", $uid);  
	        $request->setParam("includeAllIdentities", true);
	        $response = $request->send();
	        if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
	            return $response;
	        }
	        else{  // Error   
	            return $response->getErrorMessage();
	        }
	    } catch (Exception $e) {
			return $e->getMessage();
		}

    }

    public function getDatos($sitio){	

   		$ganadores = PremiosLog::where('sitio',$sitio)->get();

   		if($ganadores){

			foreach ($ganadores as $value) {

				$userInfo=$this->gigyaUser($value->uid);

				print_r($userInfo->getString("profileURL",""));

				$premio = Premios::where('id',$value->premio_id)->first();
			}
			
		}

   	}


	
  }

  ?>
