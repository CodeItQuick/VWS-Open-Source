<?php

namespace App\Http\Controllers\Surveys\SimpleDTOs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Surveys\SimpleDTOs\PrimaryLevel\SurveyListDTO;
use App\Http\Controllers\Surveys\SimpleDTOs\PrimaryLevel\QuestionsDTO;
use App\Http\Controllers\Surveys\SimpleDTOs\PrimaryLevel\AnswersDTO;

use App\Models\Questions;
use App\Models\Answers;
use App\Models\SurveyList;

interface ICreateAggregate {
    public function createAggregate();
}

interface IDTO {
    public function create();
}

class PopulateSurveysAggregate implements ICreateAggregate
{
    private $request = null;
    private $DataToPopulateSurveysDTO = null;
    private $SurveyListDTO;
    private $QuestionsArray = Array();
    public $questionDescriptions;
    public $answerDescriptions;

    public function __construct(Request $request)
    {
        $this->surveyName = $request->surveyName;
        $this->DeliveryFreq = $request->deliveryFrequency;
        $this->programStartDate = $request->programstartdate;
        $this->chooseSurvey = $request->chooseSurvey;

        $this->questionDescriptions = [$request->questionOne, $request->questionTwo, $request->questionThree,
            $request->questionFour, $request->questionFive, $request->questionSix, $request->questionSeven,
            $request->questionEight, $request->questionNine];

        $this->answerDescriptions = [$request->questionOneLikert, $request->questionTwoLikert, $request->questionThreeLikert,
            $request->questionFourLikert, $request->questionFiveLikert, $request->questionSixLikert, $request->questionSevenLikert,
            $request->questionEightLikert, $request->questionNineLikert];

        $this->participants = [$request->participantOne,
            $request->participantTwo,
            $request->participantThree,
            $request->participantFour,
            $request->participantFive
        ];
    }

    public function createAggregate(
        Object $modelSurveyList = null,
        Object $modelSurveyUserList = null,
        Object $modelQuestions = null,
        Object $modelAnswers = null
        ) {

        if($modelSurveyList === null)
            $modelSurveyList = new SurveyList();
        if($modelQuestions === null)
            $modelQuestions = new Questions();
        if($modelAnswers === null)
            $modelAnswers = new Answers();

        $this->SurveyListDTO = new SurveyListDTO($this->surveyName, $this->programStartDate);
        $this->SurveyListDTO->create($modelSurveyList);

        foreach ($this->participants as $participant) {
            $idx = 0;
            foreach ($this->questionDescriptions as $QuestionDescription) {
                $newQuestionDTO = new QuestionsDTO($QuestionDescription, $this->SurveyListDTO);
                $this->QuestionsArray[$idx] = $newQuestionDTO;

                $this->QuestionsArray[$idx]->create($modelQuestions);
                $newAnswerDTO = new AnswersDTO($participant, $this->QuestionsArray[$idx]);
                $this->AnswersDTO[$idx] = $newAnswerDTO;
                $this->AnswersDTO[$idx] = $this->AnswersDTO[$idx]->create($modelAnswers);
                $idx++;
            }
        }
        return $this->DataToPopulateSurveysDTO;
    }

}
