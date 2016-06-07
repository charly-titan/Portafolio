
var tweeting_rga = {

	loadCarrousel:function(page_carrousel,direction){

		numContenedorTweets = document.getElementsByClassName("numTweets");

		numTweets = numContenedorTweets.length;

		ArrowRight =  document.getElementById('carouselArrowRight_comm').getElementsByTagName('i')[0].className='tvsa-double-caret-right';
		ArrowLeft =   document.getElementById('carouselArrowLeft_comm').getElementsByTagName('i')[0].className='tvsa-double-caret-left';

		if(direction == 'right'){
			
			if(page_carrousel < numTweets ){
				document.getElementById("showArrows_twitter_"+page_carrousel).style.display="none";
				page_carrousel = page_carrousel+1;
				
				ArrowRight;

				if(page_carrousel == numTweets ){
					document.getElementById('carouselArrowRight_comm').getElementsByTagName('i')[0].className='tvsa-double-caret-right inactive';
					ArrowLeft;

				}
			}else{

				page_carrousel = numTweets;
				document.getElementById('carouselArrowRight_comm').getElementsByTagName('i')[0].className='tvsa-double-caret-right inactive';
			}
		
		}else if(direction == 'left'){
			
			if(page_carrousel == 1){
				page_carrousel = 1;
				document.getElementById('carouselArrowLeft_comm').getElementsByTagName('i')[0].className='tvsa-double-caret-left inactive';
			}else{
				page_carrousel = page_carrousel-1;
				ArrowRight;
				document.getElementById("showArrows_twitter_"+page_carrousel).style.display="block";
			}
		}

		document.getElementById('carouselArrowRight_comm').onclick=function(){tweeting_rga.loadCarrousel(page_carrousel,'right'); return false;};
		document.getElementById('carouselArrowLeft_comm').onclick=function(){tweeting_rga.loadCarrousel(page_carrousel,'left'); return false;};
		
	}

}


