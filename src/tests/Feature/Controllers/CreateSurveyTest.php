<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Http\Controllers\Surveys\SurveyDomain\DistributeSurvey;
use App\Http\Controllers\Surveys\SurveyController;

use App\Models\DataToPopulateSurvey;
use App\Models\AvailableSurveys;
use App\Models\SurveyUserList;
use App\Models\SurveyList;
use App\Models\Survey;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\User;

use Illuminate\Http\Request;

class CreateSurveyTest extends TestCase
{
    use RefreshDatabase;
    

    /**
     * A distributed survey.
     *
     * Fails becaues ParticipantUser has too many permissions at the moment
     *
     * @return void
     */
    public function testResearcherUserCanCreateANewSurveyListSurveyTest()
    {
        //Given we are researcher John
        $user = new User(array('name' => 'John'));
        //When we create a survey as john
        $this->actingAs($user)->post('/surveys/createSurvey', $this->data());

        //Then we get a survey populated in the surveylist table
        $availableSurveys = SurveyList::all();
        $this->assertCount(1, $availableSurveys);
        $this->assertEquals($availableSurveys[0]->id, 1);
        $this->assertEquals($availableSurveys[0]->SurveyName, 'Health Survey');
        $this->assertEquals($availableSurveys[0]->DeliveryDate, '01/01/2021');
    }

    /**
     * A distributed survey.
     *
     * Fails becaues ParticipantUser has too many permissions at the moment
     *
     * @return void
     */
    public function testResearcherUserCanCreateANewSurveyListQuestionOnASurveyTest()
    {
        //Given we are researcher John
        $user = new User(array('name' => 'John'));
        //When we create a survey as john
        $this->actingAs($user)->post('/surveys/createSurvey', $this->data());

        //Then we get a survey populated in the surveylist table
        $availableSurveys = SurveyList::all();
        $this->assertCount(1, $availableSurveys);
        $this->assertEquals($availableSurveys[0]->id, 1);
        $this->assertEquals($availableSurveys[0]->SurveyName, 'Health Survey');
        $this->assertEquals($availableSurveys[0]->DeliveryDate, '01/01/2021');

        $this->actingAs($user)->post('/surveys/questions/create?surveyId=1', $this->createQuestionData());
        $surveyCreated = Survey::where('id', 1)->first()->questions()->get();
        dd($surveyCreated);
        $this->assertCount(1, $questions);
        $this->assertEquals($questions->question, 'How much do you like the time?');
        $this->assertEquals($questions->type, 'range');

    }
    private function createQuestionData() {
        return [
            'question'=>'How much do you like the time?',
            'questionType'=>'range', //this is a likert range
            'surveyId' => 1,
            'likertScaleAnswer'=> '5',
            'textChoice' => '',
            'choiceOne' => '',
            'choiceTwo' => '',
            'answerValue' => '5'
        ];
    }
    private function data() {
        return [
            'surveyName' => 'Health Survey',
            'programdate' => '01/01/2021',
            'quarterly' => 'quarterly'
        ];
    }
}
