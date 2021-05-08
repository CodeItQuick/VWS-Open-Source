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
use App\Models\Questions;
use App\Models\Answers;
use App\Models\User;

use Illuminate\Http\Request;

class DistributeSurveyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A distributed survey.
     *
     * @return void
     */
    public function testUserCanCreateADistributedSurveyTest()
    {
        $user = new User(array('name' => 'John'));
        $this->actingAs($user)->post('/dashboard/distributeSurvey', $this->data());

        $availableSurveys = AvailableSurveys::all();

        $this->assertCount(1, $availableSurveys);
    }


    /**
     * A distributed survey.
     *
     * Fails becaues ParticipantUser has too many permissions at the moment
     *
     * @return void
     */
    public function testParticipantUserCannotCreateADistributedSurveyTest()
    {
        $user = new ParticipantUser(array('name' => 'John'));
        $this->actingAs($user)->post('/dashboard/distributeSurvey', $this->data());

        $availableSurveys = AvailableSurveys::all();

        $this->assertCount(0, $availableSurveys);
    }

    private function data() {
        return [
            'surveyName' => 'Health Survey',
            'deliveryfrequency' => 'Quarterly',
            'programstartdate' => '01/01/2021',
            'chooseSurvey' => 'Should be removed',
            'participantOne' => 'Tim',
            'participantTwo' => 'John',
            'participantThree' => 'Spencer',
            'participantFour' => 'Ferris',
            'participantFive' => 'Aulden',
            'questionOne' => 'This is the first question?',
            'questionTwo' => 'What is the second question?',
            'questionThree' => 'Who is the third question?',
            'questionFour' => 'Where is the fourth question?',
            'questionFive' => 'When is the fith question?',
            'questionSix' => 'What is the second question?',
            'questionSeven' => 'Who is the third question?',
            'questionEight' => 'Where is the fourth question?',
            'questionNine' => 'When is the fith question?',
            'questionOneLikert' => 'Likert 5',
            'questionTwoLikert' => 'Likert 5',
            'questionThreeLikert' => 'Likert 5',
            'questionFourLikert' => 'Likert 5',
            'questionFiveLikert' => 'Likert 5',
            'questionSixLikert' => 'Likert 5',
            'questionSevenLikert' => 'Likert 5',
            'questionEightLikert' => 'Likert 5',
            'questionNineLikert' => 'Likert 5'
        ];
    }
}
