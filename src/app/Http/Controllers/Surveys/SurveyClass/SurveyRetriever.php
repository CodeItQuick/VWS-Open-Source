<?php

namespace App\Http\Controllers\Surveys\SurveyClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Surveys\SurveyClass\PrimaryLevel\SurveyListObject;
use App\Http\Controllers\Surveys\SurveyClass\PrimaryLevel\DataToPopulateSurveysObject;

use App\Models\SurveyList;
use App\Models\DataToPopulateSurvey;

class SurveyRetriever
{
    private $SurveyListId;

    public function __construct(Int $SurveyListId)
    {
        $this->SurveyListId = $SurveyListId;

    }

    public function displaySurvey() {

        $SurveyList = SurveyListObject::withSurveyListId($this->SurveyListId);

        $modelSurveyList = new SurveyList();
        $retrieveSurvey = $SurveyList->display($modelSurveyList);

        $DataToPopulateSurveys = DataToPopulateSurveysObject::withSurveyId($this->SurveyListId);
        $modelDataToPopulateSurveys = new DataToPopulateSurvey();
        $retrievedQuestionData = $DataToPopulateSurveys->display($modelDataToPopulateSurveys);


        return $retrievedQuestionData;
    }

}
