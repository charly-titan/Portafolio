<?php 
Class TimelineController extends BaseController
{
	public function getIndex(){
		return View::make('timeline.index');
		//echo "TimelineController";
	}
}