<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $survey = Survey::where('id', request()->surveyId)->first();

        return view('survey.question.create',compact('survey'));
    }
    public function store(Request $request)
    {
        $survey = Survey::where('id', request()->surveyId)->first();
        $this->validate($request,[
                'question'=>'required',
                'questionType'=>'required',
                'likertScaleAnswer'=>'required_if:questionType,range',
                'textChoice'=>'required_if:questionType,text',
                'choice'=>'required_if:questionType,radio',
        ]);
        $type= $request->questionType;
        $singleAnswer = $request->likertScaleAnswer;
        $question = $survey->questions()->create([
            'question' => $request->question,
            'type' => $request->questionType
        ]);
        if($type === 'radio')
        {
            $answers = [
                ['answerValue' => $request->choice[0]],
                ['answerValue' => $request->choice[1]]
            ];
            if(count($request->choice) >= 3) array_push($answers, ['answerValue' => $request->choice[2]]);
            if(count($request->choice) >= 4) array_push($answers, ['answerValue' => $request->choice[3]]);
            if(count($request->choice) >= 5) array_push($answers, ['answerValue' => $request->choice[4]]);
            $question->answers()->createMany($answers);
        }
        if($type === 'range')
        {
            $answerValue = $request->likertScaleAnswer;
            $question->answers()->create(['answerValue' => $answerValue]);
        }
        if($type === 'text')
        {
            $question->answers()->create(['answerValue' => $request->textChoice]);
        }
        return redirect('surveys/'.$request->surveyId); //redirect back to the survey
    }

    public function delete(Survey $survey, Questions $question)
    {
        $question->answers()->delete();
        $question->delete();
        return redirect('surveys/'.$survey->id)->with('alert', 'Question Deleted!');
    }

    public function show(Survey $survey)
    {
        $survey->load('questions');//lazy loading
        return view('survey.show',compact('survey'));
    }
}
